<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:24:21
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/upgrade.index.php" */ ?>
<?php /*%%SmartyHeaderCode:200749697252d0ffb5c1a940-82986841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7024dbcee09916e2672eef2c48b9a3610b205967' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/upgrade.index.php',
      1 => 1334155305,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200749697252d0ffb5c1a940-82986841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TRIAL_LIMITS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ffb5cb3cd1_68248052',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ffb5cb3cd1_68248052')) {function content_52d0ffb5cb3cd1_68248052($_smarty_tpl) {?><div id="upgrade" class="tab_content">
  <h3>Upgrade Required</h3>
  <p>Right now your store uses &quot;CubeCart Lite&quot; the free version of CubeCart which has restricted features and a limit of <?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['customers'];?>
 customers or <?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['orders'];?>
 orders (whichever comes first) and <?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['administrator'];?>
 administrator. Below is our website showing our pricing and links to further information.</p>
  <p>Please note that the software license key can be added in the &quot;Advanced&quot; tab of your stores <a href="?_g=settings#Advanced_Settings">General Settings</a>.</p>
  <iframe src="<?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['url'];?>
" width="100%" height="500" style="border: 3px solid grey;"></iframe>
  <p align="right"><a href="<?php echo $_smarty_tpl->tpl_vars['TRIAL_LIMITS']->value['url'];?>
" target="_blank">Launch in new window</a></p>
</div><?php }} ?>