<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.session.php" */ ?>
<?php /*%%SmartyHeaderCode:85662999552d1047093df09-44756567%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'adf3d41079c77ec30278c9659c0b13fbe3505ce3' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.session.php',
      1 => 1302514688,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '85662999552d1047093df09-44756567',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'IS_USER' => 0,
    'LANG_WELCOME_BACK' => 0,
    'STORE_URL' => 0,
    'LANG' => 0,
    'URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d10470a12405_41612482',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d10470a12405_41612482')) {function content_52d10470a12405_41612482($_smarty_tpl) {?><div id="session">
  <?php if ($_smarty_tpl->tpl_vars['IS_USER']->value){?>
  <p>
	<?php echo $_smarty_tpl->tpl_vars['LANG_WELCOME_BACK']->value;?>
 ::
	<a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?_a=logout" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['logout'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['logout'];?>
</a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?_a=account" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['your_account'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['your_account'];?>
</a>
  </p>
  <?php }else{ ?>
  <p>
	<a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value['login'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['log_in'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['log_in'];?>
</a> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['or'];?>

	<a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value['register'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register'];?>
</a>
  </p>
  <?php }?>
</div><?php }} ?>