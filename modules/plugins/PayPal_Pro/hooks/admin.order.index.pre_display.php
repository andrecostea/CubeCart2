<?php
/*
$Date: 2009-07-17 15:46:20 +0100 (Fri, 17 Jul 2009) $
$Rev: 751 $
*/
/* Handle Payments Pro actions from link clicks on transaction log */

if (isset($_GET['PayPal_Pro'])) {
	include_once (CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'PayPal_Pro'.CC_DS.'website_payments_pro.class.php');
	$wpp	= new Website_Payments_Pro($GLOBALS['config']->get('PayPal_Pro'));
	switch ($_GET['PayPal_Pro']) {
		case 'Capture':
			## Capture the payment (in full)
			if ($transaction = $GLOBALS['db']->select('CubeCart_transactions', false, array('id' => $_GET['transaction_id']))) {
				$capture	= array(
					'transaction_id'	=> $transaction[0]['trans_id'],
					'amount'	=> $transaction[0]['amount']-$transaction[0]['captured'],
					'complete'	=> true,
				);
				if ($response = $wpp->DoCapture($capture)) {
					$log	= array(
						'gateway'	=> 'PayPal_Pro',
						'order_id'	=> $transaction[0]['order_id'],
						'status'	=> $response['PAYMENTSTATUS'],
						'trans_id'	=> $response['TRANSACTIONID'],
						'amount'	=> $response['AMT'],
						'notes'  	=> ($response['ACK'] == 'Success') ? 'Authorization '.$transaction[0]['trans_id'].' has been captured successfully.' : 'It has not been possible to capture authorization '.$transaction[0]['trans_id'].'.',
					);
				}
			}
			break;
		case 'Refund':
			## Refund a transaction (in full)
			if ($transaction = $GLOBALS['db']->select('CubeCart_transactions', false, array('id' => $_GET['transaction_id']))) {
				$refund	= array(
					'transaction_id' => $transaction[0]['trans_id'],
					'type'		=> 'Full',
					'amount'	=> $transaction[0]['amount']
				);
				if ($response = $wpp->RefundTransaction($refund)) {
					$log	= array(
						'gateway'	=> 'PayPal_Pro',
						'order_id'	=> $transaction[0]['order_id'],
						'status'	=> 'Refunded',
						'trans_id'	=> $response['REFUNDTRANSACTIONID'],
						'amount'	=> $response['GROSSREFUNDAMT'],
						'notes'  	=> ($response['ACK'] == 'Success') ? 'A full refund for '.$transaction[0]['trans_id'].' has been processed successfully.' : 'It has not been possible to refund '.$transaction[0]['trans_id'].'.',
					);
				}
			}
			break;
		case 'Void':
			## Void a transaction
			if ($transaction = $GLOBALS['db']->select('CubeCart_transactions', false, array('id' => $_GET['transaction_id']))) {
				$void	= array('transaction_id' => $transaction[0]['trans_id']);
				if ($response = $wpp->DoVoid($void)) {
					$log	= array(
						'gateway'	=> 'PayPal_Pro',
						'order_id'	=> $transaction[0]['order_id'],
						'status'	=> 'Voided',
						'trans_id'	=> $response['AUTHORIZATIONID'],
						'notes'  	=> ($response['ACK'] == 'Success') ? 'Authorization '.$transaction[0]['trans_id'].' has been voided.' : 'It has not been possible to void '.$transaction[0]['trans_id'].'.',
					);
				}
			}
		default:
	}
	if (isset($log) && is_array($log)) $order->logTransaction($log);
	httpredir(currentPage(array('PayPal_Pro', 'transaction_id')),'order_transactions');
}