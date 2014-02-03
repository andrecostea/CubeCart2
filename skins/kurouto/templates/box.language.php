<div id="language_select">
  <span class="title">{$LANG.common.change_language}</span>:
  {foreach from=$LANGUAGES item=language}
  <a href="{$language.url}" title="{$language.title}" class="{$language.css}">
	<img src="{$STORE_URL}/language/flags/{$language.code}.png" alt="{$language.title}" id="language_{$language.code}" />
  </a>
  {/foreach}
</div>