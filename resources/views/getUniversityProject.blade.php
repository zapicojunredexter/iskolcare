<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>{{$project->ProjectName}} Project</title>
</head>

<body>

    @include('forms.addActivityForm')
    @include('forms.editProjectForm')
    @include('forms.changeProjectBannerForm')
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
                $label="Project";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content" style="min-height:20px;padding:10px;">
                      
                <ul class="breadcrumb" style="margin:0px;padding:0px;background:transparent;">
                    <li><a href="{{url('getUniversityProfile')}}?id={{$university->UniId}}">{{$university->UniName}}</a></li>
                    @if(!empty($university->ProgramName))
                    <li><a href="{{url('getUniversityProgramsSpecific')}}?id={{$university->ProgramId}}">{{$university->ProgramName}}</a></li>
                    @endif
                    <li><a href="#">{{$project->ProjectName}}</a></li>
                    <li></li>
                <!--
                    <li style="padding:10px;"><a style="margin-left:40px;">{{$project->ProjectName}}</a></li>
                -->
                </ul>
            </div> 

            <div class="content" style="padding-top:0px;">
                <div class="container-fluid" style="padding:0px;">
				
                    <div class="row">
            
                        <!--start sa project details-->
                            
                        <div class="col-sm-12">
                            <div class="row" style="background-color:white;padding:30px;">
                                <div class="col-sm-1">
                                
                                    @if($canEdit === 1)
                                        <img
                                            id="click-change-cover-photo"
                                            data-toggle="modal"
                                            data-target="#changeProjectBannerModal"
                                            src="img/logos/programs/{{$project->Banner}}"
                                            style="width:70px;">
                                    @else
                                        <img
                                            src="img/logos/programs/{{$project->Banner}}"
                                            style="width:70px;">

                                    @endif
                                
                                
                                </div>
                                <div class="col-sm-8">
                                    <b style="font-size: 20px;color:{{$project->Status === 'Approved'? 'black' : 'red'}};">{{$project->ProjectName}}</b>
                                    <br>
                                    <small style="color: black; font-size: 12px;">
                                        @if(!empty($university->ProgramName))
                                        by the <a href="{{url('getUniversityProgramsSpecific')}}?id={{$university->ProgramId}}">{{$university->ProgramName}}</a> Program
                                        @endif
                                        of the <a href="{{url('getUniversityProfile')}}?id={{$university->UniId}}">{{$university->UniName}}</a>
                                    </small>
                                    <br>
                                    @if($canEdit === 1)
                                        <small>
                                            Project Status:<a>{{$project->Status}}</a>
                                        </small>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    
                                    <div class="row">
                                    @if($canEdit === 1)
                                        <div class="col-sm-3">
                                            <img src="default-img/edit.png" data-toggle="modal" data-target="#editProjectModal" data-toggle="tooltip" title="Edit Project Details" style="width:20px;margin-right:5px;" alt="edit">
                                        </div>
                                        @if((Session::get('type') === "Director") || (Session::get('type')==="Coordinator" && $project->Status === "Pending for Add"))
                                        
                                        <div class="col-sm-3">
                                            <img data-toggle="tooltip" title="Delete this Project" onclick="deleteThisProject({{$project->ProjectId}})" src="default-img/trash.png" style="width:20px;;" alt="delete">                  
                                        </div>
                                        <script>
                                            function deleteThisProject(projectId){
                                                if(confirm('Are you sure you want to delete this project')){
                                                    window.location.href="{{url('deleteProject')}}?id="+projectId;
                                                }
                                            }
                                        </script>
                                        @endif
                                        
                                    @endif    
                                    </div>
                                        
                                
                                </div>
                            </div>
                        </div>
                        <!--end sa project details-->




					
						<!-- start sa varied contents-->
                        <div class="col-md-12">

                            <div class="row" style="margin-top:20px;">
                            <!--start sa left details-->
                                <div class="col-md-12" style="">
                                       
                                    <!-- start sa graphs-->
                                    <div style="color:white;background-color:white;padding:20px;">
                                    
                                    <canvas height="100" id="bar-chart"></canvas>
                                        <script src="js/Chart.js">
                                        </script>
                                        <script src="js/Chart.bundle.js">
                                        </script>
                                        <script src="js/utils.js">
                                        </script>
                                        <script>

                                            loadBarChar();
    function loadBarChar(){
        var a={!!json_encode($finalDatesArray)!!};
        console.log(a);
            
        var dates = a.map((element) => {
            return getMonthString(Number(element.Date.substr(5,2)));
        });
        var volC = a.map((element) => {
            return element.VolCount;
        });
        var benC = a.map((element) => {
            return element.BenCount;
        });

            
            
        new Chart(document.getElementById('bar-chart'),{
            type: 'bar',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Volunteers",
                        backgroundColor: "#3e95cd",
                        data: volC,
                    },
                    {
                        label: "Beneficiaries",
                        backgroundColor: "#336699",
                        data: benC,
                    },
                ]
            },
            options:{
                title:{
                    display: true,
                    text: 'Number of Participants in the last Year',
                }
            }
        });
            
	
        
        
        
        
    }


    function getMonthString(month){
        var strMonth="";
        switch(month){
            case 1 :
                strMonth="January";
                break;
            case 2 :
                strMonth="February";
                break;
            case 3 :
                strMonth="March";
                break;
            case 4 :
                strMonth="April";
                break;
            case 5 :
                strMonth="May";
                break;
            case 6 :
                strMonth="June";
                break;
            case 7 :
                strMonth="July";
                break;
            case 8 :
                strMonth="August";
                break;
            case 9 :
                strMonth="September";
                break;
            case 10 :
                strMonth="October";
                break;
            case 11 :
                strMonth="November";
                break;
            case 12 :
                strMonth="December";
                break;
        }
        return strMonth;
    }
                                        </script>
                                        
                                    </div>
                                    <!-- end sa graph-->

                                    
                                </div>
                            <!--end sa left details-->
                            
                            <!--start sa right details-->
                                <div class="col-md-4">
                                    <div style="padding-top:15px;">
                                        <div style="background-color:#1b593e;color:white;padding:20px;">
                                            <b>ABOUT</b><br><br>
                                            <p>
                                                <?php echo nl2br($project->ProjectDescription); ?>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div style="padding-top:15px;padding-right:15px;">
                                        <div style="background-color:white;padding:20px;" class="row">
                                        
                                        <div class="col-sm-12">
                                    

                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" onkeyup="filterActivities(this.value)" Placeholder="Search..." name="search" class="serch">
                                                </div>
                                                <div class="col-sm-3">
                                                @if($project->Status === "Approved")
                                                    @if($canEdit === 1)
                                                    <button data-toggle="modal" class="blue-button" style="width:100%;" data-target="#addActivityModal">
                                                        + Add Activity
                                                    </button>
                                                    @endif
                                                @else
                                                    <p style="color:red;">This Project is currently not yet Approved</p>
                                                @endif
                                                
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    
                                        <script>
                                            function filterActivities(keyword){
                                                //alert(keyword);
                                                console.log(keyword);
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
                                        <div style="padding:20px;" class="col-sm-12">
                                        

                                            @for($i = 0; $i < sizeof($project->Activities); $i++)
                                                
                                                <div class="row" id="project-parent-{{$i}}" style="border: 1px solid rgba(0,0,0,0.2);padding:20px;background: {{$i % 2 === 0 ? 'rgba(0,0,0,0.1)' : 'none'}}">
                                                    
                                                    <div class="col-sm-10 project-lists">{{$project->Activities[$i]->ActivityName}}</div>
                                                    <div class="col-sm-2"><a href="{{url('getActivityPage')}}?id={{ $project->Activities[$i]->ActivityId}}"><button style="padding: 10px;background: #2196F3;color: white;cursor: pointer;border: none;">View</button></a></div>
                                                    
                                                </div>
                                            @endfor
                                        </div>
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