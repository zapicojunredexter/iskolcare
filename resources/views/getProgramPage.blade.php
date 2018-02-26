<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard Template for Bootstrap</title>
        @include('includes.libs')
  </head>

  <body style="background-color:#e5e5e7">
      
      
    <div id="changeProjectBannerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('changeProjectBannerModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
               
                @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator'&& Session::get('programId')===$program->ProgramId))
                    @include('forms.changeProjectBannerForm')
                @endif
               
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>
      
    <div id="changeProgramLogoModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('changeProgramLogoModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
               
                @if(Session::get('type')==='Director' && (Session::get('uniId')===$university->UniId))
                    @include('forms.changeProgramLogo')
                @endif
               
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>
      
    <div id="editDirectorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editDirectorsModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
               
               <iframe src="editCoordinator?id={{$program->ProgramId}}" style="border:none;width:100%;height:500px;">
                </iframe>
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>
      
    <div id="addActivityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addActivityModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                @include('forms.addActivityForm')
               
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
                
            </div>
        </div>
    </div>
    <div id="editProjectsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editProjectsModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                @include('forms.editProjectForm')
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>
      
      
      
    <div id="editProgramModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editProgramModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                edit program
                @include('forms.editProgramForm')   
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>  
      

    <div id="addProjectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('addProjectModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                @include('forms.addProjectForm')
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>  
      
      
 

		
       
	
			<div>
                <!--start if university details--->
        <div style="border: 2px solid rgba(0,0,0,0.2); border-radius: 5px; padding: 0; margin-top: 0;padding:20px;">
                <img 
                    @if(Session::get('type')==='Director' && (Session::get('uniId')===$university->UniId))
                     onclick="displayModal('changeProgramLogoModal')" 
                     @endif
                     src="img/logos/programs/{{$program->Logo}}"  style="float: left; width: 300px; height: 300px; border-radius: 50%; padding: 10px; margin-left: 10px;">
                
				 <br>
                     @if($type==='Director'&&(Session::get('uniId')===$university->UniId))
                           
                            
                                <span onclick="displayModal('editProgramModal')" class="glyphicon glyphicon-pencil">
                                </span>
                            
                                <a href="{{url('/deleteProgram')}}?id={{$program->ProgramId}}">
                                    <span class="glyphicon glyphicon-minus">
                                    </span>
                                </a>
                        @endif 
                     <h2>{{$program->ProgramName}}</h2>
				
				 
				 <p style="font-size: 12px; color: black; margin-left: 20px; margin-right: 20px; text-align: justify;">
				 <small style="margin-left: 50px;"></small>
                     <br>
                     <h4 style="float:left;">{{$program->ProgramDescription}}</h4>
                     <br><br>   
            <h4 style="float:left;">{{$program->ProgramObjective}}</h4>
                     
                     <div class="row">
                         <div class="col-sm-12">
                        @if($type==='Director'&&(Session::get('uniId')===$university->UniId))
                            <span onclick="displayModal('editDirectorsModal')" class="glyphicon glyphicon-pencil"></span>
                        @endif
                         </div>
                         <div class="col-sm-6">
                            <h4>ACTIVE COORDINATORS

                            </h4>
                            <ul>
                                @foreach($coordinators as $coordinator)
                                    @if($coordinator->isActive===1)
                                        <li>{{$coordinator->Name}} {{$coordinator->LastName}}</li>
                                    @endif
                                @endforeach
                            </ul>
                         </div>
                         <div class="col-sm-6">
                            <h4>PREVIOUS COORDINATORS
                            </h4>
                            <ul>
                                @foreach($coordinators as $coordinator)
                                    @if($coordinator->isActive===0  )
                                        <li>{{$coordinator->Name}} {{$coordinator->LastName}}</li>
                                    @endif
                                @endforeach
                            </ul>
                         </div>
					</div>
				
                    
                    </div>
                    <!--start of programs--->
                    @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                        <span onclick="displayModal('addProjectModal')" class="glyphicon glyphicon-plus">   </span>
                        @endif
                <h3 style="text-align: left;">ACTIVE PROJECTS</h3>
             
                  
                  @foreach($program->Projects as $project)
                      @if($project->Status==='Approved')
				 <div style="border: 2px solid rgba(0,0,0,0.2); border-radius: 5px; padding: 0; margin-top: 0; width: 100%; height: 80px;">
				 <div style="height: 100%; background-color: white; padding: 10px; margin-top: 0;">
				 <img 
                      @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$program->ProgramId))
                                 onclick="
                                    document.getElementById('projectId').value={{$project->ProjectId}}
                                    displayModal('changeProjectBannerModal')
                                "
                                 @endif
                      
                      src="img/logos/programs/{{$project->Banner}}"  
                      style="float: left; width: 15%; height: 100%; margin-left: 10px;"
                 >
				 <div style="margin-left:solid black 10px;width: 10%; float: right; height: 100%; cursor:pointer;" onclick="$('#{{$project->ProjectId}}-activities').slideToggle(500)">
				 <img src="default-img/down.png" width="50px;" height="100%" style="padding-bottom: 11px; margin-right: 10px; margin-left: 10px; float: right; margin-top: 4px;">
				 </div>
				 <div id="ye" style="margin-left:30px;">
				 <br>
				 <small id="smal" style="padding-left:30px;font-size: 18px;">{{$project->ProjectName}}
                     
                     
                     @if(($type==='Director' && $university->UniId===Session::get('uniId'))||($type==='Coordinator' && $program->ProgramId===Session::get('programId')))
                                
                <span
                       onclick="
                        document.getElementById('id').value= '{{$project->ProjectId}}';
                        document.getElementById('projectName').value='{{$project->ProjectName}}';
                        document.getElementById('projectDescription').value='{{$project->ProjectDescription}}';
                                
                            @if(Session::get('type')==='Director')
                         document.getElementById('projectStatus').innerHTML='{{$project->Status}}';
                            @endif
                        
                        document.getElementById('banner').value= '{{$project->Banner}}';
                        displayModal('editProjectsModal')"
                      class="glyphicon glyphicon-pencil"></span>  
                 @endif
				 <br>
				 </small>
				 </div>
				 
                
                     
                     
                     
                     
				 </div>
				 
				 </div>
                    <div id="{{$project->ProjectId}}-activities" style="display:none;background-color: #f1f1f1; width: 100%; border-radius: 5px;">
                    
                        
                        
                        
                        
                        <p><b>PREVIOS/UPCOMING ACTIVITIES :@if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                                <span  onclick="
                        document.getElementById('activityProjectId').value={{$project->ProjectId}};
                        displayModal('addActivityModal');
                        "class="glyphicon glyphicon-plus"></span>
                                @endif</b></p>
				<div class='linkcontainer'>
					<a style="color: blue;">
					           <ul>
                                    @foreach($project->Activities as $activity)
                                        @if($activity->ActivityStatus==='Approved')
                                    <li><h5><a style="color: blue;" href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></h5></li>
                                        @endif
                                    @endforeach
                                </ul>
                        
                        
                        
                                
                                @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                        <p style="color:black;"><b>NOT YET APPROVED</b></p>
                                    
                                    <ul>
                                        @foreach($project->Activities as $activity)
                                            @if($activity->ActivityStatus!=='Approved')
                                        <li><h5><a style="color: blue;" href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></h5></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                        
                        
                        
                        
                        
					</a>
				</div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <!--
                        
                            <div style="padding:10px;">


                                ACTIVITIES:
                                @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                                <span  onclick="
                        document.getElementById('activityProjectId').value={{$project->ProjectId}};
                        displayModal('addActivityModal');
                        "class="glyphicon glyphicon-plus"></span>
                                @endif
                                <br>
                                APPROVED
                                <ul>
                                    @foreach($project->Activities as $activity)
                                        @if($activity->ActivityStatus==='Approved')
                                        <li><a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                                    NOT YET APPROVED
                                    <ul>
                                        @foreach($project->Activities as $activity)
                                            @if($activity->ActivityStatus!=='Approved')
                                            <li><a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}">{{$activity->ActivityName}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        -->
                        
                        
                        
                        
                </div>
                        @endif
                    @endforeach
                    
                    
                    
                    
                    
                    @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                    <div>
                    <h3 style="text-align: left;">PENDING</h3>
             
                  
                  @foreach($program->Projects as $project)
                      @if($project->Status!=='Approved')
				 <div style="border: 2px solid rgba(0,0,0,0.2); border-radius: 5px; padding: 0; margin-top: 0; width: 100%; height: 80px;">
				 <div style="height: 100%; background-color: white; padding: 10px; margin-top: 0;">
				 <img 
                      @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$program->ProgramId))
                                 onclick="
                                    document.getElementById('projectId').value={{$project->ProjectId}}
                                    displayModal('changeProjectBannerModal')
                                "
                                 @endif
                      
                      src="img/logos/programs/{{$project->Banner}}"  
                      style="float: left; width: 15%; height: 100%; margin-left: 10px;"
                 >
				 <div style="width: 10%; float: right; height: 100%; cursor:pointer;">
				 <!--<img src="default-img/down.png" width="50px;" height="100%" style="padding-bottom: 11px; margin-right: 10px; margin-left: 10px; float: right; margin-top: 4px;">-->
				 </div>
				 <div id="ye" style="margin-left:30px;">
				 <br>
				 <small id="smal" style="padding-left:30px;font-size: 18px;">{{$project->ProjectName}}
                     
                     
                     @if(($type==='Director' && $university->UniId===Session::get('uniId'))||($type==='Coordinator' && $program->ProgramId===Session::get('programId')))
                                
                <span
                       onclick="
                        document.getElementById('id').value= '{{$project->ProjectId}}';
                        document.getElementById('projectName').value='{{$project->ProjectName}}';
                        document.getElementById('projectDescription').value='{{$project->ProjectDescription}}';
                                
                            @if(Session::get('type')==='Director')
                         document.getElementById('projectStatus').innerHTML='{{$project->Status}}';
                            @endif
                        
                        document.getElementById('banner').value= '{{$project->Banner}}';
                        displayModal('editProjectsModal')"
                      class="glyphicon glyphicon-pencil"></span>  
                 @endif
				 <br>
				 </small>
				 </div>
				 
                     
                     
                     
                     
				 </div>
				 
				 </div>
                        @endif
                    @endforeach
                    </div>
                    @endif
                    
                    
                    
                    <!---end of projects-->
                    
                    
				 </div>

			
	
       
            
            
            
            
            
            
            
            
		
		
		


      

    @include('includes.scripts')
  </body>
</html>
