<div id="basket_summary">
  <h3 class="hidden">{$LANG.checkout.your_basket}</h3>
  <ul>
  	{foreach from=$CONTENTS item=item}
	<li class="hidden">
	  <span class="price">{$item.total}</span>
	  <a href="{$item.link}" title="{$item.name}">{$item.quantity} &times; {$item.name_abbrev}</a>
	</li>
	{/foreach}
  </ul>
  <p class="basket_items">
	{$CART_ITEMS}
	{$LANG.basket.basket_item_count}
  </p>
  <p class="basket_total">
	{$LANG.basket.total}: {$CART_TOTAL}
  </p>
  <p class="view_basket animate_basket"><a href="{$STORE_URL}/index.php?_a=basket" title="{$LANG.basket.view_basket}" class="button_default">{$LANG.basket.view_basket} &raquo;</a></p>
</div>