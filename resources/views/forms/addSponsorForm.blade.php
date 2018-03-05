<div class="modal fade" id="addSponsorModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                MANAGE ACTIVITY SPONSORS
                
                <span onclick="$('#addSponsorModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body">
            <form method="get" action="{{url('/addSponsor')}}">

            <div class="nav nav-tabs justify-content-start" role="tablist">
                <a class="nav-item nav-link active" href="#project-sponsors-tab" data-toggle="tab" style="color:black;padding:20px;text-align:center;" role="tab">Project Sponsor</a>
                <a class="nav-item nav-link" href="#add-project-sponsors-tab" data-toggle="tab" style="color:black;padding:20px;text-align:center;" role="tab">+ Add</a>
            </div>
            <div class="tab-content" style="background-color:white;padding:20px;">
                <div id="project-sponsors-tab" class="tab-pane fade show active" role="tabpanel">
                    <table class="table table-striped">
                        <tr>
                            <th>Sponsor Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th></th>
                        </tr>
                        @foreach($activity->Sponsors as $sponsor)
                        <tr>
                            <td>{{$sponsor->SponsorName}}</td>
                            <td>{{$sponsor->SponsorAddress}}</td>
                            <td>{{$sponsor->SponsorContactNo}}</td>
                            <td><a href="#" onclick="deleteActivitySponsor({{$sponsor->ActivitySponsorId}})"><img src="default-img/trash.png" style="width:30px;" alt=""></a></td>
                        </tr>
                        @endforeach

                        <script>
                            function deleteActivitySponsor(id){
                                if(confirm('Are you sure you want to delete sponsor?')){
                                    window.location.href="{{url('/deleteActivitySponsor')}}?actSponsId="+id;
                                }
                            }
                        </script>
                    </table>
                </div>
                <div id="add-project-sponsors-tab" class="tab-pane fade show" role="tabpanel">
                
                    <input type="hidden" readonly name="activityId" value="{{$activity->ActivityId}}">
                    <select class="form-control" onchange="onChangeSponsor(this.value)" name="sponsorId">
                        <option value="">-</option>
                        @foreach($activity->AllSponsors as $sponsor)
                            <option value="{{$sponsor->SponsorId}}">{{$sponsor->SponsorName}} / {{$sponsor->SponsorContactNo}}</option>
                        @endforeach
                    </select>
                    <div id="input-new-sponsor">
                        <h4>ADD NEW SPONSOR</h4>
                        Sponsor Name:
                        <input type="text" name="sponsorName" class="form-control">
                        Sponsor Address:
                        <input type="text" name="sponsorAddress" class="form-control">
                        
                        Sponsor Contact Number:
                        <input type="text" name="sponsorContactNumber" class="form-control">
                        
                    </div>
                    <br>
                    <button type="submit" class="blue-button" style="margin-left:40%;" onclick="this.disabled='true';this.form.submit();">SAVE</button>
                </div>
            </div>

            </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
<script>
    function changeTab(option){
        alert(option);
        if(option === "add"){
            $('#list-of-sponsors').css('display','none');
            $('#add-sponsor').css('display','block');
            $('#sponsor-modal-dialog').css('top','-100px');
            
        }else{
            $('#list-of-sponsors').css('display','block');
            $('#add-sponsor').css('display','none');
            $('#sponsor-modal-dialog').css('top','-50px');
        
        }
        
    }
    function onChangeSponsor(value){
        if(value){
            $('#input-new-sponsor').css('display','none');
            $('#sponsor-modal-dialog').css('top','-50px');
        }else{

            $('#input-new-sponsor').css('display','block');
            
            $('#sponsor-modal-dialog').css('top','-50px');
        }
    }
</script>

<!--

    

<form method="get" action="{{url('/addSponsor')}}">
<div class="modal fade" id="addSponsorModal" style="outline:none;top:0px;left:0px;" role="dialog">
    <div class="modal-dialog" id="sponsor-modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header" style="height:50px;padding:0px;margin-top:0px;">
                <h4 style="">MANAGE ACTIVITY SPONSORS</h4>
            </div>
            <div class="modal-body" style="">
            <div class="row">
                <div class="col-sm-6" onclick="changeTab('delete')">Delete</div>
                <div class="col-sm-6" onclick="changeTab('add')">Add</div>
            </div>
            <div id="list-of-sponsors">

                <table class="table">
                    <tr>
                                                <th>Sponsor Name</th>
                                                <th>Address</th>
                                                <th>Contact Number</th>
                                                <th></th>
                                            </tr>
                                            @foreach($activity->Sponsors as $sponsor)
                                            <tr>
                                                <td>{{$sponsor->SponsorName}}</td>
                                                <td>{{$sponsor->SponsorAddress}}</td>
                                                <td>{{$sponsor->SponsorContactNo}}</td>
                                                <td><a><button onclick="deleteActivitySponsor({{$sponsor->ActivitySponsorId}})" class="btn btn-danger">Delete</button></a></td>
                                            </tr>
                                            @endforeach
                                            
                                            <script>
                                                function deleteActivitySponsor(id){
                                                    if(confirm('Are you sure you want to delete sponsor?')){
                                                        window.location.href="{{url('/deleteActivitySponsor')}}?actSponsId="+id;
                                                    }
                                                }
                                            </script>
                                        </table>
                                



            </div>
            <div id="add-sponsor" style="display:none;">
                <input type="hidden" readonly name="activityId" value="{{$activity->ActivityId}}">
                <select class="form-control" onchange="onChangeSponsor(this.value)" name="sponsorId">
                    <option value="">-</option>
                    @foreach($activity->AllSponsors as $sponsor)
                        <option value="{{$sponsor->SponsorId}}">{{$sponsor->SponsorName}}</option>
                    @endforeach
                </select>
                <div id="input-new-sponsor">
                    <h4>ADD NEW SPONSOR</h4>
                    Sponsor Name:
                    <input type="text" name="sponsorName" class="form-control">
                    Sponsor Address:
                    <input type="text" name="sponsorAddress" class="form-control">
                    
                    Sponsor Contact Number:
                    <input type="text" name="sponsorContactNumber" class="form-control">
                    
                </div>
                <button type="submit" class="btn btn-primary btn-xl page-scroll" style="width: 150px; margin-top: 15px;">SAVE</button>
                     
            </div>

            </div>
            <div class="modal-footer">
			    &nbsp;
            </div>
        </div>
    </div>
</div> 
</form>
<script>
    function changeTab(option){
        alert(option);
        if(option === "add"){
            $('#list-of-sponsors').css('display','none');
            $('#add-sponsor').css('display','block');
            $('#sponsor-modal-dialog').css('top','-100px');
            
        }else{
            $('#list-of-sponsors').css('display','block');
            $('#add-sponsor').css('display','none');
            $('#sponsor-modal-dialog').css('top','-50px');
        
        }
        //$('#add-sponsor').toggle('slide');
        
    }
    function onChangeSponsor(value){
        if(value){
            $('#input-new-sponsor').css('display','none');
            $('#sponsor-modal-dialog').css('top','-50px');
        }else{

            $('#input-new-sponsor').css('display','block');
            
            $('#sponsor-modal-dialog').css('top','-50px');
        }
    }
</script>
-->