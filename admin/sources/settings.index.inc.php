<?php
if (!defined('CC_INI_SET')) die('Access Denied');

Admin::getInstance()->permissions('settings', CC_PERM_READ, true);

global $lang;

$htaccess = CC_ROOT_DIR.CC_DS.'.htaccess';
$GLOBALS['smarty']->assign('HTACCESS_DISABLED', (!is_writable($htaccess)));
if (isset($_POST['install_htaccess'])) {
	Admin::getInstance()->permissions('settings', CC_PERM_FULL, true);
	$ht_new = (get_magic_quotes_gpc()) ? stripslashes($_POST['htaccess-data']) : $_POST['htaccess-data'];
	if (file_exists($htaccess)) {
		if (file_put_contents($htaccess, $ht_new)) {
			$GLOBALS['main']->setACPNotify($lang['settings']['notify_htaccess_update']);
		} else {
			$GLOBALS['main']->setACPWarning($lang['settings']['error_htaccess_update']);
		}
	} else {
		if (is_writable(CC_ROOT_DIR) && file_put_contents($htaccess, $ht_new)) {
			$GLOBALS['main']->setACPNotify($lang['settings']['notify_htaccess_create']);
		} else {
			$GLOBALS['main']->setACPWarning($lang['settings']['error_htaccess_create']);
		}
	}
	httpredir(currentPage());
}
unset($htaccess);

// specify some SSL for them if its not been set yet
$ssl_url 		= $GLOBALS['config']->get('config','ssl_url');
$standard_url 	= $GLOBALS['config']->get('config','standard_url');
if(empty($ssl_url) && CC_SSL) {
	$GLOBALS['config']->set('config','ssl_url',CC_STORE_URL);
} elseif(empty($standard_url) && !CC_SSL) {
	$GLOBALS['config']->set('config','standard_url',CC_STORE_URL);
}


if (isset($_POST['config']) && Admin::getInstance()->permissions('settings', CC_PERM_FULL)) {
	$config_old	= $GLOBALS['config']->get('config');
	if (!empty($_FILES)) {
		## New logos being uploaded
		foreach ($_FILES as $logo) {
			if (file_exists($logo['tmp_name']) && $logo['size'] > 0) {
				switch ((int)$logo['error']) {
					case UPLOAD_ERR_OK:
						## Upload is okay, so move to the logo directory, and add a database reference
						$filename	= preg_replace('#[^\w\d\.\-]#', '_', $logo['name']);
						$target		= CC_ROOT_DIR.CC_DS.'images'.CC_DS.'logos'.CC_DS.$filename;
						move_uploaded_file($logo['tmp_name'], $target);
						$image		= getimagesize($target, $image_info);
						$record		= array(
							'filename'	=> $filename,
							'mimetype'	=> $image['mime'],
							'width'		=> $image[0],
							'height'	=> $image[1],
						);
						$GLOBALS['db']->insert('CubeCart_logo', $record);
						if(!$logo_update) { // prevents x amount of notifications for same thing
							$GLOBALS['main']->setACPNotify($lang['settings']['notify_logo_upload']);
						}
						$logo_update = true;
						break;
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
					case UPLOAD_ERR_PARTIAL:
					case UPLOAD_ERR_NO_FILE:
					case UPLOAD_ERR_NO_TMP_DIR:
					case UPLOAD_ERR_CANT_WRITE:
					case UPLOAD_ERR_EXTENSION:
					default:
						$GLOBALS['main']->setACPWarning($lang['settings']['error_logo_upload']);
						trigger_error('Upload Error! Logo not saved.');
						break;
				}
			}
		}
	}

	if (isset($_POST['logo']) && is_array($_POST['logo'])) {
		foreach ($_POST['logo'] as $logo_id => $logo) {
			if ($logo['status']) {
				## Disable all other logos for this skin/style combo
				$GLOBALS['db']->update('CubeCart_logo', array('status' => 0), array('skin' => $logo['skin'], 'style' => $logo['style']));
			}
			if ($GLOBALS['db']->update('CubeCart_logo', $logo, array('logo_id' => (int)$logo_id))) {
				$logo_update = true;
			}
		}
		$GLOBALS['gui']->rebuildLogos();
	}

	$config_new	= $_POST['config'];
	
	## Validate SSL URL
	/* Nice but not compatible with some servers so it has to go for now
	if (!filter_var($config_new['ssl_url'], FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)) {
		unset($config_new['ssl_url']);
		$config_new['ssl'] = false;
		$config_new['ssl_force'] = false;
	}
	*/
	## Check for .htaccess file
	if ($config_new['seo'] && !file_exists(CC_ROOT_DIR.CC_DS.'.htaccess')) {
		$config_new['seo'] = false;
	}
	if (empty($config_new['time_format'])) {
		$config_new['time_format'] = '%Y-%m-%d %H:%M';
	}

	##
	## TO DO: Add more validation routines
	$updated = ($GLOBALS['config']->set('config', '', $config_new)) ? true : false;

	if ((isset($updated) && $updated) || isset($logo_update)) {
		$GLOBALS['main']->setACPNotify($lang['settings']['notify_settings_update']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['settings']['error_settings_update']);
	}
	$GLOBALS['cache']->clear();
	httpredir(currentPage());
}

