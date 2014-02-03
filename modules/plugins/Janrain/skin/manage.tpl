<div>
  <h2>{$MODULE_LANG.your_openid}</h2>
  <p><strong>{$MODULE_LANG.your_existing_openids}</strong></p>
{if $IDENTITIES}
  <div class="list">
  {foreach from=$IDENTITIES item=identity}
	<div class="openid" title="{$identity.identity_url}">
	  <span style="float: right;">
		<a href="{$identity.delete}" class="delete" title="{$LANG.common.decision_remove}"><img src="skins/{$SKIN_FOLDER}/images/common/bin.png" alt="{$LANG.common.remove}" /></a>
	  </span>{$identity.identity_type}
	</div>
  {/foreach}
  </div>
{else}
<div class="list">
  <p>{$MODULE_LANG.no_openids_exist}</p>
</div>
{/if}
  <form action="{$VAL_SELF}" method="post">
	<fieldset>
	  <div><a href="https://{$RPX_APP_DOMAIN}/openid/v2/signin?token_url={$VAL_SELF|urlencode}" class="rpxnow">{$MODULE_LANG.link_account}</a></div>
	</fieldset>
  </div>
</div>