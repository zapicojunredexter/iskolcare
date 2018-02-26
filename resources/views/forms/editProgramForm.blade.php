

<div class="modal fade" id="editProgramModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT PROGRAM DETAILS
            </div>
            <div class="modal-body">
                
                
                
                
                
            
<form method="get" onsubmit="return false;" id="editProgramForm" action="{{ url('/editProgram') }}">
	    <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-3" style="font-weight:bold;">Program Name</div>
                    <div class="col-sm-9">
                        <input onkeyup="checkEditProgram()" id="edit-program-name" type="text" name="programName" value="{{$program->ProgramName}}" class="form-control">
		
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-sm-3" style="font-weight:bold;">Program Description</div>
                    <div class="col-sm-9">
                        <textarea onkeyup="checkEditProgram()" id="edit-program-description" name="programDescription" type="text" class="form-control">{{$program->ProgramDescription}}</textarea>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-sm-3" style="font-weight:bold;">Program Objective</div>
                    <div class="col-sm-9">

                        <textarea onkeyup="checkEditProgram()" id="edit-program-objective" name="programObjective" type="text" class="form-control">{{$program->ProgramObjective}}</textarea>
                    </div>
                </div>
            </div>
        </div>
		<input type="hidden" name="id" value="{{$program->ProgramId}}" class="form-control" readonly>
		
        <input type="hidden" name="logo" value="{{$program->Logo}}" class="form-control" readonly>
        <input type="hidden" name="universityId" value="{{$program->UniversityId}}" readonly>
		<br>
        <button type="button" id="edit-program-button" class="blue-button" style="margin-left:45%;" onclick="this.disabled='true';editProgram();">SUBMIT</button>
        </form>	

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div> 
    
    </div>

<script>
    function checkEditProgram(){
        var editGName,editGDesc,editGObj;
        editGName=$('#edit-program-name').val();
        editGDesc=$('#edit-program-description').val();
        editGObj=$('#edit-program-objective').val();
        if(editGName.trim()!==""&&editGDesc.trim()!==""&&editGObj.trim()!==""){
            $('#edit-program-button').prop('disabled',false);
        }else{
            
            $('#edit-program-button').prop('disabled',true);
        }
    }
    function editProgram(){
        $.ajax({
            url: "{{ url('/editProgram') }}",
		    data: $("#editProgramForm").serialize(),
            type: "get", 
            success: function(response) {
                alert("Successfully edited program details");
                location.reload();
            },
            error: function(xhr) {
                alert("Something went wrong!");
            }
        });
    }
</script>