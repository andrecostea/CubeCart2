<?php

if(isset($_GET['adId'])){
      header("X-XSS-Protection:0");
      $xml=simplexml_load_file("adv.xml");
      echo "<p>this is example  ".$_GET['adId']."</p>";
      $img_array=array();
      foreach($xml->ad as $tag){
                    $img_arr[]=$tag->adurl;     
                }
      $count=$_GET['adId'];
      $img_count=$count-1;
      echo "<iframe src=$img_arr[$img_count]></iframe>";
      //$count=$_GET['adId']+1;
      $ad_url=shell_exec("cat ".$count.".txt");
     
      echo "<p>this ad's url is directing to :".$ad_url."</p>";

         
}




?>



