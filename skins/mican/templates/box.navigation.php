<div>
  <h3>{$LANG.navigation.title}</h3>
  <ul id="menu" class="accordion">
	<li><a href="{$STORE_URL}/index.php" title="{$LANG.navigation.homepage}">{$LANG.navigation.homepage}</a></li>

	{$NAVIGATION_TREE}

	{if $CTRL_CERTIFICATES && !$CATALOGUE_MODE}
	<li class="li-nav"><a href="{$URL.certificates}" title="{$LANG.navigation.giftcerts}">{$LANG.navigation.giftcerts}</a></li>
	{/if}
	{if $CTRL_SALE}
	<!--<li class="li-nav"><a href="{$URL.saleitems}" title="{$LANG.navigation.saleitems}">{$LANG.navigation.saleitems}</a></li>-->
	{/if}
  </ul>
</div>