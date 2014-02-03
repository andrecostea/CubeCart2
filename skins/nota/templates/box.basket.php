<div id="basket_summary">
  <div class="top">
  <h3>{$LANG.checkout.your_basket}</h3>
  {if isset($CONTENTS) && count($CONTENTS) > 0}
  <ul>
  	{foreach from=$CONTENTS item=item}
	<li>
	  <span class="price">{$item.total}</span>
	  <a href="{$item.link}" title="{$item.name}">{$item.quantity} &times; {$item.name_abbrev}</a>
	</li>
	{/foreach}
  </ul>
  <p class="basket_items">
	<span class="price">{$CART_ITEMS}</span>
	{$LANG.basket.basket_item_count}
  </p>
  <p class="basket_total">
	<span class="price">{$CART_TOTAL}</span>
	<strong>{$LANG.basket.total}</strong>
  </p>
  <div class="checkout_button animate_basket"><a href="{$BUTTON.link}" title="{$BUTTON.text}" class="view_basket">{$BUTTON.text}</a></div>
  {else}
  <p style="text-align: center;">{$LANG.basket.basket_is_empty}</p>
  {/if}
  </div>
  <div class="bottom"> </div>
</div>