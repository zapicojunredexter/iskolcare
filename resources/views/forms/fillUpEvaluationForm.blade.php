<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
</head>

<body>  
    <div class="wrapper" style="background-color:#e6eaeb;">
        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @else
            @include('includes.regUserSidebar')
        @endif
        <div class="main-panel">
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				
                    <div class="row" style="background-color:white;">

                    <div class="col-sm-12">          
                        <form method="post" action="{{url('submitEvaluationForm')}}">
                        {{csrf_field()}}
                    
                        <input type="hidden" name="notifId" value="{{$notifId}}" readonly>
                        
                        <input type="hidden" name="relfId" value="{{$releasedForm->ReleasedFormId}}" readonly>
                            <div class="row">
                                <div class="col-sm-12" style="width:100%;text-align:center;background-color:#f1f1f1;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h2 style="font-weight:bold;">{{$releasedForm->Form->EvaluationFormName}}</h2>
                                            <h3>for the {{$releasedForm->ActivityName}} Activity</h3>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- start sa evaluation question-->
                                <?php
                                $counter=1;
                                ?>
                                @foreach($releasedForm->Form->Question as $question)
                                <div class="col-sm-12" style="margin-top:20px;padding-left:20px;padding-right:20px;">
                                <div class="row">
                                    <div class="col-sm-12">


                                    <h4 style="font-weight:bold;"><?php echo $counter++.'. ';?>
                                    {{$question->Question}}</h4>

                                    </div>
                                </div>
                                <!--
                                <a class="glyphicon glyphicon-edit" style="font-size:13px; float: right; cursor:pointer; padding-top: 2px;padding-left: 5px;" onclick="editQuestion({{$question->QuestionId}});displayModal('editQuestionModal')">edit</a>
                                -->
                                <div class="row">
                                    <div class="col-sm-12">
                                    
                                        @if($question->QuestionType === 'Open')
                                            <br><input type="text" name="{{$question->QuestionId}}" class="form-control" style="border:solid silver 1px;" placeholder="Your Answer here">
                                        @elseif($question->QuestionType === 'Checkbox')
                                            @foreach($question->Choices as $choice)
                                            <br><input type="checkbox" value="{{$choice->ChoiceDescription}}" name="{{$question->QuestionId}}[]"> {{$choice->ChoiceDescription}}
                                            @endforeach
                                        @elseif($question->QuestionType === 'Radio')
                                            @foreach($question->Choices as $choice)
                                            <br><input type="radio" value="{{$choice->ChoiceDescription}}" name="{{$question->QuestionId}}"> <p style="display:inline;">{{$choice->ChoiceDescription}}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                </div>
                                @endforeach
                                                
                            <input type="submit" value="SUBMIT">
                            </div>
                        </form>
                    </div>
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