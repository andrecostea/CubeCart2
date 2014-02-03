<?php
if(!defined('CC_DS')) die('Access Denied');
class hbar_value extends ofc_common
{
	public function __construct($left, $right = null) {
		if (isset($right)) {
			$this->left		= $left;
			$this->right	= $right;
		} else {
			$this->right	= $left;
		}
	}
}

class hbar extends ofc_common
{
	public function __construct($colour) {
		$this->type      = 'hbar';
		$this->values    = array();
		$this->set_colour( $colour );
	}
	public function set_values($v) {
		foreach ($v as $val) {
			$this->append_value(new hbar_value($val));
		}
	}
}

