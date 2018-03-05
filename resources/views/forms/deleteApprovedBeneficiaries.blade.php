<form action="{{url('deleteBeneficiary')}}" id="deleteApprovedBeneficiariesForm" method="get">
    <table class="table table-striped" style="border:solid silver 1px;">
        <tr style="background: #1b593e;color: white;">
            <th>Name</th>
            <th>University</th>
            <th>Address</th>
            <th>Type</th>
            <th><input type="checkbox"></th>
        </tr>
    @foreach($activity->Beneficiaries as $beneficiary)
    @if($beneficiary->Status===1)
        <tr>
            <td>
                <a href="{{url('viewProfile')}}?accid={{$beneficiary->AccountId}}">{{$beneficiary->Name}}</a></td>
            <td>{{$beneficiary->UniName}}</td>
            <td>{{$beneficiary->Address}}</td>
            <td>{{$beneficiary->Type}}</td>
            <td><input type="checkbox" name="benIds[]" value="{{$beneficiary->BeneficiaryId}}"></td>
        </tr>
    @endif
    @endforeach
    </table>
    <a href="#">
        <img data-toggle="tooltip" title="Delete Approved Beneficiaries" src="default-img/trash.png" alt="delete" style="height:30px;width:30px;" onclick="deleteApprovedBeneficiaries();">
    </a>
</form>
<script>
    
function deleteApprovedBeneficiaries(){

    if(confirm('Are you sure you want to delete beneficiareis?')){
     $.ajax({
		url: "{{url('deleteBeneficiary')}}",
		type: "get", 
		data: $("#deleteApprovedBeneficiariesForm").serialize(),
        success: function(response) {
		  alert("successfully deleted beneficiaries");
          location.reload();
		},
		error: function(xhr) {
			alert("Data: error");
		}
	});
    }
}
</script>