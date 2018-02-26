<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('includes.libs')
        <title>Title</title>
    </head>
    <body>
        @include('includes.scripts')
        <!--
        editActivity form
		<form method="GET" onSubmit="editActivity('{{ url('/editActivity') }}');return false;" id="editActivityForm">
	      $id=3;
		$activityName='asd';
		$activityDescription='asd';
		$activityVenue='asd';
		$targetAudience='asd';
		$status='asd';
        
		<input type="text" name="id">
		<input type="text" name="activityName">
		<input type="text" name="activityDescription">
		<input type="text" name="activityVenue">
		<input type="text" name="targetAudience">
		<input type="text" name="status">
		
		<input type="submit" value="ok">
	</form>	-->
        <!---
    qqqq
         addActivity form
		<form method="GET" onSubmit="addActivity('{{ url('/addActivity') }}');return false;" id="addActivityForm">
	      $activityName='qwe';
		$activityDescription='qwe';
		$activityVenue='qwe';
		$targetAudience='qwe';
		$projectId=1;
    
		<input type="text" name="activityName">
		<input type="text" name="activityDescription">
		<input type="text" name="activityVenue">
		<input type="text" name="targetAudience">
		<input type="text" name="projectId">
		
            <br>
        <input type="date" name="date[]"><input type="time" name="time[]">   <br> 
        <input type="date" name="date[]"><input type="time" name="time[]">   <br> 
        <input type="date" name="date[]"><input type="time" name="time[]">   <br> 
            
            
		<input type="submit" value="ok">
	</form>	-->    <!-- -->
        <!--
		 editProject form
		<form method="GET" onSubmit="editProject('{{ url('/editProject') }}');return false;" id="editProjectForm">
	       $id=2;
		$projectName='asd';
		$projectDescription='asd';
		$status='asd';
		$banner='asd';
            
    
		<input type="text" name="id">
		<input type="text" name="projectName">
		<input type="text" name="projectDescription">
		<input type="text" name="status">
		<input type="text" name="banner">
		
		<input type="submit" value="ok">
	</form>	
-->
        <!--
        add project form
		<form method="GET" onSubmit="addProject('{{ url('/addProject') }}');return false;" id="addProjectForm">
	
	$projectName='qwe';
		$projectDescription='qwe';
		$programId=1;
		$status='Pending for Approval';
		$banner='qwe';
            
	
		<input type="text" name="projectName">
		<input type="text" name="projectDescription">
		<input type="text" name="programId">
		<input type="text" name="banner">
		
		<input type="submit" value="ok">
	</form>	
        -->
        
		<!--
		edit program form
		<form method="GET" onSubmit="editProgram('{{ url('/editProgram') }}');return false;" id="editProgramForm">
	
	//program id	programName	programDescription	 programObjective		Logo
	
		<input type="text" name="id">
		<input type="text" name="programName">
		<input type="text" name="programDescription">
		<input type="text" name="programObjective">
		<input type="text" name="Logo">
		<input type="text" name="universityId">
		
		<input type="submit" value="ok">
	</form>	
	
		-->
		<!---
		adding project form
	<form method="GET" onSubmit="addProgram('{{ url('/addProgram') }}')" id="addProgramForm">
	//programName  programDescription 	programObjective	 Logo  universityId
	
		
		<input type="text" name="programName">
		<input type="text" name="programDescription">
		<input type="text" name="programObjective">
		<input type="text" name="Logo">
		<input type="text" name="universityId">
		
		<input type="submit" value="ok">
	</form>
-->
		<script>
		/*$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		*/
		
		function sendJson(){	 
			info = [];
			var sample={"haha":"zxccc","zxc":"asd"};
			sample=[{"haha":"1","zxc":"1"},{"haha":"2","zxc":"2"}];
			info[0] = 'hi';
			info[1] = 'hello';
			  $.ajax({
			  url: "{{ url('/dis') }}",
			  type: "POST", //send it through get method
			  data: JSON.stringify(sample),
			  processData:false,
			  contentType:"application/json;charset=UTF-8",
			  success: function(response) {
				//Do Something
				alert("Data: success");
			  },
			  error: function(xhr) {
				//Do Something to handle error
					alert("Data: error"+xhr);
			  }
			});
		}
		</script>
       
    </body>
</html>
