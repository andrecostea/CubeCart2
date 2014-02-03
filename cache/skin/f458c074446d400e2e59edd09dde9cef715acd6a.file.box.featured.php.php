<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.featured.php" */ ?>
<?php /*%%SmartyHeaderCode:144965731052d10470b72918-05785083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f458c074446d400e2e59edd09dde9cef715acd6a' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.featured.php',
      1 => 1300356178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144965731052d10470b72918-05785083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'featured' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d10470b8fd58_30034175',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d10470b8fd58_30034175')) {function content_52d10470b8fd58_30034175($_smarty_tpl) {?><div id="featured_product">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_feature'];?>
</h3>
  <p class="image">
	<a href="<?php echo $_smarty_tpl->tpl_vars['featured']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
">
	  <img src="<?php echo $_smarty_tpl->tpl_vars['featured']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
" />
	</a>
  </p>
  <p class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['featured']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['featured']->value['name'];?>
</a></p>
</div><?php }} ?>