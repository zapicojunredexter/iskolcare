<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;

class SubscribersController extends Controller
{
    function validate(){
       if(session('type')==='Director'){
           return true;
       }else{
           return false;
       }
    }

    function chooseFromSubscription(Request $request){
        if(self::validate()){
            $subscriptions = DB::select("select * from subscriptions");
            return View('chooseFromSubscription',["subscriptions"=>$subscriptions]);
        }else{
            return View('RestrictedAccess');
        }
    }
    function deleteAccount(Request $request){
        if(self::validate()){
            $id = $request->input("accId");
            
            DB::delete("delete from accounts where AccountId = ?",[$id]);
            //DB::delete("delete from beneficiaries where AccountId = ?",[$id]);
            //DB::delete("delete from volunteers where AccountId = ?",[$id]);
            //DB::delete("delete from coordinators where AccountId = ?",[$id]);
            
            //DB::delete("delete from volunteers,volunteerattendances inner join  where v.VolunteerId = a.VolunteerId and v.AccountId = ?",[$id]);
            //DB::delete("delete from volunteers,volunteerattendances inner join volunteerattendances where volunteers.VolunteerId = volunteerattendances.VolunteerId and volunteers.AccountId = ?",[$id]);
            
        }else{
            return View('RestrictedAccess');
        }
    }

