<form id="language_select" action="{$VAL_SELF}" method="post">
  <span class="title">{$LANG.common.change_language}</span>:<br />
  <select name="set_language" class="auto_submit">
  {foreach from=$LANGUAGES item=language}
  <option value="{$language.code}" {$language.selected}>{$language.title}</option>
  {/foreach}
  </select> <input type="submit" value="{$LANG.common.submit}" />
  </form>