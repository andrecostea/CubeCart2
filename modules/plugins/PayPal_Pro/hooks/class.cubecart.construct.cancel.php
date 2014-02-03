<?php
if(!defined('CC_DS')) die('Access Denied');
unset($this->_basket['PayPal_Pro']);
httpredir('index.php?_a=basket');
