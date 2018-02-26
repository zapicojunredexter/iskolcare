
<form method="get" onsubmit="addEvaluationForm();return false;" id="addEvaluationFormForm" action="{{url('addEvaluationTool')}}">
    
<div class="modal fade" id="addEvaluationToolModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                ADD NEW EVALUATION TOOL
            </div>
            <div class="modal-body" style="">
                
                

    
                
                
            <input type="hidden" 
           name="uniId"
           value="{{Session::get('uniId')}}"
           readonly>
    <input onkeyup="checkAddEvaluationForm()" class="form-control" id="add-tool-name" type="text" name="toolName" placeholder="Name of Evaluation Form"><br>
    <input onkeyup="checkAddEvaluationForm()" class="form-control" id="add-tool-desc" type="text" name="toolDesc" placeholder="Description"><br>
    <select name="programId" class="form-control">
    
        <option value="">-</option>
        @foreach($programs as $program)
            <option value="{{$program->ProgramId}}">{{$program->ProgramName}}</option>
        @endforeach
    </select>
    <br>
    <button class="blue-button" style="margin-left:40%;" id="add-evaluation-tool-button" type="button" onclick="this.disabled='true';addEvaluationForm()" disabled>
        SUBMIT
    </button>
 
            




            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

</form>

     
                
                
                
                
                
            


      <script>
        function checkAddEvaluationForm(){
            var addToolName,addToolDesc;
            addToolName=$('#add-tool-name').val();
            addToolDesc=$('#add-tool-desc').val();
            if(addToolName.trim()!==""&&addToolDesc.trim()!==""){
                $('#add-evaluation-tool-button').prop('disabled',false);
            }else{
                $('#add-evaluation-tool-button').prop('disabled',true);    
            }
        }
          function addEvaluationForm(){
                 $.ajax({
                    url: "{{url('addEvaluationTool')}}",
		            data: $("#addEvaluationFormForm").serialize(),
                    type: "get", 
                    success: function(response) {
                      alert("Successfully added new evaluation form");
                      
                      location.reload();
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                    }
                });
              }
    
      </script>