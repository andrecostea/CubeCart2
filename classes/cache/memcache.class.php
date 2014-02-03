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
	/**
	 * Cache instance
	 *
	 * @var object
	 */
	protected $_memcache = null;

	final protected function __construct() {
		if (!extension_loaded('memcache')) {
			$this->_online = false;
			return ;
		}

    	$this->_mode		= 'Memcache';
    	$this->_memcache	= new Memcache;

    	//Check the config file for memcache servers and try to load them
		if (isset($GLOBALS['config']['cache_memcache_list']) && !empty($GLOBALS['config']['cache_memcache_list'])) {
			$online = false;
			$pool = explode(',', $GLOBALS['config']['cache_memcache_list']);

			foreach ($pool as $server) {
				$server	= explode(':', $server);
				// Add to the server pool
				if (!$this->_memcache->addServer(trim($server[0]), (isset($server[1])) ? (int)trim($server[1]) : 11211)) {
					trigger_error('Invalid Server '.$server[0], E_USER_WARNING);
				} else {
					$online = true;
				}

				if (!$online) {
					trigger_error('Could not start cache (Memcache).', E_USER_WARNING);
					$this->_online = false;
					return ;
				}
			}
		} else {
			//If there was no memcache server list try the default settings
			if (!$this->_memcache->addServer('127.0.0.1', 11211, true, 1, 1, 15, true, null)) {
				trigger_error('Could not start cache (Memcache).', E_USER_WARNING);
				$this->_online = false;
				return ;
			}
		}

		//Make sure we have at least one connection
		if (!@$this->_memcache->getVersion()) {
			trigger_error('Could not start cache (Memcache).', E_USER_WARNING);
			$this->_online = false;
			return ;
		}

		$this->_online = true;

    	//Run the parent constructor
    	parent::__construct();
    }

    public function __destruct() {
    	if ($this->_online) {
    		//Close the memcache handler if not it will stay open for awhile which is wasteful
    		$this->_memcache->close();
    	}
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
	 * Memcache doesn't allow namespaced/tagged cache to be deleted.
	 * So everything will be deleted
	 *
	 * @param string $type Cache type prefix
	 * @return bool
	 */
	public function clear($type = '') {
		return $this->_memcache->flush();
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

		return $this->_memcache->delete($this->_makeName($id));
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

		$name = $this->_makeName($id);

		//Try to set the temp variable to the item
		if (($this->_temp[$name] = $this->_memcache->get($name)) !== false) {
			return true;
		}

		return false;
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

		//Setup the name of the cache
		$name = $this->_makeName($id);

		//Try the temp value that is set if exists was called
		if (isset($this->_temp[$name])) {
			$contents = $this->_temp[$name];
			//Unset temp
			unset($this->_temp[$name]);
		} else {
			//Try to fetch the cache contents
			$contents = $this->_memcache->get($name);
		}

		//Make sure the cache file exists
		if ($contents !== false && !empty($contents)) {
			//Remove base64 & serialization
			return unserialize(base64_decode($contents));
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
			$mems = $this->_memcache->getExtendedStats();
			$memSize = 0;
			$memUsed = 0;
			if (is_array($mems)) {
				foreach ($mems as $key => $mem) {
					if ($mem === false) {
						continue;
					}
					$eachSize = $mem['limit_maxbytes'];
					if ($eachSize == 0) {
						continue;
					}
					$eachUsed = $mem['bytes'];
					if ($eachUsed > $eachSize) {
						$eachUsed = $eachSize;
					}
					$memSize += $eachSize;
					$memUsed += $eachUsed;
				}
			}
			if ($memSize > 0) {
				$memAvail = $memSize - $memUsed;
				return sprintf('Max: %s - Used: %s (%.2f%%)', formatBytes($memSize, true), formatBytes($memUsed, true), ($memUsed * (100 / $memSize)), formatBytes($memAvail, true), ($memAvail * (100 / $memSize)));
			} else {
				return 'Memcache Statistics are unavailable.';
			}
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
		if ($this->_memcache->set($name, $data, 0, (!empty($expire) && is_numeric($expire)) ? $expire : $this->_expire)) {
			return true;
		}
		trigger_error('Cache data not written (Memcache).', E_USER_WARNING);

		return false;
	}
}