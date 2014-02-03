<div id="featured_product">
  <h3>{$LANG.catalogue.title_feature}</h3>
  <form action="{$VAL_SELF}" method="post" class="addForm" enctype="application/x-www-form-urlencoded">
	  <div class="wrapper_top">
	  <p class="image">
		<a href="{$featured.url}" title="{$featured.name}">
		  <img src="{$featured.image}" alt="{$featured.name}" />
		</a>
	  </p>
	  <p class="title"><a href="{$featured.url}" title="{$featured.name}">{$featured.name}</a></p>
	  </div>
	  <div class="wrapper_bottom">
	  {if $featured.ctrl_sale}
	  <p class="price"><span class="price_previous">{$featured.price}</span> <span class="price_sale">{$featured.sale_price}</span></p>
	  {else}
	  <p class="price">{$featured.price}</p>
	  {/if}
	  {if $featured.ctrl_purchase && !$CATALOGUE_MODE}
  	  <input type="hidden" name="add[{$featured.product_id}][quantity]" value="1" />
  	  <input type="submit" class="button_default" value="{$LANG.catalogue.buy_now} &raquo;" />
  	  {/if}
  	  </div>
  	    </form>
</div>