<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:21:31
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/element.hook_form_content.php" */ ?>
<?php /*%%SmartyHeaderCode:152906349152d0ff0b9cead6-62470053%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '127351bfe1cbbe5790db81a785dde2596db9832e' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/element.hook_form_content.php',
      1 => 1350378978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152906349152d0ff0b9cead6-62470053',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_TAB_CONTENT' => 0,
    'tabfile' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ff0b9deb87_24712208',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ff0b9deb87_24712208')) {function content_52d0ff0b9deb87_24712208($_smarty_tpl) {?><!-- Bring in Tab Content for plugin hooks. -->
<?php if ($_smarty_tpl->tpl_vars['HOOK_TAB_CONTENT']->value){?>
  <?php  $_smarty_tpl->tpl_vars['tabfile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tabfile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['HOOK_TAB_CONTENT']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tabfile']->key => $_smarty_tpl->tpl_vars['tabfile']->value){
$_smarty_tpl->tpl_vars['tabfile']->_loop = true;
?>
  	  <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['tabfile']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  <?php } ?>
<?php }?><?php }} ?>