if (isset($_GET['logo']) && isset($_GET['logo_id'])) {
	if (($logo = $GLOBALS['db']->select('CubeCart_logo', false, array('logo_id' => (int)$_GET['logo_id']))) !== false) {
		switch (strtolower($_GET['logo'])) {
			case 'delete':
				if (Admin::getInstance()->permissions('settings', CC_PERM_DELETE)) {
					$paths = array(
						'images'.CC_DS.'logos'.CC_DS.$logo[0]['filename'],
						'images'.CC_DS.'logos'.CC_DS.$logo[0]['skin'].'-'.$logo[0]['style'].'.php',
						'images'.CC_DS.'logos'.CC_DS.$logo[0]['skin'].'.php'
					);
					foreach($paths as $path) {
						if (file_exists($logo_path)) {
							unlink($logo_path);
						}
					}
					$GLOBALS['db']->delete('CubeCart_logo', array('logo_id' => $logo[0]['logo_id']));
					$GLOBALS['main']->setACPNotify('Logo removed');
				}
			break;
		}
	}
	$GLOBALS['cache']->clear();
	$GLOBALS['gui']->rebuildLogos();
	httpredir(currentPage(array('logo', 'logo_id')),'Logos');
}

###########################################

## Add content tabs
$GLOBALS['main']->addTabControl($lang['common']['general'], 'General');
$GLOBALS['main']->addTabControl($lang['settings']['tab_features'], 'Features');
$GLOBALS['main']->addTabControl($lang['settings']['tab_layout'], 'Layout');
$GLOBALS['main']->addTabControl($lang['settings']['tab_stock'], 'Stock');
$GLOBALS['main']->addTabControl($lang['settings']['tab_seo'], 'Search_Engines');
$GLOBALS['main']->addTabControl($lang['settings']['tab_ssl'], 'SSL');
$GLOBALS['main']->addTabControl($lang['settings']['tab_offline'], 'Offline');
$GLOBALS['main']->addTabControl($lang['settings']['tab_logos'], 'Logos');
$GLOBALS['main']->addTabControl($lang['settings']['tab_advanced'], 'Advanced_Settings');
$GLOBALS['main']->addTabControl($lang['settings']['tab_copyright'], 'Copyright');
$GLOBALS['main']->addTabControl($lang['settings']['tab_extra'], 'Extra');

if (file_exists(CC_ROOT_DIR.CC_DS.'.htaccess')) {
	$htaccess = file_get_contents(CC_ROOT_DIR.CC_DS.'.htaccess');
} 

