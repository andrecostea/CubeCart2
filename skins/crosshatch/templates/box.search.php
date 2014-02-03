<div id="search">
	<form id="searchForm" action="{$ROOT_PATH}index.php?_a=category" method="get">
		<fieldset>
			<div class="input">
				<input type="text" name="search[keywords]" id="s" value="{$LANG.search.input_default}"/>
				<input type="hidden" name="_a" value="category"/>
			</div>
			<input id="searchSubmit" type="submit" value="{$LANG.common.search}"/>
		</fieldset>
	</form>
	<a href="{$SEARCH_URL}" class="searchAdvanced">{$LANG.search.advanced}</a>
</div>