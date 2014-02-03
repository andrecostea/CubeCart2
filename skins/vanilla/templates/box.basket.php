<div id="basket_summary">
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
  {else}
  <p>{$LANG.basket.basket_is_empty}</p>
  {/if}
  <!--<p class="basket_totals">{$CART_ITEMS} {$LANG.common.items}</p>-->
  <p class="basket_total"><span>{$LANG.basket.total}</span>{$CART_TOTAL}</p>
  <p class="view_basket animate_basket"><a href="{$BUTTON.link}" title="{$BUTTON.text}">{$BUTTON.text}</a></p>
</div>