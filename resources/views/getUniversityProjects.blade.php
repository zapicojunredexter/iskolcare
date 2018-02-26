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
					
					
						<!-- start sa uni logo ug cover photo -->
						
                            <div class="col-md-12" style="height:200px;">
                               
							    <div style="width:30%;height:100%;float:left;">
                                    @if(Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)
                                    <img
                                        onclick="displayModal('editUniLogo')"
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
                                    onclick="displayModal('editCoverPhotoModal')" 
                                    style="float: right;width: 70%;height: 100%;background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('img/logos/{{$university->CoverPhoto}}');background-repeat: no-repeat;background-position: center;background-size: 100%;cursor: pointer;padding-left: 30px;color:white;">
                                
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
						@include('includes.universityTabs')
                        <!-- start sa varied contents-->
                        <div class="col-md-12">
                           



                            <div class="card">
                                <?php $counter=0;?>
                                @foreach($university->InstProjects as $project)
                                @if($project->Status==='Approved')
								
                                
                                <div class="card-body ">
                                <?php if($counter++ !== 0){ echo "<hr>"; } ?>
					
									<div class="row">
										<div class="col-sm-3">
                                            <img 
                                            onclick="
                                                document.getElementById('projectId').value={{$project->ProjectId}}
                                                displayModal('changeProjectBannerModal')
                                            "
                                
                                            src="img/logos/programs/{{$project->Banner}}"  
                                            style="width:80px;height:80px;border:solid silver 2px;border-radius:50% ">
                                    
										</div>
										<div class="col-sm-9">
										    <h3>{{$project->ProjectName}}</h3>
                                            <h5>{{$project->ProjectDescription}}</h5>
                                            <small onclick="$('#activities-{{$project->ProjectId}}').toggle('slide');">Show Activities</small>
                                    
										</div>
									</div>
									
								</div>
                                

                                <div class="card-footer" style="display:none;" id="activities-{{$project->ProjectId}}">
                                    <ul>
                                        @foreach($project->Activities as $activity)
                                            @if($activity->ActivityStatus === 'Approved')
                                                <li><a href="{{url('getactivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>



                                @endif
                                @endforeach
                            
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