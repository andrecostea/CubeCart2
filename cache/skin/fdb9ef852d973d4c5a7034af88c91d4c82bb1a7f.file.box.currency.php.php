<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.currency.php" */ ?>
<?php /*%%SmartyHeaderCode:51160881652a5b64b223e75-27213792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fdb9ef852d973d4c5a7034af88c91d4c82bb1a7f' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.currency.php',
      1 => 1282340539,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51160881652a5b64b223e75-27213792',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'CURRENCIES' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b2439f4_85991516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b2439f4_85991516')) {function content_52a5b64b2439f4_85991516($_smarty_tpl) {?><div id="currency_select">
  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['change_currency'];?>
:
  <?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CURRENCIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value){
$_smarty_tpl->tpl_vars['currency']->_loop = true;
?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['currency']->value['url'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['currency']->value['css'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['currency']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['currency']->value['code'];?>
</a>
  <?php } ?>
  </p>
</div><?php }} ?>