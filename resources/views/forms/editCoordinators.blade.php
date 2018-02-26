<div style="font-family:Arial;">
    <h3>ASSIGN NEW COORDINATORS</h3><br>
    <input class="form-control" placeholder="type in name of coordinator" type="text" onkeyup="filterUserByName()" id="newCoordinatorName">
@foreach($accounts as $account)
    <div style="" class="user" id="{{$account->AccountId}}"  onclick="document.getElementById('accountId').value={{$account->AccountId}}">
        <input type="radio" name="same"> {{$account->LastName}}, {{$account->Name}}
    </div>
@endforeach

<form action="{{url('/addCoordinator')}}" method="get">  
    <input type="hidden" name="programId" value="{{$uniId}}" readonly>
    <input type="hidden" name="accountId" id="accountId"><br>
    <input type="submit" class="btn btn-success" value="SUBMIT">
</form>

<h3>ACTIVE COORDINATORS</h3><br>


@foreach($coordinators as $coordinator)
    @if($coordinator->isActive===1)
    
    <button class="btn btn-danger" onclick="deleteCoordinator({{$coordinator->CoordinatorId}})">Delete</button>
    <button class="btn btn-warning" onclick="unassignCoordinator({{$coordinator->CoordinatorId}})">Unassign</button>
    <a>{{$coordinator->Name}} {{$coordinator->LastName}}</a>
    <br>
    @endif
@endforeach
    <h3>FORMER COORDINATORS </h3><br>
@foreach($coordinators as $coordinator)
    @if($coordinator->isActive===0)
    <button class="btn btn-danger" onclick="deleteCoordinator({{$coordinator->CoordinatorId}})">Delete</button>
    <button class="btn btn-warning" onclick="reassignCoordinator({{$coordinator->CoordinatorId}})">Reassign</button>
    <a>{{$coordinator->Name}} {{$coordinator->LastName}}</a>
    <br>
    @endif
@endforeach
    
</div>
<script>
    function filterUserByName(){
       var users=document.getElementsByClassName('user');
        
        for(var i=0;i<users.length;i++){
            document.getElementsByClassName('user')[i].style.display="none";
            if(users[i].innerHTML.toUpperCase().indexOf(document.getElementById('newCoordinatorName').value.toUpperCase())>-1){
                document.getElementsByClassName('user')[i].style.display="block";
           
            }
        }
        
    }
    function deleteCoordinator(id){
        if(confirm("Are you sure you want to delete Coordinator?")){
            window.location.href="{{url('/deleteCoordinator')}}?id="+id;
        }
    }
    function unassignCoordinator(id){
        
        if(confirm("Are you sure you want to delete Coordinator?")){
            window.location.href="{{url('/unassignCoordinator')}}?id="+id;
        }
    }
    
    function reassignCoordinator(id){
        if(confirm("Are you sure you want to Reassign Coordinator?")){
            window.location.href="{{url('/reassignCoordinator')}}?id="+id;
        }
    }
</script>