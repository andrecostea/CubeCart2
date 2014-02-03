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

/* Dropdown menu */
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

function account_dd_open(){	
	account_dd_canceltimer();
	account_dd_close();
	ddmenuitem = $(this).find('ul').eq(0).css('visibility', 'visible');
}

function account_dd_close(){	
	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');
}

function account_dd_timer(){
	closetimer = window.setTimeout(account_dd_close, timeout);
}

function account_dd_canceltimer(){	
	if(closetimer){	
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

$(document).ready(function(){
	$('.jquery_dd > li').bind('mouseover', account_dd_open);
	$('.jquery_dd > li').bind('mouseout',  account_dd_timer);
});
document.onclick = account_dd_close;