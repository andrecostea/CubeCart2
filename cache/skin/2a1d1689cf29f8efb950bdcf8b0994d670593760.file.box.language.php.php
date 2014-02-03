<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.language.php" */ ?>
<?php /*%%SmartyHeaderCode:165867395352a5b64b1e7370-05163029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a1d1689cf29f8efb950bdcf8b0994d670593760' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.language.php',
      1 => 1300356178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165867395352a5b64b1e7370-05163029',
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
  'unifunc' => 'content_52a5b64b21e147_70229908',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b21e147_70229908')) {function content_52a5b64b21e147_70229908($_smarty_tpl) {?><div id="language_select">
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