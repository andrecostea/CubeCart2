{if isset($BLOCKS)}
<div class="checkout-progress">
  {foreach from=$BLOCKS item=block}
  <span class="{$block.class}"><a href="{$block.url}">{$block.step} {$block.title}</a></span>
  {/foreach}
  &nbsp;
</div>
 {/if}