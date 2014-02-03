<?php
if(!defined('CC_DS')) die('Access Denied');
/* !OpenID management */
if (!$GLOBALS['user']->is()) {
	httpredir('?_a=login');
}

$GLOBALS['gui']->addBreadcrumb($GLOBALS['language']->account['your_account'], 'index.php?_a=account');

$GLOBALS['language']->loadDefinitions('janrain', CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'Janrain'.CC_DS.'language', 'module.definitions.xml');
$lang = $GLOBALS['language']->getStrings('janrain');

$GLOBALS['gui']->addBreadcrumb($lang['your_account'], 'index.php?_a=account');
$GLOBALS['gui']->addBreadcrumb($lang['your_openid'], currentPage());
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
	if ($GLOBALS['db']->delete('CubeCart_openid', array('customer_id' => $GLOBALS['user']->getId(), 'identity_id' => (int)$_GET['delete']))) {
		$GLOBALS['gui']->setNotify($lang['notify_delete_openid']);
	} else {
		$GLOBALS['gui']->setError($lang['error_delete_openid']);
	}
	httpredir('index.php?_a=plugin&plugin=Janrain');
}

if ($GLOBALS['config']->get('Janrain', 'status') && !$GLOBALS['config']->isEmpty('Janrain', 'rpx_api_key') && !$GLOBALS['config']->isEmpty('Janrain', 'rpx_app_domain') && isset($_POST['token'])) {
	require CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'Janrain'.CC_DS.'library'.CC_DS.'engage.lib.php';
	$response = engage_auth_info($GLOBALS['config']->get('Janrain', 'rpx_api_key'), $_POST['token']);
	$response = json_decode($response, true);
	if (!$GLOBALS['db']->select('CubeCart_openid', array('customer_id', 'identity_id'), array('identity_url' => $response['profile']['identifier']))) {
		//Create a new account
		$GLOBALS['db']->insert('CubeCart_openid', array('customer_id' => $GLOBALS['user']->getId(), 'identity_url' => $response['profile']['identifier'], 'identity_type' => $response['profile']['providerName']));
		$GLOBALS['gui']->setNotify($lang['notify_add_openid']);
	} else {
		$GLOBALS['gui']->setError($lang['error_add_openid']);
	}
	httpredir('index.php?_a=plugin&plugin=Janrain');
}
// Manage OpenIDs
$openid_list = $GLOBALS['db']->select('CubeCart_openid', false, array('customer_id' => $GLOBALS['user']->getId()));
if ($openid_list) {
	foreach ($openid_list as $openid) {
		$openid['delete'] = currentPage(null, array('delete' => $openid['identity_id']));
		$vars['identities'][] = $openid;
	}
	$GLOBALS['smarty']->assign('IDENTITIES', $vars['identities']);
} else {
	$GLOBALS['smarty']->assign('IDENTITIES', false);
}
$GLOBALS['gui']->changeTemplateDir(str_replace('hooks','skin',dirname(__FILE__)));
$GLOBALS['smarty']->assign('RPX_APP_DOMAIN',$GLOBALS['config']->get('Janrain', 'rpx_app_domain'));
$GLOBALS['smarty']->assign('MODULE_LANG',$lang);
$file_name = 'manage.tpl';
$form_file = str_replace('hooks/','',$GLOBALS['gui']->getCustomModuleSkin('plugins', dirname(__FILE__), $file_name));
$GLOBALS['gui']->changeTemplateDir($form_file);
$content = $GLOBALS['smarty']->fetch($file_name);
$GLOBALS['smarty']->assign('PAGE_CONTENT', $content);
$GLOBALS['gui']->changeTemplateDir();