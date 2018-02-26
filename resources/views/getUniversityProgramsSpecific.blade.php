<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>{{$program->ProgramName}} Program</title>
</head>

<body>
    <div class="wrapper" style="background-color:#e6eaeb;">

    @if(Session::get('type') === 'Director' && Session::get('uniId') === $program->UniversityId)
        @include('forms.editProgramForm')
        @include('forms.changeProgramLogo')
    @endif
<!--TODO itrap ni-->
    @include('forms.addProjectForm')
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
                $label="Program";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            
            <div class="content" style="min-height:20px;padding:10px;">
                      
                <ul class="breadcrumb" style="margin:0px;padding:0px;background:transparent;">
                  
                    <li><a href="{{url('getUniversityProfile')}}?id={{$program->UniId}}">{{$program->UniName}}</a></li>
                    
                    <li><a href="#">{{$program->ProgramName}}</a></li>
                    <li></li>
                    <!--<li style="padding:10px;"><b style="margin-left:40px;">{{$program->ProgramName}}</b></li>-->
                
                </ul>
            </div> 

            <div class="content" style="padding-top:10px;">
            
       
                <div class="container-fluid">
				
                    <div class="row">
					
						<!-- start sa uni logo ug cover photo -->
						
                            <div class="col-md-12" style="height:220px;">
                               
							    <div style="width:30%;height:100%;float:left;">
                                    @if(Session::get('type')==='Director' && Session::get('uniId')===$program->UniId)
                                    <img
                                        id="click-change-program-logo"
                                        data-toggle="modal"
                                        data-target="#changeProgramLogo"
                                        src="img/logos/programs/{{$program->Logo}}"
                                        style="float: left; width: 100%; height: 100%; cursor: pointer;box-shadow:3px 3px 2px silver;">
                                    @else
                                    <img
                                        src="img/logos/programs/{{$program->Logo}}"
                                        style="float: left; width: 100%; height: 100%;">
                                    @endif
							    </div>




                                <div style="float: right;width: 70%;height: 100%;background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('img/logos/{{$program->CoverPhoto}}');background-repeat: no-repeat;background-position: center;background-size: 100%;padding-left: 30px;color:white;">
                                    <div style="float:right;">
                                        @if(Session::get('type')==='Director' && Session::get('uniId')===$program->UniId)
                                            <img src="default-img/edit.png" data-toggle="modal" data-target="#editProgramModal" style="width:20px;margin-right:5px;margin-top:5px;" alt="edit">
                                            <img src="default-img/trash.png" style="width:20px;margin-right:5px;margin-top:5px;" onclick="deleteProgram({{$program->ProgramId}})" alt="delete">
                                            <script>
                                                function deleteProgram(programId){
                                                    if(confirm('Are you sure you want to delete this program')){
                                                        location.href="{{url('deleteProgram')}}?id="+programId;
                                                    }
                                                }
                                            </script>
                                        @endif
                                    </div>
                                                        
                                    <small id="sm" style="font-size: 30px; margin-left: 2px;">{{$program->ProgramName}}</small>
                                    <br>
                                    <p id="sm" style="overflow-y:auto;overflow-x:hidden;height:50px;font-size: 15px; margin-left: 8px;">
                                        <?php echo nl2br($program->ProgramDescription); ?>
                                    </p>
                                    <br>
                                    <br>
                                    <p id="sm" style="overflow-y:auto;overflow-x:hidden;height:100px;font-size: 15px; margin-left: 10px; margin-right: 40px; text-align: justify;">
                                        <small style="margin-left: 50px;"></small>
                                        {{$program->ProgramObjective}}
                                      
                                    </p>
                                </div>
                                








							   
                            </div>

                        
					<!-- end sa uni logo ug cover photo -->

                        <!-- start sa varied contents-->
                        <div class="col-md-12">

                            <div class="row" style="margin-top:20px;">
                            <!--start sa left details-->
                                <div class="col-md-4">
                                
                                
                                    <!-- start sa graphs-->
                                    <!--div style="color:white;background-color:white;">
                                        
                                        
