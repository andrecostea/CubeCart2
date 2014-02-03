<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.newsletter.php" */ ?>
<?php /*%%SmartyHeaderCode:208230284152a5b64b34eab7-51152753%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55182d773ee7e1ec8380c70ab7d010f19189219b' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.newsletter.php',
      1 => 1300356178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '208230284152a5b64b34eab7-51152753',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'IS_USER' => 0,
    'CTRL_SUBSCRIBED' => 0,
    'STORE_URL' => 0,
    'VAL_SELF' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b391094_70665740',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b391094_70665740')) {function content_52a5b64b391094_70665740($_smarty_tpl) {?><div id="mailing_list">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['mailing_list'];?>
</h3>
  <?php if ($_smarty_tpl->tpl_vars['IS_USER']->value){?>
	<?php if (($_smarty_tpl->tpl_vars['CTRL_SUBSCRIBED']->value)){?>
	<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['customer_is_subscribed'];?>
<br /><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?_a=newsletter&amp;action=unsubscribe"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['click_to_unsubscribe'];?>
</a></p>
	<?php }else{ ?>
	<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['customer_not_subscribed'];?>
<br /><a href="<?php echo $_smarty_tpl->tpl_vars['STORE_URL']->value;?>
/index.php?_a=newsletter&amp;action=subscribe"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['click_to_subscribe'];?>
</a></p>
	<?php }?>
  <?php }else{ ?>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
	<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['enter_email_signup'];?>
</p>
	<p class="input"><input name="subscribe" type="text" class="textbox required" size="18" maxlength="250" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['email_address'];?>
"/></p>
	<p><input type="submit" class="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['newsletter']['subscribe_now'];?>
" /></p>
  </form>
  <?php }?>
</div><?php }} ?>