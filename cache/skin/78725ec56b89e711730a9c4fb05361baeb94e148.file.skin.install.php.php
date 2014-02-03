<?php /* Smarty version Smarty-3.1.13, created on 2013-12-05 06:11:58
         compiled from "/home/student/public_html/CubeCart-5.2.2/setup/skin.install.php" */ ?>
<?php /*%%SmartyHeaderCode:207306128252a0192e71e418-72845052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78725ec56b89e711730a9c4fb05361baeb94e148' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/setup/skin.install.php',
      1 => 1351591757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207306128252a0192e71e418-72845052',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'VERSION' => 0,
    'REFRESH' => 0,
    'LANG_LIST' => 0,
    'lang' => 0,
    'LANG' => 0,
    'PROGRESS' => 0,
    'GUI_MESSAGE' => 0,
    'error' => 0,
    'notice' => 0,
    'MODE_COMPAT' => 0,
    'CHECKS' => 0,
    'check' => 0,
    'EXTENSIONS' => 0,
    'ext' => 0,
    'MODE_METHOD' => 0,
    'SHOW_UPGRADE' => 0,
    'LANG_UPGRADE_CUBECART_TITLE' => 0,
    'LANG_INSTALL_CUBECART_TITLE' => 0,
    'MODE_LICENCE' => 0,
    'MODE_PERMS' => 0,
    'PERMISSIONS' => 0,
    'file' => 0,
    'PERMS_PASS' => 0,
    'MODE_INSTALL' => 0,
    'FORM' => 0,
    'LANGUAGES' => 0,
    'language' => 0,
    'CURRENCIES' => 0,
    'currency' => 0,
    'MODE_UPGRADE' => 0,
    'MODE_UPGRADE_CONFIRM' => 0,
    'LANG_UPGRADE_FROM_TO' => 0,
    'SHOW_LICENCE' => 0,
    'LANG_UPGRADE_LICENCE_NEEDED' => 0,
    'MODE_UPGRADE_PROGRESS' => 0,
    'LANG_UPGRADE_IN_PROGRESS' => 0,
    'MODE_COMPLETE' => 0,
    'MODE_COMPLETE_INSTALL' => 0,
    'MODE_COMPLETE_UPGRADE' => 0,
    'SHOW_LINKS' => 0,
    'CONTROLLER' => 0,
    'COPYRIGHT_YEAR' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a0192e970792_47404154',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a0192e970792_47404154')) {function content_52a0192e970792_47404154($_smarty_tpl) {?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>CubeCart&trade; <?php echo $_smarty_tpl->tpl_vars['VERSION']->value;?>
 Installer</title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="styles/style.css" media="screen" />
  <?php if (isset($_smarty_tpl->tpl_vars['REFRESH']->value)){?><meta http-equiv="refresh" content="5" /><?php }?>
</head>
<body>
<div id="frame">
  <div id="header">
	<div id="language">
	  <form action="index.php" method="post" enctype="multipart/form-data">
		<select name="language" id="language-select" class="textbox">
		<?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LANG_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value){
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['code'];?>
"<?php echo $_smarty_tpl->tpl_vars['lang']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['lang']->value['title'];?>
</option><?php } ?>
		</select>
		<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['update'];?>
" class="mini_button" />
	  </form>
	</div>
  </div>

  <?php if (isset($_smarty_tpl->tpl_vars['PROGRESS']->value)){?>
  <div id="progress">
	<div class="container">
	  <div class="indicator" style="width: <?php echo $_smarty_tpl->tpl_vars['PROGRESS']->value['percent'];?>
% !important;">&nbsp;</div>
	</div>
	<div class="text"><?php echo $_smarty_tpl->tpl_vars['PROGRESS']->value['message'];?>
</div>
  </div>
  <?php }?>


  <?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value)){?>
	<?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['errors'])){?>
  <div id="error">
	<h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['gui_message']['errors_detected'];?>
</h3>
	<ul>
	  <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
?><li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li><?php } ?>
	</ul>
  </div>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['notices'])){?>
	<?php  $_smarty_tpl->tpl_vars['notice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['notice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GUI_MESSAGE']->value['notices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['notice']->key => $_smarty_tpl->tpl_vars['notice']->value){
$_smarty_tpl->tpl_vars['notice']->_loop = true;
?>
  <div id="notice">
	<h3 class="first"><?php echo $_smarty_tpl->tpl_vars['notice']->value;?>
</h3>
  </div>
	<?php } ?>
	<?php }?>
  <?php }?>

  <form action="index.php" method="post" enctype="multipart/form-data">
	<div id="content">
  <?php if (isset($_smarty_tpl->tpl_vars['MODE_COMPAT']->value)){?>
	  <h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_compat_check'];?>
</h3>
	  <?php  $_smarty_tpl->tpl_vars['check'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['check']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CHECKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['check']->key => $_smarty_tpl->tpl_vars['check']->value){
$_smarty_tpl->tpl_vars['check']->_loop = true;
?>
	  <div>
		<span class="result"><?php if ($_smarty_tpl->tpl_vars['check']->value['status']){?><span class="pass"><?php echo $_smarty_tpl->tpl_vars['check']->value['pass'];?>
</span><?php }else{ ?><span class="fail"><?php echo $_smarty_tpl->tpl_vars['check']->value['fail'];?>
</span><?php }?></span>
	  <?php echo $_smarty_tpl->tpl_vars['check']->value['title'];?>

	  </div>
	  <?php } ?>
	  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_optional_features'];?>
</h3>
	  <?php  $_smarty_tpl->tpl_vars['ext'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ext']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['EXTENSIONS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ext']->key => $_smarty_tpl->tpl_vars['ext']->value){
$_smarty_tpl->tpl_vars['ext']->_loop = true;
?>
	  <div>
		<span class="result"><?php if ($_smarty_tpl->tpl_vars['ext']->value['status']){?><span class="pass"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['installed'];?>
</span><?php }else{ ?><span class="fail"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['not_installed'];?>
</span><?php }?></span>
		<?php echo $_smarty_tpl->tpl_vars['ext']->value['name'];?>

	  </div>
	  <?php } ?>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['MODE_METHOD']->value)){?>
	<?php if (isset($_smarty_tpl->tpl_vars['SHOW_UPGRADE']->value)){?>
	  <div id="method-upgrade" class="click-select">
	  <input type="radio" name="method" value="upgrade" />
	  <span class="icon"><img src="images/upgrade.gif" alt="" /></span>
	  <h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG_UPGRADE_CUBECART_TITLE']->value;?>
</h3>
	  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['upgrade_existing'];?>
</p>
	</div>
	<?php }?>
	<div id="method-install" class="click-select<?php if (isset($_smarty_tpl->tpl_vars['SHOW_UPGRADE']->value)){?> faded<?php }?>">
	  <input type="radio" name="method" value="install" />
	  <span class="icon"><img src="images/install.gif" alt="" /></span>
	  <h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG_INSTALL_CUBECART_TITLE']->value;?>
</h3>
	  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_fresh'];?>
</p>
	</div>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['MODE_LICENCE']->value)){?>
	<h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_licence'];?>
</h3>
	<div class="license"><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['ROOT']->value)."/docs/license.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
	<div><input type="checkbox" id="licence_agree" name="licence" value="1" /> <label for="licence_agree"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['licence_agree'];?>
</label></div>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['MODE_PERMS']->value)){?>
	<h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_file_permissions'];?>
</h3>
	<?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PERMISSIONS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value){
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
	  <div>
		<span class="result"><?php if ($_smarty_tpl->tpl_vars['file']->value['status']){?><span class="pass"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['writable'];?>
</span><?php }else{ ?><span class="fail"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['read_only'];?>
</span><?php }?></span>
		<?php echo $_smarty_tpl->tpl_vars['file']->value['name'];?>

	  </div>
	<?php } ?>
	<?php if (isset($_smarty_tpl->tpl_vars['PERMS_PASS']->value)){?><input type="hidden" name="permissions" value="1" /><?php }?>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['MODE_INSTALL']->value)){?>
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_database_settings'];?>
</h3>
	<fieldset>
	  <div><label for="form-dbhhost" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbhostname'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['db_host'];?>
</label><span><input type="text" name="global[dbhost]" id="form-dbhost" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbhost'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-dbusername" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbusername'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['username'];?>
</label><span><input type="text" name="global[dbusername]" id="form-dbusername" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbusername'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-dbpassword" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbuserpass'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</label><span><input type="password" autocomplete="off" name="global[dbpassword]" id="form-dbpassword" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbpassword'];?>
" class="textbox" /></span></div>
	  <div><label for="form-dbpassconf" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbconfirmpass'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password_confirm'];?>
</label><span><input type="password" autocomplete="off" name="global[dbpassconf]" rel="form-dbpassword" id="form-dbpassconf" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbpassconf'];?>
" class="textbox confirm" /></span></div>
	  <div><label for="form-dbdatabase" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbname'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['db_name'];?>
</label><span><input type="text" name="global[dbdatabase]" id="form-dbdatabase" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbdatabase'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-dbprefix" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_dbprefix'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['db_prefix'];?>
</label><span><input type="text" name="global[dbprefix]" id="form-dbprefix" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['global']['dbprefix'];?>
" class="textbox" /></span></div>
	</fieldset>
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_store_settings'];?>
</h3>
	<fieldset>
	  <div>
		<label for="form-language" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_defaultlang'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_language'];?>
</label>
		<span>
		  <select name="config[default_language]" id="form-language" class="textbox required">
			<option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
			<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['code'];?>
"<?php echo $_smarty_tpl->tpl_vars['language']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['language']->value['title'];?>
</option><?php } ?>
		  </select>
		</span>
	  </div>
	  <div>
		<label for="form-currency" class="help" rel="" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['help_defaultcurrency'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_currency'];?>
</label>
		<span>
		  <select name="config[default_currency]" id="form-currency" class="textbox required">
			<option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
			<?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CURRENCIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value){
$_smarty_tpl->tpl_vars['currency']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value['code'];?>
"<?php echo $_smarty_tpl->tpl_vars['currency']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['currency']->value['code'];?>
 - <?php echo $_smarty_tpl->tpl_vars['currency']->value['name'];?>
</option><?php } ?>
		  </select>
		</span>
	  </div>
	</fieldset>
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_admin_profile'];?>
</h3>
	<fieldset>
	  <div><label for="form-username" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['username'];?>
</label><span><input type="text" name="admin[username]" id="form-username" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['admin']['username'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-password" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</label><span><input type="password" name="admin[password]" id="form-password" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['admin']['password'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-passconf" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password_confirm'];?>
</label><span><input type="password" name="admin[passconf]" id="form-passconf" rel="form-password" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['admin']['passconf'];?>
" class="textbox required confirm" /></span></div>
	  <div><label for="form-realname" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['name_full'];?>
</label><span><input type="text" name="admin[name]" id="form-realname" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['admin']['name'];?>
" class="textbox required" /></span></div>
	  <div><label for="form-email" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['email'];?>
</label><span><input type="text" name="admin[email]" id="form-email" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['admin']['email'];?>
" class="textbox required" /></span></div>
	</fieldset>
	<h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_software_licence'];?>
 <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['optional'];?>
</h3>
	<p>Please leave this field empty to use &quot;<a href="http://cubecart.com/tour/features" target="_blank">CubeCart Lite</a>&quot;. (Link opens in new window)</p>
	<fieldset>
	  <div><label for="form-licence" class="help" rel=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['software_licence_key'];?>
 <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['optional'];?>
</label><span><input type="text" name="license_key" id="form-licence" value="<?php echo $_smarty_tpl->tpl_vars['FORM']->value['license_key'];?>
" class="textbox" /> </span></div>
	</fieldset>
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['title_advanced_settings'];?>
</h3>
	<fieldset>
	  <div><label for="form-drop" class="help" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_drop_tables_explained'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_drop_tables'];?>
</label><span><input type="checkbox" name="drop" id="form-drop" value="1" /> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_drop_tables_explained'];?>
</span></div>
	</fieldset>
	<input type="hidden" name="progress" value="0" />
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['MODE_UPGRADE']->value)){?>
	<?php if (isset($_smarty_tpl->tpl_vars['MODE_UPGRADE_CONFIRM']->value)){?>
	<div><?php echo $_smarty_tpl->tpl_vars['LANG_UPGRADE_FROM_TO']->value;?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['upgrade_will_reload'];?>
<br />
	<br />
	<?php if (isset($_smarty_tpl->tpl_vars['SHOW_LICENCE']->value)){?>
	<fieldset>
	  <div><?php echo $_smarty_tpl->tpl_vars['LANG_UPGRADE_LICENCE_NEEDED']->value;?>
</div>
	  <p>Please leave this field empty to use &quot;<a href="http://cubecart.com/tour/features" target="_blank">CubeCart Lite</a>&quot;. (Link opens in new window)</p>
	  <br />
	  <div><label for="licence_key"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['software_licence_key'];?>
 <?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['optional'];?>
</label><span><input type="text" id="licence_key" name="license_key" class="textbox" value="" /></span></div>
	</fieldset>
	<?php }?>

	<br /><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['upgrade_click_continue'];?>
</div>
	<input type="hidden" name="progress" value="0" />
	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['MODE_UPGRADE_PROGRESS']->value)){?>
	  <div>
	  <p><?php echo $_smarty_tpl->tpl_vars['LANG_UPGRADE_IN_PROGRESS']->value;?>
</p>
	  <img src="images/loading.gif" align="middle" />
	  </div>
	<?php }?>
  <?php }?>


  <?php if (isset($_smarty_tpl->tpl_vars['MODE_COMPLETE']->value)){?>
	<?php if (isset($_smarty_tpl->tpl_vars['MODE_COMPLETE_INSTALL']->value)){?>
	  <h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_complete'];?>
</h3>
	  <div><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['install_complete_note'];?>
</div>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['MODE_COMPLETE_UPGRADE']->value)){?>
	  <h3 class="first"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['upgrade_complete'];?>
</h3>
	  <div><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['upgrade_complete_note'];?>
</div>
	<?php }?>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['SHOW_LINKS']->value)){?>
	  <div>
		<ul>
		  <li><a href="../admin.php?_g=settings" target="_blank"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['link_admin_panel'];?>
</a></li>
		  <li><a href="../index.php" target="_blank"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['link_store_front'];?>
</a></li>
		</ul>
	  </div>
	<?php }?>

	  <div id="toolbar">
		<?php if (isset($_smarty_tpl->tpl_vars['CONTROLLER']->value['continue'])){?><span class="continue"><input type="submit" name="proceed" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['continue'];?>
" class="" /></span><?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['CONTROLLER']->value['retry'])){?><span class="continue"><input type="submit" name="retry" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['button_retry'];?>
" class="" /></span><?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['CONTROLLER']->value['restart'])){?><span class="cancel"><input type="submit" name="cancel" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['setup']['button_restart'];?>
" class="cancel" /></span><?php }?>
	  </div>
	</div>
  </form>
</div>
<div id="footer">
  Copyright <a href="http://www.cubecart.com" target="_blank">Devellion Ltd</a> <?php echo $_smarty_tpl->tpl_vars['COPYRIGHT_YEAR']->value;?>
. All rights reserved.
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/plugins/jquery.pstrength.js"></script>
<script type="text/javascript" src="js/install.js"></script>
</body>
</html><?php }} ?>