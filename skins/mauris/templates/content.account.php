<div>
  <h2>{$LANG.account.your_account}</h2>
  <div id="myaccount">	
	<ul>
	  <li><a href="{$STORE_URL}/index.php?_a=profile" title="{$LANG.account.your_details}">{$LANG.account.your_details}</a></li>
	  <li><a href="{$STORE_URL}/index.php?_a=addressbook" title="{$LANG.account.your_addressbook}">{$LANG.account.your_addressbook}</a></li>
	  <li><a href="{$STORE_URL}/index.php?_a=vieworder" title="{$LANG.account.your_orders}">{$LANG.account.your_orders}</a></li>
	  <li><a href="{$STORE_URL}/index.php?_a=downloads" title="{$LANG.account.your_downloads}">{$LANG.account.your_downloads}</a></li>
	  <li><a href="{$STORE_URL}/index.php?_a=newsletter" title="{$LANG.account.your_subscription}">{$LANG.account.your_subscription}</a></li>
	  {foreach from=$ACCOUNT_LIST_HOOKS item=list_item}
	  <li><a href="{$list_item.href}" title="{$list_item.title}">{$list_item.title}</a></li>
	  {/foreach}
	</ul>
  </div>
</div>
