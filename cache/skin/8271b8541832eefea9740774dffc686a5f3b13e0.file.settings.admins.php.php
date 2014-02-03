<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:21:37
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/settings.admins.php" */ ?>
<?php /*%%SmartyHeaderCode:134065394552d0ff11158f05-44192074%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8271b8541832eefea9740774dffc686a5f3b13e0' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/settings.admins.php',
      1 => 1350378978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134065394552d0ff11158f05-44192074',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'VAL_SELF' => 0,
    'DISPLAY_FORM' => 0,
    'ADD_EDIT_ADMIN' => 0,
    'LANG' => 0,
    'ADMIN' => 0,
    'LANGUAGES' => 0,
    'language' => 0,
    'IS_SUPER' => 0,
    'LINKED' => 0,
    'UNLINK' => 0,
    'SECTIONS' => 0,
    'section' => 0,
    'ADMINS' => 0,
    'admin' => 0,
    'SKIN_VARS' => 0,
    'SESSION_TOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ff11575dd1_30133921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ff11575dd1_30133921')) {function content_52d0ff11575dd1_30133921($_smarty_tpl) {?><form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
  <?php if ($_smarty_tpl->tpl_vars['DISPLAY_FORM']->value){?>
  <div id="general" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['ADD_EDIT_ADMIN']->value;?>
</h3>
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['details'];?>
</legend>
	  <div><label for="admin-name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['name'];?>
</label><span><input type="text" name="admin[name]" id="admin-name" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['name'];?>
" class="textbox required capitalize" /></span></div>
	  <div><label for="admin-username"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['username'];?>
</label><span><input type="text" name="admin[username]" id="admin-username" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['username'];?>
" class="textbox required" /></span></div>
	  <div><label for="admin-email"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['email'];?>
</label><span><input type="text" name="admin[email]" id="admin-email" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['email'];?>
" class="textbox required" /></span></div>
	  <div><label for="admin-lang"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['default_language'];?>
</label><span><select name="admin[language]" id="admin-lang" class="textbox">
	  <?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['code'];?>
" <?php echo $_smarty_tpl->tpl_vars['language']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['language']->value['title'];?>
</option><?php } ?>
	  </select></span></div>

	  <?php if ($_smarty_tpl->tpl_vars['IS_SUPER']->value&&isset($_smarty_tpl->tpl_vars['ADMIN']->value['super_user'])){?>
	  <div><label for="admin-super"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['super_user'];?>
</label><span><input type="hidden" name="admin[super_user]" id="admin-super" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['super_user'];?>
" /></span></div>
	  <?php }?>

	  <div><label for="order_notify"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['notifications'];?>
</label><span><input type="hidden" name="admin[order_notify]" id="order_notify" class="toggle" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['order_notify'];?>
" /></span></div>

	  <?php if ($_smarty_tpl->tpl_vars['LINKED']->value){?>
	  <div><label><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['account_linked'];?>
</label><span><a href="?_g=customers&amp;action=edit&amp;customer_id=<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['customer_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['account_link_view'];?>
</a> &nbsp; [<a href="<?php echo $_smarty_tpl->tpl_vars['UNLINK']->value;?>
" class="delete"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['remove'];?>
</a>]</span></div>
	  <?php }else{ ?>
	  <div><label for="admin-customer"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['account_link'];?>
</label><span>
		<input type="hidden" id="result_admin-customer" name="admin[customer_id]" /><input type="text" id="admin-customer" class="ajax textbox" rel="user" />
	  </span></div>
	  <?php }?>
	</fieldset>
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</legend>
	  <div><label for="admin-password"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['password'];?>
</label><span><input type="password" autocomplete="off" name="password" id="admin-password" class="textbox" /></span></div>
	  <div><label for="admin-passconf"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['user']['password_confirm'];?>
</label><span><input type="password" autocomplete="off" name="passconf" id="admin-passconf" rel="admin-password" class="textbox confirm" /></span></div>
	</fieldset>
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['notes'];?>
</legend>
	  <div><label for="admin-notes"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['notes'];?>
</label><span><textarea name="admin[notes]" id="admin-notes" class="textbox"><?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['notes'];?>
</textarea></span></div>
	</fieldset>
  </div>

  <div id="overview" class="tab_content">
	<div><label for="admin-logins"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['login_count'];?>
</label><span><input type="text" id="admin-logins" class="textbox number" name="admin[logins]" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['logins'];?>
" /></span></div>
	<div><label><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['login_last'];?>
</label><span><?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['last_login'];?>
</span></div>
  </div>

  <div id="permissions" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['permission'];?>
</h3>
	<table class="list">
	  <thead>
		<tr>
		  <th width="400"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['permission_section'];?>
</th>
		  <th width="40" align="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['read'];?>
</th>
		  <th width="40" align="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
</th>
		  <th width="40" align="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php  $_smarty_tpl->tpl_vars['section'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['section']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SECTIONS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['section']->key => $_smarty_tpl->tpl_vars['section']->value){
$_smarty_tpl->tpl_vars['section']->_loop = true;
?>
		<tr>
		  <td><dl><dt><?php echo $_smarty_tpl->tpl_vars['section']->value['name'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['section']->value['info'];?>
</dd></dl></td>
		  <td align="center"><input type="checkbox" class="read" name="permission[<?php echo $_smarty_tpl->tpl_vars['section']->value['id'];?>
][]" value="1" <?php echo $_smarty_tpl->tpl_vars['section']->value['read'];?>
 /></td>
		  <td align="center"><input type="checkbox" class="edit" name="permission[<?php echo $_smarty_tpl->tpl_vars['section']->value['id'];?>
][]" value="2" <?php echo $_smarty_tpl->tpl_vars['section']->value['edit'];?>
 /></td>
		  <td align="center"><input type="checkbox" class="delete" name="permission[<?php echo $_smarty_tpl->tpl_vars['section']->value['id'];?>
][]" value="4" <?php echo $_smarty_tpl->tpl_vars['section']->value['delete'];?>
 /></td>
		</tr>
	  <?php } ?>
	  </tbody>
	  <tfoot>
		<tr>
		  <td align="right"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['permission_all'];?>
</td>
		  <td align="center"><input type="checkbox" class="check-all" rel="read" /></td>
		  <td align="center"><input type="checkbox" class="check-all" rel="edit" /></td>
		  <td align="center"><input type="checkbox" class="check-all" rel="delete" /></td>
		</tr>
	  </tfoot>
	</table>
  </div>
  <?php }else{ ?>
  <div id="admins" class="tab_content list">
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['admins']['title_administrators'];?>
</h3>
	<?php  $_smarty_tpl->tpl_vars['admin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['admin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ADMINS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['admin']->key => $_smarty_tpl->tpl_vars['admin']->value){
$_smarty_tpl->tpl_vars['admin']->_loop = true;
?>
	<div>
	  <span class="actions">
		<a href="<?php echo $_smarty_tpl->tpl_vars['admin']->value['link_edit'];?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/edit.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
" /></a>
		<?php if ($_smarty_tpl->tpl_vars['admin']->value['link_delete']){?><a href="<?php echo $_smarty_tpl->tpl_vars['admin']->value['link_delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a><?php }?>
	  </span>
	  <input type="hidden" name="status[<?php echo $_smarty_tpl->tpl_vars['admin']->value['admin_id'];?>
]" id="status_<?php echo $_smarty_tpl->tpl_vars['admin']->value['admin_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['status'];?>
" class="toggle" />
	  <a href="<?php echo $_smarty_tpl->tpl_vars['admin']->value['link_edit'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['account']['logins'];?>
: <?php echo $_smarty_tpl->tpl_vars['admin']->value['logins'];?>
"><?php echo $_smarty_tpl->tpl_vars['admin']->value['name'];?>
</a>
	</div>
	<?php } ?>
  </div>
<?php }?>

  <?php echo $_smarty_tpl->getSubTemplate ('templates/element.hook_form_content.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


  <div class="form_control">
	<input type="hidden" name="admin_id" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['admin_id'];?>
" />
	<input type="hidden" name="previous-tab" id="previous-tab" value="" />
	<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" />
  </div>
  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
</form><?php }} ?>