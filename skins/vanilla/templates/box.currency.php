<form id="currency_select" action="{$VAL_SELF}" method="post">
  <p>{$LANG.common.change_currency}:<br />
  <select name="set_currency" class="auto_submit">
  {foreach from=$CURRENCIES item=currency}
  <option value="{$currency.code}" {$currency.selected} title="{$currency.name}">{$currency.symbol_left} {$currency.code} {$currency.symbol_right}</option>
  {/foreach}
  </select> <input type="submit" value="{$LANG.common.submit}" />
  </p>
  </form>