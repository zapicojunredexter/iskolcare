<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Activity Attendance</title>
</head>

<body>

    @include('forms.uploadCertificateForm')

    <div class="modal fade" id="editAttendanceModal" role="dialog">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    EDIT ATTENDANCE DETAILS
                <span onclick="$('#editAttendanceModal').modal('hide');" class="close-span">&times;</span>
                </div>
                <div class="modal-body" style="">

                    <form method="get" action="{{url('editAttendanceRecords')}}">
                        <input type="hidden" value="{{$activity->ActivityId}}" name="ai">
                        <input type="hidden" id="editDate" name="date">
                        <input type="text" id="type" name="type">
                        <div id="checkboxes">
                        </div>
                        
                        <button onclick="this.disabled='true';this.form.submit()" class="blue-button" style="margin-left:40%;">SUBMIT</button>
                    </form>
                                            
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>


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
                $label="Activity Attendance";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content" style="padding:0px;">
                <div class="container-fluid">
                    <div class="row">
				        <div class="col-sm-12" id="printable">
                            <a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}#tab-participants"><h2>{{$activity->ActivityName}}</h2></a>
                            
                            <div id="tab-list" class="nav nav-tabs justify-content-start" role="tablist">
                                <a class="nav-item nav-link active" id="volunteers-tab" onclick="window.location.href='#volunteers-tab'" style="width:50%;color:black;padding:20px;text-align:center;font-weight:bold;" data-toggle="tab" class="nav-item nav-link active" href="#tab-volunteers" data-toggle="tab" role="tab" >VOLUNTEERS</a>
                                <a class="nav-item nav-link" id="beneficiaries-tab" onclick="window.location.href='#beneficiaries-tab'" href="#tab-beneficiaries" style="width:50%;color:black;padding:20px;text-align:center;font-weight:bold;" class="nav-item nav-link active" data-toggle="tab" role="tab" >BENEFICIARIES</a>
                                
                            </div>
                            <div class="tab-content" style="background-color:white;padding:20px;">
                                
                                <!-- start of volunteers -->
                                <div class="tab-pane fade show active" id="tab-volunteers">
                                    <script>
                                        function printVolunteerAttendance(){
                                            $('#tab-list').hide();
                                            document.getElementById('volunteer-to-hide').style.display='none';
                                            //document.getElementById('tab-list').style.display='none';
                                            
                                            var printable = document.getElementById('printable').innerHTML;
                                            var original = document.body.innerHTML;
                                            document.body.innerHTML = printable;
                                            window.print();
                                            document.body.innerHTML = original;
                                            document.getElementById('volunteer-to-hide').style.display='block';
                                            $('#tab-list').show();
                                            
                                            //document.getElementById('tab-list').style.display='block';
                                            
                                        }
                                    </script>
                                    <div id="volunteer-to-hide">
                                        <button class="blue-button" onclick="printVolunteerAttendance()">print</button>
                                        <button style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" onclick="$('#certificate-for').val('volunteers');$('#chooseCertificateModal').modal('show');"> Create Certificates</button>
                                    </div>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Volunteer</th>
                                            @foreach($distinctDates as $date)
                                            <th><a style="color:#2196F3;cursor:pointer;" onclick="getAttendanceDetails('volunteer',{{$activity->ActivityId}},'{{$date->SchedDate}}')">{{date("M jS, Y",strtotime($date->SchedDate))}}</a></th>
                                            @endforeach
                                        </tr>
                                        @foreach($volunteers as $volunteer)
                                        <tr>
                                            <td>{{$volunteer->LastName}}, {{$volunteer->Name}}</td>
                                            @foreach($volunteer->AttendanceDates as $date)


                                            <td>
                                                @if(!empty($date->Record))
                                                    {{($date->Record[0]->Status)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </table>


                                </div>
                                
                                <!-- end of volunteers -->
                                
                                <!-- start of beneficiaires -->
                                <div class="tab-pane fade show" id="tab-beneficiaries">
                                    <script>
                                        function printBeneficiaryAttendance(){
                                            $('#tab-list').hide();
                                            
                                            document.getElementById('beneficiary-to-hide').style.display='none';
                                            
                                            document.getElementById('tab-list').style.display='none';
                                            
                                            var printable = document.getElementById('printable').innerHTML;
                                            var original = document.body.innerHTML;
                                            document.body.innerHTML = printable;
                                            window.print();
                                            document.body.innerHTML = original;
                                            document.getElementById('beneficiary-to-hide').style.display='block';
                                            
                                            $('#tab-list').show();
                                            //document.getElementById('tab-list').style.display='block';
                                            
                                        }
                                    </script>
                                    <div id="beneficiary-to-hide">
                                        <button onclick="printBeneficiaryAttendance()" class="blue-button">print</button>
                                        <button style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" onclick="$('#certificate-for').val('beneficiaries');$('#chooseCertificateModal').modal('show');"> Create Certificates</button>
                                    </div>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Beneficiaries</th>
                                            @foreach($distinctDates as $date)
                                            <th><a style="color:#2196F3;cursor:pointer;" onclick="getAttendanceDetails('beneficiary',{{$activity->ActivityId}},'{{$date->SchedDate}}')">{{date("M jS, Y",strtotime($date->SchedDate))}}</a></th>
                                            @endforeach
                                        </tr>
                                        @foreach($beneficiaries as $beneficiary)
                                        <tr>
                                            <td>{{$beneficiary->LastName}}, {{$beneficiary->Name}}</td>
                                            @foreach($beneficiary->AttendanceDates as $date)


                                            <td>
                                                @if(!empty($date->Record))
                                                    {{($date->Record[0]->Status)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </table>



                                </div>
                                
                                <!-- end of beneficiaires -->
                            </div>
                            
                            
                            <script>
                                function getAttendanceDetails(type,actId,date){
                                    
                                    if("{{date('Y-m-d')}}"===date){
                                        document.getElementById('editDate').value=date;
                                        $('#checkboxes').html("");
                                        
                                        $('#type').val(type);
                                        if(type==="volunteer"){
                                            $.ajax({
                                                url: "{{url('mobileAttendance')}}?actId="+actId+"&date="+date+"&type="+type,
                                                type: "get", 
                                                success: function(response) {
                                                    response=JSON.parse(response);
                                                    console.log(response);
                                                    for(var i=0;i<response.Volunteers.length;i++){
                                                        console.log(response.Volunteers[i].Status);
                                                        if(response.Volunteers[i].Status === "Present"){

                                                            $('#checkboxes').append("<input type='checkbox' checked name='"+response.Volunteers[i].VolunteerId+"-attendance'>&nbsp;&nbsp;&nbsp;"+response.Volunteers[i].Name+" "+response.Volunteers[i].LastName+"<br>");
                                                        }else{
                                                            $('#checkboxes').append("<input type='checkbox' name='"+response.Volunteers[i].VolunteerId+"-attendance'>&nbsp;&nbsp;&nbsp;"+response.Volunteers[i].Name+" "+response.Volunteers[i].LastName+"<br>");
                                                        }
                                                    }
                                                    //displayModal('editAttendanceModal');
                                                    $('#editAttendanceModal').modal('show');

                                                },
                                                error: function(xhr) {
                                                    alert('error');
                                                }
                                            });
                                        }else
                                            if(type==="beneficiary"){
                                                $.ajax({
                                                    url: "{{url('mobileAttendance')}}?actId="+actId+"&date="+date+"&type="+type,
                                                    type: "get", 
                                                    success: function(response) {
                                                        response=JSON.parse(response);
                                                        console.log(response);
                                                        for(var i=0;i<response.Beneficiaries.length;i++){
                                                            console.log(response.Beneficiaries[i].Status);
                                                            if(response.Beneficiaries[i].Status === "Present"){

                                                                $('#checkboxes').append("<input type='checkbox' checked name='"+response.Beneficiaries[i].BeneficiaryId+"-attendance'>&nbsp;&nbsp;&nbsp;"+response.Beneficiaries[i].Name+" "+response.Beneficiaries[i].LastName+"<br>");
                                                            }else{
                                                                $('#checkboxes').append("<input type='checkbox' name='"+response.Beneficiaries[i].BeneficiaryId+"-attendance'>&nbsp;&nbsp;&nbsp;"+response.Beneficiaries[i].Name+" "+response.Beneficiaries[i].LastName+"<br>");
                                                            }
                                                        }
                                                        //displayModal('editAttendanceModal');
                                                        $('#editAttendanceModal').modal('show');

                                                    },
                                                    error: function(xhr) {
                                                        alert('error');
                                                    }
                                                });
                                            }
                                    }else{
                                        swal("Cannot set attendance","{{date('M jS Y')}}","error").then(()=>{});
                                    }
                                }
                            </script>
                

                        </div>


					</div>
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
    
</body>


</html>