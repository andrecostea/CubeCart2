<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.language.php" */ ?>
<?php /*%%SmartyHeaderCode:165001710452d1047084c210-18341307%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14bebf9f7982cea9561f9f9f08c5ae7e7a46a1fe' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.language.php',
      1 => 1300356178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165001710452d1047084c210-18341307',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'LANGUAGES' => 0,
    'language' => 0,
    'STORE_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d104708cc2f0_78672742',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d104708cc2f0_78672742')) {function content_52d104708cc2f0_78672742($_smarty_tpl) {?><div id="language_select">
  <span class="title"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['change_language'];?>
</span>:
  <?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
  <a href="<?php echo $_smarty_tpl->tpl_vars['language']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['title'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['language']->value['css'];?>
">
	<img src="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/language/flags/<?php echo $_smarty_tpl->tpl_vars['language']->value['code'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['language']->value['title'];?>
" id="language_<?php echo $_smarty_tpl->tpl_vars['language']->value['code'];?>
" />
  </a>
  <?php } ?>
</div><?php }} ?>