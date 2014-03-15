<div id="live_chatroom">
<button style="margin-left:25px;" onclick="pop_chatroom()">Chatroom</button>
<button style="margin-left:25px;" onclick="pop_share()">Share</button>
<button style="margin-left:25px;" onclick="pop_ad()">CreateAd</button>
</div>
<script>
function pop_chatroom()
{
    window.location.href="http://localhost/CubeCart2/index.php?_a=chatroom";
}
function pop_share()
{
    window.open("http://localhost/CubeCart2/share.html");
}
function pop_ad()
{
    window.open("http://localhost/CubeCart2/createAd/");
}
</script>
