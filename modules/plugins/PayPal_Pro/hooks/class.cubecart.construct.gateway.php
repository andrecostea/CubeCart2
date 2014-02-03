<?php
/*
$Date: 2010-06-08 17:11:38 +0100 (Tue, 08 Jun 2010) $
$Rev: 1169 $
*/
if(!defined('CC_DS')) die('Access Denied');
if (isset($_GET['module']) && $_GET['module'] == 'PayPal_Pro' || !$GLOBALS['session']->isEmpty('PayerID','PayPal_Pro')) {

	include_once (CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'PayPal_Pro'.CC_DS.'website_payments_pro.class.php');

	$wpp	= new Website_Payments_Pro($GLOBALS['config']->get('PayPal_Pro'));

	if ($GLOBALS['session']->get('stage', 'PayPal_Pro')=='SetExpressCheckout') {
		$wpp->SetExpressCheckout();
		exit;
	} else if ($GLOBALS['session']->get('stage', 'PayPal_Pro')=='DoExpressCheckoutPayment') {
		if ($response = $wpp->DoExpressCheckoutPayment()) {
			/*
			const ORDER_PENDING		= 1;
			const ORDER_PROCESS		= 2;
			const ORDER_COMPLETE	= 3;
			const ORDER_DECLINED	= 4;
			const ORDER_FAILED		= 5;	# Fraudulent
			const ORDER_CANCELLED	= 6;
			*/
			
			switch ($response['PAYMENTSTATUS']) {
				case 'Canceled-Reversal':	## A reversal has been cancelled
					break;
				case 'Denied':				## The merchant has denied the payment
				case 'Failed':				## The payment has failed
					$pp_order_status	= 4;
					break;
				case 'Expired':				## The Authorization period for this payment has expired
					## DoReauthorization
					break;
				case 'In-Progress':			## The transaction has not terminated, e.g. authorization may be awaiting completion
					break;
				case 'Partially-Refunded':	## The payment has been partially refunded
					break;
				case 'Pending':				## The payment is pending
					switch ($response['PENDINGREASON']) {
						case 'address':			## The customer did not include a confirmed shipping address
							## Give options to Authorize or Deny the payment
							break;
						case 'authorization':	## The payment has been authorized, but not settled
							break;
						case 'echeck':			## The payment was by echeck
							break;
						case 'intl':			## Merchant has a non-US account, and does not have a withdrawl mechanism
							break;
						case 'multi-currency':	## You do not have a balance in the currency sent
							break;
						case 'order':			## Part of an order that has been authorized, but not settled
							break;
						case 'paymentreview':	## Under risk review by PayPal
							break;
						case 'unilateral':		## Made by an unregistered or unconfirmed email address
							break;
						case 'verify':			## Merchant is not yet verified
							break;
						case 'other':			## None of the above. Call PayPal customer services.
						case 'none':			## No pending reason
							break;
					}
				#	$pp_order_status	= 1;
					break;
				case 'Reversed':			## A payment was reversed due to a chargeback, or other type of reversal
					switch ($response['REASONCODE']) {
						case 'none':			## No reason code
							break;
						case 'chargeback':		## Chargeback by customer
							break;
						case 'guarantee':		## Customer triggered moneyback guarantee
							break;
						case 'buyer-complaint':	## Customer complained about transaction
							break;
						case 'refund':			## Merchant has refunded customer
							break;
						case 'other':			## None of the above.
							break;
					}
				case 'Refunded':			## The merchant refunded the payment
					$pp_order_status	= 5;
					break;
				case 'Voided':				## An authorization for this transaction has been voided
					break;
				case 'Completed':			## The payment has been completed
				case 'Processed':			## A payment has been accepted
					$pp_order_status	= 2;
			}
			
			
			/* Fraud management filters clearly not fished
			foreach ($response as $field => $value) {
				if (preg_match('#^L_FMF#', $field)) {
					## ???
				}
			}
			*/
			
			$GLOBALS['session']->delete('', 'PayPal_Pro');
			
			$order	= Order::getInstance();
			$cart_order_id		= $GLOBALS['cart']->basket['cart_order_id'];
			$order_summary		= $order->getSummary($cart_order_id);
	
			$transData['gateway']		= 'PayPal Express Checkout';
			$transData['order_id']		= $cart_order_id;
			$transData['trans_id']		= $response['TRANSACTIONID'];
			$transData['amount']		= $response['AMT'];
			$transData['status']		= $response['PAYMENTSTATUS'];
			$transData['customer_id']	= $order_summary['customer_id'];
			$transData['extra']			= '';
			$transData['notes']			= '';
			$order->logTransaction($transData);
			
			$order->updateSummary($cart_order_id, array('gateway' => $transData['gateway']));
			if (isset($pp_order_status)) {
				$order->orderStatus($pp_order_status,$GLOBALS['cart']->basket['cart_order_id']);
				## Redirect to receipt page
				switch ($pp_order_status) {
					case 2:
					case 3:
						httpredir('?_a=complete');
						break;
				}
			} else {
				$GLOBALS['gui']->setError("Payment failed. Please try again.");
			}
		}
	}
}