<?php
/**
 * CubeCart v5
 * ========================================
 * CubeCart is a registered trade mark of Devellion Limited
 * Copyright Devellion Limited 2010. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:			http://www.cubecart.com
 * Email:		sales@devellion.com
 * License:		http://www.cubecart.com/v5-software-license
 * ========================================
 * CubeCart is NOT Open Source.
 * Unauthorized reproduction is not allowed.
 */
/**
 * Statistics
 *
 * @author Andreea Costea
 * @version 1.1.0
 * @since 5.0.0
 */
class Statistics {

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	/**
	 * Setup the instance (singleton)
	 *
	 * @return Statistics
	 */
	public static function getInstance() {
      	  if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
       	  }
          return self::$_instance;
	}

	public function getPrevLogin($email, $customer_id){
		$query = "SELECT `time`, `ip_address` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_access_log` WHERE `username`= '".$email."' AND `user_id` =".$customer_id." ORDER BY `time` DESC LIMIT 1";
		/*select time, ip_address, username, user_id  from cubecartCubeCart_access_log where username="student@student.com" order by time desc limit 1
*/
		$res = $GLOBALS['db']->query($query);
		$ret = array ('prev_login_date' => date('d/m/Y H:i:s', $res[0]['time']),
			      'prev_login_ip'   => $res[0][ip_address],
			      'prev_login_browser' => 3,);
		return $ret;
	}

	public function getLastTransaction($email, $customer_id){
		$query = "SELECT `time` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_transactions` WHERE `customer_id`= ".$customer_id." ORDER BY `time` DESC LIMIT 1";
		/*select time, ip_address, username, user_id  from cubecartCubeCart_access_log where username="student@student.com" order by time desc limit 1
*/
		$res = $GLOBALS['db']->query($query);
		$ret = array ('prev_transaction' => date('d/m/Y H:i:s', $res[0]['time']),); //check for no trans
		return $ret;
	}

	public function getOnlineUsers(){
		/*select count(*) from cubecartCubeCart_sessions;*/

		$query = "SELECT count(*) as `ct` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_sessions` ";
		$res = $GLOBALS['db']->query($query);
		$ret = array ('online_users' => $res[0]['ct'],);
		return $ret;
	}
		
}
