<div id="language_select">
  <span style="float: left;">{$LANG.common.change_language}:</span>
  <ul id="account_language_dd" class="jquery_dd">
	<li><a href="#"><img src="{$STORE_URL}/language/flags/{$current_language.code}.png" alt="{$current_language.title}" id="language_{$current_language.code}" /></a>
		<ul>
			{foreach from=$LANGUAGES item=language}
				{if !$language.selected}
				<li><a href="{$language.url}" title="{$language.title}" class="{$language.css}">
	<img src="{$STORE_URL}/language/flags/{$language.code}.png" alt="{$language.title}" id="language_{$language.code}" />
  </a> </li>
				{/if}
			{/foreach}
		</ul>
	</li>
  </ul>
</div>