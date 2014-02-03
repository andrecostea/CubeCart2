<?php
/**
 * CubeCart v5
 * ========================================
 * CubeCart is a registered trade mark of Devellion Limited
 * Copyright Devellion Limited 2010. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:			http://www.cubecart.com
 * Email:		sales@devellion.com
 * License:		http://www.cubecart.com/v5-software-license
 * ========================================
 * CubeCart is NOT Open Source.
 * Unauthorized reproduction is not allowed.
 */
/**
 * Autoloader controller
 *
 * @author Technocrat
 * @version 1.0.0
 * @since 5.0.0
 */
class Autoloader {

	/**
	 * Contains all the paths to search for classes
	 *
	 * @var array of paths
	 */
	private static $_paths	= null;

	/**
	 * Append a path to the path array
	 *
	 * @param string $path
	 */
	public static function appendPaths($path) {
		if (is_null(self::$_paths)) {
			self::$_paths = explode(CC_PS, ini_get('include_path'));
		}

		if (CC_DS != '/') {
			$path = str_replace('/', CC_DS, $path);
		}

		if (is_dir($path) && file_exists($path)) {
			self::$_paths[] = $path;
		}
	}

	/**
	 * Autoload a class
	 *
	 * @param string $class
	 * @return bool
	 */
	public static function autoload($class) {
		if (CC_DS != '/') {
			$class	= str_replace('/', CC_DS, $class);
		}

		//Don't double load
		if (class_exists($class)) {
			return true;
		}

		//If its a DB class use the db method
		if ($class == 'Database') {
			return self::autoload_db();
		}

		//If its a cache class use the cache method
		if ($class == 'Cache') {
			return self::autoload_cache();
		}

		//If its smarty we need to use the smarty loader
		if ($class == 'Smarty') {
			require_once CC_INCLUDES_DIR.'lib'.CC_DS.'smarty'.CC_DS.'Smarty.class.php';
			return true;
		}

		//Try classes first
		if (file_exists(CC_CLASSES_DIR.CC_DS.strtolower($class).'.class.php')) {
			include_once CC_CLASSES_DIR.CC_DS.strtolower($class).'.class.php';
			return true;
		}

		//Get the paths if needed
		if (!self::$_paths) {
			self::$_paths = explode(CC_PS, ini_get('include_path'));
		}

		//Loop through the include paths
		if (is_array(self::$_paths)) {
			foreach (self::$_paths as $path) {
				if (file_exists($path.CC_DS.strtolower($class).'.class.php')) {
					include_once $path.CC_DS.strtolower($class).'.class.php';
					return true;
				} else if (file_exists($path.CC_DS.$class.'.php')) {
					include_once $path.CC_DS.$class.'.php';
					return true;
				}
			}
		}

		return true;
	}

	/**
	 * Autoload the correct DB class
	 *
	 * @return bool
	 */
	public static function autoload_db() {
		global $glob;

		//If the configuration has a DB try to load that one first
		if (isset($glob['db']) && !empty($glob['db'])) {
			if (file_exists(CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'db'.CC_DS.$glob['db'].'.class.php')) {
				include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'db'.CC_DS.$glob['db'].'.class.php';
				return true;
			}
		}

		//We will do mysqli if loaded
		if (extension_loaded('mysqli')) {
			include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'db'.CC_DS.'mysqli.class.php';
			return true;
		} else {
			include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'db'.CC_DS.'mysql.class.php';
			return true;
		}

		return false;
	}

	/**
	 * Autoload the correct cache class
	 *
	 * @return bool
	 */
	public static function autoload_cache() {
		global $glob;

		//If the configuration has a DB try to load that one first
		if (isset($glob['cache']) && !empty($glob['cache'])) {
			if (file_exists(CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.$glob['cache'].'.class.php')) {
				include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.$glob['cache'].'.class.php';
				return true;
			}
		}

		//Try to pick the best opcode cache
		if (extension_loaded('APC') && ini_get('apc.enabled')) {
			include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.'apc.class.php';
			return true;
		}

		/**
		 * @todo
		 * This has been disabled until more testing can be done
		 */
		/*if (extension_loaded('memcache')) {
			include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.'memcache.class.php';
			return true;
		}*/

		if (extension_loaded('XCache') && ini_get('xcache.size') > 0) {
			if (ini_get('xcache.admin.enable_auth')) {
				// To use XCache, you must set "xcache.admin.enable_auth" to "Off" in your php.ini
			} else {
				include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.'xcache.class.php';
				return true;
			}
		}

		//Default to file cache
		include CC_ROOT_DIR.CC_DS.'classes'.CC_DS.'cache'.CC_DS.'file.class.php';
		return true;
	}

	/**
	 * Register autoload function
	 *
	 * @param string/array $function or array(class, method)
	 */
	public static function autoload_register($function = null) {
		if (!function_exists('spl_autoload_functions')) {
			trigger_error("!function_exists('spl_autoload_functions')", E_USER_ERROR);
		}

		//If there is not function we shouldn't be here
		if (!$function) {
			return ;
		}

		//If the function is really a class->method try to load that
		if (is_array($function)) {
			list($class, $method) = $function;
			if (!method_exists($class, $method)) {
				return ;
			}
		} elseif (!function_exists($function)) {
			return ;
		}

		//If the spl_autoload is implemented get the functions if not
		if (($callbacks = spl_autoload_functions()) === false) {
			//Register our function
			spl_autoload_register($function);
			return ;
		}
		//If there are no call backs we do not need to continue
		if (empty($callbacks)) {
			spl_autoload_register($function);
			return ;
		}

		//Lop through the call backs and unload them
		$key = array_keys($callbacks);
		$size = sizeOf($key);
		for ($i = 0; $i < $size; ++$i) {
			spl_autoload_unregister($callbacks[$key[$i]]);
		}

		//Register our function
		spl_autoload_register($function);

		//Reload the previous functions
		for ($i = 0; $i < $size; ++$i) {
			spl_autoload_register($callbacks[$key[$i]]);
		}
	}

	/**
	 * Reload all the paths from the include_path
	 * Should not need to run unless you add more paths to the include_path
	 */
	public static function reloadPaths() {
		self::$_paths = explode(CC_PS, ini_get('include_path'));
	}
}