<h2>{$category.cat_name}</h2>
 {if isset($category.image)}
<div id="categoryImage">
	<img src="{$category.image}" alt="{$category.cat_name}"/>
</div>
 {/if} {$category.cat_desc} {if $SUBCATS}
<div id="subCategories">
	 {foreach from=$SUBCATS item=subcat}
	<div class="subCategory">
		<a href="{$subcat.url}" title="{$subcat.cat_name}"><img src="{$subcat.cat_image}" alt="{$subcat.cat_name}"/></a>
		<br/>
		<a href="{$subcat.url}" title="{$subcat.cat_name}">{$subcat.cat_name}</a>
	</div>
	 {/foreach}
	<div class="clear">
		&nbsp;
	</div>
</div>
 {/if} {if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<form class="sortBy" action="{$VAL_SELF}" method="post">
	<div class="control controlTop">
		<span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>
		{if isset($SORTING)}
		<div class="sortByCaption">
			{$LANG.form.sort_by}
		</div>
		<div class="select">
			<select name="sort" class="sortBy auto_submit">
				<option value="">{$LANG.form.please_select}</option>
				 {foreach from=$SORTING item=sort}
				<option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
				 {/foreach}
			</select>
			<input type="submit" value="{$LANG.form.sort}"/>
		</div>
		 {/if}
	</div>
</form>
<div class="clear">
	&nbsp;
</div>
 {/if} {if isset($PRODUCTS)}
<div id="productContainer">
	 {foreach from=$PRODUCTS item=product}
	<div class="products">
		<form action="{$VAL_SELF}" method="post" class="addForm">
			<div class="productsImg">
				<a href="{$product.url}" title="{$product.name}">
				<img src="{$product.thumbnail}" alt="{$product.name}"/>
				</a>
			</div>
			<div class="productsTitle">
				<a href="{$product.url}" title="{$product.name}">{$product.name|truncate:38:"&hellip;"}</a>
			</div>
			 {if $product.ctrl_sale}
			<div class="productsPrice">
				<span class="price_previous">{$product.price}</span><span class="price_sale">{$product.sale_price}</span>
			</div>
			 {else}
			<div class="productsPrice">
				{$product.price}
			</div>
			 {/if}
			<div class="productsActions">
				<a href="{$product.url}" class="btn productsBuy">{$LANG.common.more_info}</a>
			</div>
		</form>
	</div>
	 {/foreach}
</div>
 {else}
<p>
	{$LANG.category.no_products}
</p>
 {/if}
<div class="clear">
	&nbsp;
</div>
 {if isset($PRODUCTS) && count($PRODUCTS) >= 1}
<form class="sortBy" action="{$VAL_SELF}" method="post">
	<div class="control">
		<span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>
		{if isset($SORTING)}
		<div class="sortByCaption">
			{$LANG.form.sort_by}
		</div>
		<div class="select">
			<select name="sort" class="sortBy auto_submit">
				<option value="">{$LANG.form.please_select}</option>
				 {foreach from=$SORTING item=sort}
				<option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
				 {/foreach}
			</select>
			<input type="submit" value="{$LANG.form.sort}"/>
		</div>
		 {/if}
	</div>
</form>
<div class="clear">
	&nbsp;
</div>
{/if}