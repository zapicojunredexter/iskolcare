<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @include('includes.libs')

</head>
<body>
    <div class="modal fade" id="viewUserDetails" role="dialog">
        <div class="modal-dialog"  role="document">
            <div class="modal-content" style="">
                <div class="modal-body" style="" id="details-body">

                   haha
xc

                </div>
                
            </div>
        </div>
    </div>
    <div style="padding:10px;">
        <h3 style="font-weight:bold;">{{$activity->ActivityName}}</h3>
        <br>
        <select class="form-control" onchange="changeDate(this.value)">
            @foreach($activity->Schedules as $sched)
                    <option value="{{$sched->SchedDate}}" {{$selectedDate===$sched->SchedDate?'selected':''}}>{{date("M jS,Y",strtotime($sched->SchedDate))}}</option>
            @endforeach
        </select>
        <br>
        @foreach($activity->Schedules as $sched)
            <div id="{{$sched->SchedDate}}-date" style="display:{{$selectedDate===$sched->SchedDate?'block':'none'}}">
               

                <form>
                    <input type="hidden" value="{{$activity->ActivityId}}" name="activityId">
                    <input type="hidden" value="{{$sched->SchedDate}}" name="addAttendanceToDate" readonly>
                    <input type="hidden" value="1" name="toEditVol" readonly>
                    <div>Volunteers</div>
                    @foreach($sched->VolunteerAttendances as $volAtt)

                        <div style="width:48%;float:left;">
                            <small style="white-space:nowrap;display:block;overflow:hidden;text-overflow:ellipsis;" onclick="$('#details-body').html(`{{$volAtt->Name}}`);$('#viewUserDetails').modal('show')">
                            {{$volAtt->Name}}
                            </small>
                        </div>
                        <div style="width:48%;float:right;text-align:right;">
                            <small style="white-space:nowrap;display:block;overflow:hidden;text-overflow:ellipsis;">
                            {{$volAtt->AttendanceStatus}}

                            <input name="volAtt[]" value="{{$volAtt->VolId}}" type="checkbox" {{($volAtt->AttendanceStatus === "Present"?'checked':'')}} {{date('Y-m-d')!==$sched->SchedDate?'disabled':''}}>
                            </small>
                        </div>

                    @endforeach
                    
                        <input onclick="this.disabled='true';this.form.submit();" style="padding:5px 10px 5px 10px;margin-left:40%" type="submit" value="SUBMIT" class="blue-button" {{date('Y-m-d')!==$sched->SchedDate?'disabled':''}}>
                </form>


                <form>
                    <input type="hidden" value="{{$activity->ActivityId}}" name="activityId">
                    <input type="hidden" value="{{$sched->SchedDate}}" name="addAttendanceToDate" readonly>
                    <input type="hidden" value="1" name="toEditBen" readonly>

                    <div>Beneficiaries</div>
                    @foreach($sched->BeneficiaryAttendances as $benAtt)
                    <div style="width:48%;float:left;">
                        <small style="white-space:nowrap;display:block;overflow:hidden;text-overflow:ellipsis;">
                        {{$benAtt->Name}}
                        </small>
                    </div>
                    <div style="width:48%;float:right;">
                        <small style="white-space:nowrap;display:block;overflow:hidden;text-overflow:ellipsis;text-align:right;">
                           {{$benAtt->AttendanceStatus}}
                            <input name="benAtt[]" value="{{$benAtt->BenId}}" type="checkbox" {{($benAtt->AttendanceStatus === "Present"?'checked':'')}}  {{date('Y-m-d')!==$sched->SchedDate?'disabled':''}}> 
                        </small>
                    </div>
                    @endforeach

                        <input onclick="this.disabled='true';this.form.submit();" style="padding:5px 10px 5px 10px;margin-left:40%" type="submit" value="SUBMIT" class="blue-button" {{date('Y-m-d')!==$sched->SchedDate?'disabled':''}}>
                    
                </form>
            </div>
        @endforeach

    </div>
    @include('includes.scripts')
    <script>     
        var dates = [];
        @foreach($activity->Schedules as $sched)
            dates.push('{{$sched->SchedDate}}');
        @endforeach
        
        @if(empty($selectedDate) || sizeof($activity->Schedules === 1))
            document.getElementById(dates[0]+'-date').style.display='block';
        @endif

        function changeDate(date){
            for(var i = 0;i<dates.length;i++){
                document.getElementById(dates[i]+'-date').style.display='none';
            }
            document.getElementById(date+'-date').style.display='block';
            //$('#'+date+'-date').show();
        }
    </script>
</body>
</html>