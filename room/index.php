<?php
session_start();
require_once("../dbcon.php");

$name = $_GET['name'];
$getRooms = "SELECT * FROM cubecartCubeCart_chatrooms WHERE name = '$name'";
$roomResults = mysql_query($getRooms);

if (mysql_num_rows($roomResults) < 1) {
    header("Location: ../chatroom_index.php");
    die();
}

$file = "";
while ($rooms = mysql_fetch_array($roomResults)) {
    $file = $rooms['file'];
}

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome to: <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="../main.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
    <script src="chat.js" type="text/javascript"></script>
    <script type="text/javascript">
    	var chat = new Chat('<?php echo $file; ?>');
        chat.init();
    	chat.getUsers(<?php echo "'" . $name ."','" .$_SESSION['CHATROOM_USER_EMAIL'] . "'"; ?>);
        var name = '<?php echo $_SESSION['CHATROOM_USER_FIRST'];?>';
        var room_to_invite = '<?php echo $name; ?>';
    </script>
    <script type="text/javascript" src="settings.js"></script>
    <script type="text/javascript" src="inviting.js"></script>
</head>

<body>
    <div id="page-wrap">

    	<div id="header">
        	<h1><a href="/CubeCart2/images/logo.jpg">cubecart</a></h1>
        	<div id="you"><span>Logged in as:</span> <?php echo $_SESSION['CHATROOM_USER_FIRST']?></div>
        </div>
        
        <div id="section">
            <div id="invite-user-div">
				<label>Input email: </label>
            	<input type="text" name="user" id="invite_user"/>
	            <button id="invite" name="invite" onclick="inviteUserFunc()">Invite</button>
            </div>
            <div id="left-room">
            </div>
        </div>
        <div id="section">
            <h2><?php echo $name; ?></h2>      
            <div id="chat-wrap">
                <div id="chat-area"></div>
            </div>
            <div id="userlist"></div>
            <form id="send-message-area" action="">
                <textarea id="sendie" maxlength='100'></textarea>
            </form>
        </div>
        
    </div>
</body>
</html>
