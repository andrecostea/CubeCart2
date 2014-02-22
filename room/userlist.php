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
        $user_email = $user['username'];
        $userResults = mysql_query("SELECT * FROM cubecartCubeCart_customer where `email` = '$user_email'");
        $user_data = mysql_fetch_array($userResults);
        $data['userlist'][] = $user_data['first_name'];
	}
	$data['userlist'] = array_reverse($data['userlist']);

	echo json_encode($data);

?>