    function becomeSubscriber(Request $request){
        $username=$request->input('username');
        $password=$request->input('password');
        $contactNumber=$request->input('contactNumber');
        $address=$request->input('address');
        $emailAddress=$request->input('emailAddress');
        $status=1;
        $maxPrograms=3;
        $results = DB::select("select * from subscribers where Username='$username'");
        if(sizeof($results)===0){
             $results = DB::select("select * from accounts where Username='$username'");
            if(sizeof($results)===0){
                DB::insert('insert into subscribers (Username,Password,ContactNumber,Address,EmailAddress,Status,MaxPrograms) values (?, ?, ?, ?, ?, ?, ?)', [$username,$password,$contactNumber,$address,$emailAddress,$status,$maxPrograms]);
                $results = DB::select('select max(SubscriberId) as SubscriberId from subscribers');
                $id=$results[0]->SubscriberId;

                DB::insert('insert into universities 
                (UniName,UniDescription,Vision,Mission,ExtensionHeadName,SubscriberId)
                values (?, ?, ?, ?, ?, ?)', ['-','-','-','-','-',$id]);
                
                $results = DB::select("select * from subscribers s,universities u where s.Username='$username' and s.Password='$password' and u.SubscriberId=s.SubscriberId");
                
                session(['accountId'=>$results[0]->SubscriberId]);
                session(['name'=>$results[0]->ExtensionHeadName]);
                session(['type'=>'Director']);
                session(['pic'=>$results[0]->UniLogo]);
                session(['uniId'=>$results[0]->UniId]);
                session(['maxPrograms'=>$results[0]->MaxPrograms]);
                //return redirect('getProfile');
                echo "Successfully Created new Account";
            }else{
                echo "Username exists in accounts table";
            }
        }else{
            echo "username exists in subscribers table";
        }
        
        
        
    }
    
    function editUniversity(Request $request){
        //asd
        if(self::validate()){
            $uniName=$request->input('uniName');
            $uniId=$request->input('uniId');
            $uniDescription=nl2br($request->input('uniDescription'));
            $uniDescription=($request->input('uniDescription'));
            //$uniDescription=str_replace(' ','&nbsp',$uniDescription);
            $vision=nl2br($request->input('vision'));
            $vision=($request->input('vision'));
            //$vision=str_replace(' ','&nbsp',$vision);
            //$mission=$request->input('mission');
            $mission=nl2br($request->input('mission'));
            $mission=($request->input('mission'));
            //$mission=str_replace(' ','&nbsp',$mission);
            
            $extensionHeadName=$request->input('extensionHeadName');
            
            $contNum=$request->input('contNumber');
            $address=$request->input('address');
            DB::update('update universities set UniName = ?,UniDescription=?,Vision=?,Mission=?,ExtensionHeadName=?,UniAddress=?,UniContNum=?
            where UniId = ?', [ $uniName,$uniDescription,$vision,$mission,$extensionHeadName,$address,$contNum,$uniId]);
            //return back();
            
            session(['name'=>$extensionHeadName]);
        }else{
            return View('RestrictedAccess');
        }
	}
    /*function getUniversityProfile(Request $request){
        if(self::validate()){
            $id=session('accountId');
            $subDetails = DB::select("select * from subscribers where SubscriberId='$id'");
            $uniDetails = DB::select("select * from universities where SubscriberId='$id'");
            print_r($uniDetails);

        }else{
            return View('RestrictedAccess');
            
        }
    }*/
    
	function addProgram(Request $request){
        
        if(self::validate()){
           $programName=$request->input('programName');
            $programDescription=$request->input('programDescription');
            $programObjective=$request->input('programObjective');
            $universityId=$request->input('universityId');
            DB::insert('insert into programs (ProgramName,ProgramDescription,ProgramObjective,UniversityId) 
            values (?, ?, ?, ?)', [$programName,$programDescription,$programObjective,$universityId]);
            $lastId = DB::getPdo()->lastInsertId();
            //$programId=$request->input('programId');
            //DB::update('update programs set Logo=? where ProgramId=?', [$lastId.'-program-logo-photo.jpg',$lastId]);
            //$request->file('photo')->move('img\logos\programs',$lastId.'-program-logo-photo.jpg');
          
            echo "Successfully added new program".$lastId;
            //return back();
        }else{
            echo "Restricted Access;";
            //return View('RestrictedAccess');
        }
	}
    
	function editProgram(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            $programName=$request->input('programName');
            $programDescription=$request->input('programDescription');
            //$programDescription=nl2br($request->input('programDescription'));
            
            $programObjective=$request->input('programObjective');
            $logo=$request->input('logo');
            DB::update('update programs set ProgramName = ?,ProgramDescription=?,ProgramObjective=?,Logo=?
            where Programid = ?', [$programName,$programDescription,$programObjective,$logo,$id]);
            return back();
        }else{
            return View('RestrictedAccess');
        }
	}
	
	function deleteProgram(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            $program = DB::select("select * from programs where ProgramId = ?",[$id]);
            DB::delete('delete from Programs where ProgramId=?',[$id]);
            DB::delete('delete from Coordinators where ProgramId=?',[$id]);
            return redirect('getUniversityProfile?id='.$program[0]->UniversityId);
                
        }else{
            return View('RestrictedAccess');
        }
	}
	
    function addCoordinator(Request $request){
        if(self::validate()){
            
            $programId=$request->input('programId');
            $isActive=1;
            $accountId=$request->input('accountId');
            $programs=DB::select("select * from programs where ProgramId=?",[$programId]);
            $uni=DB::select("select * from universities where UniId=?",[$programs[0]->UniversityId]);
            //$checkIfCoordinatorAdy = DB::select("select * from coordinators where AccountId = ? and ProgramId = ?",[$accountId,$programId]);
            $checkIfCoordinatorAdy = DB::select("select * from coordinators c,programs p where p.ProgramId = c.ProgramId and c.AccountId = ?",[$accountId]);
            //print_r($checkIfCoordinatorAdy);
            if(empty($checkIfCoordinatorAdy)){
                DB::insert('insert into coordinators (ProgramId,isActive,AccountId) values (?, ?, ?)', [$programId,$isActive,$accountId]);
            
                DB::insert("insert into notifications (Description,Status,LinksTo,Recipient,RecipientId) values(?,?,?,?,?)",["You have been assigned as a Coordinator of ".$uni[0]->UniName."'s ".$programs[0]->ProgramName.".",0,"getUniversityProgramsSpecific?id=".$programId,"Registered User",$accountId]);
                echo "Successfully added a news coordinator";
            }else{
                $flag = 0;
                $flag1 = 0;
                $coordProgram = "";
                foreach($checkIfCoordinatorAdy as $coordAdy){
                    if($coordAdy->isActive == 1){
                        $coordProgram = $coordAdy->ProgramName;
                        $flag = 1;
                    }
                }
                foreach($checkIfCoordinatorAdy as $coordAdy){
                    if($coordAdy->ProgramId == $programId){
                        $coordProgram = $coordAdy->ProgramName;
                        $flag1 = 1;
                    }
                }
                if($flag === 0 && $flag1 === 0){
                    //TODO: should trap?
                    //echo "Account is already a previous coordinator of the ".$checkIfCoordinatorAdy[0]->ProgramName." program";
                    DB::insert('insert into coordinators (ProgramId,isActive,AccountId) values (?, ?, ?)', [$programId,$isActive,$accountId]);
            
                    DB::insert("insert into notifications (Description,Status,LinksTo,Recipient,RecipientId) values(?,?,?,?,?)",["You have been assigned as a Coordinator of ".$uni[0]->UniName."'s ".$programs[0]->ProgramName.".",0,"getUniversityProgramsSpecific?id=".$programId,"Registered User",$accountId]);
                    echo "Successfully added previous coordinator to another program";
                }
                if($flag===1){
                    echo "Account is already a current coordinator of the ".$coordProgram." program";
                }
                if($flag1===1){
                    if($flag === 1)
                        echo " and is already a previous coordinator of the ".$coordProgram." program";
                    else
                        echo "Account is already a previous coordinator of the ".$coordProgram." program";
                    
                }
                
            }

            //DB::insert('insert into coordinators (ProgramId,isActive,AccountId) values (?, ?, ?)', [$programId,$isActive,$accountId]);
            
            //DB::insert("insert into notifications (Description,Status,LinksTo,Recipient,RecipientId) values(?,?,?,?,?)",["You have been assigned as a Coordinator of ".$uni[0]->UniName."'s ".$programs[0]->ProgramName.".",0,"getUniversityProgramsSpecific?id=".$programId,"Registered User",$accountId]);
            //echo "ma add";
            
           //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    /*function editCoordinator(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            //DB::update('update coordinators set isActive = ?
            //where CoordinatorId = ?', [$isActive,$id]);
            $uniId = 0;
           if(session("type") === "Coordinator"){
               $uniId = session("uniId");
           }elseif(session("type") === "Director"){
               $uniId = session("programUniId");
           }
            $users=DB::select("select * from accounts where UniversityId = ?",[$uniId]);
            $coordinators=DB::select("select * from coordinators c,accounts a where a.AccountId=c.AccountId and c.ProgramId='$id'");
            return View('forms.editCoordinators',['accounts'=>$users,'uniId'=>$id,'coordinators'=>$coordinators]);
        }else{
            //return View('RestrictedAccess');
        }
	}*/
    function deleteCoordinator(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            
            $coordinators=DB::select("select * from coordinators where CoordinatorId=?",[$id]);
            DB::delete('delete from coordinators where CoordinatorId=?',[$id]);	
            
            DB::insert("insert into notifications (Description,Status,LinksTo,Recipient,RecipientId) values(?,?,?,?,?)",["You are now not a Coordinator.",0,"getProfile?","Coordinator",$coordinators[0]->AccountId]);
            
            echo "deleted coordinator successfully";
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    function reassignCoordinator(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            $status=1;
            $coordinator = DB::select("select * from coordinators c, programs p where p.ProgramId = c.ProgramId and c.CoordinatorId = ?",[$id]);
            if(!empty($coordinator)){
                $coordinator=$coordinator[0];
                $checkIfCoordinatorAdy = DB::select("select p.ProgramName from coordinators c,programs p where p.ProgramId = c.ProgramId and c.AccountId = ? and isActive = ?",[$coordinator->AccountId,1]);
                if(empty($checkIfCoordinatorAdy)){
                    DB::update('update coordinators set isActive=? where CoordinatorId=?',[$status,$id]);
            
                    $coordinator = DB::select("select * from coordinators c, programs p where p.ProgramId = c.ProgramId and c.CoordinatorId = ?",[$id]);
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["You have been assigned as coordinator of ".$coordinator[0]->ProgramName,"getUniversityProgramsSpecific?id=".$coordinator[0]->ProgramId,"Registered User",$coordinator[0]->AccountId]);
                    echo "reassigned coordinator successfully";
           
                }else{
                    echo "Account is already a current coordinator of ".$checkIfCoordinatorAdy[0]->ProgramName;
                }
            }else{
                echo "Coordinator record does not exist";
            }
            /*
            DB::update('update coordinators set isActive=? where CoordinatorId=?',[$status,$id]);
            
            $coordinator = DB::select("select * from coordinators c, programs p where p.ProgramId = c.ProgramId and c.CoordinatorId = ?",[$id]);
            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["You have been assigned as coordinator of ".$coordinator[0]->ProgramName,"getUniversityProgramsSpecific?id=".$coordinator[0]->ProgramId,"Registered User",$coordinator[0]->AccountId]);
            echo "reassigned coordinator successfully";*/
        }else{
            return View('RestrictedAccess');
        }
	}
    function unassignCoordinator(Request $request){
        if(self::validate()){
            $id=$request->input('id');
            $status=0;
            DB::update('update coordinators set isActive=? where CoordinatorId=?',[$status,$id]);	
            echo "unassigned coordinator successfully";
            $coordinator = DB::select("select * from coordinators c, programs p where p.ProgramId = c.ProgramId and c.CoordinatorId = ?",[$id]);
            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["You are no longer a coordinator of ".$coordinator[0]->ProgramName,"getUniversityProgramsSpecific?id=".$coordinator[0]->ProgramId,"Registered User",$coordinator[0]->AccountId]);
        }else{
            return View('RestrictedAccess');
        }
	}
    
	
	/*function addProject(Request $request){
        if(self::validate()){
		$projectName=$request->input('projectName');
		$projectDescription=$request->input('projectDescription');
		$programId=$request->input('programId');
		$status='Approved';
		$banner=$request->input('banner');
        
		DB::insert('insert into projects (ProjectName,ProjectDescription,ProgramId,Status,Banner) 
		values (?, ?, ?, ?, ?)', [$projectName,$projectDescription,$programId,$status,$banner]);
        }else{
            return View('RestrictedAccess');
        }
	}*/
	
	
	/*function editProject(Request $request){
        if(self::validate()){
		$id=$request->input('id');
		$projectName=$request->input('projectName');
		$projectDescription=$request->input('projectDescription');
		$status=$request->input('status');
		$banner=$request->input('banner');
        
		DB::update('update projects set ProjectName = ?,ProjectDescription=?,Status=?,Banner=?
		where ProjectId = ?', [$projectName,$projectDescription,$status,$banner,$id]);
        }else{
            return View('RestrictedAccess');
        }

	}*/
	
