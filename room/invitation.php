<?php
require_once("../dbcon.php");
//Start Array
$data = array();
// Get data to work with
$room = $_GET['room'];
$username = $_GET['username'];

$invite_user = cleanInput($username);
if (checkVar($invite_user))
{
	$check_user = "SELECT * FROM `cubecartCubeCart_customer` WHERE `email` = '$invite_user'";
	if (hasData($check_user))
	{
		$check_user_room = "SELECT * FROM `cubecartCubeCart_chatrooms_users` WHERE `username` = '$invite_user' and `room` = '$room'";
		if (!hasData($check_user_room)) 
		{
			$check_user_invite = "SELECT * FROM `cubecartCubeCart_chatrooms_invitation` WHERE `username` = '$invite_user' and `room` = '$room'";
			if(!hasData($check_user_invite))
			{
				$now = time();
				$sendInvite = "INSERT INTO `cubecartCubeCart_chatrooms_invitation` (`id`, `username`, `room`, `mod_time`) VALUES ( NULL , '$invite_user', '$room', '$now')";
				mysql_query($sendInvite) or die(mysql_error());
				$data['check'] = 'true';
				$data['errorinfo'] = 'The invitation has been sent successfully!';
			} else {
				$data['check'] = 'false';
				$data['errorinfo'] = 'The user has been invited';
			}
		} else {
			$data['check'] = 'false';
			$data['errorinfo'] = 'The user is already here';
		}
	} else {
		$data['check'] = 'false';
		$data['errorinfo'] = 'No user found';
	}
} else {
	$data['check'] = 'false';
	$data['errorinfo'] = 'Input the correct user information';
}
echo json_encode($data);

?>
