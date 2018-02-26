<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MobileController extends Controller
{
    //
    function mobileLogin(Request $request){
        /*$username = $request->input("username");
        $response = new \stdClass();
        $user = DB::select("select * from Accounts where Username = ?",[$username]);
        if(!empty($user)){
            $response = $user[0];
            $checkIfCoord = DB::select("select * from coordinators where AccountId = ? and isActive = 1",[$response->AccountId]);
            if(sizeof($checkIfCoord)>0){
                $response->Type="Coordinator";
            }else{
                $response->Type="Registered User";
            }
        }else{
            $response->Message = "Not Found";
                
        }
        echo json_encode($response);*/
        $username = $request->input("username");
        $password = $request->input("password");
        $response = new \stdClass();
        $user = DB::select("select * from Accounts where Username = ?",[$username]);
        if(!empty($user)){
            $response = $user[0];
            $checkIfCoord = DB::select("select * from coordinators where AccountId = ? and isActive = 1",[$response->AccountId]);
            if(sizeof($checkIfCoord)>0){
                $response->Type="Coordinator";
            }else{
                $response->Type="Registered User";
            }
        }else{
            $user =DB::select("select * from subscribers s,universities u where s.SubscriberId = u.SubscriberId and s.Username = ?",[$username]);
            if(!empty($user)){
                $user=$user[0];
                $response->AccountId = $user->SubscriberId;
                $response->UniversityId = $user->UniId;
                $response->Type = "Director";
                $response->Username = $user->Username;
                $response->Name = $user->ExtensionHeadName;
                $response->LastName = '';
                $response->Password = $user->Password;
                $response->ContactNumber = $user->ContactNumber;
                $response->Address = $user->Address;
                $response->EmailAddress = $user->EmailAddress;
                $response->DisplayPic = "../logos/".$user->UniLogo;
                $response->Gender = '-';

            }else{
                $response->Message = "Not Found";
            }
        }
        if(!empty($response->Password)){
            if($password === $response->Password){
                echo json_encode($response);
            }else{
                $response = new \stdClass();
                $response ->Message = "Username and password mismatch";
                echo json_encode($response);
            }
        }else{
            echo json_encode($response);
        }
    }
    
    function mobileAttendance(Request $request){
        $actId = $request->input('actId');
        $date = $request->input('date');
        
        $distinctDates = DB::select("select distinct(SchedDate) from schedules where ProgramId = ?",[$actId]);
            
        $activity = DB::select("select * from activities a where a.ActivityId = ?",[$actId]);
        $activity=$activity[0];
        $activity->Volunteers = DB::select("select * from volunteers v, accounts a where a.AccountId = v.AccountId and v.ProgramId = ?",[$activity->ActivityId]);
        $activity->DistinctDates=$distinctDates;
        foreach($activity->Volunteers as $volunteer){
            $attRecord = DB::select("select * from volunteerattendances v where v.AttendanceDate = ? and v.VolunteerId = ?",[$date,$volunteer->VolunteerId]);
            if(!empty($attRecord)){
                $volunteer->Status = $attRecord[0]->Status;
            }else{
                $volunteer->Status = "no record";
            }
            
        }
        echo json_encode($activity);
    }
    
    function getUniversityDetails(Request $request){
        $uniId = $request->input('uniId');
        $university = DB::select("select * from universities where UniId = ?",[$uniId]);
        
        if(!empty($university)){
            $university = $university[0];
            $university->Announcements = DB::select("select * from posts  where UniId = ? order by PostId desc",[$uniId]);
        }
        echo json_encode($university);
    }
    function fillUpReleasedForm(Request $request){
        $refId = $request->input('refId');
        $releasedForm = new \stdClass();
        $error = new \stdClass();
        $releasedForm = DB::select("select * from releasedforms r,evaluationtools e,activities a where a.ActivityId = r.ActivityId and e.EvaluationFormId = r.FormId and r.ReleasedFormId = ?",[$refId]);
        if(!empty($releasedForm)){
            $releasedForm = $releasedForm[0];
            $currentDate = date('Y-m-d');
            if($releasedForm->FromDate <= $currentDate && $releasedForm->ToDate >= $currentDate){
                $releasedForm->Questions=DB::select("select * from questions where formid=?",[$releasedForm->FormId]);
                foreach($releasedForm->Questions as $question){
                    $question->Choices = DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                }
                echo json_encode($releasedForm);
            }else{
                $error->Message = "Cannot fill up form";
                $error->ActivityName = $releasedForm->ActivityName;
                $error->EvaluationFormName = $releasedForm->EvaluationFormName;
                $error->ReleasedFormId = $releasedForm->ReleasedFormId;
                echo json_encode($error);
            }
           // echo date('Y-m-d');
        }else{
            //$releasedForm->Message="Released Form not found";
            $error->Message = "Released Form not found";
            $error->ActivityName = "Not Found";
            $error->EvaluationFormName = "Not Found";
            $error->ReleasedFormId = -1;
            echo json_encode($error);
        
        }
        
    }
    
    function getMobileNotifications(Request $request){
        $username=$request->input('username');
        $recipientType=$request->input('recipientType');
        $account=DB::select("select * from accounts where Username=?",[$username]);
        $notifications=null;
        if(!empty($account)){
            $account=$account[0];
            $notifications = DB::select("select * from notifications where RecipientId=? and Recipient = ? and Status = ? order by NotificationId desc",[$account->AccountId,$recipientType,0]);
        }else{
            $account = DB::select("select * from subscribers where username = ?",[$username]);
            if(!empty($account)){
                $account = $account[0];
                $notifications = DB::select("select * from notifications where RecipientId=? and Recipient = ? and Status = ? order by NotificationId desc",[$account->SubscriberId,$recipientType,0]);
            }else{
                echo "Account not found";
            }
        }
        echo json_encode($notifications);
        
    }
    function getCoordinatorsActivities(Request $request){
        $username=$request->input('username');
        $recipientType=$request->input('recipientType');
        $account=DB::select("select * from accounts where Username=?",[$username]);
        $notifications=null;
        $activities = array();
            
        if(!empty($account)){
            $account=$account[0];
            //checking if coordinator
            $coordinator = DB::select("select * from coordinators where AccountId=? and isActive = ?",[$account->AccountId,1]);
            if(sizeof($coordinator)>0){
                $coordinator=$coordinator[0];
                $upcomingAsCoo = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Program",$coordinator->ProgramId]);
                    foreach($upcomingAsCoo as $uc){
                        $activity = new \stdClass();
                        $activity = $uc;
                        $activity->As = "Coordinator";
                        array_push($activities,$activity);
                    }
            }

            $upcomingAsVol = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from volunteers v, activities a,projects p,schedules s where v.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and v.AccountId = ? and s.SchedDate >= ? and v.VolunteerStatus group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$account->AccountId,date("Y-m-d"),1]);
            $upcomingAsBen = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from beneficiaries b, activities a,projects p,schedules s where b.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and b.AccountId = ? and s.SchedDate >= ? and b.BenStatus = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$account->AccountId,date("Y-m-d"),1]);
            foreach($upcomingAsVol as $uv){
                $activity = new \stdClass();
                $activity = $uv;
                $activity->As = "Volunteer";
                array_push($activities,$activity);
            }
            foreach($upcomingAsBen as $ub){
                $activity = new \stdClass();
                $activity = $ub;
                $activity->As = "Beneficiary";
                array_push($activities,$activity);
            }
            echo json_encode($activities);
        }else{
            $account = DB::select("select * from subscribers s,universities u where s.SubscriberId = u.SubscriberId and s.Username=?",[$username]);
            if(!empty($account)){
                $account = $account[0];
                //start sa if subscriber and institutionLevel
                $upcomingAsCooInst = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Institution",$account->UniId]);
                foreach($upcomingAsCooInst as $uc){
                    $activity = new \stdClass();
                    $activity = $uc;
                    $activity->As = "Coordinator";
                    array_push($activities,$activity);
                }
                //print_r($account);
                //start sa if subscriber and programLevel
                //$upcomingAsCooProg = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate > ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Institution",$account->UniId]);
                $upcomingAsCooProg = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s,programs g where g.ProgramId = p.ProgramId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Program",$account->UniId]);
                
                //print_r($upcomingAsCooProg);
                foreach($upcomingAsCooProg as $uc){
                    $activity = new \stdClass();
                    $activity = $uc;
                    $activity->As = "Coordinator";
                    array_push($activities,$activity);
                }
                
                echo json_encode($activities);
            }else{
                $res = new \stdClass();
                $res->Message = "Account not found";
                echo json_encode($res);
            }
        }
        /*
        $username=$request->input('username');
        $recipientType=$request->input('recipientType');
        $account=DB::select("select * from accounts where Username=?",[$username]);
        $notifications=null;
        if(!empty($account)){
            $account=$account[0];
            $coordinator = DB::select("select * from coordinators where AccountId=? and isActive = ?",[$account->AccountId,1]);
            
            if(sizeof($coordinator)>0){
                $coordinator=$coordinator[0];
                $activities = DB::select("select * from activities a,projects j,programs p where p.ProgramId = ? and p.ProgramId = j.Programid and a.ProjectId = j.ProjectId and a.ActivityStatus = ? and j.Status = ? and j.Level = ?",[$coordinator->ProgramId,'Approved','Approved','Program']);

            }else{
                
                $activities = DB::select("select * from activities a,projects j,programs p,volunteers v where v.AccountId = ? and v.ProgramId = a.ActivityId and p.ProgramId = j.Programid and a.ProjectId = j.ProjectId and a.ActivityStatus = ? and j.Status = ? and j.Level = ?",[$account->AccountId,'Approved','Approved','Program']);

            }
            echo json_encode($activities);
        }else{
            
        }
        */
        
    }
    
    function addAnnouncementMobile(Request $request){
        $username=$request->input('username');
        $announcement=$request->input('announcement');
        $account=DB::select("select * from accounts where Username=?",[$username]);
        if(!empty($account)){
            $account=$account[0];
            print_r($account);
            DB::insert("insert into posts (UniId,PostDescr,PostedBy,PosterDP) values(?,?,?,?)",[$account->UniversityId,$announcement,$account->Name.' '.$account->LastName,$account->DisplayPic]);
            
        }else{
        }
        
    }
    
    
    
    
    function getProjectsHistorySummary(Request $request){
       
            
            
            $id = session('uniId');
            $projects = DB::select("select * from projects pj, programs pg where pg.ProgramId = pj.ProgramId and pg.UniversityId = ?",[$id]);
            foreach($projects as $project){
                $activities = DB::select("select * from activities where ProjectId=?",[$project->ProjectId]);
                $project->NumOfActivities = sizeof($activities);
                //kani mui magamit
                $numOfVolunteers=DB::select("select * from activities a, volunteers v where v.ProgramId = a.ActivityId and v.VolunteerStatus = 1 and a.ProjectId = ?",[$project->ProjectId]);
                
                $project->NumOfVolunteers = sizeof($numOfVolunteers);
                
                
                $numOfBeneficiaries=DB::select("select * from activities a, beneficiaries b where b.ProgramId = a.ActivityId and b.BenStatus = 1 and a.ProjectId = ?",[$project->ProjectId]);
                
                
                $project->NumOfBeneficiaries = sizeof($numOfBeneficiaries);
                
            }
            
            $datesArray = array();
            
            echo json_encode($projects);
            
    }
    function mobileSubmitEvalForm(Request $request){
        $relfId=$request->input("relfId");
        $releasedForm=DB::select("select * from releasedforms r,evaluationtools e where e.EvaluationFormId = r.FormId and r.ReleasedFormId = ?",[$relfId]);
        $userAccountId=$request->input("userAccountId");
        if(!empty($releasedForm)){
            $releasedForm = $releasedForm[0];
            $questions = DB::select("select * from questions where FormId = ?",[$releasedForm->EvaluationFormId]);
            foreach($questions as $question){
                if($question->QuestionType === "Checkbox"){
                    $answers = $request->input($question->QuestionId);
                    if(!empty($answers)){
                        foreach($answers as $answer){ 
                            DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,$answer,$userAccountId]);
                        }
                    }
                }else{
                    DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,$request->input($question->QuestionId),$userAccountId]);
                }
            }
            DB::update("update releasedforms set totalResponses = totalResponses + 1 where ReleasedFormId = ?",[$relfId]);
            if(!empty($request->input("notifId"))) {
                DB::update("update notifications set Status = 1 where notificationId = ?",[$request->input("notifId")]);
            
            }
           echo "Successfully submitted answers";
        }else{
            echo "Released Form not found!";
        }
    }
    function masterSearch(Request $request){
        $q = $request->input("q");
        $uniId=session('uniId');
        $results = array();

        $uniArr =   DB::select("select 'img/logos/' as FilePath, u.UniLogo as Picture,u.UniName as ItemName,('getUniversityProfile?id=') as Link,u.UniId as ItemId from universities u where u.UniName like '%{$q}%'");
        $programArr =   DB::select("select 'img/logos/programs/' as FilePath, p.Logo as Picture, p.ProgramName as ItemName,('getUniversityProgramsSpecific?id=') as Link,p.ProgramId as ItemId from programs p where p.ProgramName like '%{$q}%'");
        $projectArr =   DB::select("select 'img/logos/programs/' as FilePath, p.Banner as Picture,p.ProjectName as ItemName,('getUniversityProject?id=') as Link,p.ProjectId as ItemId from projects p where p.ProjectName like '%{$q}%'");
        $accountArr =   DB::select("select 'img/logos/dp' as FilePath, p.Banner as Picture,a.ActivityName as ItemName,('getActivityPage?id=') as Link,a.ActivityId as ItemId from activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityName like '%{$q}%'");
        
        if(!empty($uniArr)){
            foreach($uniArr as $uni){
                array_push($results,$uni);
            }
        }
        if(!empty($programArr)){
            foreach($programArr as $program){
                array_push($results,$program);
            }
        }
        if(!empty($projectArr)){
            foreach($projectArr as $project){
                array_push($results,$project);
            }
        }
        if(!empty($accountArr)){
            foreach($accountArr as $acc){
                array_push($results,$acc);
            }
        }
        //print_r($results);
        echo json_encode($results);
        /*
        $programArr = 
        $projectArr = 
        $activityArr = 
        $accountArr = 
        */

    }
}
