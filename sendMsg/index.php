<?php
    
    //refresh the website
    echo "<script language='JavaScript'>\r\n";
    echo "function myrefresh()
    {
        window.location.reload();
    }\r\n";
    echo "setTimeout('myrefresh()',60000);\r\n";
    echo "</script>";
    
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
        	echo "<script language=\"JavaScript\">\r\n";
        	echo "window.alert('No user found');\r\n";
        	echo "history.back();\r\n";
        	echo "</script>";
    	}
        elseif (strcmp("$_POST[email]", "$sender")===0)
    	{
        	echo "<script language=\"JavaScript\">\r\n";
        	echo "window.alert('The receiver is the sender');\r\n";
        	echo "history.back();\r\n";
        	echo "</script>";
    	}
        else
    	{
            //random for the room id
        	function randomkeys($length)
        	{
                $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
                for($i=0;$i<$length;$i++)
       	   		{
          			$key .= $pattern{mt_rand(0,35)};
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
     		$receiver = "select receive from chatmsg where receive = '$_POST[email]' and rflag = 1
            union all
            select receive from chatmsg where receive = '$_POST[email]' and rflag = 0 and flag = 1";
            
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
        			echo "<script language=\"JavaScript\">\r\n";
        			echo "window.alert('Send successful!');\r\n";
                    echo "</script>";
      			}
    		}
    	}
    	mysql_close($con);
    }
    else {
    ?>
<?php echo "Send an invition to your friend<br>"?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
Email:  <input type="text" name="email"><br>
<input type="hidden" name="action" value="submitted">
<input type="submit" name="submit" value="Invite">
</form>
<?php
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
    
    //show the user unread message
    $msg = "select * from chatmsg where receive = '$sender' and rflag = 1";
    $result = mysql_query($msg,$con);
    
    if (!$result)
    {
        die('Error: ' . mysql_error());
    }
    
    //draw the table for unread message
    echo "Unread message:<br>";
    echo "<table border=\"1\">";
    echo "<tr bgcolor=\"#FF0000\"><td>ID</td><td>Sender</td><td>Message</td></tr>";
    while($row = mysql_fetch_array($result))
    {
        echo "<tr><td>".$row['id']."</td><td>".$row['send']."</td><td><a href='check.php?id=".$row['id']."'><div>".$row['send']." invite you to facetime https://opentokrtc.com/".$row['msg']."</div></a></td></tr>";
    }
    echo "</table>";
    
    //update when the message read
    $do = $_GET['do'];
    $id = $_GET['id'];
    //if $id exists, it means the receiver rejects the request
    if ($id)
    {
        $update = "update chatmsg set flag = 0, rflag = 0 where id = '$id'";
        $result = mysql_query($update,$con);
        if (!$result)
        {
    		die('Error: ' . mysql_error());
        }
        echo "<script type = \"text/javascript\" language = \"javascript\">\r\n";
        echo "location.replace(\"index.php\");\r\n";
        echo "</script>";
    }
    //if $do exists, it means the receiver accepts the request
    if ($do)
    {
        $update = "update chatmsg set flag = 1, rflag = 0 where id = '$do'";
        $result = mysql_query($update,$con);
        if (!$result)
        {
    		die('Error: ' . mysql_error());
        }
        echo "<script type = \"text/javascript\" language = \"javascript\">\r\n";
        echo "location.replace(\"index.php\");\r\n";
        echo "</script>";
    }
    
    
    //the offer accept reply to the sender
    $reply = "select * from chatmsg where flag=1 and send = '$sender'";
    if(mysql_num_rows(mysql_query($reply,$con))>0)
    {
        while($row = mysql_fetch_array(mysql_query($reply,$con)))
        {
            $update = "update chatmsg set flag = 0 where flag=1 and send = '$sender'";
            mysql_query($update,$con);
      		echo "<script language=\"JavaScript\">\r\n"; 
      		echo "if(confirm('$row[receive] accept your request for facetime https://opentokrtc.com/$row[msg]'))
            {
                window.open ('https://opentokrtc.com/$row[msg]', 'newwindow', 'height=100, width=400, top=0, left=0, toolbar=no, menubar=no, 				scrollbars=no, resizable=no,location=n o, status=no');   
                
                location.replace(\"index.php\");
                                 
                                 }
                                 else  
                                 location.replace(\"index.php\");\r\n";  
                                                  echo "</script>";
                                                  }
                                                  }
    ?>
