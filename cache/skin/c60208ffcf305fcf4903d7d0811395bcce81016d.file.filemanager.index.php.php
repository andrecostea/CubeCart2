<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:24:44
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/filemanager.index.php" */ ?>
<?php /*%%SmartyHeaderCode:7435295952d0ffcc222078-58609481%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c60208ffcf305fcf4903d7d0811395bcce81016d' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/filemanager.index.php',
      1 => 1350378978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7435295952d0ffcc222078-58609481',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'VAL_SELF' => 0,
    'mode_list' => 0,
    'FILMANAGER_TITLE' => 0,
    'FOLDERS' => 0,
    'folder' => 0,
    'LANG' => 0,
    'SKIN_VARS' => 0,
    'FILES' => 0,
    'file' => 0,
    'CK_FUNC_NUM' => 0,
    'mode_form' => 0,
    'FILE' => 0,
    'DIRS' => 0,
    'dir' => 0,
    'SHOW_CROP' => 0,
    'SESSION_TOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ffcc5badb6_37136206',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ffcc5badb6_37136206')) {function content_52d0ffcc5badb6_37136206($_smarty_tpl) {?><form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" enctype="multipart/form-data">
  <?php if (isset($_smarty_tpl->tpl_vars['mode_list']->value)){?>
  <div id="filemanager" class="tab_content">
	<h3><?php echo $_smarty_tpl->tpl_vars['FILMANAGER_TITLE']->value;?>
</h3>
	<div class="list" style="height: 430px; overflow: auto; padding-right: 5px;">
	  <?php if (isset($_smarty_tpl->tpl_vars['FOLDERS']->value)){?>
	  <?php  $_smarty_tpl->tpl_vars['folder'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['folder']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['FOLDERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['folder']->key => $_smarty_tpl->tpl_vars['folder']->value){
$_smarty_tpl->tpl_vars['folder']->_loop = true;
?>
	  <div>
		<span class="actions">
		<?php if (!is_null($_smarty_tpl->tpl_vars['folder']->value['delete'])){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['folder']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		<?php }?>
		</span>
		<img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/folder.png" alt="<?php echo $_smarty_tpl->tpl_vars['folder']->value['name'];?>
" />
		<a href="<?php echo $_smarty_tpl->tpl_vars['folder']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['folder']->value['name'];?>
</a>
	  </div>
	  <?php } ?>
	  <?php }?>

	  <?php if (isset($_smarty_tpl->tpl_vars['FILES']->value)){?>
	  <?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['FILES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value){
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
	  <div>
		<span class="actions">
		  <?php if ($_smarty_tpl->tpl_vars['file']->value['select_button']){?>
		  <a href="<?php echo $_smarty_tpl->tpl_vars['file']->value['master_filepath'];?>
" class="select"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/add.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['add'];?>
" /></a>
		  <?php }else{ ?>
		  <a href="<?php echo $_smarty_tpl->tpl_vars['file']->value['edit'];?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/edit.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
" /></a>
		  <a href="<?php echo $_smarty_tpl->tpl_vars['file']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		  <?php }?>
		</span>
		<img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/<?php echo $_smarty_tpl->tpl_vars['file']->value['icon'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['file']->value['mimetype'];?>
" />
		<a href="<?php echo $_smarty_tpl->tpl_vars['file']->value['filepath'];?>
?<?php echo $_smarty_tpl->tpl_vars['file']->value['random'];?>
" <?php echo $_smarty_tpl->tpl_vars['file']->value['class'];?>
 title="<?php echo $_smarty_tpl->tpl_vars['file']->value['description'];?>
" target="_self"><?php echo $_smarty_tpl->tpl_vars['file']->value['filename'];?>
</a>
	  </div>
	  <?php } ?>
	  <?php }else{ ?>
	  <div class="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['file_none'];?>
</div>
	  <?php }?>
	</div>
  </div>
  <div id="upload" class="tab_content">
	<h3><?php echo $_smarty_tpl->tpl_vars['FILMANAGER_TITLE']->value;?>
</h3>
	<div>
	  <label for="uploader"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['file_upload'];?>
</label><span><input name="file" id="uploader" type="file" class="multiple" /></span>
	</div>
  </div>
  <div id="folder" class="tab_content">
	<h3><?php echo $_smarty_tpl->tpl_vars['FILMANAGER_TITLE']->value;?>
</h3>
	<div><label for="create-dir"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['folder_create'];?>
</label><span><input name="fm[create-dir]" id="create-dir" type="text" class="textbox" /></span></div>
  </div>
  
  <?php echo $_smarty_tpl->getSubTemplate ('templates/element.hook_form_content.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  
  <div class="form_control">
	<input type="hidden" name="previous-tab" id="previous-tab" value="" />
	<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" />
	<input type="hidden" id="ckfuncnum" value="<?php echo $_smarty_tpl->tpl_vars['CK_FUNC_NUM']->value;?>
" />
  </div>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['mode_form']->value)){?>
  <div id="fm-details" class="tab_content">
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['title_file_edit'];?>
</h3>
	<div><label for="filename"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['file_name'];?>
</label><span><input type="text" id="filename" name="details[filename]" class="textbox" value="<?php echo $_smarty_tpl->tpl_vars['FILE']->value['filename'];?>
" /></span></div>
	<div><label for="move"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['file_subfolder'];?>
</label><span><select name="details[move]" id="move" class="textbox">
	  <option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
	  <?php if (isset($_smarty_tpl->tpl_vars['DIRS']->value)){?><?php  $_smarty_tpl->tpl_vars['dir'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dir']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DIRS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dir']->key => $_smarty_tpl->tpl_vars['dir']->value){
$_smarty_tpl->tpl_vars['dir']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['dir']->value['path'];?>
"<?php echo $_smarty_tpl->tpl_vars['dir']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['dir']->value['path'];?>
</option><?php } ?><?php }?>
	</select>
	</span></div>
	<div><label for="description"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['description'];?>
</label><span><textarea name="details[description]" id="description" class="textbox"><?php echo $_smarty_tpl->tpl_vars['FILE']->value['description'];?>
</textarea></span></div>
  </div>
  <?php if (isset($_smarty_tpl->tpl_vars['SHOW_CROP']->value)){?>
  <div id="fm-cropper" class="tab_content">
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['title_image_crop'];?>
</h3>
	<img id="resize" src="<?php echo $_smarty_tpl->tpl_vars['FILE']->value['filepath'];?>
<?php echo $_smarty_tpl->tpl_vars['FILE']->value['filename'];?>
?<?php echo $_smarty_tpl->tpl_vars['FILE']->value['random'];?>
" alt="" class="cropper" />
  </div>
  <?php }?>
  
  <?php echo $_smarty_tpl->getSubTemplate ('templates/element.hook_form_content.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  
  <div class="form_control">
	<input type="hidden" name="file_id" value="<?php echo $_smarty_tpl->tpl_vars['FILE']->value['file_id'];?>
" />
	<input type="hidden" name="previous-tab" id="previous-tab" value="" />
	<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" />
	<input type="submit" name="cancel" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['cancel'];?>
" />
  </div>
  <?php }?>
  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
</form>
<?php }} ?>