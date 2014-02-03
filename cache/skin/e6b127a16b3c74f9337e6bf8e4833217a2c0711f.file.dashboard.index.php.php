<?php /* Smarty version Smarty-3.1.13, created on 2014-01-11 08:44:07
         compiled from "/home/student/public_html/CubeCart/admin/skins/default/templates/dashboard.index.php" */ ?>
<?php /*%%SmartyHeaderCode:63899214252d1045709a577-93747402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6b127a16b3c74f9337e6bf8e4833217a2c0711f' => 
    array (
      0 => '/home/student/public_html/CubeCart/admin/skins/default/templates/dashboard.index.php',
      1 => 1354268642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63899214252d1045709a577-93747402',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANG' => 0,
    'QUICK_STATS' => 0,
    'CUSTOM_QUICK_TASKS' => 0,
    'task' => 0,
    'QUICK_TASKS' => 0,
    'LAST_ORDERS' => 0,
    'order' => 0,
    'NEWS' => 0,
    'item' => 0,
    'DASH_NOTES' => 0,
    'SESSION_TOKEN' => 0,
    'ORDERS' => 0,
    'SKIN_VARS' => 0,
    'ORDER_PAGINATION' => 0,
    'REVIEWS' => 0,
    'review' => 0,
    'REVIEW_PAGINATION' => 0,
    'STOCK' => 0,
    'warn' => 0,
    'STOCK_PAGINATION' => 0,
    'COUNT' => 0,
    'SYS' => 0,
    'PHP' => 0,
    'CHART_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d104577dea18_60569555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d104577dea18_60569555')) {function content_52d104577dea18_60569555($_smarty_tpl) {?><div id="dashboard" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_dashboard'];?>
</h3>
  <div class="dashboard_content">
    <?php if (isset($_smarty_tpl->tpl_vars['QUICK_STATS']->value)){?>
	<div id="flash-chart" class="chart" style="text-align:center;">
	  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="99%" height="300" id="graph-2" align="middle" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="quality" value="high" />
		<param name="wmode" value="opaque" />
		<param name="movie" value="includes/lib/OFC/open-flash-chart.swf" />
		<embed src="includes/lib/OFC/open-flash-chart.swf" quality="high" wmode="transparent" bgcolor="#FFF" width="99%" height="300" name="open-flash-chart" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	  </object>
	</div>
	<?php }?>
	<table width="100%">
	  <tr>
	    <td valign="top" nowrap="nowrap" width="25%">
		  <h4><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_tasks'];?>
</h4>
		  <ul>
			<?php  $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value] = new Smarty_Variable; $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CUSTOM_QUICK_TASKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value]->key => $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value]->value){
$_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value]->_loop = true;
?>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['task']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['task']->value['name'];?>
</a></li>
			<?php }
if (!$_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['task']->value]->_loop) {
?>
				<li><a href="?_g=reports&amp;report[date][from]=<?php echo $_smarty_tpl->tpl_vars['QUICK_TASKS']->value['today'];?>
&amp;report[date][to]=<?php echo $_smarty_tpl->tpl_vars['QUICK_TASKS']->value['today'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['task_orders_view_day'];?>
</a></li>
				<li><a href="?_g=reports&amp;report[date][from]=<?php echo $_smarty_tpl->tpl_vars['QUICK_TASKS']->value['this_weeks'];?>
&amp;report[date][to]=<?php echo $_smarty_tpl->tpl_vars['QUICK_TASKS']->value['today'];?>
"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['task_orders_view_week'];?>
</a></li>
				<li><a href="?_g=reports"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['task_orders_view_month'];?>
</a></li>
				<li><a href="?_g=products&action=add"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['product_add'];?>
</a></li>
				<li><a href="?_g=categories&action=add"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['catalogue']['category_add'];?>
</a></li>
			<?php } ?>
		  </ul>
	    </td>
	    <td valign="top" nowrap="nowrap" width="25%">
	    <h4><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_last_orders'];?>
</h4>
		  <?php if (isset($_smarty_tpl->tpl_vars['LAST_ORDERS']->value)){?>
		  <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LAST_ORDERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
		  <div><a href="?_g=orders&action=edit&order_id=<?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
</a> - <?php if (empty($_smarty_tpl->tpl_vars['order']->value['first_name'])&&empty($_smarty_tpl->tpl_vars['order']->value['last_name'])){?>
		  		<?php echo $_smarty_tpl->tpl_vars['order']->value['name'];?>

		  	<?php }else{ ?>
		  		<?php echo $_smarty_tpl->tpl_vars['order']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['order']->value['last_name'];?>

		  	<?php }?></div>
		  <?php } ?>
		  <?php }else{ ?>
		  <div><?php echo $_smarty_tpl->tpl_vars['LANG']->value['form']['none'];?>
</div>
		  <?php }?>
		</td>
	    <?php if (isset($_smarty_tpl->tpl_vars['QUICK_STATS']->value)){?>
	    <td valign="top" nowrap="nowrap" width="25%">
		  <table width="100%">
			<tr>
			  <th align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_sales_total'];?>
</th>
			  <th align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_sales_average'];?>
</th>
			</tr>
			<tr>
			  <td align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['QUICK_STATS']->value['total_sales'];?>
</td>
			  <td align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['QUICK_STATS']->value['ave_order'];?>
</td>
			</tr>
			<tr>
			  <th align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_month_this'];?>
</th>
			  <th align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_month_last'];?>
</th>
			</tr>
			<tr>
			  <td align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['QUICK_STATS']->value['this_month'];?>
</td>
			  <td align="center" width="50%"><?php echo $_smarty_tpl->tpl_vars['QUICK_STATS']->value['last_month'];?>
</td>
			</tr>
		  </table>
		</td>
		<?php }?>
		<td valign="top" nowrap="nowrap" width="25%">
		  <?php if (isset($_smarty_tpl->tpl_vars['NEWS']->value)){?>
		  <h4><strong title="<?php echo $_smarty_tpl->tpl_vars['NEWS']->value['description'];?>
"><?php echo $_smarty_tpl->tpl_vars['NEWS']->value['title'];?>
</strong></h4>
		  <ul>
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['NEWS']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></li>
		 	<?php } ?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['NEWS']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['more'];?>
</a></li>
		  </ul>
		  <?php }?>
	    </td>
	  </tr>
	</table>
	<div>
	  <form class="note" action="?" method="post">
		<span class="actions"><input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['save'];?>
" name="notes" class="mini_button" /></span>
		<p><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_my_notes'];?>
</p>
		<textarea name="notes[dashboard_notes]"><?php echo $_smarty_tpl->tpl_vars['DASH_NOTES']->value;?>
</textarea>
		<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
	  </form>
	</div>
  </div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['ORDERS']->value)){?>
<div id="orders" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_orders_unsettled'];?>
</h3>
  <div>
	<table class="list">
	  <thead>
		<tr>
		  <td width="120"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['orders']['order_number'];?>
</td>
		  <td width="16">&nbsp;</td>
		  <td><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['name'];?>
</td>
		  <td width="190" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['status'];?>
</td>
		  <td width="190"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['date'];?>
</td>
		  <td width="75"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['basket']['total'];?>
</td>
		  <td width="60">&nbsp;</td>
		</tr>
	  </thead>
	  <tbody>
		<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ORDERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
		<tr>
		  <td><a href="?_g=orders&amp;action=edit&amp;order_id=<?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
</a></td>
		  <td><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/<?php echo $_smarty_tpl->tpl_vars['order']->value['icon'];?>
.png" alt="" /></td>
		  <td>
		    <a href="?_g=customers&amp;action=edit&amp;customer_id=<?php echo $_smarty_tpl->tpl_vars['order']->value['customer_id'];?>
"><?php if (empty($_smarty_tpl->tpl_vars['order']->value['first_name'])&&empty($_smarty_tpl->tpl_vars['order']->value['last_name'])){?>
		  		<?php echo $_smarty_tpl->tpl_vars['order']->value['name'];?>

		  	<?php }else{ ?>
		  		<?php echo $_smarty_tpl->tpl_vars['order']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['order']->value['last_name'];?>

		  	<?php }?></a>
		  </td>
		  <td><?php echo $_smarty_tpl->tpl_vars['order']->value['status'];?>
</td>
		  <td><?php echo $_smarty_tpl->tpl_vars['order']->value['date'];?>
</td>
		  <td><?php echo $_smarty_tpl->tpl_vars['order']->value['total'];?>
</td>
		  <td>
		  	<a href="?_g=orders&amp;action=edit&amp;order_id=<?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/edit.png" /></a>
		  	<a href="?_g=orders&amp;delete=<?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		  	<?php if (isset($_smarty_tpl->tpl_vars['order']->value['notes'])){?>
		  	<a href="?_g=orders&action=edit&order_id=<?php echo $_smarty_tpl->tpl_vars['order']->value['cart_order_id'];?>
#order_notes" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['notes_read'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/note.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['notes'];?>
" /></a>
		  	<?php }?>
		  </td>
		</tr>
		<?php } ?>
	  </tbody>
	</table>
	<div><?php echo $_smarty_tpl->tpl_vars['ORDER_PAGINATION']->value;?>
</div>
  </div>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['REVIEWS']->value)){?>
<div id="product_reviews" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_reviews_pending'];?>
</h3>
	<form action="?_g=products&node=reviews&origin=dashboard" method="post" enctype="multipart/form-data">
	  <?php  $_smarty_tpl->tpl_vars['review'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['review']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['REVIEWS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['review']->key => $_smarty_tpl->tpl_vars['review']->value){
$_smarty_tpl->tpl_vars['review']->_loop = true;
?>
	  <div class="note">
		<span class="actions">
		  <input type="hidden" class="toggle" name="approve[<?php echo $_smarty_tpl->tpl_vars['review']->value['id'];?>
]" id="approve_<?php echo $_smarty_tpl->tpl_vars['review']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['review']->value['approved'];?>
" />
		  <a href="<?php echo $_smarty_tpl->tpl_vars['review']->value['edit'];?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/edit.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
" /></a>
		  <a href="<?php echo $_smarty_tpl->tpl_vars['review']->value['delete'];?>
" class="delete" title="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['notification']['confirm_delete'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/delete.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['delete'];?>
" /></a>
		</span>
		<div><strong><?php echo $_smarty_tpl->tpl_vars['review']->value['title'];?>
</strong></div>
		<p><?php echo $_smarty_tpl->tpl_vars['review']->value['review'];?>
</p>
		<div class="details">
		  <span style="float: right;">
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
			  <input type="radio" class="rating" name="rating_<?php echo $_smarty_tpl->tpl_vars['review']->value['id'];?>
" value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['index'];?>
" disabled="disabled" <?php if ($_smarty_tpl->tpl_vars['review']->value['rating']==$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']){?>checked="checked"<?php }?> />
			<?php endfor; endif; ?>
		  </span>
		  <a href="?_g=products&amp;product_id=<?php echo $_smarty_tpl->tpl_vars['review']->value['product_id'];?>
&amp;action=edit"><?php echo $_smarty_tpl->tpl_vars['review']->value['product']['name'];?>
</a> &raquo; <?php echo $_smarty_tpl->tpl_vars['review']->value['date'];?>
 :: <?php echo $_smarty_tpl->tpl_vars['review']->value['name'];?>

		</div>
	  </div>
	  <?php } ?>
	  <div>
		<input class="submit" type="submit" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['update'];?>
" />
	  </div>
	  <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['SESSION_TOKEN']->value;?>
" />
	</form>
  <div><?php echo $_smarty_tpl->tpl_vars['REVIEW_PAGINATION']->value;?>
</div>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['STOCK']->value)){?>
<div id="stock_warnings" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_stock_warnings'];?>
</h3>
  <div class="list">
  <?php  $_smarty_tpl->tpl_vars['warn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['warn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['STOCK']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['warn']->key => $_smarty_tpl->tpl_vars['warn']->value){
$_smarty_tpl->tpl_vars['warn']->_loop = true;
?>
	<div>
	  <span class="actions"><a href="?_g=products&amp;action=edit&amp;product_id=<?php echo $_smarty_tpl->tpl_vars['warn']->value['product_id'];?>
<?php if ($_smarty_tpl->tpl_vars['warn']->value['M_use_stock']==1){?>#Options<?php }?>" class="edit"><img src="<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['admin_folder'];?>
/skins/<?php echo $_smarty_tpl->tpl_vars['SKIN_VARS']->value['skin_folder'];?>
/images/edit.png" alt="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['common']['edit'];?>
" /></a></span>
	  <a href="?_g=products&amp;action=edit&amp;product_id=<?php echo $_smarty_tpl->tpl_vars['warn']->value['product_id'];?>
<?php if ($_smarty_tpl->tpl_vars['warn']->value['M_use_stock']==1){?>#Options<?php }?>"><?php echo $_smarty_tpl->tpl_vars['warn']->value['name'];?>
</a> (<?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['stock_level'];?>
: <?php if ($_smarty_tpl->tpl_vars['warn']->value['M_use_stock']==1){?><?php echo $_smarty_tpl->tpl_vars['warn']->value['M_stock_level'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['warn']->value['I_stock_level'];?>
<?php }?>)
	  <?php if ($_smarty_tpl->tpl_vars['warn']->value['cached_name']){?>
	  - <?php echo $_smarty_tpl->tpl_vars['warn']->value['cached_name'];?>

	  <?php }?>
	</div>
  <?php } ?>
  </div>
  <div><?php echo $_smarty_tpl->tpl_vars['STOCK_PAGINATION']->value;?>
</div>
</div>
<?php }?>

<div id="advanced" class="tab_content">
  <h3><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_store_overview'];?>
</h3>
  <div>
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_inventory_data'];?>
</legend>
	  <dl>
		<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['inv_customers'];?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['COUNT']->value['customers'];?>
</dd>
		<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['inv_products'];?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['COUNT']->value['products'];?>
</dd>
		<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['inv_orders'];?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['COUNT']->value['orders'];?>
</dd>
	  </dl>
	</fieldset>
	<fieldset><legend><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['title_technical_data'];?>
</legend>
	  <dl>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_version_cc'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['cc_version'];?>
 <?php echo $_smarty_tpl->tpl_vars['SYS']->value['cc_build'];?>
</dd>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_version_php'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['php_version'];?>
</dd>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_version_mysql'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['mysql_version'];?>
</dd>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_size_image'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['dir_images'];?>
</dd>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_size_download'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['dir_files'];?>
</dd>
	  	<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_upload_max'];?>
</dt>
	  	<dd><?php echo $_smarty_tpl->tpl_vars['PHP']->value['upload_max_filesize']['local_value'];?>
</dd>
		<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_browser'];?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['client'];?>
</dd>
		<dt><?php echo $_smarty_tpl->tpl_vars['LANG']->value['dashboard']['tech_server'];?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['SYS']->value['server'];?>
</dd>
	  </dl>
	</fieldset>
  </div>
</div>
<script type="text/javascript">
var chart_data = '<?php echo $_smarty_tpl->tpl_vars['CHART_DATA']->value;?>
';
function open_flash_chart_data() {
	return chart_data;
}
</script><?php }} ?>