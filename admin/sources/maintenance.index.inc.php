<?php

if (!defined('CC_INI_SET')) die('Access Denied');
Admin::getInstance()->permissions('maintenance', CC_PERM_EDIT, true);

global $lang;
$cache = Cache::getInstance();
$pclzip_path = CC_INCLUDES_DIR.'lib'.CC_DS.'pclzip'.CC_DS.'pclzip.lib.php';

if(isset($_GET['restore']) && !empty($_GET['restore'])) {
	$file_path = CC_ROOT_DIR.CC_DS.'backup'.CC_DS.$_GET['restore'];
	require_once($pclzip_path);
	
	if(preg_match('/^database_full/',$_GET['restore'])) { // Restore database
		if(preg_match('/\.sql.zip$/',$_GET['restore'])) { // unzip first 
			$archive 			= new PclZip($file_path);
			$extract_location 	= str_replace('.zip','',$file_path);
	  		$extract 	= $archive->extract(PCLZIP_OPT_REPLACE_NEWER);
	  		if ($extract == 0) {
	    		$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	    		httpredir('?_g=maintenance&node=index#backup');
	  		}
		}
		
		if(isset($extract[0]['filename']) && file_exists($extract[0]['filename'])) {
			$contents = file_get_contents(CC_ROOT_DIR.CC_DS.$extract[0]['filename']);
			unlink($extract[0]['filename']);
		} else {
			$contents = file_get_contents($file_path);
		}
	
		if(!empty($contents) && $GLOBALS['db']->parseSchema($contents)) {
			$GLOBALS['main']->setACPNotify($lang['maintain']['db_restored']);
	    	$GLOBALS['cache']->clear();
	    	httpredir('?_g=maintenance&node=index#backup');
		}
		
	} elseif(preg_match('/^files/',$_GET['restore'])) { // restore archive
		$archive = new PclZip(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.$_GET['restore']);
	  	
	  	## Get file contents to compare filesize afterwards shame we have no md5 but filesize should be ok
	  	if (($backup_contents = $archive->listContent()) == 0) {
    		$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	    	httpredir('?_g=maintenance&node=index#backup');
  		}
  		## Do extraction
	  	$extract 	= $archive->extract(PCLZIP_OPT_PATH,CC_ROOT_DIR,PCLZIP_OPT_REPLACE_NEWER);
	  	if ($extract == 0) {
	    	$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	    	httpredir('?_g=maintenance&node=index#backup');
	  	}
	  	
	  	$error_log = '----- Restore Log from '.$_GET['restore']." (".date("d M Y - H:i:s").") -----\r\n\r\n";
  		## Check the files have been updated
  		$fail_status = array('newer_exist','write_protected','path_creation_fail','write_error','read_error','invalid_header','filename_too_long');
  		if(is_array($extract)) {
  			foreach($extract as $file) {
  				if(in_array($file['status'],$fail_status)) {
  					$fail = true;
  					$error_log .= $file['stored_filename']." - Extract Status: ".$file['status']."\r\n";
  				}
  			}
  		}
  		
  		## Check files MD5 all match as an extra layer
  		$files_after_extract = glob_recursive('*');
		foreach($files_after_extract as $file) {
			if(is_file($file)) {
				## Open the source file
		        if (($v_file = fopen($file, "rb")) == 0) {
		          $fail = true;
		          $error_log .= "$file - Unable to open file to calculate CRC.\r\n";
		        }
		
		        ## Read the file content
		        $v_content = fread($v_file, filesize($file));
		
		        ## Close the file
		        fclose($v_file);
		        
		        ## Replace ./ from the start of the filename to match against stores_filename from PCLZIP
				$crc_after_extract[preg_replace('/^.\//', '', $file)] = crc32($v_content);
			}
		}
		## If filesize of file after extraction doesn't match package contents then it hasn't worked 
		foreach($backup_contents as $file) {
			if(file_exists($file['stored_filename']) && isset($crc_after_extract[$file['stored_filename']]) && $file['crc'] !== $crc_after_extract[$file['stored_filename']]) {
				$fail = true;
				$error_log .= $file['stored_filename']." of ".$crc_after_extract[$file['stored_filename']]." checksum doesn't match new version of ".$file['crc'].".\r\n";
			} elseif(!file_exists($file['stored_filename'])) {
				$error_log .= $file['stored_filename']." doesn't exist.\r\n";
			}
		}
		$error_log .= "\r\n------------------------------ \r\n\r\n\r\n\r\n\r\n";
		
		if($fail) {
 			if(!empty($error_log)) {
 				$fp = fopen(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'restore_error_log', 'a+');
				fwrite($fp, $error_log);
				fclose($fp);	
 			}
 			$GLOBALS['main']->setACPWarning($lang['maintain']['files_restore_fail']);
  			httpredir('?_g=maintenance&node=index#backup');
 		} else {
 			$GLOBALS['main']->setACPNotify($lang['maintain']['files_restore_success']);
  			$GLOBALS['cache']->clear();
  			httpredir('?_g=maintenance&node=index#backup');
  		}
	  	
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['files_restore_not_possible']);
  		httpredir('?_g=maintenance&node=index#backup');
	}
}

