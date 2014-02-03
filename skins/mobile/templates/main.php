<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$TEXT_DIRECTION}" lang="{$HTML_LANG}">
  <head>
	<title>{$META_TITLE}</title>
	<link rel="canonical" href="{$VAL_SELF}" />
	<link rel="shortcut icon" href="{$STORE_URL}/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/common.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/{$SKIN_SUBSET}/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="{$STORE_URL}/js/styles/styles.php" media="screen" />
	<meta http-equiv="Content-Type" content="text/html;charset={$CHARACTER_SET}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta name="description" content="{if isset($META_DESCRIPTION)}{$META_DESCRIPTION}{/if}" />
	<meta name="keywords" content="{if isset($META_KEYWORDS)}{$META_KEYWORDS}{/if}" />
	<meta name="robots" content="index, follow" />
	<meta name="generator" content="cubecart" />
	{if $FBOG}
	<meta property="og:image" content="{$PRODUCT.thumbnail}">
	<meta property="og:url" content="{$VAL_SELF}">
	{/if}
	{if $ANALYTICS}
	{literal}<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '{/literal}{$ANALYTICS}{literal}']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>{/literal}
	{/if}
  </head>
<body>
	<div id="account">
	 {$SESSION}{$SHOPPING_CART} 
	</div>
	<div id="header">
	  <p class="logo"><a href="{$STORE_URL}"><img src="{$STORE_LOGO}" alt=" " /></a></p>  
      {$SEARCH_FORM}
	</div>  
	<div class="{$SECTION_NAME}_wrapper">
	 {if isset($SECTION_NAME) && ($SECTION_NAME == "home")}{$CATEGORIES}{/if}
	  <div id="page_content" class="cf">	
		{if isset($CHECKOUT_PROGRESS)}{$CHECKOUT_PROGRESS}{/if}
        {include file='templates/box.errors.php'}
		{$PAGE_CONTENT}
        {if isset($SECTION_NAME) && ($SECTION_NAME == "home")}
        {$MAIL_LIST}     
        <h2>Store Settings</h2>
        <fieldset>{$CURRENCY}{$LANGUAGE}</fieldset> {/if} 
      </div>            
	  <div id="documents">{$SITE_DOCS}{$COPYRIGHT}
	  <div><a href="{$STORE_URL}/index.php?display_mobile=0">{$LANG.common.desktop_site}</a></div>
	  </div>
	  
	</div>
  {include file='js/common.html'}
  {foreach from=$JS_SCRIPTS key=k item=script}
  <script type="text/javascript" src="{$STORE_URL}/{$script|replace:'\\':'/'}"></script>
  {/foreach}
</body>
</html>