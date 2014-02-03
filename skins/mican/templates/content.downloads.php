{if $IS_USER}
<h2>{$LANG.account.your_downloads}</h2>
<p></p>
<div class="paginate">{if isset($PAGINATION)}{$PAGINATION}{/if}</div>
<div class="list">
  {foreach from=$DOWNLOADS item=download}
	  {if $download.deleted}
  <div class="dl_unavailable">{$LANG.account.download_deleted}</div>
	  {else}
		{if $download.active}
  <div>
	<span class="actions">
	  <a href="{$STORE_URL}/index.php?_a=download&amp;accesskey={$download.accesskey}" title="{$LANG.common.download}"><img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/common/file_download.png" alt="{$LANG.common.download}" /></a>
	</span>
	<a href="{$download.product_url}" title="{$LANG.catalogue.view_product}">{$download.name}</a>
	<p><strong>{$LANG.account.download_expires}</strong>: {$download.expires} - <strong>{$LANG.account.download_count}</strong>: {$download.downloads}/{$MAX_DOWNLOADS}</p>
  </div>
		{else}
  <div>
	<span class="actions">{$LANG.common.expired}</span>
	<a href="{$download.product_url}" title="View product">{$download.name}</a>
	<p><strong>{$LANG.account.download_expired}</strong>: {$download.expires} - <strong>{$LANG.account.download_count}</strong>: {$download.downloads}/{$MAX_DOWNLOADS}</p>
  </div>
		{/if}
	  {/if}
  {foreachelse}
  <div>{$LANG.notification.no_downloads_available}</div>
  {/foreach}
</div>
<div class="paginate">{if isset($PAGINATION)}{$PAGINATION}{/if}</div>
{else}
<form action="{$VAL_SELF}" method="post">
  <h2>{$LANG.catalogue.redeem_download_code}</h2>
  <p></p>
  <fieldset>
	<div><label for="download-code">{$LANG.catalogue.download_access_key}</label><span><input type="text" name="accesskey" id="download-code" value="" /></span></div>
  </fieldset>
  <div><input type="submit" value="{$LANG.common.submit}" class="button_default" /></div>
  </form>
{/if}