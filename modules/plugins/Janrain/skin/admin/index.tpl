<form action="{$VAL_SELF}" method="post" enctype="multipart/form-data">
  <div id="Janrain" class="tab_content">
	<h3>{$LANG.janrain.module_title}</h3>
	  <fieldset><legend>{$LANG.module.config_settings}</legend>
	<div><label for="status">{$LANG.janrain.openid_allow}</label><span><select name="module[status]" id="status" class="textbox">
	  <option value="0" {$SELECT_status_0}>{$LANG.common.disabled}</option>
	  <option value="1" {$SELECT_status_1}>{$LANG.common.enabled}</option>
	</select> <a href="http://www.janrain.com/products/engage" target="_blank">{$LANG.janrain.rpx_what}</a></span></div>
	<div><label for="rpx_app_domain">{$LANG.janrain.rpx_application}</label><span><input name="module[rpx_app_domain]" id="rpx_app_domain" type="text" class="textbox" value="{$MODULE.rpx_app_domain}" /> {$LANG.janrain.rpx_application_example}</span></div>
	<div><label for="rpx_api_key">{$LANG.janrain.rpx_api_key}</label><span><input name="module[rpx_api_key]" id="rpx_api_key" type="text" class="textbox" value="{$MODULE.rpx_api_key}" /></span></div>
  </fieldset>
  </div>
  {$MODULE_ZONES}
  <div class="form_control">
	<input type="submit" value="{$LANG.common.save}" />
  </div>
  <input type="hidden" name="token" value="{$SESSION_TOKEN}" />
</form>