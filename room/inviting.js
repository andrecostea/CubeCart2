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

function quitRoom() {
	var room_leave = room_to_invite;
	var user_leave = user_to_leave;

	$.ajax({
		type: "GET",
		url: "quitroom.php",
		data: { 'room' : room_leave,
			'username': user_leave,
		},
		dataType: "json",
		cache: false,
		success: function(data) {
			alert(data.info);
			window.location.href="http://localhost/CubeCart2/chatroom_index.php";
		},
	});
}
