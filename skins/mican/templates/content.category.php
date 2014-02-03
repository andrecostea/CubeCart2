<h2>{$category.cat_name}</h2>

{if isset($category.image)}
<div id="category_image"><img src="{$category.image}" alt="{$category.cat_name}" /></div>
{/if}

{$category.cat_desc}

{if $SUBCATS}
<div id="subcategories">
  {foreach from=$SUBCATS item=subcat}
  <div class="subcategory">
	<a href="{$subcat.url}" title="{$subcat.cat_name}">
	  <img src="{$subcat.cat_image}" alt="{$subcat.cat_name}" />
	</a>
	<a href="{$subcat.url}" title="{$subcat.cat_name}">{$subcat.cat_name}</a>
  </div>
  {/foreach}
</div>
{/if}

{if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<form action="{$VAL_SELF}" method="post">
  <div class="control">
	<span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>
	{if isset($SORTING)}
	{$LANG.form.sort_by}
	<select name="sort" class="auto_submit">
	  <option value="">{$LANG.form.please_select}</option>
	  {foreach from=$SORTING item=sort}
	  <option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
	  {/foreach}
	</select>
	<input type="submit" value="{$LANG.form.sort}" />
	{/if}
  </div>
  </form>
{/if}

{if isset($PRODUCTS)}
  {foreach from=$PRODUCTS item=product}
<form action="{$VAL_SELF}" method="post" enctype="application/x-www-form-urlencoded" class="addForm">
  <div class="category_product">
	<h3><a href="{$product.url}" title="{$product.name}">{$product.name}</a></h3>
	<a href="{$product.url}" title="{$product.name}" class="image">
	  <img src="{$product.thumbnail}" alt="{$product.name}" />
	</a>
	<div class="details">
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
	  <p class="rating-info">{$product.review_info}</p>
	{/if}


	{if $product.ctrl_purchase && !$CATALOGUE_MODE}
	  <p class="buy_button"><input type="text" name="add[{$product.product_id}][quantity]" value="1" class="quantity" /> <input type="submit" value="{$LANG.catalogue.add_to_basket}" class="button_default" /></p>
	{elseif $product.out}
	  <p class="buy_button">{$LANG.catalogue.out_of_stock_short}</p>
	{/if}
	</div>
	<p class="description">{$product.description_short}</p>
  </div>
  </form>
  {/foreach}
{else}
<p>{$LANG.category.no_products}</p>
{/if}

{if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<form action="{$VAL_SELF}" method="post">
  <div class="control">
	<span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>
	{if isset($SORTING)}
	{$LANG.form.sort_by}
	<select name="sort" class="auto_submit">
	  <option value="">{$LANG.form.please_select}</option>
	  {foreach from=$SORTING item=sort}
	  <option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
	  {/foreach}
	</select>
	<input type="submit" value="{$LANG.form.sort}" />
	{/if}
  </div>
  </form>
{/if}