<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/main.php" */ ?>
<?php /*%%SmartyHeaderCode:69508177452a5b64b503492-25167881%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28310e921823272ec14d95d9b63c294b429c6ac7' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/main.php',
      1 => 1360331467,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69508177452a5b64b503492-25167881',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TEXT_DIRECTION' => 0,
    'HTML_LANG' => 0,
    'META_TITLE' => 0,
    'VAL_SELF' => 0,
    'STORE_URL' => 0,
    'SKIN_FOLDER' => 0,
    'SKIN_SUBSET' => 0,
    'CSS' => 0,
    'css_files' => 0,
    'CHARACTER_SET' => 0,
    'META_DESCRIPTION' => 0,
    'META_KEYWORDS' => 0,
    'FBOG' => 0,
    'PRODUCT' => 0,
    'ANALYTICS' => 0,
    'SESSION' => 0,
    'CURRENCY' => 0,
    'LANGUAGE' => 0,
    'SEARCH_FORM' => 0,
    'STORE_LOGO' => 0,
    'LANG' => 0,
    'CRUMBS' => 0,
    'crumb' => 0,
    'SECTION_NAME' => 0,
    'CATEGORIES' => 0,
    'SALE_ITEMS' => 0,
    'MAIL_LIST' => 0,
    'SHOPPING_CART' => 0,
    'RANDOM_PROD' => 0,
    'POPULAR_PRODUCTS' => 0,
    'CHECKOUT_PROGRESS' => 0,
    'PAGE_CONTENT' => 0,
    'SKIN_SELECT' => 0,
    'SITE_DOCS' => 0,
    'COPYRIGHT' => 0,
    'CONFIG' => 0,
    'DEBUG_INFO' => 0,
    'JANRAIN' => 0,
    'LIVE_HELP' => 0,
    'JS_SCRIPTS' => 0,
    'script' => 0,
    'COOKIE_DIALOGUE' => 0,
    'COOKIE_DIALOGUE_FAIL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b647099_60250056',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b647099_60250056')) {function content_52a5b64b647099_60250056($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/student/public_html/CubeCart-5.2.2/includes/lib/smarty/plugins/modifier.replace.php';
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $_smarty_tpl->tpl_vars['TEXT_DIRECTION']->value;?>
" lang="<?php echo $_smarty_tpl->tpl_vars['HTML_LANG']->value;?>
">
  <head>
	<title><?php echo $_smarty_tpl->tpl_vars['META_TITLE']->value;?>
</title>
	<link rel="canonical" href="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" />
	<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/styles/common.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/styles/<?php echo $_smarty_tpl->tpl_vars['SKIN_SUBSET']->value;?>
/layout.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/js/styles/styles.php" media="screen" />
	<?php if (isset($_smarty_tpl->tpl_vars['CSS']->value)){?>
		<?php  $_smarty_tpl->tpl_vars['css_files'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['css_files']->_loop = false;
 $_smarty_tpl->tpl_vars['css_keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CSS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['css_files']->key => $_smarty_tpl->tpl_vars['css_files']->value){
$_smarty_tpl->tpl_vars['css_files']->_loop = true;
 $_smarty_tpl->tpl_vars['css_keys']->value = $_smarty_tpl->tpl_vars['css_files']->key;
?>
		  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['css_files']->value;?>
" media="screen" />
	    <?php } ?>
    <?php }?>
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_FOLDER']->value;?>
/styles/ie7.css" media="screen" /><![endif]-->
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $_smarty_tpl->tpl_vars['CHARACTER_SET']->value;?>
" />
	<meta name="description" content="<?php if (isset($_smarty_tpl->tpl_vars['META_DESCRIPTION']->value)){?><?php echo $_smarty_tpl->tpl_vars['META_DESCRIPTION']->value;?>
<?php }?>" />
	<meta name="keywords" content="<?php if (isset($_smarty_tpl->tpl_vars['META_KEYWORDS']->value)){?><?php echo $_smarty_tpl->tpl_vars['META_KEYWORDS']->value;?>
<?php }?>" />
	<meta name="robots" content="index, follow" />
	<meta name="generator" content="cubecart" />
	<?php if ($_smarty_tpl->tpl_vars['FBOG']->value){?>
	<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['PRODUCT']->value['thumbnail'];?>
">
	<meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
">
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['ANALYTICS']->value){?>
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '<?php echo $_smarty_tpl->tpl_vars['ANALYTICS']->value;?>
']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	<?php }?>
  </head>
<body>
  <div id="page_wrapper">
	<div id="account">
	  <?php echo $_smarty_tpl->tpl_vars['SESSION']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['CURRENCY']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>

	</div>
	<div id="header">
	  <?php echo $_smarty_tpl->tpl_vars['SEARCH_FORM']->value;?>

	  <p class="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['STORE_LOGO']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['META_TITLE']->value;?>
" /></a></p>
	</div>
	<div id="breadcrumb">
	  <ul>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['home'];?>
</a></li>
		<?php  $_smarty_tpl->tpl_vars['crumb'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['crumb']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CRUMBS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['crumb']->key => $_smarty_tpl->tpl_vars['crumb']->value){
$_smarty_tpl->tpl_vars['crumb']->_loop = true;
?>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['crumb']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['crumb']->value['title'];?>
</a></li>
		<?php } ?>
	  </ul>
	</div>

	<div class="<?php echo $_smarty_tpl->tpl_vars['SECTION_NAME']->value;?>
_wrapper">
	  <div class="sidebar" id="sidebar_left">
		<?php echo $_smarty_tpl->tpl_vars['CATEGORIES']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['SALE_ITEMS']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['MAIL_LIST']->value;?>

	  </div>
	  <div class="sidebar" id="sidebar_right">
		<?php echo $_smarty_tpl->tpl_vars['SHOPPING_CART']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['RANDOM_PROD']->value;?>

		<?php if (isset($_smarty_tpl->tpl_vars['POPULAR_PRODUCTS']->value)){?><?php echo $_smarty_tpl->tpl_vars['POPULAR_PRODUCTS']->value;?>
<?php }?>
	  </div>
	  <div id="page_content">
		<?php echo $_smarty_tpl->getSubTemplate ('templates/box.errors.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<?php if (isset($_smarty_tpl->tpl_vars['CHECKOUT_PROGRESS']->value)){?><?php echo $_smarty_tpl->tpl_vars['CHECKOUT_PROGRESS']->value;?>
<?php }?>
		<?php echo $_smarty_tpl->tpl_vars['PAGE_CONTENT']->value;?>

		<p style="clear: both; height: 1px;">&nbsp;</p>
	  </div>
	  <div id="documents"><?php if (isset($_smarty_tpl->tpl_vars['SKIN_SELECT']->value)){?><?php echo $_smarty_tpl->tpl_vars['SKIN_SELECT']->value;?>
<?php }?> <?php echo $_smarty_tpl->tpl_vars['SITE_DOCS']->value;?>
</div>
	</div>
  </div>
  
  <?php echo $_smarty_tpl->tpl_vars['COPYRIGHT']->value;?>

  <?php if (!$_smarty_tpl->tpl_vars['CONFIG']->value['disable_mobile_skin']){?><p id="mobile_switch"><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?display_mobile=1"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['mobile_site'];?>
</a></p><?php }?>
  
  <?php if (isset($_smarty_tpl->tpl_vars['DEBUG_INFO']->value)){?><?php echo $_smarty_tpl->tpl_vars['DEBUG_INFO']->value;?>
<?php }?>

  <?php echo $_smarty_tpl->getSubTemplate ('js/common.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


  <?php if (isset($_smarty_tpl->tpl_vars['JANRAIN']->value)){?><?php echo $_smarty_tpl->tpl_vars['JANRAIN']->value;?>
<?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['LIVE_HELP']->value)){?><?php echo $_smarty_tpl->tpl_vars['LIVE_HELP']->value;?>
<?php }?>

  <?php  $_smarty_tpl->tpl_vars['script'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['script']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['JS_SCRIPTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['script']->key => $_smarty_tpl->tpl_vars['script']->value){
$_smarty_tpl->tpl_vars['script']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['script']->key;
?>
  <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['script']->value,'\\','/');?>
"></script>
  <?php } ?>
  
  <?php if ($_smarty_tpl->tpl_vars['COOKIE_DIALOGUE']->value){?>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" class="cookies-notify" method="POST">
    <p><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['store_name'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['LANG']->value['notification']['cookie_dialogue'],'%s',$_tmp1);?>
</p>
    <p<?php if ($_smarty_tpl->tpl_vars['COOKIE_DIALOGUE_FAIL']->value){?> class="retry"<?php }?>><input type="checkbox" name="accept_cookies" value="1" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['cookie_dialogue_declaration'];?>
 <input type="submit" name="accept_cookies_submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['continue'];?>
" /></p>
  </form>
  <?php }?>
  
</body>
</html><?php }} ?>