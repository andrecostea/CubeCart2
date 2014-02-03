<div id="quick_search">
  <form action="{$ROOT_PATH}index.php?_a=category" method="get">
	<h2>{$LANG.common.search}</h2>
	<span class="search"><input name="search[keywords]" type="text" id="keywords" title="{$LANG.search.input_default}" size="18" /></span>
	<input type="hidden" name="_a" value="category" />
	<input class="search" type="submit" value="{$LANG.common.find} &raquo;" />
	<p class="advanced"><a href="{$SEARCH_URL}">{$LANG.search.advanced}</a></p>
	  </form>
</div>