<form id="currency_select" action="{$VAL_SELF}" method="post">
  <div><label>{$LANG.common.change_currency}</label>
  <span><select name="set_currency" class="textbox auto_submit">
  {foreach from=$CURRENCIES item=currency}
  <option value="{$currency.code}" {$currency.selected} title="{$currency.name}">{$currency.symbol_left} {$currency.code} {$currency.symbol_right}</option>
  {/foreach}
  </select> <input type="submit" value="{$LANG.common.submit}" />
  </span></div>
  </form>