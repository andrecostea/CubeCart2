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
 * Catalogue controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since 5.0.0
 */
class Catalogue {
	private $_category_count		= 0;
	private $_category_products		= 0;
	private $_category_status_prod_id	= array();
	private $_categoryData;
	private $_productData;
	private $_pathElements;
	private $_category_translations	= false;
	private $_option_required = false;

	const OPTION_SELECT     = 0;
	const OPTION_TEXTBOX    = 1;
	const OPTION_TEXTAREA   = 2;
	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	/**
	 * Setup the instance (singleton)
	 *
	 * @return Catalogue
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}

	//=====[ Public ]====================================================================================================

	public function buildCategoriesDropDown($parent_id = 0, $breakout = '|', $spaces = 0) {
		$out = array();
		if (($categories = $GLOBALS['db']->select('CubeCart_category', array('cat_parent_id', 'cat_id', 'cat_name'), array('cat_parent_id' => $parent_id), 'priority, cat_name ASC')) !== false) {
			foreach ($categories as $category) {
				$out[] = array(
					'cat_id'	=> $category['cat_id'],
					'name'		=> ($spaces > 0) ? str_repeat('&nbsp;', $spaces).$breakout.' '.$category['cat_name'] : $category['cat_name'],
				);
				if (($children = $GLOBALS['db']->count('CubeCart_category', 'cat_id', array('cat_parent_id' => $category['cat_id']))) !== false) {
					$out = array_merge($out, $this->buildCategoriesDropDown($category['cat_id'], $breakout, $spaces + 2));
				}
			}
		}

		return $out;
	}

	public function categoryPagination($page) {
		if ($this->_category_count) {
			//Pagination
			if(!is_numeric($GLOBALS['config']->get('config', 'catalogue_products_per_page'))) {
				$catalogue_products_per_page = 10;
			} else {
				$catalogue_products_per_page = $GLOBALS['config']->get('config', 'catalogue_products_per_page');
			}
			if (($pages = $GLOBALS['db']->pagination($this->_category_count, $catalogue_products_per_page, $page)) !== false) {
				// Display pagination
				$GLOBALS['smarty']->assign('PAGINATION', $pages);
			}
		}
	}

	public function categoryPath($category_id, $glue = '/', $link = true, $reverse_sort = true, $top = true) {
		if ($top) {
			$this->_pathElements = null;
		}
		if (is_numeric($category_id) && $category_id > 0) {
			$this->getCategoryData($category_id);
			$this->_categoryTranslation();

			$result = $this->_categoryData;
			$this->_pathElements[] = ($link) ? sprintf('<a href="'.$GLOBALS['storeURL'].'/index.php?_a=viewCat&amp;cat_id=%d">%s</a>', $result['cat_id'], $result['cat_name']) : $result['cat_name'];
			if ($result['cat_parent_id'] != 0) {
				$this->categoryPath($result['cat_parent_id'], $glue, $link, $reverse_sort, false);
			}
		}
		if (is_array($this->_pathElements)) {
			($reverse_sort) ? krsort($this->_pathElements) : ksort($this->_pathElements);
			return implode($glue, $this->_pathElements);
		}
	}

	public function displayCategory() {

		// Allow hooks to see/change what will be displayed
		$catData = $this->_categoryData;
		$products = $this->_category_products;
		
		foreach ($GLOBALS['hooks']->load('class.cubecart.pre_display_category') as $hook) include $hook;

		if (isset($catData) && is_array($catData)) {
			$vars['category'] = $catData;

			if (!empty($catData['cat_image'])) {
				$vars['category']['image'] = $this->imagePath($catData['cat_image'], 'category','url');
			}
			$GLOBALS['smarty']->assign('category', $vars['category']);
			$meta_data	= array(
				'name'			=> (isset($catData['cat_name'])) ? $catData['cat_name'] : '',
				'path'			=> null,
				'description'	=> (isset($catData['seo_meta_description'])) ? $catData['seo_meta_description'] : '',
				'keywords'		=> (isset($catData['seo_meta_keywords'])) ? $catData['seo_meta_keywords'] : '',
				'title'			=> (isset($catData['seo_meta_title'])) ? $catData['seo_meta_title'] : '',
			);
			$GLOBALS['seo']->set_meta_data($meta_data);
		} else if ($_GET['_a'] !== 'saleitems') {
			$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_category_error']);
			return false;
		}
	
		if (!empty($products)) {
			foreach ($products as $product) {
				$product = $this->getProductPrice($product);
				$this->productAssign($product, false);
				$product['url'] = $GLOBALS['seo']->buildURL('prod', $product['product_id'], '&amp;');
				$vars['products'][] = $product;
			}

			$GLOBALS['smarty']->assign('PRODUCTS', $vars['products']);
		}

		if (!empty($catData)) {
			$GLOBALS['smarty']->assign('SUBCATS', $this->displaySubCategory(isset($_GET['cat_id']) ? $_GET['cat_id'] : ''));


			// Generate Breadcrumbs
			$string	= $GLOBALS['seo']->getDirectory((isset($catData['cat_id'])) ? $catData['cat_id'] : '', true, '|');
			$cats	= explode('|', $string);
			if (is_array($cats)) {
				foreach ($cats as $cat) {
					if (preg_match('#^<a href="(.*)">(.*)</a>$#', $cat, $match)) {
						$GLOBALS['gui']->addBreadcrumb($match[2], $match[1]);
					}
				}
			}
		}
			
		// Sorting
		$GLOBALS['smarty']->assign('SORTING', ($sorting = $this->displaySort((isset($_GET['cat_id']) && $_GET['cat_id'] == 'sale'))) ? $sorting : false);
		foreach ($GLOBALS['hooks']->load('class.cubecart.display_category') as $hook) include $hook;
		$content = $GLOBALS['smarty']->fetch('templates/content.category.php');
		$GLOBALS['smarty']->assign('PAGE_CONTENT', $content);

		return true;
	}

	public function displayProduct($product = false, $popularity = false) {
		if (isset($product) && is_numeric($product)) {
			if (($product = $this->getProductData($product)) !== false) {
				$meta_data	= array(
					'name'			=> $product['name'],
					'path'			=> null,
					'description'	=> $product['seo_meta_description'],
					'keywords'		=> $product['seo_meta_keywords'],
					'title'			=> $product['seo_meta_title'],
				);
				$GLOBALS['seo']->set_meta_data($meta_data);

				// Update popularity
				if ($popularity) {
					$this->_productPopularity($product['product_id']);
				}

				if (isset($_GET['error']) && !empty($_GET['error'])) {
					switch (strtolower($_GET['error'])) {
						case 'option':
							$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_option_required']);
						break;
						default:
							// No error defined
						break;
					}
				}
				$this->productAssign($product);

				// Show manfacturer
				if (($manufacturer = $this->getManufacturer($product['manufacturer'])) !== false) {
					$GLOBALS['smarty']->assign('MANUFACTURER', $manufacturer);
				}

				// Display gallery
				$GLOBALS['smarty']->assign('GALLERY', $this->_productGallery($product['product_id']));
				$GLOBALS['smarty']->assign('OPTIONS', $this->_displayProductOptions($product['product_id']));

				$allow_purchase = true;
				$out = $hide = false;

				if ((bool)$product['use_stock_level']) {
					// Get Stock Level
					$stock_level = $this->getProductStock($product['product_id'], null, true);

					$product['stock_level'] = ($stock_level>0) ? $stock_level : 0;
					if ((int)$stock_level <= 0) {
						// Out of Stock
						if (!$GLOBALS['config']->get('config', 'basket_out_of_stock_purchase')) {
							// Not Allowed
							$allow_purchase = false;
							$out = true;
						}
					}
				}

				if ($GLOBALS['session']->get('hide_prices')) {
					$allow_purchase = false;
					$hide = true;
				}

				$GLOBALS['smarty']->assign('CTRL_ALLOW_PURCHASE', $allow_purchase);
				$GLOBALS['smarty']->assign('CTRL_HIDE_PRICES', $hide);
				$GLOBALS['smarty']->assign('CTRL_OUT_OF_STOCK', $out);

				$GLOBALS['smarty']->assign('REVIEW_SCORE_MAX', 5);
				//Are we displaying reviews, or the "tell-a-friend" form?

				$GLOBALS['smarty']->assign('CTRL_REVIEW', (bool)$GLOBALS['config']->get('config','enable_reviews'));
				// Display Reviews
				$page		= (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
				$per_page	= 5;
				if (($reviews = $GLOBALS['db']->select('CubeCart_reviews', false, array('approved' => 1, 'product_id' => $product['product_id']), 'time DESC', $per_page, $page)) !== false) {
					if (($paginate = $GLOBALS['db']->select('CubeCart_reviews', 'SUM(`rating`) AS Score, COUNT(`id`) as Count', array('approved' => 1, 'product_id' => $product['product_id']))) !== false) {
						$review_count	= (int)$paginate[0]['Count'];
						$review_score	= $paginate[0]['Score'];
						$GLOBALS['smarty']->assign('PAGINATION', $GLOBALS['db']->pagination($review_count, $per_page, $page));
					}
					foreach ($reviews as $review) {
						if ($review['anon']) {
							$review['name'] = $GLOBALS['language']->catalogue['review_anon'];
						}
						$review['date']		= formatTime($review['time']);
						$vars[]	= $review;
					}
					$GLOBALS['smarty']->assign('REVIEWS', $vars);
					$GLOBALS['smarty']->assign('REVIEW_COUNT', (int)$review_count);
					$GLOBALS['smarty']->assign('REVIEW_AVERAGE', round($review_score/$review_count, 1));
				}
				for ($i = 1; $i <= 5; ++$i) {
					$star = array(
						'value'		=> $i,
						'checked'	=> (isset($_POST['rating']['rating']) && $_POST['rating']['rating'] == $i) ? 'checked="checked"' : '',
					);
					$vars['rating_stars'][] = $star;
					$GLOBALS['smarty']->assign('RATING_STARS', $vars['rating_stars']);
				}

				// Trackbacks
				if ($GLOBALS['config']->get('config', 'seo') && $GLOBALS['config']->get('config', 'seo_trackbacks')) {
					$trackbacks	= $GLOBALS['db']->select('CubeCart_trackback', false, array('product_id' => $product['product_id']));
					$GLOBALS['smarty']->assign('TRACKBACKS', ($trackbacks) ? $trackbacks : false);
					$GLOBALS['smarty']->assign('TRACKBACK_URL', currentPage(null, array('_a' => 'trackback'), true));
				}
				$product['url'] = $GLOBALS['seo']->buildURL('prod', $product['product_id'], '&amp;');
				
				// Get stock level variations for options
				if($stock_variations = $GLOBALS['db']->select('CubeCart_option_matrix','MAX(stock_level) AS max_stock, MIN(stock_level) AS min_stock', array('product_id' => $product['product_id'], 'use_stock' => 1, 'status' => 1),false,1)) {
					if(is_numeric($stock_variations[0]['min_stock']) && is_numeric($stock_variations[0]['max_stock'])) {
						$product['stock_level'] =  ($stock_variations[0]['min_stock'] == $stock_variations[0]['max_stock']) ? $stock_variations[0]['max_stock'] : $stock_variations[0]['min_stock'].' - '.$stock_variations[0]['max_stock'];
					}
				}
				$product['stock_level'] = ($GLOBALS['config']->get('config', 'stock_level')=='1') ? $product['stock_level'] : false;
				$GLOBALS['smarty']->assign('PRODUCT', $product);
			}
			if (($category = $GLOBALS['db']->select('CubeCart_category_index', false, array('product_id' => (int)$product['product_id'], 'primary' => 1), array('priority' => 'DESC'), 1)) !== false) {
				$string	= $GLOBALS['seo']->getDirectory($category[0]['cat_id'], true, '|');
				$cats	= explode('|', $string);
				if (is_array($cats)) {
					foreach ($cats as $cat) {
						if (preg_match('#^<a href="(.*)">(.*)</a>$#', $cat, $match)) {
							$GLOBALS['gui']->addBreadcrumb($match[2], $match[1]);
						}
					}
				}
				$GLOBALS['gui']->addBreadcrumb($product['name'], currentPage());
			}
			// Fire up recaptcha
			if ($GLOBALS['config']->get('config', 'recaptcha') && !$GLOBALS['session']->get('confirmed','recaptcha')) {
				$GLOBALS['smarty']->assign('DISPLAY_RECAPTCHA', recaptcha_get_html($GLOBALS['recaptcha_keys']['captcha_public'], $GLOBALS['recaptcha']['error'], CC_SSL));
				$GLOBALS['smarty']->assign('RECAPTCHA', true);
			}
					
			// Output to main GUI
			foreach ($GLOBALS['hooks']->load('class.cubecart.display_product') as $hook) include $hook;
			$content = $GLOBALS['smarty']->fetch('templates/content.product.php');
			$GLOBALS['smarty']->assign('SECTION_NAME', 'product');
			$GLOBALS['smarty']->assign('PAGE_CONTENT', $content);

			return true;
		}

		return false;
	}

	public function displaySort($search = false) {
		// Sort
		if ($search) {
			$sorters['Relevance'] = $GLOBALS['language']->common['relevance'];
		}
		$sorters['name']		= $GLOBALS['language']->common['name'];
		$sorters['date_added']	= $GLOBALS['language']->category['sort_date'];

		if (!$GLOBALS['session']->get('hide_prices')) {
			$sorters['price'] = $GLOBALS['language']->common['price'];
		}
		if ($GLOBALS['config']->get('config', 'stock_level')) {
			$sorters['stock_level'] = $GLOBALS['language']->category['sort_stock'];
		}
		#
		$directions	= array(
			'DESC'	=> $GLOBALS['language']->category['sort_high_low'],
			'ASC'	=> $GLOBALS['language']->category['sort_low_high'],
		);
		foreach ($sorters as $field => $name) {
			foreach ($directions as $order => $direction) {
				$direction	= (isset($GLOBALS['language']->category[strtolower('sort_'.$field.'_'.$order)])) ? $GLOBALS['language']->category[strtolower('sort_'.$field.'_'.$order)] : $direction;
				$assign	= array('name' => $name, 'field' => $field, 'order' => $order, 'direction' => $direction);
				$assign['selected'] = (isset($_GET['sort'][$field]) && strtoupper($_GET['sort'][$field]) == $order) ? 'selected="selected"' : '';
				$data[] = $assign;
			}
		}
		return $data;
	}

	public function displaySubCategory($category_id) {
		if (!empty($category_id) && is_numeric($category_id)) {
			if (($subcats = $GLOBALS['db']->select('CubeCart_category', false, array('cat_parent_id' => $category_id, 'status' => '1'),array('priority'=>'ASC'))) !== false) {
				foreach ($subcats as $cat) {
					// Translate
					$GLOBALS['language']->translateCategory($cat);
					$products = $this->productCount($cat['cat_id']);
					if ($products || ($products = $this->productCount($cat['cat_id']) || $GLOBALS['config']->get('config', 'catalogue_show_empty')) !== false) {
						$cat['cat_image'] = $this->imagePath($cat['cat_image'], 'subcategory','url');
						$cat['url'] = $GLOBALS['seo']->buildURL('cat', $cat['cat_id'], '&amp;');
						$cat['products_number'] = $products;
						$return[] = $cat;
					}
				}
				return $return;
			}
		}
		return false;
	}

	public function getCategoryData($category_id) {
		if (($result = $GLOBALS['db']->select('CubeCart_category', false, array('cat_id' => $category_id, 'status' => 1))) !== false) {
			$GLOBALS['language']->translateCategory($result[0]);
			$this->_categoryData = $result[0];
			return $this->_categoryData;
		}

		return false;
	}

	function getCategoryStatusByProductID($product_id) {
		if (empty($this->_category_status_prod_id)) {
			$query = sprintf("SELECT CI.* , C.status FROM `%1\$sCubeCart_category_index` AS CI, `%1\$sCubeCart_category` AS C WHERE CI.cat_id = C.cat_id ORDER BY CI.product_id", $GLOBALS['config']->get('config', 'dbprefix'));
			if (($data = $GLOBALS['db']->query($query)) !== false) {
				foreach ($data as $cat_data) {
					$this->_category_status_prod_id[$cat_data['product_id']][] = $cat_data;
				}
			}
		}

		if (isset($this->_category_status_prod_id[$product_id])) {
			return $this->_category_status_prod_id[$product_id];
		}

		return array();
	}

	public function getCategoryTree($parent_id = 0) {
		if (($categories = $GLOBALS['db']->select('CubeCart_category', array('cat_parent_id', 'cat_id', 'cat_name'), array('cat_parent_id' => $parent_id, 'status' => 1), 'priority, cat_name ASC')) !== false) {

			// Write over with translations
			if (!$this->_category_translations && ($translations = $GLOBALS['db']->select('CubeCart_category_language', array('cat_id', 'cat_name'), array('language' => $GLOBALS['language']->current()))) !== false) {
				foreach($translations as $translation) {
						$this->_category_translations[$translation['cat_id']] = $translation['cat_name'];
				}
			}

			foreach ($categories as $category) {
				
				$where = ' AND I.status = 1';
				
				if($GLOBALS['config']->get('config', 'hide_out_of_stock')) {
					$where .= ' AND I.use_stock_level = 1 AND I.stock_level > 0';
				}
				
				$products_array = $GLOBALS['db']->misc('SELECT `id` FROM `'.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_category_index` AS C INNER JOIN `'.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_inventory` AS I ON I.`product_id` = C.`product_id` WHERE C.cat_id = '.$category['cat_id'].$where);
				$products = $products_array ? count($products_array) : 0;	
							
				$children	= $GLOBALS['db']->count('CubeCart_category', 'cat_id', array('cat_parent_id' => $category['cat_id'], 'status' => '1'));
				if (($products || $GLOBALS['config']->get('config', 'catalogue_show_empty')) || $children) {
					$result	= array(
						'name'		=> (isset($this->_category_translations[$category['cat_id']]) && !empty($this->_category_translations[$category['cat_id']])) ? $this->_category_translations[$category['cat_id']] : $category['cat_name'],
						'cat_id'	=> $category['cat_id'],
					);
					if ($GLOBALS['config']->get('config', 'catalogue_expand_tree') && $children = $this->getCategoryTree($category['cat_id'])) {
						$result['children'] = $children;
					}
					$tree_data[]	= $result;
				}
			}
		}

		return (isset($tree_data)) ? $tree_data : false;
	}

	public function getManufacturer($id) {
		if (($manufacturers	= $GLOBALS['db']->select('CubeCart_manufacturers', array('name','URL'), array('id' => $id))) !== false) {
			if(filter_var($manufacturers[0]['URL'],FILTER_VALIDATE_URL)) {
				return '<a href="'.$manufacturers[0]['URL'].'" target="_blank">'.$manufacturers[0]['name'].'</a>';
			} else {
				return $manufacturers[0]['name'];
			}
		} else {
			return false;
		}
	}

	public function getProductData($product_id, $quantity = 1, $order = false, $per_page = 10, $page = 1, $category = false,$options_identifier = null) {
	
		if (!is_array($product_id)) {
			$category_data = $this->getCategoryStatusByProductID($product_id);
			$category_status = false;
			if (is_array($category_data)) {
				foreach ($category_data as $trash => $data) {
					if ($data['status'] == 1) {
						$category_status = true;
					}
				}
			}
			if (!$category_status) {
				return false;
			}
		}

		$where = $this->outOfStockWhere(array('product_id' => $product_id, 'status' => 1));
		
		if (isset($order['price']) && $GLOBALS['config']->get('config', 'catalogue_sale_mode')) {
			if(!empty($page) && is_numeric($page)){
				$query = 'SELECT *, IF(`sale_price` > 0, `sale_price`, `price`) AS price_sort FROM '.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_inventory WHERE '.$where.' ORDER BY `price_sort` '.$order['price'].' LIMIT '.$per_page.' OFFSET '.(int)($page-1)*$per_page;
			} else {
				$query = 'SELECT *, IF(`sale_price` > 0, `sale_price`, `price`) AS price_sort FROM '.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_inventory WHERE '.$where.' ORDER BY `price_sort` '.$order['price'];
			}
			$result = $GLOBALS['db']->query($query);
		}  else {
			$result = $GLOBALS['db']->select('CubeCart_inventory', false, $where, $order, $per_page, $page);
		}

		// Get product option specific data
		$products_matrix_data = $GLOBALS['db']->select('CubeCart_option_matrix', array('stock_level' ,'product_code', 'upc', 'jan', 'isbn', 'image'), array('product_id' => (int)$product_id, 'options_identifier' => $options_identifier, 'status' => 1, 'use_stock' => 1));
		if($products_matrix_data) {
			foreach($products_matrix_data[0] as $key => $value) {
				if(!is_null($value) && !empty($value)) {
					$result[0][$key] = $value;
				}
			}
		}
		if ($result !== false) {
			$count	= count($result);
			$data = array();
			foreach ($result as $product) {
				$GLOBALS['language']->translateProduct($product);
				$this->getProductPrice($product, $quantity);
				if (!$category && $count == 1) {
					$data = $product;
					break;
				} else {
					$data[$product['product_id']] = $product;
				}
			}
			foreach ($GLOBALS['hooks']->load('class.catalogue.product_data') as $hook) include $hook;
			return $data;
		}

		return false;
	}

	public function getProductOptions($product_id = null) {
		if (($setlist = $GLOBALS['db']->select('CubeCart_options_set_product', array('set_id'), array('product_id' => (int)$product_id))) !== false) {
			// Fetch Option Sets
			foreach ($setlist as $set_data) {
				if (($sets = $GLOBALS['db']->select('CubeCart_options_set_member', false, array('set_id' => (int)$set_data['set_id']))) !== false) {
					foreach ($sets as $set) {
						$set_members[]	= $set['set_member_id'];
						$set_groups[]	= $set['option_id'];
						$set_values[$set['option_id']][] = $set['value_id'];
					}
					if (($groups = $GLOBALS['db']->select('CubeCart_option_group', false, array('option_id' => $set_groups), array('priority' => 'ASC', 'option_name' => 'ASC'))) !== false) {
						foreach ($groups as $group) {
							if ($group['option_type'] == 0) {
								if(isset($set_values[$group['option_id']]) && !empty($set_values[$group['option_id']])) {
									$value_id = $set_values[$group['option_id']];
								}
								if (is_array($value_id) && ($values = $GLOBALS['db']->select('CubeCart_option_value', false, array('value_id' => $value_id), array('priority' => 'ASC', 'value_name' => 'ASC'))) !== false) {
									foreach ($values as $value) {
										if (($assigns = $GLOBALS['db']->select('CubeCart_option_assign', false, array('value_id' => $value['value_id'], 'option_id' => $value['option_id'], 'product' => (int)$product_id, 'set_member_id' => $set_members))) !== false) {
											foreach ($assigns as $assign) {
												if (!$assign['set_enabled']) continue;
												$option_array[$group['option_type']][$value['option_id']][] = array_merge($group, $value, $assign);
											}
										} else {
											## Unassigned, default option from set
											$option_array[$group['option_type']][$value['option_id']][] = array_merge($group, $value, array('assign_id' => (int)($value['value_id']*(-1))));
										}
									}
								}
							} else {
								// Text option
								if (($assigns = $GLOBALS['db']->select('CubeCart_option_assign', false, array('option_id' => $group['option_id'], 'product' => (int)$product_id))) !== false) {
									$assign	= $assigns[0];
								} else {
									$assign = array();
								}
								$option_array[$group['option_type']][$group['option_id']][]	= array_merge($group, $assign);
							}
							$option_array[$group['option_type']][$group['option_id']]['priority'] = $group['priority'];
							unset($group);
						}
					}
					unset($set_members, $set_groups, $set_values);
				}
			}
		}

		if (($products = $GLOBALS['db']->select('CubeCart_option_assign', false, array('product' => (int)$product_id, 'set_member_id' => 0, 'set_enabled' => '1'))) !== false) {
			$option = array();
			foreach ($products as $assigned) {
				if ($assigned['option_id'] > 0) {
					$option[$assigned['option_id']][] = $assigned;
					$top[]	= $assigned['option_id'];
					$mid[]	= $assigned['value_id'];
				}
			}
			if (($categories = $GLOBALS['db']->select('CubeCart_option_group', array('option_id', 'option_name', 'option_type', 'option_required', 'priority'), array('option_id' => $top), array('priority' => 'ASC', 'option_name' => 'ASC'))) !== false) {
				foreach ($categories as $category) {
					$array = false;
					if ($category['option_required']) {
						$this->_option_required = true;
					}
					if ($category['option_type'] == 0) {
						// Get Option Values
						if (($values	= $GLOBALS['db']->select('CubeCart_option_value', false, array('option_id' => $category['option_id'], 'value_id' => $mid), array('priority' => 'ASC', 'value_name' => 'ASC'))) !== false) {
							foreach ($values as $value) {
								foreach ($option[$value['option_id']] as $opt) {
									if ($opt['value_id'] == $value['value_id']) {
										$option_array[$category['option_type']][$category['option_id']][]	= array_merge($category, $value, $opt);
									}
								}
							}
						}
					} else {
						// Text Options
						foreach ($option[$category['option_id']] as $opt) {
							$option_array[$category['option_type']][$category['option_id']][] = array_merge($category, $opt);
							break;
						}
					}
					$option_array[$category['option_type']][$category['option_id']]['priority'] = $category['priority'];
				}
			}
		}
		// Sort option values
		if (is_array($option_array)) {
			foreach ($option_array as $type => $option_list) {
				if (is_array($option_list)) {
					foreach ($option_list as $oid => $array) {
						uasort($array, 'cmpmc');
						$option_array[$type][$oid] = $array;
					}
				}
			}
		}
		

		if (isset($option_array) && is_array($option_array)) {
			foreach ($GLOBALS['hooks']->load('class.catalogue.product_options') as $hook) include $hook;
			return $option_array;
		}

		return false;
	}

	public function getProductPrice(&$product_data, $quantity = 1) {
		if (isset($product_data['product_id']) && is_numeric($product_data['product_id'])) {
			$product_id	= (int)$product_data['product_id'];
			$group_id = 0;
			if (isset($GLOBALS['user']) && $GLOBALS['user']->is()) {
				// Check for group pricing
				if (($memberships = $GLOBALS['db']->select('CubeCart_customer_membership', array('group_id'), array('customer_id' => (int)$GLOBALS['user']->getId()))) !== false) {
					$group_id = array();
					foreach ($memberships as $membership) {
						$group_id[]	= $membership['group_id'];
					}
					if (($pricing_group = $GLOBALS['db']->select('CubeCart_pricing_group', false, array('product_id' => $product_id, 'group_id' => $group_id), array('price' => 'ASC'), 1)) !== false) {
						$product_data['price']			= $pricing_group[0]['price'];
						$product_data['sale_price']		= $pricing_group[0]['sale_price'];
						$product_data['tax_inclusive']	= $pricing_group[0]['tax_inclusive']; # do not rely on retail price setting!
						$product_data['tax_type']		= $pricing_group[0]['tax_type'];
					}
				}
			}

			//Are we in sale mode?
			$sale = false;
			$product_data['ctrl_sale'] = false;

			switch ((int)$GLOBALS['config']->get('config', 'catalogue_sale_mode')) {
				case 0:
					break;
				case 1:
					if ($product_data['sale_price'] && ($product_data['sale_price'] > 0 && $product_data['sale_price'] != Tax::getInstance()->priceFormatHidden())) {
						$product_data['ctrl_sale'] = true;
					}
					$sale = true;
					break;
				case 2:
					if (!$GLOBALS['config']->isEmpty('config', 'catalogue_sale_percentage')) {
						$product_price = $product_data['price'];
						//Make sure the first character is a digit
						$product_price = preg_replace('/[^0-9.]*/','',$product_price);

