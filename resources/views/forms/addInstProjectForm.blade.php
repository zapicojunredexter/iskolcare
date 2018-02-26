<!--
<form method="GET" onSubmit="addProject('{{ url('/addProject') }}');return false;" id="addProjectForm">
<div id="addInstProjectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addInstProjectModal')">×</span>
                    <h2>ADD NEW ACTIVITY</h2>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Name of Project" name="projectName" class="form-control"><br>
                <input type="text" placeholder="Project Description" name="projectDescription" class="form-control"><br>
                <input type="hidden" placeholder="Project Description" name="level" class="form-control" value="Institution" readonly>
                <input type="hidden" name="programId" value="{{Session::get('uniId')}}" class="form-control" readonly>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="SUBMIT">
                
            </div>
        </div>
    </div>
</form>	-->

<div class="modal fade" id="addInstProjectModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                Add New Institutional Level Project
            </div>
            <div class="modal-body" style="">

<!-- onSubmit="addProject('{{ url('/addProject') }}');return false;" -->
            <form method="GET" action="{{ url('/addProject') }}" onsubmit="return false;" id="addInstProject">
                <input onkeyup="checkInstProject()" type="text" placeholder="Name of Project" id="inst-project-name" name="projectName" class="form-control"><br>
                <!--
                <input onkeyup="checkInstProject()" type="text" placeholder="Project Description" id="inst-project-desc" name="projectDescription" class="form-control"><br>
                -->
                <textarea name="projectDescription" onkeyup="checkInstProject();" id="inst-project-desc" class="form-control" placeholder="Project Description"></textarea>
        
                <input type="hidden" placeholder="Project Description" name="level" class="form-control" value="Institution" readonly>
                <input type="hidden" name="programId" value="{{Session::get('uniId')}}" class="form-control" readonly>
            <button id="add-inst-button" onclick="this.disabled='true';addInstProject();" class="blue-button" disabled>SUBMIT</button>
            </form>	

            </div>                
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<script>
    function checkInstProject(){
        var projName,projDesc;
        projName = $('#inst-project-name').val();
        projDesc = $('#inst-project-desc').val();
        if(projName.trim()!=="" && projDesc.trim()!==""){
            $('#add-inst-button').prop('disabled',false);
        }else{
            $('#add-inst-button').prop('disabled',true);
        }
    }
    function addInstProject(){
        var projName,projDesc;
        projName = $('#inst-project-name').val();
        projDesc = $('#inst-project-desc').val();
        if(projName.trim()!=="" && projDesc.trim()!==""){

            $.ajax({
                url: "{{ url('/addProject') }}",
                type: "get", 
                data: $("#addInstProject").serialize(),
                success: function(response) {
                //alert("successfully added new project!");
                //location.reload();
                    if(response.indexOf("Successfully added new project")===0){
                        alert("Successfully added new project");
                        var projId=response.substring(30,response.length);
                    
                        window.location.href="{{url('getUniversityProject')}}?id="+projId+"#click-change-cover-photo";
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

        

