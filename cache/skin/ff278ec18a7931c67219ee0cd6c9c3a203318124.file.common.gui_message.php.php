<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:21:24
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/common.gui_message.php" */ ?>
<?php /*%%SmartyHeaderCode:10664258452d0ff04421090-03505009%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff278ec18a7931c67219ee0cd6c9c3a203318124' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/common.gui_message.php',
      1 => 1301512240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10664258452d0ff04421090-03505009',
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
  'unifunc' => 'content_52d0ff044c68d4_74270996',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ff044c68d4_74270996')) {function content_52d0ff044c68d4_74270996($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value)){?>
<div id="gui_message">
  <?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['error'])){?>
  <div class="warnText" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['click_to_close'];?>
">
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
  	<div class="infoText" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['click_to_close'];?>
"><?php echo $_smarty_tpl->tpl_vars['notice']->value;?>
</div>
	<?php } ?>
  <?php }?>
</div>
<?php }?><?php }} ?>