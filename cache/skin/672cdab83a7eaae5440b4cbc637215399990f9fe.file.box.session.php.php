<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.session.php" */ ?>
<?php /*%%SmartyHeaderCode:50428199052a5b64b244e85-24962428%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '672cdab83a7eaae5440b4cbc637215399990f9fe' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.session.php',
      1 => 1302514688,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50428199052a5b64b244e85-24962428',
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
  'unifunc' => 'content_52a5b64b289a31_36720633',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b289a31_36720633')) {function content_52a5b64b289a31_36720633($_smarty_tpl) {?><div id="session">
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