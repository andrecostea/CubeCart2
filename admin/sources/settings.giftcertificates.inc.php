<?php
if (!defined('CC_INI_SET'))	die('Access Denied');
Admin::getInstance()->permissions('settings', CC_PERM_READ, true);

global $lang;

if (isset($_POST['gc']) && is_array($_POST['gc']) && Admin::getInstance()->permissions('settings', CC_PERM_EDIT)) {
	if ($GLOBALS['config']->set('gift_certs', '', $_POST['gc'])) {
		$GLOBALS['cache']->clear();
		$GLOBALS['main']->setACPNotify($lang['settings']['notify_settings_update']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['settings']['error_settings_update']);
	}
}

$GLOBALS['main']->addTabControl($lang['catalogue']['gift_certificates'], 'Certificates');
$GLOBALS['gui']->addBreadcrumb($lang['catalogue']['gift_certificates'], $_GET);

$gc = $GLOBALS['config']->get('gift_certs');

if (($taxes = $GLOBALS['db']->select('CubeCart_tax_class')) !== false) {
	foreach ($taxes as $tax) {
		$tax['selected'] = ($gc['taxType'] == $tax['id'])? ' selected="selected"' : '';
		$smarty_data['taxs'][]	= $tax;
	}
	$GLOBALS['smarty']->assign('TAXES', $smarty_data['taxs']);
}
$GLOBALS['smarty']->assign('GC', $gc);
$select_options	= array(
	'delivery'	=> array(1 => $lang['settings']['gc_type_digital'], 2 => $lang['settings']['gc_type_physical'], 3 => $lang['settings']['gc_type_both']),
	'status'	=> array(0 => $lang['common']['disabled'], 1 => $lang['common']['enabled']),
);
if (isset($select_options)) {
	foreach ($select_options as $field => $options) {
		if (!is_array($options) || empty($options)) {
			$options	= array($lang['common']['no'], $lang['common']['yes']);
		}
		foreach ($options as $value => $title) {
			$selected	= (isset($gc[$field]) && $gc[$field] == $value) ? ' selected="selected"' : '';
			$smarty_data['options'][]	= array('value' => $value, 'title' => $title, 'selected' => $selected);
		}
		$GLOBALS['smarty']->assign('OPT_'.strtoupper($field), $smarty_data['options']);
		unset($smarty_data['options']);
	}
}
$page_content = $GLOBALS['smarty']->fetch('templates/settings.giftcertificates.php');