if(isset($_GET['upgrade']) && !empty($_GET['upgrade'])) {
	
    $contents = false;
	## Download the version we want	
	$request = new Request('www.cubecart.com', '/download/'.$_GET['upgrade'].'/zip', 80, false, true, 10);
	$request->setData(array('null'=>0)); // setData needs a value to work
	$request->setUserAgent('CubeCart');
	$request->skiplog(true);
	
	if(!$contents = $request->send()){
		$contents = file_get_contents('http://www.cubecart.com/download/'.$_GET['upgrade'].'/zip');
	}
	
	if(empty($contents)) {

  		$GLOBALS['main']->setACPWarning($lang['maintain']['files_upgrade_download_fail']);
  		httpredir('?_g=maintenance&node=index#upgrade');

  	} else {

		if(stristr($contents, 'DOCTYPE') ) {
			$GLOBALS['main']->setACPWarning("Sorry. CubeCart-".$_GET['upgrade'].".zip was not found. Please try again later.");
	    	httpredir('?_g=maintenance&node=index#upgrade');
		}
		
		$destination_path = CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'CubeCart-'.$_GET['upgrade'].'.zip';
		$fp = fopen($destination_path, 'w');
		fwrite($fp, $contents);
		fclose($fp);
		
		if(file_exists($destination_path)) {
			
			## Make the new file read/writable which is probably not needed
			chmod($destination_path,0775);
			
			require_once($pclzip_path);
	  		
	  		$archive = new PclZip($destination_path);
	  		
	  		## Get file contents to compare filesize afterwards shame we have no md5 but filesize should be ok
	  		if (($package_contents = $archive->listContent()) == 0) {
    			$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	    		httpredir('?_g=maintenance&node=index#upgrade');
  			}
  			
  			
	  		$extract = $archive->extract(PCLZIP_OPT_PATH,
	  										CC_ROOT_DIR,
	  										PCLZIP_OPT_REPLACE_NEWER);
	  		
	  		if ($extract == 0) {
	    		$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	    		httpredir('?_g=maintenance&node=index#upgrade');
	  		}
	  		$error_log = '----- Upgrade log to '.$_GET['upgrade']." (".date("d M Y - H:i:s").") -----\r\n\r\n";
	  		## Check the file have been updated
	  		$fail_status = array('newer_exist','write_protected','path_creation_fail','write_error','read_error','invalid_header','filename_too_long');
	  		if(is_array($extract)) {
	  			foreach($extract as $file) {
	  				if(in_array($file['status'],$fail_status)) {
	  					$fail = true;
	  					$error_log .= $file['stored_filename']." - Extract Status: ".$file['status']."\r\n";
	  				}
	  			}
	  		}
	  		
	  		## Check files MD5 all match as an extra layer
	  		$files_after_extract = glob_recursive('*');
			foreach($files_after_extract as $file) {
				if(is_file($file)) {
					## Open the source file
			        if (($v_file = fopen($file, "rb")) == 0) {
			          $fail = true;
			          $error_log .= "$file - Unable to open file to calculate CRC.\r\n";
			        }
			
			        ## Read the file content
			        $v_content = fread($v_file, filesize($file));
			
			        ## Close the file
			        fclose($v_file);
			        
			        ## Replace ./ from the start of the filename to match against stores_filename from PCLZIP
					$crc_after_extract[preg_replace('/^.\//', '', $file)] = crc32($v_content);
				}
			}
			## If filesize of file after extraction doesn't match package contents then it hasn't worked 
			foreach($package_contents as $file) {
				if(file_exists($file['stored_filename']) && isset($crc_after_extract[$file['stored_filename']]) && $file['crc'] !== $crc_after_extract[$file['stored_filename']]) {
					
					$error_log .= $file['stored_filename']." of ".$crc_after_extract[$file['stored_filename']]." checksum doesn't match new version of ".$file['crc'].".\r\n";
				} elseif(!file_exists($file['stored_filename'])) {
					$error_log .= $file['stored_filename']." .\r\n";
				}
			}
			$error_log .= "\r\n------------------------------ \r\n\r\n\r\n\r\n\r\n";
			
			## Remove the source folder
			@unlink($destination_path);
			
	 		if($fail) {
	 			if(!empty($error_log)) {
	 				$fp = fopen(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'upgrade_error_log', 'a+');
					fwrite($fp, $error_log);
					fclose($fp);	
	 			}
	 			$GLOBALS['main']->setACPWarning($lang['maintain']['files_upgrade_fail']);
	  			httpredir('?_g=maintenance&node=index#upgrade');
	 		} elseif($_POST['force']) {
	 			## Try to delete setup folder
	 			recursiveDelete(CC_ROOT_DIR.CC_DS.'setup');
	 			unlink(CC_ROOT_DIR.CC_DS.'setup');
	 			## If that failes we try an obscure rename
	 			if(file_exists(CC_ROOT_DIR.CC_DS.'setup')) {
	 				rename(CC_ROOT_DIR.CC_DS.'setup',CC_ROOT_DIR.CC_DS.'setup_'.md5(time().$_GET['upgrade']));
	 			}
	 			$GLOBALS['main']->setACPNotify($lang['maintain']['current_version_restored']);
	 			$GLOBALS['cache']->clear();
	 			httpredir('?_g=maintenance&node=index#upgrade');
	  		} else {
	  			httpredir(CC_ROOT_REL.'setup/index.php?autoupdate=1');
	  		}
	  	}

  	} // end if $contents
}

