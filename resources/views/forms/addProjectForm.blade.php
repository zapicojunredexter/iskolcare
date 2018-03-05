<div class="modal fade" id="addProjectModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                ADD NEW PROJECT
                
                <span onclick="$('#addProjectModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                    
            
            <form method="GET" onSubmit="return false;" id="addProjectForm">
	
            
            
            
		<input type="text" onkeyup="checkAddProgramProject();" id="project-name" placeholder="Name of Project" name="projectName" class="form-control"><br>
		<!--
        <input type="text" onkeyup="checkAddProgramProject();" id="project-desc" placeholder="Project Description" name="projectDescription" class="form-control"><br>
        -->
        <textarea name="projectDescription" onkeyup="checkAddProgramProject();" id="project-desc" class="form-control" placeholder="Project Description"></textarea>
        
		<input type="hidden" name="programId" value="{{$program->ProgramId}}" class="form-control" readonly>
        <br>
       <button id="add-program-project" style="margin-left:40%;" class="blue-button" onclick="this.disabled='true';addProject();" disabled>SUBMIT</button>
            
            
            
            
            </form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>




        <!--

  <div id="addProjectModal1" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addProjectModal')">×</span>
                    <h2>ADD NEW PROJECT</h2>
            </div>
            <div class="modal-body">
               
		<input type="text" placeholder="Name of Project" name="projectName" class="form-control"><br>
		<input type="text" placeholder="Project Description" name="projectDescription" class="form-control"><br>
		<input type="hidden" name="programId" value="" class="form-control" readonly>
		<input type="submit" value="SUBMIT" class="btn btn-success">
                
                
                
                
            </div>
            <div class="modal-footer">
                <h3></h3>
            </div>
        </div>
    </div>  
    
    	</form>	-->
<script>
    function checkAddProgramProject(){
        var projName,projDesc;
        projName = $('#project-name').val();
        projDesc = $('#project-desc').val();
        if(projName.trim()!=="" && projDesc.trim()!==""){
            $('#add-program-project').prop("disabled",false);
        }else{
            $('#add-program-project').prop("disabled",true);
            
        }
    }
    function addProject(){
        var projName,projDesc;
        projName = $('#project-name').val();
        projDesc = $('#project-desc').val();
        if(projName.trim()!=="" && projDesc.trim()!==""){
            $.ajax({
                url: "{{ url('/addProject') }}",
                type: "get", 
                data: $("#addProjectForm").serialize(),
                success: function(response) {
                //location.reload();
                    if(response.indexOf("Successfully added new project")===0){
                        
                        swal("Successfully added new project","","success").then(()=>{
                            var projId=response.substring(30,response.length);
                    
                            window.location.href="{{url('getUniversityProject')}}?id="+projId+"#click-change-cover-photo";
                    
                        });

                        }else{
                        alert(response);
                    }
                },
                error: function(xhr) {
                    alert("something went wrong!");
                }
            });
        }else{
            alert('please fill in all fields');
        }
}

</script>