{if isset($CTRL_VIEW) && $CTRL_VIEW}

<h2>{$NEWSLETTER.subject}</h2>
<div>{$NEWSLETTER.content_html}</div>

{else}

<h2>{$LANG.newsletter.newsletters}</h2>
  {if isset($NEWSLETTERS)}
<p>{$LANG.newsletter.view_newsletter_archive}</p>
<div id="myaccount">
  <ul>
	{foreach from=$NEWSLETTERS item=newsletter}<li><a href="{$newsletter.view}">{$newsletter.subject}</a></li>{/foreach}
  </ul>
</div>
  {else}
<p>{$LANG.newsletter.no_archived_newsletters}</p>
  {/if}

<h2>{$LANG.newsletter.subscription}</h2>
  {if $IS_USER}
	{if $SUBSCRIBED}
<p>{$LANG.newsletter.customer_is_subscribed} <a href="{$URL.unsubscribe}">{$LANG.newsletter.click_to_unsubscribe}</a></p>
	{else}
<p>{$LANG.newsletter.customer_not_subscribed} <a href="{$URL.subscribe}">{$LANG.newsletter.click_to_subscribe}</a></p>
	{/if}
  {else}
<p>{$LANG.newsletter.enter_email_subscribe_unsubscribe}</p>
<form action="{$VAL_SELF}" method="post" enctype="multipart/form-data">
  <fieldset>
	<div>
	  <label for="newsletter-email">{$LANG.common.email}</label>
	  <span><input type="text" name="subscribe" class="required" id="newsletter-email" title="{$LANG.common.email_example}" /></span>
	</div>
  </fieldset>
  <div><input name="submit" class="button_submit" type="submit" value="{$LANG.form.submit}" /></div>
  </form>
	{/if}
{/if}