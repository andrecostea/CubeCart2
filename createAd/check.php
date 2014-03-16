<?php

$user_name=$_POST['username'];
$email=$_POST['email'];

$adv_url=$_POST['url'];
$page_url=$_POST['page_url'];
$intro=$_POST['intro'];
echo "<p>hi user <em>".$user_name." <em/>you has created ad!</p>";
echo "<a href=$page_url><img src=".$adv_url."></a>";



$xml=simplexml_load_file("adv.xml");

$count=$xml->count()+1;




$handle=fopen($count.".txt","w");
fwrite($handle,$adv_url);
fclose($handle);




$ad=$xml->addChild('ad');
$ad->addChild("username",$user_name);
$ad->addChild("email",$email);
$ad->addChild("page",$page_url);
$ad->addChild("adurl",$adv_url);
$ad->addChild("intro",$intro);
$xml->asXML('adv.xml');
//print($xml->ad[1]->email);

//foreach($xml->ad as $tag){
//print($tag->username."<br>");

//}
//echo $tag


?>
