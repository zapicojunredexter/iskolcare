<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>My Profile</title>
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
                $label = "Subscribed Schools";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content">



                <div class="container">
                    <h3>Subscribed Schools</h3>
                    <table class="table table-striped table-hover">
                        <tr style="background-color:#1b593e;color:white;">
                            <th>University Name</th>
                            <th>Extension Head Name</th>
                            <th>Contact Number</th>
                            <th></th>
                        </tr>
                    @foreach($subscribed as $sub)
                    
                        <tr>
                            <td>
                                <a href="{{url('getUniversityProfile')}}?id={{$sub->UniId}}">
                                    {{$sub->UniName}}
                                </a>
                            </td>
                            <td>{{$sub->ExtensionHeadName}}</td>
                            <td>{{$sub->ContactNumber}}</td>
                            <td>
                                @if($sub->Status === 0)
                                <a onclick="enableAccount({{$sub->SubscriberId}})">enable</a>
                                @else
                                <a onclick="disableAccount({{$sub->SubscriberId}})">disable</a>
                                @endif
                            </td>
                        </tr>
                    
                    @endforeach
                    </table>
                    <script>
                        function enableAccount(subId){
                            if(confirm('Are you sure you want to enable account')){
                                
                                window.location.href="{{url('enableAccount')}}?subId="+subId;
                            }
                        }
                        function disableAccount(subId){
                            if(confirm('Are you sure you want to disable account')){
                                
                                window.location.href="{{url('disableAccount')}}?subId="+subId;
                            }
                        }
                    </script>
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
    
<script src="js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="js/plugins/bootstrap-notify.js"></script>
    <script src="js/demo.js"></script>
    @include('includes.scripts')
    
    <script type="text/javascript">

    demo.showNotification('top','left',"haha");
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            /*demo.initDashboardPageCharts();

            demo.showNotification('top','left','haha<a href="{{url('logout')}}">fill up</a>')
            demo.showNotification();*/

        });
    </script>
</body>


</html>