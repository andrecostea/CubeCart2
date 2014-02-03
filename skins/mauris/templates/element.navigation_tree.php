<li>
  <a href="{$BRANCH.url}" title="{$BRANCH.name}">{$BRANCH.name}</a>
  {if isset($BRANCH.children)}
  <ul>{$BRANCH.children}</ul>
  {/if}
</li>