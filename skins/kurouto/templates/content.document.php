<h2>{$DOCUMENT.doc_name}</h2>
<div id="sitedoc">{$DOCUMENT.doc_content}</div>
{if $SHARE}
<h2>{$LANG.account.share}</h2>
{foreach from=$SHARE item=html}
{$html}
{/foreach}
{/if}
{foreach from=$COMMENTS item=html}
{$html}
{/foreach}