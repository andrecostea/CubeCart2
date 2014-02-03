<?php
if(!defined('CC_DS')) die('Access Denied');
$amount = ($module['price_mode'] == 'subtotal') ? $this->_basket['subtotal'] : $this->_basket['total'];
$affCode = sprintf('<!-- clixGalore tracking code --><img src="https://www.clixgalore.com/AdvTransaction.aspx?AdID=%s&amp;SV=%s&amp;OID=%s" height="0" width="0" border="0" />', $module['acNo'], $amount, $this->_basket['cart_order_id']);
