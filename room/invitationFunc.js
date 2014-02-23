function reject_invitation(room){

  $.ajax({
        type: "GET",
        url: "room/reject_invitation.php",
        data: { 'room' : room,
        	'username': user_invitation,
        },
        dataType: "json",
        cache: false,
	success: function(data) {
        	alert(data.errorinfo);
		location.reload();
        },
	error: function(data) {
        	alert(data.errorinfo);
        },
    });
}

function accept_invitation(room){

  $.ajax({
        type: "GET",
        url: "room/accept_invitation.php",
        data: { 'room' : room,
        	'username': user_invitation,
        },
        dataType: "json",
        cache: false,
        success: function(data) {
        	alert(data.errorinfo);
		location.reload();
        },
    });
}

function createChatroom(){
  var new_room = document.getElementById("room_name").value;
  $.ajax({
        type: "POST",
        url: "room/create_room.php",
        data: { 'room' : new_room,
		'username' : user_invitation,
        },
        dataType: "json",
        cache: false,
        success: function(data) {
        	alert(data.info);
		location.reload();
        },
    });

}



