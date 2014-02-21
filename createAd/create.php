<script>
function show(){

var ad=document.getElementById("ad");
var link=document.getElementById("link");
var value=document.getElementById("ad_url").value;
var link_value=document.getElementById("page_url").value;
alert(link_value);
ad.src=value;
link.href=link_value;

}

</script>
<form action="check.php" method="post">
  <h2>Set Advertisement</h2>
  <div class="login-method">
	
	<fieldset>

	  	  <div><label for="login-username">User Name</label><span><input type="text" name="username" id="login-username" value="" class="" /></span></div>

	   <div><label for="login-username">Email Address</label><span><input type="text" name="email" id="login-username" value="" class="" /></span></div>

 <div><label for="login-username">Logo URL(gif only)</label><span><input type="text" name="url" id="ad_url" value="" class="" /></span></div>

<div><label for="login-username">Ad Url(target page)</label><span><input type="text" name="page_url" id="page_url" value="" class="" /></span></div>
	 
 <div><label for="login-username">Ad introduction</label><span><input type="text" name="intro" id="login-username" value="" class="" /></span></div>
	</fieldset>
  </div>
  <div>


	<input name="submit" type="submit" value="set" class="button_submit" />
  </div>
  </form>
<button id="show_ad" onclick="show()" > show what you want to post</button></br>
<a id="link" target="_blank"><img id="ad"></a>
