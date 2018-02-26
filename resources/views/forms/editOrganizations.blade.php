
@include('includes.libs')
<form method="get" action="{{url('addOrganization')}}">
    <input type="text" name="pos" class="form-control" placeholder="Position"><br>
    <input type="text" name="org" class="form-control" placeholder="Name of organization"><br>
    <input type="submit" value="SUBMIT" class="btn btn-success">
</form>

<h3>My Organizations</h3>
<ul>
@foreach($organizations as $organization)
    <li>
        <a href="{{url('deleteOrganization')}}?id={{$organization->OrgId}}"><button class="btn btn-danger">Delete this entry</button></a>
        {{$organization->Position}} at {{$organization->OrgName}}
    </li>
@endforeach
</ul>