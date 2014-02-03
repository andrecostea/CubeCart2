<?php
if(!defined('CC_DS')) die('Access Denied');
class pie_value extends ofc_common
{
	public function __construct($value, $label) {
		$this->value = $value;
		$this->label = $label;
	}
	
	public function set_label($label, $label_colour, $font_size) {
		$this->label = $label;
		$this->set_label_colour($label_colour);
		$this->set_font_size($font_size);
	}
	
	/**
	 * An object that inherits from base_pie_animation
	 */
	public function add_animation($animation) {
		if (!isset($this->animate)) $this->animate = array();
		$this->animate[] = $animation;
		return $this;
	}
}

class base_pie_animation extends ofc_common {}

class pie_fade extends base_pie_animation
{
	public function __construct() {
		$this->type	= 'fade';
	}
}
class pie_bounce extends base_pie_animation
{
	public function __construct($distance) {
		$this->type		= 'bounce';
		$this->distance	= $distance;
	}
}

class pie extends ofc_common
{
	public function __construct() {
		$this->type	= 'pie';
	}
	
	public function add_animation($animation) {
		if (!isset($this->animate)) $this->animate = array();
		$this->animate[] = $animation;
		return $this;
	}
	public function alpha($alpha) {
		$this->set_alpha( $alpha );
		return $this;
	}
	public function colours($colours) {
		$this->set_colours($colours);
		return $this;
	}
	public function gradient_fill() {
		$this->set_gradient_fill();
		return $this;
	}
	public function label_colour($label_colour) {
		$this->set_label_colour($label_colour);
		return $this;
	}
	public function radius($radius) {
		$this->set_radius($radius);
		return $this;
	}
	public function set_animate($bool) {
		if ($bool) $this->add_animation(new pie_fade());
	}
	public function start_angle($angle) {
		$this->set_start_angle($angle);
		return $this;
	}
	public function values($v) {
		$this->set_values($v);
		return $this;
	}
	
	
}
