<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>{{$activity->ActivityName}} Activity</title>
</head>

<body>
<!--
echo {{URL::previous()}}
<ul class="breadcrumb">
    <li class="breadcrumb-item active">asd</li>
    <li class="breadcrumb-item">asd</li>
    <li class="breadcrumb-item">asd</li>
</ul>
-->
@if($canEdit === 1)
    @include('forms.editActivityForm')    
    @include('forms.editScheduleForm')  
    @include('forms.addSponsorForm')  
    @include('forms.assignEvaluationToolForm')   
    @include('forms.addVolunteersForm')   
    @include('forms.addBeneficiariesForm')  
    @include('forms.editReleasedForm')          
@endif

@include('forms.uploadNewPhotosForm')
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
                $label="Activity";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            
            <div class="col-sm-12" style="min-height:20px;padding:10px;">
                      
                      <ul class="breadcrumb" style="margin:0px;padding:0px;background:transparent;">
                          <li><a href="{{url('getUniversityProfile')}}?id={{$activity->MadeBy->UniId}}">{{$activity->MadeBy->UniName}}</a></li>
                          @if(!empty($activity->MadeBy->ProgramName))
                          <li><a href="{{url('getUniversityProgramsSpecific')}}?id={{$activity->MadeBy->ProgramId}}">{{$activity->MadeBy->ProgramName}}</a></li>
                          @endif
                          <li><a href="{{url('getUniversityProject')}}?id={{$activity->ProjectId}}">{{$activity->ProjectName}}</a></li>
                          <li><a href="#">{{$activity->ActivityName}}</a></li>
                          <li></li>
                      </ul>
      
                  </div> 
                    
            <div class="content" style="padding-top:0px;">
            
                <div class="container-fluid" style="padding:0px;">
				
                    <!--start sa activity details-->
                    <div class="row" style="background-color:white;padding:30px;">
                        <div class="col-sm-1">
                            <img src="img/logos/programs/{{$activity->Banner}}" alt="activity-logo"  style="width:70px;">
                        </div>
                        <div class="col-sm-8">
                            <b style="font-size: 20px;color:{{($activity->ActivityStatus === 'Approved' && $activity->Status === 'Approved')? 'black' : 'red'}};">{{$activity->ActivityName}}</b>
                            <br>
                            <small style="color: black; font-size: 12px;">by the
                                @if($activity->Level==="Program")
                                    <a href="{{url('/getUniversityProject')}}?id={{$activity->ProjectId}}">{{$activity->ProjectName}}</a> Project of the
                                    <a href="{{url('/getUniversityProgramsSpecific')}}?id={{$activity->MadeBy->ProgramId}}">{{$activity->MadeBy->ProgramName}}</a> Program of the
                                    <a href="{{url('/getUniversityProfile')}}?id={{$activity->MadeBy->UniId}}">{{$activity->MadeBy->UniName}}</a>
                                @elseif($activity->Level==="Institution")
                                    {{$activity->ProjectName}} Project of the
                                    <a href="{{url('/getUniversityProfile')}}?id={{$activity->MadeBy->UniId}}">{{$activity->MadeBy->UniName}}</a>
                                @endif
                                <!--
                                Activity:{{$activity->ActivityStatus}}Project{{$activity->Status}}
                                -->
                            </small>
                        </div>
                        <div class="col-sm-3">
                            
                            <div class="row">
                                @if($canEdit === 1)                 
                                <div class="col-sm-3">
                                    <div>
                                        <img data-toggle="dropdown"  class="dropdown" src="default-img/edit.png" style="width:20px;" alt="edit">
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-item" data-toggle="modal" data-target="#editActivityModal">Edit Activity Details</li>
                                            <li class="dropdown-item"><hr></li>
                                            <li class="dropdown-item" data-toggle="modal" data-target="#editScheduleModal">Manage Activity Schedule</li>
                                            <li class="dropdown-item"><hr></li>
                                            <li class="dropdown-item" data-toggle="modal" data-target="#addSponsorModal">Manage Sponsors</li>
                                        </ul>
                                    </div>
                                </div>
                                @if((Session::get('type') === "Director")||(Session::get('type')==="Coordinator" && $activity->ActivityStatus === "Pending for Add"))
                                <div class="col-sm-3">
                                    <img data-toggle="tooltip" title="Delete this Activity" onclick="deleteThisActivity({{$activity->ActivityId}})" src="default-img/trash.png" style="width:20px;" alt="edit">                  
                                </div>
                                <script>
                                    function deleteThisActivity(actId){
                                        if(confirm("Are you sure you want to delete this activity?")){
                                            //alert(actId);
                                            window.location.href="{{url('deleteActivity')}}?id="+actId;
                                        }
                                    }
                                </script>
                                @endif
                                
                                @else
                                <!-- TODO check if pwede ba-->
                                        
                                @if($canParticipate===1 && $canVolunteer === 1)
                                    
                                    @if($activity->isExclusive === 1)
                                        @if($activity->MadeBy->UniId === Session::get('uniId'))
                                            <a href="{{url('/addVolunteer')}}?programId={{$activity->ActivityId}}&madeByUniId={{$activity->MadeBy->UniId}}">
                                                <button style="padding: 8px; background: rgb(129,206,151);color: white;font-size: 10px;border: 1px solid #f2f2f2;border-left: none;cursor: pointer;margin-top: 0;" class="vol">VOLUNTEER</button>
                                            </a>
                                            <a href="{{url('addBeneficiary')}}?programId={{$activity->ActivityId}}&madeByUniId={{$activity->MadeBy->UniId}}">
                                                <button style="padding: 8px;background: #2196F3;color: white;font-size: 10px;border: 1px solid #f2f2f2;border-left: none;cursor: pointer;margin-top: 0;" class="par">PARTICIPATE</button>
                                            </a>
                                        @else
                                            <a style="padding: 8px;background: #f2575f;color: white;font-size: 10px;border: 1px solid #f2f2f2;border-left: none;cursor: pointer;margin-top: 0;">This Activivity is Exclusive</a>
                                        @endif
                                    @else
                                        <a href="{{url('/addVolunteer')}}?programId={{$activity->ActivityId}}&madeByUniId={{$activity->MadeBy->UniId}}">
                                            <button style="padding: 8px; background: rgb(129,206,151);color: white;font-size: 10px;border: 1px solid #f2f2f2;border-left: none;cursor: pointer;margin-top: 0;" class="vol">VOLUNTEER</button>
                                        </a>
                                        <a href="{{url('addBeneficiary')}}?programId={{$activity->ActivityId}}&madeByUniId={{$activity->MadeBy->UniId}}">
                                            <button style="padding: 8px;background: #2196F3;color: white;font-size: 10px;border: 1px solid #f2f2f2;border-left: none;cursor: pointer;margin-top: 0;" class="par">PARTICIPATE</button>
                                        </a>  
                                    @endif
                                @endif               
                                
                                @endif
                                <div class="col-sm-3">
                                    <a href="#" onclick="window.open('fb', 'newwindow', 'width=600, height=550'); return false;"><img style="width:30px;" src="default-img/fb.png"></a>
                                </div>
                            </div>
                                
                        
                        </div>



                       


					</div>
                
                    <!--end sa activity details-->

                    <div class="row" style="background-color:white;margin-bottom:0px;padding-bottom:0px;">
                         
                        @if($canEdit === 1)
                            <a href="#tab-about" id="tab-about" onclick="changeTab('about')" style="margin-left:50px;border-bottom:solid blue 2px;">ABOUT</a>   
                            <a href="#tab-photos" id="tab-photos" onclick="changeTab('photos')" style="margin-left:50px;">PHOTOS</a> 
                            
                            <a href="#tab-released-forms" id="tab-released-forms" onclick="changeTab('released-forms')" style="margin-left:50px;">RELEASED FORMS</a> 
                            <a href="#tab-participants" id="tab-participants" onclick="changeTab('participants')" style="margin-left:50px;">PARTICIPANTS</a> 
                        @else
                            <a href="#tab-about" id="tab-about" onclick="changeTab('about')" style="margin-left:50px;border-bottom:solid blue 2px;">ABOUT</a>   
                            <a href="#tab-photos" id="tab-photos" onclick="changeTab('photos')" style="margin-left:50px;">PHOTOS</a> 

                        @endif
                    </div>
                    <script>
                        var selectedTab = 'photos'
                        function changeTab(selectedTab){
                            $('#about-tab').css('display','none');
                            $('#photos-tab').css('display','none');
                            $('#released-forms-tab').css('display','none');
                            $('#participants-tab').css('display','none');
                            
                            $('#tab-about').css('border-bottom','solid blue 0px');
                            $('#tab-photos').css('border-bottom','solid blue 0px');
                            $('#tab-released-forms').css('border-bottom','solid blue 0px');
                            $('#tab-participants').css('border-bottom','solid blue 0px');

                            
                            $('#tab-'+selectedTab).css('border-bottom','solid blue 2px');
                            $('#'+selectedTab+'-tab').toggle('slide');
                            $('#'+selectedTab+'-tab').css('display','block');
                            //alert('#'+selectedTab+'-tab');
                        }
                        function selectPhotos(){
                            //photos-tab
                            //about-tab
                            //released-forms-tab
                            //participants tab
                            //participants-tab
                            $('#tab-about').css('border-bottom','solid blue 0px');
                            $('#tab-photos').css('border-bottom','solid blue 2px');
                            $('#about-tab').css('display','none');
                            $('#photos-tab').toggle('slide');
                        }
                        function selectAbout(){
                            $('#tab-about').css('border-bottom','solid blue 2px');
                            $('#tab-photos').css('border-bottom','solid blue 0px');
                            $('#photos-tab').css('display','none');
                            $('#about-tab').toggle('slide');
                        }
                        function selectParticipants(){

                        }
                        function selectReleasedForms(){

                        }
                    </script>
                    <div id="about-tab">
                    <!--start sa about tab -->
                    <!--start sa volunteers details-->
                    <div class="row">
                        <div class="col-sm-12" style="margin-left:0px;padding-top:20px;">
                        
                        <?php
                            $volunteerCount=0;
                            $beneficiaryCount = 0;
                        ?>
                        @foreach($activity->Volunteers as $volunteer)
                    
                                @if($volunteer->VolunteerStatus==1)
                                    
                                    <?php $volunteerCount++;?>
                                
                                @endif
                        @endforeach
                        @foreach($activity->Beneficiaries as $beneficiary)
                                @if($beneficiary->BenStatus===1)
                                    <?php $beneficiaryCount++;?>
                               @endif
                        @endforeach
