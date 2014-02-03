<?php
if(!defined('CC_DS')) die('Access Denied');
class radar_axis extends ofc_common
{
	public function __construct($max) {
		$this->set_max($max);
	}
}

class radar_axis_labels extends ofc_common
{
	public function __construct($labels) {
		$this->labels = $labels;
	}
}


class radar_spoke_labels
{
	public function __construct($labels) {
		$this->labels = $labels;
	}
}