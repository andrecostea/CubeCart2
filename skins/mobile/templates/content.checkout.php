<div id="checkout">
  {if isset($ITEMS)}
  <form action="{$VAL_SELF}" method="post" enctype="multipart/form-data" id="basket">
    {if $INCLUDE_CHECKOUT}
    {include file='templates/content.checkout.confirm.php'}
    {/if}
	<h2>{$LANG.checkout.your_basket}</h2>
	{foreach from=$ITEMS key=hash item=item}
	<div class="basket_product">
	  
      <span class="image">
		<a href="{$item.link}" title="{$item.name}">
		  <img src="{$item.image}" alt="{$item.name}" />
		</a>
       <span class="remove"> <a href="{$STORE_URL}/index.php?_a=basket&amp;remove-item={$hash}">
		<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/{$SKIN_SUBSET}/basket_remove.png" alt="{$LANG.common.remove}" title="{$LANG.common.remove}" />
		</a></span>
	  </span>
      
	  <div class="cart_item_details">
      <p><a href="{$item.link}" class="txtDefault"><strong>{$item.name|truncate:65:"&hellip;"}</strong></a></p>
	  {if $item.options}
	  {foreach from=$item.options item=option}<p><strong>{$option.option_name}</strong>: {$option.value_name|truncate:45:"&hellip;":true}{if !empty($option.price_display)} ({$option.price_display}){/if}</p>{/foreach}
	  {/if}
      {if !empty($item.product_code)}<p><strong>Product Code:</strong> {$item.product_code}</p>{/if}
		<p><strong>{$LANG.common.price_unit}:</strong> {$item.line_price_display}</p>
        <p><strong>{$LANG.common.price}:</strong> {$item.price_display}</p>	
		<p><strong>Qty:</strong> <input name="quan[{$hash}]" type="text" value="{$item.quantity}" class="quantity" {$QUAN_READ_ONLY} /></p>
	  </div>
	</div>
	{/foreach}

	<div class="subtotals">
	  <p><span class="price">{$SUBTOTAL}</span>{$LANG.basket.total_sub}</p>
	  {if isset($SHIPPING)}
	  <p>
		<span class="price">{$CUSTOMER_LOCALE.mark} {$SHIPPING_VALUE}</span>
		{$LANG.basket.shipping}</p>
		<p>
		<select name="shipping" class="update_form textbox required" style="width:auto;">
		  <option value="">{$LANG.form.please_select}</option>
		  {foreach from=$SHIPPING key=group item=methods}
		  {if $HIDE_OPTION_GROUPS ne '1'}<optgroup label="{$group}">{/if}
		  	{foreach from=$methods item=method}
			<option value="{$method.value}" {$method.selected}>{$CUSTOMER_LOCALE.mark} {$method.display}</option>
			{/foreach}
		  {if $HIDE_OPTION_GROUPS ne '1'}</optgroup>{/if}
		  {/foreach}
		</select>
	  </p>
	  {/if}

	  {foreach from=$TAXES item=tax}
	  <p><span class="price">{$CUSTOMER_LOCALE.mark} {$tax.value}</span>{$tax.name}</p>
	  {/foreach}	  
      
      {foreach from=$COUPONS item=coupon}
	  <div class="discounts">
      <p><span class="price">{$coupon.value}</span><a href="{$VAL_SELF}&amp;remove_code={$coupon.remove_code}" title="{$LANG.common.remove}">{$coupon.voucher}</a></p>
      </div>
	  {/foreach}
      
      {if isset($DISCOUNT)}
	  <p><span class="price">{$DISCOUNT}</span>{$LANG.basket.total_discount}</p>
	  {/if}
        
    </div>	      
    
    <div class="subtotals">
    <p><span class="price">{$TOTAL}</span> {$LANG.basket.total_grand}</p>
    {if $BASKET_WEIGHT}<p><span class="price">{$BASKET_WEIGHT}</span> {$LANG.basket.weight}</p>{/if}
    {if $CUSTOMER_LOCALE.description}<p>{$CUSTOMER_LOCALE.mark} {$LANG.basket.unconfirmed_locale}</p>{/if}
    </div>
   
     <div class="code_input">
     <label for="coupon" class="return">{$LANG.basket.coupon_add}</label>
     <input name="coupon" id="coupon" type="text" class="textbox" maxlength="25" />
     </div>

	<div class="basket_actions">
	  <a href="{$STORE_URL}/index.php?_a=basket&amp;empty-basket=true" class="button_submit">{$LANG.basket.basket_empty}</a>
	  <input type="submit" name="update" class="button_submit update" value="{$LANG.basket.basket_update}" />
	  {if $DISABLE_CHECKOUT_BUTTON!==true}
      <input type="submit" name="proceed" class="button_submit" value="{$CHECKOUT_BUTTON}" />
      {/if}
	</div>
</form>

  {if $CHECKOUTS}
  <p class="alternate_checkout">-- {$LANG.common.or} --</p>
  {foreach from=$CHECKOUTS item=checkout}
  <p class="alternate_checkout">{$checkout}</p>
  {/foreach}
  {/if}

  {if $RELATED}
  <div class="cf">
	<h2>{$LANG.catalogue.related_products}</h2>
	{foreach from=$RELATED item=product}
	<div class="latest_product">

		<a href="{$product.url}" title="{$product.name}" class="image">
		  <img src="{$product.img_src}" alt="{$product.name}" />
		</a>

	  <a href="{$product.url}" title="{$product.name}">{$product.name|truncate:38:"&hellip;"}</a>
	</div>
	 {/foreach}
  </div>
	  {/if}
  {else}
  <p class="buttons">{$LANG.basket.basket_is_empty}</p>
  {/if}
</div>