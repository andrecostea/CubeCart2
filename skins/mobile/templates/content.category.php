<h2>{$category.cat_name}</h2>
{if isset($SUBCATS) && $SUBCATS}
<ul id="menu" class="accordion">
  {foreach from=$SUBCATS item=subcat}
  <li><a href="{$subcat.url}" title="{$subcat.cat_name}">{$subcat.cat_name}</a></li>
  {/foreach}
</ul>
{/if}

{if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<form action="{$VAL_SELF}" method="post">
  
	{if isset($SORTING)}
	<div class="control">
	<select name="sort" class="auto_submit textbox">
	  <option value="">-- {$LANG.form.sort_by} --</option>
	  {foreach from=$SORTING item=sort}
	  <option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
	  {/foreach}
	</select>
	<input type="submit" value="{$LANG.form.sort}" />
	</div>
    {/if}
  </form>
{/if}

{if isset($PRODUCTS)}
  {foreach from=$PRODUCTS item=product}
<form action="{$VAL_SELF}" method="post" enctype="application/x-www-form-urlencoded" class="addForm">
  <div class="category_product cf">
	
	<a href="{$product.url}" title="{$product.name}" class="image">
	  <img src="{$product.thumbnail}" alt="{$product.name}" />
	</a>
	<div class="details">
    <h3><a href="{$product.url}" title="{$product.name}">{$product.name}</a></h3>
	{if $product.ctrl_sale}
	  <p class="price"><span class="price_previous">{$product.price}</span> <span class="price_sale">{$product.sale_price}</span></p>
	{else}
	  <p class="price">{$product.price}</p>
	{/if}

	{if $product.review_score}
	  <p class="rating">
	  {for $i = 1; $i <= 5; $i++}
	  	{if $product.review_score >= $i}
		<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/common/star.png" alt="" />
		{elseif $product.review_score > ($i - 1) && $product.review_score < $i}
		<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/common/star_half.png" alt="" />
		{else}
		<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/common/star_off.png" alt="" />
		{/if}
      {/for}
	  </p>
	{/if}

	{if $product.ctrl_purchase && !$CATALOGUE_MODE}
	  <p class="buy_button"><input type="text" name="add[{$product.product_id}][quantity]" value="1" class="quantity" /> <input type="submit" value="{$LANG.catalogue.add_to_basket}" class="button_white" /></p>
	{elseif $product.out}
	  <p class="buy_button">{$LANG.catalogue.out_of_stock_short}</p>
	{/if}
	</div>
  </div>
  </form>
  {/foreach}
{else}
<p>{$LANG.category.no_products}</p>
{/if}

{if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>
  {/if}