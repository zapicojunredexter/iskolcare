                <form method="post" id="editSubDetailsForm" action="{{url('/editProfile')}}">
                {{csrf_field()}}
                    
                <input type="hidden" value="{{$subDetails->SubscriberId}}" readonly name="id" class="form-control">
                <div class="row">
                    <div class="col-md-5 pr-1">
                        <div class="form-group">
                            <label>University</label>
                            <input type="text" disabled readonly class="form-control" placeholder="Company" value="{{$university->UniName}}">
                        </div>
                    </div>
                    <div class="col-md-3 px-1">
                        <div class="form-group">
                            <label>Username</label>
                                <input disabled readonly type="text" class="form-control" placeholder="Username" value="{{$subDetails->Username}}">
                            </div>
                        </div>
                    <div class="col-md-4 pl-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contact Number</label>
                            <input type="text" name="contNumber" class="form-control" value="{{$subDetails->ContactNumber}}" placeholder="Contact Number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Extension Head Full Name</label>
                            <input type="text" disabled class="form-control" placeholder="Company" value="{{$university->ExtensionHeadName}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Account Password</label>
                            <input id="pass1" type="password" class="form-control" name="password" placeholder="Company" value="{{$subDetails->Password}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Re-type Password</label>
                            <input id="pass2" type="password" class="form-control" placeholder="Re-type Password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Home Address" value="{{$subDetails->Address}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email Address</label>
                            <textarea rows="4" name="emailAd" cols="80" class="form-control" placeholder="Here can be your description" value="Mike">{{$subDetails->EmailAddress}}</textarea>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="editSubscriberDetails()" class="btn btn-info btn-fill pull-right">Update Account</button>
                <div class="clearfix"></div>
            </form>
<script>
    
    function editSubscriberDetails(){
        if(document.getElementById('pass1').value === document.getElementById('pass2').value){
            $.ajax({
                url: "{{ url('/editProfile') }}",
                type: "post", 
                data: $("#editSubDetailsForm").serialize(),
                success: function(response) {
                    alert("successfully edited profile");
                    location.reload();
                },
                error: function(xhr) {
                    alert("Data: error");
                }
            });
        }else{
            alert('Passwords must match!');
        }
        
    }
    
    </script>
<!--
    <input type="hidden" value="{{$subDetails->SubscriberId}}" name="id" class="form-control">
 Contact Number: <input type="text" name="contNumber" value="{{$subDetails->ContactNumber}}" class="form-control"><br>
 E-mail Address: <input type="text" name="emailAd" value="{{$subDetails->EmailAddress}}" class="form-control"><br>
 Address: <input type="text" name="address" value="{{$subDetails->Address}}" class="form-control"><br>
 
 <input type="submit" value="SUBMIT" class="btn btn-success">
</form>
-->