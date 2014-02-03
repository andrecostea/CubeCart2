<form method="post" action="?_a=category" enctype="multipart/form-data">
  <h2>{$LANG.search.advanced}</h2>
  <p></p>
  <fieldset>
	<div><label for="keywords">{$LANG.search.keywords}</label><span><input type="text" class="textbox" name="search[keywords]" id="keywords" class="required" /> *</span></div>
	<div>
	  <label for="">{$LANG.search.price_range}</label><span><input type="text" class="textbox" style="width: 50px;" name="search[priceMin]" /> 
		- <input type="text" class="textbox" style="width: 50px;" name="search[priceMax]" /> 
		<input type="checkbox" name="search[priceVary]" value="1" /> &plusmn;5%
	  </span>
	</div>
	{if isset($MANUFACTURERS)}
	<div>
	  <label for="">{$LANG.catalogue.manufacturer}</label>
	  <span>
		<select name="search[manufacturer][]" multiple="multiple">
		  <option value="">{$LANG.form.ignore}</option>
		  {foreach from=$MANUFACTURERS item=manufacturer}
		  <option value="{$manufacturer.id}" {$manufacturer.selected}>{$manufacturer.name}</option>
		  {/foreach}
		</select>
	  </span>
	</div>
	{/if}
	{if isset($SORTERS)}
	<div>
	  <label for="sort">{$LANG.form.sort_by}</label><span><select name="sort" id="sort">
	  	{foreach from=$SORTERS item=sort}
		<option value="{$sort.field}|{$sort.order}" {$sort.selected}>{$sort.name} ({$sort.direction})</option>
		{/foreach}
		</select>
	  </span>
	</div>
	{/if}
	{if !isset($OUT_OF_STOCK)}<div><label for="in_stock">{$LANG.search.in_stock}</label><span><input type="checkbox" name="search[inStock]" id="in_stock" value="1" /></span></div>{/if}
	<div><label for="featured_only">{$LANG.search.featured_only}</label><span><input type="checkbox" name="search[featured]" id="featured_only" value="1" /></span></div>	
  </fieldset>
  <p><input type="submit" class="button_submit" value="{$LANG.form.submit}" /> <input type="reset" class="button_submit" value="{$LANG.common.reset}" /></p>
</form>