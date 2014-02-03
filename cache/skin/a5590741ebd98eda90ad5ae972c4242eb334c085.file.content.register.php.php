<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 15:40:59
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/content.register.php" */ ?>
<?php /*%%SmartyHeaderCode:115525207252d1660b78a213-34794701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5590741ebd98eda90ad5ae972c4242eb334c085' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/content.register.php',
      1 => 1321530922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115525207252d1660b78a213-34794701',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'VAL_SELF' => 0,
    'LOGIN_HTML' => 0,
    'html' => 0,
    'DATA' => 0,
    'TERMS_CONDITIONS' => 0,
    'TERMS_CONDITIONS_CHECKED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d1660b909a74_57545084',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d1660b909a74_57545084')) {function content_52d1660b909a74_57545084($_smarty_tpl) {?><h2><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['create_account'];?>
</h2>
<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register_text'];?>
</p>
<form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" name="registration">
  <fieldset>
	  <?php  $_smarty_tpl->tpl_vars['html'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['html']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LOGIN_HTML']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['html']->key => $_smarty_tpl->tpl_vars['html']->value){
$_smarty_tpl->tpl_vars['html']->_loop = true;
?>
	    <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

	  <?php } ?>
	<div><label for="register-title"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['title'];?>
</label><span><input type="text" name="title" id="register-title" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['title'];?>
" class="" /></span></div>
	<div><label for="register-firstname"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['name_first'];?>
</label><span><input type="text" name="first_name" id="register-firstname" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['first_name'];?>
" class="required" /> *</span></div>
	<div><label for="register-lastname"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['name_last'];?>
</label><span><input type="text" name="last_name" id="register-lastname" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['last_name'];?>
" class="required" /> *</span></div>
	<div><label for="register-email"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['email'];?>
</label><span><input type="text" name="email" id="register-email" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['email'];?>
" class="required" /> *</span></div>
	<div><label for="register-phone"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['phone'];?>
</label><span><input type="text" name="phone" id="register-phone" class="textbox required" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['phone'];?>
" /> *</span></div>
	<div><label for="register-mobile"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['address']['mobile'];?>
</label><span><input type="text" name="mobile" id="register-mobile" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['DATA']->value['mobile'];?>
" /></span></div>

	<div><label for="register-password"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</label><span><input type="password" autocomplete="off" name="password" id="register-password" value="" class="required" /> *</span></div>
	<div><label for="register-passconf"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password_confirm'];?>
</label><span><input type="password" autocomplete="off" name="passconf" id="register-passconf" value="" class="required" /> *</span></div>

	<?php echo $_smarty_tpl->getSubTemplate ('templates/content.recaptcha.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	<?php if ($_smarty_tpl->tpl_vars['TERMS_CONDITIONS']->value){?>
	<div><label for="register-terms">&nbsp;</label><span><input type="checkbox" id="register-terms" name="terms_agree" value="1" <?php echo $_smarty_tpl->tpl_vars['TERMS_CONDITIONS_CHECKED']->value;?>
 /> <a href="<?php echo $_smarty_tpl->tpl_vars['TERMS_CONDITIONS']->value;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register_terms_agree'];?>
</a></span></div>
	<?php }?>
	<div><label for="register-mailing">&nbsp;</label><span><input type="checkbox" id="register-mailing" name="mailing_list" value="1" <?php if (isset($_smarty_tpl->tpl_vars['DATA']->value['mailing_list'])&&$_smarty_tpl->tpl_vars['DATA']->value['mailing_list']==1){?>checked="checked"<?php }?> /><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register_mailing'];?>
</a></span></div>
  </fieldset>
  <div><input type="submit" name="register" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['register'];?>
" class="button_submit" /></div>
</form><?php }} ?>