{if isset($DOCUMENT)}
<div id="announcement">
  <h1>{$DOCUMENT.title}</h1>
  {$DOCUMENT.content}
</div>
{/if}

{if isset($LATEST_PRODUCTS)}
<div>
  <h2>{$LANG.catalogue.latest_products}</h2>
  {foreach from=$LATEST_PRODUCTS item=product}
  <div class="latest_product">
	<form action="{$VAL_SELF}" method="post" class="addForm">
	  <p class="image">
		<a href="{$product.url}" title="{$product.name}">
		  <img src="{$product.image}" alt="{$product.name}" />
		</a>
	  </p>
	  <p class="title"><a href="{$product.url}" title="{$product.name}">{$product.name|truncate:38:"&hellip;"}</a></p>
	  {if $product.ctrl_sale}
	  <p class="price"><span class="price_previous">{$product.price}</span> <span class="price_sale">{$product.sale_price}</span></p>
	  {else}
	  <p class="price">{$product.price}</p>
	  {/if}
	  <p class="actions">
		<a href="{$product.url}" title="{$product.name}" class="button_black">{$LANG.common.info}</a>
		<input type="hidden" name="add" value="{$product.product_id}" />
		{if $product.ctrl_stock && !$CATALOGUE_MODE}
		<input type="submit" value="{$LANG.catalogue.add_to_basket}" class="button_white" />
		{elseif !$CATALOGUE_MODE}
		<input type="submit" value="{$LANG.catalogue.out_of_stock_short}" class="button_white disabled" disabled="disabled" />
		{/if}
	  </p>
	  	</form>
  </div>
  {/foreach}
</div>
{/if}