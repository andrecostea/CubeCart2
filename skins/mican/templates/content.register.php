<h2>{$LANG.account.create_account}</h2>
<p>{$LANG.account.register_text}</p>
<form action="{$VAL_SELF}" method="post" name="registration">
  <fieldset>
	  {foreach from=$LOGIN_HTML item=html}
	    {$html}
	  {/foreach}
	<div><label for="register-title">{$LANG.user.title}</label><span><input type="text" name="title" id="register-title" value="{$DATA.title}" class="" /></span></div>
	<div><label for="register-firstname">{$LANG.user.name_first}</label><span><input type="text" name="first_name" id="register-firstname" value="{$DATA.first_name}" class="required" /> *</span></div>
	<div><label for="register-lastname">{$LANG.user.name_last}</label><span><input type="text" name="last_name" id="register-lastname" value="{$DATA.last_name}" class="required" /> *</span></div>
	<div><label for="register-email">{$LANG.common.email}</label><span><input type="text" name="email" id="register-email" value="{$DATA.email}" class="required" /> *</span></div>
	<div><label for="register-phone">{$LANG.address.phone}</label><span><input type="text" name="phone" id="register-phone" class="textbox required" value="{$DATA.phone}" /> *</span></div>
	<div><label for="register-mobile">{$LANG.address.mobile}</label><span><input type="text" name="mobile" id="register-mobile" class="textbox" value="{$DATA.mobile}" /></span></div>

	<div><label for="register-password">{$LANG.account.password}</label><span><input type="password" autocomplete="off" name="password" id="register-password" value="" class="required" /> *</span></div>
	<div><label for="register-passconf">{$LANG.account.password_confirm}</label><span><input type="password" autocomplete="off" name="passconf" id="register-passconf" value="" class="required" /> *</span></div>

	{include file='templates/content.recaptcha.php'}

	{if $TERMS_CONDITIONS}
	<div><label for="register-terms">&nbsp;</label><span><input type="checkbox" id="register-terms" name="terms_agree" value="1" {$TERMS_CONDITIONS_CHECKED} /> <a href="{$TERMS_CONDITIONS}" target="_blank">{$LANG.account.register_terms_agree}</a></span></div>
	{/if}
	<div><label for="register-mailing">&nbsp;</label><span><input type="checkbox" id="register-mailing" name="mailing_list" value="1" {if isset($DATA.mailing_list) && $DATA.mailing_list == 1}checked="checked"{/if} />{$LANG.account.register_mailing}</a></span></div>
  </fieldset>
  <div><input type="submit" name="register" value="{$LANG.account.register}" class="button_default" /></div>
</form>