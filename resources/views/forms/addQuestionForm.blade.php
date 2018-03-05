

<div class="modal fade" id="addQuestionModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>ADD NEW QUESTION</h5>
            </div>
            <div class="modal-body" style="padding:20px;">



<form id="questionForm" action="{{url('addQuestion')}}" method="get">                    
    <div class="row">
        <div class="col-sm-8">
            <input type="text" onkeyup="checkQuestion()" id="add-question" placeholder="Question" name="question" class="form-control" style="border:solid silver 1px;">
        </div>
        <div class="col-sm-4">
            <select id="q-type-dropdown" onchange="onChangeQType(this.value)" class="form-control" style="border:solid silver 1px;">
                <option value="op">Open Ended Question</option>
                <option value="ra">Radio Question</option>
                <option value="ch">Checkbox Question</option>
            </select>
        </div>
        <div class="col-sm-12">
            <div class="row" id="choices-container">

            </div>
            <div class="row" id="if-add" style="display:none;">
                <img src="default-img/add.png" style="width:25px;" title="Add more Choices" onclick="addMoreCheckChoices()" >
            </div>
        </div>
    </div>
           
    <input type="hidden" value="{{$evaluationTool->EvaluationFormId}}" name="formId" readonly>
    <input type="hidden" id="questionType" value="Open" name="questionType" readonly>
    <!--
    <div id="questions-container">
        Questions
    </div>
    <div id="choices-container">
        Choices
    </div>
    -->
    <br>
    <button id="add-quesitons-button" onclick="this.disabled='true';this.form.submit();" class="blue-button" style="margin-left:45%;" disabled>
        SUBMIT
    </button>
    
</form>



            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<!--
Select Question Type<br>
<button onclick="addOpenQuestion();">Open</button>
<button onclick="addRadioQuestion();">Radio</button>
<button onclick="addCheckboxQuestion();">Checkbox</button>
<form id="questionForm" action="{{url('addQuestion')}}" method="get">
    <input type="hidden" value="{{$evaluationTool->EvaluationFormId}}" name="formId" readonly>
    <input type="hidden" id="questionType" name="questionType" readonly>
    <div id="questions-container">
        Questions
    </div>
    <div id="choices-container">
        Choices
    </div>
    <input type="submit" value="ok">
</form>-->


<script src="js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
    function checkQuestion(){
        var question = $('#add-question').val();
        if(question.trim()!==""){
            $('#add-quesitons-button').prop('disabled',false);
        }else{
            $('#add-quesitons-button').prop('disabled',true);
        }
    }
    function addMoreCheckChoices(){
        //$('#choices-container').append('<div class="col-sm-1" style="margin-top:10px;"><input type="checkbox"></div><div style="margin-top:10px;" class="col-sm-11"><input style="width:100%;" placeholder="Option 1" type="text" class="form-control" name="choice[]"></div>');
        if($('#q-type-dropdown').val() === "ra"){
            $('#choices-container').append('<div class="col-sm-1" style="margin-top:10px;"><input type="radio"></div><div style="margin-top:10px;" class="col-sm-11"><input style="width:100%;" placeholder="Option" type="text" class="form-control" name="choice[]"></div>');
          
        }else if($('#q-type-dropdown').val() === "ch"){
            $('#choices-container').append('<div class="col-sm-1" style="margin-top:10px;"><input type="checkbox"></div><div style="margin-top:10px;" class="col-sm-11"><input style="width:100%;" placeholder="Option" type="text" class="form-control" name="choice[]"></div>');
        
        }
    }
    function onChangeQType(val){
        if(val === "op"){
            addOpenQuestion();
        }else if(val === "ra"){
            addRadioQuestion();
        }else if(val === "ch"){
            addCheckboxQuestion();
        }
    }
    function addOpenQuestion(){
        //$.("#questions-container").html("-");
        document.getElementById("questionType").value="Open";
        //document.getElementById("questions-container").innerHTML="<input class='form-control' placeholder='Type in your open ended Question' type='text' name='question'>";
        document.getElementById("choices-container").innerHTML="";
        
        $('#if-add').css('display','none');
    }
    function addRadioQuestion(){
        document.getElementById("questionType").value="Radio";
        //document.getElementById("questions-container").innerHTML="<input class='form-control' placeholder='Type in your radiobox Question' type='text' name='question'>";
        //document.getElementById("choices-container").innerHTML="Choices:<br><input placeholder='Option 1' type='text' class='form-control' name='choice[]'><input type='text' placeholder='Option 2' class='form-control' name='choice[]'><input type='text' placeholder='Option 3' class='form-control' name='choice[]'>";
        $('#choices-container').html('<div class="col-sm-1" style="margin-top:10px;"><input type="radio"></div><div style="margin-top:10px;" class="col-sm-11"><input style="width:100%;" placeholder="Option" type="text" class="form-control" name="choice[]"></div>');
        
        $('#if-add').css('display','block');
    }
    function addCheckboxQuestion(){
        document.getElementById("questionType").value="Checkbox";
        //document.getElementById("questions-container").innerHTML="<input class='form-control' placeholder='Type in your checkbox Question' type='text' name='question'>";
        //document.getElementById("choices-container").innerHTML="Choices:<br><input type='checkbox'><input style='width:80%;' placeholder='Option 1' type='text' class='form-control' name='choice[]'><input type='text' placeholder='Option 2' class='form-control' name='choice[]'><input type='text' placeholder='Option 3' class='form-control' name='choice[]'>";
        $('#choices-container').html('<div class="col-sm-1" style="margin-top:10px;"><input type="checkbox"></div><div style="margin-top:10px;" class="col-sm-11"><input style="width:100%;" placeholder="Checkbox Option" type="text" class="form-control" name="choice[]"></div>');
        
        $('#if-add').css('display','block');
    }

</script>
