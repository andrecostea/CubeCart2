<div id="user_statistics">
  <h3>{$LANG.user_statistics.useful_info}</h3>
  {if $IS_USER}
	<ul id="menu" class="accordion">
	   <li><a href="{$STORE_URL}/index.php?_a=statistics">{$LANG.user_statistics.statistics}</a></li>
	</ul>
  {else}
	<br />
	<p><a href="{$STORE_URL}/index.php?_a=login">&nbsp;{$LANG.user_statistics.login}</a> {$LANG.user_statistics.login_to_display}</p>
  {/if}
</div>
