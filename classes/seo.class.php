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
 * Language controller
 *
 * @author Technocrat
 * @author Al
 * @version 1.2.0
 * @since 5.0.0
 */
class SEO {
	/**
	 * Category directories
	 *
	 * @var array of strings
	 */
	private $_cat_dirs			= null;
	/**
	 * Category paths
	 *
	 * @var array of strings
	 */
	private $_cat_path			= null;
	/**
	 * Dynamic URL sections
	 *
	 * @var array of strings
	 */
	private $_dynamic_sections	= array('prod', 'cat', 'doc');
	/**
	 * SEO url extension
	 *
	 * @var string
	 */
	private $_extension			= '.html';
	/**
	 * Ignored URL sections
	 *
	 * @var array of strings
	 */
	private $_ignored			= array(
		'account', 'addressbook', 'basket', 'checkout', 'complete', 'confirm', 'downloads', 'gateway', 'logout', 'openid', 'profile', 'recover', 'recovery', 'remote', 'vieworder', 'plugin'
	);
	/**
	 * Meta data
	 *
	 * @var array
	 */
	private $_meta_data			= array();
	/**
	 * Sitemap XML handle
	 *
	 * @var handle
	 */
	private $_sitemap_xml		= false;
	/**
	 * Static URL sections
	 *
	 * @var array of strings
	 */
	private $_static_sections	= array('saleitems', 'certificates', 'trackback', 'contact', 'search', 'login', 'register');

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	const TAGS_DEFAULT	= 0;
	const TAGS_MERGE	= 1;
	const TAGS_REPLACE	= 2;

	const PCRE_REQUEST_URI	= '(.*/)?[\w]+.[a-z]+\?_a\=([\w]+)\&(amp;)?([\w]+)\=([\w\-\_]+)([^"\']*)';

	public $_a = '';

	//////////////////////////////////////////

	public function __construct() {
		// Build an array of ALL categories
		$this->_getCategoryList();

		//If SEO is enabled
		if ($this->enabled()) {
			//If URL is an SEO
			if (preg_match('#^'.self::PCRE_REQUEST_URI.'$#Sui', $_SERVER['REQUEST_URI'], $match)) {
				if (!in_array($match[2], $this->_ignored)) {
					//Generate SEO URL
					$seo_url = html_entity_decode($this->generatePath($match[5], $match[2], $match[4], true, true));
					//If the SEO URL != to the current URL
					if (str_replace($GLOBALS['rootRel'], '', $_SERVER['REQUEST_URI']) != $seo_url) {
						//Push the user to that URL
						header('Location: '.$seo_url, true, 301);
						exit;
					}
				}
			}
		}
	}

	/**
	 * Setup the instance (singleton)
	 *
	 * @return SEO
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}

	/**
	 * Add another element to the ignored url segments
	 *
	 * @param string $string
	 */
	public function addIgnore($string) {
		if (!empty($string)) {
			$this->_ignored[] = $string;
		}
	}

	/**
	 * Build SEO URL
	 *
	 * @param string $type
	 * @param string $item_id
	 * @param string $amp
	 * @return string
	 */
	public function buildURL($type, $item_id = false, $amp = '&') {
		if ($this->enabled()) {
			// Some SEO paths are not stored in the database
			if (!$item_id && in_array($type, $this->_static_sections)) {
				if (($item = $GLOBALS['db']->select('CubeCart_seo_urls', array('path'), array('type' => $type))) !== false) {
					return $GLOBALS['storeURL'].'/'.$item[0]['path'].$this->_extension;
				} else {
					return  $GLOBALS['storeURL'].'/'.$this->setdbPath($type, '', '', false).$this->_extension;
				}
			} elseif (($item = $GLOBALS['db']->select('CubeCart_seo_urls', array('path'), array('type' => $type, 'item_id' => $item_id))) !== false) {
				return $GLOBALS['storeURL'].'/'.$item[0]['path'].$this->_extension;
			} else {
				return  $GLOBALS['storeURL'].'/'.$this->setdbPath($type, $item_id, '', false).$this->_extension;
			}
		} else {
			return $GLOBALS['storeURL'].'/'.'index.php?'.http_build_query($this->_getItemVars($type, $item_id), '', $amp);
		}
	}

