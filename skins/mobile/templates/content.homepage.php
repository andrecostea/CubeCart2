{if isset($LATEST_PRODUCTS)}
<div>
  <h2 class="btitle">{$LANG.catalogue.latest_products}</h2>
  {foreach from=$LATEST_PRODUCTS item=product}
	<form action="{$VAL_SELF}" method="post" class="addForm">
		  <div class="category_product cf">
          <a href="{$product.url}" title="{$product.name}" class="image">
		  <img src="{$product.image}" alt="{$product.name}" />
		</a>
      <div class="details">
	  <h3><a href="{$product.url}" title="{$product.name}">{$product.name|truncate:38:"&hellip;"}</a></h3>
	  {if $product.ctrl_sale}
	  <p class="price"><span class="price_previous">{$product.price}</span> <span class="price_sale">{$product.sale_price}</span></p>
	  {else}
	  <p class="price">{$product.price}</p>
	  {/if}
	  <p class="buy_button">
		<input type="hidden" name="add" value="{$product.product_id}" />
		{if $product.ctrl_stock && !$CATALOGUE_MODE}
		<input type="submit" value="{$LANG.catalogue.add_to_basket}" class="button_white" />
		{elseif !$CATALOGUE_MODE}
		<input type="submit" value="{$LANG.catalogue.out_of_stock_short}" class="button_white disabled" disabled="disabled" />
		{/if}
	  </p>
      </div>
        </div>
	  	</form>
  {/foreach}
</div>
{/if}