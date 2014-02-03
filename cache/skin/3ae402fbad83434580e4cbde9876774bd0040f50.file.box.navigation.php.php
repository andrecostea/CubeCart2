<?php /* Smarty version Smarty-3.1.13, created on 2014-02-03 12:56:52
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.navigation.php" */ ?>
<?php /*%%SmartyHeaderCode:209769721852ef9214b1c863-94658459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ae402fbad83434580e4cbde9876774bd0040f50' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.navigation.php',
      1 => 1306840300,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209769721852ef9214b1c863-94658459',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'STORE_URL' => 0,
    'NAVIGATION_TREE' => 0,
    'CTRL_CERTIFICATES' => 0,
    'CATALOGUE_MODE' => 0,
    'URL' => 0,
    'CTRL_SALE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52ef9214be2649_34608066',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ef9214be2649_34608066')) {function content_52ef9214be2649_34608066($_smarty_tpl) {?><div>
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['title'];?>
</h3>
  <ul id="menu" class="accordion">
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['homepage'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['homepage'];?>
</a></li>

	<?php echo $_smarty_tpl->tpl_vars['NAVIGATION_TREE']->value;?>


	<?php if ($_smarty_tpl->tpl_vars['CTRL_CERTIFICATES']->value&&!$_smarty_tpl->tpl_vars['CATALOGUE_MODE']->value){?>
	<li class="li-nav"><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value['certificates'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['giftcerts'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['giftcerts'];?>
</a></li>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['CTRL_SALE']->value){?>
	<li class="li-nav"><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value['saleitems'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['saleitems'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['navigation']['saleitems'];?>
</a></li>
	<?php }?>
  </ul>
</div><?php }} ?>