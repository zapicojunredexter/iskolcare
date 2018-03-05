<div class="modal fade" id="editUserDetailsModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                Edit Account Details
            </div>
            <div class="modal-body" style="">
                    
                            
                <form action="{{url('/editProfile')}}" method="post" style="padding:0px 0px 20px 20px;">
                    {{csrf_field()}}
                    
                    <div id="uneditable">
                        <input type="hidden" id="accountId" name="accountId">
                        <br><p>Name:
                        <input type="text" id="name" name="name" class="form-control">
                        <br>Last Name:
                        <input type="text" id="lName" name="lName" class="form-control">
                        </p>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            Password
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            Contact Number
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="contactNumber" name="contactNumber" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            Address
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            E-mail Address
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="emailAddress" name="emailAddress" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px;display:none;">
                        <div class="col-sm-3">
                            Gender
                        </div>
                        <div class="col-sm-9">
                            <input type="radio" name="gender" value="Male" checked>Male 
                            <input type="radio" name="gender" value="Female"
                                   @if($data->ContPersonContNumber)
                                    checked
                                   @endif
                                   >Female
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            Contact Person
                        </div>
                        <div class="col-sm-9">
                            <input name="contPerson" value="{{$data->ContPerson}}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-3">
                            Contact Person Contact Number
                        </div>
                        <div class="col-sm-9">
                            <input name="contPersonContNum" value="{{$data->ContPersonContNumber}}" type="text" class="form-control">
                        </div>
                    </div>
                    
                    <select style="display:none;" id="accType" name="accountType" class="form-control">
                        <option id="initialType">-</option>
                        <option value="Volunteer - Student">Student Volunteer</option>
                        <option value="Volunteer - Faculty">Faculty Volunteer</option>
                        <option value="Beneficiary - Leader">Beneficiary - Leader</option>
                        <option value="Beneficiary - Member">Beneficiary - Member</option>
                    </select>
                    <input type="submit" value="SUBMIT" class="blue-button" style="margin-left:40%">
                
                </form>
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

