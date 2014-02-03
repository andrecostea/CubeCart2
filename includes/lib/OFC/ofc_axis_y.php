<?php
if(!defined('CC_DS')) die('Access Denied');
class y_axis extends ofc_common
{
	public function set_colours($colour, $grid_colour) {
		$this->set_colour($colour);
		$this->set_grid_colour($grid_colour);
	}
	public function set_label_text($text) {
		$tmp = new y_axis_labels();
		$tmp->set_text($text);
		$this->labels = $tmp;
	}
	public function set_vertical() {
		$this->rotate = 'vertical';
	}
}

class y_axis_labels extends ofc_common {}
class y_axis_right extends ofc_common {}

class y_legend extends ofc_common
{
	public function __construct($text = '') {
		$this->text = $text;
	}
}