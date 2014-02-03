{if $PRODUCTS}
<div id="sale_products">
  <h3>{$LANG.catalogue.title_saleitems}</h3>
  <div class="wrapper">
	  <ul>
	  {foreach from=$PRODUCTS item=product}
		<li>
		  <a href="{$product.url}" title="{$product.name}">{$product.name}</a><br />
		  {if {$product.saving}}<span class="saving">{$LANG.catalogue.saving} {$product.saving}</span>{/if}
		</li>
	  {/foreach}
	  </ul>
  <a href="{$SALE_ITEMS_URL}" class="button_default_large" />{$LANG.catalogue.view_all_saleitems} &raquo;</a>
  </div>
</div>
{/if}