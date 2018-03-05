

		<!-- start sa sidebar-->
        <div class="sidebar" data-color="green" style="">
            <!--
                 data-image="img/logos/1-university-logo-photo.jpg"
                "img/logos/1-university-logo-photo.jpg"

        data-image="../assets/img/sidebar-5.jpg"

        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
$('--').data('image');
        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper" style="background-color:#1b593e;">
                <div class="logo" style="align-items:center;justify-content:center;text-align:center;">
                    <!--
					<img src="default-img/logo.png" style="margin-left:25%;width:50%;">
                    -->
					<img src="default-img/logo.png" style="margin-left:autopx;width:75%;">
                </div>
                <div class="list-group panel">
                    <a
                        style="
                        {{Request::is('getUniversityProgramsSpecific') && $program->ProgramId === Session::get('programId')?'background-color:#103525!important;':''}}
                        "
                        href="{{url('getUniversityProgramsSpecific')}}?id={{Session::get('programId')}}"
                        class="list-group-item collapse">
                        <i class="nc-icon nc-notes" data-toggle="collapse" aria-expanded="false"></i>        
                        <p style="">MY DEPARTMENT</p>
                    </a>

                    <a
                        style="
                        {{Request::is('getUniversityProfile') && $university->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProgramsSpecific') && (!empty($program)) && $program->ProgramId !== Session::get('programId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProject') && $university->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getActivityPage') && $activity->MadeBy->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('manageAttendance')?'background-color:#103525!important;':''}}
                        {{Request::is('createCertificates')?'background-color:#103525!important;':''}}
                        "
                        href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}"
                        class="list-group-item collapse">
                        <i data-target="#menu1" class="nc-icon nc-bank" data-toggle="collapse" aria-expanded="false"></i>        
                        <p style="">MY SCHOOL</p>
                    </a>
                    <div class="collapse" id="menu1">
                        <a href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}" class="list-group-item collapse">
                            <i class="plus-arrow-toggle" data-target="#submenu1" data-toggle="collapse" aria-expanded="false">+</i>
                            Programs
                        </a>
                        <div class="collapse" id="submenu1">
                            <a class="list-group-item"> Activities</a>
                        </div>
                        <a href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}#click-inst-projects" class="list-group-item collapse">
                            <i class="plus-arrow-toggle">+  </i>
                            Projects
                        </a>
                    </div>

                    <a
                        style="
                        {{Request::is('manageUserAccounts')?'background-color:#103525!important;':''}}
                        {{Request::is('viewProfile')?'background-color:#103525!important;':''}}
                        "
                        class="list-group-item collapse" href="{{url('manageUserAccounts')}}">
                        <i data-target="#menu2" data-toggle="collapse" aria-expanded="false" class="nc-icon nc-bullet-list-67"></i>     
                        <p style="">USER ACCOUNTS</p>
                    </a>
                    <div class="collapse" id="menu2">
                        <a class="list-group-item collapse" data-target="#submenu2" data-toggle="collapse" aria-expanded="false">
                            &nbsp;&nbsp;&nbsp;&nbsp;<b data-target="#submenu2" data-toggle="collapse" aria-expanded="false">+</b> &nbsp;
                            
                            <b onclick="window.location.href='{{url('manageUserAccounts')}}#btn-click-coo'">Coordinators</b>
                        
                        </a>
                        <div class="collapse" id="submenu2">
                            <a class="list-group-item" href="{{url('manageUserAccounts')}}#btn-click-pro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volunteers</a>
                            <a class="list-group-item" href="{{url('manageUserAccounts')}}#btn-click-ben">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Beneficiaries</a>
                        </div>
                        <a class="list-group-item">
                            &nbsp;&nbsp;&nbsp;&nbsp;+ External Volunteers
                        </a>
                    </div>
                    
                    <a
                        style="
                        {{Request::is('viewPendingProposals')?'background-color:#103525!important;':''}}
                        "
                        href="{{url('viewPendingProposals')}}" class="list-group-item">
                        <i class="nc-icon nc-single-copy-04"></i>    
                        <p style="">PROJECTS / ACTIVITIES</p>
                    </a>

                    <a
                        style="
                        {{Request::is('getAllEvaluationTools')?'background-color:#103525!important;':''}}
                        {{Request::is('getEvaluationTool')?'background-color:#103525!important;':''}}
                        {{Request::is('getResults')?'background-color:#103525!important;':''}}
                        
                        "
                        href="{{url('getAllEvaluationTools')}}" class="list-group-item">
                        <i class="nc-icon nc-paper-2"></i>    
                        <p style="">EVALUATION</p>
                    </a>


                    <a 
                    
                        style="
                        {{Request::is('getUniversityProfile') && $university->UniId !== Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProgramsSpecific') && (!empty($program)) && $program->UniversityId !== Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProject') && $university->UniId !== Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getActivityPage') && $activity->MadeBy->UniId !== Session::get('uniId')?'background-color:#103525!important;':''}}
                        "
                        class="list-group-item" onclick="getUniversityLists()">
                        <i class="nc-icon nc-istanbul"></i>
                        <p>OTHER SCHOOLS</p>
                    </a>
                    
                    <div style="background-color:#185038;display:none;" id="universities-dropdown">
                        <div style="list-style:none;" id="universities-dropdown-ul">
                        </div>
                    </div>

                </div>
                
                <!--
                <ul class="nav">
                    <li class="{{Request::is('getUniversityProgramsSpecific') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getUniversityProgramsSpecific')}}?id={{Session::get('programId')}}">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>My Department</p>
                        </a>
                    </li>
                    <li class="{{Request::is('getUniversityProfile') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}">
							
                            <i class="nc-icon nc-bank"></i>
                            
                            <p>My University</p>
                        </a>
                    </li>
                    <li class="{{Request::is('manageUserAccounts') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('manageUserAccounts')}}">
                            <i class="nc-icon nc-bullet-list-67"></i>
                            <p>User Accounts</p>
                        </a>
                    </li>
                    <li class="{{Request::is('getAllEvaluationTools') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getAllEvaluationTools')}}">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Evaluation Tools</p>
                        </a>
                    </li>
                    <li class="{{Request::is('viewPendingProposals') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('viewPendingProposals')}}">
                            <i class="nc-icon nc-single-copy-04"></i>
                            <p>Proposals</p>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-toggle nav-link" onclick="getUniversityLists()">
                            <i class="nc-icon nc-istanbul"></i>
                            <p>Universities</p>
                        </a>

                        <ul class="dropdown-content" style="display:none;" id="universities-dropdown">

					    </ul>
                    </li>
                </ul>
                -->
            </div>
        </div>
		<!-- end sa sidebar-->
<script>
    function getUniversityLists(){
        
    $.ajax({
		url: "{{url('getUniversityListsJson')}}",
		type: "get", 
        success: function(response) {
            response=JSON.parse(response);
            $('#universities-dropdown-ul').html("");
            for(var i=0;i<response.length;i++){
                //$('#universities-dropdown').append("<li class='uni-list-dropdown'><div><a href='getUniversityProfile?id="+response[i].UniId+"'>"+response[i].UniName+"</a></div></li>");
                $('#universities-dropdown-ul').append("<div style='padding:10px;'><img src='img/logos/"+response[i].UniLogo+"' alt='uni-logo' style='width:20px;height:20px;border-radius:50%;margin-right:10px;'><a href='getUniversityProfile?id="+response[i].UniId+"'>"+response[i].UniName+"</a></div>");
            
            }
            
            $('#universities-dropdown').toggle('slide');
		},
		error: function(xhr) {
            alert('error fetching list of universities');
		}
	});
    }
</script>