	/**
	 * Delete SEO URL
	 *
	 * @param string $type
	 * @param string $item_id
	 * @return bool
	 */
	public function delete($type, $item_id) {
		if (in_array($type, $this->_dynamic_sections) && is_numeric($item_id)) {
			return $GLOBALS['db']->delete('CubeCart_seo_urls', array('type' => $type, 'item_id' => $item_id));
		}
		return false;
	}

	/**
	 * Put the META data to the GUI
	 */
	public function displayMetaData() {
		$GLOBALS['smarty']->assign('META_DESCRIPTION',	$this->meta_description());
		$GLOBALS['smarty']->assign('META_KEYWORDS',		$this->meta_keywords());
		$GLOBALS['smarty']->assign('META_TITLE',		$this->meta_title());
	}

	/**
	 * SEO enabled?
	 *
	 * @return bool
	 */
	public function enabled() {
		return $GLOBALS['config']->get('config', 'seo');
	}

	/**
	 * Create full URL
	 *
	 * @param string $url
	 * @param bool $process
	 * @return string
	 */
	public function fullURL($url, $process = false) {
		if (!empty($url) && !preg_match('#^([a-z]+:|\"|\'|\#|\?)#Si', $url)) {
			if ($process) {
				$url = $GLOBALS['storeURL'] . (($GLOBALS['rootRel'] != CC_DS) ? '/'. str_replace($GLOBALS['rootRel'], '', $url) : '/'.$url);
			} else if (substr($url, 0, strlen($GLOBALS['rootRel'])) != $GLOBALS['rootRel']) {
				$url = $GLOBALS['rootRel'].$url;
			}
		}
		return $url;
	}

	/**
	 * Create item URL
	 *
	 * @param string $path
	 * @param bool $url
	 */
	public function getItem($path, $url = false) {
		
		if (isset($_GET['seo_path'])) unset($_GET['seo_path']);
		
		if (!empty($path)) {
			if (($item = $GLOBALS['db']->select('CubeCart_seo_urls', false, array('path' => $path))) !== false) {
				$item_vars = $this->_getItemVars($item[0]['type'], $item[0]['item_id']);
				$_GET = (is_array($_GET)) ? array_merge($item_vars, $_GET) : $item_vars;
				if ($url) {
					return	$GLOBALS['storeURL'].'/index.php?'.http_build_query($_GET);
				} else {
					return true;
				}
			} else {
				httpredir('index.php');
			}
		} else {
			httpredir('index.php');
		}
	}

	/**
	 * Get SEO URLs from the DB
	 *
	 * @param string $type
	 * @param string $item_id
	 * @return string
	 */
	public function getdbPath($type, $item_id) {
		if (($item = $GLOBALS['db']->select('CubeCart_seo_urls', array('path'), array('type' => $type, 'item_id' => $item_id))) !== false) {
			return $item[0]['path'];
		} else {
			return '';
		}
	}

