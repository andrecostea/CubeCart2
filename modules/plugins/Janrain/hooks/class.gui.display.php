<?php
if(!defined('CC_DS')) die('Access Denied');
if ($GLOBALS['config']->has('Janrain', 'status') && $GLOBALS['config']->get('Janrain', 'status') && !$GLOBALS['config']->isEmpty('Janrain', 'rpx_app_domain')) {
	$GLOBALS['config']->merge('Janrain', 'rpx_auth_url', 'https://'.strtolower($GLOBALS['config']->get('Janrain', 'rpx_app_domain')));
	$GLOBALS['smarty']->assign('RPX_LANG', $GLOBALS['language']->current());
	$GLOBALS['smarty']->assign('RPX', true);
	$file_name = 'js.tpl';
	$form_file = str_replace('hooks/','',$GLOBALS['gui']->getCustomModuleSkin('plugins', dirname(__FILE__), $file_name));
	$GLOBALS['gui']->changeTemplateDir($form_file);
	$display_html[] = array(
		'macro_name' => 'JANRAIN',
		'html' => $GLOBALS['smarty']->fetch($file_name)
	);
	$GLOBALS['gui']->changeTemplateDir();
}