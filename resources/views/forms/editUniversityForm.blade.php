<div class="modal fade" id="edit-university-modal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT UNIVERSITY DETAILS
            </div>
            <div class="modal-body">
			<form id="editUniversityForm" onsubmit="return false;" method="post">
				{{csrf_field()}}
                <input type="hidden" name="uniId" value="{{$university->UniId}}" class="form-control">
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						University Name
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="uniName" value="{{$university->UniName}}">
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						University Description
					</div>
					<div class="col-sm-9">
						<textarea name="uniDescription" type="text" class="form-control">{{$university->UniDescription}}</textarea>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						University Vision
					</div>
					<div class="col-sm-9">
						<textarea type="text" class="form-control" name="vision">{{$university->Vision}}</textarea>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						University Mission
					</div>
					<div class="col-sm-9">
					<textarea class="form-control" name="mission">{{$university->Mission}}</textarea>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						Extension Head Name
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="extensionHeadName" value="{{$university->ExtensionHeadName}}" >
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						Address
					</div>
					<div class="col-sm-9">
					<textarea type="text" class="form-control" name="address">{{$university->UniAddress}}</textarea>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-3">
						Contact Number
					</div>
					<div class="col-sm-9">
					<input type="text" class="form-control" name="contNumber" value="{{$university->UniContNum}}">
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-sm-9">
						
					</div>
					<div class="col-sm-3">
						<button type="button" onclick="this.disabled='true';editUniversity();" class="blue-button">SAVE</button>
					</div>
				</div>

                                    
			</form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
function editUniversity(){
     $.ajax({
		url: "{{url('/editUniversity')}}",
		type: "post", 
		data: $("#editUniversityForm").serialize(),
        success: function(response) {
		  alert("Successfully edited university details");
		  //$('#edit-university-modal').modal('hide');
          
		  //		  $('#editCoverPhotoModal').modal('show');
		  location.reload();
		},
		error: function(xhr) {
			alert("Something went wrong!");
		}
	});
}
</script>