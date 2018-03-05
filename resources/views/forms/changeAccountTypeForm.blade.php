
    
    <div class="modal fade" id="change-account-type-modal" role="dialog">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    CHANGE ACCOUNT TYPE
                <span onclick="$('#change-account-type-modal').modal('hide');" class="close-span">&times;</span>
                </div>
                <div class="modal-body" style="">
                    <form id="changeAccountTypeForm">
                        <input type="hidden" name="accountId" id="change-accoun-type-id" readonly>

                        <select name="accountType" id="" class="form-control">
                            <option value="Volunteer - Student">Volunteer - Student</option>
                            <option value="Volunteer - Faculty">Volunteer - Faculty</option>
                            <option value="Volunteer - External">Volunteer - External</option>
                            <option value="Beneficiary - Member">Beneficiary - Member</option>
                            <option value="Beneficiary - Leader">Beneficiary - Leader</option>
                        </select>
                        <br>
                        <button type="button" onclick="changeAccountType();" class="blue-button" style="margin-left:40%">SUBMIT</button>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
         
                    
                    
                    
                    
                    
                
    
    
          <script>
              function changeAccountType(){
                     $.ajax({
                        url: "{{url('changeAccountType')}}",
                        data: $("#changeAccountTypeForm").serialize(),
                        type: "get", 
                        success: function(response) {
                          //alert("Successfully added new evaluation form");
                          swal("Successfully Changed Account Type","","success").then(()=>{location.reload();});
                        },
                        error: function(xhr) {
                            alert("Something went wrong!");
                        }
                    });
                  }
        
          </script>