	/**
	 * Generate SEO path
	 *
	 * @param string $id
	 * @param string $type
	 * @param string $key
	 * @param string $absolute
	 * @param string $extension
	 * @return string
	 */
	public function generatePath($id = null, $type = null, $key = null, $absolute = false, $extension = false) {
		$prefix 	= '';
		$type 		= strtolower($type);
		if (!isset($GLOBALS['db']) || !is_object($GLOBALS['db'])) {
			$GLOBALS['db'] = Database::getInstance();
		}

		if(in_array($type, $this->_static_sections)) { /*! Static */
			if (($existing = $GLOBALS['db']->select('CubeCart_seo_urls', 'path', array('type' => $type))) !== false) {
				$path = $existing[0]['path'];
			} else {
				$path = (!empty($GLOBALS['language']->navigation['seo_path_'.$type])) ? $GLOBALS['language']->navigation['seo_path_'.$type] : $type;
			}
		} else { /*! Dymanic */
			switch ($type) {
				case 'cat':
				case 'category':
				case 'viewcat':
					// check its not been made already
					if (($existing = $GLOBALS['db']->select('CubeCart_seo_urls', 'path', array('type' => 'cat', 'item_id' => $id))) !== false) {
						$path = $existing[0]['path'];
					} elseif (is_numeric($id) && isset($this->_cat_dirs[$id])) {
						$path = $this->getDirectory($id);
					} elseif (!isset($this->_cat_dirs[$id])) {
						// new category won't be in cache so it needs rebuilding
						$GLOBALS['cache']->delete('seo.category.list');
						$this->_getCategoryList();
						$path = $this->getDirectory($id);
					} else {
						// last panic resort which shouldn't happen
						$path = 'cat'.$id;
					}
					break;
				case 'doc':
				case 'document':
				case 'viewdoc':
					// check its not been made already
					if (($existing = $GLOBALS['db']->select('CubeCart_seo_urls', 'path', array('type' => 'doc', 'item_id' => $id))) !== false) {
						$path = $existing[0]['path'];
					} else {
						$docs = $GLOBALS['db']->select('CubeCart_documents', array('doc_name'), array('doc_id' => $id));
						$path = $docs[0]['doc_name'];
					}
					break;
				case 'prod':
				case 'product':
				case 'viewprod':
					// check its not been made already
					if (($existing = $GLOBALS['db']->select('CubeCart_seo_urls', 'path', array('type' => 'prod', 'item_id' => $id))) !== false) {
						$path = $existing[0]['path'];
					} elseif (($prods = $GLOBALS['db']->select('CubeCart_inventory', array('product_id', 'name', 'cat_id'), array('product_id' => (int)$id), false, 1)) !== false) {
						if (($cats = $GLOBALS['db']->select('CubeCart_category_index', array('cat_id'), array('product_id' => (int)$id), array('primary' => 'DESC'), 1)) !== false) {
							$prods[0]['cat_id']	= $cats[0]['cat_id'];
						}
						$cat_directory = $this->getDirectory($prods[0]['cat_id']);
						$path = empty($cat_directory) ? $prods[0]['name'] : $cat_directory.'/'.$prods[0]['name'];

					}
					break;
				default:
				$this->_url = 'index.php?_a=' . $type . '&amp;' . $key . '=' . $id;
				return $this->_url;
			}
		}
		$safe_path = $this->_safeUrl($path);
		return (($absolute) ? $GLOBALS['storeURL'] . '/' . $safe_path : $safe_path) . (($extension) ? $this->_extension : '');
	}

	/**
	 * Create meta description
	 *
	 * @param string $cat_id
	 * @param string $link
	 * @param string $glue
	 * @param string $append
	 * @param string $custom
	 *
	 * @return string
	 */
	public function getDirectory($cat_id, $link = false, $glue = '/', $append = false, $custom = true, &$noLoops = array()) {
		if (is_numeric($cat_id)) {
			$category = (isset($this->_cat_dirs[$cat_id])) ? $this->_cat_dirs[$cat_id] : false;
			if (!empty($category)) {

				// Prevent never-ending loops!
				if(in_array($cat_id, $noLoops)) {
					trigger_error('Cat Loop Detected! Cat Path: '.implode(' -> ', $noLoops).'.',E_USER_WARNING);
					return false;
				}
				$noLoops[] = $cat_id;

				if ($link) {
					$this->_cat_path[] = '<a href="'.$GLOBALS['storeURL'].'/index.php?_a=category&amp;cat_id='.(int)$category['cat_id'].'">'.$category['cat_name'].'</a>';
				} else {
					$this->_cat_path[] = $category['cat_name'];
				}
				if (is_numeric($category['cat_parent_id']) && $category['cat_parent_id'] != 0) {
					$this->_cat_path[]	= $this->getDirectory($category['cat_parent_id'], $link, $glue, $append, $custom, $noLoops);
				}
				krsort($this->_cat_path);
				if ($append) {
					$this->_cat_path[] = $append;
				}
				$path = implode($glue, $this->_cat_path);
				$this->_cat_path = null;
				return $path;
			}
		}
		return false;
	}

	/**
	 * Get the SEO extension
	 *
	 * @return string
	 */
	public function getExtension() {
		return $this->_extension;
	}

