<?php
/*
$Date: 2010-03-15 13:24:29 +0000 (Mon, 15 Mar 2010) $
$Rev: 1019 $
*/

## Detect current status, if there's pending funds, and allow capture, refund, void, etc
/* commented due to Xtemplate coding below
if (isset($summary[0]['gateway']) && stristr($summary[0]['gateway'], 'PayPal_Pro')) {

	$main->addTabControl($language->paypalpro['module_title'], 'paypal_pro');

	$paypal	= $GLOBALS['config']->get('PayPal_Pro');
	include_once (CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'PayPal_Pro'.CC_DS.'website_payments_pro.class.php');
	$wpp	= new Website_Payments_Pro($paypal);

	$tmpl	= new ACP('admin.order.display.tpl', dirname(__FILE__));
	//$GLOBALS['gui']->changeTemplateDir(dirname(__FILE__));

	if (is_array($history)) {
		foreach ($history as $trans_id => $data) {
			switch ($data['response']['PAYMENTSTATUS']) {
				case 'Expired':
					$methods	= array('Auth');
					break;
				case 'None':
					$methods	= array('Capture');
					if (($data['transaction']['time']+(3600*72)) <= time()) $methods[] = 'Auth';
					break;
				case 'Pending':
					$methods	= array('Capture', 'Void');
					if (($data['transaction']['time']+(3600*72)) <= time()) $methods[] = 'Auth';
					break;
				case 'Completed':
					$methods	= array('Refund','Void');
					break;
				default:
					## Don't show this transaction
					continue 2;
			}
			$json[$data['transaction']['id']]	= array(
				'status'	=> $data['response']['PAYMENTSTATUS'],													## Current trasaction status
				'methods'	=> (is_array($methods)) ? implode(',', $methods) : $methods,							## Available methods
				'amount'	=> number_format($data['transaction']['amount']-$data['transaction']['captured'], 2),	## Transaction value
			);
			$vars['list_transaction'][]	= $data;
		}
		if (isset($json)) $tmpl->assign('JSON_TRANSACTIONS', json_encode($json));
	}
	$tmpl->parse($vars);
	$vars['plugin_tabs'][]	= $tmpl->display();
}
*/