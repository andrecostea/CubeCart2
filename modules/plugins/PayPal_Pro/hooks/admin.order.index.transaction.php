<?php
/*
$Date: 2010-03-15 13:24:29 +0000 (Mon, 15 Mar 2010) $
$Rev: 1019 $
*/
/* Display Pyaments Pro actions in the transaction log rows */
if (stristr($transaction['gateway'], 'PayPal_Pro') || stristr($transaction['gateway'], 'PayPal Express Checkout') || stristr($transaction['gateway'], 'PayPal Card Payment')) {	
	include_once (CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'PayPal_Pro'.CC_DS.'website_payments_pro.class.php');
	$wpp	= new Website_Payments_Pro($GLOBALS['config']->get('PayPal_Pro'));
	if ($response = $wpp->GetTransactionDetails($transaction['trans_id'])) {
		
		switch ($response['PAYMENTSTATUS']) {
			case 'Completed':
				if($transaction['status']!=="Refunded") {
					$action[]	= array(
						'title'	=> $language->paypal_pro['action_refund'],
						'icon'	=> 'arrow_out.png',
						'url'	=> currentPage(null, array('PayPal_Pro' => 'Refund', 'transaction_id' => $transaction['id'])),
					);
				}
				break;
			case 'None':
			case 'Pending':
				$action[]	= array(
					'title'	=> $language->paypal_pro['action_capture'],
					'icon'	=> 'arrow_in.png',
					'url'	=> currentPage(null, array('PayPal_Pro' => 'Capture', 'transaction_id' => $transaction['id'])),
				);
				$action[]	= array(
					'title'	=> $language->paypal_pro['action_void'],
					'icon'	=> 'delete.png',
					'url'	=> currentPage(null, array('PayPal_Pro' => 'Void', 'transaction_id' => $transaction['id'])),
				);
				break;
			case 'Refunded':
			case 'Partial-Refund':
			case 'Voided':
				## Do nothing (presumably as i think there is nothing to do)
				break;
		}
	}

	if (isset($action) && is_array($action)) {
		$transaction['actions']	= $action;
		$GLOBALS['smarty']->assign('transaction_actions',true);
		unset($action);
	}
}