	/**
	 * Create meta description
	 *
	 * @param string $glue
	 * @return string
	 */
	public function meta_description($glue = ' - ') {
		if ($GLOBALS['config']->has('config', 'seo_metadata') && $GLOBALS['config']->get('config', 'seo_metadata') && !empty($this->_meta_data['description'])) {
			switch ((int)$GLOBALS['config']->get('config', 'seo_metadata')) {
				case self::TAGS_MERGE:
					$description[] = $this->_meta_data['description'];
					$description[] = $GLOBALS['config']->get('config', 'store_meta_description');
					break;
				case self::TAGS_REPLACE:
					$description = $this->_meta_data['description'];
					break;
			}
			return (is_array($description)) ? implode($glue, $description) : $description;
		} else {
			return $GLOBALS['config']->get('config', 'store_meta_description');
		}
	}

	/**
	 * Make Meta keywords
	 *
	 * @param string $glue
	 * @return string
	 */
	public function meta_keywords($glue = ',') {
		if ($GLOBALS['config']->has('config', 'seo_metadata') && $GLOBALS['config']->get('config', 'seo_metadata') && !empty($this->_meta_data['keywords'])) {
			switch ((int)$GLOBALS['config']->get('config', 'seo_metadata')) {
				case self::TAGS_MERGE:
					$keywords[]	= $this->_meta_data['keywords'];
					$keywords[]	= $GLOBALS['config']->get('config', 'store_meta_keywords');
					break;
				case self::TAGS_REPLACE:
					$keywords = $this->_meta_data['keywords'];
					break;
			}
			return (is_array($keywords)) ? implode($glue, $keywords) : $keywords;
		} else {
			return $GLOBALS['config']->get('config', 'store_meta_keywords');
		}
	}

	/**
	 * Make Meta title
	 *
	 * @param string $glue
	 * @return string
	 */
	public function meta_title($glue = ' - ') {
		// Return the title
		if ($GLOBALS['config']->has('config', 'seo_metadata')) {
			if (!empty($this->_meta_data['title'])) {
				$title[1] = $this->_meta_data['title'];
			}
		}
		if (!isset($title[1]) && isset($this->_meta_data['name'])) {
			$title[2] = $this->_meta_data['name'];
		}
		$title[69] = $GLOBALS['config']->get('config', 'store_title');
		ksort($title);
		return implode($glue, $title);
	}

	/**
	 * Parse query string
	 *
	 * @param string $query
	 * @return string
	 */
	public function queryString($query) {
		$query = trim($query);
		if (!empty($query)) {
			$question = true;
			// Get any exists in variables
			if (isset($this->_url) && !empty($this->_url)) {
				//This is already being done else where
				//parse_str(html_entity_decode($this->_url), $existing_vars);
				if (strpos($this->_url, '?') !== false) {
					$question = false;
				}
			}
			// Get query string variables
			parse_str(html_entity_decode($query), $vars);
			//$vars = (isset($existing_vars) && is_array($existing_vars)) ? array_merge($existing_vars, $vars) : $vars;
			foreach ($vars as $key => $var) {
				if (substr($key, 0, 1) == '#') {
					unset($vars[$key]);
				}
			}
			// Get URL elements
			if (!empty($vars)) {
				if ($question) {
					$append[] = '?'.http_build_query($vars);
				} else {
					$append[] = '&'.http_build_query($vars);
				}
			}
			$fragment = parse_url($query, PHP_URL_FRAGMENT);
			if (!empty($fragment)) {
				$append[] = '#'. $fragment;
			}

			if (!empty($append)) {
				return implode('', $append);
			}
		}

		return $query;
	}

	/**
	 * Rebuild category listings
	 */
	public function rebuildCategoryList() {
		$this->_getCategoryList(true);
	}

	/**
	 * Rewrite URL
	 *
	 * @param string $page_html
	 * @param bool $page_html
	 * @return bool
	 */
	public function rewriteUrls($page_html, $full_urls = false) {
		$index = $this->_getBaseUrl($full_urls);

		if ($this->enabled()) {
			$search[0] = '#(href|action)=["\'](.*/)?[\w]+.[a-z]+\?_a\=([\w]+)\&(amp;)?([\w]+)\=([\w\-\_]+)([^"\']*)["\']#Sei';
			$replace[0]	= '"$1=\"".$index.$this->generatePath(\'$6\', \'$3\', \'$5\').$this->queryString(\'$7\')."\""';
		}
		$search[1] = '#(href|src|background)=([\"\'])([^\"]*)([\"\'])#Suie';
		$replace[1]	= '"$1=$2".$this->fullURL(\'$3\', $full_urls)."$4"';
		return preg_replace($search, $replace, $page_html);
	}

