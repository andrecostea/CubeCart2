<?php

mysql_connect('localhost', 'root', 'student') or die("Could not connect");
mysql_select_db ("cubecart")or die('Cannot connect to the database because: ' . mysql_error());
?>
