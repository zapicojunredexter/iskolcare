
<form action="{{url('addBeneficiary')}}" method="get">
    <input type="hidden" name="programId" value="{{$activity->ActivityId}}" readonly>
    Participate as:
     <select name="type" class="form-control">
        <option value="Participant">Participant</option>
        <option value="Leader">Leader</option>
    </select>
<br>
    
    <input type="submit" value="SUBMIT" class="btn btn-success">
    
</form>