if(!strstr($htaccess,'seo_path')) {
	$htaccess = (!empty($htaccess)) ? $htaccess."\r\n\r\n" : '';
	$htaccess .= file_get_contents(CC_ROOT_DIR.CC_DS.$glob['adminFolder'].CC_DS.'sources'.CC_DS.'settings'.CC_DS.'seo-htaccess.txt');
}
$GLOBALS['smarty']->assign('VAL_HTACCESS_CONTENTS', $htaccess);


## Get Front End skins
if (($skins = $GLOBALS['gui']->listSkins()) !== false) {
	foreach ($skins as $folder => $skin) {
		if($skin['info']['mobile']) {
			$skin['info']['selected'] = ($skin['info']['name'] == $GLOBALS['config']->get('config', 'skin_folder_mobile')) ? ' selected="selected"' : '';
			$smarty_data['skins_mobile'][]	= $skin['info'];
			## List of styles
			if (isset($skin['styles']) && is_array($skin['styles'])) {
				foreach ($skin['styles'] as $style) {
					$skin_style[$skin['info']['name']][$style['directory']]	= $style['name'];
				}
			}
		} else {
			$skin['info']['selected'] = ($skin['info']['name'] == $GLOBALS['config']->get('config', 'skin_folder')) ? ' selected="selected"' : '';
			$smarty_data['skins'][]	= $skin['info'];
			## List of styles
			if (isset($skin['styles']) && is_array($skin['styles'])) {
				foreach ($skin['styles'] as $style) {
					$skin_style[$skin['info']['name']][$style['directory']]	= $style['name'];
				}
			}
		}
	}
	$GLOBALS['smarty']->assign('SKINS', $smarty_data['skins']);
	$GLOBALS['smarty']->assign('SKINS_MOBILE', $smarty_data['skins_mobile']);
	
	$other_logo_array = array(
		'0' => array('other_optgroup' => true, 'name' => 'invoices', 'display' => $lang['orders']['title_invoices']),
		'1' => array('name' => 'emails', 'display' => $lang['email']['title_email_templates'])
	);
	
	$GLOBALS['smarty']->assign('SKINS_ALL', array_merge($smarty_data['skins'],$smarty_data['skins_mobile'],$other_logo_array));
	
	$software_license_key = $GLOBALS['config']->get('config', 'license_key');
	
	if(empty($software_license_key)) {
		$GLOBALS['smarty']->assign('MOBILE_DISABLED',' disabled="disabled"');
	}
	
	if (isset($skin_style)) {
		$GLOBALS['smarty']->assign('JSON_STYLES', json_encode((array)$skin_style));
	}
}

## Get admin skins
$path = CC_ROOT_DIR.CC_DS.$GLOBALS['config']->get('config', 'adminFolder').CC_DS.'skins'.CC_DS;
foreach (glob($path.'*', GLOB_MARK) as $folder) {
	if (is_dir($folder) && file_exists($folder.'images') && file_exists($folder.'styles') && file_exists($folder.'templates')) {
		$data['name']		= basename($folder);
		$data['selected'] 	= ($GLOBALS['config']->get('config', 'admin_skin') == $data['name']) ? 'selected="selected"' : '';
		$smarty_data['skins_admin'][]	= $data;
	}
	$GLOBALS['smarty']->assign('SKINS_ADMIN', $smarty_data['skins_admin']);

}
## Get Logos
if (($logos = $GLOBALS['db']->select('CubeCart_logo')) !== false) {
	foreach ($logos as $logo) {
		$logo['delete']	= currentPage(null, array('logo' => 'delete', 'logo_id' => $logo['logo_id']));
		$smarty_data['logos'][]	= $logo;
	}
	$GLOBALS['smarty']->assign('LOGOS', $smarty_data['logos']);
}
## Get Languages
if (($languages = $GLOBALS['language']->listLanguages()) !== false) {
	foreach ($languages as $code => $option) {
		$option['selected'] = ($code == $GLOBALS['config']->get('config', 'default_language')) ? ' selected="selected"' : '';
		$smarty_data['languages'][] = $option;
	}
	$GLOBALS['smarty']->assign('LANGUAGES', $smarty_data['languages']);
}

