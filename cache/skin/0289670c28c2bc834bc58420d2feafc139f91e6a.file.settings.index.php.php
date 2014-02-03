<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:21:30
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/settings.index.php" */ ?>
<?php /*%%SmartyHeaderCode:64811365552d0ff0ad06a66-72007314%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0289670c28c2bc834bc58420d2feafc139f91e6a' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/settings.index.php',
      1 => 1364298866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '64811365552d0ff0ad06a66-72007314',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PHP_SELF' => 0,
    'LANG' => 0,
    'CONFIG' => 0,
    'COUNTRIES' => 0,
    'country' => 0,
    'LANGUAGES' => 0,
    'language' => 0,
    'CURRENCIES' => 0,
    'currency' => 0,
    'OPT_PRODUCT_PRICES_INCLUDE_TAX' => 0,
    'option' => 0,
    'OPT_BASKET_TAX_BY_DELIVERY' => 0,
    'OPT_EMAIL_DISABLE_ALERT' => 0,
    'OPT_CATALOGUE_SALE_MODE' => 0,
    'OPT_ADMIN_NOTIFY_STATUS' => 0,
    'OPT_PRODUCT_SORT_COLUMN' => 0,
    'OPT_PRODUCT_SORT_DIRECTION' => 0,
    'OPT_CATALOGUE_SHOW_EMPTY' => 0,
    'OPT_CATALOGUE_EXPAND_TREE' => 0,
    'OPT_BASKET_JUMP_TO' => 0,
    'OPT_CATALOGUE_LATEST_PRODUCTS' => 0,
    'OPT_CATALOGUE_POPULAR_PRODUCTS_SOURCE' => 0,
    'SKINS' => 0,
    'skin' => 0,
    'SKINS_ADMIN' => 0,
    'OPT_SKIN_CHANGE' => 0,
    'MOBILE_DISABLED' => 0,
    'SKINS_MOBILE' => 0,
    'TRIAL_LIMITS' => 0,
    'OPT_STOCK_WARN_TYPE' => 0,
    'OPT_PRODUCT_WEIGHT_UNIT' => 0,
    'OPT_STOCK_CHANGE_TIME' => 0,
    'OPT_SEO_METADATA' => 0,
    'OPT_SEO' => 0,
    'HTACCESS_DISABLED' => 0,
    'OPT_SEO_METHOD' => 0,
    'VAL_HTACCESS_CONTENTS' => 0,
    'OPT_SEO_TRACKBACKS' => 0,
    'OPT_SSL' => 0,
    'OPT_SSL_FORCE' => 0,
    'OPT_OFFLINE' => 0,
    'OPT_OFFLINE_ALLOW_ADMIN' => 0,
    'LOGOS' => 0,
    'logo' => 0,
    'SKINS_ALL' => 0,
    'SKIN_VARS' => 0,
    'OPT_EMAIL_METHOD' => 0,
    'OPT_EMAIL_SMTP' => 0,
    'OPT_DEBUG' => 0,
    'OPT_CACHE' => 0,
    'OPT_PROXY' => 0,
    'TIMEZONES' => 0,
    'timezone' => 0,
    'OPT_PRODUCT_CLONE' => 0,
    'OPT_PRODUCT_CLONE_CODE' => 0,
    'SESSION_TOKEN' => 0,
    'VAL_JSON_COUNTY' => 0,
    'JSON_STYLES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ff0b9bad34_77843958',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ff0b9bad34_77843958')) {function content_52d0ff0b9bad34_77843958($_smarty_tpl) {?><form id="form-settings" action="<?php echo $_smarty_tpl->tpl_vars['PHP_SELF']->value;?>
" method="post" enctype="multipart/form-data">

<div id="General" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['general'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_geographical'];?>
</legend>
	<div><label for="store_name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['store_name'];?>
</label><span><input name="config[store_name]" id="store_name" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_name'];?>
" /></span></div>
	<div><label for="store_address"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['line1'];?>
</label><span><textarea name="config[store_address]" id="store_address" class="textbox"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_address'];?>
</textarea></span></div>
	<div><label for="country-list"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['country'];?>
</label><span><select name="config[store_country]" id="country-list" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['COUNTRIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value){
$_smarty_tpl->tpl_vars['country']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['numcode'];?>
"<?php echo $_smarty_tpl->tpl_vars['country']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['country']->value['name'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="state-list"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['state'];?>
</label><span><input type="text" name="config[store_zone]" id="state-list" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_zone'];?>
" /></span></div>
	<div><label for="store_postcode"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['postcode'];?>
</label><span><input name="config[store_postcode]" id="store_postcode" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_postcode'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_tax_lang'];?>
</legend>
	<div><label for="default_language"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_language'];?>
</label><span><select name="config[default_language]" id="default_language" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['code'];?>
"<?php echo $_smarty_tpl->tpl_vars['language']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['language']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="default_currency"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_currency'];?>
</label><span><select name="config[default_currency]" id="default_currency" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CURRENCIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value){
$_smarty_tpl->tpl_vars['currency']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value['code'];?>
"<?php echo $_smarty_tpl->tpl_vars['currency']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['currency']->value['code'];?>
 - <?php echo $_smarty_tpl->tpl_vars['currency']->value['name'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="product_prices_include_tax"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['tax_customer'];?>
</label><span><select name="config[product_prices_include_tax]" id="product_prices_include_tax" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_PRICES_INCLUDE_TAX']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="basket_tax_by_delivery"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['tax_customer_by'];?>
</label><span><select name="config[basket_tax_by_delivery]" id="basket_tax_by_delivery" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_BASKET_TAX_BY_DELIVERY']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
  </fieldset>
</div>


<div id="Features" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_features'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['google_analytics'];?>
</legend>
	<div><label for="google_analytics"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['google_analytics_id'];?>
</label><span><input name="config[google_analytics]" id="google_analytics" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['google_analytics'];?>
" /></span></div>
  </fieldset>

  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['nav_prod_reviews'];?>
</legend>
	<div><label for="enable_reviews"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['enable_reviews'];?>
</label><span><input name="config[enable_reviews]" id="enable_reviews" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['enable_reviews'];?>
" /></span></div>
  </fieldset>

  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_orders'];?>
</legend>
	<!--
	<div><label for="email_disable_alert"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['email_disable_alert'];?>
</label><span><select name="config[email_disable_alert]" id="email_disable_alert" class="textbox">
	-->
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_EMAIL_DISABLE_ALERT']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	<!--
	</select></span></div>
	-->
  <div><label for="basket_order_expire"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['expire_pending'];?>
</label><span><input name="config[basket_order_expire]" id="basket_order_expire" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['basket_order_expire'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['blank_to_disable'];?>
</span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_sales'];?>
</legend>
	<div><label for="catalogue_sale_mode"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['sales_mode'];?>
</label><span><select name="config[catalogue_sale_mode]" id="catalogue_sale_mode" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CATALOGUE_SALE_MODE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="catalogue_sale_percentage"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['sales_percentage'];?>
</label><span><input name="config[catalogue_sale_percentage]" id="catalogue_sale_percentage" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_sale_percentage'];?>
" />%</span></div>
	<div><label for="catalogue_sale_items"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['sales_items_count'];?>
</label><span><input name="config[catalogue_sale_items]" id="catalogue_sale_items" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_sale_items'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_flood'];?>
</legend>
	<div><label for="recaptcha"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['recaptcha_enable'];?>
</label><span><input name="config[recaptcha]" id="recaptcha" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['recaptcha'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['misc'];?>
</legend>
   <div><label for="admin_notify_status"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['admin_order_status_notification'];?>
</label><span><select name="config[admin_notify_status]" id="admin_notify_status" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_ADMIN_NOTIFY_STATUS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
   <div><label for="no_skip_processing_check"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['no_skip_processing_check'];?>
</label><span><input name="config[no_skip_processing_check]" id="no_skip_processing_check" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['no_skip_processing_check'];?>
" /></span></div>
   <div><label for="catalogue_hide_prices"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['hide_prices'];?>
</label><span><input name="config[catalogue_hide_prices]" id="catalogue_hide_prices" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_hide_prices'];?>
" /></span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['no_admin_affect'];?>
</div>
   <div><label for="catalogue_mode"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['catalogue_mode'];?>
</label><span><input name="config[catalogue_mode]" id="catalogue_mode" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_mode'];?>
" /></span></div>
   <div><label for="auto_save_cart"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['auto_save_cart'];?>
</label><span><input name="config[auto_save_cart]" id="auto_save_cart" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['auto_save_cart'];?>
" /></span></div>
   <div><label for="allow_no_shipping"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['allow_no_shipping'];?>
</label><span><input name="config[allow_no_shipping]" id="allow_no_shipping" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['allow_no_shipping'];?>
" /></span></div>
   <div><label for="disable_shipping_groups"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['disable_shipping_groups'];?>
</label><span><input name="config[disable_shipping_groups]" id="disable_shipping_groups" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['disable_shipping_groups'];?>
" /></span></div>
   <div><label for="cookie_dialogue"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['cookie_dialogue'];?>
</label><span><input name="config[cookie_dialogue]" id="cookie_dialogue" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['cookie_dialogue'];?>
" /></span></div>
  </fieldset>
</div>

<div id="Layout" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_layout'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_display'];?>
</legend>
	<div><label for="catalogue_products_per_page"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_per_page'];?>
</label><span><input name="config[catalogue_products_per_page]" id="catalogue_products_per_page" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_products_per_page'];?>
" /></span></div>
	<div><label for="default_product_sort"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_product_sort'];?>
</label>
		<span>
			<select name="config[product_sort_column]" id="product_sort_column" class="textbox">
			  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_SORT_COLUMN']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
			</select>
			
			<select name="config[product_sort_direction]" id="product_sort_direction" class="textbox">
				<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_SORT_DIRECTION']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
			</select>
		</span>
	</div>
	<div><label for="catalogue_show_empty"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['category_display_empty'];?>
</label><span><select name="config[catalogue_show_empty]" id="catalogue_show_empty" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CATALOGUE_SHOW_EMPTY']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="product_precis"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_precis'];?>
</label><span><input name="config[product_precis]" id="product_precis" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_precis'];?>
" /></span></div>
	<div><label for="dirSymbol"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['category_directory_symbol'];?>
</label><span><input name="config[default_directory_symbol]" id="dirSymbol" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['default_directory_symbol'];?>
" /></span></div>
	<div><label for="catalogue_expand_tree"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['category_expand_tree'];?>
</label><span><select name="config[catalogue_expand_tree]" id="catalogue_expand_tree" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CATALOGUE_EXPAND_TREE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="basket_jump_to"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['basket_jump_to'];?>
</label><span><select name="config[basket_jump_to]" id="basket_jump_to" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_BASKET_JUMP_TO']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="disable_checkout_terms"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['disable_checkout_terms'];?>
</label><span><input name="config[disable_checkout_terms]" id="disable_checkout_terms" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['disable_checkout_terms'];?>
" /></span></div>
	<div><label for="default_rss_feed"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_rss'];?>
</label><span><input name="config[default_rss_feed]" id="default_rss_feed" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['default_rss_feed'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_popular_latest'];?>
</legend>
	<div><label for="catalogue_latest_products"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_latest'];?>
</label><span><select name="config[catalogue_latest_products]" id="catalogue_latest_products" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CATALOGUE_LATEST_PRODUCTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="catalogue_latest_products_count"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_latest_number'];?>
</label><span><input name="config[catalogue_latest_products_count]" id="catalogue_latest_products_count" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_latest_products_count'];?>
" /></span></div>
	<div><label for="catalogue_popular_products_count"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_popular'];?>
</label><span><input name="config[catalogue_popular_products_count]" id="catalogue_popular_products_count" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['catalogue_popular_products_count'];?>
" /></span></div>
	<div><label for="catalogue_popular_products_source"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_popular_source'];?>
</label><span><select name="config[catalogue_popular_products_source]" id="catalogue_popular_products_source" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CATALOGUE_POPULAR_PRODUCTS_SOURCE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_skins'];?>
</legend>
	<div><label for="skin_folder"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['skins_default_front'];?>
</label><span>
	  <input type="hidden" class="default-style" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['skin_style'];?>
" />
	  <select name="config[skin_folder]" id="skin_folder" class="textbox select-skin no-drop">
	  <?php  $_smarty_tpl->tpl_vars['skin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SKINS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skin']->key => $_smarty_tpl->tpl_vars['skin']->value){
$_smarty_tpl->tpl_vars['skin']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['skin']->value['description'];?>
"<?php echo $_smarty_tpl->tpl_vars['skin']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['skin']->value['display'];?>
</option><?php } ?>
	  </select>
	  <select name="config[skin_style]" id="skin_style" class="textbox select-style"></select>
	</span></div>
	<div><label for="admin_skin"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['skins_default_admin'];?>
</label><span>
	  <select name="config[admin_skin]" id="admin_skin" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['skin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SKINS_ADMIN']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skin']->key => $_smarty_tpl->tpl_vars['skin']->value){
$_smarty_tpl->tpl_vars['skin']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
" <?php echo $_smarty_tpl->tpl_vars['skin']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
</option><?php } ?>
	  </select>
	</span></div>
	<div><label for="skin_change"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['skins_allow_change'];?>
</label><span><select name="config[skin_change]" id="skin_change" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SKIN_CHANGE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="skin_folder_mobile"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['skins_mobile_default_front'];?>
</label><span>
	  <input type="hidden" class="default-style-mobile" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['skin_style_mobile'];?>
" />
	  <select name="config[skin_folder_mobile]" id="skin_folder_mobile" class="textbox select-skin-mobile no-drop"<?php echo $_smarty_tpl->tpl_vars['MOBILE_DISABLED']->value;?>
>
	  <?php  $_smarty_tpl->tpl_vars['skin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SKINS_MOBILE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skin']->key => $_smarty_tpl->tpl_vars['skin']->value){
$_smarty_tpl->tpl_vars['skin']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['skin']->value['description'];?>
"<?php echo $_smarty_tpl->tpl_vars['skin']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['skin']->value['display'];?>
</option><?php } ?>
	  </select>
	  <select name="config[skin_style_mobile]" id="skin_style_mobile" class="textbox select-style-mobile"<?php echo $_smarty_tpl->tpl_vars['MOBILE_DISABLED']->value;?>
></select> 
	  <?php if ($_smarty_tpl->tpl_vars['MOBILE_DISABLED']->value){?>
	  (<a href="<?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['url'];?>
">Upgrade</a>)
	  <input type="hidden" name="skin_style_mobile" value="mobile" />
	  <input type="hidden" name="skin_folder_mobile" value="blue" />
	  <?php }?>
	</span></div>
	<div><label for="disable_mobile_skin"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['disable_mobile_skin'];?>
</label><span><input name="config[disable_mobile_skin]" id="disable_mobile_skin" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['disable_mobile_skin'];?>
" /></span></div>
  </fieldset>
</div>


<div id="Stock" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_stock'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_digital'];?>
</legend>
	<div><label for="download_expire"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['digital_expiry'];?>
</label><span><input name="config[download_expire]" id="download_expire" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['download_expire'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['blank_to_disable'];?>
</span></div>
	<div><label for="download_count"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['digital_attempts'];?>
</label><span><input name="config[download_count]" id="download_count" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['download_count'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['blank_to_disable'];?>
</span></div>
	<div><label for="download_custom_path"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['digital_custom_root'];?>
</label><span><input name="config[download_custom_path]" id="download_custom_path" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['download_custom_path'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_stock_general'];?>
</legend>
    <div><label for="stock_level"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_show'];?>
</label><span><input name="config[stock_level]" id="stock_level" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['stock_level'];?>
" /></span></div>
    <div><label for="basket_out_of_stock_purchase"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_allow_oos'];?>
</label><span><input name="config[basket_out_of_stock_purchase]" id="basket_out_of_stock_purchase" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['basket_out_of_stock_purchase'];?>
" /></span></div>
    <div><label for="stock_warn_type"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_warning_method'];?>
</label><span><select name="config[stock_warn_type]" id="stock_warn_type" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_STOCK_WARN_TYPE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
    <div><label for="stock_warn_level"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_warning_level'];?>
</label><span><input name="config[stock_warn_level]" id="stock_warn_level" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['stock_warn_level'];?>
" /></span></div>
    <div><label for="stock_warn_limit"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_warning_limit'];?>
</label><span><input name="config[stock_warn_limit]" id="stock_warn_limit" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['stock_warn_limit'];?>
" /></span></div>
    <div><label for="product_weight_unit"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['weight_unit'];?>
</label><span><select name="config[product_weight_unit]" id="product_weight_unit" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_WEIGHT_UNIT']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
    <div><label for="show_basket_weight"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['show_basket_weight'];?>
</label><span><input name="config[show_basket_weight]" id="show_basket_weight" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['show_basket_weight'];?>
" /></span></div>
    <div><label for="basket_allow_non_invoice_address"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['dispatch_to_non_invoice'];?>
</label><span><input name="config[basket_allow_non_invoice_address]" id="basket_allow_non_invoice_address" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['basket_allow_non_invoice_address'];?>
" /></span></div>
    <div><label for="stock_change_time"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['stock_reduce'];?>
</label><span><select name="config[stock_change_time]" id="stock_change_time" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_STOCK_CHANGE_TIME']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
   	<div><label for="hide_out_of_stock"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_hide_out_of_stock'];?>
</label><span><input name="config[hide_out_of_stock]" id="hide_out_of_stock" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['hide_out_of_stock'];?>
" /></span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['no_admin_affect'];?>
</div>
  </fieldset>
</div>

<div id="Search_Engines" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_seo'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_seo_meta_data'];?>
</legend>
  	<div><label for="store_title"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_browser_title'];?>
</label><span><input name="config[store_title]" id="store_title" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_title'];?>
" /></span></div>
	<div><label for="store_meta_description"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_meta_description'];?>
</label><span><textarea name="config[store_meta_description]" id="store_meta_description" class="textbox"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_meta_description'];?>
</textarea></span></div>
	<div><label for="store_meta_keywords"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_meta_keywords'];?>
</label><span><textarea name="config[store_meta_keywords]" id="store_meta_keywords" class="textbox"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_meta_keywords'];?>
</textarea></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_seo_meta_behaviour'];?>
</legend>
    <div><label for="seo_metadata"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_meta_behaviour'];?>
</label><span><select name="config[seo_metadata]" id="seo_metadata" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SEO_METADATA']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_seo_urls'];?>
</legend>
	<div><label for="seo"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_enable'];?>
</label><span><select name="config[seo]" id="seo" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SEO']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select><?php if ($_smarty_tpl->tpl_vars['HTACCESS_DISABLED']->value){?>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['htaccess_error'];?>
<?php }?></span></div>
	<div><label for="seo_method"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_format'];?>
</label><span><select name="config[seo_method]" id="seo_method" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SEO_METHOD']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="htaccess"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_htaccess'];?>
</label><span>
	<textarea name="htaccess-data" id="htaccess" class="textbox" cols="80" rows="20"><?php echo $_smarty_tpl->tpl_vars['VAL_HTACCESS_CONTENTS']->value;?>
</textarea></span></div>
	<div><label class="spacer">&nbsp;</label><span><input name="install_htaccess" id="install_htaccess" type="submit" class="" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['seo_htaccess_install'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_trackbacks'];?>
</legend>
    <div><label for="seo_trackbacks"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_trackbacks'];?>
</label><span><select name="config[seo_trackbacks]" id="seo_trackbacks" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SEO_TRACKBACKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
  </fieldset>
</div>

<div id="SSL" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_ssl'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_ssl'];?>
</legend>
    <div><label for="enable_ssl"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['ssl_enable'];?>
</label><span><select name="config[ssl]" id="enable_ssl" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SSL']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
    <div><label for="ssl_force"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['ssl_force'];?>
</label><span><select name="config[ssl_force]" id="ssl_force" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_SSL_FORCE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
    </select></span></div>
	<div><label for="ssl_path"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['ssl_root_path'];?>
</label><span><input name="config[ssl_path]" id="ssl_path" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['ssl_path'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['eg'];?>
: /store/</span></div>
	<div><label for="ssl_url"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['ssl_url'];?>
</label><span><input name="config[ssl_url]" id="ssl_url" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['ssl_url'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['eg'];?>
: https://www.example.com/store</span></div>
	<div><label for="standard_url"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['standard_url'];?>
</label><span><input name="config[standard_url]" id="standard_url" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['standard_url'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['eg'];?>
: http://www.example.com/store</span></div>
  </fieldset>
</div>

<div id="Offline" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_offline'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_offline'];?>
</legend>
  <div><label for="offline"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['offline_enable'];?>
</label><span><select name="config[offline]" id="offline" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_OFFLINE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
  </select></span></div>
  <div><label for="offline_allow_admin"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['offline_admin'];?>
</label><span><select name="config[offline_allow_admin]" id="offline_allow_admin" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_OFFLINE_ALLOW_ADMIN']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
  </select></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['offline_message'];?>
</legend>
	<textarea name="config[offline_content]" id="offline_content" class="textbox fck"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['offline_content'];?>
</textarea>
  </fieldset>
</div>

<div id="Logos" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_logo'];?>
</h3>
  <?php if (isset($_smarty_tpl->tpl_vars['LOGOS']->value)){?>
  <fieldset class="list"><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_logo_current'];?>
</legend>
	<?php  $_smarty_tpl->tpl_vars['logo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['logo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LOGOS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['logo']->key => $_smarty_tpl->tpl_vars['logo']->value){
$_smarty_tpl->tpl_vars['logo']->_loop = true;
?>
	<div>
	  <span class="actions">
		<input type="hidden" class="default-style" value="<?php echo $_smarty_tpl->tpl_vars['logo']->value['style'];?>
" />
		<select id="" name="logo[<?php echo $_smarty_tpl->tpl_vars['logo']->value['logo_id'];?>
][skin]" class="textbox select-skin">
		  <optgroup label="Skins">
		  	<option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['logo_all_skins'];?>
</option>
		  <?php  $_smarty_tpl->tpl_vars['skin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SKINS_ALL']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skin']->key => $_smarty_tpl->tpl_vars['skin']->value){
$_smarty_tpl->tpl_vars['skin']->_loop = true;
?>
		    <?php if (isset($_smarty_tpl->tpl_vars['skin']->value['other_optgroup'])&&$_smarty_tpl->tpl_vars['skin']->value['other_optgroup']){?>
		    </optgroup><optgroup label="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['other'];?>
">
		    <?php }?>
		    <option value="<?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
" <?php if (($_smarty_tpl->tpl_vars['skin']->value['name']==$_smarty_tpl->tpl_vars['logo']->value['skin'])){?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['skin']->value['display'];?>
</option>
		  <?php } ?>
		    </optgroup>
		</select>
		<select id="" name="logo[<?php echo $_smarty_tpl->tpl_vars['logo']->value['logo_id'];?>
][style]" class="textbox select-style">
		  <option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['logo_all_styles'];?>
</option>
		</select>
		<a href="<?php echo $_smarty_tpl->tpl_vars['logo']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
	  </span>
	  <span style="float: left; width: 25px;"><input type="hidden" name="logo[<?php echo $_smarty_tpl->tpl_vars['logo']->value['logo_id'];?>
][status]" id="logo_<?php echo $_smarty_tpl->tpl_vars['logo']->value['logo_id'];?>
_status" value="<?php echo $_smarty_tpl->tpl_vars['logo']->value['status'];?>
" class="toggle" /></span>
	  <a href="images/logos/<?php echo $_smarty_tpl->tpl_vars['logo']->value['filename'];?>
" target="_blank" class="colorbox"><img src="images/logos/<?php echo $_smarty_tpl->tpl_vars['logo']->value['filename'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['logo']->value['filename'];?>
" height="50" /></a>
	</div>
	<?php } ?>
  </fieldset>
  <?php }?>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_logo_upload'];?>
</legend>
	<div><input type="file" name="logo" class="textbox multiple" /></div>
  </fieldset>
</div>

<div id="Advanced_Settings" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_advanced'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_licence_keys'];?>
</legend>
	<div><label for="licence_key"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['software_licence_key'];?>
</label><span><input name="config[license_key]" id="license_key" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['license_key'];?>
" /></span></div>
	<div><label for="lkv"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['copyright_key'];?>
</label><span><input name="lkv" id="lkv" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['lkv'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['email'];?>
</legend>
	<div><label for="email_method"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['email_method'];?>
</label><span><select name="config[email_method]" id="email_method" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_EMAIL_METHOD']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="email_name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['email_sender_name'];?>
</label><span><input name="config[email_name]" id="email_name" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_name'];?>
" /></span></div>
	<div><label for="email_address"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['email_sender_address'];?>
</label><span><input name="config[email_address]" id="email_address" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_address'];?>
" /></span></div>
	<div><label for="email_smtp_host"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['smtp_host'];?>
</label><span><input name="config[email_smtp_host]" id="email_smtp_host" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_smtp_host'];?>
" /></span></div>
	<div><label for="email_smtp_port"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['smtp_port'];?>
</label><span><input name="config[email_smtp_port]" id="email_smtp_port" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_smtp_port'];?>
" /></span></div>
	<div><label for="email_smtp"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['smtp_auth'];?>
</label><span><select name="config[email_smtp]" id="email_smtp" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_EMAIL_SMTP']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="email_smtp_user"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['smtp_user'];?>
</label><span><input name="config[email_smtp_user]" id="email_smtp_user" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_smtp_user'];?>
" /></span></div>
	<div><label for="email_smtp_password"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['smtp_pass'];?>
</label><span><input name="config[email_smtp_password]" id="email_smtp_password" type="password" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['email_smtp_password'];?>
" autocomplete="off" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_performance'];?>
</legend>
	<div><label for="debug"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['debug_enable'];?>
</label><span><select name="config[debug]" id="debug" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_DEBUG']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="debug"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['debug_ip_addresses'];?>
</label><span><input name="config[debug_ip_addresses]" id="debug_ip_addresses" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['debug_ip_addresses'];?>
" /></span></div>
	<div><label for="cache"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['cache_enable'];?>
</label><span><select name="config[cache]" id="cache" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_CACHE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="cache_memcache_list"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['cache_memcache'];?>
</label><span><input type="text" name="config[cache_memcache_list]" id="cache_memcache_list" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['cache_memcache_list'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_proxy'];?>
</legend>
	<div><label for="proxy"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['proxy_enable'];?>
</label><span><select name="config[proxy]" id="proxy" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PROXY']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="proxy_host"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['proxy_host'];?>
</label><span><input name="config[proxy_host]" id="proxy_host" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['proxy_host'];?>
" /></span></div>
	<div><label for="proxy_port"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['proxy_port'];?>
</label><span><input name="config[proxy_port]" id="proxy_port" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['proxy_port'];?>
" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_time_date'];?>
</legend>
	<div><label for="time_format"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['time_format'];?>
</label><span><input name="config[time_format]" id="time_format" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['time_format'];?>
" /> PHP <a href="http://www.php.net/strftime" target="_blank">strftime</a></span></div>
	<div><label for="time_offset"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['time_utc_offset'];?>
</label><span><input name="config[time_offset]" id="time_offset" type="text" class="textbox number" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['time_offset'];?>
" /></span></div>
	<?php if (isset($_smarty_tpl->tpl_vars['TIMEZONES']->value)){?>
	<div><label for="time_zone"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['time_zone'];?>
</label><span><select name="config[time_zone]" id="time_zone" type="text" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['timezone'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['timezone']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TIMEZONES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['timezone']->key => $_smarty_tpl->tpl_vars['timezone']->value){
$_smarty_tpl->tpl_vars['timezone']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['timezone']->value['zone'];?>
"<?php echo $_smarty_tpl->tpl_vars['timezone']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['timezone']->value['zone'];?>
</option><?php } ?>
	</select></span></div>
	<?php }?>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['other'];?>
</legend>
  <div><label for="feed_access_key"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['feed_access_key'];?>
</label><span><input name="config[feed_access_key]" id="feed_access_key" type="text" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['feed_access_key'];?>
" /></span></div>
  </fieldset>
</div>

<div id="Copyright" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_copyright'];?>
</h3>
  <fieldset>
	<div><span><textarea name="config[store_copyright]" id="copyright_content" class="textbox fck"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_copyright'];?>
</textarea></span></div>
  </fieldset>
</div>

<div id="Extra" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_extra'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_product_clone'];?>
</legend>
	<div><label for="product_clone"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['status'];?>
</label><span><select name="config[product_clone]" id="product_clone" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_CLONE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="product_clone_images"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_images'];?>
</label><span><input name="config[product_clone_images]" id="product_clone_images" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_clone_images'];?>
" /></span></div>
	<div><label for="product_clone_options"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_options'];?>
</label><span><input name="config[product_clone_options]" id="product_clone_options" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_clone_options'];?>
" /></span></div>
	<div><label for="product_clone_acats"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_acats'];?>
</label><span><input name="config[product_clone_acats]" id="product_clone_acats" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_clone_acats'];?>
" /></span></div>
	<div><label for="product_clone_code"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_code'];?>
</label><span><select name="config[product_clone_code]" id="product_clone_code" class="textbox">
	<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['OPT_PRODUCT_CLONE_CODE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['value'];?>
"<?php echo $_smarty_tpl->tpl_vars['option']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['option']->value['title'];?>
</option><?php } ?>
	</select></span></div>
	<div><label for="product_clone_translations"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_translations'];?>
</label><span><input name="config[product_clone_translations]" id="product_clone_translations" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_clone_translations'];?>
" /></span></div>
	<div><label for="product_clone_redirect"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['product_clone_redirect'];?>
</label><span><input name="config[product_clone_redirect]" id="product_clone_redirect" type="hidden" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['product_clone_redirect'];?>
" /></span></div>
  </fieldset>
</div>

<?php echo $_smarty_tpl->getSubTemplate ('templates/element.hook_form_content.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="form_control">
  <input id="submit" type="submit" class="button" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" />
  <input type="hidden" name="previous-tab" id="previous-tab" value="" />
</div>
<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
</form>
<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['VAL_JSON_COUNTY']->value){?> var county_list = <?php echo $_smarty_tpl->tpl_vars['VAL_JSON_COUNTY']->value;?>
;<?php }?>
<?php if ($_smarty_tpl->tpl_vars['JSON_STYLES']->value){?>var json_skins	= <?php echo $_smarty_tpl->tpl_vars['JSON_STYLES']->value;?>
;<?php }?>
</script><?php }} ?>