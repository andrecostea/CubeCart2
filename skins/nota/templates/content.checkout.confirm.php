{if $IS_USER}
	<div class="title_swipe"><h2>
	<span class="inline"><a href="{$STORE_URL}/index.php?_a=addressbook&amp;action=edit&amp;address_id={$DATA.address_id}&amp;redir=confirm">{$LANG.address.address_edit}</a></span>
	{if $CTRL_DELIVERY}{$LANG.address.billing_address}{else}{$LANG.address.billing_delivery_address}{/if}</h2></div>
	<p>
	  {$DATA.title} {$DATA.first_name} {$DATA.last_name}<br />
	  {if $DATA.company_name}{$DATA.company_name}<br />{/if}
	  {$DATA.line1}<br />
	  {if $DATA.line2}{$DATA.line2}<br />{/if}
	  {$DATA.town}<br />
	  {$DATA.state}, {$DATA.postcode}<br />
	  {$DATA.country}<br />
	</p>
	{if $CTRL_DELIVERY}
	<div class="title_swipe"><h2>{$LANG.address.delivery_address}
	<span class="inline"><a href="{$STORE_URL}/index.php?_a=addressbook&amp;action=add&amp;redir=confirm">{$LANG.address.address_add}</a></span>
	</h2></div>
	<p>

	  <select name="delivery_address" id="delivery_address" class="update_form" style="border: 1px solid #222222; width: 400px;">
	  	{foreach from=$ADDRESSES item=address}
		<option value="{$address.address_id}" {$address.selected}>{$address.description} - {$address.first_name} {$address.last_name}, {$address.line1}, {$address.postcode}</option>
		{/foreach}
	  </select>
	</p>
	{/if}
{else}

	<div id="register">
	  <p>{$LANG.account.already_registered} <a href="{$URL.login}">{$LANG.account.log_in}</a></p>
	  <h2>{$LANG.account.your_details}</h2>
	  <fieldset><legend>{$LANG.account.contact_details}</legend>
		<div><label for="user_title">{$LANG.user.title}</label><span><input type="text" name="user[title]" id="user_title" class="textbox capitalize" value="{$USER.title}" /></span></div>
		<div><label for="user_first">{$LANG.user.name_first}</label><span><input type="text" name="user[first_name]" id="user_first" class="textbox capitalize required" value="{$USER.first_name}" /> *</span></div>
		<div><label for="user_last">{$LANG.user.name_last}</label><span><input type="text" name="user[last_name]" id="user_last" class="textbox capitalize required" value="{$USER.last_name}" /> *</span></div>
		<div><label for="user_email">{$LANG.common.email}</label><span><input type="text" name="user[email]" id="user_email" class="textbox required" value="{$USER.email}" /> *</span></div>
		<div><label for="user_phone">{$LANG.address.phone}</label><span><input type="text" name="user[phone]" id="user_phone" class="textbox required" value="{$USER.phone}" /> *</span></div>
		<div><label for="user_mobile">{$LANG.address.mobile}</label><span><input type="text" name="user[mobile]" id="user_mobile" class="textbox" value="{$USER.mobile}" /></span></div>
	  </fieldset>

	  <fieldset id="address_billing"><legend>{$LANG.address.billing_address}{if !$ALLOW_DELIVERY_ADDRESS} {$LANG.address.ship_to_billing_only}{/if}</legend>
		<div><label for="addr_company">{$LANG.address.company_name}</label><span><input type="text" name="billing[company_name]" id="addr_company" class="textbox" value="{$BILLING.company_name}" /></span></div>
		<div><label for="addr_line1">{$LANG.address.line1}</label><span><input type="text" name="billing[line1]" id="addr_line1" class="textbox required" value="{$BILLING.line1}" /> *</span></div>
		<div><label for="addr_line2">{$LANG.address.line2}</label><span><input type="text" name="billing[line2]" id="addr_line2" class="textbox" value="{$BILLING.line2}" /></span></div>
		<div><label for="addr_town">{$LANG.address.town}</label><span><input type="text" name="billing[town]" id="addr_town" class="textbox required" value="{$BILLING.town}" /> *</span></div>
		<div><label for="addr_postcode">{$LANG.address.postcode}</label><span><input type="text" name="billing[postcode]" id="addr_postcode" class="textbox uppercase required" value="{$BILLING.postcode}" /> *</span></div>
		<div><label for="country-list">{$LANG.address.country}</label><span>
		  <select name="billing[country]" class="textbox" id="country-list">
			{foreach from=$COUNTRIES item=country}
			<option value="{$country.numcode}" {$country.selected}>{$country.name}</option>
			{/foreach}
		  </select> *</span></div>
		<div><label for="state-list">{$LANG.address.state}</label></span><input type="text" name="billing[state]" id="state-list" class="textbox required" value="{$BILLING.state}" /> *</span></div>
		{if $TERMS_CONDITIONS}
		<div><label for="reg_terms">&nbsp;</label><span><input type="checkbox" id="reg_terms" name="terms_agree" value="1" {$TERMS_CONDITIONS_CHECKED} /> <a href="{$TERMS_CONDITIONS}" target="_blank">{$LANG.account.register_terms_agree}</a></span></div>
		{/if}
		{if $ALLOW_DELIVERY_ADDRESS}<div><label>&nbsp;</label><span><input type="checkbox" name="delivery_is_billing" id="delivery_is_billing" {$DELIVERY_CHECKED} /> {$LANG.address.delivery_is_billing}</span></div>{/if}
	  </fieldset>

	  {if $ALLOW_DELIVERY_ADDRESS}
	  <fieldset id="address_delivery"><legend>{$LANG.address.delivery_address}</legend>
		<div><label for="del_title">{$LANG.user.title}</label><span><input type="text" name="delivery[title]" id="del_title" class="textbox capitalize" value="{$DELIVERY.title}" /></span></div>
		<div><label for="del_first">{$LANG.user.name_first}</label><span><input type="text" name="delivery[first_name]" id="del_first" class="textbox capitalize required" value="{$DELIVERY.first_name}" /> *</span></div>
		<div><label for="del_last">{$LANG.user.name_last}</label><span><input type="text" name="delivery[last_name]" id="del_last" class="textbox capitalize required" value="{$DELIVERY.last_name}" /> *</span></div>
		<div><label for="del_company">{$LANG.address.company_name}</label><span><input type="text" name="delivery[company_name]" id="del_company" class="textbox" value="{$DELIVERY.company_name}" /></span></div>
		<div><label for="del_line1">{$LANG.address.line1}</label><span><input type="text" name="delivery[line1]" id="del_line1" class="textbox required" value="{$DELIVERY.line1}" /> *</span></div>
		<div><label for="del_line2">{$LANG.address.line2}</label><span><input type="text" name="delivery[line2]" id="del_line2" class="textbox" value="{$DELIVERY.line2}" /></span></div>
		<div><label for="del_town">{$LANG.address.town}</label><span><input type="text" name="delivery[town]" id="del_town" class="textbox required" value="{$DELIVERY.town}" /> *</span></div>
		<div><label for="del_postcode">{$LANG.address.postcode}</label><span><input type="text" name="delivery[postcode]" id="del_postcode" class="textbox uppercase required" value="{$DELIVERY.postcode}" /> *</span></div>
		<div><label for="delivery_country">{$LANG.address.country}</label><span>
		  <select name="delivery[country]" id="delivery_country" class="textbox country-list" rel="delivery_state">
			{foreach from=$COUNTRIES item=country}
			<option value="{$country.numcode}" {$country.selected_d}>{$country.name}</option>
			{/foreach}
		  </select> *</span></div>
		<div><label for="delivery_state">{$LANG.address.state}</label></span><input type="text" name="delivery[state]" id="delivery_state" class="textbox required" value="{$DELIVERY.state}" /> *</span></div>
	  </fieldset>
	  {/if}
	  <script type="text/javascript">
		var county_list = {$STATE_JSON};
	  </script>

	  <div class="select_register"><input type="checkbox" name="register" id="show-reg" value="1" class="" {$REGISTER_CHECKED} /> <label for="show-reg">{$LANG.account.create_account}</label></div>

	  <fieldset id="account-reg"><legend>{$LANG.account.password}</legend>
		<div><label for="reg_password">{$LANG.user.password_new}</label></span><input type="password" autocomplete="off" name="password" id="reg_password" class="textbox required" value="" /> *</span></div>
		<div><label for="reg_passconf">{$LANG.user.password_confirm}</label></span><input type="password" autocomplete="off" name="passconf" id="reg_passconf" class="textbox required" value="" /> *</span></div>
	  </fieldset>
	  {include file='templates/content.recaptcha.php'}
	</div>
{/if}

<p><label for="delivery_comments" class="return"><strong>{$LANG.basket.your_comments}</strong></label><textarea name="comments" id="delivery_comments">{$VAL_CUSTOMER_COMMENTS}</textarea></p>