	/**
	 * Can we use SEO
	 *
	 * @param string $path
	 * @return bool/string
	 */
	public function SEOable($path) {
		if ($this->enabled()) {
			if (strpos($path, 'index.php?_a=category&search') !== false) {
				$path = str_replace('index.php?', 'search.html?', $path);
				return $path;
			} else if (($pos = strpos($path, 'index.php?_a=search')) !== false) {
				if (strlen($path) == $pos + 19) {
					$path = str_replace('index.php?_a=search', 'search.html', $path);
				} else {
					$path = str_replace('index.php?_a=search&', 'search.html?', $path);
				}
				return $path;
			}
		}

		if ($this->enabled() && preg_match('#^(.*/)?[\w]+.[a-z]+\?_a\=([\w]+)\&(amp;)?([\w\[\]]+)\=([\w\-\_]+)([^"\']*)$#ieS', $path, $match)) {
			return $this->generatePath($match[5], $match[2], $match[4], true, true).$this->queryString($match[6]);
		} else {
			return $path;
		}
	}

	/**
	 * Set a DB path
	 *
	 * @param string $type
	 * @param int $item_id
	 * @param string $path
	 * @param bool $bool
	 * @param bool $show_error
	 * @return bool/string
	 */
	public function setdbPath($type, $item_id, $path, $bool = true, $show_error = true) {
		if (in_array($type, array_merge($this->_dynamic_sections, $this->_static_sections))) {
			// if path is empty or already taken generate one
			if (empty($path) || $GLOBALS['db']->count('CubeCart_seo_urls', 'id', "`path` = '$path' AND `type` = '$type' AND `item_id` <> $item_id") > 0) {
				// send warning if in use
				if (!empty($path)) {
					if ($show_error) {
						$GLOBALS['gui']->setError($GLOBALS['language']->settings['seo_path_taken']);
					}
				}
				// try to generate
				$path = $this->generatePath($item_id, $type);
			}
			$path = sanitizeSEOPath($path);
			
			if(empty($path)) {
				return ($bool) ? false : '';
			}
			if (($existing = $GLOBALS['db']->select('CubeCart_seo_urls', 'id', array('type' => $type, 'item_id' => $item_id))) !== false) {
				$GLOBALS['db']->update('CubeCart_seo_urls', array('type' => $type, 'item_id' => $item_id, 'path' => $path), array('id' => $existing[0]['id']));
			} else {
				//Check for dup path
				if(!$GLOBALS['db']->select('CubeCart_seo_urls', false, array('path' => $path))) {
					$GLOBALS['db']->insert('CubeCart_seo_urls', array('type' => $type, 'item_id' => $item_id, 'path' => $path));
				} else {
					// Force unique path is it's already taken
					$unique_id = substr($type,0,1).$item_id;
					$GLOBALS['db']->insert('CubeCart_seo_urls', array('type' => $type, 'item_id' => $item_id, 'path' => $path.'-'.$unique_id));
					$GLOBALS['gui']->setError($GLOBALS['language']->settings['seo_path_taken']);
				}
			}
			return $bool ? true : $path;
		} else {
			trigger_error('Invalid SEO path type '.$type.'.',E_USER_NOTICE);
			return false;
		}
	}

	/**
	 * Set all meta data
	 *
	 * @param array $meta_data
	 * @return bool
	 */
	public function set_meta_data($meta_data) {
		if (!empty($meta_data) && is_array($meta_data)) {
			$default	= array('name' => '', 'path' => '', 'title' => '', 'description' => '', 'keywords' => '');
			$meta_data	= array_merge($default, $this->_meta_data, $meta_data);
			foreach ($meta_data as $key => $value) {
				$this->_meta_data[$key]	= $value;
			}
			return true;
		}
		return false;
	}

	/**
	 * Enable/Disable cache
	 *
	 * @param bool $enable
	 */
	public function setCache($enable) {
		$GLOBALS['cache']->enable($enable);
	}

