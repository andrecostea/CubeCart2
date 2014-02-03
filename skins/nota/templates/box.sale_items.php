{if $PRODUCTS}
<div id="sale_products">
  <div class="top">  
    <h3>{$LANG.catalogue.title_saleitems}</h3>
    <ul>
    {foreach from=$PRODUCTS item=product}
	  <li>
	    <a href="{$product.url}" title="{$product.name}">{$product.name}</a><br />
	    {if {$product.saving}}<span class="saving">{$LANG.catalogue.saving} {$product.saving}</span>{/if}
	  </li>
    {/foreach}
    </ul>
  </div>
  <div class="bottom"><a href="{$SALE_ITEMS_URL}">{$LANG.catalogue.all_sale_items}</a></div>
</div>
{/if}