						$product_data['sale_price']	= $product_price - ($product_price / 100) * $GLOBALS['config']->get('config', 'catalogue_sale_percentage');

						$product_data['ctrl_sale'] = ($product_data['sale_price'] > 0 && $product_data['sale_price'] != Tax::getInstance()->priceFormatHidden()) ? true : false;
						$sale = true;
					}
					break;
			}


			$search	= array('product_id' => $product_id, 'group_id' => $group_id);

			if (($pricing = $GLOBALS['db']->select('CubeCart_pricing_quantity', array('quantity', 'price'), $search, array('quantity' => 'ASC', 'price' => 'ASC'))) !== false) {
				foreach ($pricing as $price) {
					$prices[$price['quantity']]	= ($GLOBALS['config']->get('config', 'catalogue_sale_mode')==2) ? ($price['price'] - ($price['price'] / 100) * $GLOBALS['config']->get('config', 'catalogue_sale_percentage')) : $price['price'];
				}
				krsort($prices);
				// Ok so we need to get quantity for other items with same product ID for quantity discounts.
				// e.g. 1 x Blue Widget + 2 x Red Widget
				$original_quantity = $quantity;
				if(is_array($GLOBALS['cart']->basket['contents'])) {
					$quantity = 0;
					foreach($GLOBALS['cart']->basket['contents'] as $hash => $item) {
						if($item['id']==$product_id) {
							$quantity += $item['quantity'];
						}
					}	
				}
				$quantity = ($quantity==0) ? $original_quantity : $quantity;
				  
				foreach ($prices as $quant => $price) {
					if ($quant > $quantity) {
						continue;
					} else {
						//If the sale price is still better than the quantity price use the sale price
						if (!$sale || ((double)$product_data['sale_price'] == 0) || ($sale && $product_data['sale_price'] > $price)) {
							$product_data['price'] = $price;
							$product_data['sale_price'] = $price;
						}
						break;
					}
				}
			}

			foreach ($GLOBALS['hooks']->load('class.cubecart.product_price') as $hook) include $hook;

			if($sale && $product_data['sale_price'] >= $product_data['price']) {
				$product_data['ctrl_sale'] = false;
			}
			return $product_data;
		}

		return false;
	}

	public function getCategoryProducts($category_id, $page = 1, $per_page = 10, $hidden = false) {
		if (strtolower($page) == 'all') {
			$per_page	= false;
			$page		= false;
		}

		$where2 = $this->outOfStockWhere(false, 'INV', true);

		if (($result = $GLOBALS['db']->query('SELECT I.product_id FROM `'.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_category_index` as I,  `'.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_inventory` as INV WHERE I.cat_id = '.$category_id.' AND I.product_id = INV.product_id AND INV.status = 1'.$where2)) !== false) {
			$this->_category_count = $GLOBALS['db']->numrows();
			if (isset($_GET['sort']) && is_array($_GET['sort'])) {
				foreach ($_GET['sort'] as $field => $direction) {
					$order[$field] = (strtolower($direction) == 'asc') ? 'ASC' : 'DESC';
					break;
				}
			} else {
				$order_column = $GLOBALS['config']->get('config', 'product_sort_column');
				$order_direction = $GLOBALS['config']->get('config', 'product_sort_direction');
				$order[$order_column] = $order_direction;
			}
			foreach ($result as $product) {
				$list[] = $product['product_id'];
			}
			foreach ($GLOBALS['hooks']->load('class.catalogue.category_product_list') as $hook) include $hook;
			$productList = $this->getProductData($list, 1, $order, $per_page, $page, true);
		}

		return (isset($productList) && is_array($productList)) ? $productList : false;
	}

	public function getOptionData($option_id, $assign_id) {
		if (($category = $GLOBALS['db']->select('CubeCart_option_group', false, array('option_id' => (int)$option_id))) !== false) {
			// Is it assigned, or was it from an option set?
			if (is_int($assign_id) && $assign_id < 0) {
				// Option Set
				if (($value = $GLOBALS['db']->select('CubeCart_option_value', false, array('value_id' => abs($assign_id)))) !== false) {
					return array_merge($category[0], $value[0]);
				}
			} else {
				$assigned = $GLOBALS['db']->select('CubeCart_option_assign', false, array('assign_id' => (int)$assign_id));
				if ($category[0]['option_type'] == 0) {
					// Select
					if (($value = $GLOBALS['db']->select('CubeCart_option_value', false, array('option_id' => $category[0]['option_id'], 'value_id' => $assigned[0]['value_id']))) !== false) {
						return array_merge($category[0], $assigned[0], $value[0]);
					}
				} else {
					// Text
					if (isset($assigned[0])) {
						return array_merge($category[0], $assigned[0]);
					} else {
						return $category[0];
					}
				}
			}
		}
		return false;
	}

	public function getOptionRequired() {
		return $this->_option_required;
	}

	public function getProductStock($product_id = null, $options_identifier_string = null, $return_max = false) {
		
		// Choose option combination specific stock
		if(is_numeric($product_id) && (!empty($options_identifier_string) || $return_max == true)) {
			
			if($return_max) {
				$rows = 'MAX(stock_level) AS `stock_level`';
				$where = array('product_id' => (int)$product_id, 'status' => 1, 'use_stock' => 1);
			} else {
				$rows = array('stock_level','restock_note');
				$where = array('product_id' => (int)$product_id, 'options_identifier' => $options_identifier_string, 'status' => 1, 'use_stock' => 1);
			}
			$products_matrix = $GLOBALS['db']->select('CubeCart_option_matrix', $rows, $where);
			if(is_numeric($products_matrix[0]['stock_level'])) {	
			 	if(!empty($products_matrix[0]['restock_note'])) {
			 		$GLOBALS['session']->set('restock_note',$products_matrix[0]['restock_note']);
			 	}
			 	return $products_matrix[0]['stock_level'];
			 }
			
		}

		// Fall back to traditional stock check if there are no results for the combination or it is not used
		if (is_numeric($product_id) && ($products = $GLOBALS['db']->select('CubeCart_inventory', array('stock_level'), array('product_id' => (int)$product_id), false, 1)) !== false) {
			return $products[0]['stock_level'];
		}

		return false;
	}

	public function imagePath($input, $mode = 'medium', $path = 'relative', $return_placeholder = true) {
		$defaults	= true;
		if (is_numeric($input)) {
			if (($result = $GLOBALS['db']->select('CubeCart_filemanager', false, array('file_id' => (int)$input))) !== false) {
				$file		= $result[0]['filepath'].$result[0]['filename'];
				$defaults	= false;
			}
		} else if (!empty($input)) {
			$file		= str_replace(array('images/cache/', 'images/uploads/'), '', $input);
			$defaults	= false;
		}

		$skins	= $GLOBALS['gui']->getSkinData();
		// Fetch a default image, just in case...
		if ($return_placeholder && isset($skins['images'][$mode])) {
			$default	= (string)$skins['images'][$mode]['default'];
			$files		= glob('skins'.CC_DS.$GLOBALS['gui']->getSkin().CC_DS.'{images,styleImages}'.CC_DS.'{common,'.$GLOBALS['gui']->getStyle().'}'.CC_DS.$default , GLOB_BRACE | GLOB_NOSORT);
			if ($files) {
				$default_image = str_replace(CC_DS, '/', $GLOBALS['storeURL'].'/'.$files[0]);
			}
		} else {
			$default_image = '';
		}
		if (!isset($file) || empty($file)) {
			return $default_image;
		}
		$source	= CC_ROOT_DIR.CC_DS.'images'.CC_DS.'source'.CC_DS.$file;
		if (!is_dir($source) && file_exists($source)) {
			if ($mode == 'source') {
				$folder		= 'source';
				$filename	= $file;
			} else {
				$folder	= 'cache';
				if (isset($skins['images'][$mode])) {
					$data	= $skins['images'][$mode];
					preg_match('#(.*)(\.\w+)$#', $file, $match);
					$size		= (int)$data['maximum'];
					$filename	= sprintf('%s.%d%s', $match[1], $size, $match[2]);
					## Find the source
					$image		= CC_ROOT_DIR.CC_DS.'images'.CC_DS.$folder.CC_DS.$filename;
					if (!file_exists($image)) {
						## Check if the target folder exists - if not, create it!
						if (!file_exists(dirname($image))) mkdir(dirname($image), chmod_writable(), true);
						## Generate the image
						$gd		= new GD(dirname($image), $size, (int)$data['quality']);
						$gd->gdLoadFile($source);
						$gd->gdSave(basename($image));
					}
				} else {
					trigger_error('No image mode set', E_USER_NOTICE);
					return false;
				}
			}
			## Generate the required path
			switch (strtolower($path)) {
				case 'filename':	## Calculate the from source folder
					$img	= $filename;
					break;
				case 'root':		## Calculate the absolute filesystem path
					$img	= str_replace('/', CC_DS, CC_ROOT_DIR.'/images/'.$folder.'/'.$filename);
					break;
				case 'url':			## Calculate the absolute url
					$img	= str_replace(CC_DS, '/', $GLOBALS['storeURL'].'/images/'.$folder.'/'.$filename);
					break;
				case 'rel':
				case 'relative':	## Calculate the relative web path
					$img	= str_replace(CC_DS, '/', $GLOBALS['rootRel'].'images/'.$folder.'/'.$filename);
					break;
			}
			return $img;
		} else {
			return $default_image;
		}
	}

	public function productAssign(&$product, $product_view = true) {
		## Short Description
		$product['description_short'] = (strlen($product['description']) > $GLOBALS['config']->get('config', 'product_precis')) ? substr(strip_tags($product['description']), 0, $GLOBALS['config']->get('config', 'product_precis')).'&hellip;' : $product['description'];

		$product['price_unformatted']		= $product['price'];
		$product['sale_price_unformatted']	= $product['sale_price'];

		$product['price']		= $GLOBALS['tax']->priceFormat($product['price']);
		$product['sale_price']	= $GLOBALS['tax']->priceFormat($product['sale_price']);

		$product['ctrl_purchase'] = ($GLOBALS['session']->get('hide_prices')) ? false : true;
		$product['out'] = false;
		if ($product['use_stock_level']) {
			// Get Stock Level
			$stock_level = $this->getProductStock($product['product_id'], null, true);
			if ((int)$stock_level <= 0) {
				// Out of Stock
				if (!$GLOBALS['config']->get('config', 'basket_out_of_stock_purchase')) {
					// Not Allowed
					$product['ctrl_purchase'] = false;
					$product['out'] = true;
				}
			}
		}

		$skins = $GLOBALS['gui']->getSkinData();
		if (isset($skins['images'])) {
			$image_types = $skins['images'];
			if (!isset($image_types['source'])) {
				$image_types['source'] = array();
			}
			foreach ($image_types as $image_key => $values) {
				$product[$image_key] = $GLOBALS['gui']->getProductImage($product['product_id'], $image_key);
				if ($image_key == 'medium') {
					if (strpos($product[$image_key], 'noimage') !== false) {
						$product['magnify'] = false;
					} else {
						$product['magnify'] = true;
					}
				}
			}
		}

		## Calculate average review score
		if ($GLOBALS['config']->get('config','enable_reviews') && ($reviews = $GLOBALS['db']->select('CubeCart_reviews', array('rating'), array('product_id' => (int)$product['product_id'], 'approved' => '1'))) !== false) {
			$score	= 0;
			$count	= 0;
			foreach ($reviews as $review) {
				$score += $review['rating'];
				$count++;
			}
			$product['review_score'] = round($score/$count, 1);
			if (!$product_view) {
				$link = currentPage(array('_a', 'cat_id'), null, false).'_a=product&amp;product_id='.$product['product_id'].'#reviews';
			} else {
				$link = '#reviews';
			}
			$score = number_format(($score/$count),1);
			if($product_view) {
				$GLOBALS['smarty']->assign('LANG_REVIEW_INFO', sprintf($GLOBALS['language']->catalogue['review_info'], $score, $count, $link));	
			} else {
				$product['review_info'] = sprintf($GLOBALS['language']->catalogue['review_info'], $score, $count, $link);
			}
			unset($score, $count);
		} else {
			$product['review_score'] = false;
		}

		if ($product_view) {
			// Price by quantity
			$user = (array)$GLOBALS['user']->get();
			if (isset($user['customer_id']) && ($memberships = $GLOBALS['db']->select('CubeCart_customer_membership', array('group_id'), array('customer_id' => (int)$user['customer_id']))) !== false) {
				foreach ($memberships as $membership) {
					$group_id[]	= $membership['group_id'];
				}
			} else {
				$group_id = 0;
			}
			// Limit by membership
			if (($prices = $GLOBALS['db']->select('CubeCart_pricing_quantity', false, array('product_id' => $product['product_id'], 'group_id' => $group_id), array('quantity' => 'ASC'))) !== false) {
				foreach ($prices as $price) {
					$price['price']	= ($GLOBALS['config']->get('config', 'catalogue_sale_mode')==2) ? ($price['price'] - ($price['price'] / 100) * $GLOBALS['config']->get('config', 'catalogue_sale_percentage')) : $price['price'];
					$price['price']	= $GLOBALS['tax']->priceFormat($price['price'], true);
					$product['discounts'][]	= $price;
				}
			}
		}

		return true;

	}

	public function productCount($cat_id) {
		$products	= $GLOBALS['db']->select('CubeCart_category_index', array('id'), array('cat_id' => $cat_id));
		$count		= ($products) ? count($products) : 0;
		$children	= $GLOBALS['db']->select('CubeCart_category', array('cat_id'), array('cat_parent_id' => (int)$cat_id));
		if ($children) {
			foreach ($children as $child) {
				$count += $this->productCount($child['cat_id']);
			}
		}
		return $count;
	}

	public function setCategory($element, $data) {
		$this->_categoryData[$element] = $data;
	}

	public function get_int($input) {
		return (int)$input;
	}
	public function get_int_array($inputArray) {
		return array_map(array(&$this, 'get_int'), $inputArray);
	}
	public function searchCatalogue($search_data = null, $page = 1, $per_page = 10, $search_mode = 'fulltext') {

		$per_page = (!is_numeric($per_page) || $per_page < 1) ? 10 : $per_page;

		$original_search_data = $search_data;

		/*	Allow plugins to add to conditions and joins or change the search_data
			Where conditions may be added to the $where variable and must be self contained (e.g. no AND prefix or suffix) since they will be ANDed together below
			$where[] = "I.price > 100";
			Joins may be added to the $joins variable - keep in mind the need for unique table aliases as appropriate
			$joins[] = "`plugin_myPlugin` as P ON P.`product_id`=I.`product_id` AND P.`my_field`='some_value'";
			The only guaranteed table alias is I for CubeCart_inventory
		*/
		$where = array();
		$joins = array();
		foreach ($GLOBALS['hooks']->load('class.catalogue.pre_search') as $hook) include $hook;

		$sale_mode = $GLOBALS['config']->get('config', 'catalogue_sale_mode');
		
		if ($sale_mode == 2) {
			$sale_percentage = $GLOBALS['config']->get('config', 'catalogue_sale_percentage');
		}
		$user = (array)$GLOBALS['user']->get();
		$group_id = 'WHERE group_id = 0';
		if (isset($user['customer_id']) && ($memberships = $GLOBALS['db']->select('CubeCart_customer_membership', array('group_id'), array('customer_id' => (int)$user['customer_id']))) !== false) {
			$group_id = 'WHERE ';
			foreach ($memberships as $membership) {
				$group_id .= 'group_id = '.$membership['group_id'].' OR ';
			}
			$group_id = substr($group_id, 0, -4);
		}

		if (strtolower($page) != 'all') {
			$page	= (is_numeric($page)) ? $page : 1;
			$limit	= sprintf('LIMIT %d OFFSET %d', (int)$per_page, $per_page*($page-1));
		} else {
			$limit	= 'LIMIT 100';
		}
		
		// Presence of a join is similar to presence of a search keyword
		if (!empty($joins) || is_array($search_data)) {
			if (!empty($search_data['priceVary'])) {
				// Allow for a 5% variance in prices
				if (!empty($search_data['priceMin']) && is_numeric($search_data['priceMin'])) {
					$price = round($GLOBALS['tax']->priceConvertFX($search_data['priceMin'])/1.05, 3);
					if ($sale_mode == 1) {
						$where[] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price) >= '.$price.', IF (G.sale_price = 0, G.price, G.sale_price) >= '.$price.')';
					} else if ($sale_mode == 2) {
						$where[] = 'IF (G.price IS NULL, (I.price - ((I.price / 100) * '.$sale_percentage.')) >= '.$price.', (G.price - ((G.price / 100) * '.$sale_percentage.')) >= '.$price.')';
					} else {
						$where[] = 'IF (G.price IS NULL, I.price >= '.$price.', G.price >= '.$price.')';
					}
				}

				if (!empty($search_data['priceMax']) && is_numeric($search_data['priceMax'])) {
					$price = round($GLOBALS['tax']->priceConvertFX($search_data['priceMax'])*1.05, 3);
					if ($sale_mode == 1) {
						$where[] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price) <= '.$price.', IF (G.sale_price = 0, G.price, G.sale_price) <= '.$price.')';
					} else if ($sale_mode == 2) {
						$where[] = 'IF (G.price IS NULL, (I.price - ((I.price / 100) * '.$sale_percentage.')) <= '.$price.', (G.price - ((G.price / 100) * '.$sale_percentage.')) <= '.$price.')';
					} else {
						$where[] = 'IF (G.price IS NULL, I.price <= '.$price.', G.price <= '.$price.')';
					}
				}
			} else {
				## Basic price searching
				if (!empty($search_data['priceMin']) && is_numeric($search_data['priceMin']) &&
					!empty($search_data['priceMax']) && is_numeric($search_data['priceMax']) &&
					$search_data['priceMax'] == $search_data['priceMin']) {
						$price = round($GLOBALS['tax']->priceConvertFX($search_data['priceMin']), 3);
						if ($sale_mode == 1) {
							$where[] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price) = '.$price.', IF (G.sale_price = 0, G.price, G.sale_price) = '.$price.')';
						} else if ($sale_mode == 2) {
							$where[] = 'IF (G.price IS NULL, (I.price - ((I.price / 100) * '.$sale_percentage.')) = '.$price.', (G.price - ((G.price / 100) * '.$sale_percentage.')) = '.$price.')';
						} else {
							$where[] = 'IF (G.price IS NULL, I.price = '.$price.', G.price = '.$price.')';
						}
				} else {
					if (!empty($search_data['priceMin']) && is_numeric($search_data['priceMin'])) {
						$price = round($GLOBALS['tax']->priceConvertFX($search_data['priceMin']), 3);
						if ($sale_mode == 1) {
							$where[] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price) >= '.$price.', IF (G.sale_price = 0, G.price, G.sale_price) >= '.$price.')';
						} else if ($sale_mode == 2) {
							$where[] = 'IF (G.price IS NULL, (I.price - ((I.price / 100) * '.$sale_percentage.')) >= '.$price.', (G.price - ((G.price / 100) * '.$sale_percentage.')) >= '.$price.')';
						} else {
							$where[] = 'IF (G.price IS NULL, I.price >= '.$price.', G.price >= '.$price.')';
						}
					}
					if (!empty($search_data['priceMax']) && is_numeric($search_data['priceMax'])) {
						$price = round($GLOBALS['tax']->priceConvertFX($search_data['priceMax']), 3);
						if ($sale_mode == 1) {
							$where[] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price) <= '.$price.', IF (G.sale_price = 0, G.price, G.sale_price) <= '.$price.')';
						} else if ($sale_mode == 2) {
							$where[] = 'IF (G.price IS NULL, (I.price - ((I.price / 100) * '.$sale_percentage.')) <= '.$price.', (G.price - ((G.price / 100) * '.$sale_percentage.')) <= '.$price.')';
						} else {
							$where[] = 'IF (G.price IS NULL, I.price <= '.$price.', G.price <= '.$price.')';
						}
					}
				}
			}
			// Manufacturer
			if (isset($search_data['manufacturer']) && is_array($search_data['manufacturer']) && count($search_data['manufacturer'])>0) {
				$where[] = 'I.manufacturer IN ('.implode(',', $this->get_int_array($search_data['manufacturer'])).')';
//				$where[] = 'I.manufacturer IN ('.implode(',', '\''.$search_data['manufacturer']).'\')';
			}

			if (isset($_GET['sort']) && is_array($_GET['sort'])) {
				foreach ($_GET['sort'] as $field => $direction) {
					$order['field']	= $field;
					if ($field == 'price') {
						if ($sale_mode == 1) {
							$order['field'] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price), IF (G.sale_price = 0, G.price, G.sale_price))';
						} else {
							$order['field'] = 'IF (G.price IS NULL, I.price, G.price)';
						}
					}
					$order['sort'] = (strtolower($direction) == 'asc') ? 'ASC' : 'DESC';
					break;
				}
			} elseif($search_mode == 'fulltext') {
				$order['field']	= 'Relevance';
				$order['sort']	= 'DESC';
			}
			if (empty($search_data['keywords']) && $order['field'] == 'Relevance') {
				if ($sale_mode == 1) {
					$order['field'] = 'IF (G.sale_price IS NULL, IF (I.sale_price = 0, I.price, I.sale_price), IF (G.sale_price = 0, G.price, G.sale_price))';
				} else {
					$order['field'] = 'IF (G.price IS NULL, I.price, G.price)';
				}
			}
			if(is_array($order)) {
				$order_string = 'ORDER BY '.$order['field'].' '.$order['sort'];
			}

			if (isset($search_data['featured'])) {
				$where[] = "I.featured = '1'";
			}
			// Only look for items that are in stock
			if (isset($search_data['inStock']) || $GLOBALS['config']->get('config','hide_out_of_stock'))	{
				$where[] = "((I.use_stock_level = '0') OR (I.use_stock_level = '1' AND I.stock_level > 0))";
			}

			$whereString = (isset($where) && is_array($where)) ? implode(' AND ', $where) : '';
			if (!empty($whereString)) $whereString = ' AND '.$whereString;

			$joinString = (isset($joins) && is_array($joins)) ? implode(' JOIN ', $joins) : '';
			if (!empty($joinString)) $joinString = ' JOIN '.$joinString;

			$indexes = $GLOBALS['db']->getFulltextIndex('CubeCart_inventory', 'I');

			if (!empty($joins) || isset($search_data['keywords']) && is_array($indexes) && !empty($search_data['keywords'])) {

				$max_word_len = $GLOBALS['db']->getSearchWordLen();
				$words = explode(' ',$search_data['keywords']);
				if(is_array($words)) {
					$search_str_len = 0;
					foreach($words as $word) {
						$search_str_len = ($search_str_len < strlen($word)) ? strlen($word) : $search_str_len;
					}
				} else {
					$search_str_len = strlen($search_data['keywords']);
				}

				if ($search_mode == 'fulltext' && $search_str_len >= $max_word_len) {
					switch (true) {
						case (preg_match('#[\+\-\>\<][\w]+#iu', $search_data['keywords'])):
							## Switch to bolean mode
							$mode = 'IN BOOLEAN MODE';
							break;
						default:
							$search_data['keywords'] = str_replace(' ', '*) +(*', $search_data['keywords']);
							$search_data['keywords'] .= '*)';
							$search_data['keywords'] = '+(*'.$search_data['keywords'];
							$mode = 'IN BOOLEAN MODE';
							break;
					}
					$words = preg_replace('/[^\p{Greek}a-zA-Z0-9\s]+/u', '', $search_data['keywords']);
					$words = $GLOBALS['db']->sqlSafe($words);
					// Score matching string
					$match = sprintf("MATCH (%s) AGAINST('%s' %s)", implode(',', $indexes), $words, $mode);
					$match_val	= 0.5;
					
					$query = sprintf("SELECT I.*, %2\$s AS Relevance FROM %1\$sCubeCart_inventory AS I LEFT JOIN (SELECT product_id, MAX(price) as price, MAX(sale_price) as sale_price FROM %1\$sCubeCart_pricing_group $group_id GROUP BY product_id) as G ON G.product_id = I.product_id $joinString WHERE I.product_id IN (SELECT product_id FROM `%1\$sCubeCart_category_index` as CI INNER JOIN %1\$sCubeCart_category as C where CI.cat_id = C.cat_id AND C.hide = 0) AND I.status = 1 AND (%2\$s) >= %4\$f %3\$s %5\$s %6\$s", $GLOBALS['config']->get('config', 'dbprefix'), $match, $whereString, $match_val, $order_string, $limit);
					if (($search = $GLOBALS['db']->query($query)) !== false) {
						$q2 = sprintf("SELECT COUNT(I.product_id) as count, %2\$s AS Relevance FROM %1\$sCubeCart_inventory AS I LEFT JOIN (SELECT product_id, MAX(price) as price, MAX(sale_price) as sale_price FROM %1\$sCubeCart_pricing_group $group_id GROUP BY product_id) as G ON G.product_id = I.product_id $joinString WHERE I.product_id IN (SELECT product_id FROM `%1\$sCubeCart_category_index` as CI INNER JOIN %1\$sCubeCart_category as C where CI.cat_id = C.cat_id AND C.hide = 0) AND I.status = 1 AND (%2\$s) >= %4\$f %3\$s GROUP BY I.product_id %5\$s", $GLOBALS['config']->get('config', 'dbprefix'), $match, $whereString, $match_val, $order_string);
						$count	= $GLOBALS['db']->query($q2, false, 0);
						$this->_category_count		= (int)count($count);
						$this->_category_products	= $search;
						return true;
					} elseif($search_mode == 'fulltext') {
						return $this->searchCatalogue($original_search_data, 1, $per_page, 'like');
					}
					
				} else {
				
					$rlike = '';
					if (!empty($search_data['keywords'])) {
						$searchwords = preg_split( '/[ ,]/', $GLOBALS['db']->sqlSafe($search_data['keywords']));
						foreach ($searchwords as $word) {
							$searchArray[] = $word;
						}
					
						$noKeys = count($searchArray);
						$regexp = '';
						for ($i=0; $i<$noKeys; ++$i) {
							$ucSearchTerm = strtoupper($searchArray[$i]);
							if (($ucSearchTerm != 'AND') && ($ucSearchTerm != 'OR')) {
								$regexp .= '[[:<:]]'.$searchArray[$i].'[[:>:]].*';
							}
						}
						$regexp = substr($regexp, 0, strlen($regexp)-2);
						$rlike	= " AND (I.name RLIKE '".$regexp."' OR I.description RLIKE '".$regexp."' OR I.product_code RLIKE '".$regexp."')";
					}
					
					$q2 = "SELECT I.* FROM ".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_inventory AS I LEFT JOIN (SELECT product_id, MAX(price) as price, MAX(sale_price) as sale_price FROM ".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_pricing_group $group_id GROUP BY product_id) as G ON G.product_id = I.product_id $joinString WHERE I.product_id IN (SELECT product_id FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_category_index` as CI INNER JOIN ".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_category as C where CI.cat_id = C.cat_id AND C.hide = 0) AND I.status = 1 ".$whereString.$rlike;
					$query = $q2.' '.$limit;
					if (($search = $GLOBALS['db']->query($query)) !== false) {	
						$count	= $GLOBALS['db']->query($q2, false, 0);
						$this->_category_count		= (int)count($count);
						$this->_category_products	= $search;
						return true;
					}
				}
				
			} 
		} else {
			if (is_numeric($search_data)) {
				if (($category = $this->getCategoryData((int)$search_data)) !== false) {
					if (($products = $this->getCategoryProducts((int)$search_data, $page, $per_page)) !== false) {
						$this->_category_products = $products;
					}
					return true;
				}
			} else if (strtolower($search_data) == 'sale') {
				if (isset($_GET['sort']) && is_array($_GET['sort'])) {
					foreach ($_GET['sort'] as $field => $direction) {
						$order[$field]	= (strtolower($direction) == 'asc') ? 'ASC' : 'DESC';
						break;
					}
				} else {
					$order['name'] = 'ASC';
				}
				
				$where2 = $this->outOfStockWhere(false, 'I', true);
				$whereString = 'IF (G.sale_price IS NULL, I.sale_price, G.sale_price) > 0'.$where2;
				$query = sprintf("SELECT I.* FROM %1\$sCubeCart_inventory AS I LEFT JOIN (SELECT product_id, MAX(price) as price, MAX(sale_price) as sale_price FROM %1\$sCubeCart_pricing_group $group_id GROUP BY product_id) as G ON G.product_id = I.product_id $joinString WHERE I.product_id IN (SELECT product_id FROM `%1\$sCubeCart_category_index` as CI INNER JOIN %1\$sCubeCart_category as C where CI.cat_id = C.cat_id AND C.hide = 0) AND I.status = 1 AND %2\$s %3\$s %4\$s", $GLOBALS['config']->get('config', 'dbprefix'), $whereString, $order_string, $limit);
				if (($sale = $GLOBALS['db']->query($query)) !== false) {
					$q2 = sprintf("SELECT I.* FROM %1\$sCubeCart_inventory AS I LEFT JOIN (SELECT product_id, MAX(price) as price, MAX(sale_price) as sale_price FROM %1\$sCubeCart_pricing_group $group_id GROUP BY product_id) as G ON G.product_id = I.product_id $joinString WHERE I.product_id IN (SELECT product_id FROM `%1\$sCubeCart_category_index` as CI INNER JOIN %1\$sCubeCart_category as C where CI.cat_id = C.cat_id AND C.hide = 0) AND I.status = 1 AND %2\$s %3\$s", $GLOBALS['config']->get('config', 'dbprefix'), $whereString, $order_string);
					$count	= $GLOBALS['db']->query($q2);
					$this->_category_count		= (int)count($count);
					$this->_category_products	= $sale;
				}
			}
		}

		return false;
	}

	public function outOfStockWhere($original = false, $label = false, $force = false) {

		$def = $original ? str_replace('WHERE ','', $GLOBALS['db']->where('CubeCart_inventory', $original)) : '';

		if ($GLOBALS['config']->get('config','hide_out_of_stock') && !Admin::getInstance()->is()) {
			$def .= ($force || $def) ? ' AND' : '';
			$oos = sprintf('%1$s ((%2$s.stock_level > 0 AND %2$s.use_stock_level = 1) OR %2$s.use_stock_level = 0)', $def, ($label ? $label : sprintf('%sCubeCart_inventory',$GLOBALS['config']->get('config', 'dbprefix'))));
		}
		return ($GLOBALS['config']->get('config','hide_out_of_stock') && !Admin::getInstance()->is()) ? $oos : $def;
	}

	//=====[ Private ]===================================================================================================

	private function _categoryTranslation() {
		if (isset($GLOBALS['language']) && !empty($GLOBALS['language'])) {
			if (($result = $GLOBALS['db']->select('CubeCart_category_language', array('cat_name', 'cat_desc'), array('cat_id' => $this->_categoryData['cat_id'], 'language' => $GLOBALS['language']))) !== false) {
				$this->_categoryData['cat_name']	= $result[0]['cat_name'];
				$this->_categoryData['cat_desc']	= $result[0]['cat_desc'];
				return true;
			}
		}
		return false;
	}

	private function _displayProductOptions($product_id = null) {
		if (isset($product_id) && is_numeric($product_id)) {
			$optionArray = $this->getProductOptions($product_id);
			if (is_array($optionArray)) {
				foreach ($optionArray as $type => $group) {
					switch ($type) {
						case self::OPTION_SELECT:		## Dropdown options
							foreach ($group as $key => $option) {
							    $group_priority = $option['priority'];
							    unset ($option['priority']);
								foreach ($option as $value) {
									if (!isset($option_list[$value['option_id']])) {
										$option_list[$value['option_id']]	= array(
											'type'			=> $value['option_type'],
											'option_id'		=> $value['option_id'],
											'option_name'	=> $value['option_name'],
											'required'		=> (bool)$value['option_required'],
										);
									}
									$option_list[$value['option_id']]['values'][] = array(
										'assign_id'		=> $value['assign_id'],
										'price'			=> (isset($value['option_price']) && $value['option_price']>0) ? $GLOBALS['tax']->priceFormat($value['option_price'], true) : false,
										'symbol'		=> (isset($value['option_price']) && $value['option_negative'] == 0) ? '+' : '-',
										'value_id'		=> $value['value_id'],
										'value_name'	=> $value['value_name'],
									);
								}
								$option_list[$value['option_id']]['priority'] = $group_priority;
							}
							break;
						case self::OPTION_TEXTBOX:		## Textbox options
						case self::OPTION_TEXTAREA:		## Textarea option
							foreach ($group as $key => $option) {
								$option_list[] = array(
									'type'			=> $option[0]['option_type'],
									'option_id'		=> $option[0]['option_id'],
									'option_name'	=> $option[0]['option_name'],
									'required'		=> (bool)$option[0]['option_required'],
									'price'			=> (isset($option[0]['option_price'])) ? $GLOBALS['tax']->priceFormat($option[0]['option_price'], false) : false,
									'symbol'		=> (isset($option[0]['option_price']) && $option[0]['option_negative'] == 0) ? '+' : '-',
									'priority'      => $option['priority'],
								);
							}
							break;
					}
				}
				uasort($option_list, 'cmpmc'); // sort groups
				return $option_list;
			}
		}

		return false;
	}

	private function _productGallery($product_id = false) {
		if (isset($product_id) && is_numeric($product_id)) {
			$skins = $GLOBALS['gui']->getSkinData();
			if (isset($skins['images'])) {
				$image_types[] = 'source';
				foreach ($skins['images'] as $name => $values) {
					$image_types[] = $name;
				}
			}
			$image_types[] = 'source';

			// Look for images
			if (($gallery = $GLOBALS['db']->select('CubeCart_image_index', false, array('product_id' => $product_id), array('main_img' => 'DESC'))) !== false) {
				$duplicates = array();
				foreach ($gallery as $key => $image) {
					if (is_array($image_types) && !in_array($image['img'],$duplicates)) {
						$duplicates[] = $image['img'];
						foreach ($image_types as $type) {
							$source = ($image['file_id']) ? $image['file_id'] : $image['img'];
							$image[$type] = $this->imagePath($source, $type);
						}
						$return[] = $image;
						$json['image_'.$image['id']] = $image;
					}
				}
				$GLOBALS['smarty']->assign('GALLERY_JSON', json_encode($json));
				return $return;
			}
		}
		$GLOBALS['smarty']->assign('GALLERY_JSON', "''");

		return false;
	}

	private function _productPopularity($product_id = false) {
		if ($product_id && is_numeric($product_id)) {
			$GLOBALS['db']->update('CubeCart_inventory', array('popularity' => '+1'), array('product_id' => (int)$product_id), false);
			return true;
		}

		return false;
	}
}