	/**
	 * Create sitemap
	 *
	 * @return bool
	 */
	public function sitemap() {
		// Generate a Sitemap Protocol v0.9 compliant sitemap (http://sitemaps.org)
		$this->_sitemap_xml = new XML();
		$this->_sitemap_xml->startElement('urlset', array('xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'));

		// Generate Standard records
		# Homepage
		
		$store_url = (CC_SSL) ? $GLOBALS['config']->get('config','standard_url') : $GLOBALS['storeURL'];
		
		$this->_sitemap_link(array('url' => $store_url.'/index.php'));
		# Sale Items
		$this->_sitemap_link(array('url' => $store_url.'/index.php?_a=saleitems'));
		# Gift Certificates
		$this->_sitemap_link(array('url' => $store_url.'/index.php?_a=certificates'));

		$queryArray = array(
			'category'	=> $GLOBALS['db']->select('CubeCart_category', array('cat_id'), array('status' => '1')),
			'product'	=> $GLOBALS['db']->select('CubeCart_inventory', array('product_id', 'updated'), array('status' => '1')),
			'document'	=> $GLOBALS['db']->select('CubeCart_documents', array('doc_id'), array('doc_parent_id' => '0', 'doc_status' => 1)),
		);

		foreach ($queryArray as $type => $results) {
			if ($results) {
				foreach ($results as $record) {
					switch ($type){
						case 'category':
							$id		= $record['cat_id'];
							$key	= 'cat_id';
							break;
						case 'product':
							$id		= $record['product_id'];
							$key	= 'product_id';
							break;
						case 'document':
							$id		= $record['doc_id'];
							$key	= 'doc_id';
							break;
					}
					$this->_sitemap_link(array('key' => $key, 'id' => $id), (!isset($record['updated'])) ? (int)$record['updated'] : time(), $type);
				}
			}
		}
		$sitemap = $this->_sitemap_xml->getDocument(true);

		if (function_exists('gzencode')) {
			// Compress the file if GZip is enabled
			$filename	= CC_ROOT_DIR.CC_DS.'sitemap.xml.gz';
			$mapdata	= gzencode($sitemap, 9, FORCE_GZIP);
		} else {
			$filename	= CC_ROOT_DIR.CC_DS.'sitemap.xml';
			$mapdata	= $sitemap;
		}
		if (file_put_contents($filename, $mapdata)) {
			// Ping Google
			$request = new Request('www.google.com','/webmasters/sitemaps/ping');
			$request->setMethod('get');
			$request->setData(array('sitemap' => $store_url.'/'.basename($filename)));
			$request->send();
			return true;
		}
		return false;
	}

	/**
	 * Get the base url
	 *
	 * @param bool $full_urls
	 * @return string
	 */
	private function _getBaseUrl($full_urls = false) {
		return ($full_urls) ? $GLOBALS['storeURL'].'/' : '';
	}

	/**
	 * Get categories
	 *
	 * @param bool $rebuild
	 */
	private function _getCategoryList($rebuild = false) {
		$language = $GLOBALS['session']->has('language', 'client') ? $GLOBALS['session']->get('language', 'client') : Language::getInstance()->current();
		if ($rebuild || ($this->_cat_dirs = Cache::getInstance()->read('seo.category.list.'.$language)) === false) {
			if (($results = $GLOBALS['db']->select('CubeCart_category', array('cat_id', 'cat_name', 'cat_parent_id'), array('hide' => '0'), array('cat_id' => 'DESC'))) !== false) {
				foreach ($results as $result) {
					$this->_cat_dirs[$result['cat_id']] = $result;
				}

				// Write over with translations
				if (($translations = $GLOBALS['db']->select('CubeCart_category_language', array('cat_id', 'cat_name'), array('language' => $language))) !== false) {
					foreach($translations as $translation) {
						$this->_cat_dirs[$translation['cat_id']]['cat_name'] = $translation['cat_name'];
					}
				}

				if (!empty($this->_cat_dirs)) {
					$GLOBALS['cache']->write($this->_cat_dirs, 'seo.category.list.'.$language);
				}
			}
		}
	}

