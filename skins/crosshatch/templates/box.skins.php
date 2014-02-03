<div id="skinSelect">
	<form action="{$VAL_SELF}" method="post" id="skin_selector">
		<div class="skinCaption">
			Select Skin:
		</div>
		<div class="select">
			<select name="select_skin" class="auto_submit">
				 {foreach from=$SKINS item=skin} {if isset($skin.styles)} <optgroup label="{$skin.display}">
				{foreach from=$skin.styles item=style}
				<option value="{$skin.name}|{$style.directory}" {$style.selected}>{$style.name}</option>
				 {/foreach} </optgroup>
				{else}
				<option value="{$skin.name}" {$skin.selected}>{$skin.display}</option>
				 {/if} {/foreach}
			</select>
		</div>
		<input type="submit" value="submit"/>
	</form>
	<div class="clear">
		&nbsp;
	</div>
</div>