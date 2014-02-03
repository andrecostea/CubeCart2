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
 * Cart controller
 *
 * @author Technocrat
 * @author Sir William
 * @version 1.1.0
 * @since 5.0.0
 */
class Cart {
	/**
	 * Current basket
	 *
	 * @var array
	 */
	public $basket				= null;
	/**
	 * Basket data
	 *
	 * @var array
	 */
	public $basket_data			= false;
	/**
	 * Digital basket
	 *
	 * @var bool
	 */
	public $basket_digital		= false;

	/**
	 * Cart discount
	 *
	 * @var float
	 */
	private $_discount			= 0;
	/**
	 * Cart item discount flag
	 *
	 * @var bool
	 */
	private $_item_discount		= false;
	/**
	 * Shipping cost
	 *
	 * @var float
	 */
	private $_shipping			= 0;
	/**
	 * Shipping discount
	 *
	 * @var float
	 */
	private $_shipping_discount = 0;
	/**
	 * Cart subtotal
	 *
	 * @var float
	 */
	private $_subtotal			= 0;
	/**
	 * Cart total
	 *
	 * @var float
	 */
	private $_total				= 0;
	/**
	 * Cart weight
	 *
	 * @var float
	 */
	private $_weight			= 0;

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	final protected function __construct() {
		if ($GLOBALS['user']->is()) {
			if (($currency = $GLOBALS['user']->get('currency')) !== false) {
				if ($GLOBALS['config']->get('config', 'default_currency') != $currency) {
					$GLOBALS['tax']->loadCurrencyVars($currency);
				}
			}
		}

		//If the user just logged in try to autoload the cart
		if ($GLOBALS['session']->get('check_autoload')) {
			$GLOBALS['session']->delete('check_autoload');
			$this->autoload();
		}

		$tax_on	= ($GLOBALS['config']->get('config', 'basket_tax_by_delivery')) ? 'delivery_address' : 'billing_address';
		if (isset($this->basket[$tax_on])) {
			$tax_country	= (int)$this->basket[$tax_on]['country_id'];
		} else {
			$tax_country	= $GLOBALS['config']->get('config', 'store_country');
		}
		
		// Load Basket contents
		$this->load();

		if (!$GLOBALS['config']->get('config', 'basket_allow_non_invoice_address') && isset($_POST['delivery_address']) && is_numeric($_POST['delivery_address'])) {
			$this->basket['delivery_address'] = $GLOBALS['user']->getAddress((int)$_POST['delivery_address']);
		}

		if (isset($_POST['comments']) && !empty($_POST['comments'])) {
			$this->basket['comments'] = strip_tags(urldecode($_POST['comments']));
			$this->save();
		}

		if (isset($_POST['add'])) {
			// Check if productOptions SHOULD be present. i.e. add from category page
			if (!isset($_POST['productOptions'])) {
				if (is_array($_POST['add'])) {
					foreach($_POST['add'] as $key => $value) {
						if($GLOBALS['catalogue']->getProductOptions($key) && $GLOBALS['catalogue']->getOptionRequired()) {
							$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_option_required']);
							if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
								$GLOBALS['debug']->supress();
								die('Redir:'.$GLOBALS['seo']->buildURL('prod',$key));
							} else {
								httpredir("index.php?_a=product&product_id=$key");
							}
						}
					}
				}
				if(is_int($_POST['add'])) {
					$key = (int)$_POST['add'];
					if($GLOBALS['catalogue']->getProductOptions($key) && $GLOBALS['catalogue']->getOptionRequired()) {
						$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_option_required']);
						if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
							$GLOBALS['debug']->supress();
							die('Redir:'.$GLOBALS['seo']->buildURL('prod',$key));
						} else {
							httpredir("index.php?_a=product&product_id=$key");
						}
					}
				}
			}

