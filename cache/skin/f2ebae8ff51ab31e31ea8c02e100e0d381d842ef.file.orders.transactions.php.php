<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:24:52
         compiled from "/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/orders.transactions.php" */ ?>
<?php /*%%SmartyHeaderCode:110105693552d0ffd425d565-23916272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2ebae8ff51ab31e31ea8c02e100e0d381d842ef' => 
    array (
      0 => '/home/student/public_html/CubeCart-5.2.2/admin/skins/default/templates/orders.transactions.php',
      1 => 1306420435,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110105693552d0ffd425d565-23916272',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DISPLAY_ALL_TRANSACTIONS' => 0,
    'LANG' => 0,
    'VAL_SELF' => 0,
    'SESSION_TOKEN' => 0,
    'THEAD' => 0,
    'ALL_TRANSACTIONS' => 0,
    'transaction' => 0,
    'TOTAL_RESULTS' => 0,
    'PAGINATION' => 0,
    'DISPLAY_ORDER_TRANSACTIONS' => 0,
    'TRANSACTION_LOGS_TITLE' => 0,
    'ORDER_TRANSACTIONS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d0ffd4472ac8_96186776',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d0ffd4472ac8_96186776')) {function content_52d0ffd4472ac8_96186776($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['DISPLAY_ALL_TRANSACTIONS']->value)){?>
<div id="logs" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['orders']['title_transaction_logs'];?>
</h3>
  <form action="<?php echo $_smarty_tpl->tpl_vars['VAL_SELF']->value;?>
" method="post">
	<div>
	  <input type="text" name="search" class="textbox" /> <input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['search'];?>
" class="mini_button" />
	</div>
	<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
  </form>
  <table class="list">
	<thead>
	  <tr>
		<td width="120"><?php echo $_smarty_tpl->tpl_vars['THEAD']->value['cart_order_id'];?>
</td>
		<td width="70"><?php echo $_smarty_tpl->tpl_vars['THEAD']->value['amount'];?>
</td>
		<td width="120"><?php echo $_smarty_tpl->tpl_vars['THEAD']->value['gateway'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['THEAD']->value['date'];?>
</td>
	  </tr>
	</thead>
	<tbody>
	<?php if (isset($_smarty_tpl->tpl_vars['ALL_TRANSACTIONS']->value)){?>
	  <?php  $_smarty_tpl->tpl_vars['transaction'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['transaction']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ALL_TRANSACTIONS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->key => $_smarty_tpl->tpl_vars['transaction']->value){
$_smarty_tpl->tpl_vars['transaction']->_loop = true;
?>
	  <tr>
		<td><a href="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['orders']['title_transaction_view'];?>
"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['order_id'];?>
</a></td>
		<td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['amount'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['gateway'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['time'];?>
</td>
	  </tr>
	  <?php } ?>
	<?php }else{ ?>
	  <tr>
		<td colspan="4" align="center"><strong><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['none'];?>
</strong></td>
	  </tr>
	<?php }?>
	</tbody>
  </table>
  <div class="pagination">
	<span><?php echo $_smarty_tpl->tpl_vars['TOTAL_RESULTS']->value;?>
</span>
	<?php echo $_smarty_tpl->tpl_vars['PAGINATION']->value;?>

  </div>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['DISPLAY_ORDER_TRANSACTIONS']->value){?>
<div id="log" class="tab_content">
<h3><?php echo $_smarty_tpl->tpl_vars['TRANSACTION_LOGS_TITLE']->value;?>
</h3>
  <table class="list">
	<thead>
	  <tr>
		<td nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['orders']['transaction_id'];?>
</td>
		<td nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['status'];?>
</td>
		<td nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['amount'];?>
</td>
		<td nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['orders']['gateway_name'];?>
</td>
		<td nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['date_time'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['notes'];?>
</td>
	  </tr>
	</thead>
	<tbody>
	  <?php if ($_smarty_tpl->tpl_vars['ORDER_TRANSACTIONS']->value){?><?php  $_smarty_tpl->tpl_vars['transaction'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['transaction']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ORDER_TRANSACTIONS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->key => $_smarty_tpl->tpl_vars['transaction']->value){
$_smarty_tpl->tpl_vars['transaction']->_loop = true;
?>
	  <tr>
		<td><!--<a href="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['order_id'];?>
</a><br />--><?php echo $_smarty_tpl->tpl_vars['transaction']->value['trans_id'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['status'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['amount'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['gateway'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['time'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['notes'];?>
</td>
	  </tr>
	  <?php } ?>
	  <?php }?>
	</tbody>
  </table>
</div>
<?php }?><?php }} ?>