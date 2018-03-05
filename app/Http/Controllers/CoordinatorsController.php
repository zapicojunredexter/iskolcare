<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use DB;
class CoordinatorsController extends Controller
{
    function checkRestr(){
       if(session('type')==='Coordinator'||session('type')==='Director'){
           return true;
       }else{
           return false;
       }
    }
    
    function viewProfile(Request $request){
        //if(self::checkRestr()){
            
            $accId = $request->input('accid');
            
            $account = DB::select("select * from accounts where AccountId = ?",[$accId]);
            
            if(sizeof($account)>0){

                $account = $account[0];
                
                if($account->UniversityId === session('uniId')){
                    DB::select("select * from programs");
                    $account->partHist = DB::select("select a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId,b.BeneficiaryId from beneficiaries b, activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityId = b.ProgramId and b.AccountId = ? and a.ActivityStatus = ? and p.Status = ? and b.BenStatus = 1",[$account->AccountId,"Approved","Approved"]);
                    //$account->partHist = DB::select("select a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId,count(ba.BenAttendanceId) as AttendanceCount,count(s.SchedId) as SchedCount from beneficiaries b, activities a,projects p,beneficiaryattendances ba,schedules s where s.ProgramId = a.ActivityId and ba.BeneficiaryId = b.BeneficiaryId and p.ProjectId = a.ProjectId and a.ActivityId = b.ProgramId and ba.Status='Present' and b.AccountId = ? and a.ActivityStatus = ? and p.Status = ? and b.BenStatus = 1 group by a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId",[$account->AccountId,"Approved","Approved"]);
                    
                    $account->volHist = DB::select("select a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId,v.VolunteerId from volunteers v, activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityId = v.ProgramId and v.AccountId = ? and a.ActivityStatus = ? and p.Status = ? and v.VolunteerStatus",[$account->AccountId,"Approved","Approved"]);                    
                    //$account->volHist = DB::select("select a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId,count(va.VolAttendanceId) as AttendanceCount,count(s.SchedId) as SchedCount from volunteers v, activities a,projects p,volunteerattendances va,schedules s where s.ProgramId = a.ActivityId and va.VolunteerId = v.VolunteerId and p.ProjectId = a.ProjectId and v.VolunteerStatus=1 and a.ActivityId = v.ProgramId and v.AccountId = ? and a.ActivityStatus = ? and p.Status = ? and v.VolunteerStatus group by a.ActivityName,a.ActivityId,p.Banner,p.ProjectName,p.ProjectId",[$account->AccountId,"Approved","Approved"]);
                    
                    foreach($account->partHist as $partHist){
                        $schedCounter = DB::select("select count(SchedId) as SchedCounter from schedules where ProgramId = ?",[$partHist->ActivityId]);
                        $attendanceCounter = DB::select("select count(BeneficiaryId) as AttendanceCounter from beneficiaryattendances where BeneficiaryId = ? and Status='Present'",[$partHist->BeneficiaryId]);
                        $partHist->AttendanceCount=$attendanceCounter[0]->AttendanceCounter;
                        $partHist->SchedCount=$schedCounter[0]->SchedCounter;
                    }
                    
                    foreach($account->volHist as $volHist){
                        
                        $schedCounter = DB::select("select count(SchedId) as SchedCounter from schedules where ProgramId = ?",[$volHist->ActivityId]);
                        $attendanceCounter = DB::select("select count(VolunteerId) as AttendanceCounter from volunteerattendances where VolunteerId = ? and Status='Present'",[$volHist->VolunteerId]);
                        $volHist->AttendanceCount=$attendanceCounter[0]->AttendanceCounter;
                        $volHist->SchedCount=$schedCounter[0]->SchedCounter;
                        
                    }
                    
                     
                    $account->CoordinatorHistory = DB::select("select * from programs p,coordinators c where c.ProgramId = p.ProgramId and c.AccountId = ? order by c.isActive desc",[$account->AccountId]);
                    return View("viewProfile",["account"=>$account]);
                }else{
                    $message = "Cannot View profile of Accounts from Other Schools";    
                    return View('notFound',["message"=>$message]);
        
                }
            }else{
                echo "account not found";
            }
            
        /*}else{
            return View('RestrictedAccess');
        }*/
    }
    
    function getAllUniUserAccounts(Request $request){
        if(self::checkRestr()){
            $uniId=-1;
            if(session("type")==="Director"){
                $uniId=session("uniId");
            }elseif(session("type")==="Coordinator"){
                $uniId=session("programUniId");
            }
            $accounts=DB::select("select * from accounts where UniversityId = ?",[$uniId]);

            
            return View("getAllUniUserAccounts",["accounts"=>$accounts]);
        }else{
            return View('RestrictedAccess');
        }
    }
        
