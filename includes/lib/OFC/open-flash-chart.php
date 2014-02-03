<?php
require 'ofc_common.php';

require 'ofc_axis_x.php';
require 'ofc_axis_y.php';

require 'ofc_chart_line.php';
require 'ofc_chart_area.php';
require 'ofc_chart_bar.php';
require 'ofc_chart_hbar.php';

require 'ofc_chart_pie.php';
require 'ofc_chart_radar.php';
require 'ofc_chart_scatter.php';

class open_flash_chart extends ofc_common
{
	public function __construct() {
		$this->elements = array();
	}
	public function add_element($e) {
		$this->elements[] = $e;
	}
	public function add_y_axis($y) {
		$this->y_axis = $y;
	}
	public function set_bg_colour($colour) {
		$this->bg_colour = $colour;	
	}
	public function set_radar_axis($radar) {
		$this->radar_axis = $radar;
	}
	public function set_x_axis($x) {
		$this->x_axis = $x;	
	}
	public function set_x_legend($x) {
		$this->x_legend = $x;
	}
	public function set_y_axis($y) {
		$this->y_axis = $y;
	}
	public function set_y_axis_right($y) {
		$this->y_axis_right = $y;
	}
	public function set_y_legend($y) {
		$this->y_legend = $y;
	}
	
	/**
	 * This is a bit funky :(
	 *
	 * @param $num_decimals as integer. Truncate the decimals to $num_decimals, e.g. set it
	 * to 5 and 3.333333333 will display as 3.33333. 2.0 will display as 2 (or 2.00000 - see below)
	 * @param $is_fixed_num_decimals_forced as boolean. If true it will pad the decimals.
	 * @param $is_decimal_separator_comma as boolean
	 * @param $is_thousand_separator_disabled as boolean
	 *
	 * This needs a bit of love and attention
	 */
	public function set_number_format($num_decimals = 2, $is_fixed_num_decimals_forced, $is_decimal_separator_comma, $is_thousand_separator_disabled) {
		$this->num_decimals						= (int)$num_decimals;
		$this->is_fixed_num_decimals_forced		= (bool)$is_fixed_num_decimals_forced;
		$this->is_decimal_separator_comma		= (bool)$is_decimal_separator_comma;
		$this->is_thousand_separator_disabled	= (bool)$is_thousand_separator_disabled;
	}
	
	/**
	 * This is experimental and will change as we make it work
	 * 
	 * @param $m as ofc_menu
	 */
	public function set_menu($m)
	{
		$this->menu = $m;
	}
	
	public function toString() {
		return json_encode($this);
	}
	public function toPrettyString() {
		return json_format($this->toString());
	}
}

class OFC extends open_flash_chart {}

class title extends ofc_common
{
	public function __construct($text = '') {
		$this->text = $text;
	}
}

class tooltip extends ofc_common
{
	function set_background_colour($bg) {
		$this->background = $bg;
	}
	function set_title_style($style) {
		$this->title = $style;
	}
    function set_body_style($style) {
		$this->body = $style;
	}
	function set_proximity() {
		$this->mouse = 1;
	}
	function set_hover() {
		$this->mouse = 2;
	}
}

class shape_point extends ofc_common
{
	public function __construct($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}
}

class shape extends ofc_common
{
	public function __construct($colour) {
		$this->type		= 'shape';
		$this->colour	= $colour;
		$this->values	= array();
	}
}

class ofc_menu_item extends ofc_common
{
	public function __construct($text, $javascript_function_name) {
		$this->type	= 'text';
		$this->text	= $text;
		$this->{'javascript-function'} = $javascript_function_name;
	}
}

class ofc_menu_item_camera extends ofc_common
{
	/**
	 * @param $text as string. The menu item text.
	 * @param $javascript_function_name as string. The javascript function name, the
	 * js function takes one parameter, the chart ID. So for example, our js function
	 * could look like this:
	 *
	 * function save_image( chart_id )
	 * {
	 *     alert( chart_id );
	 * }
	 *
	 * to make a menu item call this: ofc_menu_item_camera('Save chart', 'save_image');
	 */
	public function __construct($text, $javascript_function_name) {
		$this->type	= 'camera-icon';
		$this->text = $text;
		$this->{'javascript-function'} = $javascript_function_name;
	}
}

class ofc_menu extends ofc_common
{
	public function __construct($colour, $outline_colour) {
		$this->colour			= $colour;
		$this->outline_colour	= $outline_colour;
	}
	
	public function values($values) {
		$this->values = $values;
	}
}

class dot_base extends ofc_common
{
	public function __construct($type, $value = null) {
		$this->type = $type;
		if (isset($value)) $this->value($value);
	}
	public function value($value) {
		$this->value = $value;
	}
	public function colour($colour) {
		$this->colour = $colour;
		return $this;
	}
	public function size($size) {
		$this->{'dot-size'} = (int)$size;
		return $this;
	}
	public function type($type) {
		$this->type = $type;
		return $this;
	}
}

class anchor extends dot_base
{
	public function __construct($value = null) {
		parent::__construct('anchor', $value);
	}
	public function sides($sides) {
		$this->sides = $sides;
		return $this;
	}
}
class bow extends dot_base
{
	public function __construct($value = null) {
		parent::__construct('bow', $value);
	}
}
class dot extends dot_base
{
	function __construct($value = null) {
		parent::__construct('dot', $value);
	}
}
class hollow_dot extends dot_base
{	
	public function __construct($value = null) {
		parent::__constuct('hollow-dot', $value);
	}
}
class solid_dot extends dot_base
{
	function __construct($value = null) {
		parent::__construct('solid-dot', $value);
	}
}
class star extends dot_base
{
	public function __construct($value = null) {
		parent::__construct('star', $value);
	}
	public function hollow($is_hollow) {
		$this->hollow = $is_hollow;
	}
}
