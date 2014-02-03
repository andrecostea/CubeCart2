<div id="quick_search">
  <h3>{$LANG.common.search}</h3>
  <form action="{$ROOT_PATH}index.php?_a=category" method="get">
	<span class="search"><input name="search[keywords]" type="text" id="keywords" title="{$LANG.search.input_default}" size="18" /></span>
	<input type="hidden" name="_a" value="category" />
	<input class="search" type="submit" value="" title="{$LANG.common.search}" />
	<p class="advanced"><a href="{$SEARCH_URL}">{$LANG.search.advanced}</a></p>
	  </form>
</div>