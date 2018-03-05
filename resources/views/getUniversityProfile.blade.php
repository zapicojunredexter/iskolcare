<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>{{$university->UniName}}</title>

</head>

<body>
    <div class="wrapper" style="background-color:#e6eaeb;">
        @if(Session::get('type')==='Director' && Session::get('uniId') === $university->UniId)
            @include('forms.editUniversityForm')
            @include('forms.changeUniCoverPhoto')
            @include('forms.changeUniLogo')
            @include('forms.editAnnouncementForm')
            @include('forms.addProgramForm')
            @include('forms.addInstProjectForm')
            @include('forms.addAnnouncements')
                                        
        @endif
        @if(Session::get('type')==='Coordinator' && Session::get('uniId')===$university->UniId)
        @include('forms.addAnnouncements')
        @include('forms.editAnnouncementForm')
        @endif              
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
                $label = "University Profile";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content" style="padding-top:10px;">
            
                <div class="container-fluid">
				
                    <div class="row">
					
					
						<!-- start sa uni logo ug cover photo -->
						
                            <div class="col-md-12" style="height:220px;">
                               
							    <div style="width:30%;height:100%;float:left;">
                                    @if(Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)
                                    <img
                                        data-toggle="modal"
                                        data-target="#editUniLogo"
                                        src="img/logos/{{$university->UniLogo}}"
                                        style="float: left; width: 100%; height: 100%; cursor: pointer;box-shadow:3px 3px 2px silver;">
                                    @else
                                    <img
                                        src="img/logos/{{$university->UniLogo}}"
                                        style="float: left; width: 100%; height: 100%;">
                                    @endif
							    </div>




                                @if(Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)
                                <div
		                            onclick="$('#editCoverPhotoModal').modal('show');"
                                    style="float: right;width: 70%;height: 100%;background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('img/logos/{{$university->CoverPhoto}}');background-repeat: no-repeat;background-position: center;background-size: 100%;cursor: pointer;padding-left: 30px;color:white;">
                                    <div style="float:right;z-index:-12">
                                    <img data-toggle="modal" data-target="#edit-university-modal" data-toggle="tooltip" title="Edit University Details"  id="edit-uni-button" src="default-img/edit.png" style="width:20px;margin-right:5px;margin-top:5px;" alt="edit"></div>
                                    <br>
				                    <small style="font-size: 40px; margin-top: 50px;">{{$university->UniName}}</small>
				                    <br>
                                    <small style="font-size: 17px;"><img src="default-img/location.png" width="15px" style="padding-bottom: 11px; margin-right: 11px; margin-left: 8px;">{{$university->UniAddress}}</small>
                                    <br>
                                    <small style="font-size: 17px;"><img src="default-img/telephone.png" width="21px" style="margin-right: 11px; margin-left: 5px;">{{$university->UniContNum}}</small>
                                </div>
                                @else
                                <div 
                                    style="float: right;width: 70%;height: 100%;background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('img/logos/{{$university->CoverPhoto}}');background-repeat: no-repeat;background-position: center;background-size: 100%;cursor: pointer;padding-left: 30px;color:white;">
                                
                                    <br>
				                    <small style="font-size: 40px; margin-top: 50px;">{{$university->UniName}}</small>
				                    <br>
                                    <small style="font-size: 17px;"><img src="default-img/location.png" width="15px" style="padding-bottom: 11px; margin-right: 11px; margin-left: 8px;">{{$university->UniAddress}}</small>
                                    <br>
                                    <small style="font-size: 17px;"><img src="default-img/telephone.png" width="21px" style="margin-right: 11px; margin-left: 5px;">{{$university->UniContNum}}</small>
                                </div>
                                @endif











							   
                            </div>
					<!-- end sa uni logo ug cover photo -->
                        <!-- start sa varied contents-->
                        <div class="col-md-12">

                            <div class="row" style="margin-top:20px;">
                            <!--start sa left details-->
                                <div class="col-md-4">
                                
                                    <!-- start sa about university-->
                                    <div style="color:white;padding:20px;background-color: #1b593e;color: white;">

                                        <?php 
                                            function removeNewLine($text){
                                                $result = (str_replace(PHP_EOL,"<br>",($text)));
                                                return $result;
                                            }
                                        ?>                            
                                        <b>ABOUT</b>
                                        <div style="font-size:15px;margin-top:5px;">
                                            <pre><?php echo ($university->UniDescription);?></pre>
                                            
                                        </div>
                                        <div id="extra-details" style="display:none;">
                                            <hr style="background-color:white;">                        
                                            <b>VISION</b>
                                            <div style="font-size:15px;margin-top:5px;">
                                                <pre><?php echo ($university->Vision);?></pre>
                                            </div>
                                            <hr style="background-color:white;">                        
                                            <b>MISSION</b>
                                            <div style="font-size:15px;margin-top:5px;">
                                                <pre><?php echo ($university->Mission);?></pre>
                                            </div>
                                            <hr style="background-color:white;">                        
                                            <b>Director in-charge</b>
                                            <div style="font-size:15px;margin-top:5px;">
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$university->ExtensionHeadName}}
                                            </div>
                                        </div>
                                        <hr style="background-color:white;margin-top:5px;">
                                        <div onclick="toggleDetails();" id="show-or-hide" style="text-align:right;font-size:12px;"><i>READ MORE </i><i class="nc-icon nc-stre-down"></i></div>
                                        <script>
                                            var flag = 1;
                                            function toggleDetails(){

                                                $('#extra-details').toggle('slide');
                                                flag = flag * -1;
                                                if(flag === -1)
                                                    $('#show-or-hide').html('<i>SHOW LESS </i><i class="nc-icon nc-stre-up"></i>');
                                                else
                                                    $('#show-or-hide').html('<i>READ MORE </i><i class="nc-icon nc-stre-down"></i>');
                                                
                                            }
                                        </script>
                                    </div>
                                    <!-- end sa about university-->
                                    <!--start sa tabs-->

                                    <div class="nav nav-tabs justify-content-start" style="margin-top:20px;" role="tablist">
                                        <a class="nav-item nav-link active" href="#programs-tab" data-toggle="tab" style="font-weight:bold;color:black;padding:20px;text-align:center;width:50%" role="tab">PROGRAMS</a>
                                        <a id="click-inst-projects" class="nav-item nav-link" href="#inst-projects-tab" data-toggle="tab" style="font-weight:bold;color:black;padding:20px;text-align:center;width:50%" role="tab">PROJECTS</a>
                                    </div>
                                    <div class="tab-content" style="background-color:white;padding:20px;">
                                        <!--start sa programs tab-->
                                        <div id="programs-tab" class="tab-pane fade show active" role="tabpanel">
                                            <h6>Programs Offered</h6>
                                            <hr>
                                            @foreach($university->Programs as $program)
                                                <div class="recentdetails">
                                                    <div class="projname" style="font-size: 15px;">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <img src="img/logos/programs/{{$program->Logo}}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 50%;">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <a href="{{url('getUniversityProgramsSpecific')}}?id={{$program->ProgramId}}">{{$program->ProgramName}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endforeach
                                            @if(Session::get('type')==="Director" && Session::get('uniId') === $university->UniId)
                                            <button data-toggle="modal" data-target="#addProgramModal" class="blue-button">+ Add Program</button>
                                            @endif
                                        </div>
                                        <!--end sa programs tab-->
                                        <!--start sa inst level projects-->
                                        <div id="inst-projects-tab" class="tab-pane fade show" role="tabpanel">
                                            <h6>Projects</h6>
                                            <hr>
                                            @foreach($university->InstProjects as $project)
                                                <div class="recentdetails">
                                                    <div class="projname" style="font-size: 15px;">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <img src="img/logos/programs/{{$project->Banner}}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 50%;">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <a href="{{url('getUniversityProject')}}?id={{$project->ProjectId}}">{{$project->ProjectName}}</a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <hr>
                                                </div>
                                            @endforeach
                                            
                                            @if(Session::get('type')==="Director" && Session::get('uniId') === $university->UniId)
                                            <button data-toggle="modal" data-target="#addInstProjectModal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;">+ Add Project</button>
                                            @endif
                                        </div>
                                        <!--end sa inst level projects-->
                                    </div>
                                    <!--end sa tabs-->
                                    <!-- start sa list of programs-->
                                        <!--
                                         <div style="margin-top:20px;background-color: white;padding:20px;">
                                            <h6>Programs Offered</h6>
                                            {{print_r($university->InstProjects)}}
                                            <hr>
                                            @foreach($university->Programs as $program)
                                                <div class="recentdetails">
                                                    <div class="projname" style="font-size: 15px;">
                                                    <img src="img/logos/programs/{{$program->Logo}}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 50%;">
                                                        <a href="{{url('getUniversityProgramsSpecific')}}?id={{$program->ProgramId}}" style="color: blue;">{{$program->ProgramName}}</a>
                                                    </div>
                                                    
                                                    <hr>
                                                </div>
                                            @endforeach
                                         </div>
                                         --> 
                                    <!-- end sa list of programs-->

                                </div>
                            <!--end sa left details-->
                            
                            <!--start sa right details-->
                                <div class="col-md-8">
                                
                                <!--start sa announcements-->
                                
                                <div style="width:100%;text-align:center;margin-top: 30px;">
                                    <h2 style="display:inline;font-weight:bold;">Announcements</h2>
                                    @if((Session::get('type')==="Director" && $university->UniId === Session::get('uniId'))||(Session::get('type')==="Coordinator" && $university->UniId === Session::get('uniId')))
                                        <button data-toggle="modal" data-target="#addAnnouncementModal" class="blue-button" style="float:right;">+ Add Announcement</button>
                                    @endif
                                </div>
                                    
                                @foreach($university->Posts as $post)
                                
                                <div>
                                    <div style="width:100%;height: 40%; background: white; float: right; margin-top: 30px; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                        <img src="img/dp/{{$post->PosterDP}}" width="9%" style="margin: 10px; float: left;">
                                        <div width="90%" style="padding-top: 10px;padding-bottom: 10px;">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <small style="color: black; padding: 0; font-weight: bold;">{{$post->PostedBy}}</small><br>
                                                    <small style="padding: 0; color: black;">{{date('M jS, Y h:i:s a',strtotime($post->PostDate))}}</small>
                                                </div>
                                                <div class="col-sm-4" style="text-align:right;">
                                                @if(((Session::get('type')==='Director')&&(Session::get('uniId')===$university->UniId)) || (Session::get('type')==='Coordinator' && Session::get('uniId')===$university->UniId && (Session::get('type').' - '.Session::get('accountId') === $post->PosterDetails)))
                                                    <img data-toggle="tooltip" title="Delete Announcement" src="default-img/trash.png" onclick="deleteAnnouncement({{$post->PostId}})" style="cursor:pointer;width:20px;">
                                                    <img data-toggle="tooltip" title="Edit Announcement" src="default-img/edit.png"
                                                        onclick="replaceEditAnnouncement({{$post->PostId}},`{{$post->PostedBy}}`,`{{removeNewLine($post->PostDescr)}}`,`{{$post->PostDate}}`,`{{$post->PostWhat}}`,`{{$post->PostWhen}}`,`{{$post->PostWhere}}`);" style="cursor: pointer;width:20px;" >
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 100%; background: white; float: right; padding: 2%; background: #f1f1f1;">
                                        
                                        <div class="row">
                                            @if($post->PostWhat)
                                            <div class="col-sm-3" style="font-weight:bold;">What:</div>
                                            <div class="col-sm-9">{{$post->PostWhat}}</div>
                                            @endif
                                            @if($post->PostWhen)
                                            <div class="col-sm-3" style="font-weight:bold;">When:</div>
                                            <div class="col-sm-9">{{$post->PostWhen}}</div>
                                            @endif
                                            @if($post->PostWhere)
                                            <div class="col-sm-3" style="font-weight:bold;">Where:</div>
                                            <div class="col-sm-9">{{$post->PostWhere}}</div>
                                            @endif
                                        
                                        </div>
                                        <br>
                                        <p style="text-indent: 5%;">
                                            <?php
                                                echo removeNewLine($post->PostDescr);
                                            ?>
                                        </p>
                                    </div>
                                </div>


                                @endforeach
                                <!--
                                {$university->Posts->links()}
                                -->
                                <!--end sa announcements-->
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