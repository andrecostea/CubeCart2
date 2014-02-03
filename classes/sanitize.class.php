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
 * Santize controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since
 */
class Sanitize {
	/**
	 * Exempt fields to not santize
	 *
	 * @var array
	 */
	private static $exempt = array('description', 'offline_content', 'doc_content','content_html', 'content_text', 'cat_desc', 'copyright', 'maillist_format', 'store_copyright', 'htaccess-data', 'NotificationData');
	
	//=====[ Public ]====================================================================================================

	/**
	 * Add a value to the exempt array
	 *
	 * @param array $exempt
	 */
	static public function addExemption($exempt = array()) {
		if (!empty($exempt) && is_array($exempt)) {
			self::$exempt = array_merge(self::$exempt, $exempt);
		}
	}

	/**
	 * Clean all the global varaibles
	 */
	static public function cleanGlobals() {
		self::_unsetGlobals();

		self::_clean($_GET);
		self::_clean($_POST);
		self::_clean($_COOKIE);
		self::_clean($_REQUEST);
	}

	/**
	 * Checks POSTs for valid security token
	 */
	static public function checkToken() {
		if (!empty($_POST)) {
			//Validate the POST token
			if (!isset($_POST['token']) || !$GLOBALS['session']->checkToken($_POST['token'])) {
				//Make a new token just to insure that it doesn't get used again
				$GLOBALS['session']->getToken(true);
				self::_stopToken();
			}
			//Make a new token
			$GLOBALS['session']->getToken(true);
		} 
	}

	//=====[ Private ]====================================================================================================

	/**
	 * Clean a variable
	 *
	 * @param array $data
	 */
	private static function _clean(&$data) {
		if (empty($data)) {
			return;
		}
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				//Make sure the variable's key name is a valid one
				if (preg_match('#([^a-z0-9\-\_\:\@\|])#i', urldecode($key))) {
					trigger_error('Security Warning: Illegal array key "'.htmlentities($key).'" was detected and was removed.', E_USER_WARNING);
					unset($data[$key]);
					continue;
				} else {
					if (is_array($value)) {
						self::_clean($data[$key]);
					} else {
						// If your HTML content isn't in a field with one of the following names, it's going!
						// We shold probably standardise the field names in the future
						if (!empty($value) && !in_array($key, self::$exempt)) {
							$data[$key] = self::_safety($value);
						}
					}
				}
			}
		} else {
			$data = self::_safety($data);
		}
	}

	/**
	 * Sanitize a string for HTML
	 *
	 * @param string $value
	 */
	private static function _safety($value) {
		return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	}

	/**
	 * Clears POST and triggers error
	 * Used when the POST token is not valid
	 */
	static private function _stopToken() {
		unset($_POST,$_GET);
		trigger_error('Invalid Security Token', E_USER_WARNING);
	}

	/**
	 * Uneset all the globals
	 */
	private static function _unsetGlobals() {
		if (ini_get('register_globals')) {
			if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS']) || isset($_SERVER['GLOBALS']) || isset($_SESSION['GLOBALS']) || isset($_ENV['GLOBALS'])) {
				trigger_error('Security Warning: GLOBALS overwrite attempt detected and prevented.', E_USER_ERROR);
			}
			// Variables that shouldn't be unset
			$skip = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', 'config', 'cache');
			$input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, (isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : array());
			foreach ($input as $key => $value) {
				if (!in_array($key, $skip) && isset($GLOBALS[$key])) {
					unset($GLOBALS[$key]);
				}
			}
			unset($input);
		}
	}
}