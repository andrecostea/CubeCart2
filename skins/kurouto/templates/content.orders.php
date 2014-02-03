{if $IS_USER}
<div>
  <h2>{$LANG.account.your_orders}</h2>
 {if $ORDERS}
  <p>{$LANG.account.your_orders_explained}</p>
  <div class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</div>

  <table width="100%" class="list">
	<thead>
	  <tr>
		<th width="130">{$LANG.basket.order_number}</th>
		<th width="140">{$LANG.basket.order_date}</th>
		<th width="60">{$LANG.basket.total}</th>
		<th>{$LANG.common.status}</th>
		<th width="120">&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
	{foreach from=$ORDERS item=order}
	  <tr>
		<td nowrap="nowrap"><a href="{$STORE_URL}/index.php?_a=vieworder&amp;cart_order_id={$order.cart_order_id}" title="{$LANG.common.view_details}">{$order.cart_order_id}</a></td>
		<td nowrap="nowrap">{$order.time}</td>
		<td align="right">{$order.total}</td>
		<td align="center" nowrap="nowrap">{$order.status.text}</td>
		<td align="right">
		  {if $order.make_payment}<a href="{$STORE_URL}/index.php?_a=gateway&amp;cart_order_id={$order.cart_order_id}&amp;retrieve=1">{$LANG.basket.complete_payment}</a><br />{/if}
		  {if $order.cancel}<a href="{$STORE_URL}/index.php?_a=vieworder&amp;cancel={$order.cart_order_id}" class="delete" title="">{$LANG.basket.cancel_order}</a><br />{/if}
		  <a href="{$STORE_URL}/index.php?_a=vieworder&amp;cart_order_id={$order.cart_order_id}" title="{$LANG.common.view_details}">{$LANG.common.view_details}</a>
		</td>
	  </tr>
	{/foreach}
	</tbody>
  </table>
  <div class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</div>
  {else}
  <p>{$LANG.account.no_orders_made}</p>
  {/if}
</div>
{else}
<div>
  <h2>{$LANG.account.lookup_order}</h2>
  <p></p>
  <form action="{$VAL_SELF}" method="post">
	<fieldset>
	  <div><label for="lookup_order_id">{$LANG.basket.order_number}</label><span><input type="text" id="lookup_order_id" name="cart_order_id" value="{$ORDER_NUMBER}" /></span></div>
	  <div><label for="lookup_email">{$LANG.common.email}</label><span><input type="text" id="lookup_email" name="email" value="" /></span></div>
	</fieldset>
	<div><input type="submit" value="{$LANG.common.search}" class="button_submit" /></div>
	  </form>
</div>
{/if}