## Get countries
if (($countries = $GLOBALS['db']->select('CubeCart_geo_country', array('numcode', 'name'))) !== false) {
	$store_country = $GLOBALS['config']->get('config', 'store_country');
	foreach ($countries as $country) {
		$country['selected'] = ($country['numcode'] == $store_country) ? ' selected="selected"' : '';
		$smarty_data['countries'][]	= $country;
	}
	$GLOBALS['smarty']->assign('COUNTRIES', $smarty_data['countries']);
	## Get counties
	$GLOBALS['smarty']->assign('VAL_JSON_COUNTY', state_json());
}


## Get Currencies
if (($currencies = $GLOBALS['db']->select('CubeCart_currency', array('name', 'code'), array('active' => '1'), array('name' => 'ASC'))) !== false) {
	foreach ($currencies as $currency) {
		$currency['selected'] = ($currency['code'] == $GLOBALS['config']->get('config', 'default_currency')) ? ' selected="selected"' : '';
		$smarty_data['currencies'][] = $currency;
	}
	$GLOBALS['smarty']->assign('CURRENCIES', $smarty_data['currencies']);
}

## Get supported timezones from PHP
if (class_exists('DateTimeZone')) {
	$tzabbr = DateTimeZone::listAbbreviations();
	foreach ($tzabbr as $abbr => $array) {
		foreach ($array as $details) {
			if (!empty($details['timezone_id']) && preg_match('#^([a-z\s]+)/([a-z\s]+)$|^UTC$#i', $details['timezone_id'])) {
				$timezones[$details['timezone_id']] = $details['timezone_id'];
			}
		}
	}
	if (isset($timezones)) {
		natsort($timezones);
		$current_timezone = $GLOBALS['config']->get('config', 'time_zone');
		if (empty($current_timezone)) {
			//Try to guess at the time zone
			$current_timezone = date_default_timezone_get();
		}
		foreach ($timezones as $timezone) {
			$smarty_data['timezones'][]	= array(
				'zone'		=> $timezone,
				'selected'	=> ($timezone == $current_timezone) ? ' selected="selected"' : '',
			);
		}
		$GLOBALS['smarty']->assign('TIMEZONES', $smarty_data['timezones']);
	}
}

## Default digital custom path
$GLOBALS['config']->get('config', 'dnLoadRootPath', rootHomePath());
$GLOBALS['config']->get('config', 'dnLoadCustomPath', ($GLOBALS['config']->isEmpty('config', 'dnLoadCustomPath')) ? 'files' : $GLOBALS['config']->get('config', 'dnLoadCustomPath'));

## Offline content data
//$GLOBALS['config']->get('config', 'offline_content', base64_decode($GLOBALS['config']->get('config', 'offline_content')));

