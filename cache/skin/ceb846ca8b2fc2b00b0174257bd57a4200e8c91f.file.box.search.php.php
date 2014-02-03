<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.search.php" */ ?>
<?php /*%%SmartyHeaderCode:167629920452a5b64b335b66-16603032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ceb846ca8b2fc2b00b0174257bd57a4200e8c91f' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.search.php',
      1 => 1320063043,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167629920452a5b64b335b66-16603032',
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
  'unifunc' => 'content_52a5b64b34bcb0_19198862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b34bcb0_19198862')) {function content_52a5b64b34bcb0_19198862($_smarty_tpl) {?><div id="quick_search">
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