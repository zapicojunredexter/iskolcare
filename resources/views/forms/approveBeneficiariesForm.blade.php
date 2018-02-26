<h3>BENEFICIARIES</h3>
<form method="get" action="{{url('addApprovedBeneficiary')}}">
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Birthday</th>
                                    <th>Gender</th>
                                    <th>Type</th>
                                    <th><input type="checkbox"></th>
                                </tr>
                                @foreach($activity->Beneficiaries as $beneficiary)
                                @if($beneficiary->BenStatus===0)
                                    <tr>
                                        <td><a>{{$beneficiary->Name}}</a></td>
                                        <td>{{$beneficiary->Address}}</td>
                                        <td>
                                    {{$beneficiary->Birthday}}
                                </td>
                                        <td>
                                    {{$beneficiary->Gender}}
                                </td>
                                <td>
                                    {{$beneficiary->Type}}
                                </td>
                                <td><input type="checkbox" name="benIds[]" value="{{$beneficiary->BeneficiaryId}}"></td>
                                    </tr>
                                @endif
                                @endforeach
                            </table>
    <input type="submit" value="Approve">
</form>