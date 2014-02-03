<div id="paypal_pro" class="tab_content">
  <h3>{$LANG.paypal_pro.module_title}</h3>
  <fieldset>
	{if isset($DISPLAY_TRANSACTION)}
	<?php if (isset($list_transaction)): ?>
	<div>
	  <label for="transaction_id">{$LANG.paypal_pro.title_transaction_select}</label>
	  <span>
		<select name="wpp[transaction]" id="transaction_id" class="selector">
		  <option value="">{$LANG.paypal_pro.transaction_select}</option>
		  <?php foreach ($list_transaction as $trans): ?><option value="<?php echo $trans['transaction']['id']; ?>"><?php echo $trans['transaction']['trans_id']; ?> (<?php echo $trans['transaction']['status']; ?>)</option><?php endforeach; ?>
		</select>
	  </span>
	</div>
	<script type="text/javascript">
	var transactions = {JSON_TRANSACTIONS}
	</script>
	<?php endif; ?>
	<div id="methods">
	  <label>{$LANG.paypal_pro.method}</label>
	  <span>
		<span><input type="radio" name="wpp[method]" class="contentswitch" value="Auth" /> {$LANG.paypal_pro.method_auth}</span>
		<span><input type="radio" name="wpp[method]" class="contentswitch" value="Capture" /> {$LANG.paypal_pro.method_capture}</span>
		<span><input type="radio" name="wpp[method]" class="contentswitch" value="Void" /> {$LANG.paypal_pro.method_void}</span>
		<span><input type="radio" name="wpp[method]" class="contentswitch" value="Refund" /> {$LANG.paypal_pro.method_refund}</span>
	  </span>
	</div>
  </fieldset>
  
  <fieldset id="Capture" class="contentswitch"><legend>{$LANG.paypal_pro.title_capture}</legend>
	<div><label>{$LANG.paypal_pro.funds_oustanding}</label><span><input class="transaction-amount textbox number" disabled="disabled" /></span></div>
	<div><label for="capture-amount">{$LANG.paypal_pro.capture_amount}</label><span><input type="text" id="capture-amount" name="wpp[capture][amount]" value="" class="textbox number" /></span></div>
	<div>
	  <label for="capture-type">{$LANG.paypal_pro.capture_final}</label>
	  <span><select name="wpp[capture][completetype]" id="capture-type">
		<option value="0">{$LANG.paypal_pro.capture_final_no}</option>
		<option value="1">{$LANG.paypal_pro.capture_final_yes}</option>
	  </select></span>
	</div>
	<div>
	  <label for="capture-note">{$LANG.common.notes}</label>
	  <span><textarea name="wpp[capture][note]" id="capture-note" class="textbox"></textarea>
	  </span>
	</div>
  </fieldset>
  
  <fieldset id="Refund" class="contentswitch"><legend>{$LANG.paypal_pro.method_refund}</legend>
	<div><label>{$LANG.paypal_pro.funds_captured}</label><span><input class="transaction-amount textbox number" disabled="disabled" /></span></div>
	<div><label for="refund-amount">{$LANG.paypal_pro.refund_amount}</label><span><input type="text" id="refund-amount" name="wpp[refund][amount]" class="textbox number" /></span></div>
	<!-- div>
	  <label for="complete-type">Refund Type</label>
	  <span><select name="wpp[refund][refundtype]" id="complete-type">
		<option value="0">Full Refund</option>
		<option value="1">Partial Refund</option>
	  </select></span>
	</div -->
	<div>
	  <label for="refund-note">{$LANG.common.notes}</label>
	  <span><textarea name="wpp[refund][note]" id="refund-note" class="textbox"></textarea>
	  </span>
	</div>
  </fieldset>
  
  <fieldset id="Void" class="contentswitch"><legend>{$LANG.paypal_pro.method_void}</legend>
	<div>
	  <label for="void-note">{$LANG.common.notes}</label>
	  <span><textarea name="wpp[void][note]" id="void-note" class="textbox"></textarea>
	  </span>
	</div>
  </fieldset>
  <fieldset id="Auth" class="contentswitch"><legend>{$LANG.paypal_pro.method_auth}</legend>
	{$LANG.paypal_pro.reauthorize}
  </fieldset>
</div>
