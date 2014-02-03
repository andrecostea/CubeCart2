<?php
/**
 * CubeCart v5
 * ========================================
 * CubeCart is a registered trade mark of Devellion Limited
 * Copyright Devellion Limited 2010. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:			http://www.cubecart.com
 * Email:		sales@devellion.com
 * License:		http://www.cubecart.com/v5-software-license
 * ========================================
 * CubeCart is NOT Open Source.
 * Unauthorized reproduction is not allowed.
 */

/**
 * Module controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since 5.0.0
 */
class Module {
	/**
	 * Module settings
	 *
	 * @var array
	 */
	public 	$_settings;

	/**
	 * Module content
	 *
	 * @var string
	 */
	private $_content;
	/**
	 * Module info
	 *
	 * @var array
	 */
	private $_info			= false;
	/**
	 * Module local name
	 *
	 * @var string
	 */
	private $_local_name;
	/**
	 * Module name
	 *
	 * @var string
	 */
	private $_module_name;
	/**
	 * Module package file
	 *
	 * @var string
	 */
	private $_package_file	= 'package.conf.inc';
	/**
	 * Module config dile
	 *
	 * @var string
	 */
	private $_package_xml	= 'config.xml';
	/**
	 * Module path
	 *
	 * @var string
	 */
	private $_path;
	/**
	 * Module language strings
	 *
	 * @var array of strings
	 */
	private $_strings;
	/**
	 * Taxes
	 *
	 * @var array
	 */
	private $_taxes;
	/**
	 * Template to load in the module
	 *
	 * @var string
	 */
	private $_template;
	/**
	 * Template data
	 *
	 * @var array
	 */
	private $_template_data = array();

	#########################################

	public function __construct($path = false, $local_name = false, $template = 'index.tpl', $zones = false, $fetch = true) {
		$this->_template = $template;
		if ($path) {
			// Load Package info
			$this->_module_data($path, $local_name);
			// Include module classes
			$this->_module_classes();
			if (isset($_POST['module']['status']) && is_array($_POST['module'])) {
				// Automatically handle module save requests
				if ($this->module_settings_save($_POST['module'])) {
					$GLOBALS['main']->setACPNotify(sprintf($GLOBALS['language']->notification['notify_module_settings'], $this->_info['name'] ? $this->_info['name'] : $this->_settings['folder']));
				} else {
					$GLOBALS['main']->setACPWarning(sprintf($GLOBALS['language']->notification['error_module_settings'], $this->_info['name'] ? $this->_info['name'] : $this->_settings['folder']));
				}
				$this->_module_data($path, $local_name);
				// Install hooks if required
				if($_POST['module']['status']) {
					$GLOBALS['hooks']->install($this->_module_name);
				} else {
					$GLOBALS['hooks']->uninstall($this->_module_name);
				}

			}
			// Add default tab
			$GLOBALS['main']->addTabControl($GLOBALS['language']->common['general'], $this->_module_name);

			// Include module language strings - use Language class
			$GLOBALS['language']->loadDefinitions($this->_module_name, $this->_path.CC_DS.'language', 'module.definitions.xml');
			// Load other lang either customized ones
			$GLOBALS['language']->loadLanguageXML($this->_module_name, '', $this->_path.CC_DS.'language');

			// Enable this class as an ACP interface
			if ($template) {
				$GLOBALS['gui']->changeTemplateDir($this->_path.'/skin');
				$module_lang_node = str_replace('_', '', strtolower($this->_module_name));
				$lang = $GLOBALS['language']->getStrings($module_lang_node);
				$GLOBALS['smarty']->assign('TITLE', $this->module_fetch_logo($this->_info['type'], $this->_module_name, $lang['module_title']));

				// Get tax types for modules drop down box
				if (($this->_taxes = $GLOBALS['db']->select('CubeCart_tax_class', array('id','tax_name'), false, array('tax_name' => 'ASC'))) !== false) {
					foreach ($this->_taxes as $tax) {
						$tax['selected'] = (isset($this->_settings['tax']) && $this->_settings['tax'] == $tax['id']) ? "selected='selected'" : "";
						$taxes[] = $tax;
					}
					$GLOBALS['smarty']->assign('TAXES', $taxes);
				}

				// Assign settings
				if (!empty($this->_settings)) {
					$GLOBALS['debug']->debugTail($this->_settings, $this->_module_name.': settings');

					if ($this->_info['type'] == 'gateway') {
						$this->_settings['processURL'] 	= $this->communicateURL('process');
						$this->_settings['callURL'] 	= $this->communicateURL('call');
						$this->_settings['fromURL'] 	= $this->communicateURL('from');
					}
					// Allow for 3d arrays, key is subsistuted after MODULE_ in upper case
					foreach($this->_settings as $key => $value) {
						if (is_array($value)) {
							$GLOBALS['smarty']->assign('MODULE_'.strtoupper($key), $value);
						} else {
							$basesettings[$key] = $value;
						}
					}
					$GLOBALS['smarty']->assign('MODULE', $basesettings);
					// Assign checked & selects
					if (is_array($this->_settings)) {
						foreach ($this->_settings as $setting => $value) {
							$value = str_replace(array('.','-'),'_',$value);
							$GLOBALS['smarty']->assign('SELECT_'.$setting.'_'.$value, 'selected="selected"');
							$GLOBALS['smarty']->assign('CHECKED_'.$setting.'_'.$value, 'checked="checked"');
						}
					}
				}
				// Assign config settings regardless
				$GLOBALS['smarty']->assign('CONFIG', $GLOBALS['config']->get('config'));
				// Zone selector
				if ($zones) {
					$this->_module_zones();
					$GLOBALS['gui']->changeTemplateDir($this->_path.'/skin');
				}
				$GLOBALS['language']->setTemplate();

				if($fetch) {
					$this->fetch();
				}
			}
		}
		return false;
	}

