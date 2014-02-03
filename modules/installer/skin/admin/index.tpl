<form action="{$VAL_SELF}" method="post" enctype="multipart/form-data" class="installerForm">
  <div id="CubeCart_Module_Installer" class="tab_content">
	<h3>{$LANG.installer.title}</h3>
  <!-- BEGIN: prepare -->
	<fieldset><legend>Package Details</legend>
	  <h3>{$MODULE.name}</h3>
	  <div><strong>Version: {$MODULE.version}</strong> - <a href="{$MODULE.homepage}" target="_blank">{$MODULE.creator}</a></div>
	  <div><strong>Requires</strong>: CubeCart {$MODULE.minVersion} &lt; {$MODULE.maxVersion}</div>
	  <br />
	  <p><strong>{$LANG.description}</strong><br />{$MODULE.description}</p>
	</fieldset>
	<p>{message}</p>
  <!-- END: prepare -->
  <!-- BEGIN: form -->
	<div id="contentPad">
	  <p>{$LANG.installer.install_info}</p>
	  <br />
	  <div><input type="file" name="upload" id="moduleUpload" class="textbox" /></div>
	</div>
  <!-- END: form -->
  </div>
  <div>
  <!-- BEGIN: action -->
	<input type="submit" name="{BUTTON.name}" value="{$LANG.form.submit}" class="submit" />
  <!-- END: action -->
  <!-- BEGIN: cancel -->
	<input type="submit" name="cancel" value="{$LANG.common.cancel}" class="submit" />
  <!-- END: cancel -->
  </div>
  <input type="hidden" name="token" value="{$SESSION_TOKEN}" />
</form>