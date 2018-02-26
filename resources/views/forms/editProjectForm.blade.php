<div class="modal fade" id="editProjectModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT PROJECT
            </div>
            <div class="modal-body" style="">


            <form method="GET" onsubmit="return false;" action="{{url('/editProject')}}"  id="editProjectForm">

<input type="hidden" id="id" value="{{$project->ProjectId}}" name="projectId" readonly>

<div class="row">
    <div class="col-sm-3" style="font-weight:bold;">
        Project Name
    </div>
    <div class="col-sm-9">
        <input type="text" id="projectName" onkeyup="checkEditProject()" value="{{$project->ProjectName}}" name="projectName" class="form-control">
    </div>
</div>
<div class="row" style="margin-top:10px;">
    <div class="col-sm-3" style="font-weight:bold;">
        Project Description
    </div>
    <div class="col-sm-9">
        <textarea id="projectDescription" onkeyup="checkEditProject()" name="projectDescription" class="form-control">{{$project->ProjectDescription}}</textarea>
    </div>
</div>
<input type="hidden" id="status" value="{{$project->Status}}" name="status" class="form-control" readonly>



<input type="hidden" id="banner" value="{{$project->Banner}}" name="banner" class="form-control">
<br>
<button type="button" class="blue-button" style="margin-left:45%;" id="editProjectFormButton" onclick="this.disabled='true';editProject();">SUBMIT</button>
</form>	






            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>    

<script>
    function checkEditProject(){
        var editProjectName,editProjectDesc;
        editProjectName=$('#projectName').val();
        editProjectDesc=$('#projectDescription').val();
        if(editProjectName.trim()!=="" && editProjectDesc.trim()!==""){
            $('#editProjectFormButton').prop('disabled',false);
        }else{
            $('#editProjectFormButton').prop('disabled',true);
        }
    }
    function editProject(){
        $.ajax({
            url: "{{ url('/editProject') }}",
		    data: $("#editProjectForm").serialize(),
            type: "get", 
            success: function(response) {
                swal("Successfully edited project details","","success").then(()=>{location.reload();});
            },
            error: function(xhr) {
                swal("Something went wrong!","","error").then(()=>{location.reload();});
            }
        });
    }
</script>

<!-- onsubmit="editProject();return false;"-->	
<!--
<div id="editProjectsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editProjectsModal')">×</span>
                    <h2>EDIT PROJECT DETAILS</h2>
            </div>
            <div class="modal-body">
          
                
                
                
<form method="GET" onsubmit="editProject();return false;" action="{{url('/editProject')}}"  id="editProjectForm">

    
		<input type="hidden" id="id" name="projectId" readonly>
		Name: <input type="text" id="projectName" name="projectName" class="form-control">
        <br>Description<textarea id="projectDescription" name="projectDescription" class="form-control"></textarea>
		!--Status: <input type="text" id="status" name="status" class="form-control">--
        @//if($type==='Director')
         <br>Status: 
            <select class="form-control" name="status" >
                <option id="projectStatus"></option>
                <option value="Approved">Approved</option>
                <option value="Reject">Reject</option>
            </select>
        @/endif
	   <input type="hidden" id="banner" name="banner" class="form-control">
		<br>
		<input type="submit" value="SUBMIT" class="btn btn-success">
	</form>	

                
                
            </div>
            <div class="modal-footer">
                <h3></h3>
            </div>
        </div>
    </div>-->