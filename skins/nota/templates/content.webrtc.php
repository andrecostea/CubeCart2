<div>
  <h2>{$LANG.account.your_webrtc}</h2>

<script language="JavaScript">
//refresh the website
function myrefresh()
{
     window.location.reload();
}
setTimeout('myrefresh()',60000);
</script>

<script language="php">
//check the user
if(isset($_COOKIE['current_name'])&&!empty($_COOKIE['current_name']))
{
    	$sender = $_COOKIE['current_name'];
}
else
{  
    	$sender="defualt";
}

if (isset($_POST['action']) && $_POST['action'] == 'submitted')
{ 
    	//connect to the server
    	$con=mysql_connect('localhost','root',"student");
    	if (!$con)
    	{
        	die('Could not connect: ' . mysql_error());
    	}

    	//connect to the database
    	$db_cubecart=mysql_select_db('cubecart');
    	if (!$db_cubecart)
    	{
        	die('Could not connect: ' . mysql_error());
    	}

    	$search = "select email from cubecartCubeCart_customer where email = '$_POST[email]'";

    	//check the email
    	if (mysql_num_rows(mysql_query($search,$con))<1)
    	{
</script>
        	<script language="JavaScript"> 
        	window.alert('No user found');
        	location.replace("index.php?_a=webrtc");
        	</script>
<script language="php"> 
    	}
   	 elseif (strcmp("$_POST[email]", "$sender")===0)
    	{ 
</script>
        	<script language="JavaScript"> 
        	window.alert('The receiver is the sender');
        	location.replace("index.php?_a=webrtc");
        	</script>
<script language="php"> 
    	} 
   	 else
    	{
		//random for the room id
        	function randomkeys($len)
        	{
     	    		$pattern="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ";
     	    		for($i=0;$i<$len;$i++)
       	   		{
          			$key .= $pattern[mt_rand(0,35)];
       	   		}
           		return $key;
        	}

		//connect to the new database
    		$db_msg=mysql_select_db('message');
    		if (!$db_msg)
    		{
		    	die('Could not connect: ' . mysql_error());
   		}

		//count the item in the database
     		$count_query="select * from chatmsg";
     		$count=mysql_num_rows(mysql_query($count_query,$con));

		//when to insert a new message
     		$receiver = "select receive from chatmsg where receive = '$_POST[email]' and rflag = 1 union all select receive from chatmsg where receive = '$_POST[email]' and rflag = 0 and flag = 1";

    		//insert when a message is send
    		if (mysql_num_rows(mysql_query($receiver,$con))==0)
    		{
      	    		$roomId=randomkeys(4);
      	    		$sql = "insert into chatmsg (id,send,receive,rflag,msg) values ($count+1,'$sender','$_POST[email]',1,'$roomId')";

      	    		if (!mysql_query($sql,$con))
      			{
        			die('Error: ' . mysql_error());
      			}
			else
			{
</script>
        			<script language="JavaScript"> 
        			window.alert('Send successful!');  
        			</script>
<script language="php"> 
      			}
    		}
    	}
    	mysql_close($con); 
} 
else { 
</script>
<script language="php"> 
echo ("Send an invition to your friend<br>");
</script>

<form action="index.php?_a=webrtc" method="POST"> 
   	 Email:  <input type="text" name="email"><br>  
   	 <input type="hidden" name="action" value="submitted"> 
   	 <input type="submit" name="submit" value="Invite"> 
</form> 
<script language="php"> 
} 

//connect to the server
$con=mysql_connect('localhost','root',"student");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//connect to the database
$db_msg=mysql_select_db('message');
if (!$db_msg)
{
	die('Could not connect: ' . mysql_error());
}
    
//update when the message read
$done = $_GET['done'];
$id = $_GET['id']; 
//if $id exists, it means the receiver rejects the request or the send read the reply
if ($id)
{
  	$update = "update chatmsg set flag = 0, rflag = 0 where id = '$id'";
  	$result = mysql_query($update,$con);
  	if (!$result)
  	{
    		die('Error: ' . mysql_error());
  	}
</script>
  	<script type = "text/javascript" language = "javascript">
  	location.replace("index.php?_a=webrtc");
  	</script>
<script language="php"> 
}
//if $done exists, it means the receiver accepts the request
if ($done)
{
  	$update = "update chatmsg set flag = 1, rflag = 0 where id = '$done'";
  	$result = mysql_query($update,$con);
  	if (!$result)
  	{
    		die('Error: ' . mysql_error());
  	}
</script>
  	<script type = "text/javascript" language = "javascript">
  	location.replace("index.php?_a=webrtc");
  	</script>
<script language="php"> 
}

//show the user unread message
$msg = "select * from chatmsg where receive = '$sender' and rflag = 1";
$result = mysql_query($msg,$con);

if (!$result)
{
	die('Error: ' . mysql_error());
}

if(mysql_num_rows($result)>0) 
{
</script>
  	<script type = "text/javascript" language = "javascript">
  	window.alert('Got Unread Message');	
  	</script>
<script language="php">
}

//draw the table for unread message
echo "<br>Unread message:<br>";    
echo "<table border=\"1\">";     
echo "<tr bgcolor=\"#FF0000\"><td>ID</td><td>Sender</td><td>Message</td></tr>";     
while($row = mysql_fetch_array($result))
{ 
	echo ("<tr><td>".$row['id']."</td><td>".$row['send']."</td><td><a href='check.php?id=".$row['id']."'><div>".$row['send']." invite you to facetime https://opentokrtc.com/".$row['msg']."</div></a></td></tr>"); 
} 
echo "</table>";

//show the user accept message
$accept = "select * from chatmsg where send = '$sender' and rflag = 0 and flag = 1";
$reply = mysql_query($accept,$con);

if (!$reply)
{
	die('Error: ' . mysql_error());
}

if(mysql_num_rows($reply)>0) 
{
</script>
  	<script type = "text/javascript" language = "javascript">
  	window.alert('Got Reply for the facetime');
  	</script>
<script language="php">
}

//draw the table for accept message
echo "<br>Accept message:<br>";    
echo "<table border=\"1\">";     
echo "<tr bgcolor=\"#FF0000\"><td>ID</td><td>receiver</td><td>Message</td></tr>"; 
   
while($row = mysql_fetch_array($reply))
{ 
	echo ("<tr><td>".$row['id']."</td><td>".$row['receive']."</td><td><a href='update.php?id=".$row['id']."'><div>".$row['receive']." accept your request to facetime https://opentokrtc.com/".$row['msg']."</div></a></td></tr>"); 
} 
echo "</table>";

</script>
</div>
