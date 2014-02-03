{if $PRODUCTS}
<div id="sale_products">
  <h3>{$LANG.catalogue.title_saleitems}</h3>
  <ol>
  {foreach from=$PRODUCTS item=product}
	<li>
	  <a href="{$product.url}" title="{$product.name}">{$product.name}</a><br />
	  {if {$product.saving}}<span class="saving">{$LANG.catalogue.saving} {$product.saving}</span>{/if}
	</li>
  {/foreach}
  </ol>
</div>
{/if}