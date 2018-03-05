<div class="modal fade" id="edit-sub-details" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                CHANGE SUBSCRIBER DETAILS
                <span onclick="$('#edit-sub-details').modal('hide');" class="close-span">&times;</span>
            </div>

            <div class="modal-body" style="">
<form id="editSubscriberForm" onsubmit="return false;" method="get">

    <div class="row" style="margin-top:20px;">
        <div class="col-sm-3">
            Password
        </div>
        <div class="col-sm-9">
            <input type="password" class="form-control" value="{{$data->Password}}" name="password">
        </div>
    </div>
    <div class="row" style="margin-top:20px;">
        <div class="col-sm-3">
            Contact Number
        </div>
        <div class="col-sm-9">
            <input type="text" class="form-control" value="{{$data->ContactNumber}}" name="contactNumber">
            
        </div>
    </div>
    <div class="row" style="margin-top:20px;">
        <div class="col-sm-3">
            Address
        </div>
        <div class="col-sm-9">
            <input type="text" class="form-control" value="{{$data->Address}}" name="address">
            
        </div>
    </div>
    <div class="row" style="margin-top:20px;">
        <div class="col-sm-3">
            Email Address
        </div>
        <div class="col-sm-9">
            <input type="email" class="form-control" value="{{$data->EmailAddress}}" name="emailAddress">
            
        </div>
    </div>
            
                <button class="blue-button" type="button" onclick="editSubscriberDetails();" style="margin-left:40%;">SUBMIT</button>
                
</form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
<script>
    
function editSubscriberDetails(){
    
    $.ajax({
		url: "{{url('editSubscriberAccountDetails')}}",
		type: "get", 
		data: $("#editSubscriberForm").serialize(),
        success: function(response) {
		    if(response==="Successfully Edited Contact Details"){
                swal(response,"","success").then(()=>{
                    location.reload(true);});
                    
            }else{
                swal("Something went wrong","","error").then(()=>{
                });  
            }
		},
		error: function(xhr) {
            swal("Something went wrong","","error").then(()=>{
                //location.reload(true);});
            });
		}
	});
}
</script>

<div style="background-image: url('default-img/profile-cover.jpg'); width: 100%; height: 195px;">
<!--default-img/profile-cover.jpg-->

	<br><br><br>
	<div>   
		<div>
		   <div>
				<img src="img/logos/{{$university->UniLogo}}" style="border-radius: 50%; border: 3px solid white; cursor: pointer; float: left; margin-left: 20px;width:250px;height:250px;">
	            <br><br>
        	    <div style="width: 100%; height: 76px;margin-top:0px; background-color: rgba(0,0,0,0.4); color: white;">
                    <div style="width: 36%; float: left; border-right: 2px solid rgba(0,0,0,0.2);  padding-top: 10px;">
                        <p></p>
                    </div>
                    <div style="padding-top: 10px;">
                        <p></p>
                    </div>
                </div>
	        </div>                      
        </div>          
    </div>        
</div>


<div style="margin-top: 20px;">
<h2 style="font-weight:bold;">{{$university->ExtensionHeadName}}</h2>
&nbsp;
</div> 

<br>
<br>
<div class="container">
	<div class="row" style="">
		<!-- style="padding:50px"-->
		<div class="col-sm-8">
			<div style="background-color:white;border-radius:5px;margin:20px;">
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Name</b></div>
					<div class="col-sm-6" style="padding-top:20px;">{{$university->ExtensionHeadName}}</div>
                    
					<div class="col-sm-2" style="padding-top:20px;">
                    <img
                         data-toggle="modal"
                         data-target="#edit-sub-details"
				         title="Edit Profile Details"
                         src="default-img/edit.png"
                         style="float:right;margin-right:15px;width:20px;"
                         alt="edit"/>
                    </div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Address</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->Address}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Email Address</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->EmailAddress}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Contact Number</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->ContactNumber}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Max Activities</b></div>
					<div class="col-sm-8" style="padding-top:20px;padding-bottom:20px;">{{$data->MaxPrograms}}</div>
				</div>
			
			</div>
		</div>
		<!--  style="padding-top:20px;padding-bottom:20px"-->
		<div class="col-sm-4">
			<!--start of upcoming activities-->
			<div style="border-radius:5px;padding-left:20px;padding:20px;">
				<div style="margin-top:0px;border-radius:3px;background-color:white;padding:10px;background-color:white;">
					<b>Upcoming Activities</b>
						<div class="row">
					
						@foreach($upcomingActivities as $activity)
						<div class="col-sm-12"><hr></div>
							<div class="col-sm-3"><img src="img/logos/programs/{{$activity->Banner}}" style="width:100%" alt="calendar"></div>
							<div class="col-sm-9">
								<p style="font-size: 20px;margin-bottom:0px;"><a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></p>
								<small>{{date("M jS, Y",strtotime($activity->SchedDate))}}</small>
							</div>
						
						@endforeach
						
						@foreach($upcomingInstLevel as $inst)
						<div class="col-sm-12"><hr></div>
							<div class="col-sm-3"><img src="img/logos/programs/{{$inst->Banner}}" style="width:100%" alt="calendar"></div>
							<div class="col-sm-9">
								<p style="font-size: 20px;margin-bottom:0px;"><a href="{{url('getActivityPage')}}?id={{$inst->ActivityId}}">{{$inst->ActivityName}}</a></p>
								<small>{{date("M jS, Y",strtotime($inst->SchedDate))}}</small>
							</div>
						
						@endforeach
						</div>
					
				</div>
			</div>
			<!-- end of upcmoing activities-->
		</div>
	</div>

</div>
