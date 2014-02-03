{if isset($GUI_MESSAGE)}
<div id="gui_message">
  {if isset($GUI_MESSAGE.error)}
  <div class="gui_message-error">
	{$LANG.gui_message.errors_detected}
	<ul>
		{foreach from=$GUI_MESSAGE.error item=error}
	  	<li>{$error}</li>
	  	{/foreach}
	</ul>
  </div>
  {/if}
  {if isset($GUI_MESSAGE.notice)}
	{foreach from=$GUI_MESSAGE.notice item=notice}
  	<div class="gui_message-notice">{$notice}</div>
	{/foreach}
  {/if}
</div>
{/if}