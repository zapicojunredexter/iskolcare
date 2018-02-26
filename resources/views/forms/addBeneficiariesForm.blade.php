
<div class="modal fade" id="addNewBeneficiariesModal">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header">
                ADD BENEFICIARIES TO ACTIVITY
            </div>
            <div class="modal-body" style="">
                    

            <form method="get" action="{{url('addBeneficiaries')}}">
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
            @if(strpos($uniUser->AccountType,"Beneficiary") > -1)
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
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>



<form method="get" action="{{url('addBeneficiaries')}}">
    <input type="hidden" name="activityId" value="{{$activity->ActivityId}}">
    <div id="addBeneficiariesModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addBeneficiariesModal')">×</span>
                    <h2>ADD BENEFICIARIES</h2>
            </div>
            <div class="modal-body">
                activityId
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Email Address</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                    </tr>
                    @foreach($activity->uniUsers as $uniUser)
                        @if($uniUser->AccountType === "Beneficiary - Leader" || $uniUser->AccountType === "Beneficiary - Member")
                        <tr id="row-{{$uniUser->AccountId}}">
                            <td>{{$uniUser->LastName}}, {{$uniUser->Name}}</td>
                            <td>{{$uniUser->Username}}</td>
                            <td>{{$uniUser->Password}}</td>
                            <td>{{$uniUser->ContactNumber}}</td>
                            <td>{{$uniUser->Address}}</td>
                            <td>{{$uniUser->EmailAddress}}</td>
                            <td>{{$uniUser->Birthday}}</td>
                            <td>{{$uniUser->Gender}}</td>
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
            </div>
            <div class="modal-footer">      
                <input type="submit" value="Approve">
            </div>
        </div>
      </div>
    
</form>