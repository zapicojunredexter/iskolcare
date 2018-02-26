<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard Template for Bootstrap</title>
        @include('includes.libs')
  </head>

  <body>
      
      
    <div id="editScheduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editScheduleModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                @include('forms.editScheduleForm')
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div> 
      
    <div id="editActivityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editActivityModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
               @include('forms.editActivityForm');
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div> 
      
      
    @include('includes.regUserHeader')
      
      
      
      <div class="container-fluid" style="background-color:white;min-width:1200px;">
		
       
		<div class="row">
    @if(Session::get('type')==='Director')
        @include('includes.directorSidebar')    
    @elseif(Session::get('type')==='Coordinator')   
        @include('includes.coordinatorSidebar')    
    @elseif(Session::get('type')==='Registered User')
        @include('includes.reguserSidebar')
    @endif
            <div style="background: transparent; width: 80%; margin-left: 20%;">
		        <div style="background: #29d159; height: 450px;">
                    <div class="col-sm-3" style="margin-top:20px;">
				
					
					<img src="img/logos/programs/{{$activity->Banner}}" style="width:200px;height:200px;border-width:10px;border-style:solid;border-color:white;">
			         </div>
			<div class="col-sm-9" style="margin-top:20px;">
				
				<div style="background-color:white;padding:20px;">
					<div class="page-header" style="margin-top:0px;">
			
					
                         <a href="#" onclick="window.open('fb', 'newwindow', 'width=300, height=250'); return false;"><img src="default-img/fb.png"></a>
                         
                        
                        
                        @if(($activity->Level==="Institution")&&(Session::get("type")==="Director")&&
                        (Session::get("uniId")===$activity->ProgramId))
                            
                            <!--<span class="glyphicon glyphicon-pencil" onclick="displayModal('editActivityModal')"></span>&nbsp;
                            <a href="{{url('/deleteActivity')}}?id={{$activity->ActivityId}}">
                            <span class="glyphicon glyphicon-minus"></span></a>-->
                        
                        
                        @endif
                        
                        @if((($activity->Level==="Program")&&
                        (Session::get("type")==="Coordinator")&& 
                        (Session::get("programId")===$activity->ProgramId)) ||
                        (($activity->Level==="Institution")&&(Session::get("type")==="Director")&&
                        (Session::get("uniId")===$activity->ProgramId)) ||
                        (($activity->Level==="Program")&&
                        (Session::get("type")==="Director")&& 
                        (Session::get("uniId")===$activity->UniId)))
                            
                            <span class="glyphicon glyphicon-pencil" onclick="displayModal('editActivityModal')"></span>&nbsp;
                            <a href="{{url('/deleteActivity')}}?id={{$activity->ActivityId}}">
                            <span class="glyphicon glyphicon-minus"></span></a>
                        
                        @endif
                        
                        
                        
                        @if((Session::get('type')==='Director'&&Session::get('uniId')===$activity->UniversityId)   ||(Session::get('type')==='Coordinator'&&Session::get('programId')===$activity->ProgramId))
                            <!--<span class="glyphicon glyphicon-pencil" onclick="displayModal('editActivityModal')"></span>&nbsp;
                            <a href="{{url('/deleteActivity')}}?id={{$activity->ActivityId}}">
                            <span class="glyphicon glyphicon-minus"></span></a>-->
                        @endif
                        
                       

                        @if(((Session::get('type')!=='Director' )&&(Session::get('type')==='Registered User'&&$hasParticipated==='false'))|| (Session::get('type')==='Coordinator'&& $activity->ProgramId!==Session::get('programId')))
                        <a href="{{url('/addVolunteer')}}?programId={{$activity->ActivityId}}&type=Student">
                            <button>Become Student Volunteer</button>
                        </a>
                        <a href="{{url('/addVolunteer')}}?programId={{$activity->ActivityId}}&type=Faculty">
                            <button>Become Faculty Volunteer</button>
                        </a>
                        @endif
                        @if($activity->Level==='Program'&&Session::get('type')==='Director'&&Session::get('uniId')===$activity->UniId)
                        
                        <form action="approveActivity" metho="get">
                            <input type="hidden" name="activityId" value="{{$activity->ActivityId}}">
                            <input type="hidden" name="programId" value="{{$activity->ProgramId}}" readonly>
                            <input type="hidden" name="activityName" value="{{$activity->ActivityName}}" readonly>
                            <select name="status">
                            <option value="{{$activity->ActivityStatus}}">{{$activity->ActivityStatus}}</option>
                            <option value="Approved">Approve</option>
                            <option value="Pending">Pending</option>
                            </select>
                            <input type="submit" value="Submit">
                        </form>
                        @endif
                        
                        <h1>{{$activity->UniName}}</h1>
                        
                         @if($activity->Level==='Program')
                        <h3>{{$activity->ProgramName}}</h3>
                       
                        @endif
                            <h4>{{$activity->ProjectName}}</h4>
                        <h3>Activity Details</h3>
                            <table>
                                <tr>
                                    <td>Activity Name </td>
                                    <td>{{$activity->ActivityName}}</td>
                                </tr>
                                <tr>
                                    <td>Activity Description </td>
                                    <td> {{$activity->ActivityDescription}}</td>
                                </tr>
                                <tr>
                                    <td>Venue </td>
                                    <td>{{$activity->ActivityVenue}}</td>
                                </tr>
                                <tr>
                                    <td>Target Audience </td>
                                    <td>{{$activity->TargetAudience}}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{$activity->ActivityStatus}}</td>
                                </tr>
                            </table>



                                        SCHEDULE
                         @if((Session::get('type')==='Director' && Session::get('uniId')===$activity->UniversityId)||(Session::get('type')==='Coordinator' && Session::get('programId')===$activity->ProgramId))
                            <span class="glyphicon glyphicon-pencil" onclick="displayModal('editScheduleModal')"></span><br>
                        @endif
                            <ul>
                            @foreach($activity->Schedules as $sched)
                                    <li>{{$sched->SchedDate}}-{{$sched->SchedTime}}</li>
                            @endforeach
                            </ul>
                        @if((Session::get('type')==='Director'&&Session::get('uniId')===$activity->UniversityId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$activity->ProgramId))
                        <form method="get" action="{{url('/setCoordinates')}}">
                            <input type="hidden" name="id" value="{{$activity->ActivityId}}" readonly>
                            <input name="lat" id="lat" type="text" value="{{$activity->LocationLat}}" readonly>
                            <input name="lng" id="lng" type="text" value="{{$activity->LocationLng}}">
                            <input type="submit" value="Go">
    
                            
                        </form>
                        @endif
                        <div id="map" style="background-color:silver;width:100%;height:300px;">
                                MAP
                            </div>
					</div>
				</div>
			</div>
                    
                <!--if user can edit volunteers--->
                    
                    
                    @if((Session::get('type')==='Director'&&Session::get('uniId')===$activity->UniversityId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$activity->ProgramId))
			<div class="col-sm-12" style="margin-top:20px;">
				
				<div style="background-color:white;padding:20px;">
                    
            
                    @include('forms.approveVolunteersForm')
                 
                    @include('forms.deleteApprovedVolunteers')

            
				</div>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				
                
				<div style="background-color:white;padding:20px;">
                     BENEFICIARIES<br>
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Organizations</th>
                                <th><input type="checkbox"></th>
                            </tr>
                            @foreach($activity->Beneficiaries as $beneficiary)
                                <tr>
                                    <td><a>{{$beneficiary->Name}}</a></td>
                                    <td>{{$beneficiary->Address}}</td>
                                    <td></td>
                                    <td><input type="checkbox"></td>
                                </tr>
                            @endforeach
                        </table>
                    
                    
                    
                    
				</div>
                
                
                
                
			</div>
            @endif
                    <!--end if-->
                    
                </div>
            </div>
          </div>
      </div>
      
      
      
      
      <script>
      var map;
      var markers = [];

      function initMap() {
          
        var cent = {lat: {{$activity->LocationLat}}, lng: {{$activity->LocationLng}}};
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: cent,
        });
        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
          addMarker(event.latLng);
        });
        // Adds a marker at the center of the map.
        addMarker(cent);
      }

      // Adds a marker to the map and push to the array.
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
		clearMarkers();
        markers.push(marker);
           document.getElementById('lat').value=markers[0].getPosition().lat();
          document.getElementById('lng').value=markers[0].getPosition().lng();
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
        markers = [];
      }

	  function submitCoordinates(){
          document.getElementById('lat').value=markers[0].getPosition().lat();
          document.getElementById('lng').value=markers[0].getPosition().lng();
		//alert(markers[0].getPosition().lat());
        //console.log(markers[0]);
	  }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWkTUIJEfAEeJsKkySTmj0tWXnJ7_frrA&callback=initMap">
    </script>
        
        

      
      
      
      
      
        
        
    @include('includes.scripts')
  </body>
</html>
