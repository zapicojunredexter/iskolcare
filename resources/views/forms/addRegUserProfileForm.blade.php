<div class="modal fade" id="addRegUserModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                ADD NEW USER
            </div>
            <div class="modal-body" style="">
                    


            <form method="POST" id="addNewUserForm" onsubmit="return false;" action="{{ url('/normalRegistration')}}">
       
            {{csrf_field()}}
    <div class="row">
        <div class="col-sm-3"><b>First Name </b></div>
        <div class="col-sm-9">
            <input type="text" onkeyup="checkAddAccount()" id="add-fname" name="name" placeholder="Name" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Last Name</b></div>
        <div class="col-sm-9">
            <input type="text" onkeyup="checkAddAccount()" id="add-lname" name="lastName" placeholder="Last Name" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Username</b></div>
        <div class="col-sm-9">
            <input type="text" onkeyup="checkAddAccount()" id="add-uname" name="username" placeholder="Username" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Password</b></div>
        <div class="col-sm-9">
            <input type="password" onmouseover="this.type='text'" onmouseout="this.type='password'" onkeyup="checkAddAccount()" id="add-password" name="password" placeholder="Password" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Contact Number</b></div>
        <div class="col-sm-9">
            <input type="text" name="contactNumber" placeholder="Contact Number" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Address</b></div>
        <div class="col-sm-9">
            <input type="text" name="address" placeholder="Address" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>E-mail Address</b></div>
        <div class="col-sm-9">
            <input type="text" name="emailAddress" placeholder="Email Address" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Birthdate</b></div>
        <div class="col-sm-9">
            <input type="date" name="birthdate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Gender</b></div>
        <div class="col-sm-9">
            <input type="radio" value="Male" name="gender" checked> Male 
            <input type="radio" value="Female" name="gender"> Female<br>
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Citizenship</b></div>
        <div class="col-sm-9">
            <input type="text" placeholder="Citizenship" name="citizenship" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Contact Person</b></div>
        <div class="col-sm-9">
            <input type="text" placeholder="Contact Person" name="contPerson" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-sm-3"><b>Person Contact Number</b></div>
        <div class="col-sm-9">
            <input type="text" placeholder="Contact Person Contact Number" name="contPersonContNum" class="form-control">
        </div>
    </div>
    <div class="row" style="margin-top:15px;"   >
        <div class="col-sm-3"><b>Account Type</b></div>
        <div class="col-sm-9">
            <select name="accountType" class="form-control">
                <option value="Volunteer - Student">Student Volunteer</option>
                <option value="Volunteer - Faculty">Faculty Volunteer</option>
                <option value="Volunteer - External">External Volunteer</option>
                <option value="Beneficiary - Leader">Beneficiary - Leader</option>
                <option value="Beneficiary - Member">Beneficiary - Member</option>
            </select>
        </div>  
    </div>
   


    <button id="add-account-btn" type="button" onclick="this.disabled='true';addNewAccount()" class="blue-button" style="margin-left:45%;" disabled>SUBMIT</button>


            </form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
function checkAddAccount(){
    var fname,lname,uname,password;
    fname=$('#add-fname').val();
    lname=$('#add-lname').val();
    uname=$('#add-uname').val();
    password=$('#add-password').val();

    if(fname.trim()!=="" && lname.trim()!=="" && uname.trim()!=="" && password.trim()!==""){
        $('#add-account-btn').prop('disabled',false);
    }else{
        $('#add-account-btn').prop('disabled',true);
    }
}

function addNewAccount(){
     $.ajax({
		url: "{{ url('/normalRegistration')}}",
		type: "post", 
		data: $("#addNewUserForm").serialize(),
        success: function(response) {
            if(response === "Successfully added new account"){
                
                swal(response,"","success").then(()=>{location.reload();});
		        
            }else{
                swal(response,"","error").then(()=>{$('#add-account-btn').prop('disabled',false);});
		        
            }
		},
		error: function(xhr) {
			alert("Something went wrong!");
            $('#add-account-btn').prop('disabled',false);
		}
	});
}
</script>

