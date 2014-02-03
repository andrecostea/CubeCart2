<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:21:31
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/main.php" */ ?>
<?php /*%%SmartyHeaderCode:96245064152d0ff0b9e4fc3-62856518%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00406269e64d09a01fcf9fdd18d7afbce0bde4cc' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/main.php',
      1 => 1344887598,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96245064152d0ff0b9e4fc3-62856518',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'STORE_URL' => 0,
    'SKIN_VARS' => 0,
    'JQUERY_STYLES' => 0,
    'style' => 0,
    'ADMIN_UID' => 0,
    'ADMIN_USER' => 0,
    'NAVIGATION' => 0,
    'group' => 0,
    'nav' => 0,
    'TABS' => 0,
    'tab' => 0,
    'HELP_URL' => 0,
    'STORE_STATUS' => 0,
    'CRUMBS' => 0,
    'crumb' => 0,
    'SESSION_TOKEN' => 0,
    'SIDEBAR_CONTENT' => 0,
    'content' => 0,
    'DISPLAY_CONTENT' => 0,
    'CLOSE_WINDOW' => 0,
    'EXTRA_JS' => 0,
    'js_src' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ff0badf090_58678494',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ff0badf090_58678494')) {function content_52d0ff0badf090_58678494($_smarty_tpl) {?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_admin_cp'];?>
</title>
  <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/favicon.ico" type="image/x-icon" />
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/styles/ie7.css" media="screen" /><![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/styles/layout.css" media="screen" />
  <?php if (isset($_smarty_tpl->tpl_vars['JQUERY_STYLES']->value)){?>
  	<?php  $_smarty_tpl->tpl_vars['style'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['style']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['JQUERY_STYLES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['style']->key => $_smarty_tpl->tpl_vars['style']->value){
$_smarty_tpl->tpl_vars['style']->_loop = true;
?>
  	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
" media="screen" />
  	<?php } ?>
  <?php }?>
  <link rel="stylesheet" type="text/css" href="js/styles/styles.php" media="screen" />
</head>

<body>
  <div id="header">
  <span class="user_info"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['title_welcome_back'];?>
 <a href="?_g=settings&amp;node=admins&amp;action=edit&amp;admin_id=<?php echo $_smarty_tpl->tpl_vars['ADMIN_UID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['ADMIN_USER']->value;?>
</a> - [<a href="?_g=logout"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['logout'];?>
</a>]</span>
  </div>
  <div id="navigation">
  <?php if (isset($_smarty_tpl->tpl_vars['NAVIGATION']->value)){?>
    <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['NAVIGATION']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
	<div id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group'];?>
" class="menu" onclick="$('#menu_<?php echo $_smarty_tpl->tpl_vars['group']->value['group'];?>
').toggle();"><?php echo $_smarty_tpl->tpl_vars['group']->value['title'];?>
</div>
	<?php if (isset($_smarty_tpl->tpl_vars['group']->value['members'])){?>
	<ul id="menu_<?php echo $_smarty_tpl->tpl_vars['group']->value['group'];?>
" class="submenu">
	  <?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value){
$_smarty_tpl->tpl_vars['nav']->_loop = true;
?>
	  <li><a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['nav']->value['title'];?>
</a></li>
	  <?php } ?>
	</ul>
	<?php }?>
	<?php } ?>
  <?php }?>
  </div>
  <div id="content">
	<div id="tab_control">
	  <?php if (isset($_smarty_tpl->tpl_vars['TABS']->value)){?>
	  <?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TABS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
?>
	  <div id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['tab_id'];?>
" class="tab">
		<?php if (!empty($_smarty_tpl->tpl_vars['tab']->value['notify'])){?><span class="tab_notify"><?php echo $_smarty_tpl->tpl_vars['tab']->value['notify'];?>
</span><?php }?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value['url'];?>
<?php echo $_smarty_tpl->tpl_vars['tab']->value['target'];?>
" accesskey="<?php echo $_smarty_tpl->tpl_vars['tab']->value['accesskey'];?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['name'];?>
</a>
	  </div>
	  <?php } ?>
	  <?php }?>
	</div>
	<div id="breadcrumbs">
	  <span class="helpdocs" style="float: right;">
		<a href="<?php echo $_smarty_tpl->tpl_vars['HELP_URL']->value;?>
" id="wikihelp" class="colorbox wiki"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['help'];?>
</a> | <a href="index.php" target="blank"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['store_status'];?>
 <?php if (($_smarty_tpl->tpl_vars['STORE_STATUS']->value)){?><span class="store_open"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['open'];?>
</span><?php }else{ ?><span class="store_closed"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['closed'];?>
</span><?php }?></a>
	  </span>
	  <a href="?"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_dashboard'];?>
</a>
	  <?php if (isset($_smarty_tpl->tpl_vars['CRUMBS']->value)){?><?php  $_smarty_tpl->tpl_vars['crumb'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['crumb']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CRUMBS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['crumb']->key => $_smarty_tpl->tpl_vars['crumb']->value){
$_smarty_tpl->tpl_vars['crumb']->_loop = true;
?> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['crumb']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['crumb']->value['title'];?>
</a><?php } ?><?php }?>
	</div>
	<?php echo $_smarty_tpl->getSubTemplate ('templates/common.gui_message.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<div id="page_content">
	  <noscript><p class="warnText"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['error_js_required'];?>
</p></noscript>
	  <div id="sidebar_contain">
		<span id="sidebar_control">&laquo;</span>
		<div id="sidebar_content">
		  <div class="sidebar_content">
			<form action="?_g=customers" method="post">
			  <h4><?php echo $_smarty_tpl->tpl_vars['LANG']->value['search']['title_search_customers'];?>
</h4>
			  <input type="text" name="search[keywords]" id="customer_id" class="textbox ajax" rel="user" />
			  <input type="hidden" id="result_customer_id" name="search[customer_id]" value="" />
			  <input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['search'];?>
" />
			  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
			</form>
		  </div>
		  <div class="sidebar_content">
			<form action="?_g=products" method="post">
			  <h4><?php echo $_smarty_tpl->tpl_vars['LANG']->value['search']['title_search_products'];?>
</h4>
			  <input type="text" name="search[product]" id="product" class="textbox ajax" rel="product" /> <input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['search'];?>
" />
			   <input type="hidden" id="result_product" name="search[product_id]" value="" />
			   <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
			</form>
		  </div>
		  <div class="sidebar_content">
			<form action="?_g=orders" method="post">
			  <h4><?php echo $_smarty_tpl->tpl_vars['LANG']->value['search']['title_search_orders'];?>
</h4>
			  <input type="text" name="search[order_number]" id="search_order" class="textbox" /> <input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['search'];?>
" />
			  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
			</form>
		  </div>
		  <?php if (isset($_smarty_tpl->tpl_vars['SIDEBAR_CONTENT']->value)){?> <?php  $_smarty_tpl->tpl_vars['content'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['content']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SIDEBAR_CONTENT']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['content']->key => $_smarty_tpl->tpl_vars['content']->value){
$_smarty_tpl->tpl_vars['content']->_loop = true;
?><div class="sidebar_content"><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</div><?php } ?><?php }?>
		</div>
	  </div>
	  <div id="loading_content"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/loading.gif" alt="" /></div>
	  <?php echo $_smarty_tpl->tpl_vars['DISPLAY_CONTENT']->value;?>

	</div>
  </div>
  <!-- Include JavaScript last - YSlow! rates it better this way -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js"></script>

  <!--[if lte IE 6]>
  <script type="text/javascript">
	var IE6UPDATE_OPTIONS = {icons_path: "http://static.ie6update.com/hosted/ie6update/images/"}
  </script>
  <script type="text/javascript" src="http://static.ie6update.com/hosted/ie6update/ie6update.js"></script>
  <![endif]-->
  <script type="text/javascript" src="js/plugins.php"></script>
  <!-- Include CKEditor -->
  <script type="text/javascript" src="includes/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="includes/ckeditor/adapters/jquery.js"></script>
  <!-- Common JavaScript functionality -->
  <script type="text/javascript" src="js/common.js"></script>
  <script type="text/javascript" src="js/admin.js"></script>
  <?php if (isset($_smarty_tpl->tpl_vars['CLOSE_WINDOW']->value)){?>
  	<script type="text/javascript">
  	$(document).ready(function () {
  		setInterval(function() { window.close(); }, 1000);
  	});
  	</script>
  <?php }?>
  <?php if (is_array($_smarty_tpl->tpl_vars['EXTRA_JS']->value)){?>
  	<?php  $_smarty_tpl->tpl_vars['js_src'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_src']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['EXTRA_JS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_src']->key => $_smarty_tpl->tpl_vars['js_src']->value){
$_smarty_tpl->tpl_vars['js_src']->_loop = true;
?>
  		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_src']->value;?>
"></script>
  	<?php } ?>
  <?php }?>
</body>
</html><?php }} ?>