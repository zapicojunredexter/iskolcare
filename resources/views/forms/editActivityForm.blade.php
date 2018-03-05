<form method="GET" onSubmit="return false;" id="editActivityForm">
            <div class="modal fade" id="editActivityModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                EDIT ACTIVITY DETAILS
                <span onclick="$('#editActivityModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                


			<input type="hidden" value="{{$activity->ActivityId}}" name="id" class="form-control">
		Activity Name: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityName}}" id="actName" name="activityName" class="form-control"><br>
		Activity Description: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityDescription}}" id="actDesc" name="activityDescription" class="form-control"><br>
		Venue: 
                <!--
                <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityVenue}}" name="activityVenue" id="autocomplete" class="form-control">
                -->
                  <input onkeyup="checkEditActivity()" type="text" value="{{$activity->ActivityVenue}}"id="autocomplete" name="activityVenue" class="form-control" onFocus="geolocate()" type="text"/>
                <br>
		Target Audience: <input onkeyup="checkEditActivity()" type="text" value="{{$activity->TargetAudience}}" name="targetAudience" id="actTarget" class="form-control"><br>
            	@if(Session::get('type')==='Director')
      
            <Select style="display:none;" type="hidden" name="status" class="form-control">
                <option value={{$activity->ActivityStatus}}>{{$activity->ActivityStatus}} </option>
                <option value="Approved">Approve</option>
                <option value="Reject">Reject</option>
            </Select>
		      @endif
              Allow External Volunteers / Beneficiaries? <input type="checkbox" name="isExclusive" {{$activity->isExclusive === 0? 'checked' : ''}}>
            <br>

            <button type="button" class="blue-button" id="edit-activity-button" style="margin-left:45%;" onclick="this.disabled='true';editActivity();">SUBMIT</button>
                
                
                
                
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
</form>

<script>
function checkEditActivity(){
    var actName,actDesc,actVenue,actTarget;
    actName = $('#actName').val();
    actDesc= $('#actDesc').val();
    actVenue= $('#autocomplete').val();
    actTarget= $('#actTarget').val();
    if(actName.trim()!==""&&actDesc.trim()!==""&&actVenue.trim()!==""&&actTarget.trim()!==""){
        $('#edit-activity-button').prop('disabled',false);
    }else{
        $('#edit-activity-button').prop('disabled',true);
    }
}
    
function editActivity(li){
    $.ajax({
		url: "{{ url('/editActivity') }}",
		type: "get", 
		data: $("#editActivityForm").serialize(),
        success: function(response) {
		      swal("successfully edited activity","","success").then(()=>{location.reload();});

		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
}

</script>















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
	
		
            
		