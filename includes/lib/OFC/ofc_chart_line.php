<?php
if(!defined('CC_DS')) die('Access Denied');
class line extends ofc_common
{
	public function __construct() {
		$this->type      = 'line';
		$this->values    = array();
	}
	public function set_default_dot_style($style) {
		$this->{'dot-style'} = $style;	
	}
	public function attach_to_right_y_axis() {
		$this->axis = 'right';
	}
}

class line_base extends ofc_common
{
	public function __construct() {
		$this->type      = 'line';
		$this->text      = 'Page views';
		$this->set_font_size(10);
		$this->values    = array();
	}
}

class dot_value extends ofc_common
{
	public function __construct($value, $colour) {
		$this->value = $value;
		$this->colour = $colour;
	}
}

class line_dot extends line_base
{
	public function __construct() {
		$this->type      = 'line_dot';
	}
}

class line_hollow extends line_base
{
	public function __construct() {
		$this->type      = 'line_hollow';
	}
}

class line_style extends ofc_common
{
	public function __construct($on, $off) {
		$this->style	= 'dash';
		$this->on		= $on;
		$this->off		= $off;
	}
}