<div class="modal fade" id="assignEvaluationToolModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                RELEASE EVALUATION TOOL
                <span onclick="$('#assignEvaluationToolModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                    
            

            <form method="get" id="assignEvalToolForm" onsubmit="return false;" action="{{url('assignEvaluationTool')}}">
            <input type="hidden" name="activityId" value="{{$activity->ActivityId}}"><br>
           
            <div class="row">
                <div class="col-sm-3">Select form</div>
                <div class="col-sm-9"> 
                    <select name="formId" class="form-control" required>
                        @foreach($evaluationTools as $evaluationTool)
                            <option value="{{$evaluationTool->EvaluationFormId}}">{{$evaluationTool->EvaluationFormName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">From Date</div>
                <div class="col-sm-9">
                    <input type="date" value="{{date('Y-m-d')}}" onchange="checkEvaluationTool();" id="fromDate" name="fromDate" class="form-control" readonly>

                </div>
                <div class="col-sm-3">To Date</div>
                <div class="col-sm-9">
                    <input type="date" value="{{date('Y-m-d')}}" onchange="checkEvaluationTool();" id="toDate" name="toDate" class="form-control">
                </div>
                <div class="col-sm-3">To be answered by:</div>
                <div class="col-sm-9">    
                    <select name="answeredBy" class="form-control" required>
                        <option value="Student Volunteers">Student Volunteers</option>
                        <option value="Faculty Volunteers">Faculty Volunteers</option>
                        <option value="External Volunteers">External Volunteers</option>
                        <option value="Beneficiaries">Beneficiaries</option>
                        <option value="Leaders">Leaders</option>
                    </select>
                </div>


            </div>
            <button id="release-evaluation-button" type="button" onclick="this.disabled='true';assignEvaluationTool();" class="blue-button" style="margin-left:40%;">SUBMIT</button>
        </form>
        <script>
            
            function checkEvaluationTool(){
                if($('#fromDate').val() === "" || $('#toDate').val()===""){
                    $('#release-evaluation-button').prop('disabled',true);
                }else{
                    $('#release-evaluation-button').prop('disabled',false);
                }
            }
            function assignEvaluationTool(){
                if($('#fromDate').val() === "" || $('#toDate').val()===""){
                    alert('Please enter dates');
                    return;
                }
                if($('#fromDate').val()<=$('#toDate').val()){
                    $.ajax({
                        url: "{{ url('/assignEvaluationTool') }}",
                        type: "get", 
                        data: $("#assignEvalToolForm").serialize(),
                        success: function(response) {
                        alert("successfully released tool activity");
                        location.reload();
                        },
                        error: function(xhr) {
                            alert("something went wrong");
                        }
                    });
                }else{
                    alert('To Date cannot be before From Date');
                    $('#release-evaluation-button').attr('disabled',false);
                }
            }
        </script>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
