
    
    <div class="modal fade" id="change-account-type-modal" role="dialog">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    CHANGE ACCOUNT TYPE
                </div>
                <div class="modal-body" style="">
                    <input type="text" name="accountId" id="change-accoun-type-id" readonly>
    
                    Select Account Type
                    <select name="accountType" id="" class="form-control">
                        <option value="">Volunteer - Student</option>
                        <option value="">Volunteer - Faculty</option>
                        <option value="">Volunteer - External</option>
                        <option value="">Beneficiary - Member</option>
                        <option value="">Beneficiary - Leader</option>
                    </select>
                    <br>
                    <button type="button" class="blue-button" style="margin-left:40%">SUBMIT</button>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
         
                    
                    
                    
                    
                    
                
    
    
          <script>
              function changeAccountType(){
                     $.ajax({
                        url: "{{url('addEvaluationTool')}}",
                        data: $("#addEvaluationFormForm").serialize(),
                        type: "get", 
                        success: function(response) {
                          alert("Successfully added new evaluation form");
                          
                          location.reload();
                        },
                        error: function(xhr) {
                            alert("Something went wrong!");
                        }
                    });
                  }
        
          </script>