if(isset($_GET['delete']) && file_exists('backup'.CC_DS.$_GET['delete'])) {
	## Generic error message for logs delete specific for backup
	$message = preg_match('/\_error_log$/',$_GET['delete']) ? $lang['filemanager']['notify_file_delete'] : $lang['maintain']['backup_deleted'];
	$GLOBALS['main']->setACPWarning();
	unlink('backup'.CC_DS.$_GET['delete']);
	httpredir('?_g=maintenance&node=index#backup');
}
if(isset($_GET['download']) && file_exists('backup'.CC_DS.$_GET['download'])) {
	deliverFile('backup'.CC_DS.$_GET['download']);
	httpredir('?_g=maintenance&node=index#backup');
}

########## Rebuild ##########
$clear_post = false;

if (isset($_POST['sitemap'])) {
	if($GLOBALS['seo']->sitemap()) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_sitemap']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['notify_sitemap_fail']);
	}
	$clear_post = true;
}

if (isset($_POST['emptyTransLogs']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear();
	if ($GLOBALS['db']->truncate('CubeCart_transactions')) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_logs_transaction']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_logs_transaction']);
	}
	$clear_post = true;
}

if (isset($_REQUEST['emptyErrorLogs']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear();
	if ($GLOBALS['db']->truncate(array('CubeCart_system_error_log', 'CubeCart_admin_error_log'))) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_logs_error']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_logs_error']);
	}
	$clear_post = true;
}

if (isset($_REQUEST['emptyRequestLogs']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear();
	if ($GLOBALS['db']->truncate('CubeCart_request_log')) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_logs_request']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_logs_request']);
	}
	$clear_post = true;
}

if (isset($_POST['clearCache']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear();
	$GLOBALS['cache']->tidy();
	$GLOBALS['main']->setACPNotify($lang['maintain']['notify_cache_cleared']);
	$clear_post = true;
}

if (isset($_POST['clearSQLCache']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear('sql');
	$GLOBALS['main']->setACPNotify($lang['maintain']['notify_cache_cleared']);
	$clear_post = true;
}

if (isset($_POST['clearLangCache']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	$GLOBALS['cache']->clear('lang');
	$GLOBALS['main']->setACPNotify($lang['maintain']['notify_cache_cleared']);
	$clear_post = true;
}

if (isset($_POST['clearImageCache']) && Admin::getInstance()->permissions('maintenance', CC_PERM_DELETE)) {
	function cleanImageCache($path = null) {
		$path	= (isset($path) && is_dir($path)) ? $path : CC_ROOT_DIR.CC_DS.'images'.CC_DS.'cache'.CC_DS;
		$scan	= glob($path.'*', GLOB_MARK);
		if (is_array($scan) && !empty($scan)) {
			foreach ($scan as $result) {
				if (is_dir($result)) {
					cleanImageCache($result);
					rmdir($result);
				} else {
					unlink($result);
				}
			}
		}
	}
	## recursively delete the contents of the images/cache folder
	cleanImagecache();
	$GLOBALS['main']->setACPNotify($lang['maintain']['notify_cache_image']);
	$clear_post = true;
}
if (isset($_POST['prodViews'])) {
	$GLOBALS['cache']->clear();
	if ($GLOBALS['db']->update('CubeCart_inventory', array('popularity' => 0), '', true)) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_reset_product']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_reset_product']);
	}
	$clear_post = true;
}

