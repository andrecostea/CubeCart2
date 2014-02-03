<?php
/*
$Date: 2010-05-11 16:50:17 +0100 (Tue, 11 May 2010) $
$Rev: 1087 $
*/
/* Handle post data from WPP tab, and perform the requested action */

if (isset($_POST['wpp'])) {
	include_once (CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'PayPal_Pro'.CC_DS.'website_payments_pro.class.php');
	$wpp	= new Website_Payments_Pro($GLOBALS['config']->get('PayPal_Pro'));
	## Fetch transaction data
	if ($trans = $GLOBALS['db']->select('CubeCart_transactions', false, array('id' => $_POST['wpp']['transaction']), false, 1)) {
		$remainder		= number_format($trans[0]['amount']-$trans[0]['captured'], 2);
		switch ($_POST['wpp']['method']) {
			case 'Auth':
				## Reauthorize the transaction, to the value of the remainder
				if ($response = $wpp->DoReauthorization($trans[0]['trans_id'], $remainder)) {
					switch ($response['ACK']) {
						case 'SuccessWithWarning':
						case 'Success':
							## This will be the new transaction to capture funds from, so retire the old one
							$log	= array(
								'gateway'	=> 'PayPal_Pro',
								'status'	=> $response['PAYMENTSTATUS'],
								'trans_id'	=> $response['TRANSACTIONID'],
								'amount'	=> $response['AMT'],
							);
							break;
					}
				}
				break;
			case 'Capture':
				## Capture the payment
				$capture	= array(
					'transaction_id'	=> $trans[0]['trans_id'],
					'amount'			=> $_POST['wpp']['capture']['amount'],
					'complete'			=> (bool)$_POST['wpp']['capture']['completetype'],
					'note'				=> $_POST['wpp']['capture']['note'],
				);
				if ($response = $wpp->DoCapture($capture)) {
					switch ($response['ACK']) {
						case 'SuccessWithWarning':
						case 'Success':
							$log	= array(
								'gateway'	=> 'PayPal_Pro',
								'status'	=> $response['PAYMENTSTATUS'],
								'trans_id'	=> $response['TRANSACTIONID'],
								'amount'	=> $response['AMT'],
								'notes'		=> $capture['note'],
							);
							## Update original transaction record's 'remainder' field
							$GLOBALS['db']->update('CubeCart_transactions', array('captured' => $trans[0]['captured']+$response['AMT']), array('id' => $trans[0]['id']));
							break;
					}
				}
				if ($_POST['wpp']['capture']['completetype']) {
				#	if ($void_response = $wpp->DoVoid(array('transaction_id' => $trans[0]['trans_id'], 'note' => $capture['note']))) {
				#		var_dump($void_response);
				#	}
				}
				break;
			case 'Refund':
				$refund	= array(
					'transaction_id'	=> $trans[0]['trans_id'],
					'type'				=> ($_POST['wpp']['refund']['amount'] < $trans[0]['amount']) ? 'Partial' : 'Full',
					'amount'			=> $_POST['wpp']['refund']['amount'],
					'note'				=> $_POST['wpp']['refund']['note'],
				);
				if ($response = $wpp->RefundTransaction($refund)) {
					switch ($response['ACK']) {
						case 'SuccessWithWarning':
						case 'Success':
							$log	= array(
								'gateway'	=> 'PayPal_Pro',
								'status'	=> 'Refunded',
								'trans_id'	=> $response['REFUNDTRANSACTIONID'],
								'amount'	=> $response['GROSSREFUNDAMT'],
							);
							$GLOBALS['db']->update('CubeCart_transactions', array('captured' => $trans[0]['captured']-$response['GROSSREFUNDAMT']), array('id' => $trans[0]['id']));
							break;
					}
				}
				break;
			case 'Void':
				$void	= array(
					'transaction_id'	=> $trans[0]['trans_id'],
					'note'				=> $_POST['wpp']['note'],
				);
				if ($response = $wpp->DoVoid($void)) {
					switch ($response['ACK']) {
						case 'SuccessWithWarning':
						case 'Success':
							$log	= array(
								'gateway'	=> 'PayPal_Pro',
								'status'	=> 'Voided',
								'trans_id'	=> $response['AUTHORIZATIONID'],
								'notes'		=> $void['note'],
							);
							break;
					}
				}
				break;
		}
		## Update Transaction Log
		if (isset($log) && is_array($log)) {
			$log['order_id'] = $order_id;
			$order->logTransaction($log);
		}
	}
}