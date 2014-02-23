function get_invitation(){
	$.ajax({
		type: "GET",
		url: "room/invitationlist.php",
		data: {  
			'username': user_invitation,
		},
		dataType: "json",
		cache: false,
		success: function(data) {
			var list = "";
			for (var i=0; i< data.invitations.length; i++){
				list += "<li>You are invited to join the chatroom: "+ data.invitations[i] + "<button value=" + data.invitations[i] + " onclick=\"reject_invitation(this.value)\">Reject</button><button value=" + data.invitations[i] + " onclick=\"accept_invitation(this.value)\">Accept</button>";
			}
		
			$('#invitation_list').html($("<ul>"+ list +"</ul>"));
			setTimeout('get_invitation()', 1000);
		},
	});
}
