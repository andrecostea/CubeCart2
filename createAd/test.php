

<?php
//if($_GET['name']){
$result=shell_exec("cat ".$_GET['name'].".txt");
echo $result;
//}
?>
