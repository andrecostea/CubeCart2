<?php
if(!defined('CC_DS')) die('Access Denied');
$amount 	= ($module['price_mode'] == 'subtotal') ? $this->_basket['subtotal'] : $this->_basket['total'];
$affCode	= sprintf('<!-- JAM tracking code --><img src="%s/sale.php?amount=%s&amp;trans_id=%s" height="0" width="0" border="0" />', $module['URL'], $amount, $this->_basket['cart_order_id']);
