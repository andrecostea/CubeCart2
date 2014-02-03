<?php /* Smarty version Smarty-3.1.13, created on 2013-12-09 12:23:39
         compiled from "/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.documents.php" */ ?>
<?php /*%%SmartyHeaderCode:70431920952a5b64b397f38-40902431%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39f5318c66b9e9c34731a44e672daa2be2c5d095' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/skins/kurouto/templates/box.documents.php',
      1 => 1301521712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70431920952a5b64b397f38-40902431',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DOCUMENTS' => 0,
    'document' => 0,
    'CONTACT_URL' => 0,
    'LANG' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a5b64b3d6439_65145820',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a5b64b3d6439_65145820')) {function content_52a5b64b3d6439_65145820($_smarty_tpl) {?><ul class="documents">
  <?php if (isset($_smarty_tpl->tpl_vars['DOCUMENTS']->value)&&count($_smarty_tpl->tpl_vars['DOCUMENTS']->value)>0){?>
  	<?php  $_smarty_tpl->tpl_vars['document'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['document']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DOCUMENTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['document']->key => $_smarty_tpl->tpl_vars['document']->value){
$_smarty_tpl->tpl_vars['document']->_loop = true;
?>
  <li><a href="<?php echo $_smarty_tpl->tpl_vars['document']->value['doc_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['document']->value['doc_name'];?>
" <?php if ($_smarty_tpl->tpl_vars['document']->value['doc_url_openin']){?>target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['document']->value['doc_name'];?>
</a></li>
	<?php } ?>
  <?php }?>
  <?php if (isset($_smarty_tpl->tpl_vars['CONTACT_URL']->value)){?>
  <li><a href="<?php echo $_smarty_tpl->tpl_vars['CONTACT_URL']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['documents']['document_contact'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['documents']['document_contact'];?>
</a></li>
  <?php }?>
</ul><?php }} ?>