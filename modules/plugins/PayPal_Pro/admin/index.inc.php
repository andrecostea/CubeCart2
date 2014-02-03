<?php
if(!defined('CC_DS')) die('Access Denied');
$module	= new Module(__FILE__, $_GET['module'], 'admin/index.tpl', true, false);

## Modes
$modes	= array(
	'4'	=> $GLOBALS['language']->paypal_pro['mode_pp_hosted'],
	'3'	=> $GLOBALS['language']->paypal_pro['mode_pp'],
	'2'	=> $GLOBALS['language']->paypal_pro['mode_ec'],
	'1'	=> $GLOBALS['language']->paypal_pro['mode_dp'],
);

foreach ($modes as $value => $title) {
	if ($value == '1' && $GLOBALS['config']->get('config','store_country') != 840) continue; // Direct Payment for US Only
	if ($value == '4' && $GLOBALS['config']->get('config','store_country') != 826) continue; // PayPal Pro Hosted for UK Only
	$mode_list[]		= array(
		'value'		=> $value,
		'title'		=> $title,
		'selected'	=> ($value == $module->mode) ? ' selected="selected"' : '',
	);
}

## Gateways
$gateways	= array(
	'0' => $GLOBALS['language']->paypal_pro['gateway_sandbox'],
	'1' => $GLOBALS['language']->paypal_pro['gateway_live'],
);
foreach ($gateways as $value => $title) {
	$gateway_list[]		= array(
		'value'		=> $value,
		'title'		=> $title,
		'selected'	=> ($value == $module->gateway) ? ' selected="selected"' : '',
	);
}

## Payment Actions
$actions	= array(
	'Sale'			=> $GLOBALS['language']->paypal_pro['payment_sale'],
	'Authorization'	=> $GLOBALS['language']->paypal_pro['payment_auth'],
	//'Order'			=> $GLOBALS['language']->paypal_pro['payment_order'],
);
foreach ($actions as $value => $title) {
	$action_list[]		= array(
		'value'		=> $value,
		'title'		=> $title,
		'selected'	=> ($value == $module->paymentAction) ? ' selected="selected"' : '',
	);
}

## Require a confirmed address
$confirmed	= array($GLOBALS['language']->common['no'], $GLOBALS['language']->common['yes']);
foreach ($confirmed as $value => $title) {
	$confirm_list[]	= array(
		'value'		=> $value,
		'title'		=> $title,
		'selected'	=> ($value == $module->confAddress) ? ' selected="selected"' : '',
	);
}

$template_vars = array (
	'confirmed' => $confirm_list,
	'actions'	=> $action_list,
	'gateways'	=> $gateway_list,
	'modes'		=> $mode_list,
	'country'	=> $GLOBALS['config']->get('config','store_country'),
	'paypal_ipn_url' => $GLOBALS['storeURL'].'/index.php?_g=rm&amp;type=gateway&amp;cmd=call&amp;module=PayPal'
);

$module->assign_to_template($template_vars);
$module->fetch();
$page_content = $module->display();