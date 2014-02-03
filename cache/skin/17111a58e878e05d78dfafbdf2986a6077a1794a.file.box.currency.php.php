<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.currency.php" */ ?>
<?php /*%%SmartyHeaderCode:102658469452d104708d72a1-20478476%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17111a58e878e05d78dfafbdf2986a6077a1794a' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.currency.php',
      1 => 1282340539,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102658469452d104708d72a1-20478476',
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
  'unifunc' => 'content_52d10470938a10_81154723',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d10470938a10_81154723')) {function content_52d10470938a10_81154723($_smarty_tpl) {?><div id="currency_select">
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