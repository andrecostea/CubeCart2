<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:32
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/box.search.php" */ ?>
<?php /*%%SmartyHeaderCode:78961894452d10470ae1ae6-56963540%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32c2f9103e719865d3ad2053d1a49ceae5c5ebf5' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/box.search.php',
      1 => 1320063043,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78961894452d10470ae1ae6-56963540',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ROOT_PATH' => 0,
    'LANG' => 0,
    'SEARCH_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d10470af8052_77849268',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d10470af8052_77849268')) {function content_52d10470af8052_77849268($_smarty_tpl) {?><div id="quick_search">
  <form action="<?php echo $_smarty_tpl->tpl_vars['ROOT_PATH']->value;?>
index.php" method="get">
	<span class="search"><input name="search[keywords]" type="text" id="keywords" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['search']['input_default'];?>
" size="18" /></span>
	<input type="hidden" name="_a" value="category" />
	<input class="search" type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['search'];?>
" />
	<p class="advanced"><a href="<?php echo $_smarty_tpl->tpl_vars['SEARCH_URL']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['search']['advanced'];?>
</a></p>
	  </form>
</div><?php }} ?>