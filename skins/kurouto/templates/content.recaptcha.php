{if $RECAPTCHA}
<fieldset id="recaptcha-title">
  <legend>{$LANG.form.verify_human}</legend>
  <script type="text/javascript">
   var RecaptchaOptions = {
      theme : 'clean'
   };
  </script>
  {$DISPLAY_RECAPTCHA}
</fieldset>
{/if}