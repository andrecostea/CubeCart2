function inviteUserFunc(){
var user_to_invite = document.getElementById("invite_user").value;
send_invitation(room_to_invite, user_to_invite);
}

function send_invitation(room_z, username_z) {

	 $.ajax({
        type: "GET",
        url: "invitation.php",
        data: { 'room' : room_z,
        	'username': username_z,
        },
        dataType: "json",
        cache: false,
        success: function(data) {
        	alert(data.errorinfo);
        },
    });
}
