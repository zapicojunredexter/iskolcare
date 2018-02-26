
<div class="modal fade" id="addNewVolunteersModal">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header">
                ADD VOLUNTEERS TO ACTIVITY
            </div>
            <div class="modal-body" style="">
                    
       <div class="row">
            <div class="col-sm-12">
            <form action="{{url('addVolunteers')}}" method="get">
    <input type="hidden" name="activityId" value="{{$activity->ActivityId}}">
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Birth Date</th>
            <th>Gender</th>
            <th>Account Type</th>
        </tr>
        @foreach($activity->uniUsers as $uniUser)
            @if(strpos($uniUser->AccountType,"Volunteer") > -1)
            <tr id="row-{{$uniUser->AccountId}}">
                <td>{{$uniUser->LastName}}, {{$uniUser->Name}}</td>
                <td>{{$uniUser->Address}}</td>
                <td>{{$uniUser->Birthday}}</td>
                <td>{{$uniUser->Gender}}</td>
                <td>{{$uniUser->AccountType}}</td>
                <td id="{{$uniUser->AccountId}}Button">
                    <input type="hidden" readonly>
                </td>
                <td><input type="checkbox" name="accIds[]" value="{{$uniUser->AccountId}}"></td>
                <td id="{{$uniUser->AccountId}}Type">
                    <input name="{{$uniUser->AccountId}}Type" type="hidden" value="{{$uniUser->AccountType}}">
                </td>
            </tr>
            @endif
        @endforeach
    </table>
    <button style="margin-left:40%;" class="blue-button" onclick="this.disabled='true';this.form.submit();">SUBMIT</button>
</form>
            </div>
       </div>





            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

