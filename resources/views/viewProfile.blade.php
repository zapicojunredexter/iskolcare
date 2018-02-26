<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>{{$account->Name}}'s Profile</title>
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
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content" style="padding:0px;">
                <!-- start sa body-->
                <div style="background-image: url('default-img/profile-cover.jpg'); width: 100%; height: 195px;">
                    <br><br><br>
                    <div>   
                        <div>
                        <div>
                                <img data-toggle="modal" data-target="#editDisplayPic" src="img/dp/{{$account->DisplayPic}}" style="border-radius: 50%; border: 3px solid white; cursor: pointer; float: left; margin-left: 20px;width:250px;height:250px;">
                                <br><br>
                                <div style="width: 100%; height: 76px;margin-top:0px; background-color: rgba(0,0,0,0.4); color: white;">
                                    <div style="width: 36%; float: left; border-right: 2px solid rgba(0,0,0,0.2);  padding-top: 10px;">{{sizeof($account->volHist)}}
                                        <p>Activities Volunteered</p>
                                    </div>
                                    <div style="padding-top: 10px;">{{sizeof($account->partHist)}}
                                        <p>Activities Participated</p>
                                    </div>
                                </div>
                            </div>                      
                        </div>          
                    </div>        
                </div>

                <div style="margin-top: 20px;">
                <h2 style="font-weight:bold;">{{$account->Name}} {{$account->LastName}}</h2>
                {{$account->Username}}	
                </div> 
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12" style="padding:50px">
                            <div style="background-color:white;border-radius:5px;">	
                            
                                @if(Session::get('type')==="Director")
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Username</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Username}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Password</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Password}}</div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>First Name</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Name}}</div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Last Name</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->LastName}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Address</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Address}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>EmailAddress</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->EmailAddress}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Birthdate</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Birthday}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Gender</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Gender}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Citizenship</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->Citizenship}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Contact Person</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->ContPerson}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Contact Person Contact Number</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;">{{$account->ContPersonContNumber}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Account Type</b></div>
                                    <div class="col-sm-8" style="padding-top:20px;padding-bottom:20px;">{{$account->AccountType}}</div>
                                </div>
                            
                            </div>
                            <!--start sa volunteer history details-->
                            <div style="background-color:white;border-radius:5px;">
                            
                                <div style="background-color:#1b593e;color:white;margin-top:30px;">
                                    <h4 style="font-weight:bold;padding:10px;">VOLUNTEERING HISTORY</h4>
                                </div>
                                <div style="margin-top:20px;padding:20px;">
                                    <div class="row">
                                    @foreach($account->volHist as $volH)
                                        <div class="col-sm-3">
                                            <div style="overflow:hidden;height:200px;border:solid silver 1px;padding:20px;text-align:center;">
                                                <img src="img/logos/programs/{{$volH->Banner}}" style="width:40px;height:40px;border-radius:50%" alt="">
                                                <br>
                                                <a href="{{url('getActivityPage')}}?id={{$volH->ActivityId}}">{{$volH->ActivityName}}</a>
                                                <br>
                                                <small style="overflow:hidden;text-overflow:ellipsis;">of the <a href="{{url('getUniversityProject')}}?id={{$volH->ProjectId}}">{{$volH->ProjectName}} Project</a></small>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                                <!--end sa volunteer history details-->
                                
                            <!--start sa beneficiary history details-->
                            <div style="background-color:white;border-radius:5px;">
                                
                                <div style="background-color:#1b593e;color:white;margin-top:30px;">
                                    <h4 style="font-weight:bold;padding:10px;">BENEFICIARY HISTORY</h4>
                                </div>
                                <div style="margin-top:20px;padding:20px;">
                                    <div class="row">
                                    @foreach($account->partHist as $benH)
                                        <div class="col-sm-3">
                                            <div style="overflow:hidden;height:200px;border:solid silver 1px;padding:20px;text-align:center;">
                                                <img src="img/logos/programs/{{$benH->Banner}}" style="width:40px;height:40px;border-radius:50%" alt="">
                                                <br>
                                                <a href="{{url('getActivityPage')}}?id={{$benH->ActivityId}}">{{$benH->ActivityName}}</a>
                                                <br>
                                                <small style="overflow:hidden;text-overflow:ellipsis;">of the <a href="{{url('getUniversityProject')}}?id={{$benH->ProjectId}}">{{$benH->ProjectName}} Project</a></small>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--end sa beneficiary history details-->
                        </div>
                        
                    </div>
                </div>
                <!--end sa body-->
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