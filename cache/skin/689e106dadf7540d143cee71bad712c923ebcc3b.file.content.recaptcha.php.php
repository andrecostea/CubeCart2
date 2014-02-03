<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 15:40:59
         compiled from "/home/student/public_html/CubeCart/skins/kurouto/templates/content.recaptcha.php" */ ?>
<?php /*%%SmartyHeaderCode:100257317452d1660b910f53-79917029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '689e106dadf7540d143cee71bad712c923ebcc3b' => 
    array (
      0 => '/home/student/public_html/CubeCart/skins/kurouto/templates/content.recaptcha.php',
      1 => 1305213178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '100257317452d1660b910f53-79917029',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECAPTCHA' => 0,
    'LANG' => 0,
    'DISPLAY_RECAPTCHA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d1660b9350f1_92432702',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d1660b9350f1_92432702')) {function content_52d1660b9350f1_92432702($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['RECAPTCHA']->value){?>
<fieldset id="recaptcha-title">
  <legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['verify_human'];?>
</legend>
  <script type="text/javascript">
   var RecaptchaOptions = {
      theme : 'clean'
   };
  </script>
  <?php echo $_smarty_tpl->tpl_vars['DISPLAY_RECAPTCHA']->value;?>

</fieldset>
<?php }?><?php }} ?>