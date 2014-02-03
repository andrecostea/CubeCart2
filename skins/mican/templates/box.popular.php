<div id="popular_products">
  <h3>{$LANG.catalogue.title_popular}</h3>
  <div class="wrapper">
	  <ol>
		{foreach from=$POPULAR item=product}
		<li><a href="{$product.url}" title="{$product.name}">{$product.name}</a></li>
		{/foreach}
	  </ol>
  </div>
</div>