<div id="quick_search">
  <h3>{$LANG.common.search}</h3>
  <form action="{$ROOT_PATH}index.php?_a=category" method="get">
	<input name="search[keywords]" type="text" id="keywords" title="{$LANG.search.input_default}" size="18" />
	<input type="hidden" name="_a" value="category" />
	<div class="controls">
		<input type="submit" value="{$LANG.common.search}" />
		<a href="{$SEARCH_URL}">{$LANG.search.advanced}</a>
	</div>
  </form>
</div>