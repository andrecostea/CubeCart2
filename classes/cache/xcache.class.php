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
 * @version 1.1.0
 * @since 5.0.0
 */
class Cache extends Cache_Controler {
	final protected function __construct() {
		if (!extension_loaded('XCache') || ini_get('xcache.size') <= 0 || ini_get('xcache.admin.enable_auth')) {
			$this->_online = false;
			return ;
		}

    	$this->_mode	= 'XCache';
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
	 * Clear the cache
	 *
	 * @param string $type Cache type prefix
	 * @return bool
	 */
	public function clear($type = '') {
		//Get the current cache IDs
		$this->getIDs();

		if (!empty($type)) {
			$type = strtolower($type);
			$len = strlen($type);
		}

		$return = true;
		if (!empty($this->_ids)) {
			//Loop through each id to delete it
			foreach ($this->_ids as $id) {
				//If there is a type we need to only delete that
				if (!empty($type)) {
					if (substr($id, 0, $len) == $type) {
						if (!$this->delete($id)) {
							$return = false;
						}
					}
				} else {
					//If no type delete every id
					if (!$this->delete($id)) {
						$return = false;
					}
				}
			}
		}
		return $return;
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

		return xcache_unset($this->_makeName($id));
	}

	/**
	 * Check to see if the cache file exists
	 *
	 * @param string $id Cache identifier
	 * @return bool
	 */
	public function exists($id) {
		if (!$this->status()) {
			return false;
		}

		return xcache_isset($this->_makeName($id));
	}

	/**
	 * Get all the cache ids
	 *
	 * @return array
	 */
	public function getIDs() {
		if (empty($this->_ids)) {
	        for ($i = 0, $count = xcache_count(XC_TYPE_VAR); $i < $count; ++$i) {
	            $entries = xcache_list(XC_TYPE_VAR, $i);

	            if (is_array($entries['cache_list'])) {
	                foreach ($entries['cache_list'] as $entry) {
	                	$this->_ids[] = str_replace(array($this->_prefix, $this->_suffix), '', $entry['name']);
	                }
	            }
	        }
		}

        return $this->_ids;
	}

	/**
	 * Get the cached data
	 *
	 * @param string $id Cache identifier
	 * @return data/false
	 */
	public function read($id) {
		if (!$this->status()) {
			return false;
		}

		//Setup the name of the cache
		$name = $this->_makeName($id);

		//Make sure the cache file exists
		if (xcache_isset($name)) {
			$contents = xcache_get($name);

			if (!empty($contents)) {
				//Remove base64 & serialization
				return unserialize(base64_decode($contents));
			}
		}

		return false;
	}

	/**
	 * Calculates the cache usage
	 *
	 * @return string
	 */
	public function usage() {
		if ($this->status()) {
			return 'XCache Statistics are unavailable.';
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
	 * @return bool
	 */
	public function write($data, $id, $expire = '') {
		if (!$this->status()) {
			return true;
		}

		$data = serialize($data);

		//Base64 to obfuscate it
		$data = base64_encode($data);

		$name = $this->_makeName($id);

		//Write to file
		if (xcache_set($name, $data, (!empty($expire) && is_numeric($expire)) ? $expire : $this->_expire)) {
			return true;
		}
		trigger_error('Cache data not written (XCache).', E_USER_WARNING);

		return false;
	}
}