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
        @elseif(Session::get('type')==='Registered User')
            @include('includes.regUserSidebar')
        @else
            @include('includes.superAdminSideBar')
        @endif
        <div class="main-panel">
            <?php
                $label="Evaluation Results";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content">



                <div class="container-fluid">
    
                    <div class="row">
                        
                        <div class="col-sm-12" style="text-align:center;background-color:#f1f1f1;">
                            <h2><a href="{{url('getActivityPage')}}?id={{$releasedForm->ActivityId}}" style="font-weight:bold;">{{strtoupper($releasedForm->ActivityName)}}</a></h2>        
                        </div>
                        <div class="col-sm-12" style="text-align:center;background-color:#f1f1f1;">
                            <h3>{{$releasedForm->EvaluationFormName}}</h3>
                        </div>
                        <div class="col-sm-12" style="background-color:white;">
                            <div class="nav nav-tabs justify-content-start" role="tablist">
                                <a class="nav-item nav-link active" href="#tab-summary" data-toggle="tab" style="color:black;padding:20px;text-align:center;" role="tab">SUMMARY</a>
                                <a class="nav-item nav-link" href="#tab-specific" data-toggle="tab" style="color:black;padding:20px;text-align:center;" role="tab">INDIVIDUAL</a>
                            </div>
                            <div class="tab-content" style="background-color:white;padding:20px;">
                                <div class="tab-pane fade show active" role="tabpanel" id="tab-summary">
                                    @include('includes.evaluationToolResults')
                                </div>
                                <div class="tab-pane fade show" role="tabpanel" id="tab-specific">
                                    <table class="table">
                                        <tr style="background-color:#1b593e;color:white;">
                                            <th>NAME</th>
                                            <th>VIEW</th>
                                        </tr>
                                        @foreach($respondents as $respondent)
                                        <tr>
                                            <td style="width:50%">{{$respondent->Name}} {{$respondent->LastName}}</th>
                                            <td style="width:50%">
                                                <a href="#" onclick="getUserAnswers({{$releasedForm->ReleasedFormId}},{{$respondent->AccountId}})" style="background-color:#2196F3;color:white;border:solid black 0px;padding:10px;">
                                                    View Results
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="display:none;" id="specific-results-{{$respondent->AccountId}}">
                                                    asdasd
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    <script>
                                        function getUserAnswers(rfId,userId){
                                            $.ajax({
                                                url: "{{ url('/getParticipantsAnswer') }}?rfid="+rfId+"&userId="+userId,
                                                type: "get", 
                                                success: function(response) {
                                                    //console.log(response);
                                                    
                                                    response=JSON.parse(response);
          
                                                    console.log(response);

                                                    $('#specific-results-'+userId).html('');
                                                    for(var i = 0;i<response.Questions.length;i++){
                                                        console.log(i);
                                                        console.log(response.Questions[i]);
                                                        $('#specific-results-'+userId).append(i + 1 +'. '+response.Questions[i].Question+'<br>');
                                                        for(var j = 0;j<response.Questions[i].Answers.length;j++){
                                                            $('#specific-results-'+userId).append('-'+response.Questions[i].Answers[j].Answer+'<br>');
                                                            //console.log(i);
                                                            //console.log(response.Questions[i].Answers[j]);
                                                        
                                                        }
                                                    }

                                                    $('#specific-results-'+userId).toggle('slide');
                                                    
                                                },
                                                error: function(xhr) {
                                                    alert("Data: error");
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>    

                        </div>
                    

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