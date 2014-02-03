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
 * ACP controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since 5.0.0
 */
class ACP {

	/**
	 * Hide navigation on the admin screen
	 *
	 * @var bool
	 */
	private $_hide_navigation	= false;
	/**
	 * Navigation
	 *
	 * @var array
	 */
	private $_navigation		= array();
	/**
	 * Tabs
	 *
	 * @var array
	 */
	private $_tabs				= array();
	/**
	 * Wiki namespace
	 *
	 * @var string
	 */
	private $_wiki_namespace	= 'ACP';
	/**
	 * Wiki page
	 *
	 * @var string
	 */
	private $_wiki_page			= null;

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	final private function __construct() {
	}

	/**
	 * Setup the instance (singleton)
	 *
	 * @return ACP
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}

	//=====[ Public ]====================================================================================================

	/**
	 * Add a admin navigation item
	 *
	 * @param string $group
	 * @param array $array (name => url)
	 */
	public function addNavItem($group, $array) {
		if (!empty($array)) {
			foreach ($array as $name => $url) {
				$this->_navigation[$group][] = array(
					'name'	=> strip_tags($name),
					'url'	=> $url,
				);
			}
		}
	}

	/**
	 * Add a tab control
	 *
	 * @param string $name
	 * @param string $target
	 * @param string $url
	 * @param string $accesskey
	 * @param string $notify_count
	 * @return bool
	 */
	public function addTabControl($name, $target = '', $url = null, $accesskey = null, $notify_count = false) {
		if (!empty($name)) {
			$url = (!empty($url) && is_array($url)) ? currentPage(null, $url) : $url;
			$this->_tabs[] = array(
				'name'		=> $name,
				'target'	=> $target,
				'url'		=> preg_replace('/(#.*)$/i', '', $url),
				'accesskey'	=> $accesskey,
				'notify'	=> $notify_count,
			);
			return true;
		}
		return false;
	}
	
	/**
	* Remove tab control
	*
	* @param string $name
	* @return self
	*/
	
	public function removeTabControl($name) {
		if (!empty($name)) {
			foreach($this->_tabs as $key => $tab) {
				if ( $tab['name'] == $name ) {
					unset($this->_tabs[$key]);
				}
			}
		}
		return $this;
	}

	/**
	 * Log admin message
	 *
	 * @param string $message
	 */
	public function adminLog($message) {
		if (!empty($message)) {
			$record	= array(
				'admin_id'		=> Admin::getInstance()->getId(),
				'ip_address'	=> get_ip_address(),
				'time'			=> time(),
				'description'	=> $message,
			);
			$GLOBALS['db']->insert('CubeCart_admin_log', $record);
		}
	}

	/**
	 * Get category path
	 *
	 * @param int $cat_id
	 * @param int $i
	 * @return data/false
	 */
	public function getCategoryPath($cat_id, $i = 0) {
		// get the path for a single category
		if (is_int($cat_id) ) {
			if (($parent = $GLOBALS['db']->select('CubeCart_category', array('cat_id', 'cat_parent_id', 'cat_name'), array('cat_id' => $cat_id))) !== false) {
				$data[$i] = $parent[0];
				if (((int)$parent[0]['cat_parent_id']) != 0) {
					++$i;
					$data = array_merge($data, $this->getCategoryPath($parent[0]['cat_parent_id'], $i));
				}
				sort($data);
				return $data;
			}
		}
		return false;
	}

	/**
	 * Hide admin navigation
	 *
	 * @param bool $status
	 */
	public function hideNavigation($status = false) {
		$this->_hide_navigation = (bool)$status;
	}

	/**
	 * Import admin node
	 *
	 * @param string $request
	 * @param string $node
	 * @return string
	 */
	public function importNode($request, $node = false) {
		$base = CC_ROOT_DIR.CC_DS.$GLOBALS['config']->get('config', 'adminFolder').CC_DS.'sources'.CC_DS;
		$node = (!empty($node)) ? $node : 'index';

		$source	= implode('.', array($request, $node, 'inc.php'));
		if (file_exists($base.$source)) {
			return $base.$source;
		} else {
			if (!is_dir($base.$request) && file_exists($base.$request.'inc.php')) {
				$source	= CC_ROOT_DIR.CC_DS.$GLOBALS['config']->get('config', 'adminFolder').CC_DS.'sources'.CC_DS.$request.'.inc.php';
			} else {
				$source	= CC_ROOT_DIR.CC_DS.$GLOBALS['config']->get('config', 'adminFolder').CC_DS.'sources'.CC_DS.$request.CC_DS.$node.'.inc.php';
			}
			trigger_error($request.'/'.$node.' needs to be updated.', E_USER_NOTICE);
			return $source;
		}
	}

