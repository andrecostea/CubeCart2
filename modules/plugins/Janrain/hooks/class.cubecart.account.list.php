<?php
if(!defined('CC_DS')) die('Access Denied');
if ($GLOBALS['config']->get('Janrain', 'status')) {
	$account_list_hooks[] = array(
		'href' 	=> $GLOBALS['storeURL'].'/index.php?_a=plugin&amp;plugin=Janrain',
		'title' => $GLOBALS['language']->janrain['your_openid']
	);
}