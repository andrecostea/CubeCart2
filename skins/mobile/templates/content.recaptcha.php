{if $RECAPTCHA}
  <label style="margin-bottom:5px;text-align:center;display:block;"><strong>{$LANG.form.verify_human}</strong></label>
  <script type="text/javascript">
   var RecaptchaOptions = {
      theme : 'white'
   };
  </script>
  <div style="width:318px;margin:0 auto">{$DISPLAY_RECAPTCHA}</div>

{/if}