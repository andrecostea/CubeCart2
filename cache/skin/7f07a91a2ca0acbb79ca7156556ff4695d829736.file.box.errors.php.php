<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.errors.php" */ ?>
<?php /*%%SmartyHeaderCode:147383956352d10470ca6f54-80729632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f07a91a2ca0acbb79ca7156556ff4695d829736' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.errors.php',
      1 => 1297254905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147383956352d10470ca6f54-80729632',
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
  'unifunc' => 'content_52d10470cd6e50_35333934',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d10470cd6e50_35333934')) {function content_52d10470cd6e50_35333934($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value)){?>
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