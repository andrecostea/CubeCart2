<?php
require_once("../dbcon.php");

//Start Array
	$data = array();
// Get data to work with
	$username = $_GET['username'];

	$data['check'] = 'true';
	$data['invitations'] = array();
	$query_invitation = mysql_query("SELECT * FROM cubecartCubeCart_chatrooms_invitation WHERE username = '$username'");
	while($invitation = mysql_fetch_array($query_invitation)) {
		$data['invitations'][] = $invitation['room'];
	}
	$data['invitations'] = array_reverse($data['invitations']);

	echo json_encode($data);

?>