	function deleteProject(Request $request){
        if(self::validate()){
        $id=$request->input('id');
        $project = DB::select("select * from projects where ProjectId = ?",[$id]);
        DB::delete('delete from projects where ProjectId=?',[$id]);	
        if(!empty($project)){
            if($project[0]->Level === "Institution"){
                return redirect('getUniversityProfile?id='.$project[0]->ProgramId);
            }else{
                return redirect('getUniversityProgramsSpecific?id='.$project[0]->ProgramId);
            } 
        }else{
            echo "project id not found";
        }
        }else{
            return View('RestrictedAccess');
        }
	}
	
	/*
	function addActivity(Request $request){
        if(self::validate()){
            $activityName=$request->input('activityName');
            $activityDescription=$request->input('activityDescription');
            $activityVenue=$request->input('activityVenue');
            $targetAudience=$request->input('targetAudience');
            $projectId=$request->input('projectId');
            $status='Approved';
            DB::insert('insert into activities (ActivityName,ActivityDescription,ActivityVenue,TargetAudience,ProjectId,Status) 
            values (?, ?, ?, ?, ?, ?)', [$activityName,$activityDescription,$activityVenue,$targetAudience,$projectId,$status]);

            $results = DB::select('select max(ActivityId) as ActivityId from activities');
            $id=$results[0]->ActivityId;

            $date=$request->input('date');
            $time=$request->input('time');

            for($i=0;$i<sizeof($date);$i++){
                if($date[$i]!==''&&$time[$i]!==''){
                    DB::insert('insert into schedules (ProgramId,SchedTime,SchedDate) 
                    values ( ?, ?, ?)', [$id,$time[$i], $date[$i]]);
                }
            }
        }else{
            return View('RestrictedAccess');
        }
	}*/
	
