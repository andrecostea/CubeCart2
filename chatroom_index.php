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
<script>
    document.write("<p> ABCDE </p>");
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CubeCart Chatrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>


<body>
    <div id="page-wrap">
    	<div id="header">
        	<h1><a href="/CubeCart2/images/logo.jpg">cubecart</a></h1>
        	<div id="you"><span>Logged in as:</span> <?php echo $_SESSION['CHATROOM_USER_FIRST']; ?></div>
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
                    <a href="room/?name=<?php echo $rooms['name']?>"><?php echo $rooms['name'] . "<span>Users chatting: <strong>" . $numOfUsers . "</strong></span>" ?></a>
                    </li>
                    <?php endif; endwhile; ?>
                </ul>
            </div>
        </div>   
    </div>

</body>
</html>
