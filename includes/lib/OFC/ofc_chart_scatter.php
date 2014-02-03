<?php
if(!defined('CC_DS')) die('Access Denied');
class scatter_value extends ofc_common
{
	public function __construct($x, $y, $dot_size = -1) {
		$this->x = $x;
		$this->y = $y;
		if ($dot_size > 0) $this->{'dot-size'} = $dot_size;
	}
}

class scatter extends ofc_common
{
	public function __construct($colour) {
		$this->type      = 'scatter';
		$this->set_colour($colour);
	}
	public function set_default_dot_style($style) {
		$this->set_dot_style($style);
	}
}


class scatter_line extends ofc_common
{
	public function __construct($colour) {
		$this->type      = 'scatter_line';
		$this->set_colour($colour);
	}
	public function set_default_dot_style($style) {
		$this->{'dot-style'} = $style;	
	}
	
	public function set_step_horizontal() {
		$this->stepgraph = 'horizontal';
	}
	public function set_step_vertical() {
		$this->stepgraph = 'vertical';
	}
	public function set_key($text, $font_size) {
		$this->text      = $text;
		$this->{'font-size'} = $font_size;
	}
}