	/**
	 * Get an SEO item
	 *
	 * @param string $type
	 * @param string $item_id
	 * @return array
	 */
	private function _getItemVars($type, $item_id) {
		switch($type) {
			/*! Static */
			case 'search':
				$array = array(
					'_a' => 'search'
				);
			break;
			case 'contact':
				$array = array(
					'_a' => 'contact'
				);
			break;
			case 'saleitems':
				$array = array(
					'_a' => 'saleitems'
				);
			break;
			case 'certificates':
				$array = array(
					'_a' => 'certificates'
				);
			break;
			/*! Dymanic */
			case 'cat':
				$array = array(
					'_a' => 'category',
					'cat_id' => $item_id
				);
			break;
			case 'doc':
				$array = array(
					'_a' => 'document',
					'doc_id' => $item_id
				);
			break;

			case 'prod':
				$array = array(
					'_a' => 'product',
					'product_id' => $item_id
				);
			break;
			case 'certificates':
				$array = array(
					'_a' => 'certificates',
				);
			break;
			case 'basket':
				$array = array(
					'_a' => 'basket',
				);
			break;
			case 'login':
			    $array = array(
			        '_a' => 'login'
			    );
			break;
			case 'register':
			    $array = array(
			        '_a' => 'register'
			    );
			break;
		}
		$this->_a = $array['_a'];
		return $array;
	}

	/**
	 * Is URL safe?
	 *
	 * @param string $url
	 * @return bool
	 */
	private function _safeUrl($url) {
		$url = trim($url);
		$url = str_replace(' ', '-', html_entity_decode($url, ENT_QUOTES));
		$url = preg_replace('#[^\w\-_/]#iuU', '-', str_replace(CC_DS, '/', $url));
		return preg_replace(array('#/{2,}#iu', '#-{2,}#'), array('/', '-'), $url);
	}

	/**
	 * Create sitemap link
	 *
	 * @param string $input
	 * @param string $updated
	 * @param string $type
	 */
	private function _sitemap_link($input, $updated = false, $type = false) {
		$updated = (!$updated) ? time() : $updated;
		if (!isset($input['url']) && !empty($type)) {
			if ($this->enabled()) {
				$input['url'] = $this->generatePath($input['id'], $type, '', true, true);
			} else {
				$input['url'] = $GLOBALS['storeURL'].sprintf('/index.php?_a=%s&%s=%s', $type, $input['key'], $input['id']);
			}
		}
		$this->_sitemap_xml->startElement('url');
		$this->_sitemap_xml->setElement('loc',  htmlspecialchars($input['url']),false, false);
		$this->_sitemap_xml->setElement('lastmod', date('c', $updated), false, false);
		$this->_sitemap_xml->endElement();
	}

	/**
	 * Create talkback
	 *
	 * @param string $product_id
	 * @param string $data
	 */
	private function _trackback($product_id = false, $data = false) {
		$products	= $GLOBALS['db']->select('CubeCart_inventory', 'product_id', array('product_id' => (int)$product_id));
		if ($products) {
			if (isset($data['url']) && filter_var(urldecode($data['url']), FILTER_VALIDATE_URL)) {
				$record	= array(
					'product_id'	=> (int)$product_id,
					'url'			=> urldecode($data['url']),
					'blog_name'		=> (isset($data['blog_name']) && !empty($data['blog_name'])) ? strip_tags($data['blog_name']) : null,
					'title'			=> (isset($data['title']) && !empty($data['title'])) ? strip_tags($data['title']) : null,
					'excerpt'		=> (isset($data['excerpt']) && !empty($data['excerpt'])) ? strip_tags($data['excerpt']) : null,
				);
				if (!$GLOBALS['db']->insert('CubeCart_trackback', $record)) $error = 'Unknown Error';
			} else {
				$error	= 'Invalid URL';
			}
		} else {
			$error	= 'That page does not exist';
		}
		// Generate response
		$response	= new XMLWriter();
		$response->openMemory();
		$response->startDocument('1.0', 'UTF-8');
		$response->startElement('response');
		if (isset($error)) {
			// Failure
			$response->writeElement('error', '1');
			$response->writeElement('message', strip_tags($error));
		} else {
			// Success
			$response->writeElement('error', '0');
		}
		$response->endElement();
		// Send response
		die($response->outputMemory(true));
	}
}
