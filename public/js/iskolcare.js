
function deleteAnnouncement(id){
	if(confirm('Are you sure you want to delete announcement?')){
		//alert('gidelete');
		window.location.href="deleteAnnouncement?id="+id;
	}
}
function approveVolunteers(){
  
    
     $.ajax({
		url: 'http://127.0.0.1:8000/addApprovedVolunteers',
		type: "get", 
		data: $("#approveVolunteersForm").serialize(),
        success: function(response) {
		  alert("success");
          location.reload();
		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
}
function rejectVolunteers(){

    
     $.ajax({
		url: 'http://127.0.0.1:8000/deleteVolunteer',
		type: "get", 
		data: $("#approveVolunteersForm").serialize(),
        success: function(response) {
		  alert("success");
          location.reload();
		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
}


