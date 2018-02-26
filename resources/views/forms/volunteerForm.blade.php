<form action="{{url('/addVolunteer')}}" method="get">
    <input type="hidden" name="programId" value="{{$activity->ActivityId}}" readonly>
    Volunteer as: 
    <select name="type" class="form-control">
        <option value="Student">Student</option>
        <option value="Faculty">Faculty</option>
    </select><br>
    <input type="submit" value="SUBMIT" class="btn btn-success">
    
</form>