	/**
	 * Set admin warning
	 *
	 * @param string $message
	 */
	public function setACPWarning($message, $show_once = false, $display = true) {
		if(empty($message)) {
			return;
		}
		// Log message and don't show again to current staff member
		if($show_once) {
			if(!$GLOBALS['db']->select('CubeCart_admin_error_log', 'log_id', array('message' => $message, 'admin_id' => Admin::getInstance()->get('admin_id')))) {
				$GLOBALS['db']->insert('CubeCart_admin_error_log', array('message' => $message, 'admin_id' => Admin::getInstance()->get('admin_id'), 'time' => time()));
				if($display) {
					$GLOBALS['gui']->setError($message);
				}
			}
		}  else if($display) {
			$GLOBALS['gui']->setError($message);
		}
	}

	/**
	 * Set admin warning
	 *
	 * @param string $message
	 */
	public function setACPNotify($message) {
		$GLOBALS['gui']->setNotify($message);
		// Add record to admin log
		$this->adminLog($message);
	}

	/**
	 * Setup admin data
	 */
	public function setTemplate() {
		if (Admin::getInstance()->is()) {
			$GLOBALS['smarty']->assign('ADMIN_USER', strip_tags(Admin::getInstance()->get('name')));
			$GLOBALS['smarty']->assign('ADMIN_UID', Admin::getInstance()->getId());
		}
	}

	/**
	 * Show help
	 */
	public function showHelp() {
		if (Admin::getInstance()->is()) {
			if (empty($this->_wiki_page)) {
				if (isset($_GET['_g']) && !empty($_GET['_g'])) {
					$pages[] = $_GET['_g'];
					if (isset($_GET['node']) && !empty($_GET['node']) && strtolower($_GET['node']) != 'index') {
						$pages[] = $_GET['node'];
					}
					if (isset($_GET['action']) && !empty($_GET['action'])) {
						$pages[] = $_GET['action'];
					}
					$this->_wiki_page = implode(' ', $pages);
				}
			}

			$this->_wiki_page = preg_replace('#\W#', '_', ucwords($this->_wiki_page));
			$page = (!empty($this->_wiki_namespace)) ? ucfirst($this->_wiki_namespace).':'.$this->_wiki_page : $this->_wiki_page;
			// Assign and Parse
			$GLOBALS['smarty']->assign('HELP_URL', 'http://helpdocs.info/'.$page.'?useskin=chick');
			$GLOBALS['smarty']->assign('STORE_STATUS', !(bool)$GLOBALS['config']->get('config', 'offline'));
		}
	}

	/**
	 * Show admin navigation
	 *
	 * @return bool
	 */
	public function showNavigation() {
		if (Admin::getInstance()->is() && is_array($this->_navigation) && !$this->_hide_navigation) {
			//Try cache first
			$admin_session_language = Admin::getInstance()->get('language');
			if (($navigation = $GLOBALS['cache']->read('acp.showNavigation.'.$admin_session_language)) === false) {
				foreach ($this->_navigation as $group => $menu) {
					$item = array(
						'title'	=> $group,
						'group'	=> str_replace(' ', '_', $group)
					);
					foreach ($menu as $submenu) {
						$item['members'][] = array(
							'title'	=> ucwords($submenu['name']),
							'url'	=> $submenu['url'],
						);
					}
					$navigation[] = $item;
				}
				$GLOBALS['cache']->write($navigation, 'acp.showNavigation');
			}
			$GLOBALS['smarty']->assign('NAVIGATION', $navigation);
			return true;
		}
		return false;
	}

	/**
	 * Show admin tabs
	 *
	 * @return bool
	 */
	public function showTabs() {
		if (Admin::getInstance()->is() && !empty($this->_tabs) && is_array($this->_tabs)) {
			foreach ($this->_tabs as $tab) {
				$tab['name']	= ucwords($tab['name']);
				$tab['tab_id']	= 'tab_'.str_replace(' ', '_', $tab['target']);
				$tab['target']	= (!empty($tab['target'])) ? '#'.$tab['target'] : '';
				$tabs[]	= $tab;
			}
			foreach ($GLOBALS['hooks']->load('admin.tabs') as $hook) include $hook;
			$GLOBALS['smarty']->assign('TABS', $tabs);
			return true;
		}
		return false;
	}

	/**
	 * Setup wiki
	 *
	 * @param string $ns
	 * @param string $page
	 */
	public function wiki($ns = null, $page = null) {
		$this->wikiNamespace($ns);
		$this->wikiPage($page);
	}

	/**
	 * Setup wiki namespace
	 *
	 * @param string $ns
	 */
	public function wikiNamespace($ns) {
		if (!empty($ns)) {
			$this->_wiki_namespace = ucfirst($ns);
		}
	}

	/**
	 * Setup wiki page
	 *
	 * @param string $page
	 */
	public function wikiPage($page = null) {
		$this->_wiki_page = (!empty($page)) ? ucwords($page) : 'Index';
	}
}