<?php
/*
$Date: 2010-05-11 16:50:17 +0100 (Tue, 11 May 2010) $
$Rev: 1087 $
*/
class Website_Payments_Pro  {

	private $_api_username;
	private $_api_password;
	private $_api_signature;
	private $_api_version	= '65.0';

	private $_api_endpoint;
	private $_api_paypal;
	private $_api_method;

	private $_basket;
	private $_module;
	private $_token;

	################################################

	public function __construct($settings = false) {
		$this->_basket =& $GLOBALS['cart']->basket;

		//parent::__construct();

		if (is_array($settings)) {
			$this->_module			= $settings;
			## Settings
			$this->_api_username	= $settings['username'];
			$this->_api_password	= $settings['password'];
			$this->_api_signature	= $settings['signature'];
			$this->_api_method		= $settings['paymentAction'];
			$mobile = ($GLOBALS['gui']->mobile) ? '-mobile' : '';
			
			if ($settings['gateway']) {
				## Live Mode
				$this->_api_endpoint	= 'api-3t.paypal.com/nvp';
				$this->_api_paypal_url	= 'https://www.paypal.com/webscr&cmd=_express-checkout'.$mobile.'&token=';
			} else {
				## Sandbox/Testing Mode
				$this->_api_endpoint	= 'api-3t.sandbox.paypal.com/nvp';
				$this->_api_paypal_url	= 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout'.$mobile.'&token=';
			}
		} else {
			## Accelerated Boarding
			$this->_api_method		= 'Sale';
		}

		## Fetch Token, if set
		$this->_token	= $GLOBALS['session']->isEmpty('token','PayPal_Pro') ? false : $GLOBALS['session']->get('token', 'PayPal_Pro');
	}

	public function __destruct() {
	#	$_SESSION['Paypal_Pro']['TOKEN']	= $this->_token;
	}

	public function __call($method, $arguments) {
		if (!empty($arguments) && is_array($arguments[0])) {
			if ($response = $this->nvp_request($method, $arguments[0])) {
				return $response;
			}
		}
		return false;
	}

	################################################

	public function GetTargetUrl() {
		return $this->_api_paypal_url.$this->_token;
	}
	
	public function GetHostedUrl($parameters) {
		$static_nvp_data = array(
			'BUTTONCODE' 		=> 'TOKEN',
			'BUTTONTYPE' 		=> 'PAYMENT',
			'BUTTONIMAGEURL' 	=> 'https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif'
		);	
		
		$k = 0;
		foreach($parameters as $key => $value) {
			$dynamic_nvp_data['L_BUTTONVAR'.$k] = $key.'='.$value;
			$k++;
		}
		if(!empty($this->_module['partner']) && !empty($this->_module['vendor'])) {
			$dynamic_nvp_data['L_BUTTONVAR'.$k] = 'partner='.$this->_module['partner'];
			$k++;
			$dynamic_nvp_data['L_BUTTONVAR'.$k] = 'vendor='.$this->_module['vendor'];
		}
		$nvp_data = array_merge($dynamic_nvp_data, $static_nvp_data);
		
		$response = $this->nvp_request('BMCreateButton', $nvp_data);
		return $response['EMAILLINK'];
	}

	################################################

	public function DoAuthorization($transaction_id = null, $amount = null) {
		## Authorize a payment
		$nvp_data	= array(
			'TRANSACTIONID'	=> $transaction_id,
			'AMT'			=> $amount,
			'CURRENCYCODE'	=> $GLOBALS['config']->get('config','default_currency'),
		);
		return $this->nvp_request('DoAuthorization', $nvp_data);
	}

