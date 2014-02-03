<div id="currency_select">
  <span style="float: left;">{$LANG.common.change_currency}:</span>
  <ul id="account_currency_dd" class="jquery_dd">
	<li><a href="#">{$CURRENT_CURRENCY.symbol_left} {$CURRENT_CURRENCY.code} {$currency.symbol_right}</a>
		<ul>
			{foreach from=$CURRENCIES item=currency}
				{if !$currency.selected}
				<li><a href="{$currency.url}" title="{$currency.name}">{$currency.symbol_left} {$currency.code} {$currency.symbol_right}</a></li>
				{/if}
			{/foreach}
		</ul>
	</li>
  </ul>
</div>