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
                            <!-- start sa adding announcement form-->
                            <div class="row">
                                <div class="col-md-12">
                                    @if((Session::get('type')==='Director'&& Session::get('uniId')===$university->UniId))
                                        @include('forms.addAnnouncements')   
                                    @endif
                                    
                                    @foreach($university->Programs as $program)
                                        @if(Session::get('type')==='Coordinator'&&Session::get('programId')===$program->ProgramId)
                                            @include('forms.addAnnouncements')
                                        @endif
                                    @endforeach
                                    
                                
                                
                                </div>
                            </div>
                        <!-- start sa adding announcement form-->
                            <!-- start sa looping for programs-->
                            @foreach($university->Posts as $post)
                                <div class="row">
                                    <div class="col-md-1">
                                    
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card ">
                                            <div class="card-header ">
                                                <div class="row">
                                                    <div class="col-md-3">

                                                        <img src="img/dp/{{$post->PosterDP}}" width="100px" height="100px" style="border-radius: 50%; margin: 10px; border: 2px solid white;">
		
                                                    </div>
                                                    <div class="col-md-9">        
                                                        <h4 class="card-title">{{$post->PostedBy}}</h4>
                                                        <p class="card-category">{{$post->PostDate}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style="text-align:center;">
                                                {{$post->PostDescr}}
                                            </div>

                                            
                                            <div class="card-footer ">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                    
                                    </div>
                                </div>
                            @endforeach
                            <!-- start sa looping for programs-->
                        
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