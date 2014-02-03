<div class="box" id="newsletter">
	<h3>{$LANG.newsletter.mailing_list}</h3>
	 {if $IS_USER} {if ($CTRL_SUBSCRIBED)}
	<p>
		{$LANG.newsletter.customer_is_subscribed}<br/><a href="{$STORE_URL}/index.php?_a=newsletter&amp;action=unsubscribe">{$LANG.newsletter.click_to_unsubscribe}</a>
	</p>
	 {else}
	<p>
		{$LANG.newsletter.customer_not_subscribed}<br/><a href="{$STORE_URL}/index.php?_a=newsletter&amp;action=subscribe">{$LANG.newsletter.click_to_subscribe}</a>
	</p>
	 {/if} {else}
	<form action="{$VAL_SELF}" method="post">
		<p>
			{$LANG.newsletter.enter_email_signup}
		</p>
		<input name="subscribe" type="text" class="textbox required" size="18" maxlength="250" title="{$LANG.common.email}"/>
		<p>
			<input type="submit" class="btn" value="{$LANG.newsletter.subscribe_now}"/>
		</p>
	</form>
	 {/if}
</div>