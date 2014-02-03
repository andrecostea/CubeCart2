<?php
if(!defined('CC_DS')) die('Access Denied');
class x_axis extends ofc_common
{
	public function set_colours($colour, $grid_colour) {
		$this->set_colour($colour);
		$this->set_grid_colour($grid_colour);
	}
	public function set_labels_from_array($a) {
		$x_axis_labels = new x_axis_labels();
		$x_axis_labels->set_labels($a);
		$this->labels = $x_axis_labels;
		if (isset($this->steps)) $x_axis_labels->set_steps($this->steps);
	}
}

class x_axis_labels extends ofc_common
{
	public function set_vertical() {
		$this->rotate = 270;
	}
	
	public function rotate($angle) {
		$this->rotate = $angle;
	}
}

class x_axis_label extends ofc_common
{
	public function __construct($text, $colour, $size, $rotate) {
		$this->set_text($text);
		$this->set_colour($colour);
		$this->set_size($size);
		$this->set_rotate($rotate);
	}
	function set_vertical() {
		$this->rotate	= 'vertical';
	}
}

class x_legend extends ofc_common
{
	public function __construct($text = '') {
		$this->text = $text;
	}
}