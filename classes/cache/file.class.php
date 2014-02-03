<?php
/**
 * Header
 */
if(!defined('CC_DS')) die('Access Denied');
require CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.'cache.class.php';

/**
 * Cache specific class
 *

 * @author Technocrat
 * @author Sir William
 * @version 1.1.0
 * @since 5.0.0
 */
class Cache extends Cache_Controler {
	/**
	 * Path to cache files
	 *
	 * @var string
	 */
	protected $_cache_path	= '';

    final protected function __construct() {
    	if (!$this->setPath()) {
    		$this->_online = false;
    		return ;
    	}

    	$this->_mode	= 'File';
    	$this->_online	= true;

    	//Run the parent constructor
    	parent::__construct();
    }

	/**
	 * Setup the instance (singleton)
	 *
	 * @return instance
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}

	/**
	 * Clear all the cache
	 *
	 * @param string $type Cache type prefix
	 *
	 * @return bool
	 */
	public function clear($type = '') {
		if (!empty($type)) {
			$prefix	= '*'.strtolower($type).'*';
		} else {
			$prefix = '*';
		}

		//Loop through each cache file
		$files = glob($this->_cache_path.$this->_prefix.$prefix.$this->_suffix, GLOB_NOSORT);
		if(is_array($files)) {
			foreach ($files as $file) {
				//Delete the file
				unlink($file);
			}
		}

		clearstatcache();

		return true;
	}

	/**
	 * Remove a single item of cache
	 *
	 * @param string $id Cache identifier
	 * @return bool
	 */
	public function delete($id) {
		if (!$this->status()) {
			return true;
		}

		clearstatcache(); // Clear cached results

		if (file_exists($this->_cache_path.$this->_makeName($id))) {
			return unlink($this->_cache_path.$this->_makeName($id));
		}

		return true;
	}

	/**
	 * Check to see if the cache file exists
	 *
	 * @param string $id Cache identifier
	 *
	 * @return bool
	 */
	public function exists($id) {
		if (!$this->status()) {
			return false;
		}

		clearstatcache(); // Clear cached results

		return file_exists($this->_cache_path.$this->_makeName($id));
	}

	/**
	 * Get all the cache ids
	 *
	 * @return array
	 */
	public function getIDs() {
		if (empty($this->_ids)) {
			foreach (glob($this->_cache_path.'*'.$this->_suffix, GLOB_NOSORT) as $file) {
	        	if (strpos($file, $this->_prefix) !== false) {
	            	$this->_ids[] = str_replace(array($this->_prefix, $this->_suffix, CC_CACHE_DIR), '', $file);
	        	}
	        }
		}

        return $this->_ids;
	}

	/**
	 * Get the cache data
	 *
	 * @param string $id Cache identifier
	 * @return data/false
	 */
	public function read($id) {
		if (!$this->status()) {
			return false;
		}

		$name = $this->_makeName($id);
		$file = $this->_cache_path.$name;

		clearstatcache(); // Clear cached results

		//Make sure the cache file exists
		if (file_exists($file)) {
			$contents	= @file_get_contents($file, false);

			//If there is no newline then the file isn't valid
			if (strpos($contents, "\n") === false) {
				@unlink($file);
				return false;
			}

			//Split meta and data
			list($meta, $data) = explode("\n", $contents);
			$meta = unserialize($meta);

			//Check to see if the cache is past the experation date
			if (($meta['time'] + $meta['expire']) <= time()) {
				unlink($file);
				return false;
			}

			return unserialize(base64_decode($data));
		}

		return false;
	}

	/**
	 * Set cache path to some where else
	 *
	 * @param string $path
	 */
	public function setPath($path = '') {
		if (empty($path)) {
			$path = CC_ROOT_DIR.CC_DS.'cache'.CC_DS;
		} else {
			$ds = substr($path, -1);
			if ($ds != '/' && $ds != '\\') {
				$path .= CC_DS;
			}
		}

		clearstatcache(); // Clear cached results

		if (is_dir($path) && file_exists($path) && is_writable($path)) {
			$this->_cache_path = $path;
		} else {
			trigger_error('Could not change cache path ('.$path.')', E_USER_WARNING);
			return false;
		}

		return true;
	}

	/**
	 * Calculates the cache usage
	 *
	 * @return string
	 */
	public function usage() {
		if ($this->status()) {
			$cache_size = 0;
			foreach (glob($this->_cache_path.'*', GLOB_NOSORT) as $file) {
				$cache_size += filesize($file);
			}
			return 'Used: '.formatBytes($cache_size, true);
		} else {
			return 'Cache is disabled';
		}
	}

	/**
	 * Write cache data
	 *
	 * @param mixed $data Data to write to the file
	 * @param string $id Cache identifier
	 * @param int $expire Force a time to live
	 * return bool
	 */
	public function write($data, $id, $expire = '') {
		if (!$this->status()) {
			return true;
		}

		$data = serialize($data);

		//Base64 to obfuscate it
		$data = base64_encode($data);

		$name = $this->_makeName($id);

		//Create the meta data for the file
		$meta = array(
			'time'		=> time(),
			'expire'	=> (!empty($expire) && is_numeric($expire)) ? $expire : $this->_expire,
		);
		//Combine the meta and the data
		$data 	= serialize($meta)."\n".$data;

		//Write to file
		if (file_put_contents($this->_cache_path.$name, $data)) {
			return true;
		}
		trigger_error('Cache data not written.', E_USER_WARNING);

		return false;
	}
}