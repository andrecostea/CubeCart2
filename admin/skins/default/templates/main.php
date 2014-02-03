<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>{$LANG.dashboard.title_admin_cp}</title>
  <link rel="shortcut icon" href="{$STORE_URL}/favicon.ico" type="image/x-icon" />
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="{$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/styles/ie7.css" media="screen" /><![endif]-->
  <link rel="stylesheet" type="text/css" href="{$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/styles/layout.css" media="screen" />
  {if isset($JQUERY_STYLES)}
  	{foreach from=$JQUERY_STYLES item=style}
  	<link rel="stylesheet" type="text/css" href="{$style}" media="screen" />
  	{/foreach}
  {/if}
  <link rel="stylesheet" type="text/css" href="js/styles/styles.php" media="screen" />
</head>

<body>
  <div id="header">
  <span class="user_info">{$LANG.settings.title_welcome_back} <a href="?_g=settings&amp;node=admins&amp;action=edit&amp;admin_id={$ADMIN_UID}">{$ADMIN_USER}</a> - [<a href="?_g=logout">{$LANG.account.logout}</a>]</span>
  </div>
  <div id="navigation">
  {if isset($NAVIGATION)}
    {foreach from=$NAVIGATION item=group}
	<div id="{$group.group}" class="menu" onclick="$('#menu_{$group.group}').toggle();">{$group.title}</div>
	{if isset($group.members)}
	<ul id="menu_{$group.group}" class="submenu">
	  {foreach from=$group.members item=nav}
	  <li><a href="{$nav.url}">{$nav.title}</a></li>
	  {/foreach}
	</ul>
	{/if}
	{/foreach}
  {/if}
  </div>
  <div id="content">
	<div id="tab_control">
	  {if isset($TABS)}
	  {foreach from=$TABS item=tab}
	  <div id="{$tab.tab_id}" class="tab">
		{if !empty($tab.notify)}<span class="tab_notify">{$tab.notify}</span>{/if}
		<a href="{$tab.url}{$tab.target}" accesskey="{$tab.accesskey}">{$tab.name}</a>
	  </div>
	  {/foreach}
	  {/if}
	</div>
	<div id="breadcrumbs">
	  <span class="helpdocs" style="float: right;">
		<a href="{$HELP_URL}" id="wikihelp" class="colorbox wiki">{$LANG.common.help}</a> | <a href="index.php" target="blank">{$LANG.settings.store_status} {if ($STORE_STATUS)}<span class="store_open">{$LANG.common.open}</span>{else}<span class="store_closed">{$LANG.common.closed}</span>{/if}</a>
	  </span>
	  <a href="?">{$LANG.dashboard.title_dashboard}</a>
	  {if isset($CRUMBS)}{foreach from=$CRUMBS item=crumb} &raquo; <a href="{$crumb.url}">{$crumb.title}</a>{/foreach}{/if}
	</div>
	{include file='templates/common.gui_message.php'}
	<div id="page_content">
	  <noscript><p class="warnText">{$LANG.settings.error_js_required}</p></noscript>
	  <div id="sidebar_contain">
		<span id="sidebar_control">&laquo;</span>
		<div id="sidebar_content">
		  <div class="sidebar_content">
			<form action="?_g=customers" method="post">
			  <h4>{$LANG.search.title_search_customers}</h4>
			  <input type="text" name="search[keywords]" id="customer_id" class="textbox ajax" rel="user" />
			  <input type="hidden" id="result_customer_id" name="search[customer_id]" value="" />
			  <input type="submit" value="{$LANG.common.search}" />
			  <input type="hidden" name="token" value="{$SESSION_TOKEN}" />
			</form>
		  </div>
		  <div class="sidebar_content">
			<form action="?_g=products" method="post">
			  <h4>{$LANG.search.title_search_products}</h4>
			  <input type="text" name="search[product]" id="product" class="textbox ajax" rel="product" /> <input type="submit" value="{$LANG.common.search}" />
			   <input type="hidden" id="result_product" name="search[product_id]" value="" />
			   <input type="hidden" name="token" value="{$SESSION_TOKEN}" />
			</form>
		  </div>
		  <div class="sidebar_content">
			<form action="?_g=orders" method="post">
			  <h4>{$LANG.search.title_search_orders}</h4>
			  <input type="text" name="search[order_number]" id="search_order" class="textbox" /> <input type="submit" value="{$LANG.common.search}" />
			  <input type="hidden" name="token" value="{$SESSION_TOKEN}" />
			</form>
		  </div>
		  {if isset($SIDEBAR_CONTENT)} {foreach from=$SIDEBAR_CONTENT item=content}<div class="sidebar_content">{$content}</div>{/foreach}{/if}
		</div>
	  </div>
	  <div id="loading_content"><img src="{$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/images/loading.gif" alt="" /></div>
	  {$DISPLAY_CONTENT}
	</div>
  </div>
  <!-- Include JavaScript last - YSlow! rates it better this way -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js"></script>

  <!--[if lte IE 6]>
  <script type="text/javascript">
	{literal}var IE6UPDATE_OPTIONS = {icons_path: "http://static.ie6update.com/hosted/ie6update/images/"}{/literal}
  </script>
  <script type="text/javascript" src="http://static.ie6update.com/hosted/ie6update/ie6update.js"></script>
  <![endif]-->
  <script type="text/javascript" src="js/plugins.php"></script>
  <!-- Include CKEditor -->
  <script type="text/javascript" src="includes/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="includes/ckeditor/adapters/jquery.js"></script>
  <!-- Common JavaScript functionality -->
  <script type="text/javascript" src="js/common.js"></script>
  <script type="text/javascript" src="js/admin.js"></script>
  {if isset($CLOSE_WINDOW)}
  	<script type="text/javascript">
  	$(document).ready(function () {
  		setInterval(function() { window.close(); }, 1000);
  	});
  	</script>
  {/if}
  {if is_array($EXTRA_JS)}
  	{foreach from=$EXTRA_JS item=js_src}
  		<script type="text/javascript" src="{$js_src}"></script>
  	{/foreach}
  {/if}
</body>
</html>