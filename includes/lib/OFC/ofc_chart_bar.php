<?php
if(!defined('CC_DS')) die('Access Denied');
class bar_value extends ofc_common
{
	public function __construct($top, $bottom = null) {
		$this->top = $top;
		if (isset($bottom)) $this->bottom = $bottom;
	}
}

class bar_filled_value extends bar_value
{
	public function __construct($top, $bottom = null) {
		parent::__construct($top, $bottom);
	}
}

class bar_filled extends ofc_common
{
	public function __construct($colour = null, $outline_colour = null) {
		$this->type      = 'bar_filled';
		if (isset($colour)) $this->set_colour($colour);
		if (isset($outline_colour)) $this->set_outline_colour($outline_colour);
	}
}

class bar extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar';
	}
}

class bar_3d extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_3d';
	}
}
class bar_3d_value extends ofc_common
{
	public function __construct($top) {
		$this->top = $top;
	}
}
class bar_cylinder extends ofc_common
{
	public function __construct() {
		$this->type      = "bar_cylinder";
	}
}
class bar_cylinder_outline extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_cylinder_outline';
	}
}
class bar_dome extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_dome';
	}
}
class bar_glass extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_glass';
	}
}
class bar_round extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_round';
	}
}
class bar_round3d extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_round3d';
	}
}
class bar_rounded_glass extends ofc_common
{
	public function __construct() {
		$this->type      = 'bar_round_glass';
	}
}
class bar_sketch extends ofc_common
{
	public function __construct($colour, $outline_colour, $fun_factor) {
		$this->type		= 'bar_sketch';
		$this->set_colour($colour);
		$this->set_outline_colour($outline_colour);
		$this->offset	= $fun_factor;
	}
}
class bar_stack extends ofc_common
{
	public function _construct() {
		$this->type      = 'bar_stack';
	}
	public function append_stack($v) {
		$this->append_value($v);
	}
}

class bar_stack_value extends ofc_common
{
	public function __construct($val, $colour) {
		$this->val		= $val;
		$this->colour	= $colour;
	}
}

class bar_stack_key extends ofc_common
{
	public function __construct($colour, $text, $font_size) {
		$this->colour	= $colour;
		$this->text		= $text;
		$this->set_font_size($font_size);
	}
}