if (isset($_POST['clearLogs'])) {
	$GLOBALS['cache']->clear();
	if ($GLOBALS['db']->truncate(array('CubeCart_admin_log', 'CubeCart_access_log'))) {
		$GLOBALS['main']->setACPNotify($lang['maintain']['notify_logs_admin']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_logs_admin']);
	}
	$clear_post = true;
}

########## Database ##########

if (!empty($_POST['database'])) {
	if (is_array($_POST['tablename'])) {
		foreach ($_POST['tablename'] as $value) {
			$tableList[] = sprintf('`%s`', $value);
		}
		$database_result = $GLOBALS['db']->query(sprintf("%s TABLE %s;", $_POST['action'], implode(',', $tableList)));
		$GLOBALS['main']->setACPNotify(sprintf($lang['maintain']['notify_db_action'], $_POST['action']));
	} else {
		$GLOBALS['main']->setACPWarning($lang['maintain']['db_none_selected']);
	}
}

########## Backup ##########
if(isset($_GET['files_backup'])) {
	set_time_limit(600);
	$GLOBALS['cache']->clear(); // Clear cache to remove unimpoartant data to save space and possible errors
	include_once($pclzip_path);
	$destination_filepath = 'backup'.CC_DS.'files_'.CC_VERSION.'_'.date("dMy-His").'.zip';
	$archive = new PclZip($destination_filepath);

	$files = glob('*');
	foreach($files as $file) {
		if($file !== "backup") {
			$backup_list[] = $file;
		}
	}
	$v_list = $archive->create($backup_list);
	if($v_list == 0) {
		@unlink($destination_filepath);
		$GLOBALS['main']->setACPWarning("Error: ".$archive->errorInfo(true));
	} else {
		$GLOBALS['main']->setACPNotify($lang['maintain']['files_backup_complete']);
	}
	httpredir('?_g=maintenance&node=index#backup');
}

if (isset($_POST['backup'])) {
	set_time_limit(600);
	
	if (!$_POST['drop'] && !$_POST['structure'] && !$_POST['data']) {
		$GLOBALS['main']->setACPWarning($lang['maintain']['error_db_backup_option']);
	} else {
		if ($_POST['drop'] && !$_POST['structure']) {
			$GLOBALS['main']->setACPWarning($lang['maintain']['error_db_backup_conflict']);
		} else {
			$full = ($_POST['drop'] && $_POST['structure'] && $_POST['data']) ? '_full' : ''; 
			$fileName 	= 'backup'.CC_DS.'database'.$full.'_'.CC_VERSION.'_'.$glob['dbdatabase']."_".date("dMy-His").'.sql';
			$sqlDumpOut = $GLOBALS['db']->doSQLBackup($_POST['drop'],$_POST['structure'],$_POST['data']);
			$fp = fopen($fileName, 'w');
			$write = fwrite($fp, $sqlDumpOut);
			fclose($fp);
			if($write) {
				if($_POST['compress']) {
					include_once($pclzip_path);
					$archive = new PclZip($fileName.'.zip');
					$v_list = $archive->create($fileName);
					if($v_list == 0) {
						$GLOBALS['main']->setACPWarning($archive->errorInfo(true));
					} else {
						$GLOBALS['main']->setACPNotify($lang['maintain']['db_backup_complete']);
					}
					unlink($fileName);
				} else {
					$GLOBALS['main']->setACPNotify($lang['maintain']['db_backup_complete']);
				}
			} else {
				$GLOBALS['main']->setACPWarning($lang['maintain']['db_backup_failed']);
			}
		}
		$clear_post = true;
	}
}

if ($clear_post) httpredir(currentPage(array('clearLogs','emptyErrorLogs')));

########## Tabs ##########
$GLOBALS['main']->addTabControl($lang['maintain']['tab_backup'], 'backup');
$GLOBALS['main']->addTabControl($lang['common']['upgrade'], 'upgrade');
$GLOBALS['main']->addTabControl($lang['maintain']['tab_db'], 'database');
$GLOBALS['main']->addTabControl($lang['maintain']['tab_rebuild'], 'rebuild');

$GLOBALS['main']->addTabControl($lang['maintain']['tab_query_sql'],'general', '?_g=maintenance&node=sql');

##########

## Database
if($database_result) {
	$GLOBALS['smarty']->assign('TABLES_AFTER', $database_result);
} elseif (($tables = $GLOBALS['db']->getRows()) !== false) {
	foreach ($tables as $table) {
		$table['Data_free'] = ($table['Data_free'] > 0) ? formatBytes($table['Data_free'], true) : '-';
		$table_size			= $table['Data_length']+$table['Index_length'];
		$data_length		= formatBytes($table_size);
		$table['Data_length'] = ($table_size>0) ? $data_length['size'].$data_length['suffix'] : '-';
		$table['Name_Display'] = $GLOBALS['config']->get('config','dbdatabase').'.'.$table['Name'];
		$smarty_data['tables'][] = $table;
	}
	$GLOBALS['smarty']->assign('TABLES', $smarty_data['tables']);
}

## Existing Backups
$files = glob('{backup/*.sql,backup/*.zip}',GLOB_BRACE);

if(count($files)>0) {
	foreach($files as $file) {
		$sorted_files[filemtime($file)] = $file;
	}
	unset($files);
	
	krsort($sorted_files); // Sort to time order

	foreach($sorted_files as $file) {
		$filename = basename($file);
		$type = (preg_match('/^database/',$filename)) ? 'database' : 'files';
		$restore = (preg_match('/^database_full|files/',$filename)) ? '?_g=maintenance&amp;node=index&amp;restore='.$filename.'#backup' : false;
		$existing_backups[] = array('filename' => $filename, 
									'delete_link' => '?_g=maintenance&amp;node=index&amp;delete='.$filename.'#backup',
									'download_link' => '?_g=maintenance&amp;node=index&amp;download='.$filename.'#backup',
									'restore_link' => $restore,
									'type' => $type,
									'warning' => ($type=='database') ? $lang['maintain']['restore_db_confirm'] : $lang['maintain']['restore_files_confirm'],
									'size' => format_size(filesize($file)));
	}
}
$GLOBALS['smarty']->assign('EXISTING_BACKUPS', $existing_backups);

## Upgrade
## Check current version
if ($request = new Request('cp.cubecart.com', '/licence/version/'.CC_VERSION)) {
	$request->cache(true);
	$request->setData(array('version' => CC_VERSION));
	if (($response = $request->send()) !== false) {
		if (version_compare(trim($response), CC_VERSION, '>')) {
			$GLOBALS['smarty']->assign('OUT_OF_DATE',sprintf($lang['dashboard']['error_version_update'], $response, CC_VERSION));
			$GLOBALS['smarty']->assign('LATEST_VERSION',$response);
			$GLOBALS['smarty']->assign('UPGRADE_NOW',$lang['maintain']['upgrade_now']);
			$GLOBALS['smarty']->assign('FORCE','0');
		} else {
			$GLOBALS['smarty']->assign('LATEST_VERSION',CC_VERSION);
			$GLOBALS['smarty']->assign('UPGRADE_NOW',$lang['maintain']['force_upgrade']);
			$GLOBALS['smarty']->assign('FORCE','1');
		}
	} 
} 

if(file_exists(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'restore_error_log')) {
	$contents = file_get_contents(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'restore_error_log');
	if(!empty($contents)) {
		$GLOBALS['smarty']->assign('RESTORE_ERROR_LOG',$contents);
	}
}

if(file_exists(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'upgrade_error_log')) {
	$contents = file_get_contents(CC_ROOT_DIR.CC_DS.'backup'.CC_DS.'upgrade_error_log');
	if(!empty($contents)) {
		$GLOBALS['smarty']->assign('UPGRADE_ERROR_LOG',$contents);
	}
}

$page_content = $GLOBALS['smarty']->fetch('templates/maintenance.index.php');