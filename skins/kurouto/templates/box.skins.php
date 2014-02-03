<form action="{$VAL_SELF}" method="post" id="skin_selector">
  <select name="select_skin" class="auto_submit">
  {foreach from=$SKINS item=skin}
	{if isset($skin.styles)}
	<optgroup label="{$skin.display}">
	  {foreach from=$skin.styles item=style}
	  <option value="{$skin.name}|{$style.directory}" {$style.selected}>{$style.name}</option>
	  {/foreach}
	</optgroup>
    {else}
	<option value="{$skin.name}" {$skin.selected}>{$skin.display}</option>
    {/if}
  {/foreach}
  </select><input type="submit" value="submit" />
  </form>