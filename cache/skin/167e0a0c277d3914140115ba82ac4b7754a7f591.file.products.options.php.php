<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:24:48
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/products.options.php" */ ?>
<?php /*%%SmartyHeaderCode:11517964752d0ffd0173c79-15199395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '167e0a0c277d3914140115ba82ac4b7754a7f591' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/products.options.php',
      1 => 1360941566,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11517964752d0ffd0173c79-15199395',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'VAL_SELF' => 0,
    'LANG' => 0,
    'GROUPS' => 0,
    'SKIN_VARS' => 0,
    'group' => 0,
    'OPTION_TYPES' => 0,
    'key' => 0,
    'type' => 0,
    'OPTION_TYPE_JSON' => 0,
    'option' => 0,
    'SETS' => 0,
    'set' => 0,
    'members' => 0,
    'member' => 0,
    'value_id' => 0,
    'value_name' => 0,
    'SESSION_TOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ffd0676c97_56389964',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ffd0676c97_56389964')) {function content_52d0ffd0676c97_56389964($_smarty_tpl) {?><div>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
	<div id="groups" class="tab_content">
	  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_groups'];?>
</h3>
	  <table class="list">
		<thead>
		  <tr>
			<td width="20"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['arrange'];?>
</td>
			<td width="70" align="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['required'];?>
</td>
			<td width="300"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['name'];?>
</td>
			<td width="150"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['option_group_type'];?>
</td>
			<td width="300"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['description'];?>
</td>
			<td width="50">&nbsp;</td>
		  </tr>
		</thead>
		<tbody class="reorder-list">
		  <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GROUPS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
		  <tr>
			<td align="center"><a href="#" class="handle"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/updown.gif" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['ui']['drag_reorder'];?>
" /></a>
			<input type="hidden" name="group_priority[]" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
" /></td>
			<td align="center"><input type="hidden" name="edit_group[<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
][option_required]" id="status_<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['required'];?>
" class="toggle" /></td>
			<td><span class="editable" name="edit_group[<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
][option_name]"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</span></td>
			<td><span class="editable select" name="edit_group[<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
][option_type]"><?php echo $_smarty_tpl->tpl_vars['group']->value['type_name'];?>
</span></td>
			<td><span class="editable" name="edit_group[<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
][option_description]"><?php echo $_smarty_tpl->tpl_vars['group']->value['description'];?>
</span>&nbsp;</td>
			<td align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['group']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a></td>
		  </tr>
		  <?php }
if (!$_smarty_tpl->tpl_vars['group']->_loop) {
?>
		  <tr>
			<td align="center" colspan="5"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['no_option_groups'];?>
</td>
		  </tr>
		  <?php } ?>
		</tbody>
	  </table>

	  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_group_add'];?>
</legend>
		<div><label for="new-group-name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['option_group_name'];?>
</label><span><input type="text" name="add-group[option_name]" id="new-group-name" class="textbox" /></span></div>
		<div><label for="new-group-description"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['description'];?>
</label><span><input type="text" name="add-group[option_description]" id="new-group-description" class="textbox" /></span></div>
		<div>
		  <label for="new-group-type"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['option_group_type'];?>
</label>
		  <span>
			<select name="add-group[option_type]" id="new-group-type" class="textbox">
			<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['OPTION_TYPES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value){
$_smarty_tpl->tpl_vars['type']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['type']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</option><?php } ?>
			</select>
		  </span>
		</div>
		<div><label for="new-group-required"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['required'];?>
</label><span><input type="hidden" name="add-group[option_required]" id="new-group-required" class="toggle" value="0" /></span></div>
	  </fieldset>
	  <script type="text/javascript">
		<?php if (isset($_smarty_tpl->tpl_vars['OPTION_TYPE_JSON']->value)){?>var select_data = <?php echo $_smarty_tpl->tpl_vars['OPTION_TYPE_JSON']->value;?>
<?php }?>
	  </script>
	</div>

	<div id="attributes" class="tab_content">
	  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_attributes'];?>
</h3>
	  <div>
		<select name="add-value[option_id]" id="select_group_id" rel="group_" class="field_select">
		  <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GROUPS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['group']->value['type']==0){?><option value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</option><?php }?><?php } ?>
		</select>
	  </div>
	  <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GROUPS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
	  <?php if ($_smarty_tpl->tpl_vars['group']->value['type']==0){?>
	  <fieldset id="group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
" class="list field_select_target"><legend><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</legend>
		<div class="reorder-list">
		<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['group']->value['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['option']->key;
?>
		<div>
		  <span><a href="#" class="handle"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/updown.gif" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['ui']['drag_reorder'];?>
" /></a>
			<input type="hidden" name="attr_priority[]" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" />
		  </span>
		  <span class="actions">
			<a href="?_g=products&amp;node=options&amp;delete=attribute&amp;id=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		  </span>
		  &bull; <span class="editable" name="edit_attribute[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
][value_name]"><?php echo $_smarty_tpl->tpl_vars['option']->value;?>
</span>
		</div>
		<?php }
if (!$_smarty_tpl->tpl_vars['option']->_loop) {
?>
		<?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['option_attributes_none'];?>

		<?php } ?>
		</div>
	  </fieldset>
	  <?php }?>
	  <?php } ?>

	  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_attribute_add'];?>
</legend>
		<div class="inline-add">
		  <label for="new-value-name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['name'];?>
</label>
		  <span>
			<input type="text" name="add-value[value_name]" id="new-value-name" rel="attr_name" class="textbox" />
			<a href="#" id="group_target" class="add"><img src="images/icons/add.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['add'];?>
" /></a>
		  </span>
		</div>

		<div id="attr_source" class="inline-source">
		  <span class="actions">
			<a href="#" class="remove" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		  </span>
		  &bull; <span rel="attr_name"></span><input type="hidden" rel="attr_name" />
		</div>
	  </fieldset>
	</div>

	<div id="sets" class="tab_content">
	  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_sets'];?>
</h3>
	  <?php if ($_smarty_tpl->tpl_vars['SETS']->value){?>
	  <div>
		<select name="set_id" id="" rel="set_" class="field_select">
		  <option value="0"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
		  <?php  $_smarty_tpl->tpl_vars['set'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['set']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SETS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['set']->key => $_smarty_tpl->tpl_vars['set']->value){
$_smarty_tpl->tpl_vars['set']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['set']->value['set_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['set']->value['set_name'];?>
</option><?php } ?>
		</select>
	  </div>

	  <?php  $_smarty_tpl->tpl_vars['set'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['set']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SETS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['set']->key => $_smarty_tpl->tpl_vars['set']->value){
$_smarty_tpl->tpl_vars['set']->_loop = true;
?>
	  <fieldset class="field_select_target" id="set_<?php echo $_smarty_tpl->tpl_vars['set']->value['set_id'];?>
" rel="add_options"><legend><?php echo $_smarty_tpl->tpl_vars['set']->value['set_name'];?>
</legend>
		<div class="list">
		<?php  $_smarty_tpl->tpl_vars['members'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['members']->_loop = false;
 $_smarty_tpl->tpl_vars['set_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['set']->value['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['members']->key => $_smarty_tpl->tpl_vars['members']->value){
$_smarty_tpl->tpl_vars['members']->_loop = true;
 $_smarty_tpl->tpl_vars['set_id']->value = $_smarty_tpl->tpl_vars['members']->key;
?>
		  <?php  $_smarty_tpl->tpl_vars['member'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['member']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['members']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['member']->key => $_smarty_tpl->tpl_vars['member']->value){
$_smarty_tpl->tpl_vars['member']->_loop = true;
?>
		  <div>
			<span class="actions">
			  <a href="#" class="remove" name="member_delete" rel="<?php echo $_smarty_tpl->tpl_vars['member']->value['set_member_id'];?>
" title=""><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
			</span>
			&bull; <?php echo $_smarty_tpl->tpl_vars['member']->value['display'];?>

		  </div>
		  <?php } ?>
		<?php } ?>
		</div>
		<div style="text-align: center;"><a href="<?php echo $_smarty_tpl->tpl_vars['set']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
</a></div>
	  </fieldset>
	  <?php } ?>

	  <fieldset id="add_options" class="field_select_target"><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_set_append'];?>
</legend>
		<div>
		  <select name="add_to_set[]" class="multi" multiple="multiple" style="width: 200px; height:200px">
			<option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
			<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GROUPS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['group']->value['type']==0){?>
			<optgroup label="<?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
">
			  <?php  $_smarty_tpl->tpl_vars['value_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value_name']->_loop = false;
 $_smarty_tpl->tpl_vars['value_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['group']->value['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value_name']->key => $_smarty_tpl->tpl_vars['value_name']->value){
$_smarty_tpl->tpl_vars['value_name']->_loop = true;
 $_smarty_tpl->tpl_vars['value_id']->value = $_smarty_tpl->tpl_vars['value_name']->key;
?>
			  <option value="g<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['value_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value_name']->value;?>
</option>
			  <?php } ?>
			</optgroup>
			<?php }else{ ?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</option>
			<?php }?>
			<?php } ?>
		  </select>
		</div>
	  </fieldset>
	<?php }?>
	  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['title_option_set_add'];?>
</legend>
		<div><label for="new-set-name"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['name'];?>
</label><span><input type="text" name="set_create[set_name]" id="new-set-name" class="textbox" /></span></div>
		<div><label for="new-set-desc"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['description'];?>
</label><span><input type="text" name="set_create[set_description]" id="new-set-desc" class="textbox" /></span></div>
	  </fieldset>
	</div>

	<?php echo $_smarty_tpl->getSubTemplate ('templates/element.hook_form_content.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	<div class="form_control">
	  <input type="hidden" name="previous-tab" id="previous-tab" value="" />
	  <input type="submit" class="button" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" />
	</div>
	<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
  </form>
</div><?php }} ?>