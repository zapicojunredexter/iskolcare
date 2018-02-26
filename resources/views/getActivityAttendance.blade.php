<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
</head>

<body>

    @include('forms.uploadCertificateForm')

    <div class="modal fade" id="editAttendanceModal" role="dialog">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    EDIT ATTENDANCE DETAILS
                </div>
                <div class="modal-body" style="">

                    <form method="get" action="{{url('editAttendanceRecords')}}">
                        <input type="hidden" value="{{$activity->ActivityId}}" name="ai">
                        <input type="hidden" id="editDate" name="date">
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
				        
                        <div class="col-sm-12">
                            <h2>{{$activity->ActivityName}}</h2>
                            <button style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;" onclick="$('#chooseCertificateModal').modal('show');"> Create Certificates</button>
                            <table class="table table-striped">
                                <tr>
                                    <th>Volunteer</th>
                                    @foreach($distinctDates as $date)
                                    <th><a style="color:red;" onclick="getAttendanceDetails({{$activity->ActivityId}},'{{$date->SchedDate}}')">{{$date->SchedDate}}</a></th>
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
                            

                            <script>
                                function getAttendanceDetails(actId,date){
                                document.getElementById('editDate').value=date;
                                    $('#checkboxes').html("");
                                    $.ajax({
                                        url: "{{url('mobileAttendance')}}?actId="+actId+"&date="+date,
                                        type: "get", 
                                        success: function(response) {
                                            response=JSON.parse(response);
                                            console.log(response);
                                            for(var i=0;i<response.Volunteers.length;i++){
                                                console.log(response.Volunteers[i].Status);
                                                if(response.Volunteers[i].Status === "Present"){
                                                    
                                                    $('#checkboxes').append("<input type='checkbox' checked name='"+response.Volunteers[i].VolunteerId+"-attendance'>"+response.Volunteers[i].Name+" "+response.Volunteers[i].LastName+"<br>");
                                                }else{
                                                    $('#checkboxes').append("<input type='checkbox' name='"+response.Volunteers[i].VolunteerId+"-attendance'>"+response.Volunteers[i].Name+" "+response.Volunteers[i].LastName+"<br>");
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