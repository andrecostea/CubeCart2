<?php
if($_COOKIE['log_2_ad']=='yes'){
require("create.php");
}

else{
header("X-XSS-Protection:0");
echo "<p>plz login first</p>";
echo "<p><a href='/CubeCart2/index.php?_a=login'>click back to login</a></p>";
echo "<p><a href='example.php?adId=1'>or see some examples of the ads</a> </p>";
}





?>
