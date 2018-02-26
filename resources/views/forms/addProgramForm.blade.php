<div class="modal fade" id="addProgramModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                ADD UNIVERSITY PROGRAM
            </div>
            <div class="modal-body" style="">
            @if(sizeof($university->Programs) < Session::get('maxPrograms'))
            <form method="post" id="addProgramForm" onsubmit="return false;">
            {{csrf_field()}}
            <input type="text" placeholder="Program name" name="programName" id="program-name" class="form-control"><br>
    <textarea type="text" name="programDescription" class="form-control" id="program-desc" placeholder="Program Description"></textarea><br>
    <textarea type="text" name="programObjective" class="form-control" id="program-objec" placeholder="Objective(s)"></textarea><br>
    
    <input type="hidden" placeholder="universityId" name="universityId" value="{{$university->UniId}}" readonly>
    
                <input type="button" onclick="addProgram()" value="SUBMIT">
                </form>
                @else
                    Your account has reached its 3 max programs cap. click <a href="#">here</a> to add more.
                @endif
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>         
<script>
    /*window.onclick = function(event) {
    if (event.target == document.getElementById('addProgramForm')) {
        document.getElementById('addProgramForm').style.display = "none";
    }
    }*/
    function addProgram(){
        var progName,progDesc,progObj;
        progName = $('#program-name').val();
        progDesc = $('#program-desc').val();
        progObj = $('#program-objec').val();
        if(progName.trim()!=="" && progDesc.trim()!=="" && progObj.trim()!==""){
            $.ajax({
                url: "{{url('/addProgram')}}",
                data: $("#addProgramForm").serialize(),
                type: "post", 
                success: function(response) {
                    if(response.indexOf("Successfully added new program")===0){
                        alert("Successfully added new program");
                        var progId=response.substring(30,response.length);
                    
                        window.location.href="{{url('getUniversityProgramsSpecific')}}?id="+progId+"#click-change-program-logo";
                    }else{
                        alert(response);
                    }
                    //if(response === "Successfully added new program");
                    //location.reload();
                },
                error: function(xhr) {
                    alert("Something went wrong!");
                }
            });
        }else{
            alert('please fill up all fields');
        }
    }
</script>