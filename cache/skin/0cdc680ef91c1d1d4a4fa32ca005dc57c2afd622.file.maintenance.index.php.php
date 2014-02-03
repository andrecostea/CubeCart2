<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:40:44
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/maintenance.index.php" */ ?>
<?php /*%%SmartyHeaderCode:13674264852d1038c4418d5-61721403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cdc680ef91c1d1d4a4fa32ca005dc57c2afd622' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/maintenance.index.php',
      1 => 1337939701,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13674264852d1038c4418d5-61721403',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'SESSION_TOKEN' => 0,
    'VAL_SELF' => 0,
    'EXISTING_BACKUPS' => 0,
    'backup' => 0,
    'SKIN_VARS' => 0,
    'RESTORE_ERROR_LOG' => 0,
    'OUT_OF_DATE' => 0,
    'LATEST_VERSION' => 0,
    'UPGRADE_NOW' => 0,
    'FORCE' => 0,
    'UPGRADE_ERROR_LOG' => 0,
    'TABLES' => 0,
    'table' => 0,
    'TABLES_AFTER' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d1038c9b8c62_51514113',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d1038c9b8c62_51514113')) {function content_52d1038c9b8c62_51514113($_smarty_tpl) {?><div id="backup" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_files_backup'];?>
</h3>
  <form action="?_g=maintenance&amp;node=index&amp;files_backup=1#backup" method="post">
	<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['files_backup_desc'];?>
</p>
	<div>
		<input type="submit" name="backup" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_continue'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['tab_backup'];?>
" />
		<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
	</div>
  </form>
  <br />
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_db_backup'];?>
</h3>
  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['db_backup_desc'];?>
</p> 
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" enctype="multipart/form-data">
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['backup_options'];?>
</legend>
	  <div>
		<label for="db_drop"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['db_drop_table'];?>
</label>
		<span><input type="hidden" name="drop" id="drop" class="toggle" value="1" /></span>
	  </div>
	  <div>
		<label for="db_struct"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['db_structure'];?>
</label>
		<span><input type="hidden" name="structure" id="structure" class="toggle" value="1" /></span>
	  </div>
	  <div>
		<label for="db_data"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['db_data'];?>
</label>
		<span><input type="hidden" name="data" id="data" class="toggle" value="1" /></span>
	  </div>
	  <div>
		<label for="db_data"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['compress_file'];?>
</label>
		<span><input type="hidden" name="compress" id="compress" class="toggle" value="1" /></span>
	  </div>
	</fieldset>
	<div>
		<input type="hidden" name="previous-tab" id="previous-tab" value="backup" />
		<input type="submit" name="backup" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['tab_backup'];?>
" />
	</div>
	<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
  </form>
  <br />
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_existing_backups'];?>
</h3>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['downloads'];?>
</legend>
	<?php if ($_smarty_tpl->tpl_vars['EXISTING_BACKUPS']->value){?>
	<div class="list">
		<?php  $_smarty_tpl->tpl_vars['backup'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['backup']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['EXISTING_BACKUPS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['backup']->key => $_smarty_tpl->tpl_vars['backup']->value){
$_smarty_tpl->tpl_vars['backup']->_loop = true;
?>
		<div>
		  <label for="<?php echo $_smarty_tpl->tpl_vars['backup']->value['filename'];?>
" class="wide"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/<?php echo $_smarty_tpl->tpl_vars['backup']->value['type'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['download'];?>
" /></a> <a href="<?php echo $_smarty_tpl->tpl_vars['backup']->value['download_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['backup']->value['filename'];?>
</a> - <?php echo $_smarty_tpl->tpl_vars['backup']->value['size'];?>
</label>
		  <span class="actions">
		    <?php if ($_smarty_tpl->tpl_vars['backup']->value['restore_link']){?>
		    <a href="<?php echo $_smarty_tpl->tpl_vars['backup']->value['restore_link'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['backup']->value['warning'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/restore.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['restore'];?>
" /></a>
		    <?php }?>
		    <a href="<?php echo $_smarty_tpl->tpl_vars['backup']->value['download_link'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/download.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['download'];?>
" /></a>
		    <a href="<?php echo $_smarty_tpl->tpl_vars['backup']->value['delete_link'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		  </span>
		</div>
		<?php } ?>
	</div>
	<?php }else{ ?>
	<div class="center"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['filemanager']['file_none'];?>
</div>
	<?php }?>
	</fieldset>
	<?php if ($_smarty_tpl->tpl_vars['RESTORE_ERROR_LOG']->value){?>
	<h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_error_log'];?>
</h3>
  	<div><textarea rows="10" cols="70"><?php echo $_smarty_tpl->tpl_vars['RESTORE_ERROR_LOG']->value;?>
</textarea></div>
  	<a href="?_g=maintenance&node=index&delete=restore_error_log#backup" class="delete"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['delete_error_log'];?>
</a>
    <?php }?>
</div>

<div id="upgrade" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['upgrade_to_latest'];?>
</h3>
  <?php if ($_smarty_tpl->tpl_vars['OUT_OF_DATE']->value){?>
  <p><strong><?php echo $_smarty_tpl->tpl_vars['OUT_OF_DATE']->value;?>
</strong></p>
  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['upgrade_to_latest_desc'];?>
</p>
  <?php }else{ ?>
  <p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['latest_installed'];?>
</p>
  <?php }?>
  <form action="?_g=maintenance&amp;upgrade=<?php echo $_smarty_tpl->tpl_vars['LATEST_VERSION']->value;?>
#upgrade" method="post">
    <div>
		<input type="submit" name="backup" class="submit_confirm" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_continue'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['UPGRADE_NOW']->value;?>
" />
		<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
		<input type="hidden" name="force" value="<?php echo $_smarty_tpl->tpl_vars['FORCE']->value;?>
" />
	</div>
  </form>
  <?php if ($_smarty_tpl->tpl_vars['UPGRADE_ERROR_LOG']->value){?>
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_error_log'];?>
</h3>
  <div><textarea rows="10" cols="70"><?php echo $_smarty_tpl->tpl_vars['UPGRADE_ERROR_LOG']->value;?>
</textarea></div>
  <a href="?_g=maintenance&node=index&delete=upgrade_error_log#upgrade" class="delete"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['delete_error_log'];?>
</a>
  <?php }?>
</div>


<div id="rebuild" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_rebuild'];?>
</h3>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" enctype="multipart/form-data">
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_rebuild_catalogue'];?>
</legend>
	<div style="height: 20px;"><label for="prodViews"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['reset_views'];?>
</label><span><input type="checkbox" id="prodViews" name="prodViews" value="1" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_rebuild_cache'];?>
</legend>
	<div style="height: 20px;"><label for="clearCache"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['cache_clear'];?>
</label><span><input type="checkbox" id="clearCache" name="clearCache" value="1" /></span><!--<?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['cache_warning'];?>
--></div>
	<div style="height: 20px;"><label for="clearSQLCache"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['cache_sql'];?>
</label><span><input type="checkbox" id="clearSQLCache" name="clearSQLCache" value="1" /></span></div>
	<div style="height: 20px;"><label for="clearLangCache"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['cache_language'];?>
</label><span><input type="checkbox" id="clearLangCache" name="clearLangCache" value="1" /></span></div>
	<div style="height: 20px;"><label for="clearImageCache"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['cache_image'];?>
</label><span><input type="checkbox" id="clearImageCache" name="clearImageCache" value="1" /></span></div>
  </fieldset>

  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_rebuild_logs'];?>
</legend>
	<div style="height: 20px;"><label for="clearLogs"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['logs_admin'];?>
</label><span><input type="checkbox" id="clearLogs" name="clearLogs" value="1" /></span></div>
	<div style="height: 20px;"><label for="emptyErrorLogs"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['logs_error'];?>
</label><span><input type="checkbox" id="emptyErrorLogs" name="emptyErrorLogs" value="1" /></span></div>
	<div style="height: 20px;"><label for="emptyRequestLogs"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['logs_request'];?>
</label><span><input type="checkbox" id="emptyRequestLogs" name="emptyRequestLogs" value="1" /></span></div>
	<div style="height: 20px;"><label for="emptyTransLogs"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['logs_transaction'];?>
</label><span><input type="checkbox" id="emptyTransLogs" name="emptyTransLogs" value="1" /></span></div>
  </fieldset>
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_rebuild_misc'];?>
</legend>
	<div style="height: 20px;"><label for="sitemap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['sitemap'];?>
</label><span><input type="checkbox" id="sitemap" name="sitemap" value="1" /></span></div>
  </fieldset>
	<div>
		<input type="hidden" name="previous-tab" id="previous-tab" value="rebuild" />
		<input type="submit" name="rebuild" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['submit'];?>
" />
	</div>
	<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
  </form>
</div>
<div id="database" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_db'];?>
</h3>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post" enctype="multipart/form-data">
  <fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['title_db_tables'];?>
</legend>
	  <?php if ($_smarty_tpl->tpl_vars['TABLES']->value){?>
	  <table width="650">
	  	<thead>
	  	  <tr>
	  	    <td width="10">&nbsp;</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_name'];?>
</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_records'];?>
</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_engine'];?>
</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_collation'];?>
</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_size'];?>
</td>
	  	    <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_overhead'];?>
</td>
	  	  </tr>
	  	</thead>
	  	<tbody class="list">
	  	  <?php  $_smarty_tpl->tpl_vars['table'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['table']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TABLES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['table']->key => $_smarty_tpl->tpl_vars['table']->value){
$_smarty_tpl->tpl_vars['table']->_loop = true;
?>
	  	  <tr>
	  		<td><input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['table']->value['Name'];?>
" name="tablename[]" value="<?php echo $_smarty_tpl->tpl_vars['table']->value['Name'];?>
" class="table" /></td>
	  		<td><label for="<?php echo $_smarty_tpl->tpl_vars['table']->value['Name'];?>
"><?php echo $_smarty_tpl->tpl_vars['table']->value['Name_Display'];?>
</label></td>
	  		<td><?php echo $_smarty_tpl->tpl_vars['table']->value['Rows'];?>
</td>
	  		<td><?php echo $_smarty_tpl->tpl_vars['table']->value['Engine'];?>
</td>
	  		<td><?php echo $_smarty_tpl->tpl_vars['table']->value['Collation'];?>
</td>
	  		<td><?php echo $_smarty_tpl->tpl_vars['table']->value['Data_length'];?>
</td>
	  		<td><?php echo $_smarty_tpl->tpl_vars['table']->value['Data_free'];?>
</td>
	  	  </tr>
	  	  <?php } ?>
	  	</tbody>
	  	<tfoot>
	  	  <tr>
	  		<td><span><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/select_all.gif" alt="" /></td>
	  		<td><a href="#" class="check-all" rel="table"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['check_uncheck'];?>
</a></td>
	  	  </tr>
	  	  <tr>
	  		<td>&nbsp;</td>
	  		<td><strong><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['db_with_selected'];?>
</strong>
	  		  <select name="action" class="textbox">
	    	    <optgroup label="">
	      	      <option value=""><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['please_select'];?>
</option>
		  		  <option value="OPTIMIZE"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['optimize'];?>
</option>
	      		  <option value="REPAIR"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['repair'];?>
</option>
	      		  <option value="CHECK"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['check'];?>
</option>
	      		  <option value="ANALYZE"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['settings']['analyze'];?>
</option>
	    	    </optgroup>
			  </select>
			</td>
	  	  </tr>
	  	</tfoot>
	  </table>
	  <?php }elseif($_smarty_tpl->tpl_vars['TABLES_AFTER']->value){?>
	  <table width="650">
  		<thead>
  		  <tr>
  			<td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_name'];?>
</td>
  			<td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_operation'];?>
</td>
  			<td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_message_type'];?>
</td>
  			<td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['maintain']['table_message_text'];?>
</td>
  		  </tr>
  		</thead>
  		<tbody class="list">
	  	<?php  $_smarty_tpl->tpl_vars['table'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['table']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TABLES_AFTER']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['table']->key => $_smarty_tpl->tpl_vars['table']->value){
$_smarty_tpl->tpl_vars['table']->_loop = true;
?>
	  		<tr>
	  		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['table']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	  		  <td><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</td>
	  		<?php } ?>
	  		</tr>
	  	<?php } ?>
	  	</tbody>
	  </table>
	  <?php }?>
  </fieldset>
  <div>
  	<input type="hidden" name="previous-tab" id="previous-tab" value="database" />
  	<input type="submit" name="database" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['submit'];?>
" />
  </div>
  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
  </form>
</div><?php }} ?>