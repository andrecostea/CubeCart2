<?php
class Gateway {
	private $_module;
	private $_basket;

	public function __construct($module = false, $basket = false) {
		$this->_session	=& $GLOBALS['user'];

		$this->_module	= $module;
		$this->_basket =& $GLOBALS['cart']->basket;
	}

	##################################################

	public function transfer() {

		$formAction = ($this->_module['testMode']) ? "http://test.PayOffline.com/TestTrans/CubeCart.aspx" : "http://secure.PayOffline.com/CubeCart/Invoice.aspx";

		$transfer	= array(
			'action'	=> $formAction,
			'method'	=> 'post',
			'target'	=> '_self',
			'submit'	=> 'auto',
		);
		return $transfer;
	}

	public function repeatVariables() {

		return false;
	}

	public function fixedVariables() {

		if(!empty($orderSum['add_2'])){
			$add = $this->_basket['billing_address']['line1'].",&#10;".$this->_basket['billing_address']['line2'].",&#10;".$this->_basket['billing_address']['town'].", ".$orderSum['county'].",&#10;".$this->_basket['billing_address']['country_iso'];
		} else {
			$add = $this->_basket['billing_address']['line1'].",&#10;".$this->_basket['billing_address']['town'].",&#10;".$this->_basket['delivery_address']['state'].",&#10;".$this->_basket['billing_address']['country_iso'];
		}

		$hidden	= array(
			'instId'	=> $this->_module['merchKey'],
	        'sign'		=> md5($this->_module['merchKey'].$this->_basket['cart_order_id'].$this->_basket['total'].$this->_module['secretKey']),
			'cartId'	=> $this->_basket['cart_order_id'],
			'MC_OID'	=> $this->_basket['cart_order_id'],
			'amount'	=> $this->_basket['total'],
			'currency'	=> $GLOBALS['config']->get('config', 'default_currency'),
			'desc'		=> 'Cart - '.$this->_basket['cart_order_id'],
			'name'		=> $this->_basket['billing_address']['first_name']." ".$this->_basket['billing_address']['last_name'],
			'RetURL'	=> $GLOBALS['storeURL'].'/index.php?_a=vieworder&amp;cart_order_id='.$this->_basket['cart_order_id'],
			'storeurl'	=> $GLOBALS['storeURL'],
			'address'	=> $add,
			'postcode'	=> $this->_basket['billing_address']['postcode'],
			'country'	=> $this->_basket['billing_address']['country'],
			'tel'		=> $this->_basket['billing_address']['phone'],
			'email'		=> $this->_basket['billing_address']['email'],
		);
		if($this->_module['testMode']>0) {
			$hidden['testMode'] =  $this->_module['testMode'];
		}
		return $hidden;
	}

	##################################################

	public function call() {
		return false;
	}

	public function process() {
		return false;
	}

	public function form() {
		return false;
	}
}