<?php
//for testing purposes
//$beneficiaryCount=0;
//$volunteerCount=0;
//$beneficiaryCount!=0 && $volunteerCount !=0
if($volunteerCount + $beneficiaryCount !== 0){
    $volPercent = $volunteerCount / ($volunteerCount + $beneficiaryCount) * 100;
    $benPercent = $beneficiaryCount / ($volunteerCount + $beneficiaryCount) * 100;

}else{
    $volPercent = 0;
    $benPercent = 0;
}
//echo $volPercent;
//echo $benPercent;
?>
                            <div class="page">
                                <!-- volunteers -->
                                <div class="clearfix" style="padding-bottom: 0; width: 45%; float: left; padding-left: 20%;">
                                <!-- to change value, change the value after the class p. Example: you want 30 as the value, the class should be p30-->
                                <!-- p30 = 30% progress -->
                                    <div class="c100 p{{floor($volPercent)}} big">
                                    <!-- p50 = 50% progress -->
                                    <span>{{$volunteerCount}}</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                    <span><div class="circle-text">Volunteers</div></span>
                                    </div>
                                </div>
                                <!-- end volunteers -->
                                <!-- beneficiaries -->
                                <div class="clearfix"  style="width: 45%; float: right;">
                                <!-- to change value, change the value after the class p. Example: you want 30 as the value, the class should be p30-->
                                <!-- p30 = 30% progress -->
                                    <div class="c100 p{{floor($benPercent)}} big">
                                    <!-- p50 = 50% progress -->
                                    <span>{{$beneficiaryCount}}</span>
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                    <span><div class="circle-text">Beneficiaries</div></span>
                                    </div>
                                </div>
                                <!-- end beneficiaries -->
                            </div>
                        
                        
                        
                        
                        
                        
                        </div>
                        <!--end sa chart-->

                        <!-- start sa more details sa activity -->
                        <div class="col-sm-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-8" style="padding:30px;">
                                    <div style="font-weight: 550;font-size: 15px;width: 100%;padding: 3%;background-color: #1b593e;color: white;">
                                    ACTIVITY DETAILS
                                    </div>
                                    <div style="background-color:white;padding:30px;">
                                        <div class="row">
                                            <div class="col-sm-4"><b>Activity Name</b></div>
                                            <div class="col-sm-8">{{$activity->ActivityName}}</div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-4"><b>Activity Description</b></div>
                                            <div class="col-sm-8">{{$activity->ActivityDescription}}</div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-4"><b>Venue</b></div>
                                            <div class="col-sm-8">{{$activity->ActivityVenue}}</div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-4"><b>Target Audience</b></div>
                                            <div class="col-sm-8">{{$activity->TargetAudience}}</div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-4"><b>Exclusive for {{$activity->MadeBy->UniName}} Members only</b></div>
                                            <div class="col-sm-8">{{$activity->isExclusive === 1?'Yes':'No'}}</div>
                                        </div>
                                        @if($canEdit === 1)
                                            <div class="row" style="margin-top:20px;">
                                                <div class="col-sm-4"><b>Project Status</b></div>
                                                <div class="col-sm-8">{{$activity->Status}}</div>
                                            </div>
                                            <div class="row" style="margin-top:20px;">
                                                <div class="col-sm-4"><b>Activity Status</b></div>
                                                <div class="col-sm-8">{{$activity->ActivityStatus}}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--start sa right side-->
                                <div class="col-md-4" style="padding-top:30px;">
                                    <!-- start maps-->
                                    @if($canEdit === 1)
                                        <form method="get" action="{{url('/setCoordinates')}}" id="save-coordinates-form">
                                            <input type="hidden" name="id" value="{{$activity->ActivityId}}" readonly>
                                            <input name="lat" id="lat" type="hidden" value="{{$activity->LocationLat}}" readonly>
                                            <input name="lng" id="lng" type="hidden" value="{{$activity->LocationLng}}">
                                            <img src="default-img/save-location.png" style="width:30px;" onclick="$('#save-coordinates-form').submit();">
                                        </form>
                                    @endif
                                    <div id="map" style="background-color:silver;width:100%;height:300px;">
                                        MAP
                                    </div>
                                    <!-- end maps-->
                                    <!--start sa schedules-->
                                    <div style="margin-top:30px;background-color:white;padding:10px;">
                                    <b>Activity Schedule(s)</b>
                                    <div class="row">
                                    
                                    @foreach($activity->Schedules as $sched)
                                        <div class="col-sm-12"><hr></div>
                                        <div class="col-sm-3"><img src="default-img/calendar.jpg" style="width:100%" alt="calendar"></div>
                                        <div class="col-sm-9">
                                            <p style="font-size: 20px;margin-bottom:0px;">{{date('M jS,Y',strtotime($sched->SchedDate))}}</p>
                                            <small>{{date("h:i a",strtotime($sched->SchedTime))}} until {{date("h:i a",strtotime($sched->SchedTimeEnd))}}</small>
                                        </div>
                                        
                                    @endforeach
                                    </div>
                                    
                                    </div>
                                    <!--end sa schedules-->
                                    <!--  start sa sponsors-->
                                    <div style="margin-top:30px;background-color:white;padding:10px;">
                                    <h3>PROJECT SPONSORS</h3>
                                        <table class="table">
                                            <tr>
                                                <th>Sponsor Name</th>
                                                <th>Address</th>
                                                <th>Contact Number</th>
                                            </tr>
                                            @foreach($activity->Sponsors as $sponsor)
                                            <tr>
                                                <td>{{$sponsor->SponsorName}}</td>
                                                <td>{{$sponsor->SponsorAddress}}</td>
                                                <td>{{$sponsor->SponsorContactNo}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                
                                    </div>
                                    <!--end sa sponsors-->
                                </div>
                                <!-- end sa right side-->
                            </div>
                        </div><!-- end sa more details sa activity -->
                        
                        

					</div><!--end sa participants details-->
                
                    
                    
                    </div><!-- end sa about tab-->
                    <!--start sa photos tab-->
                    <div id="photos-tab" style="display:none;">
                        <h2>PHOTOS</h2>
                        @if($activity->ActivityStatus === "Approved" && $activity->Status === "Approved")
                            <button data-toggle="modal" data-target="#uploadNewPhotosModal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;">+ Upload</button>
                        @else
                            @if($activity->ActivityStatus!=="Approved")
                                <button>Cannot upload photos to a pending Activity</button>
                            @endif
                            @if($activity->Status!=="Approved")
                                <button>Cannot upload photos to a pending project</button>
                            @endif
                        @endif    
                        <div class="row">
                        
                            @foreach($activity->Photos as $photo)
                                @if($photo->Status === 1)
                                <div class="col-sm-3">
                                    
                                    <img onclick="enlargeImage('img/activities/{{$photo->FilePath}}')" style="height:200px;width:200px;" src="img/activities/{{$photo->FilePath}}" />
                                </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if(Session::get('type')==="Director" && $activity->MadeBy->UniId === Session::get('uniId'))
                            <h2>PENDING PHOTOS</h2>
                            
                            <form action="{{url('approveUnapprovedPhotos')}}" method="get">
                            <div class="row">
                            @foreach($activity->Photos as $photo)
                                @if($photo->Status === 0)
                                <div class="col-sm-3">
                                        <img onclick="enlargeImage('img/activities/{{$photo->FilePath}}')" style="height:200px;width:200px;" src="img/activities/{{$photo->FilePath}}" />
                                        <input type="checkbox" name="photoIds[]" value="{{$photo->PictureId}}">

                                </div>
                                @endif
                            @endforeach
                                <div class="col-sm-12">
                                
                                    <input type="submit" value="+ Approve" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;">
                                </div>
                           
                            </div>
                            </form>
                        @endif
                    </div>

                    <script>
                        function enlargeImage(src){
                            $('#preview-img').attr('src',src);
                            $('#enlargePhotoModal').modal('show');
                        }
                    </script>
                    <div class="modal fade" id="enlargePhotoModal" role="dialog">
                        <div class="modal-dialog modal-lg"  role="document">
                            <div class="modal-content">
                                <div class="modal-body" style="text-align:center">
                                    <img src="" style="width:600px;" id="preview-img" alt="Image not found">
                                </div>
                            </div>
                        </div>
                    </div>  
                                
                    <!--end sa photos tab-->
                    <!--start sa released forms tab-->
                    <div id="released-forms-tab" style="display:none;">
                    
                        <h2>RELEASED FORMS</h2>
                        
                        @if($activity->ActivityStatus === "Approved" && $activity->Status === "Approved")
                            <a href="#" data-toggle="modal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" data-target="#assignEvaluationToolModal">
                                + Release Evaluation Tool
                            </a>
                        @else
                            @if($activity->ActivityStatus!=="Approved")
                                <button>Cannot add released form to a pending Activity</button>
                            @endif
                            @if($activity->Status!=="Approved")
                                <button>Cannot add  released form to a pending project</button>
                            @endif
                        @endif
                        <br>
                        <br>    
                        <table class="table table-striped">
                            <tr style="background-color:#1b593e;color:white;">
                                <th>Released Form Name</th>
                                <th>From/To</th>
                                <th>To be Answered by</th>
                                <th>No. of respodents</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($activity->ReleasedForms as $releasedForm)
                            <tr>
                                <td>{{$releasedForm->EvaluationFormName}}</td>
                                <td>{{date("M jS, Y",strtotime($releasedForm->FromDate))}} / {{date("M jS, Y",strtotime($releasedForm->ToDate))}}</td>
                                <td>{{$releasedForm->ToBeAnsweredBy}}</td>
                                <td>{{$releasedForm->totalResponses}}</td>
                                <td>
                                    <a href="#" onclick="editReleasedForm({{$releasedForm->ReleasedFormId}});">
                                    <img data-toggle="tooltip" title="Edit Evaluation Details" src="default-img/edit.png" alt="edit" style="width:20px;"></a>
                                </td>
                                <td>
                                    <a href="#" onclick="deleteReleasedForm({{$releasedForm->ReleasedFormId}});">
                                    <img data-toggle="tooltip" title="Cancel Evaluation" src="default-img/trash.png" alt="delete" style="width:20px;"></a>
                                </td>
                                <td>
                                    <a href="{{url('getResults')}}?rfid={{$releasedForm->ReleasedFormId}}">
                                    <button class="blue-button">View Results</button></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                                                
                        <script>
                            function deleteReleasedForm(rfId){
                               if(confirm('Are you sure you want to delete released form?')){
                                   window.location.href="{{url('deleteReleasedForm')}}?rfId="+rfId;
                               }
                            }
                            function editReleasedForm(rfId){
                                $.ajax({
                                    url: "{{url('getReleasedForm')}}?rfId="+rfId,
                                    type: "get", 
                                    success: function(response) {
                                        response=JSON.parse(response);
                                        document.getElementById("rfId").value=response["ReleasedFormId"];
                                        document.getElementById("toDate").value=response["ToDate"];
                                        document.getElementById("fromDate").value=response["FromDate"];
                                    $('#initialFor').html(response["ToBeAnsweredBy"]); document.getElementById("initialFor").value=response["ToBeAnsweredBy"];
                                    
                                    $('#editReleasedFormModal').modal('show');
                                    },
                                    error: function(xhr) {
                                    alert('error');
                                    }
                                });
                            }
                        </script>
                    </div>
                    <!-- end sa released forms tab-->

                    <!-- start sa participants tab-->
                    <div id="participants-tab" style="display:none;">
                        <h2>PARTICIPANTS</h2>

                            <div class="nav nav-tabs justify-content-start" role="tablist">
                                <a class="nav-item nav-link active" href="#volunteer-tab" data-toggle="tab" style="color:black;padding:20px;text-align:center;width:33%" role="tab">Volunteers</a>
                                <a class="nav-item nav-link" href="#benef-tab" data-toggle="tab" style="color:black;padding:20px;text-align:center;width:33%" role="tab">Beneficiaries</a>
                                <a class="nav-item nav-link" href="#requests-tab" data-toggle="tab" style="color:black;padding:20px;text-align:center;width:33%" role="tab">Requests to join</a>
                            </div>
                            <div class="tab-content" style="background-color:white;padding:20px;">
                            

                            <div id="volunteer-tab" class="tab-pane fade show active" role="tabpanel">
                                @if($activity->ActivityStatus === "Approved" && $activity->Status === "Approved")
                                <button data-toggle="modal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" data-target="#addNewVolunteersModal">+ Add Volunteers</button>
                                
                                <a href="{{url('manageAttendance')}}?ai={{$activity->ActivityId}}"><button data-toggle="modal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;">+ Manage Attendance</button></a>
                                @else
                                    @if($activity->ActivityStatus!=="Approved")
                                        <button>Cannot add volunteers to a pending Activity</button>
                                    @endif
                                    @if($activity->Status!=="Approved")
                                        <button>Cannot add volunteers to a pending project</button>
                                    @endif
                                @endif
                                @include('forms.deleteApprovedVolunteers')
                            </div>
                            <div id="benef-tab" class="tab-pane fade show" role="tabpanel">
                                
                                @if($activity->ActivityStatus === "Approved" && $activity->Status === "Approved")
                                    <button data-toggle="modal" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" data-target="#addNewBeneficiariesModal">
                                        + Add Beneficiaries
                                    </button>
                                @else
                                    @if($activity->ActivityStatus!=="Approved")
                                        <button>Cannot add beneficiaries to a pending Activity</button>
                                    @endif
                                    @if($activity->Status!=="Approved")
                                        <button>Cannot add beneficiaries to a pending project</button>
                                    @endif
                                @endif
                                @include('forms.deleteApprovedBeneficiaries')     
                            </div>
                            <div id="requests-tab" class="tab-pane fade show" role="tabpanel">
                                <form action="{{url('addApprovedParticipants')}}" id="requests-participants-form">
                                    <table class="table table-striped" style="border:solid silver 1px;">
                                        <tr style="background: #1b593e;color: white;">
                                            <th>Name</th>
                                            <th>University</th>
                                            <th>Address</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                    @foreach($activity->Volunteers as $volunteer)
                                        @if($volunteer->VolunteerStatus === 0)
                                        <tr>
                                            <td>{{$volunteer->Name}} {{$volunteer->LastName}}</td>
                                            <td>{{$volunteer->UniName}}</td>
                                            <td>{{$volunteer->Address}}{{$volunteer->VolunteerStatus}}</td>
                                            <td>{{$volunteer->Type}} Volunteer</td>
                                            <td><input type="checkbox" name="volIds[]" value="{{$volunteer->VolunteerId}}"></td>
                                        </tr>
                                        @endif
                                    @endforeach      
                                    @foreach($activity->Beneficiaries as $beneficiary)
                                        @if($beneficiary->BenStatus === 0)
                                        <tr>
                                            <td>{{$beneficiary->Name}} {{$beneficiary->LastName}}</td>
                                            <td>{{$beneficiary->UniName}}</td>
                                            <td>{{$beneficiary->Address}}{{$beneficiary->BenStatus}}</td>
                                            <td>{{$beneficiary->Type}} Beneficiary</td>
                                            <td><input type="checkbox" name="benIds[]" value="{{$beneficiary->BeneficiaryId}}"></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </table>
                                    <button type="button" onclick="addApprovedParticipants()">APPROVE</button>
                                    <button type="button" onclick="deletePendingParticipants()">DELETE</button>
                                </form>
                                                            
                                <script>
                                    
                                    function addApprovedParticipants(){
                                    
                                        if(confirm('Are you sure you want to add new participants?')){
                                            $.ajax({
                                                url: "{{url('addApprovedParticipants')}}",
                                                type: "get", 
                                                data: $("#requests-participants-form").serialize(),
                                                success: function(response) {
                                                alert("successfully added participants");
                                                location.reload();
                                                },
                                                error: function(xhr) {
                                                    alert("Data: error");
                                                }
                                            });
                                        }
                                    }
                                    function deletePendingParticipants(){
                                    
                                        if(confirm('Are you sure you want to delete participants?')){
                                        $.ajax({
                                            url: "{{url('deletePendingParticipants')}}",
                                            type: "get", 
                                            data: $("#requests-participants-form").serialize(),
                                            success: function(response) {
                                            alert("successfully deleted participants");
                                            location.reload();
                                            },
                                            error: function(xhr) {
                                                alert("Data: error");
                                            }
                                        });
                                        }
                                    }
                                </script>
                            </div>
 



                            </div>
                            
                    </div>
                    <!-- end sa participants tab-->
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
    @include('includes.scripts')
     
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWkTUIJEfAEeJsKkySTmj0tWXnJ7_frrA&callback=initMap">
    </script>
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
      
</body>


</html>