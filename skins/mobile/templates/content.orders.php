{if $IS_USER}
<div>
  <h2>{$LANG.account.your_orders}</h2>
 {if $ORDERS}
  <p>{$LANG.account.your_orders_explained}</p>
  <div class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</div>


	{foreach from=$ORDERS item=order}
<div class="category_product">
<strong>{$LANG.basket.order_number}:</strong> <a href="{$STORE_URL}/index.php?_a=vieworder&amp;cart_order_id={$order.cart_order_id}" title="{$LANG.common.view_details}">{$order.cart_order_id}</a><br />
<strong>{$LANG.basket.order_date}:</strong> {$order.time}<br />
<strong>{$LANG.basket.total}:</strong> {$order.total}<br />
<strong>{$LANG.common.status}:</strong> {$order.status.text}<br />

<div style="margin-top:5px;">
{if $order.make_payment}<a href="{$STORE_URL}/index.php?_a=gateway&amp;cart_order_id={$order.cart_order_id}&amp;retrieve=1" class="button_submit">{$LANG.basket.complete_payment}</a> {/if}
{if $order.cancel}<a href="{$STORE_URL}/index.php?_a=vieworder&amp;cancel={$order.cart_order_id}" class="button_submit" title="">{$LANG.basket.cancel_order}</a>{/if}
</div>
</div>
	{/foreach}

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
	  <div><label for="lookup_order_id">{$LANG.basket.order_number}</label><span><input type="text" id="lookup_order_id" name="cart_order_id" value="" /></span></div>
	  <div><label for="lookup_email">{$LANG.common.email}</label><span><input type="text" id="lookup_email" name="email" value="" /></span></div>
	</fieldset>
	<div><input type="submit" value="{$LANG.common.search}" class="button_submit" /></div>
	  </form>
</div>
{/if}