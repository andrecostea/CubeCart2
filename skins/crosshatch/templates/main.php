<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$TEXT_DIRECTION}" lang="{$HTML_LANG}">
<head>
<title>{$META_TITLE}</title>
<link rel="canonical" href="{$VAL_SELF}"/>
<link rel="shortcut icon" href="{$STORE_URL}/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/common.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/dropdown.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/expandingsearch.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/print.css" media="print"/>
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/js/styles/styles.php" media="screen"/>
 {if isset($CSS)} {foreach from=$CSS key=css_keys item=css_files}
<link rel="stylesheet" type="text/css" href="{$STORE_URL}/{$css_files}" media="screen"/>
 {/foreach} {/if} 
<!--[if IE]><link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/ie.css" media="screen" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/ie8.css"><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="{$STORE_URL}/skins/{$SKIN_FOLDER}/styles/ie7.css"><![endif]-->
<meta http-equiv="Content-Type" content="text/html;charset={$CHARACTER_SET}"/>
<meta name="description" content="{$META_DESCRIPTION}"/>
<meta name="keywords" content="{$META_KEYWORDS}"/>
<meta name="robots" content="index, follow"/>
<meta name="generator" content="cubecart"/>
{if $FBOG}
<meta property="og:image" content="{$PRODUCT.thumbnail}">
<meta property="og:url" content="{$VAL_SELF}">
{/if}
 {if $ANALYTICS} {literal}
<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '{/literal}{$ANALYTICS}{literal}']);
	  _gaq.push(['_trackPageview']);
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
{/literal} {/if}
</head>
<body>
<div id="header">
	<div class="headerContainer">
		<a href="{$STORE_URL}" class="headerLogo"><img src="{$STORE_LOGO}" alt="{$META_TITLE}"/></a>
		{$SEARCH_FORM} {$SITE_DOCS}
		<div class="headerSelects">
			 {if isset($SKIN_SELECT)}{$SKIN_SELECT}{/if} {$LANGUAGE} {$CURRENCY}
			<div class="clear">
				&nbsp;
			</div>
		</div>
	</div>
</div>
 {$CATEGORIES}
<div id="content">
	<div class="contentLeft">
		 {$SESSION} {if isset($POPULAR_PRODUCTS)}{$POPULAR_PRODUCTS}{/if} {$SALE_ITEMS}
	</div>
	<div class="contentMid">
		<div id="breadcrumb">
			<ul>
				<li><a href="{$STORE_URL}">{$LANG.common.home}</a></li>
				 {foreach from=$CRUMBS item=crumb}
				<li><a href="{$crumb.url}">{$crumb.title}</a></li>
				 {/foreach}
			</ul>
		</div>
		 {include file='templates/box.errors.php'} {if isset($CHECKOUT_PROGRESS)}{$CHECKOUT_PROGRESS}{/if} {$PAGE_CONTENT}
	</div>
	<div class="contentRight">
		 {$SHOPPING_CART} {$MAIL_LIST} {$RANDOM_PROD}
	</div>
	<div class="clear">
		&nbsp;
	</div>
</div>
<div id="footer">
	<div class="footerContainer">
		<a href="{$STORE_URL}" class="footerLogo"><img src="{$STORE_LOGO}" alt="{$META_TITLE}"/></a>
		<div class="copyright">
			{$COPYRIGHT}
		</div>
		 {$SITE_DOCS} {if !$CONFIG.disable_mobile_skin}
		<div class="mobile">
			<a href="{$STORE_URL}/index.php?display_mobile=1">{$LANG.common.mobile_site}</a>
		</div>
		{/if}
	</div>
</div>
 {if isset($DEBUG_INFO)}{$DEBUG_INFO}{/if} {include file='js/common.html'} {if isset($JANRAIN)}{$JANRAIN}{/if} {if isset($LIVE_HELP)}{$LIVE_HELP}{/if} {foreach from=$JS_SCRIPTS key=k item=script}
<script type="text/javascript" src="{$STORE_URL}/{$script|replace:'\\':'/'}"></script>
 {/foreach} {if $COOKIE_DIALOGUE}
<form action="{$VAL_SELF}" class="cookies-notify" method="POST">
	<p>
		{$LANG.notification.cookie_dialogue|replace:'%s':{$CONFIG.store_name}}
	</p>
	<p{if $cookie_dialogue_fail} class="retry" {/if}><input type="checkbox" name="accept_cookies" value="1"/> {$LANG.notification.cookie_dialogue_declaration} <input type="submit" name="accept_cookies_submit" value="{$LANG.common.continue}" class="btn"/>
</p>
</form>
<script type="text/javascript">
  	jQuery(document).ready(function(e){
		jQuery(".cookies-notify").css("height", "0px").prependTo(jQuery("body")).animate({ height: "50px" }, 800);
	});
  </script>
 {/if}
</body>
</html>