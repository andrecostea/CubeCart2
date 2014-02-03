<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR.'ini.inc.php';
define('CC_IN_ADMIN', false);

header('X-Frame-Options: SAME-ORIGIN'); // do not allow iframes

global $config_default;

if (isset($glob['encoder']) && !empty($glob['encoder'])) {
	switch($glob['encoder']) {
		case 'zend': // Load Zend Encrypted File
			$php_version = (PHP_5_3) ? '5.3' : '5.2';
			require_once CC_ROOT_DIR.CC_DS.'index_php'.$php_version.'_enc_zend.php';
		break;
		case 'obfuscated': // Load Obfuscated file
			require_once CC_ROOT_DIR.CC_DS.'index_obf.php';
		break;
		case 'plain': // For internal development only
			require_once CC_ROOT_DIR.CC_DS.'index_no_enc.php';
		break;
		case 'ioncube':
		default: // Load Ioncube Encrypted File
			require_once CC_ROOT_DIR.CC_DS.'index_enc_ion.php';
	}
} else {
	die("The incudes/global.inc.php file has no value for the 'encoder' parameter. This needs to be set to 'zend' or 'ioncube'.");
}