	/*function editActivity(Request $request){
        
        if(self::validate()){
            $id=$request->input('id');
            $activityName=$request->input('activityName');
            $activityDescription=$request->input('activityDescription');
            $activityVenue=$request->input('activityVenue');
            $targetAudience=$request->input('targetAudience');
            $status=$request->input('status');

            DB::update('update activities set ActivityName=?,ActivityDescription=?,ActivityVenue=?,TargetAudience=?,Status=?
            where ActivityId = ?', [$activityName,$activityDescription,$activityVenue,$targetAudience,$status,$id]);
        }else{
            //return View('RestrictedAccess');
        }

	}*/
	
	
    
    function approveActivity(Request $request){
        if(self::validate()){
            $activityId=$request->input('activityId');
            $activityName=$request->input('activityName');
            $status=$request->input('status');
            $programId=$request->input('programId');
            DB::update("update activities set ActivityStatus=? where ActivityId=?",[$status,$activityId]);	

            if($status==='Approved'){
                $coordinators=DB::select("select * from coordinators c where c.ProgramId=?",[$programId]);
                foreach($coordinators as $coordinator){
                    DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["Your Activity ".$activityName." has been approved","getActivityPage?id=".$activityId,"Coordinator",$coordinator->AccountId]);
                }
            }
            
            
            
            
            //DB::insert("insert into notificaionts");
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function approveActivities(Request $request){
        if(self::validate()){
            $activityIds=$request->input('activityIds');
            $status = "Approved";
            foreach($activityIds as $activityId){
                echo $activityId." -- <br>";
                DB::update('update activities set ActivityStatus = ? where ActivityId = ?',[$status,$activityId]);
            }
    
            if($status==='Approved'){
                foreach($activityIds as $activityId){
                    $coordinators=DB::select("select * from coordinators co,programs pg,projects pj,activities ac where ac.ProjectId = pj.ProjectId and pj.ProgramId = pg.ProgramId and pg.ProgramId = co.ProgramId and co.isActive = ? and ac.ActivityId = ?",[1,$activityId]);
                    
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["Your Activity ".$coordinator->ActivityName." has been approved","getActivityPage?id=".$coordinator->ActivityId,"Registered User",$coordinator->AccountId]);
                    }
                }
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }

    function rejectActivities(Request $request){
        if(self::validate()){
            $activityIds=$request->input('activityIds');
            $status = "Approved";
            foreach($activityIds as $activityId){
                echo $activityId." -- <br>";
                DB::delete('delete from activities where ActivityId = ?',[$activityId]);
            }
            
            if($status==='Approved'){
                //$coordinators=DB::select("select * from coordinators co,programs pg,projects pj where pg.ProgramId = ",[$programId]);
                /*foreach($activityIds as $activityId){
                    $coordinators=DB::select("select * from coordinators co,programs pg,projects pj,activities ac where ac.ProjectId = pj.ProjectId and pj.ProgramId = pg.ProgramId and pg.ProgramId = co.ProgramId and co.isActive = ? and ac.ActivityId = ?",[1,$activityId]);
                    
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["Your Activity ".$coordinator->ActivityName." has been approved","getActivityPage?id=".$coordinator->ActivityId,"Registered User",$coordinator->AccountId]);
                    }
                }*/
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function approveProjects(Request $request){
        if(self::validate()){
            $projectIds=$request->input('projectIds');
            $status = "Approved";
            foreach($projectIds as $projectId){
                DB::update('update projects set Status = ? where ProjectId = ?',[$status,$projectId]);
            }
    
            if($status==='Approved'){
                foreach($projectIds as $projectId){
                    $coordinators=DB::select("select * from coordinators co,programs pg,projects pj where pj.ProgramId = pg.ProgramId and pg.ProgramId = co.ProgramId and co.isActive = ? and pj.ProjectId = ?",[1,$projectId]);
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["Your Project ".$coordinator->ProjectName." has been approved","getUniversityProject?id=".$coordinator->ProjectId,"Registered User",$coordinator->AccountId]);
                    }
                }
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }

    function rejectProjects(Request $request){
        if(self::validate()){
            $projectIds=$request->input('projectIds');
            $status = "Approved";
            foreach($projectIds as $projectId){
                echo $projectId." -- <br>";
                DB::delete('delete from projects where ProjectId = ?',[$projectId]);
            }
            
            if($status==='Approved'){
                //$coordinators=DB::select("select * from coordinators co,programs pg,projects pj where pg.ProgramId = ",[$programId]);
                /*foreach($activityIds as $activityId){
                    $coordinators=DB::select("select * from coordinators co,programs pg,projects pj,activities ac where ac.ProjectId = pj.ProjectId and pj.ProgramId = pg.ProgramId and pg.ProgramId = co.ProgramId and co.isActive = ? and ac.ActivityId = ?",[1,$activityId]);
                    
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["Your Activity ".$coordinator->ActivityName." has been approved","getActivityPage?id=".$coordinator->ActivityId,"Registered User",$coordinator->AccountId]);
                    }
                }*/
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    
	function approvePhoto(Request $request){
        if(self::validate()){
         
            $photoId = $request->input("photoId");
            DB::update("update pictures set Status = 1 where PictureId = ?",[$photoId]);
            echo "naoks na";
            return back();
        }else{
            return View('RestrictedAccess');
        }
			
    }
    
	function approveUnapprovedPhotos(Request $request){
        if(self::validate()){
         
            $photoIds = $request->input("photoIds");
            if(!empty($photoIds)){
                foreach($photoIds as $photo){
                    DB::update("update pictures set Status = 1 where PictureId = ?",[$photo]);
                }
            }
            //DB::update("update pictures set Status = 1 where PictureId = ?",[$photoId]);
            return back();
        }else{
            return View('RestrictedAccess');
        }
			
	}
	/*
	function (Request $request){
			
	}
	*/
	
}
