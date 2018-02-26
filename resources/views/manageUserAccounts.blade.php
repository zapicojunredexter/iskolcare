<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Manage User Accounts</title>
</head>

<body>
    @if(Session::get('type') === "Director" || Session::get('type') === "Coordinator")
    <!--
        include('forms.editRegUserProfileForm')
    -->
        @include('forms.addCoordinatorForm')
        @include('forms.addRegUserProfileForm')
        @include('forms.changeAccountTypeForm')
    @endif

    <div class="wrapper" style="background-color:#e6eaeb;">

        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @else
            @include('includes.regUserSidebar')
        @endif
        <div class="main-panel">
            <?php
                $label="User Accounts";
            ?>
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="" onkeyup="filterCoordinators(this.value)" class="serch" placeholder="Search Coordinators" id="search-coo">
                            <input type="text" name="" onkeyup="filterBeneficiaries(this.value)" class="serch" placeholder="Search Beneficiaries" style="display:none;" id="search-ben">
                            <input type="text" name="" onkeyup="filterVolunteers(this.value)" class="serch" placeholder="Search Volunteers" style="display:none;" id="search-vol">
                            <input type="text" name="" class="serch" placeholder="Search My Volunteers" style="display:none;" id="search-pro">
                            
                        </div>
                        <br><br><br>
                        <script>
                            function filterCoordinators(keyword){
                                var table = $('.coordinator-table-tr');
                                for(var i=0;i<table.length;i++){
                                    if(table[i].innerText.toUpperCase().indexOf(keyword.toUpperCase())>-1){
                                        $('#coordinator-table-tr-'+i).show();
                                        
                                    }else{
                                        $('#coordinator-table-tr-'+i).hide();
                                    }
                                }
                            }
                            function filterBeneficiaries(keyword){
                                var table = $('.beneficiary-table-tr');
                                for(var i=0;i<table.length;i++){
                                    if(table[i].innerText.toUpperCase().indexOf(keyword.toUpperCase())>-1){
                                        $('#beneficiary-table-tr-'+i).show();
                                        
                                    }else{
                                        $('#beneficiary-table-tr-'+i).hide();
                                    }
                                }
                            }
                            function filterVolunteers(keyword){
                                var table = $('.volunteer-table-tr');
                                for(var i=0;i<table.length;i++){
                                    if(table[i].innerText.toUpperCase().indexOf(keyword.toUpperCase())>-1){
                                        $('#volunteer-table-tr-'+i).show();
                                        
                                    }else{
                                        $('#volunteer-table-tr-'+i).hide();
                                    }
                                }
                            }
                        </script>
                        <!--start sa adding and filtering part-->
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-9">
                                    <a id="btn-click-coo" onclick="onChangeOption('coo')" href="#btn-click-coo" class="round-blue-button">
                                        COORDINATORS
                                    </a>
                                    <a id="btn-click-ben" onclick="onChangeOption('ben')" href="#btn-click-ben" class="round-blue-button-inactive">
                                        BENEFICIARIES
                                    </a>
                                    <a id="btn-click-vol" onclick="onChangeOption('vol')" href="#btn-click-vol" class="round-blue-button-inactive">
                                        VOLUNTEERS
                                    </a>
                                    @if(Session::get('type') === "Coordinator")
                                    <a id="btn-click-pro" onclick="onChangeOption('pro')" href="#btn-click-pro" class="round-blue-button-inactive">
                                        MY VOLUNTEERS
                                    </a>
                                    @endif
                                </div>
                                <div class="col-sm-3">       
                                    <button style="float:right;" class="blue-button" onclick="$('#addRegUserModal').modal('show');">
                                        + Add Account
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            function onChangeOption(value){
                                $('#all').css('display','none');
                                var tabs = ['all','coo','vol','ben','pro'];
                                tabs.forEach((tab) => {
                                    if(tab === value){
                                        $('#btn-click-'+value).attr('class','round-blue-button');
                                        $('#'+value).css('display','block');
                                        $('#search-'+value).css('display','block');
                                    }else{
                                        $('#btn-click-'+tab).attr('class','round-blue-button-inactive');
                                        $('#'+tab).css('display','none');
                                        $('#search-'+tab).css('display','none');
                                    }
                                });
                            }
                        </script>
                        <!--end sa adding and filtering part-->

                        <!-- start sa div for all accounts-->
                        <div class="col-sm-12" id="all" style="display:none;">
                        <table class="table table-striped">
                            <tr style="background: #1b593e;color: white;">
                                <th>FULL NAME</th>
                                <th>CONTACT</th>
                                <th>EMAIL</th>
                                <th>BIRTHDATE</th>
                                <th>TYPE</th>
                                <th></th>
                            </tr>
                            @foreach($uniUsers as $uniUser)
                            <tr>
                                <td><a href="{{url('viewProfile')}}?accid={{$uniUser->AccountId}}">{{$uniUser->LastName}}, {{$uniUser->Name}}</a></td>
                                <td>{{$uniUser->ContactNumber}}</td>
                                <td>{{$uniUser->EmailAddress}}</td>
                                <td>
                                        <!--
                                        {$uniUser->Birthday}
                                        -->
                                        {{(date('Y')-date('Y',strtotime($uniUser->Birthday)))}}</td>
                                <td>{{$uniUser->AccountType}}</td>
                                <td>
                                    <img src="default-img/trash.png" style="width:25px;" alt="">
                                </td>
                                        
                                <td></td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                        <!-- end sa div for all accounts-->
                        <!-- start sa div for volunteer accounts-->
                        <div class="col-sm-12" id="vol" style="display:none">
                        <table class="table table-striped">
                            <tr style="background: #1b593e;color: white;">
                                <th>FULL NAME</th>
                                <th>CONTACT</th>
                                <th>EMAIL</th>
                                <th>BIRTHDATE</th>
                                <th>TYPE</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php $i=0;?>
                            @foreach($uniUsers as $uniUser)
                                @if($uniUser->AccountType === 'Volunteer - Student' || $uniUser->AccountType === 'Volunteer - Faculty' || $uniUser->AccountType === 'Volunteer - External')
                                    <tr class="volunteer-table-tr" id="volunteer-table-tr-<?php echo $i++;?>">
                                        <td><a href="{{url('viewProfile')}}?accid={{$uniUser->AccountId}}">{{$uniUser->LastName}}, {{$uniUser->Name}}</a></td>
                                        <td>{{$uniUser->ContactNumber}}</td>
                                        <td>{{$uniUser->EmailAddress}}</td>
                                        <td>
                                        <!--
                                        {$uniUser->Birthday}
                                        -->
                                        {{(date('Y')-date('Y',strtotime($uniUser->Birthday)))}}
                                        </td>
                                        <td>{{$uniUser->AccountType}}</td>
                                        @if(Session::get('type')==="Director")
                                        <td>
                                            <img onclick="deleteAccount({{$uniUser->AccountId}})" data-toggle="tooltip" title="Delete this Account" src="default-img/trash.png" style="width:25px;" alt="">
                                        </td>
                                        @endif
                                        @if(Session::get('type')==="Director" && $uniUser->AccountType === "Volunteer - Faculty")
                                            <td>
                                                <img src="default-img/edit.png" data-toggle="tooltip" title="Change Account Type" onclick="$('#change-accoun-type-id').attr('value',{{$uniUser->AccountId}});$('#change-account-type-modal').modal('show')" alt="assign" style="width:25px;">
                                            </td>
                                            <td>
                                                <img src="default-img/assign-coordinator.png" data-toggle="tooltip" title="Assign as Coordinator" onclick="$('#assign-new-coordinator').attr('value',{{$uniUser->AccountId}});$('#addCoordinator').modal('show')" alt="assign" style="width:25px;">
                                            </td>
                                        @else
                                            <td>
                                                @if(Session::get('type')==="Director")
                                                <img src="default-img/edit.png" data-toggle="tooltip" title="Change Account Type" onclick="$('#change-accoun-type-id').attr('value',{{$uniUser->AccountId}});$('#change-account-type-modal').modal('show')" alt="assign" style="width:25px;">
                                                @endif
                                            </td>
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        </div>
                        <!-- end sa div for volunteer accounts-->
                        <!-- start sa div for beneficiary accounts-->
                        <div class="col-sm-12" id="ben" style="display:none">
                        <table class="table table-striped">
                            <tr style="background: #1b593e;color: white;">
                                <th>FULL NAME</th>
                                <th>CONTACT</th>
                                <th>EMAIL</th>
                                <th>BIRTHDATE</th>
                                <th>TYPE</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php $i=0;?>
                            @foreach($uniUsers as $uniUser)
                                @if($uniUser->AccountType === 'Beneficiary - Leader' || $uniUser->AccountType === 'Beneficiary - Member')
                                    <tr class="beneficiary-table-tr" id="beneficiary-table-tr-<?php echo $i++;?>">
                                        <td>
                                            <a href="{{url('viewProfile')}}?accid={{$uniUser->AccountId}}">{{$uniUser->LastName}}, {{$uniUser->Name}}</a>
                                        </td>
                                        <td>{{$uniUser->ContactNumber}}</td>
                                        <td>{{$uniUser->EmailAddress}}</td>
                                        <td>{{$uniUser->Birthday}}</td>
                                        <td>{{$uniUser->AccountType}}</td>
                                        @if(Session::get('type')==="Director")
                                        <td>
                                            <img onclick="deleteAccount({{$uniUser->AccountId}})" data-toggle="tooltip" title="Delete this Account" src="default-img/trash.png" style="width:25px;" alt="">
                                        </td>
                                        @endif
                                        <td>
                                            
                                            @if(Session::get('type')==="Director")
                                                <img src="default-img/edit.png" data-toggle="tooltip" title="Change Account Type" onclick="$('#change-accoun-type-id').attr('value',{{$uniUser->AccountId}});$('#change-account-type-modal').modal('show')" alt="assign" style="width:25px;">
                                            @endif
                                        </td>
                                    
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        </div>
                        <!-- end sa div for beneficiary accounts-->
                        <!-- start sa div for coordinator accounts-->
                        <div class="col-sm-12" id="coo">
                        <!--
                        <button onclick="$('#addCoordinator').modal('show');" style="background-color:#2196F3;padding:10px;cursor:pointer;border:solid black 0px;color:white;">
                            + Add New Coordinator
                        </button>
                        -->
                        <table class="table table-striped" id="coordinator-table">
                            <tr style="background: #1b593e;color: white;">
                                <th>FULL NAME</th>
                                <th>PROGRAM</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php $i = 0;?>
                            @foreach($coordinators as $coordinator)
                                    <tr class="coordinator-table-tr" id="coordinator-table-tr-<?php echo $i++;?>">
                                        <td><a href="{{url('viewProfile')}}?accid={{$uniUser->AccountId}}">{{$coordinator->LastName}}, {{$coordinator->Name}}</a></td>
                                        <td>
                                            <img src="img/logos/programs/{{$coordinator->Logo}}" style="width:30px;height:30px;" alt="">
                                            {{$coordinator->ProgramName}}
                                        </td>
                                        @if(Session::get('type')==="Director")
                                            @if($coordinator->isActive === 1)
                                                <td><a onclick="unassignCoordinator({{$coordinator->CoordinatorId}})">Unassign</a></td>
                                            @else
                                                <td><a onclick="reassignCoordinator({{$coordinator->CoordinatorId}})"> Reassign</a></td>
                                            @endif
                                            <td><a onclick="deleteCoordinator({{$coordinator->CoordinatorId}})">Delete</a></td>
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                            @endforeach
                        </table>
                        @if(Session::get('type')==="Director")
                            
                        <script>
                                function deleteCoordinator(coordId){
                                    if(confirm("are you sure you want to delete coordinator")){
                                        $.ajax({
                                            url: "{{url('deleteCoordinator')}}?id="+coordId,
                                            type: "get", 
                                            success: function(response) {
                                                alert(response);
                                                location.reload();
                                                
                                            },
                                            error: function(xhr) {
                                                alert("Something went wrong!");
                                            }
                                        });
                                    }   
                                }
                                function unassignCoordinator(coordId){
                                    if(confirm("are you sure you want to unassign coordinator")){
                                        $.ajax({
                                            url: "{{url('unassignCoordinator')}}?id="+coordId,
                                            type: "get", 
                                            success: function(response) {
                                                alert(response);
                                                //if(response === "UNASSIGNED coordinator successfully"){
                                                    location.reload();
                                                //}
                                            },
                                            error: function(xhr) {
                                                alert("Something went wrong!");
                                            }
                                        });
                                    }   
                                }
                                function reassignCoordinator(coordId){
                                    if(confirm("are you sure you want to reassign coordinator")){

                                        $.ajax({
                                            url: "{{url('reassignCoordinator')}}?id="+coordId,
                                            type: "get", 
                                            success: function(response) {
                                                alert(response);
                                                if(response === "reassigned coordinator successfully"){
                                                    location.reload();
                                                }
                                            },
                                            error: function(xhr) {
                                                alert("Something went wrong!");
                                            }
                                        });
                                    }
                                }
                        </script>
                        @endif
                        </div>
                        <!-- end sa div for coordinator accounts-->
                        
                        <!-- start sa div for program accounts-->
                        <div class="col-sm-12" id="pro" style="display:none;">
                        <table class="table table-striped">
                            <tr style="background: #1b593e;color: white;">
                                <th>Name</th>
                                <th>Activity Name</th>
                            </tr>
                            @foreach($myVolunteers as $myVolunteer)
                                    <tr>
                                        <td>
                                            <a href="{{url('viewProfile')}}?accid={{$myVolunteer->AccountId}}">
                                                {{$myVolunteer->LastName}}, {{$myVolunteer->Name}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$myVolunteer->ActivityCount}} Activities
                                        </td>
                                    </tr>
                            @endforeach
                        </table>
                        </div>
                        <!-- end sa div for program accounts-->
                        @if(Session::get('type')==="Director")
                        <script>
                            function deleteAccount(accId){

                                alert(accId);
                            }
                        </script>
                        @endif
                    </div>
                </div>
            </div>
			<!-- start sa footer-->
            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
			
			<!-- end sa footer-->
        </div>
    </div>
    @include('includes.scripts')
    
</body>


</html>