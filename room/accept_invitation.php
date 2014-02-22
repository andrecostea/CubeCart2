<?php
require_once("../dbcon.php");
//Start Array
$data = array();
// Get data to work with
$room = $_GET['room'];
$username = $_GET['username'];
$now = time();
$insert_chatrooms_users = "INSERT INTO `cubecartCubeCart_chatrooms_users` (`id` ,`username` , `room` ,`mod_time`) VALUES (NULL , '$username', '$room', '$now')";
mysql_query($insert_chatrooms_users) or die(mysql_error());
$delete_invitation = "DELETE FROM `cubecartCubeCart_chatrooms_invitation` WHERE `username` = '$username' and `room` = '$room'";
mysql_query($delete_invitation) or die(mysql_error());
$data['check'] = 'true';
$data['errorinfo'] = 'The invitation has been sent successfully!';
?>
