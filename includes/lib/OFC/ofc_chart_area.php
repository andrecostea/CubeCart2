<?php
if(!defined('CC_DS')) die('Access Denied');
class area_base extends line
{
	public function __construct() {
		$this->type = 'area';
	}
	public function set_fill_colour($colour) {
		$this->fill = $colour;
	}
	public function fill_colour($colour) {
		$this->set_fill_colour($colour);
		return $this;
	}
	
}

class area_hollow extends area_base
{
	function __construct() {
		$this->type      = 'area_hollow';
		parent::area_base();
	}
}

class area_line extends area_base
{
	function __construct() {
		$this->type      = 'area_line';
		parent::area_base();
	}
}
