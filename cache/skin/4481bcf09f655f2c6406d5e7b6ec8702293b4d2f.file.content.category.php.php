<?php /* Smarty version Smarty-3.1.13, created on 2014-02-03 12:57:06
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/content.category.php" */ ?>
<?php /*%%SmartyHeaderCode:192555600052ef92223eb560-07104329%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4481bcf09f655f2c6406d5e7b6ec8702293b4d2f' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/content.category.php',
      1 => 1356976617,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '192555600052ef92223eb560-07104329',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'SUBCATS' => 0,
    'subcat' => 0,
    'PRODUCTS' => 0,
    'VAL_SELF' => 0,
    'PAGINATION' => 0,
    'SORTING' => 0,
    'LANG' => 0,
    'sort' => 0,
    'product' => 0,
    'i' => 0,
    'STORE_URL' => 0,
    'SKIN_FOLDER' => 0,
    'CATALOGUE_MODE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52ef92227a50e9_67575474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ef92227a50e9_67575474')) {function content_52ef92227a50e9_67575474($_smarty_tpl) {?><h2><?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
</h2>

<?php if (isset($_smarty_tpl->tpl_vars['category']->value['image'])){?>
<div id="category_image"><img src="<?php echo $_smarty_tpl->tpl_vars['category']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
" /></div>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_desc'];?>


<?php if (isset($_smarty_tpl->tpl_vars['SUBCATS']->value)&&$_smarty_tpl->tpl_vars['SUBCATS']->value){?>
<div id="subcategories">
  <?php  $_smarty_tpl->tpl_vars['subcat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUBCATS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcat']->key => $_smarty_tpl->tpl_vars['subcat']->value){
$_smarty_tpl->tpl_vars['subcat']->_loop = true;
?>
  <div class="subcategory">
	<a href="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['cat_name'];?>
">
	  <img src="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['cat_image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['cat_name'];?>
" />
	</a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['subcat']->value['cat_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['subcat']->value['cat_name'];?>
</a>
  </div>
  <?php } ?>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['PRODUCTS']->value)&&count($_smarty_tpl->tpl_vars['PRODUCTS']->value)>=1){?>
<form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
  <div class="control">
	<span class="pagination"><?php if (isset($_smarty_tpl->tpl_vars['PAGINATION']->value)){?><?php echo $_smarty_tpl->tpl_vars['PAGINATION']->value;?>
<?php }?></span>
	<?php if (isset($_smarty_tpl->tpl_vars['SORTING']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['sort_by'];?>

	<select name="sort" class="auto_submit">
	  <option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
	  <?php  $_smarty_tpl->tpl_vars['sort'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sort']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SORTING']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sort']->key => $_smarty_tpl->tpl_vars['sort']->value){
$_smarty_tpl->tpl_vars['sort']->_loop = true;
?>
	  <option value="<?php echo $_smarty_tpl->tpl_vars['sort']->value['field'];?>
|<?php echo $_smarty_tpl->tpl_vars['sort']->value['order'];?>
" <?php echo $_smarty_tpl->tpl_vars['sort']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['sort']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['sort']->value['direction'];?>
)</option>
	  <?php } ?>
	</select>
	<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['sort'];?>
" />
	<?php }?>
  </div>
  </form>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['PRODUCTS']->value)){?>
  <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PRODUCTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
<form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" enctype="application/x-www-form-urlencoded" class="addForm">
  <div class="category_product">
	<h3><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></h3>
	<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" class="image">
	  <img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['thumbnail'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" />
	</a>
	<div class="details">
	<?php if ($_smarty_tpl->tpl_vars['product']->value['ctrl_sale']){?>
	  <p class="price"><span class="price_previous"><?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
</span> <span class="price_sale"><?php echo $_smarty_tpl->tpl_vars['product']->value['sale_price'];?>
</span></p>
	<?php }else{ ?>
	  <p class="price"><?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
</p>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['product']->value['review_score']){?>
	  <p class="rating">
	  <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->tpl_vars['i']->value<=5){ for ($_foo=true;$_smarty_tpl->tpl_vars['i']->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
	  	<?php if ($_smarty_tpl->tpl_vars['product']->value['review_score']>=$_smarty_tpl->tpl_vars['i']->value){?>
		<img src="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/images/common/star.png" alt="" />
		<?php }elseif($_smarty_tpl->tpl_vars['product']->value['review_score']>($_smarty_tpl->tpl_vars['i']->value-1)&&$_smarty_tpl->tpl_vars['product']->value['review_score']<$_smarty_tpl->tpl_vars['i']->value){?>
		<img src="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/images/common/star_half.png" alt="" />
		<?php }else{ ?>
		<img src="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/images/common/star_off.png" alt="" />
		<?php }?>
      <?php }} ?>
	  </p>
	  <p class="rating-info"><?php echo $_smarty_tpl->tpl_vars['product']->value['review_info'];?>
</p>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['product']->value['ctrl_purchase']&&!$_smarty_tpl->tpl_vars['CATALOGUE_MODE']->value){?>
	  <p class="buy_button"><input type="text" name="add[<?php echo $_smarty_tpl->tpl_vars['product']->value['product_id'];?>
][quantity]" value="1" class="quantity" /> <input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['add_to_basket'];?>
" class="button_white" /></p>
	<?php }elseif($_smarty_tpl->tpl_vars['product']->value['out']){?>
	  <p class="buy_button"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['out_of_stock_short'];?>
</p>
	<?php }?>
	</div>
	<p class="description"><?php echo $_smarty_tpl->tpl_vars['product']->value['description_short'];?>
</p>
  </div>
  </form>
  <?php } ?>
<?php }else{ ?>
<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['category']['no_products'];?>
</p>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['PRODUCTS']->value)&&count($_smarty_tpl->tpl_vars['PRODUCTS']->value)>=1){?>
<form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
  <div class="control">
	<span class="pagination"><?php if (isset($_smarty_tpl->tpl_vars['PAGINATION']->value)){?><?php echo $_smarty_tpl->tpl_vars['PAGINATION']->value;?>
<?php }?></span>
	<?php if (isset($_smarty_tpl->tpl_vars['SORTING']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['sort_by'];?>

	<select name="sort" class="auto_submit">
	  <option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
	  <?php  $_smarty_tpl->tpl_vars['sort'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sort']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SORTING']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sort']->key => $_smarty_tpl->tpl_vars['sort']->value){
$_smarty_tpl->tpl_vars['sort']->_loop = true;
?>
	  <option value="<?php echo $_smarty_tpl->tpl_vars['sort']->value['field'];?>
|<?php echo $_smarty_tpl->tpl_vars['sort']->value['order'];?>
" <?php echo $_smarty_tpl->tpl_vars['sort']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['sort']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['sort']->value['direction'];?>
)</option>
	  <?php } ?>
	</select>
	<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['sort'];?>
" />
	<?php }?>
  </div>
  </form>
  <?php }?><?php }} ?>