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
            <?php
                $label = "Upcoming Activities";
            ?>
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				
                    <div class="row">
                    
                        <div class="col-sm-12">
                            @foreach($upcomingActivities as $activity)
                                <div class="row" style="margin-top:10px;color:{{$activity->SchedDate<date('Y-m-d')?'gray':'black'}};">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <div style="background-color:white;border:solid silver 1px;border-radius:3px;padding:30px;">
                                        
                                            <div class="row">
                                                <div class="col-sm-3"><img src="img/logos/programs/{{$activity->Banner}}" style="width:100px;height:100px;" alt=""></div>
                                                <div class="col-sm-9">
                                                    <a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}"><h3 style="margin:0px;">{{$activity->ActivityName}}</h3></a>
                                                    <small>
                                                        by the <a href="{{url('getUniversityProject')}}?id={{$activity->ProjectId}}">{{$activity->ProjectName}}</a>
                                                        Project
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                            @endforeach
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