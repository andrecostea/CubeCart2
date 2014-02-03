<div id="session">
  {if $IS_USER}
  <p>
	{$LANG_WELCOME_BACK} <a href="#" id="session_action_button">[+]</a> <br />
	<ul id="session_actions">
		<li><a href="{$STORE_URL}/index.php?_a=logout" title="{$LANG.account.logout}">{$LANG.account.logout}</a></li> 
		<li><a href="{$STORE_URL}/index.php?_a=account" title="{$LANG.account.your_account}">{$LANG.account.your_account}</a></li>
	</ul>
  </p>
  {else}
  <p>
	<span>{$LANG.account.welcome_guest}</span>
	<a href="{$URL.login}" title="{$LANG.account.log_in}">{$LANG.account.log_in}</a> {$LANG.common.or} 
	<a href="{$URL.register}" title="{$LANG.account.register}">{$LANG.account.register}</a>
  </p>
  {/if}
</div>