<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.errors.php" */ ?>
<?php /*%%SmartyHeaderCode:73782728252a5b64b64afa8-88490844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '752e11ed17c2449eeae57147040e29088063c999' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.errors.php',
      1 => 1297254905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73782728252a5b64b64afa8-88490844',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'GUI_MESSAGE' => 0,
    'LANG' => 0,
    'error' => 0,
    'notice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b6791e7_14826873',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b6791e7_14826873')) {function content_52a5b64b6791e7_14826873($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value)){?>
<div id="gui_message">
  <?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['error'])){?>
  <div class="gui_message-error">
	<?php echo $_smarty_tpl->tpl_vars['LANG']->value['gui_message']['errors_detected'];?>

	<ul>
		<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
	  	<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
	  	<?php } ?>
	</ul>
  </div>
  <?php }?>
  <?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['notice'])){?>
	<?php  $_smarty_tpl->tpl_vars['notice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['notice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['notice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['notice']->key => $_smarty_tpl->tpl_vars['notice']->value){
$_smarty_tpl->tpl_vars['notice']->_loop = true;
?>
  	<div class="gui_message-notice"><?php echo $_smarty_tpl->tpl_vars['notice']->value;?>
</div>
	<?php } ?>
  <?php }?>
</div>
<?php }?><?php }} ?>