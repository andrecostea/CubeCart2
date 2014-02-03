/* Custom JavaScript for default template */
/* Acordion menu (only opens, doesn't collapse) */
$('#menu.accordion a ~ ul').each(function(){
	$(this).siblings('a:first').addClass('menu_closed').hover(function(){
		$(this).addClass('menu_open').siblings('ul').slideDown();
	});
});
/* Registration toggle */
if ($('input#show-reg:checkbox').is(':checked') == false) $('fieldset#account-reg').hide();
$('input#show-reg:checkbox').change(function(){
	if ($(this).is(':checked')) {
		$('fieldset#account-reg').show();
		$('input#reg_password').addClass('required');
		$('input#reg_passconf').addClass('required');
	} else {
		$('fieldset#account-reg').hide();
		$('input#reg_password').removeClass('required');
		$('input#reg_passconf').removeClass('required');
	}
});

/* Delivery toggle */
if ($('#delivery_is_billing:checkbox').is(':checked') == true) $('fieldset#address_delivery').hide();
$('#delivery_is_billing:checkbox').change(function(){
	if ($(this).is(':checked')) {
		$('fieldset#address_delivery').hide();
	} else {
		$('fieldset#address_delivery').show();
	}
});

/* Do some clever gateway selection styling and hide the radio buttons */
$('#gateways>p').each(function(){
	if ($(this).children('input:radio:checked').length == 1) $(this).addClass('gateway-selected');
	$(this).children('input:radio').bind('change', function(){
		$('#gateways>p').removeClass('gateway-selected');
		$(this).parent('p:first').addClass('gateway-selected');
	}); //.hide();
});
