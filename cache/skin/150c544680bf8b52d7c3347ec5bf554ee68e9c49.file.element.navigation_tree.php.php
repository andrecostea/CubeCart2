<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/element.navigation_tree.php" */ ?>
<?php /*%%SmartyHeaderCode:96352819052a5b64b2d3be5-71163823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '150c544680bf8b52d7c3347ec5bf554ee68e9c49' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/element.navigation_tree.php',
      1 => 1308653024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96352819052a5b64b2d3be5-71163823',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'BRANCH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b2ef810_80352853',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b2ef810_80352853')) {function content_52a5b64b2ef810_80352853($_smarty_tpl) {?><li>
  <a href="<?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['name'];?>
</a>
  <?php if (isset($_smarty_tpl->tpl_vars['BRANCH']->value['children'])){?>
  <ul><?php echo $_smarty_tpl->tpl_vars['BRANCH']->value['children'];?>
</ul>
  <?php }?>
</li><?php }} ?>