<div class="modal fade" id="editEvaluationToolModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                EDIT EVALUATION TOOL
            </div>
            <div class="modal-body" style="">
                    
            <form id="editEvaluationFormForm" method="get" onsubmit="editEvaluationTool();return false;">
                <input type="hidden" id="formId" name="formId" readonly>
                Form Name: 
                <input type="text" class="form-control" id="formName" name="formName"><br>
                Form Description:
                <input type="text" class="form-control" id="formDesc" name="formDesc"><br>
                <input type="submit" value="SUBMIT" class="btn btn-success">
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
                    alert('successfully edited evaluation tool');
                    location.reload();

                },
                error: function(xhr) {
                    console.log(xhr);
                    alert('error!');
                }
            });
                         
    }
</script>