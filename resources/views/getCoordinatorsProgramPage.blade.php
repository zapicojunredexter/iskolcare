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
               
                @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$program->ProgramId))
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
      
      
    @include('includes.regUserHeader')
    
<div class="container-fluid" style="background-color:#e5e5e7;min-width:1200px;">
		
       
		<div class="row">
            
    @if($type==='Director')
        @include('includes.directorSidebar')    
    @elseif($type==='Coordinator')   
        @include('includes.coordinatorSidebar')    
    @elseif($type==='Registered User')
        @include('includes.reguserSidebar')
    @endif
            
            
            
			<div style="background: transparent; width: 80%; margin-left: 20%;">
		<div style="background: #29d159; height: 450px;">
       
				 <div style="padding-left: 10px; padding-right: 10px;">
				 <br>
				 <div style="height: 252px; margin: 10px; background-color: white; padding: 0;">
				 <img 
                    @if(Session::get('type')==='Director' && (Session::get('uniId')===$university->UniId))
                     onclick="displayModal('changeProgramLogoModal')" 
                     @endif
                     src="img/logos/programs/{{$program->Logo}}" style="float: left; width: 30%; height: 100%; cursor: pointer;">
				  <div class="row" style="margin-left:20px;float:left;">
                     <br>
                     
                     
                      <small style="font-size: 40px; margin-top: 50px;"><a href="{{url('/getUniversityProfile')}}?id={{$university->UniId}}">{{$university->UniName}}</a>
                            
                        </small>
                     
                      <br>
                     @if($type==='Director'&&(Session::get('uniId')===$university->UniId))
                           
                            
                                <span onclick="displayModal('editProgramModal')" class="glyphicon glyphicon-pencil">
                                </span>
                            
                                <a href="{{url('/deleteProgram')}}?id={{$program->ProgramId}}">
                                    <span class="glyphicon glyphicon-minus">
                                    </span>
                                </a>
                            @endif  
                        <br>
                        <small style="font-size: 17px;">Program Name  :  {{$program->ProgramName}}</small><br>
				        <small style="font-size: 17px;">Program Description  :  {{$program->ProgramDescription}}</small><br>
					    <small style="font-size: 17px;">Objective  :  {{$program->ProgramObjective}}</small>
							 
                    
				 </div>
				 </div>
				 
				 </div>
	
		<div class="wellcont">
				
		      <div class="well" style="margin: 20px; float: left; background-color: white;  width: 95.8%;">
		
		      <!--start of coordinators-->
                <div style="background-color:white;margin-top:10px;padding:20px;">
					<div style="margin-top:0px;">
                        @if($type==='Director'&&(Session::get('uniId')===$university->UniId))
                            <span onclick="displayModal('editDirectorsModal')" class="glyphicon glyphicon-pencil"></span>
                        @endif
                        <h3>ACTIVE COORDINATORS
                            
                        </h3>
						<ul>
                            @foreach($coordinators as $coordinator)
                                @if($coordinator->isActive===1)
                                    <li>{{$coordinator->Name}} {{$coordinator->LastName}}</li>
                                @endif
                            @endforeach
                        </ul>
                        
                        <h3>PREVIOUS COORDINATORS
                        </h3>
						<ul>
                            @foreach($coordinators as $coordinator)
                                @if($coordinator->isActive===0  )
                                    <li>{{$coordinator->Name}} {{$coordinator->LastName}}</li>
                                @endif
                            @endforeach
                        </ul>
					</div>
				</div>
                <!--end of coordinatros-->
                  <!--start of projects-->
                  <div style="padding:20px;">
                  <h3>PROJECTS
                        @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                        <span onclick="displayModal('addProjectModal')" class="glyphicon glyphicon-plus">   </span>
                        @endif
                    </h3><hr>
                  
                      
                      
                <div>
                      
                      CURRENT PROJECTS
                  
                  @foreach($program->Projects as $project)
                      @if($project->Status==='Approved')
                        <div class="row" style="
                                    margin-left:50px;
                                    margin-right:50px;
                                    padding:10px;
                                    border-radius:3px;
                                    border-color:grey;
                                    box-shadow: 3px 3px 1px silver;
                                    border-width:.5px;
                                    border-style:solid;margin-bottom:10px;">
                            <div class="col-sm-3">
                            <img 
                                 @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator'&&Session::get('programId')===$program->ProgramId))
                                 onclick="
                                    document.getElementById('projectId').value={{$project->ProjectId}}
                                    displayModal('changeProjectBannerModal')
                                "
                                 @endif
                                src="img/logos/programs/{{$project->Banner}}" style="width:100px;height:100px;">
                            </div>
                            <div class="col-sm-9">

                            <h3>{{$project->ProjectName}}
                                
                                
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
                                
                            </h3>
                                
                            </div>
                            <div class="col-sm-9">


                                ACTIVITIES:
                                @if(($type==='Director'&&$university->UniId===Session::get('uniId'))||($type==='Coordinator'&&$program->ProgramId===Session::get('programId')))
                                <span  onclick="
                        document.getElementById('activityProjectId').value={{$project->ProjectId}}
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
                            
                            
                        </div>
                      @endif
                    @endforeach
                  
                  </div>
                      
                      
                @if((Session::get('type')==='Director' && Session::get('uniId')===$university->UniId)||(Session::get('type')==='Coordinator' && Session::get('programId')===$program->ProgramId))
                      
                    <div>
                         PENDING PROJECTS
                  
                  @foreach($program->Projects as $project)
                      @if($project->Status!=='Approved')
                        <div class="row" style="
                                    margin-left:50px;
                                    margin-right:50px;
                                    padding:10px;
                                    border-radius:3px;
                                    border-color:grey;
                                    box-shadow: 3px 3px 1px silver;
                                    border-width:.5px;
                                    border-style:solid;margin-bottom:10px;">
                            <div class="col-sm-3">	
                            <img src="img/logos/{{$project->Banner}}" style="width:100px;height:100px;">
                            </div>
                            <div class="col-sm-9">


                            <h3>{{$project->ProjectName}}
                                
                                
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
                                
                            </h3>
                                
                            </div>
                            
                            
                            
                        </div>
                      @endif
                    @endforeach
                      
                      </div>
                      
                      @endif
                      
                      
                      
                      
                  </div>
                  
                  <!--end of projects-->
                  
			
              </div>
        </div>
	  </div>
    </div>
            
            
            
            
			
		</div>
       
            
            
            
            
            
            
            
            
		
		
		
	</div>

      

    @include('includes.scripts')
  </body>
</html>