			// Add item to basket
			if (is_array($_POST['add'])) {
				foreach ($_POST['add'] as $key => $value) {
					// Multi-product adding from category page
					if(is_numeric($value['quantity']) && $value['quantity'] > 1) {
						$quantity = (int)$value['quantity'];
					} else {
						$quantity = 1;
					}
					$this->add((is_numeric($value)) ? $value : $key, null, $quantity);
				}
			} else {
				$this->add((int)$_POST['add'], isset($_POST['productOptions']) ? $_POST['productOptions'] : null, (int)$_POST['quantity']);
			}
		}

		if (isset($_GET['remove-item']) && !empty($_GET['remove-item'])) {
			// Remove item from basket
			$this->remove($_GET['remove-item']);
			httpredir(currentPage(array('remove-item')));
		}
	}

	public function __destruct() {
		$this->save();
	}

	/**
	 * Setup the instance (singleton)
	 *
	 * @return Cart
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}

	//=====[ Public ]====================================================================================================

	/**
	 * Add item to the basket
	 *
	 * @param int $product_id
	 * @param array $optionsArray
	 * @param int $quantity
	 * @return bool
	 */
	public function add($product_id, $optionsArray = null, $quantity = 1) {
		foreach ($GLOBALS['hooks']->load('class.cart.add.pre') as $hook) include $hook;
		// Prevent quantities of less than one or non numerical user input
		if (!is_numeric($quantity) || $quantity < 1) {
			$quantity = 1;
		}

		// Don't allow products to be added to the basket if prices are hidden AND they're not logged in
		if ($GLOBALS['session']->get('hide_prices')) {
			if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
				$GLOBALS['debug']->supress();
				if($GLOBALS['config']->get('config','seo')) {
					die($GLOBALS['seo']->rewriteUrls("Redir:".currentPage(),true));
				}
				die("Redir:".currentPage());
			} else {
				httpredir(currentPage());
			}
		}
		// Handle gift certs
		$gc	= $GLOBALS['config']->get('gift_certs');

		if (isset($gc['product_code']) && $product_id == $gc['product_code'] && !empty($optionsArray)) {
			$hash = md5(recursive_implode('{@}', $optionsArray));
			if (isset($this->basket['contents'][$hash])) {
				// Increment quantity
				$this->basket['contents'][$hash]['quantity'] += $quantity;
				
				$product = $GLOBALS['catalogue']->getProductData($this->basket['contents'][$hash]['id']);
				$this->basket['contents'][$hash]['total_price_each'] = ($product['price']+$this->basket['contents'][$hash]['option_line_price']);
			} else {
				// Add to basket
				$this->basket['contents'][$hash] = array(
						'id'			=> $product_id,
						'quantity'		=> $quantity,
						'digital'		=> ($optionsArray['method'] == 'e') ? true : false,
						'certificate'	=> array(
							'value'			=> $optionsArray['value'],
							'name'			=> $optionsArray['name'],
							'email'			=> $optionsArray['email'],
							'message'		=> $optionsArray['message'],
						),
				);
			}
			$this->save();
			httpredir(($GLOBALS['config']->get('config', 'basket_jump_to')) ? $GLOBALS['rootRel'].'index.php?_a=basket' : currentPage(null));
			return true;
		} else if (!is_null($product_id) && is_numeric($product_id)) {
			$proceed = true;
			
			if(is_array($optionsArray)) {
				$query = 'SELECT `option_id`, `value_id` FROM `'.$GLOBALS['config']->get('config', 'dbprefix').'CubeCart_option_assign` WHERE `matrix_include` = 1 AND `assign_id` IN ('.implode(',',$optionsArray).') ORDER BY `option_id`, `value_id` ASC';
				$option_identifiers = $GLOBALS['db']->query($query);
				// Update product code & stock based on options matrix
				
				$options_identifier_string = '';
				foreach($option_identifiers as $option_identifier) {
					$options_identifier_string .= $option_identifier['option_id'].$option_identifier['value_id'];
				}
				
				$options_identifier_string = md5($options_identifier_string);
			}
			
			$product = $GLOBALS['catalogue']->getProductData($product_id, $options_identifier_string);
			
			if ($product) {
				// Check for options
				$options = $GLOBALS['catalogue']->getProductOptions($product_id);
				if ($GLOBALS['catalogue']->getOptionRequired() && ($options && empty($optionsArray))) {
					// Options needed - Redirect to product page
					// Set GUI_MESSAGE error, then redirect
					$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_option_required']);
					if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
						$GLOBALS['debug']->supress();
						die('Redir:'.$GLOBALS['seo']->buildURL('prod',$product_id));
					} else {
						httpredir("index.php?_a=product&product_id=$product_id");
					}
					return true;
				} else {
					
					// Check required options have a value!
					$quantity = (is_numeric($quantity) && $quantity > 0) ? $quantity : 1;
					$stock_level = $GLOBALS['catalogue']->getProductStock($product['product_id'], $options_identifier_string);
					
					// Check stock level
					if ($product['use_stock_level'] && !$GLOBALS['config']->get('config', 'basket_out_of_stock_purchase')) {
						if ($stock_level <= 0) {
							$max_stock	= 0;
						} else {
							$max_stock	= $stock_level;
						}
					}
					if (isset($max_stock) && $max_stock <= 0) {
						if(is_array($optionsArray)) {
							
							$stock_note = $GLOBALS['session']->has('restock_note') ? $GLOBALS['session']->get('restock_note') : '';
							$GLOBALS['session']->delete('restock_note');
							$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_no_stock_available_options'].' '.$stock_note);
							
						} else {
							$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_no_stock_available']);
						}
						if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
							$GLOBALS['debug']->supress();
							die('Redir:'.$GLOBALS['seo']->buildURL('prod',$product_id));
						} else {
							httpredir("index.php?_a=product&product_id=$product_id");
						}
						return false;
					}
					// Add item to basket
					$hash = md5($product['product_id'].((!empty($optionsArray)) ? $product['name'].recursive_implode('{@}', $optionsArray) : $product['name']));
					if (isset($this->basket['contents'][$hash])) {
						// Update quantity
						if (isset($max_stock)) {
							$current = $this->basket['contents'][$hash]['quantity'];
							$request = $current + $quantity;
							if ($request > $max_stock) {
								$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_too_many_added']);
								$quantity = $max_stock-$current;
								$stock_warning = true;
							}
						}
						$this->basket['contents'][$hash]['quantity'] += $quantity;
					} else {
						// Add to basket
						if (isset($max_stock) && $quantity > $max_stock) {
							$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_too_many_added']);
							$quantity = $max_stock;
							$stock_warning = true;
						}
						$this->basket['contents'][$hash] = array(
							'id'		=> $product_id,
							'quantity'	=> $quantity,
							'digital'	=> $product['digital'],
						);
						if ($options && !empty($optionsArray)) {
							// Add options to the basket item
							
							foreach ($optionsArray as $option_id => $option_value) {
								
								$required = $GLOBALS['db']->select('CubeCart_option_group', array('option_required', 'option_type'), array('option_id' => (int)$option_id));
								$require = ($required) ? (bool)$required[0]['option_required'] : false;
								$add_option	= true;
								if (is_array($option_value)) {
									foreach (array_values($option_value) as $value) {
										if ($add_option && !$this->_checkOption($value, $require)) {
											$add_option = false;
											$proceed 	= false;
										} else if (empty($option_value)) {
											$add_option = false;
										} else {
											$imploded = implode('', $option_value);
											if (empty($imploded)) {
												$add_option = false;
											}
										}
									}
								} else {
									if ($add_option && !$this->_checkOption($option_value, $require)) {
										$add_option = false;
										$proceed 	= false;
									} else if (empty($option_value) && !is_numeric($option_value)) {
										$add_option = false;
									}
								}
								if ($add_option) {
									$this->basket['contents'][$hash]['options'][$option_id] = $option_value;
								} else if (!$proceed) {
									// Product can't be added without required option
									unset($this->basket['contents'][$hash]);
									break;
								}
							}
							
							$this->basket['contents'][$hash]['options_identifier'] = $options_identifier_string;
							
							if (!$proceed) {
								// No required options selected
								if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
									$GLOBALS['debug']->supress();
									$GLOBALS['gui']->setError($GLOBALS['language']->catalogue['error_option_required']);
									die('Redir:'.$GLOBALS['seo']->buildURL('prod',$product_id));
								} else {
									httpredir(currentPage(null, array('error' => 'option')));
								}
								return false;
							}
						}
					}

					foreach ($GLOBALS['hooks']->load('class.cart.add.save') as $hook) include $hook;

					//Save before the jump
					$this->save();
					// Jump to basket, or return to product page?
					$jumpto = ($GLOBALS['config']->get('config', 'basket_jump_to')) ? $GLOBALS['rootRel'].'index.php?_a=basket' : currentPage(null);
					if (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd' && $GLOBALS['config']->get('config', 'basket_jump_to')) {
						$GLOBALS['debug']->supress();
						if($GLOBALS['config']->get('config','seo')) {
							die($GLOBALS['seo']->rewriteUrls("Redir:".$jumpto,true));
						} else {
							die('Redir:'.$jumpto);
						}
					} elseif (isset($_GET['_g']) && $_GET['_g'] == 'ajaxadd') {
						$GLOBALS['debug']->supress();
						if($stock_warning) {
							die('Redir:'.$GLOBALS['rootRel'].'index.php?_a=basket');
						}
					} else {
						httpredir($jumpto);
					}

					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Autoload saved cart
	 *
	 * If the cart already has items in it then we will not autoload as we assume
	 * they have what they want already
	 */
	public function autoload() {
		if ($GLOBALS['config']->get('config', 'auto_save_cart') && ($result = $GLOBALS['db']->select('CubeCart_saved_cart', array('basket'), array('customer_id' => $GLOBALS['user']->getId()))) !== false) {
			$basket = $GLOBALS['session']->get('', 'basket');
			if (empty($basket) || !isset($basket['contents'])) {
				$this->basket['contents'] = unserialize($result[0]['basket']);
				$this->save();
			}

		}
	}

	/**
	 * Clear basket
	 *
	 * @return bool
	 */
	public function clear() {
		$this->basket = null;
		$GLOBALS['session']->delete('', 'basket');

		$GLOBALS['db']->delete('CubeCart_saved_cart', array('customer_id' => $GLOBALS['user']->getId()));
		foreach ($GLOBALS['hooks']->load('class.cart.clear') as $hook) include $hook;
		return true;
	}

	/**
	 * Add a discount to the cart
	 *
	 * @param int $code
	 * @return bool
	 */
	public function discountAdd($code) {
		if (!is_null($code) && !empty($code)) {
			if (($coupon = $GLOBALS['db']->select('CubeCart_coupons', '*', array('code' => $code, 'status' => '1'))) !== false) {

				$order = false;

				if ($coupon[0]['cart_order_id'])
				$order = $GLOBALS['db']->select('CubeCart_order_summary','status',array('cart_order_id' => $coupon[0]['cart_order_id']));

				$coupon	= $coupon[0];
				// only allow multiple discount codes for gift certificates!
				if(empty($coupon['cart_order_id'])) {
					unset($this->basket['coupons']);
				}
				
				if($coupon['expires']!=='0000-00-00' && (strtotime($coupon['expires']) < time())) {
					// Coupon is no longer valid
					$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_expired']);
					return false;
				}
				if($order && !in_array($order[0]['status'], array(2,3))) {
					// Check order is still valid!
					$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_expired']);
					return false;
				}
				if ($coupon['allowed_uses'] > 0 && ($coupon['count'] >= $coupon['allowed_uses'])) {
					// Coupon is no longer valid
					$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_expired']);
					return false;
				}
				if ($coupon['min_subtotal'] > 0 && $coupon['min_subtotal'] > $this->basket['subtotal']) {
					// Minimum subtotal for voucher has not been met
					$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_product']);
					return false;
				}

				$proceed = false;

				$qualifying_products = unserialize($coupon['product_id']);

				// pull the first item off as it's our orders to be inclusive or exclusive
				$incexc = array_shift($qualifying_products);
				// this will handle legacy coupons so we don't lose any products from them
				if(is_numeric($incexc)) {
					array_unshift($qualifying_products, $incexc);
					$incexc = 'include';	
				}

				if (is_array($qualifying_products) && count($qualifying_products)>0) {

					foreach($qualifying_products as $id){
						$product_ids[$id] = true;
					}
					foreach ($this->basket['contents'] as $key => $data) {
						if ($product_ids[$data['id']]) {
							$proceed = true;
							break;
						}
					}
					if(!$proceed && $incexc == 'include') {
						$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_wrong_product']);
						return false;
					} else {
						$proceed = true;
					}
				} else {
					$proceed = true;
				}
				foreach ($GLOBALS['hooks']->load('class.cart.discount_add') as $hook) include $hook;
				if ($proceed) {
					// Add a coupon to the array
					$type	= ($coupon['discount_percent'] > 0) ? 'percent' : 'fixed';
					$value	= ($coupon['discount_percent'] > 0) ? $coupon['discount_percent'] : $coupon['discount_price'];
					if($value>0) {
						$this->basket['coupons'][strtoupper($coupon['code'])] = array(
							'voucher'	=> $coupon['code'],
							'gc'		=> (!empty($coupon['cart_order_id'])) ? true : false,
							'type'		=> $type,
							'value'		=> $value,
							'available'	=> ($coupon['allowed_uses'] > 0) ? $coupon['allowed_uses']-$coupon['count'] : 0,
							'product'	=> $coupon['product_id'],
							'shipping'	=> (bool)$coupon['shipping'],
						);
						return true;
					} else {
						$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_expired']);
						return false;
					}
				}
			} else {
				$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_voucher_none']);
			}
		}

		return false;
	}

	/**
	 * Remove discount from cart
	 *
	 * @param int $code
	 * @return bool
	 */
	public function discountRemove($code) {
		if ($code && isset($this->basket['coupons'][strtoupper($code)])) {
			unset($this->basket['coupons'][strtoupper($code)]);
			$this->save();
			return true;
		}

		return false;
	}

	/**
	 * Get the current basket
	 *
	 * @return baket/false
	 */
	public function get() {
		if ($GLOBALS['session']->get('hide_prices')) {
			return false;
		}

		if (!empty($this->basket['contents']) && is_array($this->basket['contents'])) {
			$this->_discount = $this->_subtotal = $this->_total_tax_add = $this->_weight = 0;
			// Include inline shipping maths for Per Category Shipping
			$ship_by_cat = $GLOBALS['config']->get('Per_Category');
			if (isset($ship_by_cat['status']) && $ship_by_cat['status']) {
				require_once(CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'shipping'.CC_DS.'Per_Category'.CC_DS.'line.inc.php');
				$line_shipping	= new Per_Category_Line($ship_by_cat,$this->basket);
			}

			$tax_on	= ($GLOBALS['config']->get('config', 'basket_tax_by_delivery')) ? 'delivery_address' : 'billing_address';
			$tax_country = 0;
			
			if (isset($this->basket[$tax_on])) {
				$tax_country = (int)$this->basket[$tax_on]['country_id'];
			}

			if(empty($tax_country)) {
				$tax_country = $GLOBALS['config']->get('config', 'store_country');
			}

			$GLOBALS['tax']->loadTaxes($tax_country);

			foreach ($this->basket['contents'] as $hash => $item) {
				if (empty($item) || !is_array($item)) {		## Keep things tidy
					unset($this->basket['contents'][$hash]);
					continue;
				}
				$option_price_ignoring_tax = '0';
				// Basket Contents
				if (is_numeric($item['id'])) {

					$product = $GLOBALS['catalogue']->getProductData($item['id'], $item['quantity'], false, 10, 1, false, $item['options_identifier']);
					$product['quantity'] = $item['quantity'];
					if ($GLOBALS['tax']->salePrice($product['price'], $product['sale_price'])) {
						$product['price'] = $product['sale_price'];
					}
					$product['price_display'] = $product['price'];
					$product['base_price_display'] = $GLOBALS['tax']->priceFormat($product['price'], true);
					$remove_options_tax = false;
					if ($product['tax_inclusive']) {
						// Remove tax from the items by default, everything internally should be sans-tax
						$GLOBALS['tax']->inclusiveTaxRemove($product['price'], $product['tax_type']);
						$product['tax_inclusive'] = false;
						$remove_options_tax = true;
					}
					if (isset($item['options']) && is_array($item['options'])) {
						$option_line_price = 0;
						foreach ($item['options'] as $option_id => $option_data) {
							if (is_array($option_data)) {
								// Text option
								foreach ($option_data as $trash => $option_value) {
									if (($assign_id = $GLOBALS['db']->select('CubeCart_option_assign', false, array('product' => (int)$item['id'], 'option_id' => $option_id))) !== false) {
										$assign_id = $assign_id[0]['assign_id'];
									} else {
										$assign_id = 0;
									}
									$value = $GLOBALS['catalogue']->getOptionData((int)$option_id, $assign_id);
									if ($value) {
										$value['price_display'] = '';
										if ($value['option_price']>0) {
											$display_option_tax = $value['option_price'];
											if($remove_options_tax) {
												$GLOBALS['tax']->inclusiveTaxRemove($value['option_price'], $product['tax_type']);
											}
											
											if (isset($value['option_negative']) && $value['option_negative']) {
												$product['price'] -= $value['option_price'];
												$option_line_price -= $value['option_price'];
												$option_price_ignoring_tax -= $display_option_tax;
												$value['price_display'] = '-';
											} else {
												$product['price'] += $value['option_price'];
												$option_line_price += $value['option_price'];
												$option_price_ignoring_tax += $display_option_tax;
												$value['price_display'] = '+';
											}
											$value['price_display'] .= $GLOBALS['tax']->priceFormat($display_option_tax, true);
										}
										$product['product_weight'] += (isset($value['option_weight'])) ? $value['option_weight'] : 0;
										$value['value_name']	= $option_value;
										$product['options'][]	= $value;
									}
								}
							} else if (is_numeric($option_data)) {
								// Select option
								if (($value = $GLOBALS['catalogue']->getOptionData((int)$option_id, (int)$option_data)) !== false) {
									$value['price_display'] = '';
									if ($value['option_price']>0) {
										$display_option_tax = $value['option_price'];
											if($remove_options_tax) {
												$GLOBALS['tax']->inclusiveTaxRemove($value['option_price'], $product['tax_type']);
											}
										if (isset($value['option_negative']) && $value['option_negative']) {
											$option_line_price -= $value['option_price'];
											$product['price'] -= $value['option_price'];
											$option_price_ignoring_tax -= $display_option_tax;
											$value['price_display'] = '-';
										} else {
											$option_line_price += $value['option_price'];
											$product['price'] += $value['option_price'];
											$option_price_ignoring_tax += $display_option_tax;
											$value['price_display'] = '+';
										}
										$value['price_display'] .= $GLOBALS['tax']->priceFormat($display_option_tax, true);
									}
									$product['product_weight'] += (isset($value['option_weight'])) ? $value['option_weight'] : 0;
									$product['options'][]	= $value;
								}
							}
						}
					} else {
						$product['options']	= false;
					}
					// Product Discounts
					$this->_applyProductDiscount($product['price'], $item['id'], $item['quantity']);

					// Add the total product price inc options etc for payment gateways
					$this->basket['contents'][$hash]['option_line_price'] = $option_line_price;
					$this->basket['contents'][$hash]['total_price_each'] = $product['price'];
					$this->basket['contents'][$hash]['description'] 	 = substr(strip_tags($product['description']), 0, 255);
					$this->basket['contents'][$hash]['name'] 			 = $product['name'];
					$this->basket['contents'][$hash]['product_code'] 	 = $product['product_code'];
					$this->basket['contents'][$hash]['product_weight'] 	 = $product['product_weight'];
				} else {
					if (!isset($item['certificate'])) {
						 continue;
					}
					$gc	= $GLOBALS['config']->get('gift_certs');
					$product = array(
						'quantity'		=> $item['quantity'],
						'product_code'	=> $gc['product_code'],
						'price'			=> $GLOBALS['tax']->priceCorrection($item['certificate']['value']),
						'name'			=> sprintf('%s (%s)', $GLOBALS['language']->catalogue['gift_certificate'], $GLOBALS['tax']->priceFormat($item['certificate']['value'], true)),
						'digital'		=> (bool)$item['digital'],
						'tax_type'		=> $gc['taxType'],
						'tax_inclusive'	=> true,
						'options'		=> array(
						#	'Recipient' => $item['certificate']['name'],
						#	'Message'	=> $item['certificate']['message'],
						),
					);
					$product['price_display'] = $product['price'];
				}
				if ($product['digital']) {
					$this->basket_digital = true;
				}

				$product['line_price_display']	= $GLOBALS['tax']->priceCorrection($product['price_display']+$option_price_ignoring_tax);
				$product['price_display']		= $GLOBALS['tax']->priceCorrection(($product['price_display']+$option_price_ignoring_tax)*$item['quantity']);


				## Update Subtotals
				$product['line_price']	= $product['price'];
				$product['price']		= $GLOBALS['tax']->priceCorrection($product['price'] * $item['quantity']);

				$this->_subtotal		+= $product['price'];
				$this->_weight			+= $product['quantity'] * $product['product_weight'];

				$this->basket_data[$hash] = $product;

				// Calculate Taxes
				$tax_state_id = is_numeric($this->basket[$tax_on]['state_id']) ? $this->basket[$tax_on]['state_id'] : getStateFormat($this->basket[$tax_on]['state_id'], 'name', 'id');

				if (isset($tax_state_id)) {
					$product_tax =  $GLOBALS['tax']->productTax($product['price'], (int)$product['tax_type'], (bool)$product['tax_inclusive'], $tax_state_id);
				} else {
					$product_tax =  $GLOBALS['tax']->productTax($product['price'], (int)$product['tax_type'], (bool)$product['tax_inclusive']);
				}
				
				$this->basket['contents'][$hash]['tax_each'] = $product_tax;

				// Calculate Line Shipping Price if enabled
				if (isset($ship_by_cat['status']) && $ship_by_cat['status']) {
					$assigned_categories = $GLOBALS['catalogue']->getCategoryStatusByProductID($product['product_id']);
					foreach($assigned_categories as $assigned_category) {
						if($assigned_category['primary']) {
							$assigned_category_id = $assigned_category['cat_id'];
							continue;
						}
					}
					$category	= $GLOBALS['catalogue']->getCategoryData($assigned_category_id);
					$line_shipping->lineCalc($product, $category);
				}
			}
			// Put By_Cat shipping prices into basket for calc class
			if (isset($ship_by_cat['status']) && $ship_by_cat['status']) {
				$this->basket['By_Category_Shipping'] =  $line_shipping->_lineShip + $line_shipping->_perShipPrice;
			}
			// Shipping
			$this->_shipping = (isset($this->basket['shipping']) && !empty($this->basket['shipping'])) ? $this->basket['shipping']['value']: 0;

			if (isset($this->basket[$tax_on]['state_id']) && isset($this->basket['shipping'])) {
				$GLOBALS['tax']->productTax($this->_shipping, $this->basket['shipping']['tax_id'], false, $this->basket[$tax_on]['state_id'], 'shipping');
			}

			// Apply Discounts
			$this->_applyDiscounts();

			$this->basket['weight']		= sprintf('%.3f', $this->_weight);
			$this->basket['discount']	= sprintf('%.2f', $this->_discount);
			$this->basket['subtotal']	= sprintf('%.2f', $this->_subtotal);
			$taxes = $GLOBALS['tax']->fetchTaxAmounts();
			foreach ($GLOBALS['hooks']->load('class.cart.get.fetchtaxes') as $hook) include $hook;
			$this->basket['total_tax']	= sprintf('%.2f', $taxes['applied']);

			$this->_total = (($this->_subtotal + $this->_shipping) + $this->basket['total_tax']);
			// if we are using per-product coupon, the prices are already reduced, so the total is fine
			if(!$this->_item_discount) $this->_total -= $this->_discount;
			
			if ($this->_total < 0) {
				$this->_total = 0;
			}
			$this->basket['total'] = sprintf('%.2f',$this->_total);

			foreach ($GLOBALS['hooks']->load('class.cart.get') as $hook) include $hook;

			$this->save();

			return $this->basket_data;
		}

		return false;
	}

	/**
	 * Is it a digital basket
	 *
	 * @return bool
	 */
	public function getBasketDigital() {
		return $this->basket_digital;
	}

	/**
	 * Current subtotal
	 *
	 * @return float
	 */
	public function getSubTotal() {
		return $this->_subtotal;
	}

	/**
	 * Current total
	 *
	 * @return float
	 */
	public function getTotal() {
		return $this->_total;
	}

	/**
	 * Current weight
	 *
	 * @return float
	 */
	public function getWeight() {
		return $this->_weight;
	}

	/**
	 * Load current basket
	 *
	 * @return bool
	 */
	public function load() {
		// Load previously saved basket
		if (($this->basket = $GLOBALS['session']->get('', 'basket')) !== false) {
			return true;
		}

		return false;
	}

	/**
	 * Load shipping modules
	 *
	 * @return array / false
	 */
	public function loadShippingModules() {

		if (($shipping = $GLOBALS['db']->select('CubeCart_modules', array('folder', 'countries'), array('module' => 'shipping', 'status' => '1'))) !== false) {

			// isset is critical to prevent loop!
			if(isset($this->basket['shipping_verified']) && !$this->basket['shipping_verified']) {
				unset($this->basket['shipping']);
			}

			// Fetch the basket data
			$basket_data = ($this->basket) ? $this->basket : false;
			if (!isset($basket_data['delivery_address'])) {
				$basket_data['delivery_address'] = array(
					'user_defined'	=> false,
					'postcode'		=> $GLOBALS['config']->get('config', 'store_postcode'),
					'country'		=> $GLOBALS['config']->get('config', 'store_country'),
					'country_iso'	=> getCountryFormat($GLOBALS['config']->get('config', 'store_country'),'numcode','iso'),
					'country_iso3'	=> getCountryFormat($GLOBALS['config']->get('config', 'store_country'),'numcode','iso3'),
					'state_id'		=> $GLOBALS['config']->get('config', 'store_zone'),
					'state'			=> getStateFormat($GLOBALS['config']->get('config', 'store_zone')),
					'state_abbrev' => getStateFormat($GLOBALS['config']->get('config', 'store_zone'),'id','abbrev')
				);
				$this->basket['delivery_address'] = $basket_data['delivery_address'];
			}
			if (!isset($basket_data['billing_address'])) {
				$basket_data['billing_address'] = array(
					'user_defined'	=> false,
					'postcode'	=> $GLOBALS['config']->get('config', 'store_postcode'),
					'country'	=> $GLOBALS['config']->get('config', 'store_country'),
					'country_iso'	=> getCountryFormat($GLOBALS['config']->get('config', 'store_country'),'numcode','iso'),
					'country_iso3'	=> getCountryFormat($GLOBALS['config']->get('config', 'store_country'),'numcode','iso3'),
					'state_id'	=> $GLOBALS['config']->get('config', 'store_zone'),
					'state'		=> getStateFormat($GLOBALS['config']->get('config', 'store_zone')),
					'state_abbrev' => getStateFormat($GLOBALS['config']->get('config', 'store_zone'),'id','abbrev')
				);
				$this->basket['billing_address'] = $basket_data['billing_address'];
			}
			foreach ($basket_data['contents'] as $hash => $item) {
				if ($item['digital']) unset($basket_data['contents'][$hash]);
			}
			if (!empty($basket_data['contents'])) {
				foreach ($shipping as $module) {
					$module['countries'] = Config::getInstance()->get($module['folder'], 'countries');
					$countries = (!empty($module['countries'])) ? unserialize($module['countries']) : false;

					$module['disabled_countries'] = Config::getInstance()->get($module['folder'], 'disabled_countries');
					$disabled_countries	= (!empty($module['disabled_countries'])) ? unserialize($module['disabled_countries']) : false;

					if ($this->checkShippingModuleCountry($countries,'enabled') || $this->checkShippingModuleCountry($disabled_countries,'disabled')) {
					    continue;
					}

					$class = CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'shipping'.CC_DS.$module['folder'].CC_DS.'shipping.class.php';
					if (file_exists($class)) {
						// Version 5 Shipping Calculators
						// fix for duplicate shipping module entries in config table
						if(!class_exists($module['folder'])) include $class;
						
						if (class_exists($module['folder']) && method_exists((string)$module['folder'], 'calculate')) {
							$shipping		= new $module['folder']($basket_data);
							$packages		= $shipping->calculate();
							if ($packages) {
								uasort($packages, 'price_sort');
								$shipArray[$module['folder']]	= $packages;
							}
						}
					} else {
						// Version 4 Shipping Calculators
						$calculator = CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'shipping'.CC_DS.$module['folder'].CC_DS.'calc.php';
						if (file_exists($calculator)) {
							include $calculator;
						}
					}
				}
				
				foreach ($GLOBALS['hooks']->load('class.cart.load_shipping') as $hook) include $hook;
				
				if (isset($shipArray) && is_array($shipArray)) {
					$this->save();
					return $shipArray;
				} else {
				    // No shipping option is available due to Allowed/Disabled zones restriction
				    $this->save();
					return false;
				}
			} else {
				// No shipping is required due to nothing tangible in cart to ship
				$this->save();
				return false;
			}
		} else {
			$GLOBALS['cart']->set('shipping', 0);
			$this->save();
			return false;
		}
	}


	public function checkShippingModuleCountry($countries,$zone) {

		$_country = $country_match = false;

		if(is_array($countries)) {

			foreach($countries as $country) {
				if($this->basket['delivery_address']['country_id'] == $country || $this->basket['delivery_address']['country'] == $country) {
					$country_match = true;
				}
			}
			$_country = (($zone=='enabled' && !$country_match) || ($zone=='disabled' && $country_match)) ? true : false;
		}
	
	    return $_country;
	}

	/**
	 * Remove an item from the basket
	 *
	 * @param int $identifier
	 * @return bool
	 */
	public function remove($identifier) {
		// Remove an item from the basket
		if (!is_null($identifier) && isset($this->basket['contents'][$identifier])) {
			unset($this->basket['contents'][$identifier]);
			$this->save();
			return $this->update();
		}
		return false;
	}

	/**
	 * Save basket
	 */
	public function save() {
		$GLOBALS['session']->set('', $this->basket, 'basket', true);
		//Only care about auto saving the cart if there is something in there
		if (!empty($this->basket) && isset($this->basket['contents'])) {
			if ($GLOBALS['user']->is() && $GLOBALS['config']->get('config', 'auto_save_cart')) {
				static $old_basket = null;
				$id = $GLOBALS['user']->getId();
				$basket = serialize($this->basket['contents']);
				if (empty($old_basket) || $old_basket != $basket) {
					$old_basket = $basket;
					if ((Database::getInstance()->count('CubeCart_saved_cart', 'customer_id', array('customer_id' => $id))) !== false) {
						$GLOBALS['db']->update('CubeCart_saved_cart', array('basket' => $basket), array('customer_id' => $id));
					} else {
						$GLOBALS['db']->insert('CubeCart_saved_cart', array('customer_id' => $id, 'basket' => $basket));
					}
				}
			}
		}
	}

	/**
	 * Set basket item
	 *
	 * @param mixed $identifier
	 * @param mixed $value
	 */
	public function set($identifier, $value) {
		$this->basket[$identifier] = $value;
		$this->save();
	}

	/**
	 * Update basket
	 */
	public function update() {
		// Update basket values and such - possibly to the database too
		if (isset($_POST['quan']) && is_array($_POST['quan'])) {
			$this->_subtotal = 0;
			foreach ($_POST['quan'] as $hash => $quantity) {
				if ($quantity <= 0) {
					unset($this->basket['contents'][$hash]);
				} else {
					$product = $GLOBALS['catalogue']->getProductData($this->basket['contents'][$hash]['id']);
					$stock_level = $GLOBALS['catalogue']->getProductStock($product['product_id'], $this->basket['contents'][$hash]['options_identifier']);
					if ($product['use_stock_level'] && !$GLOBALS['config']->get('config', 'basket_out_of_stock_purchase')) {
						if ($stock_level <= 0) {
							$max_stock	= 0;
						} else {
							$max_stock	= $stock_level;
						}
					}
					if (isset($max_stock)) {
						if (isset($max_stock) && $quantity > $max_stock) {
							$GLOBALS['gui']->setError($GLOBALS['language']->checkout['error_too_many_added']);
							$quantity = $max_stock;
						}
					}
					$this->basket['contents'][$hash]['quantity'] = $quantity;
					$product_data['product_id'] = (int)$this->basket['contents'][$hash]['id'];
					$this->basket['contents'][$hash]['total_price_each'] = ($product['price']+$this->basket['contents'][$hash]['option_line_price']);
					
					$this->_subtotal += $this->basket['contents'][$hash]['total_price_each'] * $quantity;
					$this->basket['subtotal'] = $this->_subtotal;
				}
			}
			foreach ($GLOBALS['hooks']->load('class.cart.update') as $hook) include $hook;
			$this->save();

			//We need to check the coupons to make sure they are still valid
			if (isset($this->basket['coupons']) && is_array($this->basket['coupons'])) {
				foreach ($this->basket['coupons'] as $key => $data) {
					$this->discountRemove($key);
					$this->discountAdd($key);
				}
			}
			$this->_applyDiscounts();
		}

		//If the cart is empty
		if (count($this->basket['contents']) == 0) {
			$this->clear();
		}
	}

	//=====[ Private ]===================================================================================================

	/**
	 * Apply a discount to the cart
	 *
	 * @return bool
	 */
	private function _applyDiscounts() {
		if (isset($this->basket['coupons']) && is_array($this->basket['coupons'])) {
			foreach ($this->basket['coupons'] as $key => $data) {
				// Product specific discounts should already have been calculated
				if ($this->_item_discount) {
					continue;
				}
				if ($data['gc']) {
					$remainder	= $data['value'];
					foreach ($this->basket['contents'] as $hash => $item) {
						$price = $item['total_price_each'] * $item['quantity'];
						if ($remainder > 0 && $price > 0) {
							if ($remainder <= $price) {
								$discount = $remainder;
								$remainder = 0;
							} else {
								$discount = $price;
								$remainder -= $price;
							}
							$this->_discount += $discount;
						}
					}
					if ($remainder > 0 && $this->_shipping > 0) {
						if ($this->_shipping <= $remainder) {
							$remainder -= $this->_shipping;
							$this->_shipping = 0;
						} else {
							$this->_shipping -= $remainder;
							$remainder = 0;
						}
					}
					// Set remainder/usage value
					$this->basket['coupons'][$key]['remainder'] = $remainder;
				} else {
					switch ($data['type']) {
						case 'percent':
							if ($data['shipping']) {
								$discount = $this->_shipping*($data['value']/100);
							} else {
								$discount = ($this->_subtotal-$this->_discount)*($data['value']/100);
							}
							$this->basket['coupons'][$key]['discount_value'] = $discount;
							$this->_discount += $discount;
							break;
						case 'fixed':
						default:
							$discount = $data['value'];
							if ($data['shipping'] && $this->_shipping < $discount) {
								$discount = $this->_shipping;
							} else if ($this->_subtotal < $discount) {
								$discount = $this->_subtotal;
							}
							$this->_discount += $discount;
					}
				}
			}
			$this->save();
			return true;
		}

		return false;
	}

	/**
	 * Apply product discount
	 *
	 * @param float $price
	 * @param int $product_id
	 * @param int $quantity
	 */
	private function _applyProductDiscount(&$price, $product_id, $quantity = 1) {
		// Apply 'assigned product' discounts on a per-product basis
		if (isset($product_id) && is_numeric($product_id)) {
			if (isset($this->basket['coupons']) && is_array($this->basket['coupons'])) {
				foreach ($this->basket['coupons'] as $key => $data) {
					$products = unserialize($data['product']);
					$incexc = array_shift($products);
					if ($incexc == 'include' && in_array($product_id, $products)) {
						switch ($data['type']) {
							case 'percent':
								$discount	= $price*($data['value']/100);
								break;
							case 'fixed':
							default:
								$available	= ($quantity > $data['available']) ? $data['available'] : $quantity;
								$discount	= (($price / $quantity) < $data['value']) ? ($price / $quantity) * $available : $data['value'] * $available;
						}
						$this->_discount += $discount;
						$price -= $discount;
					} elseif ($incexc == 'exclude' && !in_array($product_id, $products)) {
						switch ($data['type']) {
							case 'percent':
								$discount	= $price*($data['value']/100);
								break;
							case 'fixed':
							default:
								$available	= ($quantity > $data['available']) ? $data['available'] : $quantity;
								$discount	= (($price / $quantity) < $data['value']) ? ($price / $quantity) * $available : $data['value'] * $available;
						}
						$this->_discount += $discount;
						$price -= $discount;
					// Cover old coupons
					} elseif($data['product']==0 || !is_array($products)) {
                        $products = array();
					}
					// if we're including or excluding ANY products, whether in the cart or not,
					// we need to block full cart discounts
					if(count($products) > 0) $this->_item_discount = true;
				}
			}
		}

		$this->save();
	}

	/**
	 * Check option choice
	 *
	 * @param mixed $value
	 * @param bool $require
	 * return bool
	 */
	private function _checkOption($value, $require) {
		if (empty($value)) {
			if ($require) {
				return false;
			}
		}
		return true;
	}
}
