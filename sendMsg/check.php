<?php
    
    if(isset($_GET['id'])&&!empty($_GET['id'])){
        
        $con=mysql_connect('localhost','root',"student");
        if (!$con)
        {
            die('Could not connect: ' . mysql_error());
        }
        
        $db_cubecart=mysql_select_db('message');
        if (!$db_cubecart)
        {
            die('Could not connect: ' . mysql_error());
        }
        
        $count_query="select * from chatmsg";
        $count=mysql_num_rows(mysql_query($count_query,$con));
        $sender = $_COOKIE['current_name'];
        
        
        $search_msg_byID="select * from chatmsg where id=".$_GET['id'].";";
        
        $result=mysql_query($search_msg_byID,$con);
        
        while($row = mysql_fetch_array($result)){
            echo "<script type = \"text/javascript\" language = \"javascript\">\r\n";
            
            echo "if(confirm('$row[send] invite you to facetime https://opentokrtc.com/$row[msg]')){
            window.open ('https://opentokrtc.com/$row[msg]', 'newwindow', 'height=100, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no');
            
            location.replace(\"index.php?do=$row[id]\");
                             }
                             else  {location.replace(\"index.php?id=$row[id]\");}\r\n";
                                                     echo "</script>";
                                                     }
                                                     mysql_free_result($result);
                                                     
                                                     
                                                     }
    ?>







