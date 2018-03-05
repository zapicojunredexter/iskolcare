
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
                        {{Request::is('getUniversityProfile') && $university->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProgramsSpecific') && (!empty($program)) && $program->UniversityId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getUniversityProject') && $university->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        {{Request::is('getActivityPage') && $activity->MadeBy->UniId === Session::get('uniId')?'background-color:#103525!important;':''}}
                        "
                        href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}"
                        class="list-group-item collapse">
                        <i data-target="#menu1" class="nc-icon nc-bank" data-toggle="collapse" aria-expanded="false"></i>        
                        <p style="">MY SCHOOL</p>
                    </a>

                     <a
                        style="
                        {{Request::is('getUpcomingActivities')?'background-color:#103525!important;':''}}
                        "
                        href="{{url('getUpcomingActivities')}}"
                        class="list-group-item collapse">
                        <i class="nc-icon nc-bank"></i>        
                        <p style="">UPCOMING ACTIVITIES</p>
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
                    <li class="{{Request::is('getUniversityProfile') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getUniversityProfile')}}?id={{Session::get('uniId')}}">
							
                            <i class="nc-icon nc-bank"></i>
                            
                            <p>My University</p>
                        </a>
                    </li>
                    <li class="{{Request::is('getUpcomingActivities') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getUpcomingActivities')}}">
							
                            <i class="nc-icon nc-bank"></i>
                            
                            <p>Upcoming Activities</p>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-toggle nav-link" onclick="getUniversityLists()">
                            <i class="nc-icon nc-istanbul"></i>
                            <p>Universities</p>
                        </a>

                        <ul class="dropdown-content" style="display:none;list-style:none;" id="universities-dropdown">

					    </ul>
                    </li>
                </ul>-->
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
                console.log('na');
                console.log(response);
                 $('#universities-dropdown-ul').html("");
                for(var i=0;i<response.length;i++){
                    $('#universities-dropdown-ul').append("<div style='padding:10px;'><img src='img/logos/"+response[i].UniLogo+"' alt='uni-logo' style='width:20px;height:20px;border-radius:50%;margin-right:10px;'><a href='getUniversityProfile?id="+response[i].UniId+"'>"+response[i].UniName+"</a></div>");
                    
                }
                
                $('#universities-dropdown').slideToggle();
            },
            error: function(xhr) {
                alert('error upon connecting to db');
            }
        });
        }
		/*function getUniversityLists(){
			
		$.ajax({
			url: "{{url('getUniversityListsJson')}}",
			type: "get", 
			success: function(response) {
				response=JSON.parse(response);
				console.log('na');
				console.log(response);
				 $('#universities-dropdown').html("");
				for(var i=0;i<response.length;i++){
					$('#universities-dropdown').append("<li class='uni-list-dropdown'><div><a href='getUniversityProfile?id="+response[i].UniId+"'>"+response[i].UniName+"</a></div></li>");
                
				}
				
				$('#universities-dropdown').toggle('slide');
			},
			error: function(xhr) {
				alert('error upon connecting to db');
			}
		});
        }*/
	</script>
