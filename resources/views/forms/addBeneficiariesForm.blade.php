
<div class="modal fade" id="addNewBeneficiariesModal">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header">
                ADD BENEFICIARIES TO ACTIVITY
                <span onclick="$('#addNewBeneficiariesModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                    

            <form method="get" onsubmit="return false;" id="addNewBeneficiariesForm">
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


    <button style="margin-left:40%;" type="submit" class="blue-button" id="add-new-beneficiaries-button" onclick="this.disabled='true';addNewBeneficiaries();">SUBMIT</button>
    </form>




            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>


<script>
    function addNewBeneficiaries(){
        $.ajax({
            url: "{{url('addBeneficiaries')}}",
            type: "get", 
            data: $("#addNewBeneficiariesForm").serialize(),
            success: function(response) {
                if(response === "None Selected"){
                    swal(response,"","error").then(()=>{
                        $('#add-new-beneficiaries-button').attr("disabled",false);
                    });
                }else{     
                    swal(response,"","success").then(()=>{
                        location.reload(true);
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr);
                alert("Something went wrong");
            }
        });
    }
</script>