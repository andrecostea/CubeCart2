<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.navigation.php" */ ?>
<?php /*%%SmartyHeaderCode:211675203852a5b64b2f3ba0-42449923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de56e47a08a96d0688baedeea70d120b4e108101' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.navigation.php',
      1 => 1306840300,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211675203852a5b64b2f3ba0-42449923',
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
  'unifunc' => 'content_52a5b64b331f57_77700717',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b331f57_77700717')) {function content_52a5b64b331f57_77700717($_smarty_tpl) {?><div>
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