<?php
/*
$Date: 2010-06-08 17:11:38 +0100 (Tue, 08 Jun 2010) $
$Rev: 1169 $
*/

if ($module_config = $GLOBALS['config']->get('PayPal_Pro')) {
	
	$scope = (isset($module_config['scope']) && !empty($module_config['scope']) && ($module_config['scope']=='main' && $GLOBALS['gui']->mobile) || ($module_config['scope']=='mobile' && !$GLOBALS['gui']->mobile)) ? false : true;

	if ($module_config['status'] && $scope) {
		if ($GLOBALS['session']->get('stage', 'PayPal_Pro')=='DoExpressCheckoutPayment') {
			$load_checkouts = false;
			if ($this->_basket['shipping_verified'] && $_GET['_a']=='confirm' && !isset($_SESSION['__system']['GUI_MESSAGE']) && (isset($this->_basket['shipping']) || isset($this->_basket['digital_only']))) {
				$GLOBALS['smarty']->assign('CHECKOUT_BUTTON', $GLOBALS['language']->gateway['make_payment']);	
			} else {
				$GLOBALS['smarty']->assign('DISABLE_CHECKOUT_BUTTON', true);
			}
		} else {
			if (preg_match('#^([a-z]+)-([A-Z]+)#', $GLOBALS['language']->current(), $match)) {
				switch (strtoupper($match[2])) {
					case 'AU':
					case 'DE':
					case 'ES':
					case 'FR':
					case 'GB':
					case 'IT':
					case 'JP':
					case 'NL':
					case 'PL':
						$locale = str_replace('-', '_', $GLOBALS['language']->current());
						break;
					default:
						$locale = 'en_US';
				}
			} else {
				$locale	= 'en_US';
			}
			## Generate the PayPal Pro button
			$button_image = ($GLOBALS['gui']->mobile) ? $GLOBALS['storeURL'].'/modules/plugins/PayPal_Pro/images/express_checkout_mobile.gif' : 'https://www.paypal.com/'.$locale.'/i/btn/btn_xpressCheckout.gif';
			
			$button	= '<a href="'.$GLOBALS['storeURL'].'/index.php?_a=gateway&amp;module=PayPal_Pro" target="_self" title="" /><img src="'.$button_image.'" alt="" /></a>';
			if(is_numeric($module_config['position']) && !isset($list_checkouts[$module_config['position']])) {
				$position = $module_config['position'];
			} else {
				$position = '';
			}
			$list_checkouts[$position]	= (isset($basket['PayPal_Pro'])) ? null : $button;
			$GLOBALS['session']->set('stage', 'SetExpressCheckout', 'PayPal_Pro');
		}
 	}
}