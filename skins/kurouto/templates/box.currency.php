<div id="currency_select">
  <p>{$LANG.common.change_currency}:
  {foreach from=$CURRENCIES item=currency}
	<a href="{$currency.url}" class="{$currency.css}" title="{$currency.name}">{$currency.code}</a>
  {/foreach}
  </p>
</div>