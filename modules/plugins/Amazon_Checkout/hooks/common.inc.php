<?php
if(isset($_GET['purchaseContractId']) && !empty($_GET['purchaseContractId'])) {
	if($_GET['purchaseContractId']=='null') {
		$GLOBALS['session']->delete('purchaseContractId', 'amazon');
	} else {
		$GLOBALS['session']->set('purchaseContractId', $_GET['purchaseContractId'], 'amazon');
	}
	httpredir('index.php?_a=basket');
}

$purchaseContractId = $GLOBALS['session']->get('purchaseContractId', 'amazon');
if(!empty($purchaseContractId)) {
	define(PURCHASE_CONTRACT_ID,$purchaseContractId);
}
?>