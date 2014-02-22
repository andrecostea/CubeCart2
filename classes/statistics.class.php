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

include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_pie.php");

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
		$query = "SELECT `time`, `ip_address` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_access_log` WHERE `username`= '".$email."' AND `user_id` =".$customer_id." ORDER BY `time` DESC LIMIT 2";
		/*select time, ip_address, username, user_id  from cubecartCubeCart_access_log where username="student@student.com" order by time desc limit 1
*/
		$res = $GLOBALS['db']->query($query);
		$ret = array ('prev_login_date' => ($res[1]!== null ? date('d/m/Y H:i:s', $res[1]['time']) : 'N.A.'),
			      'prev_login_ip'   => ($res[1]!== null ? ($res[1]['ip_address']) : 'N.A.'),
			      'prev_login_browser' => 3,);
		return $ret;
	}

	public function getLastTransaction($customer_id){
		$query = "SELECT `time` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_transactions` WHERE `customer_id`= ".$customer_id." ORDER BY `time` DESC LIMIT 1";
		/*select time from cubecartCubeCart_transactions where customer_id=.. order by time desc limit 1;
*/
		$res = $GLOBALS['db']->query($query);
		$ret = array ('prev_transaction' => ($res[0] !== null ? date('d/m/Y H:i:s', $res[0]['time']) : 'N.A.'),); //check for no trans
		return $ret;
	}


	public function getUsersCountryX($customer_id){
		/* select count(distinct customer_id) as cnt, C.name from (select distinct country from cubecartCubeCart_addressbook where customer_id = 39) as A, cubecartCubeCart_addressbook as B, cubecartCubeCart_geo_country as C where A.country=B.country and customer_id!=39 and A.country=C.numcode group by A.country;*/
		$A=$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_addressbook";
		$C=$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_geo_country";
		$query = "SELECT COUNT(DISTINCT `customer_id`) as `cnt`, `C`.`name` FROM (SELECT DISTINCT `country` FROM `".$A."` WHERE `customer_id` = ".$customer_id.") as `A`, `".$A."` as `B`, `".$C."` as C WHERE `A`.`country`=`B`.`country` AND `customer_id` != ".$customer_id." and `A`.`country`=`C`.`numcode` GROUP BY `A`.`country`";
		$res = $GLOBALS['db']->query($query);
		$ret_str = '';
		foreach ($res as $r)
			$ret_str = $ret_str.$r['name'].': '.$r['cnt'].' / ';
		$ret = array ('users_from_same_country'  =>  $ret_str);
		return $ret;
	}


	public function getOnlineUsers(){
		/*select count(*) from cubecartCubeCart_sessions;*/

		$query = "SELECT count(*) as `ct` FROM `".$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_sessions` ";
		$res = $GLOBALS['db']->query($query);
		$ret = array ('online_users' => $res[0]['ct'],);
		return $ret;
	}

	public function getVisitorsPCountry(){
		/**select C.name,count(*) as cnt from cubecartCubeCart_addressbook as A, cubecartCubeCart_geo_country as C where A.country=C.numcode group by country;*/
		$A=$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_addressbook";
		$C=$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_geo_country";
		$query = "SELECT `".$C."`.`name`, count(*) as `cnt` FROM `".$A."`,`".$C."` WHERE `".$A."`.`country`=`".$C."`.`numcode` GROUP BY `country`";
		$res = $GLOBALS['db']->query($query);
		$countries = '';
		$users     = '';
		foreach ($res as $value){
			$countries = $countries.'_c[]='.urlencode($value['name']).'&';
			$users     = $users.'_u[]='.urlencode($value['cnt']).'&';
		}
//		$ret = array ('countries' => $countries, 'users' => $users);
		$ret['cchart'] = 'classes/chartcountry.php?'.$countries.'&'.$users;
		return $ret;
	}

	public function getVisitorsPDay(){
		/**select dayofweek(from_unixtime(time)),count(*) from cubecartCubeCart_access_log group by date(from_unixtime(time)) LIMIT 7;*/ //can have days with zero visits

/**
select dayofweek(from_unixtime(time)),count(*) from (select * from cubecartCubeCart_access_log order by time desc) as A  group by date(from_unixtime(time)) order by date(from_unixtime(time)) asc  LIMIT 7;
*/
		$A=$GLOBALS['config']->get('config', 'dbprefix')."CubeCart_access_log";
		$query = "SELECT dayofweek(from_unixtime(`time`)) AS 'day', COUNT(*) AS `cnt` FROM (SELECT * FROM `".$A."` ORDER BY `time` DESC) as `A` GROUP BY date(from_unixtime(`time`)) ORDER BY date(from_unixtime(`time`)) ASC LIMIT 7";
		$res   = $GLOBALS['db']->query($query);
		$days  = '';
		$users = '';
		foreach ($res as $value){
			$days = $days.'_d[]='.$value['day'].'&';
			$users= $users.'_u[]='.$value['cnt'].'&';
		}
//		$ret = array ('countries' => $countries, 'users' => $users);
		$ret['uchart'] = 'classes/chartusers.php?'.$days.'&'.$users;
		return $ret;
	}

}

