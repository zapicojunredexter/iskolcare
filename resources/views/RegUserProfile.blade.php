@include('forms.editRegUserProfileForm')
@include('forms.changeDisplayPicForm')
<div style="background-image: url('default-img/profile-cover.jpg'); width: 100%; height: 195px;">
	<br><br><br>
	<div>   
		<div>
		   <div>
				<img data-toggle="modal" data-target="#editDisplayPic" src="img/dp/{{$data->DisplayPic}}" style="border-radius: 50%; border: 3px solid white; cursor: pointer; float: left; margin-left: 20px;width:250px;height:250px;">
	            <br><br>
        	    <div style="width: 100%; height: 76px;margin-top:0px; background-color: rgba(0,0,0,0.4); color: white;">
                    <a href="#vol-hist" style="width: 36%; float: left; border-right: 2px solid rgba(0,0,0,0.2);  padding-top: 10px;">{{sizeof($data->volHist)}}
                        <p>Activities Volunteered</p>
                    </a>
                    <div style="padding-top: 10px;">
						<a href="#ben-hist">
						{{sizeof($data->partHist)}}
                        <p>Activities Participated</p>
						</a>
                    </div>
                </div>
	        </div>                      
        </div>          
    </div>        
</div>

<div style="margin-top: 20px;">
<h2 style="font-weight:bold;">{{$data->Name}} {{$data->LastName}}</h2>
{{$data->Username}}	
</div> 
<br>
	<div class="container">
	<div class="row">
		<div class="col-sm-8" style="padding:50px">
			<div style="background-color:white;border-radius:5px;">	
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>First Name</b></div>
					<div class="col-sm-6" style="padding-top:20px;">{{$data->Name}}</div>
					<div class="col-sm-2" style="padding:10px;">
						<img
							data-toggle="tooltip" title="Edit Profile Details"
							src="default-img/edit.png"
							style="float:right;margin-right:15px;width:20px;"
							alt="edit"
							onclick="
							document.getElementById('initialType').value='{{$data->AccountType}}';
							document.getElementById('initialType').innerHTML='{{$data->AccountType}}';
							document.getElementById('accType').style.display='none';
							document.getElementById('accountId').value='{{$data->AccountId}}';
			document.getElementById('name').value='{{$data->Name}}';
			
			document.getElementById('name').style.display='none';
			document.getElementById('lName').value='{{$data->LastName}}';
																									
			document.getElementById('lName').style.display='none';
			document.getElementById('password').value='{{$data->Password}}';
			document.getElementById('contactNumber').value='{{$data->ContactNumber}}';
			document.getElementById('address').value='{{$data->Address}}';
			document.getElementById('emailAddress').value='{{$data->EmailAddress}}';
								
												
			document.getElementById('uneditable').style.display='none';
			$('#editUserDetailsModal').modal('show');
			">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Last Name</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->LastName}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Address</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->Address}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>EmailAddress</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->EmailAddress}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Birthdate</b></div>
					<div class="col-sm-8" style="padding-top:20px;">{{$data->Birthday}}</div>
				</div>
				<div class="row">
					<div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Gender</b></div>
					<div class="col-sm-8" style="padding-top:20px;padding-bottom:20px;">{{$data->Gender}}</div>
				</div>
				
				<div class="row">
                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Citizenship</b></div>
                    <div class="col-sm-8" style="padding-top:20px;">{{$data->Citizenship}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Contact Person</b></div>
                    <div class="col-sm-8" style="padding-top:20px;">{{$data->ContPerson}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Contact Person Contact Number</b></div>
                    <div class="col-sm-8" style="padding-top:20px;">{{$data->ContPersonContNumber}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="padding-left:80px;padding-top:20px;"><b>Account Type</b></div>
                    <div class="col-sm-8" style="padding-top:20px;padding-bottom:20px;">{{$data->AccountType}}</div>
                </div>
			
			</div>
			<!--start sa volunteer history details-->
			<div style="background-color:white;border-radius:5px;" id="vol-hist">
			
				<div style="background-color:#1b593e;color:white;margin-top:30px;">
					<h4 style="font-weight:bold;padding:10px;">VOLUNTEERING HISTORY</h4>
				</div>
				<div style="margin-top:20px;padding:20px;">
					<div class="row">
					@foreach($data->volHist as $volH)
						<div class="col-sm-3">
							<div style="overflow:hidden;height:200px;border:solid silver 1px;padding:20px;text-align:center;">
								<img src="img/logos/programs/{{$volH->Banner}}" style="width:40px;height:40px;" alt="">
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
			<div style="background-color:white;border-radius:5px;" id="ben-hist">
				
				<div style="background-color:#1b593e;color:white;margin-top:30px;">
					<h4 style="font-weight:bold;padding:10px;">BENEFICIARY HISTORY</h4>
				</div>
				<div style="margin-top:20px;padding:20px;">
					<div class="row">
					@foreach($data->partHist as $benH)
						<div class="col-sm-3">
							<div style="overflow:hidden;height:200px;border:solid silver 1px;padding:20px;text-align:center;">
								<img src="img/logos/programs/{{$benH->Banner}}" style="width:40px;height:40px;" alt="">
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
		<div class="col-sm-4"  style="padding-top:50px;padding-right:50px;">
			<div style="background-color:white;border-radius:5px;padding:10px;">
				<b>UPCOMING ACTIVITIES</b> 
			
				@foreach($upcomingActivities as $upcAct)
					<div class="row" style="margin-top:10px;">
						<div class="col-sm-5">
							<div style="padding:20px;">
								<img src="img/logos/programs/{{$upcAct->Banner}}" style="width:90px;height:90px;" alt="activity">
							</div>
						</div>
						<div class="col-sm-7">
						
							<div style="padding:20px;">
								<a href="{{url('getActivityPage')}}?id={{$upcAct->ActivityId}}">
									<h4 style="display:inline;">{{$upcAct->ActivityName}}</h4>
								</a>
								<br>
								<p style="display:inline;">as {{$upcAct->As}}</p>
								<h5>{{date("M jS, Y",strtotime($upcAct->SchedDate))}}</h5>
							</div>
						</div>
						<div class="col-sm-12">
							<hr>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>