<script type='text/javascript' src='{$AMAZON.widgetURL}'>
</script>
<div id="AmazonInlineWidget" align="right"><img src="https://{$AMAZON.redirectDomain}/gp/cba/button?cartOwnerId={$AMAZON.merchId}&size={$AMAZON.buttonSize}&color={$AMAZON.buttonColor}&background={$AMAZON.buttonBg}&type=inlineCheckout" style="cursor: pointer;"/></div>

<script type='text/javascript' >
	new CBA.Widgets.InlineCheckoutWidget({
	    merchantId: '{$AMAZON.merchId}',
	    onAuthorize: function(widget) {
                window.location = '{$AMAZON.returnURL}&purchaseContractId=' + widget.getPurchaseContractId() ;	
            }
        }).render("AmazonInlineWidget");
</script>