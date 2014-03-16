<?php
session_start();
require_once("dbcon.php");

$getRooms = "SELECT * FROM cubecartCubeCart_chatrooms";
$roomResults = mysql_query($getRooms);
$user_id = $_SESSION['CHATROOM_USER_ID'];
$userResults = mysql_query("SELECT * FROM cubecartCubeCart_customer where `customer_id` = '$user_id'");
$user = mysql_fetch_array($userResults);
$_SESSION['CHATROOM_USER_EMAIL'] = $user['email'];
$_SESSION['CHATROOM_USER_FIRST'] = $user['first_name'];

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CubeCart Chatrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="room/fresh_invitation.js"></script>
    <script type="text/javascript">
        var user_invitation = '<?php echo $_SESSION['CHATROOM_USER_EMAIL'];?>';
	get_invitation();
    </script>
    <script type="text/javascript" src="room/invitationFunc.js"></script>
</head>


<body>
    <div id="page-wrap">
    	
    	<div id="section">
            <div id="creat">
                <h3>Create room</h3>
                <label for="room_name">room name: </label>
		<input type="text" name="room_name" id="room_name"/>
	        <button id="create_room" name="create_room" onclick="createChatroom()">Create Room</button>
            </div>
          </div>
          <div id="section">
            <h3>Invitation</h3>
		<div id="invitation_list"></div>
          </div>
          <div id="section">
            <div id="rooms">
            	<h3>Rooms</h3>
                <ul>
                    <?php
			$user_name = $_SESSION['CHATROOM_USER_EMAIL'];
                        while($rooms = mysql_fetch_array($roomResults)):
                            $room = $rooms['name'];    
                            $query = mysql_query("SELECT * FROM `cubecartCubeCart_chatrooms_users` WHERE `room` = '$room' and `username` = '$user_name'");
			    if ( mysql_num_rows($query) ) :
			    	$query = mysql_query("SELECT * FROM `cubecartCubeCart_chatrooms_users` WHERE `room` = '$room'");
                            	$numOfUsers = mysql_num_rows($query);
                    ?>
                    <li>
                    <a href="room/?name=<?php echo $rooms['name']?>&user=1"><?php echo $rooms['name'] . "<span>Users chatting: <strong>" . $numOfUsers . "</strong></span>" ?></a>
                    </li>
                    <?php endif; endwhile; ?>
                </ul>
            </div>
        </div>   
    </div>

</body>
</html>
