<form action="{$VAL_SELF}" method="post">
  <h2>{$LANG.catalogue.gift_certificates}</h2>
  <p>{$LANG_CERT_VALUES}</p>
  <fieldset>
	<div><label for="gc-value">{$LANG.common.value}</label><span><input type="text" name="gc[value]" id="gc-value" value="{$POST.value}" class="required" /> *</span></div>
	<div>
	  <label for="gc-method">{$LANG.catalogue.delivery_method}</label>
	  <span>
		<select name="gc[method]" class="textbox required certificate-delivery" id="gc-method">
		  {if in_array($GC.delivery, array(1,3))}<option value="e">{$LANG.common.email}</option>{/if}
		  {if in_array($GC.delivery, array(2,3))}<option value="m">{$LANG.common.post}</option>{/if}
		</select>
	  </span>
	</div>
	<div><label for="gc-name">{$LANG.catalogue.recipient_name}</label><span><input type="text" name="gc[name]" id="gc-name" value="{$POST.name}" class="required" /> *</span></div>
	{if in_array($GC.delivery, array(1,3))}
	<div id="gc-method-e"><label for="gc-email">{$LANG.catalogue.recipient_email}</label><span><input type="text" name="gc[email]" id="gc-email" value="{$POST.email}" /></span></div>
	{/if}
	<div><label for="gc-message">{$LANG.common.message} {$LANG.common.optional}</label><span><textarea name="gc[message]" id="gc-message" class="textbox">{$POST.message}</textarea></span></div>
  </fieldset>
  {if $ctrl_allow_purchase}
  <div><input type="submit" class="button_default" name="Submit" value="{$LANG.catalogue.add_to_basket}" /></div>
  {/if}
  </form>