	public function DoCapture($capture = null) {
		if (!empty($capture) && is_array($capture)) {
			$nvp_data	= array (
				'AUTHORIZATIONID'	=> $capture['transaction_id'],
				'AMT'				=> $capture['amount'],
				'COMPLETETYPE'		=> ($capture['complete']) ? 'Complete' : 'NotComplete',
				'CURRENCYCODE'		=> $GLOBALS['config']->get('config','default_currency'),
				'NOTE'				=> $capture['note'],
			);
			if ($response = $this->nvp_request('DoCapture', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function DoDirectPayment($nvp = array()) {
		## Process a credit card payment
		if (!empty($nvp)) {
			$nvp_data	= array(
				## Payment Data
				'PAYMENTACTION'		=> ($this->_api_method == 'Order') ? 'Authorization' : $this->_api_method,
				'IPADDRESS'			=> get_ip_address(),
				'RETURNFMFDETAILS'	=> '1',
				'INVNUM'			=> $this->_basket['cart_order_id'],

				## Values
				'AMT'				=> sprintf('%.2f', $this->_basket['total']),
				'ITEMAMT'			=> sprintf('%.2f', $this->_basket['total']),
				//'ITEMAMT'			=> sprintf('%.2f', $this->_basket['subtotal']),
				//'TAXAMT'			=> sprintf('%.2f', $this->_basket['total_tax']),
				//'SHIPPINGAMT'		=> sprintf('%.2f', $this->_basket['shipping']['value']),

				## Card details
				'CREDITCARDTYPE'	=> $nvp['card_type'],
				'ACCT'				=> preg_replace('#[\D]+#', '', $nvp['card_number']),
				'CVV2'				=> preg_replace('#[\D]+#', '', $nvp['cvv2']),
				'EXPDATE'			=> sprintf('%02d%d', (int)$nvp['exp_month'], (int)$nvp['exp_year']),

				## Billing Address
				'SALUTATION'		=> $nvp['title'],
				'FIRSTNAME'			=> $nvp['first_name'],
				'LASTNAME'			=> $nvp['last_name'],
				'STREET'			=> $nvp['line1'],
				'STREET2'			=> $nvp['line2'],
				'CITY'				=> $nvp['town'],
				'STATE'				=> getStateFormat($nvp['state_id'], 'id', 'abbrev'),
				'ZIP'				=> $nvp['postcode'],
				'PHONENUM'			=> $nvp['phone'],
				'COUNTRYCODE'		=> getCountryFormat($nvp['country_id'], 'numcode', 'iso'),
				'CURRENCYCODE'		=> $GLOBALS['config']->get('config','default_currency'),

				## Shipping Address
				'SHIPTONAME'		=> trim(sprintf('%s %s %s', $this->_basket['delivery_address']['title'], $this->_basket['delivery_address']['first_name'], $this->_basket['delivery_address']['last_name'])),
				'SHIPTOSTREET'		=> $this->_basket['delivery_address']['line1'],
				'SHIPTOSTREET2'		=> $this->_basket['delivery_address']['line2'],
				'SHIPTOCITY'		=> $this->_basket['delivery_address']['town'],
				'SHIPTOZIP'			=> $this->_basket['delivery_address']['postcode'],
				'SHIPTOSTATE'		=> getStateFormat($this->_basket['delivery_address']['state_id'], 'id', 'abbrev'),
				'SHIPTOCOUNTRYCODE'	=> $this->_basket['delivery_address']['country_iso'],
			);
			if ($this->_module['3ds_status']) {
				$centinel	= array(
					'AUTHSTATUS3DS'		=> $GLOBALS['session']->get('AUTHSTATUS3DS', 'centinel'),
					'MPIVENDOR3DS'		=> $GLOBALS['session']->get('MPIVENDOR3DS', 'centinel'),
					'CAVV'				=> $GLOBALS['session']->get('CAVV', 'centinel'),
					'ECI3DS'			=> $GLOBALS['session']->get('ECI', 'centinel'),
					'XID'				=> $GLOBALS['session']->get('XID', 'centinel'),
				);
				$nvp_data	= array_merge($nvp_data, $centinel);
			}
			$i	= 0;
			$tax_total	= 0;
			$prod_total	= 0;
			/* Fail fail fail!
			foreach ($this->_basket['contents'] as $hash => $item) {
				$product	= $GLOBALS['catalogue']->getProductData($item['id']);
				$price		= $item['total_price_each'];	## Always tax exclusive
				$GLOBALS['tax']->loadTaxes($this->_basket['delivery_address']['country_id']);
				$GLOBALS['tax']->productTax($price, $product['tax_type'], false, $this->_basket['delivery_address']['state_id']);
				$taxes		= $GLOBALS['tax']->fetchTaxAmounts();
				$nvp_data	= array_merge(array(
					'L_NAME'.$i	=> $item['name'],
					'L_AMT'.$i	=> sprintf('%.2f', $price),
					'L_QTY'.$i	=> $item['quantity'],
					'L_TAX'.$i	=> sprintf('%.2f', $taxes['applied']),
				), $nvp_data);
				$i++;
			}
			*/

			## Maestro/Solo required additional details
			if (in_array($nvp['card_type'], array('Maestro', 'Solo'))) {
				if (isset($nvp['issue_number']) && !empty($nvp['issue_number'])) {
					$nvp_data['ISSUENUMBER'] = (int)$nvp['issue_number'];
				}
				if (isset($nvp['issue']) && !empty($nvp['issue_month']) && !empty($nvp['issue_year'])) {
					$nvp_data['STARTDATE'] = sprintf('%02d%d', (int)$nvp['issue_month'], $nvp['issue_year']);
				}
			}
			## Handle Issue Date/Number
			if (isset($nvp['issue_month']) && !empty($nvp['issue_month']) && isset($nvp['issue_year']) && !empty($nvp['issue_year'])) {
				$nvp_data['STARTDATE']		= sprintf('%02d%d', trim($nvp['issue_month']), trim($nvp['issue_year']));
			}
			if (isset($nvp['issue_no']) && !empty($nvp['issue_no'])) {
				$nvp_data['ISSUENUMBER']	= trim($nvp['issue_no']);
			}
			unset($nvp);
			## PayPal's statistic stuff
			switch (strtoupper($GLOBALS['config']->get('config','default_currency'))) {
				case 'CAD':
					$nvp_data['BUTTONSOURCE']	= 'CubeCart_Cart_DP_CA';
					break;
				case 'GBP':
					$nvp_data['BUTTONSOURCE']	= 'CubeCart_Cart_DP';
					break;
				case 'USD':
					$nvp_data['BUTTONSOURCE']	= 'CubeCart_Cart_DP_US';
					break;
			}
			return $this->nvp_request('DoDirectPayment', $nvp_data);
		}
		return false;
	}

	public function DoExpressCheckoutPayment() {
		## Completes an Express Checkout transaction
		$delivery	= $this->_basket['delivery_address'];
		$nvp_data	= array(
			'PAYMENTACTION'		=> $this->_api_method,
			'TOKEN'				=> $this->_token,
			'PAYERID'			=> $GLOBALS['session']->get('PayerID', 'PayPal_Pro'),
			'RETURNFMFDETAILS'	=> '1',
			'CURRENCYCODE'		=> $GLOBALS['config']->get('config','default_currency'),
			'INVNUM'			=> $this->_basket['cart_order_id'],
			'IPADDRESS'			=> get_ip_address(),
			## Delivery Address
			'SHIPTONAME'	=> sprintf('%s %s', $delivery['first_name'], $delivery['last_name']),
			'SHIPTOSTREET'	=> $delivery['line1'],
			'SHIPTOSTREET2'	=> isset($delivery['line2']) ? $delivery['line2'] : '',
			'SHIPTOCITY'	=> $delivery['town'],
			'SHIPTOSTATE'	=> getStateFormat($delivery['state_id'], 'id', 'abbrev'),
			'SHIPTOZIP'		=> $delivery['postcode'],
			'SHIPTOCOUNTRY'	=> getCountryFormat($delivery['country_id'], 'numcode', 'iso'),
			'SHIPTOPHONENUM'=> isset($delivery['phone']) ? $delivery['phone'] : '',
			'NOTIFYURL'     => $GLOBALS['storeURL'].'/index.php?_g=rm&amp;type=gateway&amp;cmd=call&amp;module=PayPal'
		);

		$i	= 0;
		$tax_total	= 0;
		$prod_total	= 0;
		/*
		foreach ($this->_basket['contents'] as $hash => $item) {
			$product	= $GLOBALS['catalogue']->getProductData($item['id']);
			$price		= $item['total_price_each'];	## Always tax exclusive
			$GLOBALS['tax']->loadTaxes($this->_basket['delivery_address']['country_id']);
			$GLOBALS['tax']->productTax($price, $product['tax_type'], false, $this->_basket['delivery_address']['state_id']);
			$taxes		= $GLOBALS['tax']->fetchTaxAmounts();

			$tax_total	+= $prod_tax = $taxes['applied'];
			$prod_total	+= $price;

			$nvp_data	= array_merge(array(
				'L_NAME'.$i	=> $item['name'],
				'L_AMT'.$i	=> sprintf('%.2f', $price),
				'L_QTY'.$i	=> $item['quantity'],
				'L_TAX'.$i	=> sprintf('%.2f', $prod_tax),
			), $nvp_data);
			$i++;
		}
		*/
		$nvp_data	= array_merge(array(
			//'ITEMAMT'			=> $this->_basket['subtotal'],
			//'SHIPPINGAMT'		=> $this->_basket['shipping']['value'],
			//'TAXAMT'			=> $this->_basket['total_tax'],
			'ITEMAMT'			=> $this->_basket['total'],
			'AMT'				=> $this->_basket['total'],
		), $nvp_data);

		## PayPal's statistic tracking stuff
		switch (strtoupper($GLOBALS['config']->get('config','default_currency'))) {
			case 'CAD':
				$nvp_data['BUTTONSOURCE'] = 'CubeCart_Cart_EC_CA';
				break;
			case 'GBP':
				$nvp_data['BUTTONSOURCE'] = 'CubeCart_Cart_EC';
				break;
			case 'USD':
				$nvp_data['BUTTONSOURCE'] = 'CubeCart_Cart_EC_US';
				break;
		}
		if ($response = $this->nvp_request('DoExpressCheckoutPayment', $nvp_data)) {
			switch ($response['ACK']) {
				case 'SuccessWithWarning':
				case 'Success':
				#	$response	= $this->GetTransactionDetails($response['TRANSACTIONID']);
					break;
				case 'FailureWithWarning':
				case 'Failure':
					$GLOBALS['session']->delete('', 'PayPal_Pro');
					break;
			}
			return $response;
		}
		return false;
	}

	public function DoReauthorization($transaction_id = null, $amount = null) {
		## Reauthorize a payment
		if (!empty($transaction_id) && !empty($amount)) {
			$nvp_data	= array(
				'AUTHORIZATIONID'	=> $transaction_id,
				'AMT'				=> $amount,
				'CURRENCYCODE'		=> $GLOBALS['config']->get('config','default_currency'),
			);
		#	var_dump($nvp_data);
			if ($response = $this->nvp_request('DoReauthorization', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function DoVoid($void = null) {
		## Void an order or authorization
		if (!empty($void) && is_array($void)) {
			$nvp_data	= array(
				'AUTHORIZATIONID'	=> $void['transaction_id'],
				'NOTE'				=> $void['note'],
			);
			if ($response = $this->nvp_request('DoVoid', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function GetBalance() {
		## Obtain the available balance for a PayPal account
		if ($response = $this->nvp_request('GetBalance', array('RETURNALLCURRENCIES' => '1'))) {
			foreach ($response as $key => $value) {
				if (preg_match('#^L_CURRENCYCODE([0-9]+)#', $key, $match)) {
					$currency[$value]	= (float)$response['L_AMT'.$match[1]];
				}
			}
		#	var_dump($response);
			return (is_array($currency)) ? $currency : false;
		}
		return false;
	}

	public function GetExpressCheckoutDetails() {
		## Obtain information about an Express Checkout transaction
		if ($this->_token) {
			$nvp_data['TOKEN']	= $this->_token;
			if ($response = $this->nvp_request('GetExpressCheckoutDetails', $nvp_data)) {
				switch ($response['ACK']) {
					case 'SuccessWithWarning':
					case 'Success':
						// Disable recaptcha as PayPal human identity confirmed
						$recaptcha['confirmed'] = true;
						$GLOBALS['session']->set('', $recaptcha, 'recaptcha');
						return $response;
					case 'FailureWithWarning':
					case 'Failure':
						break;
				}
			}
		}
		return false;
	}

	public function GetTransactionDetails($transaction_id = null) {
		## Obtain information about a specific transaction
		if (!empty($transaction_id)) {
			$nvp_data	= array(
				'TRANSACTIONID'	=> $transaction_id
			);
			if ($response = $this->nvp_request('GetTransactionDetails', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function ManagePendingTransactionStatus($transaction_id = null, $accept = false) {
		## Accept or deny a payment held by the Fraud Management Filters
		if (!empty($transaction_id)) {
			$nvp_data	= array(
				'TRANSACTIONID'	=> $transaction_id,
				'ACTION'		=> ($accept) ? 'Accept' : 'Deny',
			);
			if ($response = $this->nvp_request('ManagePendingTransactionStatus', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function RefundTransaction($refund = null) {
		## Refund a transaction, ether partially, or in full
		if (!empty($refund) && is_array($refund)) {
			$nvp_data	= array(
				'TRANSACTIONID'	=> $refund['transaction_id'],
				'REFUNDTYPE'	=> $refund['type'],
				'AMT'			=> $refund['amount'],
				'NOTE'			=> $refund['note'],
			);
			if ($response = $this->nvp_request('RefundTransaction', $nvp_data)) {
				return $response;
			}
		}
		return false;
	}

	public function SetExpressCheckout() {
		## Initiates an Express Checkout transaction
		if (empty($this->_token)) {
			$nvp_data	= array(
				'PAYMENTACTION'	=> $this->_api_method,
				'RETURNURL'		=> $GLOBALS['storeURL'].'/index.php?_a=confirm',
				'CANCELURL'		=> $GLOBALS['storeURL'].'/index.php?_a=confirm&PPWPP=cancel',
				'CURRENCYCODE'	=> $GLOBALS['config']->get('config','default_currency'),
				'INVNUM'		=> $this->_basket['cart_order_id'],
			);
			## Billing information
			if ($billing = $this->_basket['billing_address']) {
				$nvp_data	= array_merge(array(
					'SALUTATION'		=> $billing['title'],
					'FIRSTNAME'			=> $billing['first_name'],
					'LASTNAME'			=> $billing['last_name'],
					'STREET'			=> $billing['line1'],
					'STREET2'			=> $billing['line2'],
					'CITY'				=> $billing['town'],
					'STATE'				=> $billing['state_abbrev'],
					'ZIP'				=> $billing['postcode'],
					'PHONENUM'			=> $billing['phone'],
					'COUNTRYCODE'		=> $billing['country_iso'],
					'CURRENCYCODE'		=> $GLOBALS['config']->get('config','default_currency'),
				), $nvp_data);
			}
			## Delivery information
			if (isset($this->_basket['delivery_address']['first_name']) && $delivery = $this->_basket['delivery_address']) {
				$nvp_data	= array_merge(array(
					'SHIPTONAME'	=> sprintf('%s %s', $delivery['first_name'], $delivery['last_name']),
					'SHIPTOSTREET'	=> $delivery['line1'],
					'SHIPTOSTREET2'	=> $delivery['line2'],
					'SHIPTOCITY'	=> $delivery['town'],
					'SHIPTOSTATE'	=> $delivery['state_abbrev'],
					'SHIPTOZIP'		=> $delivery['postcode'],
					'SHIPTOCOUNTRY'	=> $delivery['country_iso'],
					'SHIPTOPHONENUM'=> $billing['phone'], /* we don't have a delivery value for this */
					'ADDROVERRIDE'	=> '1',
				), $nvp_data);
			}

			## Add basket contents
			$i 			= 0;
			$tax_total	= 0;
			$prod_total	= 0;
			/* Fail fail fail 
			foreach ($this->_basket['contents'] as $hash => $item) {
				$product	= $GLOBALS['catalogue']->getProductData($item['id']);
				$price		= $item['total_price_each'];	## Always tax exclusive
				$GLOBALS['tax']->loadTaxes($this->_basket['delivery_address']['country_id']);
				$GLOBALS['tax']->productTax($price, $product['tax_type'], false, $this->_basket['delivery_address']['state_id']);
				$taxes		= $GLOBALS['tax']->fetchTaxAmounts();

				$tax_total	+= $prod_tax = $taxes['applied'];
				$prod_total	+= $price;

				$nvp_data	= array_merge(array(
					'L_NAME'.$i	=> $item['name'],
					'L_AMT'.$i	=> sprintf('%.2f', $price),
					'L_QTY'.$i	=> $item['quantity'],
					'L_TAX'.$i	=> sprintf('%.2f', $prod_tax),
				), $nvp_data);
				$i++;
			}
			*/

			//if (isset($this->_basket['shipping'])) {
			//	$nvp_data['SHIPPINGAMT']	= sprintf('%.2f', $this->_basket['shipping']['value']);
			//}
			$nvp_data	= array_merge(array(
				//'ITEMAMT'	=> sprintf('%.2f', $this->_basket['subtotal']),
				//'TAXAMT'	=> sprintf('%.2f', $this->_basket['total_tax']),
				'ITEMAMT'	=> sprintf('%.2f', $this->_basket['total']),
				'AMT'		=> sprintf('%.2f', $this->_basket['total']),
			), $nvp_data);
			if ($response = $this->nvp_request('SetExpressCheckout', $nvp_data)) {
				$this->update('CubeCart_order_summary', array('gateway' => 'PayPal_Pro'), array('cart_order_id' => $this->_basket['cart_order_id']));
				switch ($response['ACK']) {
					case 'SuccessWithWarning':
					case 'Success':
						$this->_token	= $response['TOKEN'];
						$GLOBALS['session']->set('token', $this->_token, 'PayPal_Pro');
						break;
					case 'FailureWithWarning':
					case 'Failure':
						$GLOBALS['gui']->setError($GLOBALS['language']->gui_message['error'].': '.$response['L_LONGMESSAGE0'].' '.$response['L_SHORTMESSAGE0']);
						return false;
						break;
				}
			}
		}
		$GLOBALS['session']->set('stage', 'GetExpressCheckoutDetails', 'PayPal_Pro');
		httpredir($this->_api_paypal_url.$this->_token);
	}

	################################################
	/* !Protected Methods */

	final protected function nvp_request($method_name = null, $nvp_data = array()) {
		if (!empty($method_name) && is_array($nvp_data)) {
			$nvp_basic	= array(
				'METHOD' 	=> $method_name,
				'VERSION'	=> $this->_api_version,
				'PWD'		=> $this->_api_password,
				'USER'		=> $this->_api_username,
				'SIGNATURE'	=> $this->_api_signature,
			);

			$nvp_data		= array_change_key_case($nvp_data, CASE_UPPER);
			$nvp_request	= http_build_query(array_merge($nvp_data, $nvp_basic), '', '&');

			## Send Request
			$request	= new Request($this->_api_endpoint);
			$request->setSSL();
			$request->setData($nvp_request);
			if ($nvp_response = $request->send()) {
				$response_array	= $this->nvp_decode($nvp_response);
				$request_array	= $this->nvp_decode($nvp_request);
				return array_change_key_case($response_array, CASE_UPPER);
			}
		}
		return false;
	}

	final protected function nvp_decode($nvp_string) {
		parse_str($nvp_string, $nvp_array);
		ksort($nvp_array);
		return $nvp_array;
	}

}


class CentinelClient {

	private $_parser	= false;
	private $_request	= false;
	private $_response	= false;
	private $_xml		= false;

	public function __construct($merchant_id = null, $transaction_pwd = null, $processor_id = null, $version = '1.7') {
		$this->_request	= array(
			'Version'			=> $version,
			'ProcessorId'		=> $processor_id,
			'MerchantId'		=> $merchant_id,
			'TransactionPwd'	=> $transaction_pwd,
		);
		$this->_xml = new XML(true);
		//$this->_xml->openMemory();
	}

	public function __destruct() {}

	## Public Methods

	public function add($name, $value = null) {
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->_request[$key] = $value;
			}
		} else {
			$this->_request[$name] = $value;
		}
	}

	public function getValue($name) {
		if (isset($this->_response[$name])) return $this->_response[$name];
		trigger_error(sprintf("Value '%s' does not exist.", $name), E_USER_WARNING);
		return null;
	}

	public function sendHttp($url, $connect_timeout = 5, $request_timeout = 10) {

		$data 		= $this->getRequestXml();
		$request	= new Request($url);
		$request->setSSL();
		$request->setData($data);
		$result		= $request->send();

		if (!$result) {
			$result = $this->setErrorResponse(8030, 'Communication timeout encountered.');
		} else if(!preg_match('/<CardinalMPI>/',$result)) {
			$result = $this->setErrorResponse(8010, 'Unable to communicate with MAPS server.');
		}

		if (!empty($result)) {
			try {
				$parser	= new SimpleXMLElement($result);
				foreach ($parser as $key => $value) {
					$this->_response[(string)$key] = (string)$value;
				}
				return $this->_response;
			} catch (Exception $e) {
				$this->_response['ErrorNo']		= 8020;
				$this->_response['ErrorDesc']	= 'Error parsing XML response.';
			}
		}
		return false;
	}

	## Private Methods

	private function getRequestXml() {
		$this->_xml->startElement('CardinalMPI');
		foreach ($this->_request as $name => $value) {
			if (is_numeric($value)) {
				$this->_xml->writeElement($name, $value);
			} else {
				$this->_xml->startElement($name);
				$this->_xml->writeCData($value);
				$this->_xml->endElement();
			}
		}
		$this->_xml->endElement();
		$data	= $this->_xml->getDocument();
		return 'cmpi_msg='.urlencode($data);
	}

	private function setErrorResponse($error_no, $error_desc) {
		$this->_xml->startElement('CardinalMPI');
		$this->_xml->writeElement('ErrorNo', $error_no);
		$this->_xml->writeElement('ErrorDesc', $error_desc);
		$this->_xml->endElement();
		return $this->_xml->getDocument();
	}

	private function escapeXML($value) {
		trigger_error(__CLASS__.'::'.__METHOD__.' is deprecated.', E_USER_WARNING);
		return $value;
	}
}