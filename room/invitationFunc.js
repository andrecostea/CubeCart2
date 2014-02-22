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