<canvas id="bar-chart" width="100%" height="100px" style=""></canvas>
                                        <script src="js/Chart.js">
                                        </script>
                                        <script src="js/Chart.bundle.js">
                                        </script>
                                        <script src="js/utils.js">
                                        </script>
                                        <script>

                                            loadBarChar();
    function loadBarChar(){
        var a={!!json_encode($program->Projects)!!};
        console.log(a);
        var projects=[];
        a.forEach((element) => {
            if(element.Status === "Approved")
                projects.push(element.ProjectName);
        });    
            
        var activityCount = [];
        a.forEach((element) => {
            var counter = 0;
            if(element.Status === "Approved"){
             
            element.Activities.forEach((activity) => {
                if(activity.ActivityStatus==="Approved"){
                    counter++;
                }
            });
            console.log('counter ai');
            console.log(counter);
            activityCount.push(counter);   
            }
            //return element.Activities.length;
        });
        console.log(projects);
        
        console.log(activityCount);
            
            
        new Chart(document.getElementById('bar-chart'),{
            type: 'bar',
            data: {
                labels: projects,
                datasets: [
                    {
                        label: "Activity Count",
                        backgroundColor: "#3e95cd",
                        data: activityCount,
                    },
                ]
            },
            options:{
                title:{
                    display: true,
                    text: 'Number of Activities',
                }
            }
        });
            
	
        
        
        
        
    }
                                        </script>
                                        
                                    </div>-->
                                    <!-- end sa graph-->

                                    <!-- start sa list of coordinators-->
                                         <div style="background-color: white;padding:20px;">
                                            <h6>Coordinator(s)</h6>
                                            
                                            <hr>

                                            @foreach($coordinators as $coordinator)  
                                                @if($coordinator->isActive === 1)                                              
                                                <div class="recentdetails">
                                                    <div class="projname" style="font-size: 15px;margin:15px;">
                                                        <img src="img/dp/{{$coordinator->DisplayPic}}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 50%;">
                                                        <a href="{{url('viewProfile')}}?accid={{$coordinator->AccountId}}" style="color: black;">{{$coordinator->Name}} {{$coordinator->LastName}}</a>
                                                        
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                            <div id="previous-coordinators" style="display:none;margin-top:50px;">
                                            <h6>Former Coordinator(s)</h6>
                                            
                                            <hr>
                                            @foreach($coordinators as $coordinator)  
                                                @if($coordinator->isActive === 0)                                              
                                                <div class="recentdetails">
                                                    <div class="projname" style="font-size: 15px;margin:15px;">
                                                        <img src="img/dp/{{$coordinator->DisplayPic}}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 50%;">
                                                        <a href="{{url('viewProfile')}}?accid={{$coordinator->AccountId}}" style="color: black;">{{$coordinator->Name}} {{$coordinator->LastName}}</a>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                            
                                            </div>
                                            <div onclick="toggleDetails();" id="show-or-hide" style="text-align:right;"><i>Show Former Coordinators </i><i class="nc-icon nc-stre-down"></i></div>
                                        
                                         </div>   

                                         <script>
                                            var flag = 1;
                                            function toggleDetails(){

                                                $('#previous-coordinators').toggle('slide');
                                                flag = flag * -1;
                                                if(flag === -1)
                                                    $('#show-or-hide').html('<i>Hide Former Coordinators </i><i class="nc-icon nc-stre-up"></i>');
                                                else
                                                    $('#show-or-hide').html('<i>Show Former Coordinators  </i><i class="nc-icon nc-stre-down"></i>');
                                                
                                            }
                                        </script>
                                    <!-- end sa list of coordinators-->

                                </div>
                            <!--end sa left details-->
                            
                            <!--start sa right details-->
                                <div class="col-md-8">
                                        <div style="background-color:white;padding:30px;">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <input onkeyup="filterProjects(this.value)" type="text" Placeholder="Search..." name="search" class="serch">
                                            </div>
                                            <div class="col-sm-4">
                                            @if((Session::get('type')==="Director" && Session::get('uniId') === $program->UniversityId)||(Session::get('type')==="Coordinator" && Session::get('programId') === $program->ProgramId))
                                                <button style="width:90%" class="blue-button" data-toggle="modal" data-target="#addProjectModal">+ ADD PROJECT</button>
                                            
                                            @endif
                                            
                                            </div>
                                        </div>
                                        
                                        <br><br>
                                        <script>
                                            function filterProjects(keyword){
                                                //alert(keyword);
                                                var a=$('.project-lists');
                                                for(var i = 0 ;i<a.length;i++){
                                                    //console.log(a[i].toString().toUpper().indexOf(keyword));
                                                    if(a[i].innerHTML.toUpperCase().indexOf(keyword.toUpperCase())>-1){
                                                        //console.log(a[i]);
                                                        //$('#project-'+i).css('display','block');
                                                        $('#project-parent-'+i).show();
                                                
                                                    }else{

                                                        //$('#project-'+i).css('display','none');
                                                        $('#project-parent-'+i).hide();
                                                
                                                    }
                                                }
                                            }
                                        </script>
                                        <!--start sa projects-->
                                        <div style="padding:20px;">
                                        
                                            @for($i = 0; $i < sizeof($program->Projects); $i++)
                                                
                                                <div class="row" id="project-parent-{{$i}}" style="border: 1px solid rgba(0,0,0,0.2);padding:20px;background: {{$i % 2 === 0 ? 'rgba(0,0,0,0.1)' : 'none'}}">
                                                    
                                                    <div class="col-sm-2">
                                                        <img src="img/logos/programs/{{$program->Projects[$i]->Banner}}" style="height:50px;width:50px;">
                                                    </div>
                                                    <div class="col-sm-8 project-lists">{{$program->Projects[$i]->ProjectName}}</div>
                                                    <div class="col-sm-2">
                                                        <a href="{{url('getUniversityProject')}}?id={{$program->Projects[$i]->ProjectId}}">
                                                            <button class="blue-button">
                                                                VIEW
                                                            </button>
                                                        </a>
                                                    </div>
                                                    
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <!--end sa projects-->
                                
                                </div>
                            <!--end sa right details-->
                            </div>
                           
                        </div>
                        
                        <!-- end sa varied contents-->
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