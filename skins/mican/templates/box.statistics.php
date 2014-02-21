<div id="user_statistics">
  <h3>{$LANG.newsletter.mailing_list}</h3>
  {if $IS_USER}
	<p><a href="{$STORE_URL}/index.php?_a=statistics">{$LANG.statistics.statistics}</a></p>
  {else}
	<p><a href="{$STORE_URL}/index.php?_a=login">{$LANG.newsletter.login}</a>{$LANG.statistics.login_to_display}</p>
  {/if}
</div>
