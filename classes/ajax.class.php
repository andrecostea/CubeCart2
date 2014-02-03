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
 * AJAX controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since 5.0.0
 */
class Ajax {

	/**
	 * Load the proper AJAX function/method
	 */
	public static function load() {
		global $glob;

		$json = '';
		//Kill debug
		$GLOBALS['debug']->supress();


		//Try a hook first
		foreach ($GLOBALS['hooks']->load('class.ajax.load') as $hook) include $hook;
		if (!empty($json)) {
			return $json;
		}

		//Get the correct function/method
		switch ($_GET['function']) {
			case 'get':
				$type = (isset($_GET['type'])) ? $_GET['type'] : '';
				if ($type == 'htaccess') {
					$json['content'] = file_get_contents(CC_ROOT_DIR.CC_DS.$glob['adminFolder'].CC_DS.'sources'.CC_DS.'settings'.CC_DS.'seo-htaccess.txt');
					$json = json_encode($json);
				} else if ($type == 'seo_code') {
					$seo = file_get_contents(CC_ROOT_DIR.CC_DS.$glob['adminFolder'].CC_DS.'sources'.CC_DS.'settings'.CC_DS.'seo-htaccess.txt');
					if (file_exists(CC_ROOT_DIR.CC_DS.'.htaccess')) {
						$htaccess = file_get_contents(CC_ROOT_DIR.CC_DS.'.htaccess');
						if (!preg_match('/#### Rewrite rules for SEO functionality ####.*<\/IfModule>/mis', $htaccess)) {
							if (preg_match('/#### Rewrite rules for SEO functionality ####.*<\/IfModule>/mis', $seo, $match)) {
								$json['content'] = $htaccess."\n".$match[0];
							} else {
								$json['content'] = $htaccess;
							}
						} else {
							$json['content'] = $htaccess;
						}
					} else {
						$json['content'] = $seo;
					}
					$json = json_encode($json);
				} else if ($type == 'no_seo_code') {
					if (file_exists(CC_ROOT_DIR.CC_DS.'.htaccess')) {
						$htaccess = file_get_contents(CC_ROOT_DIR.CC_DS.'.htaccess');
						if (($json['content'] = preg_replace('/#### Rewrite rules for SEO functionality ####.*<\/IfModule>/mis', '', $htaccess)) === false) {
							$json['content'] = $htaccess;
						}
					} else {
						$json['content'] = file_get_contents(CC_ROOT_DIR.CC_DS.$glob['adminFolder'].CC_DS.'sources'.CC_DS.'settings'.CC_DS.'seo-htaccess.txt');
					}
					$json = json_encode($json);
				}
			break;
			case 'search':
			default:
				$type = (isset($_GET['type'])) ? $_GET['type'] : '';
				$string	= ($_GET['q']) ? $_GET['q'] : '';
				$json = self::search($type, $string);
			break;
		}


		return $json;
	}

	/**
	 * Admin search function
	 *
	 * @param string $type
	 * @param string $search_string
	 * @return data/false
	 */
	public static function search($type, $search_string) {
		$data = false;
		if (!empty($type) && !empty($search_string)) {
			switch (strtolower($type)) {
				case 'user':
					if (($results = $GLOBALS['db']->select('CubeCart_customer', false, array('~'.$search_string => array('last_name', 'first_name', 'email')), false, false, false, false)) !== false) {
						foreach ($results as $result) {
							$data[] = array(
								'value'		=> $result['customer_id'],
								'display'	=> $result['first_name'].' '.$result['last_name'],
								'info'		=> $result['email'],
								'data'		=> $result,
							);
						}
					}
				break;
				case 'address':
					if (($results = $GLOBALS['db']->select('CubeCart_addressbook', false, array('customer_id' => (int)$search_string), false, false, false, false)) !== false) {
						foreach ($results as $result) {
							$result['state']	= getStateFormat($result['state']);
							$result['country']	= getCountryFormat($result['country']);
							$data[] 			= $result;
						}
					}
				break;
				case 'product':
					// Limited to a maximum of 15 results, in order to prevent it going mental
					if (($results = $GLOBALS['db']->select('CubeCart_inventory', false, array('~'.$search_string => array('name', 'product_code')), false, 15, false, false)) !== false) {
						foreach ($results as $result) {
							$lower_price = Tax::getInstance()->salePrice($result['price'], $result['sale_price'], false);
							if($lower_price && ($lower_price < $result['price'])) {
								$result['price'] = $lower_price;
							}
							$data[] = array(
								'value'		=> $result['product_id'],
								'display'	=> $result['name'],
								'info'		=> Tax::getInstance()->priceFormat($result['price']),
								'data'		=> $result,
							);
						}
					}
				break;
				case 'newsletter':
					$newsletter	= Newsletter::getInstance();
					$status		= $newsletter->sendNewsletter($_GET['q'], $_GET['page']);
					if (is_array($status)) {
						$data = $status;
					} else {
						$data = ($status) ? array('complete' => 'true', 'percent' => 100) : array('error' => 'true');
					}
				break;
				case 'files':
                                    
                    if($_GET['dir'] == CC_DS){
                        $dir = false;
                    } elseif($_GET['dir'] == '/') {
                        $dir = false;
                    } else {
                        $dir = $_GET['dir'];
                    }
                                      
					$filemanager = new FileManager($_GET['group'], $dir);

					// Directories
					if (($dirs = $filemanager->findDirectories()) !== false) {
						foreach ($dirs[$filemanager->formatPath($dir)] as $parent => $folder) {
							$path = (!empty($dir)) ? CC_DS : '';
							$json[] = array(
								'type' => 'directory',
								'path' => urldecode($dir.basename($folder).CC_DS),
								'name' => basename($folder),
							);
						}
					}

					if (($files = $filemanager->listFiles()) !== false) {
						$catalogue = new Catalogue();
						foreach ($files as $result) {
							if ($filemanager->getMode() == FileManager::FM_FILETYPE_IMG) {
								$fetch	= $catalogue->imagePath($result['file_id'], 'medium');
								$path	= $name = $fetch;
							} else {
								$path	= $result['filepath'];
								$name	= $result['filename'];
							}
							$json[] = array(
								'type'			=> 'file',
								'path'			=> dirname($path).'/',
								'file'			=> basename($result['filename']),
								'name'			=> basename($name),
								'id'			=> $result['file_id'],
								'description'	=> $result['description'],
								'mime'			=> $result['mimetype'],
							);
						}
					}

					$data = (isset($json) && is_array($json)) ? $json : false;
				break;
				default:
					return false;
				break;
			}
			if (!$data) {
				$data = array();
			}
			return json_encode($data);
		}
		return false;
	}
}