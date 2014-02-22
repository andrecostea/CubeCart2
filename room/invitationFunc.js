function reject_invitation(room){
  var user_reject = user_invitation;
  $.ajax({
        type: "GET",
        url: "reject_invitation.php",
        data: { 'room' : room,
        	'username': username_invitation,
        },
        dataType: "json",
        cache: false,
        success: function(data) {
        	alert(data.errorinfo);
        },
    });
}

function accept_invitation($room){
  var user_accept = user_invitation;
  $.ajax({
        type: "GET",
        url: "accept_invitation.php",
        data: { 'room' : room,
        	'username': username_invitation,
        },
        dataType: "json",
        cache: false,
        success: function(data) {
        	alert(data.errorinfo);
        },
    });
}