	/**
	 * Get a module value
	 *
	 * @param string $key
	 * @return string
	 */
	public function __get($key) {
		return (array_key_exists($key, $this->_settings)) ? $this->_settings[$key] : false;
	}

	/**
	 * Assign data to the template
	 *
	 * @param string $name
	 * @param string $value
	 * @return bool
	 */
	public function assign_to_template($name, $value=null) {
		if (is_array($name)) {
			foreach($name as $key => $value) {
				$this->_template_data[$key] = $value;
			}
		} elseif(!empty($name) && !is_null($value)) {
			$this->_template_data[$name] = $value;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Generate URL
	 *
	 * @param string $method
	 * @return string
	 */
	public function communicateURL($method = 'process'){
		// SSL is preferred
		if($method == 'from') {
			return $GLOBALS['storeURL'].'/index.php?_a=gateway';
		} else {
			return $GLOBALS['storeURL'].'/index.php?_g=rm&amp;type='.$this->_info['type'].'&amp;cmd='.$method.'&amp;module='.$this->_module_name;
		}
	}

	/**
	 * Display module content
	 *
	 * @param bool $return
	 * @return string
	 */
	public function display($return = true) {
		if ($return) {
			return $this->_content;
		} else {
			echo $this->_content;
		}
	}

	/**
	 * Send template date to the screen
	 */
	public function fetch() {
		if(!empty($this->_template_data)) {
			foreach($this->_template_data as $key => $value) {
				$GLOBALS['smarty']->assign($key, $value);
			}
		}
		$this->_content = $GLOBALS['smarty']->fetch($this->_template);
		$GLOBALS['gui']->changeTemplateDir();
	}

	/**
	 * Get module logo
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $module_title
	 * @return string
	 */
	public function module_fetch_logo($type, $name, $module_title = '') {
		$images	= glob(CC_ROOT_DIR.CC_DS.'modules'.CC_DS.$type.CC_DS.$name.CC_DS.'admin'.CC_DS.'logo.{gif,jpg,png}', GLOB_BRACE);
		// $name is the module folder name, $module_title is the title set in the module lang file which is preferable
		if (is_array($images) && isset($images[0])) {
			$title = (empty($module_title)) ? $name : $module_title;
			return '<img src="modules/'.$type.'/'.$name.'/admin/'.basename($images[0]).'" alt="'.$title.'" title="'.$title.'" />';
		} elseif(!empty($module_title)) {
			return $module_title;
		} else {
			return str_replace('_', ' ', $name);
		}
	}

	/**
	 * Get module language strings
	 *
	 * @return array of strings
	 */
	public function module_language() {
		return $this->_strings;
	}

	/**
	 * Get module name
	 *
	 * @param string $module_name
	 * @return string
	 */
	public static function module_name(&$module_name) {
		$module_name = preg_replace('#[^\w\-]#iU', '_', (string)$module_name);
		return $module_name;
	}

	/**
	 * Save module settings
	 *
	 * @param array $settings
	 * @return bool
	 */
	public function module_settings_save($settings) {
		if (!empty($settings) && is_array($settings)) {
			$updated = false;

			$settings['countries'] 			= $this->module_fetch_zones('zones');
			$settings['disabled_countries'] = $this->module_fetch_zones('disabled_zones');
			$data = array(
				'status'	=> $settings['status'],
				'default'	=> $settings['default'],
				'position'	=> (isset($settings['position']) && $settings['position'] > 0) ? $settings['position'] : 0,
			);
			unset($settings['status'], $settings['default']);
			if ($GLOBALS['config']->set($this->_local_name, '', $settings)) {
				$updated = true;
			}
			if (isset($settings['default']) && $settings['default']) {
				// If this is to be set as default then the others need to be unset
				if($GLOBALS['db']->update('CubeCart_modules', array('default' => 0), array('module' => $this->_info['type']))) {
					$updated = true;
				}
			}
			// Check if a record already exists
			if (($state = $GLOBALS['db']->select('CubeCart_modules', array('module_id'), array('module' => $this->_info['type'], 'folder' => $this->_local_name))) !== false) {
				if ($GLOBALS['db']->update('CubeCart_modules', $data, array('module_id' => $state[0]['module_id']))) {
					$updated = true;
				}
			} else {
				$data['folder']	= $this->_local_name;
				$data['module']	= $this->_info['type'];
				if($GLOBALS['db']->insert('CubeCart_modules', $data)) {
					$updated = true;
				}
			}
			return $updated;
		}
		return false;
	}
	public function module_fetch_zones($label) {

		if (!isset($_POST[$label]) || !is_array($_POST[$label])) return '';
		
		foreach ($_POST[$label] as $zone) {
			if (!empty($zone)) $zones[] = $zone;
		}
		return (isset($zones)) ? serialize($zones) : '';
	}


	/**
	 * Load module classes
	 *
	 * @return bool
	 */
	private function _module_classes() {
		// Include all classes for the module
		if (is_dir($this->_path.CC_DS.'classes')) {
			foreach (glob($this->_path.CC_DS.'classes'.DIRECTORY_SEPARATOR.'*.inc.php', GLOB_NOSORT) as $include) {
				if (!is_dir($include)) {
					require $include;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Get module data
	 *
	 * @param string $path
	 * @param string $local_name
	 */
	private function _module_data($path = false, $local_name = false) {
		// Set Module Path
		if ($path) {
			$drop = array('admin', 'classes', 'skin', 'language');
			$this->_path = CC_ROOT_DIR.str_replace($drop, '', dirname(str_replace(CC_ROOT_DIR,'',$path)));
			// Drop trailing slashes
			if (substr($this->_path, -1) == CC_DS) {
				$this->_path = substr($this->_path, 0, -1);
			}
		}
		// Load package configuration data
		if (file_exists($this->_path.CC_DS.$this->_package_xml)) {
			$xml = new SimpleXMLElement(file_get_contents($this->_path.CC_DS.$this->_package_xml, true));
			## Parse and handle XML data
			foreach ((array)$xml->info as $key => $value) {
				$this->_info[$key]	= (string)$value;
			}
			//$this->_module_name = (isset($this->_info['folder']) && !empty($this->_info['folder'])) ? $this->_info['folder'] : str_replace(' ', '_', $this->_info['name']);
		} else if (file_exists($this->_path.CC_DS.$this->_package_file)) {
			$this->_info		= unserialize(file_get_contents($this->_path.CC_DS.$this->_package_file, true));
			//$this->_module_name = str_replace(' ', '_', $this->_info['name']);
		} else {
			$pathFolders = explode(CC_DS, $this->_path);
			$noFolders = count($pathFolders);
			$this->_info['type'] = $pathFolders[($noFolders-2)];
			//$this->_module_name = $pathFolders[($noFolders-1)];
		}

		$this->_module_name = str_replace(' ', '_', $local_name);
		$this->_local_name		= ($local_name) ? $local_name : $this->_module_name;

		// Load module configuration
		if (!empty($this->_module_name)) {
			$config	= $GLOBALS['config']->get($this->_local_name);
			$module	= $GLOBALS['db']->select('CubeCart_modules', false, array('folder' => $this->_module_name));
			unset($config['status'], $config['default']);
			$this->_settings = ($module) ? array_merge($module[0], $config) : $config;
		}
	}

	/**
	 * Load module zones
	 */
	private function _module_zones() {
		if (($countries = $GLOBALS['db']->select('CubeCart_geo_country', array('numcode', 'name'), false, array('name' => 'ASC'))) !== false) {
			$enabled = (!empty($this->_settings['countries'])) ? unserialize($this->_settings['countries']) : false;
			foreach ($countries as $country) {
				$options[$country['numcode']] = $country;
				$all_countries[] = $country;
			}

			$GLOBALS['smarty']->assign('ALL_COUNTRIES', $all_countries);
			if (is_array($enabled)) {
				sort($enabled);
				foreach ($enabled as $country) {
					$enabled_countries[] = $options[$country];
				}
				$GLOBALS['smarty']->assign('ENABLED_COUNTRIES', $enabled_countries);
			}

			$GLOBALS['main']->addTabControl($GLOBALS['language']->settings['allowed_zones'], 'zone-list');
			$GLOBALS['gui']->changeTemplateDir();
			$GLOBALS['smarty']->assign('LANG', $GLOBALS['lang']);
			$zone_tabs = $GLOBALS['smarty']->fetch('templates/modules.zones.php');

			$disabled = (!empty($this->_settings['disabled_countries'])) ? unserialize($this->_settings['disabled_countries']) : false;

			if (is_array($disabled)) {
				sort($disabled);
				foreach ($disabled as $country) {
					$disabled_countries[] = $options[$country];
				}
				$GLOBALS['smarty']->assign('DISABLED_COUNTRIES', $disabled_countries);
			}

			$GLOBALS['main']->addTabControl($GLOBALS['language']->settings['disabled_zones'], 'disabled-zone-list');
			$zone_tabs .= $GLOBALS['smarty']->fetch('templates/modules.zones-disabled.php');

			$GLOBALS['smarty']->assign('MODULE_ZONES', $zone_tabs);
		}
	}
}