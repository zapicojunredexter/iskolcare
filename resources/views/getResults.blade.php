<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>View Evaluation Tool Results</title>
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
                        <script>
                         function printToolResults(){
                            var w=window.open("printToolResults?rfid={{$releasedForm->ReleasedFormId}}");
                            //w.onload=function(){w.print();w.close()};   
                             /*
                              w.onload=function(){
                                
                                    w.print();
                                    w.close();
                                    w.close();
                                
                            
                          }
                             */
                              w.onload=function(){
                                
                                    //w.print();
                                    //w.close();
                                
                              }
                              /*
                                setTimeout(() => {
                                
                                        w.print();
                                        w.close();

                                    
                                },0);*/
                         }
                        </script>
                        <div class="col-sm-12" style="background-color:white;">
                            <div class="nav nav-tabs justify-content-start" role="tablist">
                                <a class="nav-item nav-link active" href="#tab-summary" data-toggle="tab" style="width:50%;font-weight:bold;color:black;padding:20px;text-align:center;" role="tab">SUMMARY</a>
                                <a class="nav-item nav-link" href="#tab-specific" data-toggle="tab" style="width:50%;font-weight:bold;color:black;padding:20px;text-align:center;" role="tab">INDIVIDUAL</a>
                            </div>
                            <div class="tab-content" style="background-color:white;padding:20px;">
                                <div class="tab-pane fade show active" role="tabpanel" id="tab-summary">
                                    <img src="default-img/print.png" alt="print" style="width:30px;" onclick="printToolResults()" title="Print Results">
                                    @include('includes.evaluationToolResults')
                                </div>
                                    
                                <div class="tab-pane fade show" role="tabpanel" id="tab-specific">
                                    <div class="row">
                                        
                                        <div class="col-sm-12" style="background-color:#1b593e;color:white;padding:10px;font-weight:bold;">
                                            <div style="width:45%;float:left;">NAME</div>
                                            <div>VIEW</div>
                                        </div>
                                        @for($i = 0 ;$i <sizeof($respondents); $i++)
                                            <div class="col-sm-12" style="background-color:{{$i%2 === 0 ? '#d6d9db':'#e2e5e7'}};">
                                                {{$respondents[$i]->Name}} {{$respondents[$i]->LastName}}
                                            <button class="blue-button" onclick="getUserAnswers({{$releasedForm->ReleasedFormId}},{{$respondents[$i]->AccountId}})">View</button>
                                            </div>
                                            <div class="col-sm-12" style="display:none;background-color:#f1f1f1;width:100%;" rowspan ="2" colspan="2" id="specific-results-{{$respondents[$i]->AccountId}}">
                                                
                                            </div>
                                            
                                        @endfor
                                    </div>
                                    <script>
                                        function getUserAnswers(rfId,userId){
                                            $.ajax({
                                                url: "{{ url('/getParticipantsAnswer') }}?rfid="+rfId+"&userId="+userId,
                                                type: "get", 
                                                success: function(response) {
                                                    //console.log(response);
                                                    console.log('ari nag start');
                                                    response=JSON.parse(response);
          

                                                    $('#specific-results-'+userId).html('');
                                                    for(var i = 0;i<response.Questions.length;i++){
                                                        //$('#specific-results-'+userId).append(i + 1 +'. '+response.Questions[i].Question+'<br>');
                                                        $('#specific-results-'+userId).append("<div class='row'><div class='col-sm-12'><h4>"+(i+1)+". "+response.Questions[i].Question+"</h4></div></div>");
                                                            
                                                        for(var j = 0;j<response.Questions[i].Answers.length;j++){
                                                            if(response.Questions[i].QuestionType==="Open"){
                                                             
                                                                $('#specific-results-'+userId).append(`<div class='row-12'><input type='text' class='form-control' value="`+response.Questions[i].Answers[j].Answer+`" readonly></div>`);
                                                               
                                                            }
                                                            if(response.Questions[i].QuestionType==="Checkbox"){
                                                                //for(var k=;k<response.Questions[i].Answers.length;k++)
                                                                $('#specific-results-'+userId).append(`<div class='row-12'><input type='checkbox'`+(response.Questions[i].Answers[j].isAnswer?'checked':'')+` disabled> `+response.Questions[i].Answers[j].ChoiceDescription+`</div>`);
                                                            }
                                                            // `+response.Questions[i].Answers[j].ChoiceDescription+`
                                                            
                                                            if(response.Questions[i].QuestionType==="Radio"){
                                                                //for(var k=;k<response.Questions[i].Answers.length;k++)
                                                                console.log('ara ay');
                                                                console.log(response.Questions[i]);
                                                                $('#specific-results-'+userId).append(`<div class='row-12'><input type='radio'`+(response.Questions[i].Answers[j].isAnswer?'checked':'')+` disabled>`+response.Questions[i].Answers[j].ChoiceDescription+`</div>`);
                                                            }
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