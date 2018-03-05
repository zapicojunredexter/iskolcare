<div class="modal fade" id="editEvaluationToolModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT EVALUATION TOOL
                
                <span onclick="$('#editEvaluationToolModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
            <form id="editEvaluationFormForm" method="get" onsubmit="editEvaluationTool();return false;">
                <input type="hidden" id="formId" name="formId" value="{{!empty($evaluationTool->EvaluationFormId)?$evaluationTool->EvaluationFormId:''}}" readonly>
                Form Name: 
                <input type="text" class="form-control" value="{{!empty($evaluationTool->EvaluationFormName)?$evaluationTool->EvaluationFormName:''}}" id="formName" name="formName"><br>
                Form Description:
                <input type="text" class="form-control" value="{{!empty($evaluationTool->EvaluationFormDescription)?$evaluationTool->EvaluationFormDescription:''}}" id="formDesc" name="formDesc"><br>
                <input type="submit" value="SUBMIT" class="blue-button" style="margin-left:40%;">
            </form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
    function editEvaluationTool(){
            $.ajax({
                url: "{{url('editEvaluationTool')}}",
                type: "get", 
		        data: $("#editEvaluationFormForm").serialize(),
                success: function(response) {
//                    alert('successfully edited evaluation tool');
                    swal("successfully edited evaluation tool","","success").then(()=>{location.reload();});



                },
                error: function(xhr) {
                    console.log(xhr);
                    swal("Something went wrong!","","error").then(()=>{});

                }
            });
                         
    }
</script>