<?php
if(!defined('CC_DS')) die('Access Denied');
if ($GLOBALS['config']->get('Janrain', 'status') && !$GLOBALS['config']->isEmpty('Janrain', 'rpx_api_key') && !$GLOBALS['config']->isEmpty('Janrain', 'rpx_app_domain')) {

	$GLOBALS['language']->loadDefinitions('janrain', CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'Janrain'.CC_DS.'language', 'module.definitions.xml');
	$lang = $GLOBALS['language']->getStrings('janrain');

	if (isset($_POST['token'])) {
		require CC_ROOT_DIR.CC_DS.'modules'.CC_DS.'plugins'.CC_DS.'Janrain'.CC_DS.'library'.CC_DS.'engage.lib.php';
		$response = engage_auth_info($GLOBALS['config']->get('Janrain', 'rpx_api_key'), $_POST['token']);
		$response = json_decode($response, true);
		if($engage_errors = engage_get_errors()) {
			foreach($engage_errors as $engage_error => $engage_nonsense) {
				trigger_error($engage_error, E_USER_WARNING);
			}
		}
		if ($response['stat'] == 'ok') {
			// find and authenticate
			if (!$GLOBALS['db']->select('CubeCart_openid', array('customer_id', 'identity_id'), array('identity_url' => $response['profile']['identifier']))) {
				//�Create a new account
				$data	= array(
					'title'			=> $response['profile']['name']['honorificPrefix'],
					'first_name'	=> $response['profile']['name']['givenName'],
					'last_name'		=> $response['profile']['name']['familyName'],
					'email'			=> $response['profile']['email'],
					'phone'			=> $response['profile']['phoneNumber'],
					'registered'	=> time(),
					'ip_address'	=> get_ip_address()
				);
				// Remove empty data
				foreach ($data as $key => $value) {
					if (empty($value)) {
						unset($data[$key]);
					}
				}
				if (!isset($data['email'])) {
					$data['email'] = $_POST['token'];
				}
				if($GLOBALS['db']->select('CubeCart_customer', 'customer_id', array('email' => $response['profile']['email']))) {
					$GLOBALS['db']->update('CubeCart_customer', $data, array('email' => $response['profile']['email']));
				} else {
					$GLOBALS['db']->insert('CubeCart_customer', $data);
					$customer_id = $GLOBALS['db']->insertid();
				}

				if (!$GLOBALS['db']->select('CubeCart_openid', 'identity_id', array('identity_url' => $response['profile']['identifier']))) {
					$GLOBALS['db']->insert('CubeCart_openid', array('customer_id' => $customer_id, 'identity_url' => $response['profile']['identifier'], 'identity_type' => $response['profile']['providerName']));
				}
			}
			// Log them in
			if (!empty($response['profile']['identifier'])) {
				if (($select = $GLOBALS['db']->select('CubeCart_openid', array('customer_id'), array('identity_url' => $response['profile']['identifier']), false, 1)) !== false) {
					$GLOBALS['db']->update('CubeCart_sessions', array('customer_id' => $select[0]['customer_id']), array('session_id' => $GLOBALS['session']->getId()), false);
					// Load user data
					$GLOBALS['user']->load();
					$append	= ($GLOBALS['session']->isEmpty('contents','basket')) ? array('_a' => 'account') : array('_a' => 'basket');
					httpredir(currentPage(null, $append));
				}
			}
		} else {
			$GLOBALS['gui']->setError($response['err']['msg']);
			httpredir(currentPage());
		}
	}
	$GLOBALS['gui']->changeTemplateDir(str_replace('hooks','skin',dirname(__FILE__)));
	$GLOBALS['smarty']->assign('LANG_LOGIN',($_GET['_a']=='register') ? $lang['rpx_register'] : $lang['rpx_login']);
	$GLOBALS['smarty']->assign('RPX_APP_DOMAIN',$GLOBALS['config']->get('Janrain', 'rpx_app_domain'));
	$file_name = 'login.tpl';
	$form_file = str_replace('hooks/','',$GLOBALS['gui']->getCustomModuleSkin('plugins', dirname(__FILE__), $file_name));
	$GLOBALS['gui']->changeTemplateDir($form_file);
	$login_html[] = $GLOBALS['smarty']->fetch($file_name);
	$GLOBALS['gui']->changeTemplateDir();
}