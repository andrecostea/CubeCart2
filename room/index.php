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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="chat.js"></script>
    <script>
    	var chat = new Chat('<?php echo $file; ?>');
    	chat.init();
    	chat.getUsers(<?php echo "'" . $name ."','" .$_SESSION['CHATROOM_USER_EMAIL'] . "'"; ?>);
    	var name = '<?php echo $_SESSION['CHATROOM_USER_EMAIL'];?>';
    </script>
    <script src="settings.js"></script>
</head>

<body>
    <div id="page-wrap">

    	<div id="header">
        	<h1><a href="/CubeCart2/images/logo.jpg">cubecart</a></h1>
        	<div id="you"><span>Logged in as:</span> <?php echo $_SESSION['CHATROOM_USER_FIRST']?></div>
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
