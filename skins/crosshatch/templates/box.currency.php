<div id="currency">
	<form id="currency_select" action="{$VAL_SELF}" method="post">
		<div class="currencyCaption">
			{$LANG.common.change_currency}
		</div>
		<div class="select">
			<select name="set_currency" class="auto_submit">
				 {foreach from=$CURRENCIES item=currency}
				<option value="{$currency.code}" {$currency.selected} title="{$currency.name}">{$currency.symbol_left} {$currency.code} {$currency.symbol_right}</option>
				 {/foreach}
			</select>
		</div>
		<input type="submit" value="{$LANG.common.submit}"/>
	</form>
	<div class="clear">
		&nbsp;
	</div>
</div>