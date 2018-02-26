<h3>Pending Volunteer requests</h3>   
<form id="approveVolunteersForm" onsubmit="if(confirm('Are you sure you want to approve volunteers?')){return true}else{return false;}">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Type</th>
                        <th><input type="checkbox"></th>
                    </tr>
                        @foreach($activity->Volunteers as $volunteer)
                    
                            @if($volunteer->VolunteerStatus===0)
                            <tr>
                                <td>
                                    <a>{{$volunteer->LastName}}, {{$volunteer->Name}}</a>
                                </td>
                                <td>{{$volunteer->Address}}</td>
                                <td>
                                    {{$volunteer->Birthday}}
                                </td>
                                <td>
                                    {{$volunteer->Gender}}
                                </td>
                                <td>
                                    {{$volunteer->Type}}
                                </td>
                                <td><input type="checkbox" name="volIds[]" value="{{$volunteer->VolunteerId}}"></td>
                            </tr>
                            @endif
                    @endforeach
                </table>
                
        <button type="button" onclick="approveVolunteers()">Approve</button> 
        <button type="button" onclick="rejectVolunteers()">Reject</button>   
            </form>