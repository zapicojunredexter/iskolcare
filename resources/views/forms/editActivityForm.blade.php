<form method="GET" onSubmit="return false;" id="editActivityForm">
            <div class="modal fade" id="editActivityModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                EDIT ACTIVITY DETAILS
            </div>
            <div class="modal-body" style="">
                



			<input type="hidden" value="{{$activity->ActivityId}}" name="id" class="form-control">
		Activity Name: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityName}}" id="actName" name="activityName" class="form-control"><br>
		Activity Description: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityDescription}}" id="actDesc" name="activityDescription" class="form-control"><br>
		Venue: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityVenue}}" name="activityVenue" id="actVenue" class="form-control"><br>
		Target Audience: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->TargetAudience}}" name="targetAudience" id="actTarget" class="form-control"><br>
            	@if(Session::get('type')==='Director')
      
            <Select style="display:none;" type="hidden" name="status" class="form-control">
                <option value={{$activity->ActivityStatus}}>{{$activity->ActivityStatus}} </option>
                <option value="Approved">Approve</option>
                <option value="Reject">Reject</option>
            </Select>
		      @endif
              Allow External Volunteers / Beneficiaries? <input type="checkbox" name="isExclusive" {{$activity->isExclusive === 0? 'checked' : ''}}>
            <br>

            <button type="button" class="blue-button" id="edit-activity-button" style="margin-left:45%;" onclick="this.disabled='true';editActivity();">SUBMIT</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
</form>

<script>
function checkEditActivity(){
    var actName,actDesc,actVenue,actTarget;
    actName = $('#actName').val();
    actDesc= $('#actDesc').val();
    actVenue= $('#actVenue').val();
    actTarget= $('#actTarget').val();
    if(actName.trim()!==""&&actDesc.trim()!==""&&actVenue.trim()!==""&&actTarget.trim()!==""){
        $('#edit-activity-button').prop('disabled',false);
    }else{
        $('#edit-activity-button').prop('disabled',true);
    }
}
    
function editActivity(li){
    $.ajax({
		url: "{{ url('/editActivity') }}",
		type: "get", 
		data: $("#editActivityForm").serialize(),
        success: function(response) {
		  alert("successfully edited activity");
          location.reload();
		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
}

</script>