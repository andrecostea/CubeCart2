<?php
if(!defined('CC_DS')) die('Access Denied');
class Installer {
	private $_cache_package;
	
	private $_install_root;
	
	/*
	private $installPath;
	private $moduleName;
	private $sqlQueryLog;
	private $sqlQueryCount	= 0;
	private $sqlSucessCount	= 0;
	private $sqlFailCount	= 0;
	private $sqlSecureTables= array();
	*/
	
	#############################################################
	
	public function __construct($language = 'en_EN', $installPath = false) {
		$this->_db	=& $GLOBALS['db'];
		$this->_cache_package	= CC_ROOT_DIR.CC_DS.'cache'.CC_DS.'installer-cache.zip';
		$this->_install_root	= CC_ROOT_DIR.CC_DS.'modules';
		if (isset($_POST['cancel']) && file_exists($this->_cache_package)) unlink($this->_cache_package);
	}
	
	#############################################################
	
	public function prepare($language, $upload_name = 'upload') {
		if (is_uploaded_file($_FILES[$upload_name]['tmp_name']) && preg_match('#\.(zip)$#iu', $_FILES[$upload_name]['name'])) {
			move_uploaded_file($_FILES[$upload_name]['tmp_name'], $this->_cache_package);
			$archive	= new Archive($this->_cache_package);
			$data		= $archive->read('config.xml');
			if (!empty($data)) {
				## Parse XML data
				$xml	= new simpleXMLElement($data);
				foreach ((array)$xml->info as $key => $value) {
					$array[$key]	= (string)$value;
				}
				## Check compatible version
				$compat	= moduleVersion($xml->info->minVersion, $xml->info->maxVersion);
				if ($compat) {
					## Is it already installed?
					$target	= $this->_install_root.CC_DS.$xml->info->type.CC_DS.Module::module_name($xml->info->name);
					if (file_exists($target.CC_DS.'config.xml')) {
						## Yup, already exists
						$exists	= new simpleXMLElement(file_get_contents($target.CC_DS.'config.xml', true); 
						switch (version_compare($xml->info->version, $exists->info->version)) {
							case -1:
								## Downgrade
								$status		= 'downgrade';
								break;
							case 0:
								## Reinstall
								$status		= 'reinstall';
								break;
							case 1:
								## Upgrade
								$status		= 'upgrade';
								break;
						}
						$array['installed']	= (string)$exists->info->version;
						unset($exists);
					} else {
						$status		= 'install';
					}
					$array['status']	= $status;
				}
				$array['compatible']	= (bool)$compat;
				return $array;
			}
		}
		return false;
	}
	
	public function install() {
		## Install the files
		$archive	= new Archive($this->_cache_package);
		## Load the module data
		$data	= $archive->read('config.xml');
		$xml	= new simpleXMLElement($data);
		$module	= (array)$xml->info;
		## Build the extraction target
		$target	= CC_ROOT_DIR.CC_DS.'modules'.CC_DS.$module['type'];
		## Extract, and return the status
		if ($archive->extract($target)) {
			## Do we need to run any SQL?
			
			## Are there any hooks to install?
			if ((string)$xml->type == 'plugin' && isset($xml->hooks)) {
				## Get the folder name
				foreach ($xml->hooks->hook as $hook) {
					$attr	= (array)$hook->attributes();
					$record	= array(
						'plugin'	=> (string)$xml->info->folder,
						'hook_name'	=> (string)$hook,
						'trigger'	=> (string)$attr->trigger,
						'filepath'	=> (string)$attr->file,
					);
					if ($GLOBALS['db']->select('CubeCart_hooks', array('hook_id'), $record)) {
						$GLOBALS['db']->insert('CubeCart_hooks', $record);
					}
				}
			}
			## Remove the install package from the cache
			unlink($this->_cache_package);
			return true;
		}
		return false;
	}
	
	#############################################################
	
	## Process SQL Files
	private function loadSQLfile($sqlFile = '', $dbprefix = '') {
		if (!empty($sqlFile) && file_exists($this->installPath.CC_DS.$sqlFile)) {
			$sql = file_get_contents($this->installPath.CC_DS.$sqlFile, true);
			if (!empty($dbprefix)) $sql = str_replace('`CubeCart_', '`'.$dbprefix.'CubeCart_', $sql);
			return $sql;
		}
		return false;
	}
	
	## Install SQL Files
	private function installSQL($sqlFile) {
		
		if (($sql = $this->loadSqlFile($sqlFile)) === false) return false;		
		
		$queryArray = explode('; #EOQ', $sql);
		foreach ($queryArray as $query) {
			$query = trim($query);
			if (!empty($query)) { ## && !preg_match('/^#/iU', $query)) {
				## Just a bit of safety - Don't want some smart-ass making a CubeCart 'Virus'
				if (preg_match('#^(DROP|TRUNCATE)#iu', trim($query))) break;
				
				if (preg_match('#^(ALTER)#iuxmU', trim($query))) {
					$queryLines = explode("\n", trim($query));
					for ($i=0; $i<count($queryLines); $i++) {
						if ($i==0) {
							if (count($queryLines) == 1) {
								if ($GLOBALS['db']->misc($queryLines[0], false)) {
									$this->sqlSuccessCount++;
									$this->sqlQueryLog['Success'][] = $queryLines[0];
								} else {
									$this->sqlQueryLog['Failed'][] = $queryLines[0];
								}
							} else {
								$prefix = $queryLines[0];
							}
						} else {
							$this->sqlQueryCount++;
							$queryTemp = sprintf('%s %s', $prefix, preg_replace('#,$#iu', ';', $queryLines[$i]));
							if ($GLOBALS['db']->misc($query, false)) {
								$this->sqlSuccessCount++;
								$this->sqlQueryLog['Success'][]	= $query;
							} else {
								$this->sqlQueryLog['Failed'][]	= $query;
							}
							unset($queryTemp);
						}
					}
				} else {
					## if its an INSERT or UPDATE, then check what table it's trying to access
					
					// if (preg_match('#^(INSERT)#iu', trim($query))
					
					$this->sqlQueryCount++;
					$query = str_replace(array("\n", "\r"), '', trim($query)).';';
					
					if ($GLOBALS['db']->misc($query, false)) {
						$this->sqlSuccessCount++;
						$this->sqlQueryLog['Success'][]	= $query;
					} else {
						$this->sqlQueryLog['Failed'][]	= $query;
					}
				}
			}
		}
		$this->sqlFailCount	= $this->sqlQueryCount-$this->sqlSuccessCount;
	}
	
}

?>