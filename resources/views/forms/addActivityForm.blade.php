<div class="modal fade" id="addActivityModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                ADD NEW ACTIVITY
            </div>
            <div class="modal-body" style="">
                    

            
            <form method="GET" onSubmit="return false;" id="addActivityForm"> 
            

                <div id="act-main-details">
                    <input onkeyup="checkAddActivity()" type="text" id="act-name" placeholder="Activity Name: How should we call the Activity?" name="activityName" class="form-control" required>
                    <input onkeyup="checkAddActivity()" type="text" id="act-desc" placeholder="Activity Description: Say Something about the Activity" name="activityDescription" class="form-control" required>
                    <!--
                    <input onkeyup="checkAddActivity()" type="text" id="act-venue" placeholder="Venue: Where will the Activity be held" name="activityVenue" class="form-control" required>
                    -->
                  <input class="form-control" id="autocomplete" placeholder="Venue: Where will the Activity be held" name="activityVenue" onFocus="geolocate()" type="text"/>
                    <input onkeyup="checkAddActivity()" onkeyup="checkAddActivity()" type="text" id="act-target" placeholder="Target Audience: Who are the targeted people of this Activity?" name="targetAudience" class="form-control" required>
                    <input type="hidden" name="projectId" id="activityProjectId" name="projectId" class="form-control" value="{{$project->ProjectId}}" readonly>
                    Allow People from other Universities to Participate?
                    <input type="checkbox" name="isExclusive">
                    <br>
                    <button type="button" class="blue-button" id="activity-main-button" onclick="goToSchedules();" disabled>NEXT</button>
                    
                    
                    <!--
                    <br><br><br><br><br><br>
      <input class="form-control" id="autocomplete" placeholder="Enter your address"
             onFocus="geolocate()" type="text"/>
-->
                    
<input type="text" id="cityLat" name="cityLat" />
<input type="text" id="cityLng" name="cityLng" /> 
                </div>
                
                
                <div id="act-sched-details" style="display:none">
                
                    
                    <h3 style="display:inline;">SCHEDULE</h3>
                    <button type="button" onclick="addActivitySchedule();" class="blue-button" style="float:right;">+ Add</button>
                    <br>
                    <br>
                    <div id="sched-container" style="margin:0px;padding:0px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" name="date[]" class="form-control" style="height:100px;">
                            </div>
                            <div class="col-sm-6">
                                <input type="time" name="time[]" class="form-control" value="12:00:00" style="height:50px;">
                                <input type="time" name="timeEnd[]" class="form-control" value="12:00:00" style="height:50px;">
                            </div>
                        </div>
                        <br>
                    </div>
                    <button type="button" onclick="goToSchedules();" class="blue-button">Previous</button>
                    <button type="button" id="submit-activity-button" onclick="this.disabled='true';addActivity()" class="blue-button">SUBMIT</button>
        
                    
                </div>
            </form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
function checkAddActivity(){
    var name,desc,venue,target;
    name = $('#act-name').val();
    desc = $('#act-desc').val();
    venue = $('#autocomplete').val();
    target = $('#act-target').val();
    if((name)!=="" && (desc).trim()!=="" && (venue).trim()!=="" && (target).trim()!==""){
        $('#activity-main-button').prop('disabled',false);
        
    }else{
        $('#activity-main-button').prop('disabled',true);
    }
}
function addActivitySchedule(){
    $('#sched-container').append('<div class="row"><div class="col-sm-6"><input type="date" name="date[]" class="form-control" style="height:100px;"></div><div class="col-sm-6"><input type="time" name="time[]" class="form-control" value="12:00:00" style="height:50px;"><input type="time" name="timeEnd[]" class="form-control" value="12:00:00" style="height:50px;"></div></div><br>');
}
function goToSchedules(){
    //$("#act-main-details").slideToggle("slide",{direction:"left"});
    var name,desc,venue,target;
    name = $('#act-name').val();
    desc = $('#act-desc').val();
    venue = $('#autocomplete').val();
    target = $('#act-target').val();
    if((name)!=="" && (desc).trim()!=="" && (venue).trim()!=="" && (target).trim()!==""){
        $("#act-main-details").toggle("slide");
        $("#act-sched-details").toggle("slide");
    
    }else{
        alert('please fill up all fields');
    }
}    

function addActivity(){
    var a=$("input[name='date%5B%5D']").val();
    var b=$("input[name='time%5B%5D']").val();
    var c=$("input[name='timeEnd%5B%5D']").val();
    
    var d = $("#addActivityForm").serialize();
    console.log(a);
    console.log(b);
    console.log(c); 
    console.log(d);   
    
    $.ajax({
		url: "{{ url('/addActivity') }}",
		type: "get", 
		data: $("#addActivityForm").serialize(),
        success: function(response) {
		    if(!isNaN(response)){
                swal("Successfully Added","","success").then(()=>{
                    window.location.href="{{url('getActivityPage')}}?id="+response;});
                    
            }else{
                swal(response,"","error").then(()=>{
                    $('#submit-activity-button').prop('disabled',false);
                });  
            }
		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
}
</script>

<!--

<form method="GET" onSubmit="addActivity();return false;" id="addActivityForm"> 
<div id="addActivityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addActivityModal')">×</span>
                    <h2>ADD NEW ACTIVITY</h2>
            </div>
            <div class="modal-body">
                
                
                <div id="act-main-details">
                
                <input type="text" placeholder="Activity Name: How should we call the Activity?" name="activityName" class="form-control">
                <input type="text" placeholder="Activity Description: Say Something about the Activity" name="activityDescription" class="form-control">
                <input type="text" placeholder="Venue: Where will the Activity be held" name="activityVenue" class="form-control">
                <input type="text" placeholder="Target Audience: Who are the targeted people of this Activity?" name="targetAudience" class="form-control">
                <input type="hidden" name="projectId" id="activityProjectId" name="projectId" class="form-control" value="asd" readonly>
                Allow People from other Universities to Volunteer?
                    <input type="checkbox" name="isExclusive">
                
                    <button type="button" onclick="goToSchedules();">NEXT</button>
                </div>
                
                
                
                <div id="act-sched-details" style="display:none">
                
                
                <h3>SCHEDULE</h3>
                <input type="date" name="date[]" class="form-control"><input type="time" name="time[]" class="form-control">   <br> 
                <input type="date" name="date[]" class="form-control"><input type="time" name="time[]" class="form-control">   <br> 
                <input type="date" name="date[]" class="form-control"><input type="time" name="time[]" class="form-control">   <br> 




	
                
                </div>
               
            </div>
            <div class="modal-footer">
                <input class="btn btn-success" type="submit" value="SUBMIT">

                
            </div>
        </div>
    </div>

</form>	
-->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWkTUIJEfAEeJsKkySTmj0tWXnJ7_frrA&libraries=places&callback=initAutocomplete" async defer></script>
  
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        var place = autocomplete.getPlace();

            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
            
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        /*for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }*/
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
	  
	  
	  
	  
	    function initialize() {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('city2').value = place.name;
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
           // alert(place.address_components[0].long_name);

        });
    }
    //google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	
		
            
		