## Auto assign config settings to {VAL_[KEYNAME]}
$select_options = array(
	'admin_notify_status'	=> array('2' => $lang['order_state']['name_2'], '1' => $lang['order_state']['name_1']),
	'basket_jump_to'		=> null,
	'cache'					=> array($lang['common']['disabled'], $lang['common']['enabled']),
	'catalogue_expand_tree'	=> null,
	'skin_change'			=> null,
	'debug'					=> array($lang['common']['disabled'], $lang['common']['enabled']),
	#'email_disable_alert'	=> null,
	'ssl_force'				=> null,
	'catalogue_hide_prices'	=> null,
	'email_method'			=> array('mail' => $lang['settings']['email_method_mail'], 'smtp' => $lang['settings']['email_method_smtp']),
	'offline'				=> null,
	'offline_allow_admin'	=> null,
	'basket_out_of_stock_purchase'		=> null,
	'catalogue_popular_products_source'	=> array($lang['settings']['product_popular_views'], $lang['settings']['product_popular_sales']),
	'product_prices_include_tax'		=> null,
	'basket_tax_by_delivery'			=> array($lang['address']['billing_address'], $lang['address']['delivery_address']),
	'proxy'					=> null,
	'recaptcha'				=> array($lang['common']['disabled'], $lang['common']['enabled']),
	'catalogue_sale_mode'	=> array($lang['common']['disabled'], $lang['settings']['sales_per_product'], $lang['settings']['sales_percentage']),
	'seo'					=> (file_exists(CC_ROOT_DIR.CC_DS.'.htaccess')) ? null : array(0 => $lang['common']['no']),
	//'seo_method'			=> array($lang['settings']['seo_method_rewrite'],$lang['settings']['seo_method_lookback']),
	'seo_method'			=> array($lang['settings']['seo_method_rewrite']),
	'seo_metadata'			=> array($lang['settings']['seo_meta_option_disable'],$lang['settings']['seo_meta_option_merge'],$lang['settings']['seo_meta_option_replace']),
	'basket_allow_non_invoice_address'	=> null,
	'catalogue_latest_products'			=> null,
	'catalogue_show_empty'	=> null,
	'email_smtp'			=> null,
	'ssl'					=> null,
	'stock_level'			=> null,
	'stock_change_time'		=> array(2 => $lang['settings']['stock_reduce_pending'], 1 => $lang['settings']['stock_reduce_process'], 0 => $lang['settings']['stock_reduce_complete']),
	'stock_warn_type'		=> array($lang['settings']['stock_warning_method_global'], $lang['settings']['stock_warning_method_product']),

	'seo_trackbacks'		=> array($lang['common']['disabled'], $lang['common']['enabled']),
	'product_weight_unit'	=> array('Lb' => $lang['settings']['weight_unit_lb'], 'Kg' => $lang['settings']['weight_unit_kg']),

	'time_format'			=> '%Y-%m-%d %H:%M',
	
	'product_sort_direction' => array('ASC' => 'ASC', 'DESC' => 'DESC'),
	
	'product_clone'		    => array('0' => $lang['common']['disabled'], '2' => $lang['settings']['product_clone_hide'], '1' => $lang['common']['enabled']),
	'product_clone_code'    => array('1' => $lang['settings']['product_clone_new_code'], '2' => $lang['settings']['product_clone_old_code']),
	
);

if($inventory_columns = $GLOBALS['db']->misc('SHOW FULL COLUMNS FROM '.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_inventory')) {
	$excluded = array('use_stock_level');
	$select_options[]['product_sort_column'] = array();
	foreach($inventory_columns as $inventory_column) {
		if(!in_array($inventory_column['Field'], $excluded)) {
			$select_options['product_sort_column'][$inventory_column['Field']] = (empty($inventory_column['Comment'])) ? $inventory_column['Field'] : $inventory_column['Comment'];
		}
	}
	asort($select_options['product_sort_column']);
}

$smarty_data['config'] = $GLOBALS['config']->get('config');

$GLOBALS['smarty']->assign('CONFIG', $smarty_data['config']);

if (isset($select_options)) {
	foreach ($select_options as $field => $options) {
		if (!is_array($options) || empty($options)) {
			$options = array($lang['common']['no'], $lang['common']['yes']);
		}
		foreach ($options as $value => $title) {
			$selected = ($GLOBALS['config']->has('config', $field) && $GLOBALS['config']->get('config', $field) == $value) ? ' selected="selected"' : '';
			$smarty_data['options'][]	= array('value' => $value, 'title' => $title, 'selected' => $selected);
		}
		$GLOBALS['smarty']->assign('OPT_'.strtoupper($field), $smarty_data['options']);
		unset($smarty_data['options']);
	}
}

$page_content = $GLOBALS['smarty']->fetch('templates/settings.index.php');