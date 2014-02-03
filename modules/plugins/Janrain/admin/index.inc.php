<?php
if(!defined('CC_DS')) die('Access Denied');
if(isset($_POST['module'])) {
	$_POST['module']['rpx_app_domain'] 	= str_replace(array('https','http',':','/',' '),'',$_POST['module']['rpx_app_domain']);
	$_POST['module']['rpx_api_key']		= trim($_POST['module']['rpx_api_key']);
}
$module	= new Module(__FILE__, $_GET['module'], 'admin/index.tpl', true, false);
$module->fetch();
$page_content = $module->display();