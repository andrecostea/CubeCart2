<?php
require_once("../dbcon.php");
//Start Array
$data = array();
// Get data to work with
$room = $_POST['room'];
$username = $_POST['username'];

$chatroom_name = cleanInput($room);
if(checkVar($chatroom_name)){
	$check_name = "SELECT * FROM `cubecartCubeCart_chatrooms` WHERE `name` = '$chatroom_name'";
        if (!hasData($check_name)) {
		$insertRoom = "INSERT INTO `cubecartCubeCart_chatrooms` (`id`, `name`, `numofuser`, `file`) VALUES ( NULL , '$chatroom_name', '100', '$chatroom_name')";
		mysql_query($insertRoom) or die(mysql_error());
		$chatuser_email = $username;
		$now = time();
		$insertRoom_User = "INSERT INTO `cubecartCubeCart_chatrooms_users` (`id`, `username`, `room`, `mod_time`) VALUES ( NULL , '$chatuser_email', '$chatroom_name', '$now')";
		mysql_query($insertRoom_User) or die(mysql_error());
		$data['check'] = 'true';
		$data['info'] = 'Create room successfully!';
        } else {
		$data['check'] = 'false';
		$data['info'] = 'The room is existing';
        }
} else {
	$data['check'] = 'false';
	$data['info'] = 'Please input appropriate name';
}

echo json_encode($data);

?>
