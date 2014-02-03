<?php
##############################################################################
## DEPRECATED FUNCTIONS - All these functions will trigger an error if used	##
## The goal is to totally dispose of them before we reach a beta release	##
##############################################################################

function win() {
	trigger_error('win() has been deprecated. Please write better code (stristr(PHP_OS, \'WIN\') is much nicer).', E_USER_NOTICE);
	return (stristr(PHP_OS, 'WIN')) ? true : false;
}

function buildCatTree(&$treeData = array(), &$key = 0, $cat_parent_id = 0, $level = 0) {
	trigger_error('buildCatTree() has been deprecated. Please use Catalogue::catalogue_tree() instead.', E_USER_NOTICE);
	return false;
}
function cellColor($i, $tdEven = "tdEven", $tdOdd = "tdOdd") {
	trigger_error('cellColour() should be replaced.', E_USER_NOTICE);
	return ($i%2) ? $tdOdd : $tdEven;
}
function checkImgExt($filename) {
	trigger_error('checkIngExt(): Use GD functions instead!', E_USER_NOTICE);
	$img_exts = array("gif", "jpg", "jpeg", "png");
	foreach ($img_exts as $this_ext) {
		if (preg_match("/\.".$this_ext."$/", $filename)) {
			return true;
		}
	}
	return false;
}
function detectSSL() {
	trigger_error('detectSSL() is deprecated. Please use SSL::detect() instead.', E_USER_NOTICE);
	if (isset($GLOBALS['ssl']) && $GLOBALS['ssl'] instanceof SSL) {
		return $GLOBALS['ssl']->detect();
	} else {
		return (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == true || $_SERVER['SERVER_PORT'] == 443)) ? true : false;
	}
}
function enableSSl() {
	trigger_error('enableSSL() has been deprecated. Please use the SSL Class instead.', E_USER_NOTICE);
	return ($_COOKIE['ccSSL'] == true || $_GET['ccSSL'] == true || $_POST['ccSSL'] == true) ? true : false;
}
function fetchDbConfig($confName) {
	trigger_error('fetchDbConfig() is deprecated. Please use Database::fetchConfig(string $name [, bool $cache]) instead.', E_USER_NOTICE);
	return $GLOBALS['config']->get($confName);
	
}
function imgPath($masterImage, $thumb = false, $path = '') {
	trigger_error('imgPath() is deprecated. Please use Catalogue::imagePath(mixed $image [, bool $thumb [, string $path [, bool $rebuild]]]) instead.', E_USER_NOTICE);
	return $GLOBALS['cart']->imagePath($masterImage, $thumb, $path);
}
function listAddons($path) {
	trigger_error('listAddons should be completely deprecated by now.', E_USER_NOTICE);
	foreach (glob($path.CC_DS.'*') as $dirpath) {
		$folder = basename($dirpath);
		if (is_dir($dirpath) && !preg_match('#^[\._]#iuU', $folder)) {
			$folderList[] = $folder;
		}
	}
	natcasesort($folderList);
	return (is_array($folderList)) ? $folderList : false;
}
function listModules($path) {
	trigger_error('listModules is deprecated. Please use listAddons instead.', E_USER_NOTICE);
	return listAddons($path);
}
function loadAddonConfig($path) {
	trigger_error('loadAddonConfig is deprecated.', E_USER_NOTICE);
	if (file_exists($path.CC_DS.'package.conf.php')) {
		$string = file_get_contents($path.CC_DS.'package.conf.php', true);
		return unserialize($string);
	}
	return false;
}
function msg($msg, $log = true) { 
	trigger_error('msg() has been deprecated. Please use GUI::setError(string $message) or GUI::setNotify(string $message) instead.', E_USER_NOTICE);
	return stripslashes($msg);
}
function paginate($numRows, $maxRows, $pageNum=1, $pageVar='page', $class="txtLink", $limit=5, $excluded = array()) {
	trigger_error('paginate() has been deprecated. Please use Database::pagination() instead', E_USER_NOTICE);
	return $GLOBALS['db']->pagination($numRows, $maxRows, $pageNum, $limit, $pageVar);
}
function permission($section, $permission, $halt = false) {
	trigger_error('permission() is deprecated. Please use Admin::Permissions(string $section, int $permission [, bool $halt]) instead.', E_USER_NOTICE);
	return $GLOBALS['session']->permissions($section, $permission, $halt);
}
function priceFormat($price, $dispNull = true) {
	trigger_error('priceFormat() is deprecated. Please use Tax::priceFormat(float $price [, bool $display_null]) instead.', E_USER_NOTICE);
	$tax	= new Tax();
	return $tax->priceFormat($price, $dispNull);
}
function salePrice($normPrice, $salePrice) {
	trigger_error('salePrice() is deprecated. Please use Tax::salePrice(float $normal_price, float $sale_price) instead.', E_USER_NOTICE);
	$tax	= new Tax();
	return $tax->salePrice($normPrice, $salePrice);
}
function validateEmail($email) {
	trigger_error('validateEmail() has been superceeded by SPL filter_*() functions.', E_USER_NOTICE);
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function writeDbConf($new = '', $confName, $prevArray, $output = true) {
	trigger_error('writeDbConfig() is deprecated. Please use config::set(string $config_name, string $element, mixed $data , bool $force_write) instead.', E_USER_NOTICE);
	return $GLOBALS['db']->writeConfig($confName, $new, $prevArray);
}

##############################################################################
## The following functions have no direct replacements, so just return false
function createSpamCode($spamCode) {
	trigger_error('createSpamCode() has been superceeded by reCAPTCHA.', E_USER_NOTICE);
	return false;
}
function fetchSpamCode($ESC, $del = false) {
	trigger_error('fetchSpamCode() has been superceeded by reCAPTCHA.', E_USER_NOTICE);
	return false;
}
function getLang($path, $setlang = 'en') {
	trigger_error('getLang() is deprecated. Please use Language class methods instead.', E_USER_NOTICE);
	return false;
}
function getTax(&$price, $addTax = true, $vatRate = 17.5) {
	trigger_error('getTax() has been superceeded by the Tax Class.', E_USER_NOTICE);
	return false;
}
function imgSpambot($encodedSpamCode, $path = '') {	
	trigger_error('imgSpambot() has been superceeded by reCAPTCHA.', E_USER_NOTICE);
	return false;
}
function prodAltLang($product_id) {
	trigger_error('prodAltLang() has been superceeded by the Language/Catalogue Classes.', E_USER_NOTICE);
	return false;
}
function taxRate($id) {
	trigger_error('taxRate() has been superceeded by the Tax Class.', E_USER_NOTICE);
	return false;
}
##############################################################################

function readableSeconds($time = 0) {
	## Convert seconds into Human Readable
	## worth keeping, but should be tidied up
	$hours    = (int)floor($time/3600);
	$minutes  = (int)floor($time/60)%60;
	$seconds  = (int)$time%60;
	$output   = ''; 
	
	if ($hours == 1) {
		$output = $hours." hour";
	} else if ($hours>1) {
		$output  = $hours." hours";   
	}
	if ($output && $minutes>0 && $seconds>0) {
		$output .= ", ";
	} else if ($output && $minutes>0 && $seconds == 0) {
		$output .= " and ";
	}
	
	$s = ($minutes>1)  ? "s" : NULL;
	if ($minutes>0) $output .= $minutes." minute".$s; 
	$s = ($seconds>1) ? "s" : NULL;
	if ($output && $seconds>0) $output .= " and ";   
	if ($seconds>0) {
		$output .= $seconds." second".$s; 
	} else if (!$output && $seconds == 0) {
		$output  = "0 seconds";
	}
	return $output;
}

## Macro Substitution
function macroSub($string, $macroArray) {
	trigger_error('macroSub() is being replaced by the unholy PHPMailer/XTemplate conglomeration', E_USER_NOTICE);
	if (is_array($macroArray)) {
		foreach ($macroArray as $key => $value) {
			$string = str_replace('{'.$key.'}', $value, $string);
		}
	}
	return $string;
}

## Generate a random password
## This needs improving, or replacing
function randomPass($max = 8) {
	$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J", "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T", "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9","0");
	
	$max_chars = count($chars) - 1;
	srand((double)microtime()*1000000);
	for ($i = 0; $i < $max; $i++) {
		$newPass = ($i == 0) ? $chars[rand(0, $max_chars)] : $newPass . $chars[rand(0, $max_chars)];
	}
	return $newPass;
}

## Get county/state abbreviation by ID
function countyAbbrev($id) {
	global $db,$glob;
	$county = $GLOBALS['db']->query("SELECT SQL_CACHE abbrev FROM ".$glob['dbprefix']."CubeCart_geo_zone WHERE id = ".$GLOBALS['db']->mySQLSafe($id));
	return ($county == true) ? $county[0]['abbrev'] : false;
}
