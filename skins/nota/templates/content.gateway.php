{if isset($GATEWAYS)}
  <h2>{$LANG.gateway.select}</h2>
  
  <form id="gateway-select" action="{$VAL_SELF}" method="post" enctype="multipart/form-data">
	<div id="gateways">
	{foreach from=$GATEWAYS item=gateway}
	  <p>
		<input name="gateway" type="radio" value="{$gateway.folder}" id="{$gateway.folder}" {$gateway.checked} />
		{if !empty($gateway.help)}
		<a href="{$gateway.help}" class="info" title="{$LANG.common.information}"><img src="images/icons/information.png" alt="{$LANG.common.information}" /></a>
		{/if}
		<label for="{$gateway.folder}">{$gateway.description}</label>
	  </p>
	{/foreach}
	</div>
	<div align="center"><input type="submit" value="{$LANG.common.continue}" class="button_submit" /></div>
	  </form>
{/if}

{if isset($TRANSFER)}
	{if  $TRANSFER.mode == 'iframe'}
<iframe src="{$IFRAME_SRC}" frameborder="0" scrolling="auto" width="100%" height="500" />
{$IFRAME_FORM}
	{else}
<form id="gateway-transfer" action="{$TRANSFER.action}" method="{$TRANSFER.method}" target="{$TRANSFER.target}">
	{foreach from=$FORM_VARS key=name item=value}<input type="hidden" name="{$name}" value="{$value}" />
	{/foreach}
	{if $TRANSFER.mode == 'automatic'}
<div style="text-align: center;">
  <p>{$LANG.gateway.transferring}</p>
  <p><img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/common/loading.gif" alt="{$LANG.gateway.transfer_progress}" class="autosubmit" /></p>
</div>
	{elseif $TRANSFER.mode == 'manual'}
<h2>{$LANG.gateway.amount_due}</h2>
  <p>{$LANG_AMOUNT_DUE}</p>
	{$FORM_TEMPLATE}
	{/if}
	{if !$DISPLAY_3DS}
		<div align="center"><input type="submit" value="{$BTN_PROCEED}" class="button_submit" /></div>
	{/if}
  	{foreach from=$AFFILIATES item=affiliate}
      {$affiliate}
  	{/foreach}
  {/if}
</form>
{/if}