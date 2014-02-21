<?php
if($_COOKIE['log_2_ad']=='yes'){
require("create.php");
}


else{
echo "plz login first";
echo "<a href='/CubeCart/index.php?_a=login'>click back to login</a>";
}





?>
