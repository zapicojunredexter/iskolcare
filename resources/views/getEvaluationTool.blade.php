<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Evaluation</title>
</head>

<body>  
    <div class="wrapper" style="background-color:#e6eaeb;">
        @include('forms.addQuestionForm')
        @include('forms.editQuestionForm')
        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @else
            @include('includes.regUserSidebar')
        @endif
        <div class="main-panel">
            <?php
                $label="Evaluation";
            ?>
            @include('includes.regUserHeader')
            <div class="content" style="min-height:20px;padding:10px;">
                      
                <ul class="breadcrumb" style="margin:0px;padding:0px;background:transparent;">
                    <li><a href="{{url('getAllEvaluationTools')}}">Evaluation Tools</a></li>
                    
                    <li><a href="#">{{$evaluationTool->EvaluationFormName}}</a></li>
                    <li></li>
                
                </ul>
            </div> 
            <div class="content" style="padding-top:0px;">
                <div class="container-fluid">
				
                    <div class="row" style="background-color:white;">
                        <div class="col-sm-12" style="text-align:center;background-color:#f1f1f1;">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h2 style="font-weight:bold;">{{strtoupper($evaluationTool->EvaluationFormName)}}</h2>
                                    <h3>{{$evaluationTool->EvaluationFormDescription}}</h3>
                                </div>
                                <div class="col-sm-3" style="padding:10px;margin-left:auto;">
                                    @if($checkIfReleased->Count === 0)
                                    <button style="float:right;background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" onclick="$('#addQuestionModal').modal('show');">
                                        + Add Question
                                    </button>
                                    @else
                                    <button style="float:right;background-color:#2196F3;padding:10px;border:solid black 0px;color:white;">
                                        This has been released to {{$checkIfReleased->Count}} Activities
                                    </button>
                                    
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <!-- start sa evaluation question-->
                        <?php
                        $counter=1;
                        ?>
                        @foreach($evaluationTool->Questions as $question)
                        <div class="col-sm-12" style="margin-top:20px;padding-left:20px;padding-right:20px;">
                        <div class="row">
                            <div class="col-sm-9">


                            <h4><?php echo $counter++.'. ';?>
                                {{$question->Question}}
                            </h4>

                            </div>
                            <div class="col-sm-3" style="text-align:right;">
                            @if($checkIfReleased->Count === 0)
                                    
                                <a href="#" onclick="editQuestion({{$question->QuestionId}})">
                                    <img src="default-img/edit.png" alt="edit" style="width:30px;height:30px;">
                                </a>
                                <a href="#" onclick="if(confirm('Are you sure you want to delete this question?')){window.location.href='{{url('deleteQuestion')}}?id={{$question->QuestionId}}'}">
                                    <img src="default-img/trash.png" alt="delete" style="width:30px;height:30px;">
                                </a>
                            @endif
                            </div>
                        </div>
                        <!--
                        <a class="glyphicon glyphicon-edit" style="font-size:13px; float: right; cursor:pointer; padding-top: 2px;padding-left: 5px;" onclick="editQuestion({{$question->QuestionId}});displayModal('editQuestionModal')">edit</a>
                        -->
                        <div class="row">
                            <div class="col-sm-12">
                            
                                @if($question->QuestionType === 'Open')
                                    <br><input type="text" class="form-control" style="border:solid silver 1px;" placeholder="Your Answer here">
                                @elseif($question->QuestionType === 'Checkbox')
                                    @foreach($question->Choices as $choice)
                                    <br><input type="checkbox"> {{$choice->ChoiceDescription}}
                                    @endforeach
                                @elseif($question->QuestionType === 'Radio')
                                    @foreach($question->Choices as $choice)
                                    <br><input type="radio"> <p style="display:inline;">{{$choice->ChoiceDescription}}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <hr>
                        </div>
                        @endforeach
                    
                    <!--end sa evaluation tools question-->
                    </div>
                </div>
            </div>
			<!-- start sa footer-->
            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
			
			<!-- end sa footer-->
        </div>
    </div>
    @include('includes.scripts')
    
</body>


</html>