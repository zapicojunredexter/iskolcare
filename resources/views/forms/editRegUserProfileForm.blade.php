<div class="modal fade" id="editUserDetailsModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                Edit Account Details
            </div>
            <div class="modal-body" style="">
                    
                            
                <form action={{url('/editProfile')}} method="post">
                    {{csrf_field()}}
                    <div id="uneditable">
                        <input type="hidden" id="accountId" name="accountId">
                        <br><p>Name:
                        <input type="text" id="name" name="name" class="form-control">
                        <br>Last Name:
                        <input type="text" id="lName" name="lName" class="form-control">
                        </p>
                    </div>
                    

                    
                    Password:
                    <input type="text" id="password" name="password" class="form-control">
                    <br>Contact Number:
                    <input type="text" id="contactNumber" name="contactNumber" class="form-control">
                    <br>Address:
                    <input type="text" id="address" name="address" class="form-control">
                    <br>E-mail Address:
                    <input type="text" id="emailAddress" name="emailAddress" class="form-control"><br>
                    
                    Gender<br>
                    <input type="radio" name="gender" value="Male" checked>Male 
                    <input type="radio" name="gender" value="Female">Female
                    <select id="accType" name="accountType" class="form-control">
                        <option id="initialType">-</option>
                        <option value="Volunteer - Student">Student Volunteer</option>
                        <option value="Volunteer - Faculty">Faculty Volunteer</option>
                        <option value="Beneficiary - Leader">Beneficiary - Leader</option>
                        <option value="Beneficiary - Member">Beneficiary - Member</option>
                    </select>
                    <br>
                    <br>
                    Contact Person
                    <input name="contPerson" value="{{$data->ContPerson}}" type="text" class="form-control">
                    <br>
                    Contact Person Contact Number
                    <input name="contPersonContNum" value="{{$data->ContPersonContNumber}}" type="text" class="form-control">
                    <input type="submit" value="SUBMIT" class="blue-button" style="margin-left:40%">
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

