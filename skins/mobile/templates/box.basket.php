<div id="basket_summary">
  {if isset($CONTENTS) && count($CONTENTS) > 0}
 <span class="basket_items"><a href="{$BUTTON.link}" title="{$BUTTON.text}">{$CART_ITEMS}</a></span>
  {else}
  <span class="basket_items"><a href="{$BUTTON.link}" title="{$BUTTON.text}">0</a></span>
  {/if}
</div>