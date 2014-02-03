<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.featured.php" */ ?>
<?php /*%%SmartyHeaderCode:138931478152a5b64b4cec61-88915809%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec69186068b88f958b9e9402bf8a8f8abfdec210' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.featured.php',
      1 => 1300356178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138931478152a5b64b4cec61-88915809',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'featured' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b4f7006_74208715',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b4f7006_74208715')) {function content_52a5b64b4f7006_74208715($_smarty_tpl) {?><div id="featured_product">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_feature'];?>
</h3>
  <p class="image">
	<a href="<?php echo $_smarty_tpl->tpl_vars['featured']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
">
	  <img src="<?php echo $_smarty_tpl->tpl_vars['featured']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
" />
	</a>
  </p>
  <p class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['featured']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
</a></p>
</div><?php }} ?>