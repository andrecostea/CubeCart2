<div id="language">
	<form id="language_select" action="{$VAL_SELF}" method="post">
		<div class="languageCaption">
			{$LANG.common.change_language}
		</div>
		<div class="select">
			<select name="set_language" class="auto_submit">
				 {foreach from=$LANGUAGES item=language}
				<option value="{$language.code}" {$language.selected}>{$language.title}</option>
				 {/foreach}
			</select>
		</div>
		<input type="submit" value="{$LANG.common.submit}"/>
	</form>
	<div class="clear">
		&nbsp;
	</div>
</div>