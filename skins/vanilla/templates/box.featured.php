<div id="featured_product">
  <form action="{$VAL_SELF}" method="post" class="top addForm" enctype="application/x-www-form-urlencoded">
    <h3>{$LANG.catalogue.title_feature}</h3>
    <p class="image">
	  <a href="{$featured.url}" title="{$featured.name}">
	    <img src="{$featured.image}" alt="{$featured.name}" />
	  </a>
    </p>
    <p class="title"><a href="{$featured.url}" title="{$featured.name}">{$featured.name}</a></p>
      {if $featured.ctrl_sale}
	  <p class="price"><span class="price_previous">{$featured.price}</span> <span class="price_sale">{$featured.sale_price}</span></p>
	  {else}
	  <p class="price">{$featured.price}</p>
	  {/if}
	  {if $featured.ctrl_purchase && !$CATALOGUE_MODE}
  	  <div class="button">
  	    <input type="hidden" name="add[{$featured.product_id}][quantity]" value="1" />
  	    <input type="submit" class="button_add_basket" value="{$LANG.catalogue.buy_now}" />
  	  </div>
  	  {/if}
  </form>
</div>