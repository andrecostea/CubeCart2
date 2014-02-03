<?php
class ofc_common {
	
	private $_variables;
	
	public function __construct($text = '') {
		if (!empty($text)) $this->text = $text;
	}
	
	########################################
	## Use PHP5 Overloading - replaces most of the methods
	
	public function __call($name, $args) {
		if (preg_match('#^set\_([\w]+)$#', $name, $match)) {
			$key		= str_replace('_', '-', $match[1]);
			$this->$key	= $args[0];
		}
		return $this;
	}
	
	########################################
	
	public function append_value($v) {
		$this->values[] = $v;       
	}
	public function halo_size($size) {
		$this->set_halo_size($size);
		return $this;
	}
	public function key($text, $size) {
		$this->set_key($text, $size);
	}
	public function loop() {
		$this->loop	= true;
	}
	public function position($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}
	public function set_loop() {
		$this->loop();
	}
	public function set_range($min, $max, $steps = 1) {
		$this->min = $min;
		$this->max = $max;
		$this->set_steps($steps);
	}
	public function rotation($angle) {
		$this->rotation = $angle;
		return $this;
	}
	public function set_key($text, $size) {
		$this->text = $text;
		$this->{'font-size'} = $size;
	}
	public function set_tooltip($tip) {
		$this->tip = $tip;
	}
	public function tooltip($tip) {
		$this->set_tooltip($tip);
		return $this;
	}
	protected function type($type) {
		$this->type = $type;
		return $this;
	}
}