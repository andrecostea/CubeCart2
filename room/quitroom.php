<?php
require_once("../dbcon.php");
//Start Array
$data = array();
// Get data to work with
$room = $_GET['room'];
$username = $_GET['username'];

$quit = "DELETE FROM `cubecartCubeCart_chatrooms_users` WHERE `username` = '$username' and `room` = '$room'";
mysql_query($quit) or die(mysql_error());
$check_room = "SELECT * FROM `cubecartCubeCart_chatrooms_users` WHERE `room` = '$room'";
if (!hasData($check_room)) {
	$delete_room = "DELETE FROM `cubecartCubeCart_chatrooms` WHERE `name` = '$room'";
	mysql_query($delete_room) or die(mysql_error());
}

$data['check'] = 'true';
$data['info'] = 'Quit this room successfully';

echo json_encode($data);
?>
