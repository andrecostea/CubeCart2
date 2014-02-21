<?php
require_once("../dbcon.php");

//Start Array
	$data = array();
// Get data to work with
	$current = $_GET['current'];
	$room = $_GET['room'];
	$username = $_GET['username'];

	$data['check'] = 'true';
	$getRoomUsers = mysql_query("SELECT * FROM `cubecartCubeCart_chatrooms_users` WHERE `room` = '$room'");
	$check = mysql_num_rows($getRoomUsers);
        		 		
// Get People in chat
    $data['numOfUsers'] = $check;
	$data['userlist'] = array();
	while($user = mysql_fetch_array($getRoomUsers))
	{
		$data['userlist'][] = $user['username'];
	}
	$data['userlist'] = array_reverse($data['userlist']);

	echo json_encode($data);

?>