    function getUserAccountDetails(Request $request){
        if(self::checkRestr()){
            echo "hello";
            $accId=$request->input("id");
            
            $data=DB::select("select * from accounts where AccountId = ?",[$accId]);
      
            if(sizeof($data)>0){
                $data=$data[0];
                $data->volHist = DB::select("select * from volunteers v, activities a, projects p where a.ProjectId=p.ProjectId and a.ActivityId=v.ProgramId and v.status=1 and v.AccountId=?",[$accId]);    
                $data->partHist = DB::select("select * from beneficiaries b,activities a, projects p where a.ProjectId=p.ProjectId and a.ActivityId=b.programId and b.Status=1 and b.AccountId=?",[$accId]);
                
                return View("getUserAccountDetails",["data"=>$data]);
            }else{
                echo "user not found";
            }
           
        }else{
            return View('RestrictedAccess');
        }
    }
    function getCoordinatorsProgramPage(Request $request){
        if(self::checkRestr()){
            $notifId=$request->input("notifId");
            if(!empty($notifId)){
                DB::update("update notifications set status=1 where NotificationId=?",[$notifId]);
            }
            else{
                            //echo "wa";
            }
            $id=$request->input('id');
                //return redirect('getUniversityProfile?id='.$id);
            $program = DB::select("select * from programs where ProgramId='$id'");
            $type=session('type');
            if(sizeof($program)>0){
                 $program=$program[0];
                $program->Projects = DB::select("select * from projects where Level='Program' and  ProgramId='$id'");
                
                
                $coordinators=DB::select("select * from coordinators c,accounts a where a.AccountId=c.AccountId and c.ProgramId='$id'");
                
                if(!empty($program->Projects)){
                    
                    foreach($program->Projects as $project){
                        $project->Activities=DB::select("select * from activities where ProjectId='$project->ProjectId'");
                    }
                    $uniId=$program->UniversityId;
                    
                    
                    
                    $university=DB::select("select * from universities where UniId='$uniId'");

                    if($type==='Coordinator'){
                        return View('getCoordinatorsProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'programId'=>session('programId'),'coordinators'=>$coordinators]);
                        
                    }else{
                        return View('getCoordinatorsProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'coordinators'=>$coordinators]);
                    }
                }else{
                    $uniId=$program->UniversityId;
                    $university=DB::select("select * from universities where UniId='$uniId'");
                    

                    return View('getCoordinatorsProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'coordinators'=>$coordinators]);
                }
            }else{
                echo 'program record does not exists';
            }
            
        }else{
            return View('RestrictedAccess');
        }
	}
    function addProject(Request $request){
        if(self::checkRestr()){
            $projectName=$request->input('projectName');
            $projectDescription=$request->input('projectDescription');
            $programId=$request->input('programId');
            if(session('type')==='Coordinator'){
                $status='Pending for Add';   
            }else{
                $status='Approved';  
            }
            if(!empty($request->input('level'))){
                DB::insert('insert into projects (ProjectName,ProjectDescription,ProgramId,Status,Level) 
                values (?, ?, ?, ?, ?)', [$projectName,$projectDescription,$programId,$status,'Institution']);
                
                $lastId = DB::getPdo()->lastInsertId();    
                
                echo "Successfully added new project".$lastId;
            
            }else{
                DB::insert('insert into projects (ProjectName,ProjectDescription,ProgramId,Status) 
                values (?, ?, ?, ?)', [$projectName,$projectDescription,$programId,$status]);

                $lastId = DB::getPdo()->lastInsertId();    
                echo "Successfully added new project".$lastId;
            }
            
            if(session('type')==='Coordinator'){
                
                $programs=DB::select("select * from programs where ProgramId=?",[session('programId')]);
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["A new Project has been added to the ".$programs[0]->ProgramName." program by ".session('name')." ".session('lastName'), "getUniversityProgramsSpecific?id=".$programId,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                
                $programs=DB::select("select * from programs where ProgramId=?",[$programId]);
                $coordinators=DB::select("select * from coordinators where isActive=1 and ProgramId=?",[$programId]);
                if(empty($request->input('level'))){
                    foreach($coordinators as $coordinator){

                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["A new Project has been added to the ".$programs[0]->ProgramName." program by ".session('name').".", "getUniversityProgramsSpecific?id=".$programId,"Registered User",$coordinator->AccountId]);

                    }
                }
                
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
	
	
	function editProject(Request $request){
        if(self::checkRestr()){
            
            $id=$request->input('projectId');
            
            $accId=$request->input("projectId");
            $projectName=$request->input('projectName');
            $projectDescription=$request->input('projectDescription');

            $status=$request->input('status');
            if(session('type')==='Coordinator'){
                if($status === "Pending for Add"){
                    $status='Pending for Add';
                }else{
                    $status='Pending for Edit';
                }
            }else{
                //$status=$request->input('status');
                $status = "Approved"; 
            }
            if($status!=='Reject'){
                DB::update('update projects set ProjectName = ?,ProjectDescription=?,Status=?
                where ProjectId = ?', [$projectName,$projectDescription,$status,$id]);
                if($status==='Approved'){
                    
                    $program=DB::select("select * from programs pr,projects pj where pr.ProgramId=pj.ProgramId and pj.ProjectId=?",[$id]);
                    $coordinators=DB::select("select * from coordinators where ProgramId=?",[$program[0]->ProgramId]);
                    foreach($coordinators as $coordinator){
                        
                    //DB::insert("insert into notifications (Description,Status,LinksTo,Recipient,RecipientId) values (?,?,?,?,?)",["A project was approved by ".session("name"),0,"getCoordinatorsProgramPage?id=".$program[0]->ProgramId,"Coordinator",$coordinator->AccountId]);
                    }
                }
            }else{
                DB::delete('delete from projects
            where ProjectId = ?', [$id]);
            }
            
            
            if(session('type')==='Coordinator'){
                
               $programs=DB::select("select * from programs where ProgramId=?",[session('programId')]);
               DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Changes to the ".$projectName." project have been made by ".session('name').' '.session('lastName'), "getUniversityProject?id=".$id,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                
                $projectId=$request->input('projectId');
                echo $request->input('projectId');
                echo 'after';
                echo $projectId;
                echo 'bef ani';
               $project=DB::select("select * from projects where ProjectId=?",[$id]);
                echo $id;
                print_r($project);
                if($project[0]->Level==="Program"){

                    $coordinators=DB::select("select * from coordinators where isActive=1 and ProgramId=?",[$project[0]->ProgramId]);
                    foreach($coordinators as $coordinator){
                   
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Changes to the ".$projectName." Project has been made by ".session('name').".", "getUniversityProgramsSpecific?id=".$project[0]->ProgramId,"Registered User",$coordinator->AccountId]);
                    
                }
                }
                
                
            }
            
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
	
	/*function deleteProject(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            DB::delete('delete from projects where ProjectId=?',[$id]);	
        }else{
            return View('RestrictedAccess');
        }
	}*/
	
	
	function addActivity(Request $request){
        if(self::checkRestr()){
            $activityName=$request->input('activityName');
            $activityName=str_replace("`","'",$activityName);
            $activityDescription=$request->input('activityDescription');
            $activityVenue=$request->input('activityVenue');
            $targetAudience=$request->input('targetAudience');
            $projectId=$request->input('projectId');
            $isExclusive = 1;
            $cityLat = $request->input('cityLat');
            $cityLng = $request->input('cityLng');
                
            if(!empty($request->input("isExclusive")))
                $isExclusive = 0;
            if(session('type')==='Coordinator'){
                $status='Pending for Add';   
            }else{
                $status='Approved'; 
            }
            

            
            $date=$request->input('date');
            $time=$request->input('time');
            $timeEnd = $request->input('timeEnd');
            $message = "";
            $countScheds = 0;
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($time[$i])!==''&&trim($timeEnd[$i])!==''){
                    if($time[$i]>=$timeEnd[$i]){
                        $message = "Invalid Time entered";
                    }
                    $countScheds++;
                }
                
                if($date[$i]<=date('Y-m-d')){
                    $message = "Selected Dates Must be from Tomorrow Onwards";
                }
            }
            
            //checking if duplicate dates
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($time[$i])!==''&&trim($timeEnd[$i])!==''){
                    for($j=0;$j<sizeof($date);$j++){
                        if(trim($date[$j])!==''&&trim($time[$j])!==''&&trim($timeEnd[$j])!==''){
                            if($date[$i] === $date[$j] && $i!==$j){
                                $message = "Found Duplicate Values for Dates";
                            }
                        }
                    }
                }
            }
            
            if($countScheds === 0){
                $message = "Must have at least 1 valid schedule";
            }
            if($message!==""){
                echo $message;
                return;
            }
            
            if(empty($cityLat) && empty($cityLng)){
                DB::insert('insert into activities (ActivityName,ActivityDescription,ActivityVenue,TargetAudience,ProjectId,ActivityStatus,isExclusive) 
                values (?, ?, ?, ?, ?, ?, ?)', [$activityName,$activityDescription,$activityVenue,$targetAudience,$projectId,$status,$isExclusive]);
            }else{
                DB::insert('insert into activities (ActivityName,ActivityDescription,ActivityVenue,TargetAudience,ProjectId,ActivityStatus,isExclusive,LocationLat,LocationLng) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$activityName,$activityDescription,$activityVenue,$targetAudience,$projectId,$status,$isExclusive,$cityLat,$cityLng]);
                
            }
            
            $id = DB::getPdo()->lastInsertId();
            echo $id;
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($time[$i])!==''&&trim($timeEnd[$i])!==''){
                    DB::insert('insert into schedules (ProgramId,SchedTime,SchedTimeEnd,SchedDate) 
                    values ( ?, ?, ?, ?)', [$id,$time[$i],$timeEnd[$i],$date[$i]]);
                }
            }
            if(session('type')==='Coordinator'){
                
                $programs=DB::select("select * from programs where ProgramId=?",[session('programId')]);
                $projects=DB::select("select * from projects where ProjectId=? and Level=?",[$projectId,"Program"]);
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." added a new Activity to the ".$programs[0]->ProgramName."'s ".$projects[0]->ProjectName." project", "getActivityPage?id=".$id,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                $projects=DB::select("select * from projects p where p.ProjectId=?",[$projectId]);
                if($projects[0]->Level==="Program"){
                    $coordinators=DB::select("select * from coordinators c where c.ProgramId=?",[$projects[0]->ProgramId]);
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["A new Activity has been added to a program you were assigned in","getActivityPage?id=".$id,"Registered User",$coordinator->AccountId]);
                    }
                }
                
            }
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
	
	function editActivity(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            echo $id;
            //$projects=DB::select("select * from activities a, projects p,programs r where r.ProgramId=p.ProjectId and a.ProjectId=p.ProjectId and a.ActivityId=?",[$id]);
            $projects=DB::select("select * from activities a,projects r,programs p where p.ProgramId=r.ProgramId and r.ProjectId=a.ProjectId and a.ActivityId=?",[$id]);
            $activityName=$request->input('activityName');
            $activityName=str_replace("`","'",$activityName);
            $activityDescription=$request->input('activityDescription');
            $activityVenue=$request->input('activityVenue');
            $targetAudience=$request->input('targetAudience');
            if(session('type')==='Coordinator'){
                $status = 'Pending for Edit';
                if($projects[0]->ActivityStatus === "Pending for Add")
                    $status='Pending for Add';
                else{
                    $status='Pending for Edit';    
                }
            }else{
                $status = "Approved";
            }
            $isExclusive=1;
            if($request->input('isExclusive')){
                $isExclusive = 0;
            }
            DB::update('update activities set ActivityName=?,ActivityDescription=?,ActivityStatus=?,ActivityVenue=?,TargetAudience=?, isExclusive = ?
            where ActivityId = ?', [$activityName,$activityDescription,$status,$activityVenue,$targetAudience,$isExclusive,$id]);
            
            
            if(session('type')==='Coordinator'){
                
                $programs=DB::select("select * from programs where ProgramId=?",[session('programId')]);
                
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Director",session('programUniId')]);
                
                $volunteers = DB::select("select * from volunteers where ProgramId = ?",[$id]);
                
                foreach($volunteers as $volunteer){
                    //$checkIsCoordinator = DB::select("select * from coordinators where isActive=1 and AccountId = ?",[$volunteer->AccountId]);
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                    
                    /*if(sizeof($checkIsCoordinator>0)){
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                    }else{
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                    }*/
                    
                }
                $beneficiaries = DB::select("select * from beneficiaries where ProgramId = ?",[$id]);
                foreach($beneficiaries as $beneficiary){
                    //$checkIsCoordinator = DB::select("select * from coordinators where isActive=1 and AccountId = ?",[$volunteer->AccountId]);
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$beneficiary->AccountId]);
                    
                    /*if(sizeof($checkIsCoordinator>0)){
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                    }else{
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                    }*/
                    
                }
                
            }elseif(session('type')==='Director'){
                
                $volunteers = DB::select("select * from volunteers where ProgramId = ?",[$id]);
                
                foreach($volunteers as $volunteer){
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                }
                
                $beneficiaries = DB::select("select * from beneficiaries where ProgramId = ?",[$id]);
                foreach($beneficiaries as $beneficiary){
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$beneficiary->AccountId]);
                    
                }
                if($projects[0]->Level==="Program"){
                    $coordinators=DB::select("select * from coordinators where ProgramId=? and isActive = 1",[$projects[0]->ProgramId]);
                    foreach($coordinators as $coordinator){

                        DB::insert("insert into notifications(Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session("name")." has made changes to an Activity of the ".$projects[0]->ProjectName." project.","getActivityPage?id=".$id,"Registered User",$coordinator->AccountId]);
                    }
                /*    $volunteers = DB::select("select * from volunteers where ProgramId = ?",[$id]);
                
                    foreach($volunteers as $volunteer){
                        $checkIsCoordinator = DB::select("select * from coordinators where isActive=1 and AccountId = ?",[$volunteer->AccountId]);
                        if(sizeof($checkIsCoordinator>0)){
                            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                        }else{
                            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                        }

                    }*/
                }else{
                    /*$volunteers = DB::select("select * from volunteers where ProgramId = ?",[$id]);
                
                    foreach($volunteers as $volunteer){
                        $checkIsCoordinator = DB::select("select * from coordinators where isActive=1 and AccountId = ?",[$volunteer->AccountId]);
                        if(sizeof($checkIsCoordinator>0)){
                            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                        }else{
                            DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')."  ".session('lastName')." made changes to the ".$activityName." Activity", "getActivityPage?id=".$id,"Registered User",$volunteer->AccountId]);
                        }

                    }*/
                    
                }
            }
            
            //return back();
        }else{
            return View('RestrictedAccess');
        }

	}
	
	
    
   function deleteActivity(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            $activity = DB::select("select * from activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityId = ?",[$id]);
            
            $programId = $activity[0]->ProjectId;
            $level = $activity[0]->Level;
            DB::delete('delete from activities where Activityid=?',[$id]);
            DB::delete("delete from volunteers where ProgramId = ?",[$id]);
            DB::delete("delete from beneficiaries where ProgramId = ?",[$id]);
            if($level === 'Program'){
                return redirect('getUniversityProject?id='.$programId);
            }else{
                return redirect('getUniversityProject?id='.$programId);
            }
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function addActivitySchedule(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            $date=$request->input('date');
            $time=$request->input('time');

            for($i=0;$i<sizeof($date);$i++){
                if($date[$i]!==''&&$time[$i]!==''){
                    DB::insert('insert into schedules (ProgramId,SchedTime,SchedDate) 
                    values ( ?, ?, ?)', [$id,$time[$i], $date[$i]]);
                }
            }
            
            if(session('type')==='Coordinator'){
                
                $activity=DB::select("select * from activities where ActivityId=?",[$id]);
                
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')." ".session('lastName')." made changes to the ".$activity[0]->ActivityName." Activity schedule", "getActivityPage?id=".$id,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                
            }
            
            
            return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function editActivitySchedule(Request $request){
        if(self::checkRestr()){
            /*$id=$request->input('id');
            
            $date=$request->input('date');
            $time=$request->input('time');
            
            $finalD=[];
            $finalT=[];
            
            $previousScheds=DB::select("select * from schedules where ProgramId=?",[$id]);
           
            foreach($previousScheds as $ps){
                $d=$request->input('d'.$ps->SchedId);
                $t=$request->input('t'.$ps->SchedId);
                if(trim($d)!==''&&trim($t)!==''){
                    array_push($finalD,$d);
                    array_push($finalT,$t);
                }
            }  
            
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($time[$i])!==''){
                    array_push($finalD,$date[$i]);
                    array_push($finalT,$time[$i]);
                }
            }
            
            for($i=0;$i<sizeof($finalD);$i++){
                echo $finalD[$i].'        '.$finalT[$i].'<br>';
            }       
                   
            DB::delete('delete from schedules where ProgramId=?',[$id]);	
        
            for($i=0;$i<sizeof($finalD);$i++){
                DB::insert('insert into schedules (ProgramId,SchedTime,SchedDate) 
            values (?, ?, ?)', [$id,$finalT[$i],$finalD[$i]]);
            }
            
             if(session('type')==='Coordinator'){
                
                $activity=DB::select("select * from activities where ActivityId=?",[$id]);
                
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')." ".session('lastName')." made changes to the ".$activity[0]->ActivityName." Activity schedule", "getActivityPage?id=".$id,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                
            }*/
            $id=$request->input('id');  
            $date=$request->input('date');
            $timeStart=$request->input('timeStart');
            $timeEnd=$request->input('timeEnd');
            
            $message = "";
            $countScheds = 0;
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($timeStart[$i])!==''&&trim($timeEnd[$i])!==''){
                    if($timeStart[$i]>=$timeEnd[$i]){
                        $message = "Invalid Time entered";
                    }
                    if($date[$i]===date('Y-m-d')){
                        $message = "Selected Date Must be from Tomorrow Onwards";
                    }
                    $countScheds++;
                }else{
                    
                }
            }
            if($countScheds === 0){
                $message = "Must have at least 1 valid schedule";
            }
            
            //checking if duplicate dates
            for($i=0;$i<sizeof($date);$i++){
                if(trim($date[$i])!==''&&trim($timeStart[$i])!==''&&trim($timeEnd[$i])!==''){
                    for($j=0;$j<sizeof($date);$j++){
                        if(trim($date[$j])!==''&&trim($timeStart[$j])!==''&&trim($timeEnd[$j])!==''){
                            if($date[$i] === $date[$j] && $i!==$j){
                                $message = "Found Duplicate Values for Dates";
                            }
                        }
                    }
                }
            }
            
            if($message!==""){
                echo $message;
                return;
            }
            DB::delete("delete from schedules where ProgramId = ?",[$id]);
            if(session("type") === "Coordinator"){
                DB::update("update activities set ActivityStatus = ? where ActivityId = ?",["Pending for Edit",$id]);
            }
            for($i = 0;$i<sizeof($date);$i++){
                if(trim($date[$i])!=="" && trim($timeStart[$i])!=="" && trim($timeEnd[$i])!==""){
                    DB::insert('insert into schedules (ProgramId,SchedTime,SchedTimeEnd,SchedDate) values (?, ?, ?, ?)', [$id,$timeStart[$i],$timeEnd[$i],$date[$i]]);
                }
            }
            $activity=DB::select("select * from activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityId=?",[$id]);
            if(session('type')==='Coordinator'){             
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')." ".session('lastName')." made changes to the ".$activity[0]->ActivityName." Activity schedule", "getActivityPage?id=".$id,"Director",session('uniId')]);
            }elseif(session('type')==='Director'){
                if($activity[0]->Level === "Program"){
                    $coordinators = DB::select("select * from coordinators where ProgramId = ? and isActive = ?",[$activity[0]->ProgramId, 1]);
                    foreach($coordinators as $coordinator){
                        DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')." made changes to the ".$activity[0]->ActivityName." Activity schedule", "getActivityPage?id=".$id,"Registered User",$coordinator->AccountId]);
                    }
                }
            }
            echo "Successfully Changed Schedule!";
            //return back();
        }else{
            return View('RestrictedAccess');
        }

	}
    
    
    function deleteActivitySchedule(Request $request){
        if(self::checkRestr()){
            echo 'haha';
            $id=$request->input('id');;
            DB::delete('delete from schedules where SchedId=?',[$id]);	
            return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function addApprovedVolunteers(Request $request){
        if(self::checkRestr()){
            $id=$request->input('volIds');
            $status=1;
            
            for($i=0;$i<sizeof($id);$i++){
                
            
                $volunteer=DB::select("select * from volunteers v,activities a where a.ActivityId=v.ProgramId and v.VolunteerId=?",[$id[$i]]);
                $volunteer=$volunteer[0];
                
                DB::update('update volunteers set VolunteerStatus=?
                where VolunteerId = ?', [$status,$id[$i]]);
                $checkIfCoordinator=DB::select("select * from coordinators where isActive=1 and AccountId=?",[$volunteer->AccountId]);
                if(sizeof($checkIfCoordinator>0)){
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Your request to join ".$volunteer->ActivityName." as a volunteer has been Approved","getActivityPage?id=".$volunteer->ActivityId,"Registered User",$volunteer->AccountId]);
                    
                }else{
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Your request to join ".$volunteer->ActivityName." has been Approved","getActivityPage?id=".$volunteer->ActivityId,"Registered User",$volunteer->AccountId]);
                    
                }
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function addApprovedBeneficiary(Request $request){
        if(self::checkRestr()){
            $id=$request->input('benIds');
            $status=1;
            
            for($i=0;$i<sizeof($id);$i++){
                
            
                $volunteer=DB::select("select * from beneficiaries b,activities a where a.ActivityId=b.ProgramId and b.BeneficiaryId=?",[$id[$i]]);
                $volunteer=$volunteer[0];
                
                DB::update('update beneficiaries set BenStatus=?
                where BeneficiaryId = ?', [$status,$id[$i]]);
                $checkIfCoordinator=DB::select("select * from coordinators where isActive=1 and AccountId=?",[$volunteer->AccountId]);
                if(sizeof($checkIfCoordinator>0)){
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Your request to join ".$volunteer->ActivityName." as a beneficiary has been Approved","getActivityPage?id=".$volunteer->ActivityId,"Registered User",$volunteer->AccountId]);
                    
                }else{
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["Your request to join ".$volunteer->ActivityName." as a beneficiary has been Approved","getActivityPage?id=".$volunteer->ActivityId,"Registered User",$volunteer->AccountId]);
                    
                }
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    function editVolunteer(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            $status=1;
            
            DB::update('update volunteers set Status=?
            where VolunteerId = ?', [$status,$id]);
            return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function deleteVolunteer(Request $request){
        if(self::checkRestr()){
            $id=$request->input('volIds');
            
 
            for($i=0;$i<sizeof($id);$i++){
                DB::delete('delete from volunteers where VolunteerId=?',[$id[$i]]);	
            }
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function deleteBeneficiary(Request $request){
        if(self::checkRestr()){
            $id=$request->input('benIds');
            
 
            for($i=0;$i<sizeof($id);$i++){
                DB::delete('delete from beneficiaries where BeneficiaryId=?',[$id[$i]]);	
            }
            //return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    
    function getCoordinatorsProgram(Request $request){
        if(self::checkRestr()){
            $id=session('accountId');

            $results = DB::select("select * from coordinators c,programs p where c.accountId=? and p.ProgramId=c.ProgramId",[$id]);
            
            //return View('getCoordinatorsProgram');
        }else{
            return View('RestrictedAccess');
        }
	}
    
    
    function getActivityPage(Request $request){
        
        if(self::checkRestr()){
            $id=$request->input('id');
                //return redirect('getUniversityProfile?id='.$id);
            $activity = DB::select("select * from activities where ActivityId='$id'");
            $type=session('type');
            $activity=$activity[0];
            //$id=$activity[0]->ActivityId;
            $activity->Schedules=DB::select("select * from schedules where ProgramId='$activity->ActivityId'");
            /*foreach($projects as $project){
                $project->activities=DB::select("select * from activities where ProjectId='$project->ProjectId'");
            }*/
            
            
            $activity->Volunteers= DB::select("select * from volunteers v, Accounts a where a.AccountId=v.AccountId and v.ProgramId='$id'");
            
            $activity->Beneficiaries= DB::select("select * from beneficiaries b, Accounts a where a.AccountId=b.AccountId and b.ProgramId='$id'");
            if($type==='Director'){  
                //return View('getActivityPage',['type'=>$type,'activity'=>$activity,'uniId'=>$request->session['uniId']]);
                
            }else{
                if($type==='Coordinator'){
                    //return View('getActivityPage',['type'=>$type,'activity'=>$activity,'programId'=>session('programId')]);
                }
                //return View('getActivityPage',['type'=>$type,'activity'=>$activity]);
            }
        }else{
            return View('RestrictedAccess');
        }
   
	}
    
    function addAnnouncement(Request $request){
        if(self::checkRestr()){
            $announcement=$request->input('announcement');
                        
            $postWhat = (!empty($request->input('postWhat')))?$request->input('postWhat'):null;
            $postWhen = (!empty($request->input('postWhen')))?$request->input('postWhen'):null;
            $postWhere = (!empty($request->input('postWhere')))?$request->input('postWhere'):null;
            $uniId=$request->input('uniId');
            
            $announcement=str_replace("`","'",$announcement);
            $postWhat=str_replace("`","'",$postWhat);
            $postWhen=str_replace("`","'",$postWhen);
            $postWhere=str_replace("`","'",$postWhere);
            
            if(session('type')==="Coordinator"){
                
                $postedBy=session('name')." ".session('lastName');
                $posterDP=session('pic');

            }else{   
                $postedBy=session('name');
                $posterDP="../logos/".session('pic');
            }
        
   
            $posterDetails = session('type').' - '.session('accountId');
            DB::insert('insert into posts (UniId,PostDescr,PostedBy,PosterDP,PosterDetails,PostWhat,PostWhen,PostWhere) 
            values (?, ?, ?, ?, ?, ?, ?, ?)', [$uniId,$announcement,$postedBy,$posterDP,$posterDetails,$postWhat,$postWhen,$postWhere]);

           return back();
            
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function deleteAnnouncement(Request $request){
        if(self::checkRestr()){
            $id=$request->input('id');
            echo $id;
            DB::delete('delete from posts where PostId=?',[$id]);	
            return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function editAnnouncement(Request $request){
        if(self::checkRestr()){
            $annId=$request->input('annId');
            $annDesc=$request->input('annDesc');

            $postWhat = (!empty($request->input('postWhat')))?$request->input('postWhat'):null;
            $postWhen = (!empty($request->input('postWhen')))?$request->input('postWhen'):null;
            $postWhere = (!empty($request->input('postWhere')))?$request->input('postWhere'):null;
            
            $annDesc=str_replace("`","'",$annDesc);
            $postWhen=str_replace("`","'",$postWhen);
            $postWhere=str_replace("`","'",$postWhere);
            $postWhat=str_replace("`","'",$postWhat);
            
            
            DB::update('update posts set PostDescr = ?,PostWhat=?,PostWhen=?,PostWhere=?
            where PostId = ?', [$annDesc,$postWhat,$postWhen,$postWhere,$annId]);
         //   return back();
        }else{
            return View('RestrictedAccess');
        }
	}
    
    function setCoordinates(Request $request){
        if(self::checkRestr()){
            $lat=$request->input('lat');
            $lng=$request->input('lng');
            
            
            $id=$request->input('id');

            

            DB::update('update activities set LocationLat = ?,LocationLng=?
            where ActivityId = ?', [$lat,$lng,$id]);
            
            
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
     function createCertificates(Request $request){
        if(self::checkRestr()){
            $id=$request->input("id");
            $for=$request->input("for");
            /*if($for==="volunteers"){
                $volunteers=DB::select("select * from volunteers v,accounts a where a.AccountId=v.AccountId and ProgramId=?",[$id]);
            }elseif($for==="beneficiaries"){
                $volunteers=DB::select("select * from beneficiaries v,accounts a where a.AccountId=v.AccountId and ProgramId=?",[$id]);
             
            }
            if(empty($volunteers)){
                echo "no volunteers found for activity";
                return;
            }*/
            $activity = DB::select("select * from activities where ActivityId = ?",[$id]);
            if(empty($activity)){
                echo "Activity not found";
                return;
            }
            $activity = $activity[0];
            return View('forms.createCertificatesForm',['for'=>$for,'activityId'=>$id,'activity'=>$activity]);
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function uploadCertificates(Request $request){
        if(self::checkRestr()){
            $accountId=session('accountId');
            $id=$request->input("id");
            $for=$request->input("for");
           $request->file('photo')->move('img\certificates',session('type').'-'.$accountId.'-certificate-photo.jpg');
            return redirect('createCertificates?id='.$id.'&for='.$for);
        }else{
            return View('RestrictedAccess');
        }
    }
    

    function getParticipantsAnswer(Request $request){

        if(self::checkRestr()){
            $rfId = $request->input("rfid");
            $userId = $request->input("userId");
            $releasedForm = DB::select("select rf.ReleasedFormId,rf.FormId from releasedforms rf, evaluationtools ev where ev.EvaluationFormId = rf.FormId and rf.ReleasedFormId = ?",[$rfId]);
            
            $response = new \stdClass();
            if(empty($userId)){
                $response->Message = "User ID must exist";
            
            }elseif(!empty($releasedForm)){
                $releasedForm = $releasedForm[0];
                $questions = DB::select("select * from questions where FormId = ?",[$releasedForm->FormId]);
                foreach($questions as $question){
                   // $question->Answers = DB::select("select * from submittedanswers where QuestionId = ? and SubmittedBy = ? and ReleasedFormId = ?",[$question->QuestionId,$userId,$releasedForm->ReleasedFormId]);
                    $question->Answers = DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                    if($question->QuestionType === "Checkbox"){
                        foreach($question->Answers as $answer){
                            $answer->isAnswer = (!empty(DB::select("select * from submittedanswers where QuestionId = ? and SubmittedBy = ? and ReleasedFormId = ? and Answer = ?",[$question->QuestionId,$userId,$releasedForm->ReleasedFormId,$answer->ChoiceDescription])));
                        }
                    }elseif($question->QuestionType === "Radio"){
                        //echo "asdzxc";
                        foreach($question->Answers as $answer){
                            $answer->isAnswer = (!empty(DB::select("select * from submittedanswers where QuestionId = ? and SubmittedBy = ? and ReleasedFormId = ? and Answer = ?",[$question->QuestionId,$userId,$releasedForm->ReleasedFormId,$answer->ChoiceDescription])));
                        }
                    }else{
                        $answer = DB::select("select * from submittedanswers where QuestionId = ? and SubmittedBy = ? and ReleasedFormId = ?",[$question->QuestionId,$userId,$releasedForm->ReleasedFormId]);
                        
                        $question->Answers = $answer;  
                        
                    }
                    
                }
                $response->Questions = $questions;
            }else{
                $response->Message = "Released Form not found";
            }
            echo json_encode($response);
        }
        
        /* if(self::checkRestr()){
            $rfId = $request->input("rfid");
            $userId = $request->input("userId");
            $releasedForm = DB::select("select rf.ReleasedFormId,rf.FormId from releasedforms rf, evaluationtools ev where ev.EvaluationFormId = rf.FormId and rf.ReleasedFormId = ?",[$rfId]);
            
            $response = new \stdClass();
            if(empty($userId)){
                $response->Message = "User ID must exist";
            
            }elseif(!empty($releasedForm)){
                $releasedForm = $releasedForm[0];
                $questions = DB::select("select * from questions where FormId = ?",[$releasedForm->FormId]);
                foreach($questions as $question){
                    $question->Answers = DB::select("select * from submittedanswers where QuestionId = ? and SubmittedBy = ? and ReleasedFormId = ?",[$question->QuestionId,$userId,$releasedForm->ReleasedFormId]);
                    
                }
                $response->Questions = $questions;
            }else{
                $response->Message = "Released Form not found";
            }
            echo json_encode($response);
        }*/
    
    }
    function getAllEvaluationTools(Request $request){

        if(self::checkRestr()){
            $uniId=session('uniId');
            $evaluationTools = array();
            $programTools = array();
            if(session('type') === 'Coordinator'){
                //$evaluationTools = DB::select("select * from evaluationtools where UniId = ?",[$uniId]);
                $programTools = DB::select("select * from evaluationtools e,programs p where p.ProgramId = e.ProgramId and e.UniId = ? and e.ProgramId = ?",[$uniId,session('programId')]);
            }elseif(session('type') === 'Director'){
                $evaluationTools = DB::select("select * from evaluationtools where UniId = ? and ProgramId is null",[$uniId]);
                
                $programTools = DB::select("select * from evaluationtools e,programs p where p.ProgramId = e.ProgramId and e.UniId = ?",[$uniId]);
            }
            //$evaluationTools = DB::select("select * from evaluationtools where UniId = ?",[$uniId]);
            $programs = DB::select("select * from programs where UniversityId = ?",[$uniId]);
            return View('getAllEvaluationTools',["evaluationTools"=>$evaluationTools,"programs"=>$programs,"programTools"=>$programTools]);
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function addEvaluationTool(Request $request){
        if(self::checkRestr()){
            $uniId=session('uniId');
            $toolName=$request->input('toolName');
            $toolDesc=$request->input('toolDesc');
            $programId=$request->input('programId');
            if(!empty($programId)){
                DB::insert("insert into evaluationtools (EvaluationFormName,EvaluationFormDescription,UniId,ProgramId) values (?,?,?,?)",[$toolName,$toolDesc,$uniId,$programId]);
        
            }else{
                echo "wai program id";
                DB::insert("insert into evaluationtools (EvaluationFormName,EvaluationFormDescription,UniId) values (?,?,?)",[$toolName,$toolDesc,$uniId]);
            }
        }else{
            return View('RestrictedAccess');
        }
    }
    function editEvaluationTool(Request $request){
        if(self::checkRestr()){
           $formId=$request->input('formId');
           $formName=$request->input('formName');
           $formDesc=$request->input('formDesc');
            
            DB::update("update evaluationtools set EvaluationFormName=?,EvaluationFormDescription=? where EvaluationFormId=?",[$formName,$formDesc,$formId]);
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function deleteEvaluationTool(Request $request){
        if(self::checkRestr()){
           $id=$request->input('id');
            DB::delete("delete from evaluationtools where EvaluationFormId=?",[$id]);
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function getEvaluationTool(Request $request){
        if(self::checkRestr()){
           $id=$request->input("id"); 
           $uniId=session('uniId');
           $evaluationTool=DB::select("select * from evaluationtools where EvaluationFormId=?",[$id]);
            if(sizeof($evaluationTool)>0){
                $evaluationTool=$evaluationTool[0];
                $evaluationTool->Questions=DB::select("select * from questions where FormId = ?",[$evaluationTool->EvaluationFormId]);
                
                foreach($evaluationTool->Questions as $question){
                    $question->Choices=DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                }
                
                $checkIfReleased=DB::select("select count(ReleasedFormId) as Count from releasedforms where FormId = ?",[$id]);
                $checkIfReleased = $checkIfReleased[0];
                if($evaluationTool->UniId===$uniId){
                    return View('getEvaluationTool',['evaluationTool'=>$evaluationTool,'checkIfReleased'=>$checkIfReleased]);
                }else{
                    return View('RestrictedAccess');
                }
            }else{
                echo "evaluation tool not found";
            }
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function addQuestion(Request $request){
        if(self::checkRestr()){
           $formId=$request->input('formId');
           $questionType=$request->input('questionType');
           $question=$request->input('question');
            DB::insert("insert into questions (Question,QuestionType,FormId) values (?,?,?)",[$question,$questionType,$formId]);
            $question=DB::select("select max(QuestionId) as QuestionId from questions");
 
            $lastQuestionId=$question[0]->QuestionId;
 
            $choices=$request->input('choice');
            if($questionType!=='Open'){
                foreach($choices as $choice){
                    if(trim($choice)!==''){
                        DB::insert("insert into choices (ChoiceDescription,QuestionId) values (?,?)",[$choice,$lastQuestionId]);
                    }
                }
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function deleteQuestion(Request $request){
        if(self::checkRestr()){
           $id=$request->input('id');
            DB::delete("delete from questions where QuestionId=?",[$id]);
            DB::delete("delete from choices where QuestionId=?",[$id]);
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function editQuestion(Request $request){
        if(self::checkRestr()){
           echo "naa here";
            $questionId=$request->input('questionId');
            $question=$request->input('question');
            $choice=$request->input('choice');
            DB::update("update questions set Question=? where QuestionId=?",[$question,$questionId]);
            DB::delete("delete from choices where QuestionId=?",[$questionId]);
            if(!empty($choice)){
                foreach($choice as $c){
                    if(trim($c)!==''){
                        DB::insert("insert into choices (ChoiceDescription,QuestionId) values (?,?)",[$c,$questionId]);
                    }
                }
            }
            
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function getQuestion(Request $request){
        if(self::checkRestr()){
           $id=$request->input('id');
            $question=DB::select("select * from questions where QuestionId=?",[$id]);
            if(sizeof($question)>0){
                $question=$question[0];
                $question->Choices=DB::select("select * from choices where QuestionId=?",[$id]);
                
                $question=json_encode($question);
                echo $question;
            }else{
                echo "Question not found";
            }
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function assignEvaluationTool(Request $request){
        if(self::checkRestr()){
           $activityId=$request->input("activityId");
           $formId=$request->input("formId");
           $fromDate=$request->input("fromDate");
           $toDate=$request->input("toDate");
           $answeredBy=$request->input("answeredBy");
            $involved = null;
                switch($answeredBy){
                    case "Student Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$activityId,1,"Student"]);
                        break;
                    case "Faculty Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$activityId,1,"Faculty"]);
                        break;
                    case "External Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$activityId,1,"External"]);
                        break;
                    case "Beneficiaries":
                        $involved = DB::select("select * from beneficiaries v where v.ProgramId = ? and v.BenStatus = ? and v.Type <> ?",[$activityId,1,"Leader"]);
                        break;
                    case "Leaders":
                        $involved = DB::select("select * from beneficiaries v where v.ProgramId = ? and v.BenStatus = ? and v.Type = ?",[$activityId,1,"Leader"]);
                        break;
                }
            DB::insert("insert into releasedforms (ActivityId,FormId,FromDate,ToDate,ToBeAnsweredBy) values (?,?,?,?,?)",[$activityId,$formId,$fromDate,$toDate,$answeredBy]);
            $releasedForm = DB::select("select max(ReleasedFormId) as 'maxId' from releasedforms");
            $releasedForm = $releasedForm[0];
            $activity=DB::select("select * from activities where ActivityId = ?",[$activityId]);
            if(!empty($involved))
            foreach($involved as $user){
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",["A new Evaluation Tool has been released for ".$activity[0]->ActivityName,"fillUpEvaluationForm?relfId=".$releasedForm->maxId,"Registered User",$user->AccountId]);
            }
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function manageUserAccounts(Request $request){
        if(self::checkRestr()){
           $uniId = session("uniId");
           $myVolunteers = array();
            if(session("type") === "Coordinator"){
                //$myVolunteers = DB::select("select act.ActivityId as ActivityId,acc.Name as Name, acc.LastName as LastName,act.ActivityName from accounts acc,volunteers vol,activities act,projects pro where pro.ProjectId = act.ProjectId and act.ActivityId = vol.ProgramId and vol.AccountId = acc.AccountId and pro.Status = ? and act.ActivityStatus = ? and vol.VolunteerStatus = ? and pro.Level = ? and pro.ProgramId = ?",["Approved","Approved",1,"Program",session("programId")]);
                $myVolunteers = DB::select("select acc.AccountId as AccountId,acc.Name as Name, acc.LastName as LastName,count(vol.VolunteerId) as ActivityCount from accounts acc,volunteers vol,activities act,projects pro where pro.ProjectId = act.ProjectId and act.ActivityId = vol.ProgramId and vol.AccountId = acc.AccountId and pro.Status = ? and act.ActivityStatus = ? and vol.VolunteerStatus = ? and pro.Level = ? and pro.ProgramId = ? group by acc.AccountId, acc.Name, acc.LastName",["Approved","Approved",1,"Program",session("programId")]);

            }
            $uniUsers = DB::select("select * from accounts where UniversityId = ? order by AccountType,LastName desc",[$uniId]);
            $coordinators = DB::select("select * from coordinators c,accounts a,programs p where p.ProgramId = c.Programid and c.AccountId= a.AccountId and p.UniversityId = ?",[$uniId]);
            $programs = DB::select("select * from programs p where p.UniversityId = ?",[$uniId]);
            return View("manageUserAccounts",["uniUsers" => $uniUsers,"coordinators"=>$coordinators,"programs"=>$programs,"myVolunteers"=>$myVolunteers]);
        }else{
            return View('RestrictedAccess');
        }
    }
    function addApprovedParticipants(Request $request){
        if(self::checkRestr()){
            $volIds = $request["volIds"];
            $benIds = $request["benIds"];

            if(!empty($volIds)){
                foreach($volIds as $volId){
                    $volunteer = DB::select("select * from volunteers where VolunteerId = ?",[$volId]);
                    DB::update("update volunteers set VolunteerStatus = ?,ApprovedDate=? where VolunteerId = ?",[1,date('Y-m-d'),$volId]);

                }
            }
            if(!empty($benIds)){
                foreach($benIds as $benId){
                    $beneficiary = DB::select("select * from beneficiaries where BeneficiaryId = ?",[$benId]);
                    DB::update("update beneficiaries set BenStatus = ?,ApprovedDate=? where BeneficiaryId = ?",[1,date('Y-m-d'),$benId]);
                }
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function addVolunteers(Request $request){
        if(self::checkRestr()){
            $activityId = $request->input("activityId");
            $accIds = $request->input("accIds");
            $activity = DB::select("select * from activities where ActivityId = ?",[$activityId]);
            if(empty($activity)){
                echo "Activity not found";
                
                return;
            }
            $activity=$activity[0];
            $status = 1;
            $counter = 0;
            if($accIds!==null&&sizeof($accIds)>0){
                foreach($accIds as $acc){
                    if($request->input($acc."Type")==="Volunteer - Faculty"){
                        $type="Faculty";
                    }else{
                        $type="Student";
                    }
                    DB::insert("insert into volunteers (ProgramId,AccountId,VolunteerStatus,Type,ApprovedDate) values (?,?,?,?,?)",[$activityId,$acc,$status,$type,date("Y-m-d")]);
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["You have been enlisted as ".$type." Volunteer of the ".$activity->ActivityName."Activity","getActivityPage?id=".$activityId,"Registered User",$acc]);
                    $counter++;
                }
                echo ($counter === 1 ? 'Volunteer has':'All '.$counter.' Volunteers have').' been Added';
            }else{
                echo "None Selected";
            }
            //return back();

        }else{
            return View('RestrictedAccess');
        }
    }
    function deletePendingParticipants(Request $request){
        if(self::checkRestr()){
            $volIds = $request["volIds"];
            $benIds = $request["benIds"];

            if(!empty($volIds))
            foreach($volIds as $volId){
                DB::delete("delete from volunteers where VolunteerId = ?",[$volId]);
            }
            if(!empty($benIds))
            foreach($benIds as $benId){
                DB::delete("delete from beneficiaries where BeneficiaryId = ?",[$benId]);
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    function addBeneficiaries(Request $request){
        if(self::checkRestr()){
            $activityId = $request->input("activityId");
            $accIds = $request->input("accIds");
            $status = 1;
            $counter = 0;
            $activity = DB::select("select * from activities where ActivityId = ?",[$activityId]);
            if(empty($activity)){
                echo "Activity not found!";
                return;
            }
            $activity=$activity[0];
            if($accIds!==null&&sizeof($accIds)>0){
                foreach($accIds as $acc){
                    
                    if($request->input($acc."Type")==="Beneficiary - Leader"){
                        $type="Leader";
                    }else{
                        $type="Member";
                    }
                    
                    DB::insert("insert into beneficiaries (ProgramId,AccountId,BenStatus,Type,ApprovedDate) values (?,?,?,?,?)",[$activityId,$acc,$status,$type,date("Y-m-d")]);
                    DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values(?,?,?,?)",["You have been enlisted as a ".$request->input($acc.'Type')." for the ".$activity->ActivityName." Activity","getActivityPage?id=".$activityId,"Registered User",$acc]);
                    $counter++;
                    
                }
                echo ($counter === 1 ? 'Beneficiary has':'All '.$counter.' Beneficiaries have').' been Added';
            
            }else{
                echo "None Selected";
            }
            //DB::insert("insert into activities");
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }


    
    function manageAttendance(Request $request){
        if(self::checkRestr()){
            $actId = $request->input("ai");
            $activity=DB::select("select * from activities where ActivityId = ?",[$actId]);
            if(!empty($activity)){
                $activity = $activity[0];
            }else{
                echo "activity not found";
                return;
            }
            
            /*$schedules = DB::select("select * from schedules where ProgramId = ?",[$actId]);
            print_r($schedules);
            
            $volunteers = DB::select("select * from volunteers v,accounts a where a.AccountId = v.AccountId and v.ProgramId = ?",[$actId]);
            foreach($volunteers as $volunteer){
            
            }*/
            $distinctDates = DB::select("select distinct(SchedDate) from schedules where ProgramId = ? order by SchedDate asc",[$actId]);
            //$distinctDates = DB::select("select (SchedDate) from schedules where ProgramId = ? order by SchedDate asc",[$actId]);
            $volunteers = DB::select("select * from volunteers v,Accounts a where a.AccountId = v.AccountId and v.ProgramId = ? and v.VolunteerStatus = 1",[$actId]);
            
            $i=0;
            foreach($volunteers as $volunteer){
                $sample = array();
                foreach($distinctDates as $d){
                    $copyofob = clone $d;
                    array_push($sample,$copyofob);   
                }
                $volunteer->AttendanceDates = $sample;
            }
            $i=0;
            $finalVol = array();
            foreach($volunteers as $volunteer){
                foreach($volunteer->AttendanceDates as $date){
                    $record = new \stdClass();
                    $record = DB::select("select * from volunteerattendances where VolunteerId = ? and AttendanceDate = ?",[$volunteer->VolunteerId,$date->SchedDate]);
                    
                    $copy_of_record = array();
                    foreach($record as $r){
                        array_push($copy_of_record,$r);     
                    }
                   $date->Record = $copy_of_record;
                }
                array_push($finalVol,$volunteer);
            }
            
            
            $beneficiaries = DB::select("select * from beneficiaries b,Accounts a where a.AccountId = b.AccountId and b.ProgramId = ? and b.BenStatus = 1",[$actId]);
            
            $i=0;
            foreach($beneficiaries as $beneficiary){
                $sample = array();
                foreach($distinctDates as $d){
                    $copyofob = clone $d;
                    array_push($sample,$copyofob);   
                }
                $beneficiary->AttendanceDates = $sample;
            }
            $i=0;
            $finalBen = array();
            foreach($beneficiaries as $beneficiary){
                foreach($beneficiary->AttendanceDates as $date){
                    $record = new \stdClass();
                    $record = DB::select("select * from beneficiaryattendances where BeneficiaryId = ? and AttendanceDate = ?",[$beneficiary->BeneficiaryId,$date->SchedDate]);
                    
                    $copy_of_record = array();
                    foreach($record as $r){
                        array_push($copy_of_record,$r);     
                    }
                   $date->Record = $copy_of_record;
                }
                array_push($finalBen,$beneficiary);
            }
            
            
            return View('getActivityAttendance',["activity"=>$activity,"distinctDates"=>$distinctDates,"volunteers"=>$finalVol,"beneficiaries"=>$finalBen]);
        }else{
            return View('RestrictedAccess');
        }
    }
    function addAttendanceRecords(Request $request){
        if(self::checkRestr() || !empty($request->input("isMobile"))){
            $actId = $request->input("ai");
            $date = $request->input("date");
            $date = date("Y-m-d", strtotime($date));
            $volIds = $request->input("volIds");
            foreach($volIds as $volunteer){

                DB::delete("delete from volunteerattendances where AttendanceDate = ? and VolunteerId = ?",[$date,$volunteer]);
                DB::insert("insert into volunteerattendances (AttendanceDate,VolunteerId,Status) values (?,?,?)",[$date,$volunteer,$request->input($volunteer."Status")]);
            
            }
            
            
        }else{
            return View('RestrictedAccess');
        }
    }
    function editAttendanceRecords(Request $request){
        if(self::checkRestr()){
            $actId = $request->input("ai");
            $date = $request->input("date");
            $type = $request->input('type');
            if($type==="volunteer"){
                $volunteers = DB::select("select * from volunteers where ProgramId =  ? and VolunteerStatus = ?",[$actId,1]);
                foreach($volunteers as $volunteer){
                    $volAttendance = DB::select("select * from volunteerattendances where VolunteerId = ? and AttendanceDate = ?",[$volunteer->VolunteerId,$date]);
                    if(!empty($request->input($volunteer->VolunteerId."-attendance"))){
                        $status = "Present";  
                    }else{  
                        $status = "Absent";
                    }
                    if(!empty($volAttendance)){
                        DB::update("update volunteerattendances set Status = ? where VolunteerId = ? and AttendanceDate = ?",[$status,$volunteer->VolunteerId,$date]);
                        
                    }else{
                        DB::insert("insert into volunteerattendances (AttendanceDate,VolunteerId,Status) values (?,?,?)",[$date,$volunteer->VolunteerId,$status]);
                    }
                }
            }else{
                $beneficiaries = DB::select("select * from beneficiaries where ProgramId =  ? and BenStatus = ?",[$actId,1]);
                foreach($beneficiaries as $beneficiary){
                    $benAttendance = DB::select("select * from beneficiaryattendances where BeneficiaryId = ? and AttendanceDate = ?",[$beneficiary->BeneficiaryId,$date]);
                    if(!empty($request->input($beneficiary->BeneficiaryId."-attendance"))){
                        $status = "Present";  
                    }else{  
                        $status = "Absent";
                    }
                    if(!empty($benAttendance)){
                        DB::update("update beneficiaryattendances set Status = ? where BeneficiaryId = ? and AttendanceDate = ?",[$status,$beneficiary->BeneficiaryId,$date]);
                    }else{
                        DB::insert("insert into beneficiaryattendances (AttendanceDate,BeneficiaryId,Status) values (?,?,?)",[$date,$beneficiary->BeneficiaryId,$status]);
                    }

                }
                
            }
            return back();
            
        }else{
            return View('RestrictedAccess');
        }
    }
    function getResults(Request $request){
        if(self::checkRestr()){
            $releasedFormId = $request->input("rfid");
            $releasedForm = DB::select("select * from releasedforms r, evaluationtools f, activities a where a.ActivityId = r.ActivityId and f.EvaluationFormId = r.FormId and  r.ReleasedFormId = ?",[$releasedFormId]);
            
            if(!empty($releasedForm)){
                $releasedForm = $releasedForm[0];
                $releasedForm->Questions = DB::select("select * from questions where FormId = ?",[$releasedForm->FormId]);
                
                
                foreach($releasedForm->Questions as $question){
                    $choices = DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                    $question->Choices = $choices;
                }
                
                foreach($releasedForm->Questions as $question){
                    if($question->QuestionType === "Open"){
                        $question->Answers = DB::select("select * from submittedanswers s where s.ReleasedFormId = ? and s.QuestionId = ?",[$releasedFormId,$question->QuestionId]);
                    }else{
                        foreach($question->Choices as $choice){
                            $tally=DB::select("select * from submittedanswers s where s.ReleasedFormId = ? and s.QuestionId = ? and s.Answer = ?",[$releasedFormId,$question->QuestionId,$choice->ChoiceDescription]);
                            if($question->QuestionType !== "Open"){
                                $choice->Tally = sizeof($tally);
                            }
                        }
                    }
                }
                /*foreach($releasedForm->Questions as $question){
                    echo $question->Question;
                    if($question->QuestionType === "Open"){
                       print_r($question->Answers);
                    }else{
                        foreach($question->Choices as $choice){
                            echo $choice->ChoiceDescription."<br>";
                        print_r($choice->Tally);
                            echo "<br>";
                            
                        }
                    }
                    
                    echo "<br>";
                }
                print_r($releasedForm);*/
                $json=json_encode($releasedForm);
                $respondents = DB::select("select a.AccountId as AccountId,a.Name as Name,a.LastName as LastName from submittedanswers s,accounts a where a.AccountId = s.SubmittedBy and s.ReleasedFormId = ? group by  a.AccountId,a.Name,a.LastName",[$releasedForm->ReleasedFormId]);
                return View('getResults',["releasedForm"=>$releasedForm,"respondents"=>$respondents])->with('json',json_decode($json,true));
                
            }else{
                $message = "Released Form does not Exists";
                return View('notFound',["message"=>$message]);
        
            }
        }else{
            return View('RestrictedAccess');
        }
    }
    
    function getReleasedForm(Request $request){
        if(self::checkRestr()){
            $rfId=$request->input("rfId");
            $releasedForm = DB::select("select * from releasedforms where ReleasedFormId = ?",[$rfId]);
            $response=null;
            if(!empty($releasedForm)){
                $response=$releasedForm[0];
            }
            echo json_encode($response);
        }else{
            return View('RestrictedAccess');
        }
    }
        
    function editReleasedForm(Request $request){
        if(self::checkRestr()){
            $rfId=$request->input("rfId");
            $releasedForm = DB::select("select * from releasedforms where ReleasedFormId = ?",[$rfId]);
            
            $releasedForm = $releasedForm[0];
            
            $fromDate=$request->input("fromDate");
            $toDate=$request->input("toDate");
            $for=$request->input("for");
            $involved=array();
                switch($for){
                    case "Student Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$releasedForm->ActivityId,1,"Student"]);
                        break;
                    case "Faculty Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$releasedForm->ActivityId,1,"Faculty"]);
                        break;
                    case "External Volunteers":
                        $involved = DB::select("select * from volunteers v where v.ProgramId = ? and v.VolunteerStatus = ? and v.Type = ?",[$releasedForm->ActivityId,1,"External"]);
                        break;
                    case "Beneficiaries":
                        $involved = DB::select("select * from beneficiaries v where v.ProgramId = ? and v.BenStatus = ? and v.Type <> ?",[$releasedForm->ActivityId,1,"Leader"]);
                        break;
                    case "Leaders":
                        $involved = DB::select("select * from beneficiaries v where v.ProgramId = ? and v.BenStatus = ? and v.Type = ?",[$releasedForm->ActivityId,1,"Leader"]);
                        break;
                }
            print_r($involved);
            //DB::update("update releasedforms set FromDate = ?, ToDate = ?, ToBeAnsweredBy = ? where ReleasedFormId = ?",[$fromDate,$toDate,$for,$rfId]);
            //return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    function deleteReleasedForm(Request $request){
        if(self::checkRestr()){
            $rfId=$request->input("rfId");
            echo $rfId;
            DB::delete("delete from submittedanswers where ReleasedFormId = ?",[$rfId]);
            DB::delete("delete from releasedforms where ReleasedFormId = ?",[$rfId]);
            return back();
            /*$fromDate=$request->input("fromDate");
            $toDate=$request->input("toDate");
            $for=$request->input("for");
            DB::update("update releasedforms set FromDate = ?, ToDate = ?, ToBeAnsweredBy = ? where ReleasedFormId = ?",[$fromDate,$toDate,$for,$rfId]);
            return back();*/
        }else{
            return View('RestrictedAccess');
        }
    }
    
        
    function addSponsor(Request $request){
        if(self::checkRestr()){
            $sponsorId=$request->input('sponsorId');
            $activityId=$request->input('activityId');
            
            if(empty($sponsorId)){
                $sponsorName=$request->input('sponsorName');
                $sponsorAddress=$request->input('sponsorAddress');
                $sponsorContactNumber=$request->input('sponsorContactNumber');
                
                DB::insert("INSERT INTO sponsors (SponsorName, SponsorAddress, SponsorContactNo) VALUES ( ?, ?, ?);",[$sponsorName,$sponsorAddress,$sponsorContactNumber]);
                
                $lastId = DB::getPdo()->lastInsertId();
                DB::insert("INSERT INTO activitysponsors (SponsorId,ActivityId) VALUES ( ?, ?);",[$lastId,$activityId]);
                
                
            }else{
                echo "add daan";
                DB::insert("INSERT INTO activitysponsors (SponsorId,ActivityId) VALUES ( ?, ?);",[$sponsorId,$activityId]);
                
            }
            return back();
        }else{
            return View('RestrictedAccess');
        }
    }
    
        
    function deleteActivitySponsor(Request $request){
        if(self::checkRestr()){
            $actSponsId=$request->input('actSponsId');
            
            DB::delete('DELETE FROM activitysponsors where ActivitySponsorId = ?',[$actSponsId]);
            
            return back();
            
        }else{
            return View('RestrictedAccess');
        }
    }
    function viewPendingProposals(Request $request){
        if(self::checkRestr()){
            $myPendingProjects = array();
            $myPendingActivities = array();
            $myApprovedProjects = array();
            $myApprovedActivities = array();
            $allProjects = array();
            $allActivities = array();

            if(session('type')==="Director"){
                $myPendingProjects = DB::select("select * from projects pj,programs pg where pg.ProgramId = pj.ProgramId and pg.UniversityId = ? and pj.Status <> ?",[session('uniId'),'Approved']);
                $myPendingActivities = DB::select("select * from projects pj,programs pg,activities ac where pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and pg.UniversityId = ? and ac.ActivityStatus <> ?",[session('uniId'),'Approved']);
                
                //$allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,max(sc.SchedDate) as SchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and ((pj.Level = ? and pj.ProgramId = ?) or (pj.Level = ? and pj.ProgramId in (select pgg.ProgramId from programs pgg where pgg.UniversityId=?))) group by  pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName order by SchedDate desc",["Approved","Approved","Institution",session('uniId'),"Program",session('uniId')]);
                
                //$allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,max(sc.SchedDate) as MaxSchedDate,min(sc.SchedDate) as MinSchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and ((pj.Level = ? and pj.ProgramId = ?) or (pj.Level = ? and pj.ProgramId in (select pgg.ProgramId from programs pgg where pgg.UniversityId=?))) group by  pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName order by sc.SchedDate desc",["Approved","Approved","Institution",session('uniId'),"Program",session('uniId')]);
                $allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,max(sc.SchedDate) as MaxSchedDate,min(sc.SchedDate) as MinSchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and ((pj.Level = ? and pj.ProgramId = ?) or (pj.Level = ? and pj.ProgramId in (select pgg.ProgramId from programs pgg where pgg.UniversityId=?))) group by  pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName order by MaxSchedDate desc",["Approved","Approved","Institution",session('uniId'),"Program",session('uniId')]);
                
                $allProjects = DB::select("select * from projects pj,programs pg where pj.ProgramId = pg.ProgramId and pj.Status = 'Approved' and ((pj.Level = 'Institution' and pj.ProgramId = ?)||(pj.Level = 'Program' and pj.ProgramId in (select ProgramId from programs where UniversityId = ?))) order by pj.ProjectId desc",[session('uniId'),session('uniId')]);
                
            }elseif(session('type')==="Coordinator"){
                $myPendingProjects = DB::select("select * from projects pj,programs pg where pg.ProgramId = pj.ProgramId and pg.ProgramId = ? and Status <> ?",[session('programId'),'Approved']);
                
                $myPendingActivities = DB::select("select * from activities a,projects p,programs r where r.ProgramId = p.ProgramId and p.ProjectId = a.ProjectId and p.ProgramId = ? and a.ActivityStatus <> ?",[session('programId'),'Approved']);
                
                //$allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,sc.SchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and pj.Level = ? and pj.ProgramId = ? order by sc.SchedDate desc",["Approved","Approved","Program",session('programId')]);
                $allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,max(sc.SchedDate) as MaxSchedDate,min(sc.SchedDate) as MinSchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and pj.Level = ? and pj.ProgramId = ?  group by  pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName order by MaxSchedDate desc",["Approved","Approved","Program",session('programId')]);

                //$allActivities = DB::select("select pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName,max(sc.SchedDate) as MaxSchedDate,min(sc.SchedDate) as MinSchedDate from projects pj,activities ac,schedules sc where pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status=? and ac.ActivityStatus=? and ((pj.Level = ? and pj.ProgramId = ?) or (pj.Level = ? and pj.ProgramId in (select pgg.ProgramId from programs pgg where pgg.UniversityId=?))) group by  pj.ProjectId,pj.Banner,pj.ProjectName,ac.ActivityId,ac.ActivityName order by sc.SchedDate desc",["Approved","Approved","Program",session('uniId'),"Program",session('uniId')]);
                
                $allProjects = DB::select("select * from projects p,programs g where p.ProgramId = g.ProgramId and p.Level = 'Program' and p.Status = 'Approved' and g.ProgramId = ? order by p.ProjectId desc",[session("programId")]);
            }
            return View('viewPendingProposals',["myPendingProjects"=>$myPendingProjects,"myPendingActivities"=>$myPendingActivities,"allActivities"=>$allActivities,"allProjects"=>$allProjects]);
        }else{
            return View('RestrictedAccess');
        }
    }
    function printToolResults(Request $request){
        if(self::checkRestr()){
            $myPendingProjects = array();
            $releasedFormId = $request->input("rfid");
            $releasedForm = DB::select("select * from releasedforms r, evaluationtools f, activities a where a.ActivityId = r.ActivityId and f.EvaluationFormId = r.FormId and  r.ReleasedFormId = ?",[$releasedFormId]);
            
            if(!empty($releasedForm)){
                $releasedForm = $releasedForm[0];
                $releasedForm->Questions = DB::select("select * from questions where FormId = ?",[$releasedForm->FormId]);
                
                
                foreach($releasedForm->Questions as $question){
                    $choices = DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                    $question->Choices = $choices;
                }
                
                foreach($releasedForm->Questions as $question){
                    if($question->QuestionType === "Open"){
                        $question->Answers = DB::select("select * from submittedanswers s where s.ReleasedFormId = ? and s.QuestionId = ?",[$releasedFormId,$question->QuestionId]);
                    }else{
                        foreach($question->Choices as $choice){
                            $tally=DB::select("select * from submittedanswers s where s.ReleasedFormId = ? and s.QuestionId = ? and s.Answer = ?",[$releasedFormId,$question->QuestionId,$choice->ChoiceDescription]);
                            if($question->QuestionType !== "Open"){
                                $choice->Tally = sizeof($tally);
                            }
                        }
                    }
                }
                $json=json_encode($releasedForm);
                return View('printToolResults',["releasedForm"=>$releasedForm])->with('json',json_decode($json,true));
                
            }else{
                echo "releasedform not found";
            }
        }else{
            return View('RestrictedAccess');
            
        }
    }
    
}
