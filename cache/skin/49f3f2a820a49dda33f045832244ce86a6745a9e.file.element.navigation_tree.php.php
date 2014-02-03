<?php /* Smarty version Smarty-3.1.13, created on 2014-02-03 12:56:52
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/element.navigation_tree.php" */ ?>
<?php /*%%SmartyHeaderCode:69369175352ef9214912cc6-94789156%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49f3f2a820a49dda33f045832244ce86a6745a9e' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/element.navigation_tree.php',
      1 => 1308653024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69369175352ef9214912cc6-94789156',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'BRANCH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52ef9214ad7056_59204515',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ef9214ad7056_59204515')) {function content_52ef9214ad7056_59204515($_smarty_tpl) {?><li>
  <a href="<?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['name'];?>
</a>
  <?php if (isset($_smarty_tpl->tpl_vars['BRANCH']->value['children'])){?>
  <ul><?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['children'];?>
</ul>
  <?php }?>
</li><?php }} ?>