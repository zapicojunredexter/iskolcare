
<div class="modal fade" id="editScheduleModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT ACTIVITY SCHEDULE
            </div>
            <div class="modal-body" style="">
            

            <form method="get" id="activityScheduleForm" onsubmit="editActivitySchedule();return false;" action="{{url('editActivitySchedule')}}">
    <input type="hidden" name="id" value="{{$activity->ActivityId}}" readonly><br>
    <div class="row"> 
    
    @foreach($activity->Schedules as $sched)
        <div class="col-sm-6">
            <input type="date" name="date[]" class="form-control" style="height:100px;" value="{{$sched->SchedDate}}">
        </div>
        <div class="col-sm-6">
            <input type="time" name="timeStart[]" class="form-control" style="height:50px;" value="{{$sched->SchedTime}}">
            <input type="time" name="timeEnd[]" class="form-control" style="height:50px;" value="{{$sched->SchedTimeEnd}}"><br>
        </div>
    @endforeach
    
        <div id="more-sched-container" class="col-sm-12">
            
        </div>
  
        <div class="col-sm-12"><button onclick="addMoreEntries()" type="button">Add More Entries</button></div>
    </div>
    <button class="blue-button" style="margin-left:45%;" type="button" onclick="this.disabled='true';editActivitySchedule()">SUBMIT</button>

    </form>


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
<script>
    function addMoreEntries(){
        //$('#more-sched-container').append('<div class="row"><div class="col-sm-6"><input type="date" name="date[]" class="form-control"><br></div><div class="col-sm-6"><input type="time" name="time[]" class="form-control"></div></div>');
        $('#more-sched-container').append('<div class="row"><div class="col-sm-6"><input type="date" name="date[]" style="height:100px;" class="form-control"><br></div><div class="col-sm-6"><input type="time" name="timeStart[]" style="height:50px;" class="form-control"><input type="time" name="timeEnd[]" style="height:50px;" class="form-control"><br></div></div>');
    }
    function editActivitySchedule(){
     $.ajax({
		url: "{{url('editActivitySchedule')}}",
		type: "get", 
		data: $("#activityScheduleForm").serialize(),
        success: function(response) {
		  alert("successfully changed schedule");
          location.reload();
		},
		error: function(xhr) {
			alert("something went wrong!");
            console.log(xhr);
		}
	});

    }
</script>