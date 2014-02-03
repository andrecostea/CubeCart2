<form id="language_select" action="{$VAL_SELF}" method="post">
  <div><label>{$LANG.common.change_language}</label>
  <span><select name="set_language" class="textbox auto_submit">
  {foreach from=$LANGUAGES item=language}
  <option value="{$language.code}" {$language.selected}>{$language.title}</option>
  {/foreach}
  </select> <input type="submit" value="{$LANG.common.submit}" />
  </span>
  </div>
  </form>