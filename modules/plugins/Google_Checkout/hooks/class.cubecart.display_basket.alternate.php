<?php
if(!defined('CC_DS')) die('Access Denied');

/* Generate the alternate checkout button */

if ($module_config = $GLOBALS['config']->get('Google_Checkout')) {

	$scope = (isset($module_config['scope']) && !empty($module_config['scope']) && ($module_config['scope']=='main' && $GLOBALS['gui']->mobile) || ($module_config['scope']=='mobile' && !$GLOBALS['gui']->mobile)) ? false : true;

	if ($module_config['status'] && $scope) {
		switch ($module_config['size']) {
			case 'small':
				$width	= 160;
				$height	= 43;
				break;
			case 'medium':
				$width	= 168;
				$height	= 44;
				break;
			case 'large':
			default:
				$width	= 180;
				$height = 46;
				break;
		}
		if(strtolower($module_config['mode']) == "sandbox") {
        	$server_url = "https://sandbox.google.com/checkout/";
      	} else {
        	$server_url=  "https://checkout.google.com/";  
      	}
		if(is_numeric($module_config['position']) && !isset($list_checkouts[$module_config['position']])) {
			$position = $module_config['position'];
		} else {
			$position = '';
		}
		$list_checkouts[$position]	= sprintf('<a href="?_a=gateway&amp;module=Google_Checkout"><img src="'.$server_url.'buttons/checkout.gif?merchant_id=%s&amp;w=%d&amp;h=%d&amp;style=trans&amp;variant=text" alt="" /></a>', $module_config['merchId'], $width, $height);
	}
}