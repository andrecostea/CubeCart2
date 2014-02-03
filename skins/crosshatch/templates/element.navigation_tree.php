<li>
<a href="{$BRANCH.url}">{$BRANCH.name}</a>
{if isset($BRANCH.children)}
<ul>
	{$BRANCH.children}
</ul>
 {/if} </li>