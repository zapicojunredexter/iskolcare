<script>
    function editQuestion(questionId){
        document.getElementById("questionId").value=questionId;
        $.ajax({
            url: "{{url('getQuestion')}}?id="+questionId,
            type: "get", 
            success: function(response) {
                response=JSON.parse(response);
                document.getElementById("newQuestion").value=response.Question;
                console.log(response);
                if(response.QuestionType==="Open"){
                    $('#is-open-div').css('display','none');
                }else{
                    $('#is-open-div').css('display','block');
                    
                }
                 $('#choices-div').html("");

                for(var i=0;i<response.Choices.length;i++){
                    $('#choices-div').append("<input class='form-control' type='text' name='choice[]' value='"+response.Choices[i].ChoiceDescription+"'>");
                }
                $('#editQuestionModal').modal('show');
            },
            error: function(xhr) {
            }
        });
    }
    function submitQuestionChanges(){
        if(true){    
            $.ajax({
                url: "{{url('editQuestion')}}",
                type: "get",
                data: $('#editQuestionForm').serialize(), 
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('someting went wrong!');
                }
            });
            
        }
    }
    function addEditQuestionChoices(){
        $('#choices-div').append("<input class='form-control' type='text' name='choice[]' value=''>");
                
    }
    function checkEditQuestion(){
        var editQuestion = $('#newQuestion').val();
        if(editQuestion.trim()!==""){
            $('#edit-questions-button').prop('disabled',false);
        }else{
            $('#edit-questions-button').prop('disabled',true);
        }
    }
</script>

<div class="modal fade" id="editQuestionModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                EDIT QUESTION
            </div>
            <div class="modal-body" style="">


            <form id="editQuestionForm" action="{{url('editQuestion')}}" method="get">

                <input type="hidden" name="questionId" id="questionId">
                <div class="row">
                    <div class="col-sm-4">
                      <b>Question</b>
                    </div>
                    <div class="col-sm-8" style="margin-bottom:20px;">
                        <input onkeyup="checkEditQuestion();" type="text" name="question" id="newQuestion" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" id="is-open-div">
                        <b>Choices:</b>
                        
                      <br>
                        <img src="default-img/add.png" style="width:25px;" onclick="addEditQuestionChoices();">
                        <!--
                        <button type="button" onclick="addEditQuestionChoices();">Add choices</button>
                        -->
                    </div>
                    <div class="col-sm-8" id="choices-div">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <br>
                        <input class="blue-button" style="margin-left:40%;" type="button" id="edit-questions-button" onclick="submitQuestionChanges()" value="SUBMIT">
                    </div>
                </div>
            </form>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
         