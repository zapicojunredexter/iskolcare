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
{{$data->Username}}	
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
					<div class="col-sm-8" style="padding-top:20px;">{{$university->ExtensionHeadName}}</div>
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
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>MaxPrograms</b></div>
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
