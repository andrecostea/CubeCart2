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

if (isset($_POST['room_name']) && $_POST['room_name'] != NULL) {
    $chatroom_name = cleanInput($_POST['room_name']);
    if(checkVar($chatroom_name)){
        $check_name = "SELECT * FROM `cubecartCubeCart_chatrooms` WHERE `name` = '$chatroom_name'";
        if (!hasData($check_name)) {
            $insertRoom = "INSERT INTO `cubecartCubeCart_chatrooms` (`id`, `name`, `numofuser`, `file`) VALUES ( NULL , '$chatroom_name', '100', '$chatroom_name')";
            mysql_query($insertRoom) or die(mysql_error());
            $chatuser_email = $_SESSION['CHATROOM_USER_EMAIL'];
            $now = time();
            $insertRoom_User = "INSERT INTO `cubecartCubeCart_chatrooms_users` (`id`, `username`, `room`, `mod_time`) VALUES ( NULL , '$chatuser_email', '$chatroom_name', '$now')";
            mysql_query($insertRoom_User) or die(mysql_error());
            $chatroom_url = 'http://localhost/CubeCart2/chatroom_index.php';
            header("LOCATION:$chatroom_url");
        } else {
            echo "<script language=\"JavaScript\">\r\n";
            echo "window.alert('The room is existing!');\r\n";
            echo "history.back();\r\n";
            echo "</script>";
        }
    } else {
        echo "<script language=\"JavaScript\">\r\n";
        echo "window.alert('Please input right room name!');\r\n";
        echo "history.back();\r\n";
        echo "</script>";
    }
}
?>

<html>
<head>
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
            <div id="creat">
                <h3>Create room</h3>
                <form id="creat-room-area" action="chatroom_index.php" method="post">
                <label for="room_name">room name: </label><span><input type="text" name="room_name" id="room_name"/></span>
                <input type="submit" name="submit" value="Create Room"/>
                </form>
            </div>
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
