<h2>{$LANG.documents.document_contact}</h2>

<p>{$CONTACT.description}</p>

<form action="{$VAL_SELF}" method="post">
  <fieldset>
	<div><label for="contact_name">{$LANG.common.name}</label><span><input type="text" name="contact[name]" id="contact_name" value="{$MESSAGE.name}" class="textbox required" /></span></div>
	<div><label for="contact_email">{$LANG.common.email}</label><span><input type="text" name="contact[email]" id="contact_email" value="{$MESSAGE.email}" class="textbox required" /></span></div>
	{if isset($DEPARTMENTS)}
	<div><label for="contact_dept">{$LANG.common.department}</label>
	  <span><select name="contact[dept]" id="contact_dept" class="textbox required">
		<option value="">{$LANG.form.please_select}</option>
		{foreach from=$DEPARTMENTS item=dept}
		<option value="{$dept.key}"{$dept.selected}>{$dept.name}</option>
		{/foreach}
	  </select></span>
	</div>
	{/if}
	<div><label for="contact_subject">{$LANG.common.subject}</label><span><input type="text" name="contact[subject]" id="contact_subject" value="{$MESSAGE.subject}" class="textbox required" /></span></div>
	<div><label for="contact_enquiry">{$LANG.common.enquiry}</label><span><textarea name="contact[enquiry]" id="contact_enquiry" class="textbox required" cols="40" rows="7">{$MESSAGE.enquiry}</textarea></span></div>
	{include file='templates/content.recaptcha.php'}
  </fieldset>
  <div><input type="submit" class="button_submit" value="{$LANG.documents.send_message}" /></div>
  </form>