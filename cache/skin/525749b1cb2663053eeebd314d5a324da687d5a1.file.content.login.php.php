<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 15:40:25
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/content.login.php" */ ?>
<?php /*%%SmartyHeaderCode:96965289552d165e9379e10-68903464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '525749b1cb2663053eeebd314d5a324da687d5a1' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/content.login.php',
      1 => 1332769364,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96965289552d165e9379e10-68903464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'VAL_SELF' => 0,
    'LANG' => 0,
    'LOGIN_HTML' => 0,
    'html' => 0,
    'USERNAME' => 0,
    'REMEMBER' => 0,
    'STORE_URL' => 0,
    'REDIRECT_TO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d165e947dd18_48776570',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d165e947dd18_48776570')) {function content_52d165e947dd18_48776570($_smarty_tpl) {?><form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
  <h2><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['login'];?>
</h2>
  <div class="login-method">
	
	<fieldset>
	  <?php  $_smarty_tpl->tpl_vars['html'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['html']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LOGIN_HTML']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['html']->key => $_smarty_tpl->tpl_vars['html']->value){
$_smarty_tpl->tpl_vars['html']->_loop = true;
?>
	    <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

	  <?php } ?>
	  <div><label for="login-username"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['email_address'];?>
</label><span><input type="text" name="username" id="login-username" value="<?php echo $_smarty_tpl->tpl_vars['USERNAME']->value;?>
" class="" /></span></div>
	  <div><label for="login-password"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</label><span><input type="password" autocomplete="off" name="password" id="login-password" value="" class="" /></span></div>
	  <div><label for="login-remember"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['remember_me'];?>
</label><span><input type="checkbox" name="remember" id="login-remember" value="1" class="" <?php if ($_smarty_tpl->tpl_vars['REMEMBER']->value){?>checked="checked" <?php }?> /></span></div>
	  <div><label>&nbsp;</label><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?_a=recover"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['forgotten_password'];?>
</a></div>
	</fieldset>
  </div>
  <div>
	<input type="hidden" name="redir" value="<?php echo $_smarty_tpl->tpl_vars['REDIRECT_TO']->value;?>
" />
	<input name="submit" type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['log_in'];?>
" class="button_submit" />
  </div>
  </form><?php }} ?>