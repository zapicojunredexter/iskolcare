<form id="deleteApprovedVolunteersForm">
    <table class="table table-striped" style="border:solid silver 1px;">
        <tr style="background: #1b593e;color: white;">
            <th>Name</th>
            <th>University</th>
            <th>Address</th>
            <th>Type</th>
            <th><input type="checkbox"></th>
        </tr>
            @foreach($activity->Volunteers as $volunteer)
                @if($volunteer->VolunteerStatus===1)
        <tr>
            <td>
                {{$volunteer->Name}} {{$volunteer->LastName}}
            </td>
            <td>
                {{$volunteer->UniName}}
            </td>
            <td>
                {{$volunteer->Address}}
            </td>
            <td>
                {{$volunteer->Type}}
            </td>
            <td><input type="checkbox" name="volIds[]" value="{{$volunteer->VolunteerId}}"></td>
        </tr>
                @endif
        @endforeach
    </table>                
    
    <a href="#">
        <img data-toggle="tooltip" title="Delete Volunteers" src="default-img/trash.png" alt="delete" style="height:30px;width:30px;" onclick="deleteApprovedVolunteers();">
    </a>
</form>
<script>
    
function deleteApprovedVolunteers(){

    if(confirm('Are you sure you want to delete volunteers?')){
     $.ajax({
		url: "{{url('deleteVolunteer')}}",
		type: "get", 
		data: $("#deleteApprovedVolunteersForm").serialize(),
        success: function(response) {
		  alert("successfully deleted volunteers");
          location.reload();
		},
		error: function(xhr) {
            console.log(xhr);
			alert("Something went wrong");
		}
	});
    }
}
</script>