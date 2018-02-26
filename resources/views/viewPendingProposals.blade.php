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
				
                    <div class="row">
                        <div class="col-sm-12">
                            <script>
                                function changeTab(option){
                                    var list = ['all-activities','projects','activities'];
                                    for(var i = 0; i<list.length;i++){
                                        if(option === list[i]){
                                            $('#'+list[i]+'-tab').attr('class','nav-item nav-link active');
                                            $('#tab-'+list[i]).attr('class','tab-pane fade show active');
                                        
                                        }else{

                                            $('#'+list[i]+'-tab').attr('class','nav-item nav-link');
                                            $('#tab-'+list[i]).attr('class','tab-pane fade show');
                                        
                                        }
                                    }
                                }
                            </script>
                            <div class="nav nav-tabs justify-content-start" role="tablist">
                                <a class="nav-item nav-link active" onclick="changeTab('all-activities')" id="all-activities-tab" href="#all-activities-tab"style="width:33%;color:black;padding:20px;text-align:center;">ALL</a>
                                <a class="nav-item nav-link" onclick="changeTab('projects')" id="projects-tab" href="#projects-tab" style="width:33%;color:black;padding:20px;text-align:center;">{{sizeof($myPendingProjects)}} PROJECTS</a>
                                <a class="nav-item nav-link" onclick="changeTab('activities')" id="activities-tab" href="#activities-tab" style="width:33%;color:black;padding:20px;text-align:center;">{{sizeof($myPendingActivities)}} ACTIVITIES</a>
                                
                            </div>
                            <div class="tab-content" style="background-color:white;padding:20px;">
                                
                                <!-- start of all -->
                                <div class="tab-pane fade show active" id="tab-all-activities">
                                    <table class="table-striped" style="border:solid silver 1px;width:100%">
                                        <tr style="background-color:#1b593e;color:white;">
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-10" style="font-weight:bold;">ALL ACTIVITIES</div>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    
                                        @foreach($allProjects as $upComingAct)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-10" style="color:{{$upComingAct->SchedDate<date('Y-m-d')?'silver':'black'}};">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <img style="width:100px;height:100px;" src="img/logos/programs/{{$upComingAct->Banner}}" alt="">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <h4 style="display:inline;"><a href="{{url('getActivityPage')}}?id={{$upComingAct->ActivityId}}">{{$upComingAct->ActivityName}}</a></h4><br>
                                                            
                                                                of the <a href="{{url('getUniversityProject')}}?id={{$upComingAct->ProjectId}}">{{$upComingAct->ProjectName}}</a> Project
                                                                <br>
                                                                {{date("M jS, Y",strtotime($upComingAct->SchedDate))}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                    </table>
                                        
                                </div>
                                <!-- end of all -->
                                
                                <!-- start of pending projects -->
                                <div class="tab-pane fade show" id="tab-projects">
                                    <form id="projects-form" action="{{url('approveProjects')}}">
                                        <table class="table-striped" style="border:solid silver 1px;width:100%">
                                            <tr style="background-color:#1b593e;color:white;">
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-10" style="font-weight:bold;">PENDING PROJECTS</div>
                                                        @if(Session::get('type')==="Director")
                                                            <div class="col-sm-2"><input type="checkbox"></div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        
                                            @foreach($myPendingProjects as $project)
                                            <tr>
                                                <td>
                                                    <div class="row" style="">
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <img style="width:100px;height:100px;" src="img/logos/programs/{{$project->Banner}}" alt="">
                                                                </div>
                                                                <div class="col-sm-10" style="padding-top:20px;">
                                                                    <h4 style="display:inline;"><a href="{{url('getUniversityProject')}}?id={{$project->ProjectId}}" style="color:black">{{$project->ProjectName}}</a></h4><br>
                                                                    by the <a href="{{url('getUniversityProgramsSpecific')}}?id={{$project->ProgramId}}">{{$project->ProgramName}}</a> Program
                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(Session::get('type')==="Director")
                                                        <div class="col-sm-2"><input type="checkbox" name="projectIds[]" value="{{$project->ProjectId}}"></div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                        </table>
                                        @if(Session::get('type')==="Director")
                                        <div style="text-align:center;margin-top:10px;">
                                            <button type="button" onclick="approveProjects()" style="background-color:#2196f3;color:white;padding:10px;border-radius:5px;border:solid black 0px;">APPROVE</button>
                                            <button type="button" onclick="rejectProjects()" style="background-color:#f2575f;color:white;padding:10px;border-radius:5px;border:solid black 0px;">DELETE</button>
                                        </div>
                                        @endif
                                    </form>
                                    @if(Session::get('type')==="Director")
                                    <script>      
                                        function approveProjects(){
                                            $.ajax({
                                                url: "{{url('approveProjects')}}",
                                                type: "get", 
                                                data: $("#projects-form").serialize(),
                                                success: function(response) {
                                                    alert("successfully approved projects");
                                                    location.reload();
                                                },
                                                error: function(xhr) {
                                                    alert("Something went wrong!");
                                                }
                                            });
                                        }
                                        
                                        function rejectProjects(){
                                            $.ajax({
                                                url: "{{ url('/rejectProjects') }}",
                                                type: "get", 
                                                data: $("#projects-form").serialize(),
                                                success: function(response) {
                                                alert("successfully deleted projects");
                                                location.reload();
                                                },
                                                error: function(xhr) {
                                                    alert("Data: error");
                                                }
                                            });
                                        }

                                    </script>
                                    @endif
                                </div>
                                <!-- start of pending projects -->

                                <!-- start of pending activities -->
                                <div class="tab-pane fade show" id="tab-activities">
                                   <form id="activities-form" action="{{url('approveActivities')}}" method="get">
                                    
                                        <table class="table-striped" style="border:solid silver 1px;width:100%">
                                            <tr style="background-color:#1b593e;color:white;">
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-10" style="font-weight:bold;">PENDING ACTIVITIES</div>
                                                        @if(Session::get('type')==="Director")
                                                        <div class="col-sm-2"><input type="checkbox"></div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        
                                            @foreach($myPendingActivities as $activity)
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <img style="width:100px;height:100px;" src="img/logos/programs/{{$activity->Banner}}" alt="">
                                                                </div>
                                                                <div class="col-sm-10" style="padding-top:20px;">
                                                                    <h4 style="display:inline;"><a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}" style="color:black">{{$activity->ActivityName}}</a></h4><br>
                                                                
                                                                    by the <a href="">{{$activity->ProjectName}}</a> of the <a href="{{url('getUniversityProgramsSpecific')}}?id={{$activity->ProgramId}}">{{$activity->ProgramName}}</a> Program
                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(Session::get('type')==="Director")
                                                        <div class="col-sm-2"><input type="checkbox" name="activityIds[]" value="{{$activity->ActivityId}}"></div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                        </table>
                                        @if(Session::get('type')==="Director")
                                        <div style="text-align:center;margin-top:10px;">
                                            <button onclick="approveActivities()" type="button" style="background-color:#2196f3;color:white;padding:10px;border-radius:5px;border:solid black 0px;">APPROVE</button>
                                            <button onclick="rejectActivities()" type="button" style="background-color:#f2575f;color:white;padding:10px;border-radius:5px;border:solid black 0px;">DELETE</button>
                                        </div>
                                        @endif
                                    </form>
                                    @if(Session::get('type')==="Director")
                                    <script>
                                        
                                        
                                        function approveActivities(li){
                                            $.ajax({
                                                url: "{{url('approveActivities')}}",
                                                type: "get", 
                                                data: $("#activities-form").serialize(),
                                                success: function(response) {
                                                    alert("successfully approved activity");
                                                    location.reload();
                                                },
                                                error: function(xhr) {
                                                    alert("Something went wrong!");
                                                }
                                            });
                                        }
                                        
                                        function rejectActivities(li){
                                            $.ajax({
                                                url: "{{ url('/rejectActivities') }}",
                                                type: "get", 
                                                data: $("#activities-form").serialize(),
                                                success: function(response) {
                                                alert("successfully deleted activities");
                                                location.reload();
                                                },
                                                error: function(xhr) {
                                                    alert("Data: error");
                                                }
                                            });
                                        }

                                    </script>
                                    @endif
                                </div>
                                
                                <!-- end of pending activities -->
                            </div>
                        </div>
                        <div class="col-sm-12">
                            
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