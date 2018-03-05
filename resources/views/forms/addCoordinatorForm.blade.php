<div class="modal fade" id="addCoordinator" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--Add New Coordinator-->
                Select Program
                <span onclick="$('#addCoordinator').modal('hide');" class="close-span">&times;</span>
            
            </div>
            <div class="modal-body" style="">
                <form id="add-coordinator-form" onsubmit="return false;" method="get">
                    <!--
                    <select name="accountId" id="" class="form-control">
                        @foreach($uniUsers as $uniUser)
                            <?php
                                $flag=0;
                                $program="";
                            ?>
                            @foreach($coordinators as $coordinator)
                                @if($coordinator->AccountId === $uniUser->AccountId && $coordinator->isActive === 1)
                                    <?php
                                        $flag = 1;
                                        $program=$coordinator->ProgramName;    
                                    ?>
                                @endif
                            @endforeach
                            <?php
                                if($flag === 0){
                                    ?>
                                        <option value="{{$uniUser->AccountId}}">{{$uniUser->Name}} {{$uniUser->LastName}}</option>
                                    
                                    <?php
                                }else{
                                    ?>
                                        <option value="{{$uniUser->AccountId}}" disabled>{{$uniUser->Name}} {{$uniUser->LastName}} (<?php echo $program;?>)</option>
                                
                                    <?php
                                }
                            ?>
                        @endforeach
                    </select>
                            
                    <select name="programId" class="form-control">
                        @foreach($programs as $program)
                            <option value="{{$program->ProgramId}}">
                                {{$program->ProgramName}}
                            </option>
                        @endforeach  
                    </select>
                    -->
                    <div class="row">
                        <input type="hidden" name="accountId" id="assign-new-coordinator" type="text" readonly>
                    
                        @foreach($programs as $program)
                        
                            <div class="col-sm-10" style="margin-top:30px;">
                                <img src="img/logos/programs/{{$program->Logo}}" alt="program" style="width:40px;height:40px;">
                                {{$program->ProgramName}}
                            </div>
                            <div class="col-sm-2" style="margin-top:30px;">
                                <input type="radio" name="programId" value="{{$program->ProgramId}}" checked>
                            </div>
                        @endforeach
                   
                    </div>
                    
                    <button id="add-coordinator-button" type="button" class="blue-button" style="margin-left:45%;" onclick="this.disabled='true';addCoordinator()">SUBMIT</button>
                </form>
            </div>                
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
    function addCoordinator(){
       // $('#add-coordinator-button').prop('disabled',true);
        $.ajax({
		url: "{{ url('/addCoordinator')}}",
		type: "get", 
		data: $("#add-coordinator-form").serialize(),
        success: function(response) {
            if(response === "Successfully added a new coordinator" || response ==="Successfully added previous coordinator to another program"){
                swal(response,"","success").then(()=>{
                    window.location.href="{{url('manageUserAccounts')}}#btn-click-coo"
                    location.reload();
                });

            }else{
                //alert(response);
                swal(response,"","error").then(()=>{
                    $('#add-coordinator-button').attr('disabled',false);
                });
            }
		},
		error: function(xhr) {
			alert("Something went wrong!");
		}
	});
    }
</script>

