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
                $response->Message = "Account Not Found";
            }
        }
        if(!empty($response->Password)){
            //echo $password;
            //echo $response->Password;
            if(strtolower ($password) === strtolower($response->Password)){
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
        $type = $request->input('type');
        $date = date("Y-m-d", strtotime($date));
       // echo $date;
    
        
        $distinctDates = DB::select("select distinct(SchedDate) from schedules where ProgramId = ? order by SchedDate asc",[$actId]);
        
    
        $activity = DB::select("select * from activities a where a.ActivityId = ?",[$actId]);
        //echo $type;
        $activity=$activity[0];
        if($type==="volunteer"){
            $activity->Volunteers = DB::select("select * from volunteers v, accounts a where a.AccountId = v.AccountId and v.ProgramId = ?",[$activity->ActivityId]);
            $activity->DistinctDates=$distinctDates;
            foreach($activity->DistinctDates as $d){
                $d->SchedDate = date("M jS, Y", strtotime($d->SchedDate));
            }
            foreach($activity->Volunteers as $volunteer){
                $attRecord = DB::select("select * from volunteerattendances v where v.AttendanceDate = ? and v.VolunteerId = ?",[$date,$volunteer->VolunteerId]);
                if(!empty($attRecord)){
                    $volunteer->Status = $attRecord[0]->Status;
                }else{
                    $volunteer->Status = "no record";
                }

            }
        }elseif($type==="beneficiary"){
            $activity->Beneficiaries = DB::select("select * from beneficiaries b, accounts a where a.AccountId = b.AccountId and b.ProgramId = ?",[$activity->ActivityId]);
            $activity->DistinctDates=$distinctDates;
            foreach($activity->DistinctDates as $d){
                $d->SchedDate = date("M jS, Y", strtotime($d->SchedDate));
            }
            foreach($activity->Beneficiaries as $beneficiary){
                $attRecord = DB::select("select * from beneficiaryattendances b where b.AttendanceDate = ? and b.BeneficiaryId  = ?",[$date,$beneficiary->BeneficiaryId]);
                if(!empty($attRecord)){
                    $beneficiary->Status = $attRecord[0]->Status;
                }else{
                    $beneficiary->Status = "no record";
                }

            }
        }else{
            //if gikan mobile na
            $activity->Volunteers = DB::select("select * from volunteers v, accounts a where a.AccountId = v.AccountId and v.ProgramId = ?",[$activity->ActivityId]);
            $activity->DistinctDates=$distinctDates;
            foreach($activity->DistinctDates as $d){
                $d->SchedDate = date("M jS, Y", strtotime($d->SchedDate));
            }
            foreach($activity->Volunteers as $volunteer){
                $attRecord = DB::select("select * from volunteerattendances v where v.AttendanceDate = ? and v.VolunteerId = ?",[$date,$volunteer->VolunteerId]);
                if(!empty($attRecord)){
                    $volunteer->Status = $attRecord[0]->Status;
                }else{
                    $volunteer->Status = "no record";
                }

            }
        }
        $activity->ServerTime = date("M jS, Y");
        echo json_encode($activity);
    }
    
    function getUniversityDetails(Request $request){
        $uniId = $request->input('uniId');
        $university = DB::select("select * from universities where UniId = ?",[$uniId]);
        
        /*if(!empty($university)){
            $university = $university[0];
            $university->Announcements = DB::select("select * from posts  where UniId = ? order by PostId desc",[$uniId]);
        }
        echo json_encode($university);
        return;*/
        
        if(!empty($university)){
            $university = $university[0];
            $university->Announcements = DB::select("select * from posts  where UniId = ? order by PostId desc",[$uniId]);
            foreach($university->Announcements as $announcemnt){
                
                $announcemnt->PostDescr.="\n";
                if(!empty($announcemnt->PostWhat))
                $announcemnt->PostDescr.="\n\rWhat: ".$announcemnt->PostWhat;
                if(!empty($announcemnt->PostWhen))
                $announcemnt->PostDescr.="\n\rWhen: ".$announcemnt->PostWhen;
                if(!empty($announcemnt->PostWhat))
                $announcemnt->PostDescr.="\n\rWhere: ".$announcemnt->PostWhere;
            }
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
                $upcomingAsCoo = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId order by s.SchedDate asc",["Approved","Approved",date("Y-m-d"),"Program",$coordinator->ProgramId]);
                    foreach($upcomingAsCoo as $uc){
                        $activity = new \stdClass();
                        $activity = $uc;
                        $activity->As = "Coordinator";
                        $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
                        array_push($activities,$activity);
                    }
            }

            $upcomingAsVol = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from volunteers v, activities a,projects p,schedules s where v.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and v.AccountId = ? and s.SchedDate >= ? and v.VolunteerStatus group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId order by s.SchedDate asc",["Approved","Approved",$account->AccountId,date("Y-m-d"),1]);
            //print_r($upcomingAsVol);
            $upcomingAsBen = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from beneficiaries b, activities a,projects p,schedules s where b.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and b.AccountId = ? and s.SchedDate >= ? and b.BenStatus = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId order by s.SchedDate asc",["Approved","Approved",$account->AccountId,date("Y-m-d"),1]);
            foreach($upcomingAsVol as $uv){
                $activity = new \stdClass();
                $activity = $uv;
                $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
                $activity->As = "Volunteer";
                array_push($activities,$activity);
            }
            foreach($upcomingAsBen as $ub){
                $activity = new \stdClass();
                $activity = $ub;
                $activity->As = "Beneficiary";
                
                $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
                array_push($activities,$activity);
            }
            
            echo json_encode($activities);
        }else{
            $account = DB::select("select * from subscribers s,universities u where s.SubscriberId = u.SubscriberId and s.Username=?",[$username]);
            if(!empty($account)){
                $account = $account[0];
                /*//start sa if subscriber and institutionLevel
                $upcomingAsCooInst = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Institution",$account->UniId]);
                foreach($upcomingAsCooInst as $uc){
                    $activity = new \stdClass();
                    $activity = $uc;
                    
                    $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
                    $activity->As = "Coordinator";
                    array_push($activities,$activity);
                }
                $upcomingAsCooProg = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s,programs g where g.ProgramId = p.ProgramId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate >= ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Program",$account->UniId]);
                
                foreach($upcomingAsCooProg as $uc){
                    $activity = new \stdClass();
                    $activity = $uc;
                    $activity->As = "Coordinator";
                    
                    $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
                    array_push($activities,$activity);
                }
                
                */
                $upcomingActivities = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a, projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = 'Approved' and p.Status = 'Approved' and s.SchedDate >= ? and ((p.Level = 'Institution' and p.ProgramId = ?) or (p.Level = 'Program' and p.ProgramId in (select ProgramId from programs where UniversityId = ?))) order by s.SchedDate asc",[date('Y-m-d'),$account->UniId,$account->UniId]);
                //print_r($upcomingActivities);
                //print_r($upcomingAsCooProg); 
                
                foreach($upcomingActivities as $uc){
                    $activity = new \stdClass();
                    $activity = $uc;
                    $activity->As = "Coordinator";
                    
                    $activity->SchedDate = date("M jS, Y", strtotime($activity->SchedDate));
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
        $username=$request->input("username");
        //echo "n here";
        //echo $username;
        $announcement=$request->input('announcement');
        $account=DB::select("select * from accounts where Username=?",[$username]);
        //print_r($account);
        if(!empty($account)){
            $account=$account[0];
            //print_r($account);
            DB::insert("insert into posts (UniId,PostDescr,PostedBy,PosterDP,PosterDetails) values(?,?,?,?,?)",[$account->UniversityId,$announcement,$account->Name.' '.$account->LastName,$account->DisplayPic,'Coordinator - '.$account->AccountId]);
            echo "Successfully added";
        }else{
            $account = DB::select("select * from subscribers s,universities u where u.SubscriberId = s.SubscriberId and s.Username=?",[$username]);
            if(!empty($account)){
            $account = $account[0];
            DB::insert("insert into posts (UniId,PostDescr,PostedBy,PosterDP,PosterDetails) values(?,?,?,?,?)",[$account->UniId,$announcement,$account->ExtensionHeadName,'../logos/'.$account->UniLogo,'Dirctor - '.$account->SubscriberId]);
            echo "Successfully added";

                
            }else{
                echo "account not found";
            }
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
        $requestString = ($request->getPathInfo() . ($request->getQueryString() ? ('?' . $request->getQueryString()) : ''));
        if(strlen($requestString)>2000){
            echo "Request String too long";
            return;
        }
        //return;
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
                    if(!empty($request->input($question->QuestionId))){
                        DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,$request->input($question->QuestionId),$userAccountId]);
                    }else{
                        DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,'-',$userAccountId]);
                        
                    }
                }
            }
            DB::update("update releasedforms set totalResponses = totalResponses + 1 where ReleasedFormId = ?",[$relfId]);
            if(!empty($request->input("notifId"))) {
                DB::update("update notifications set Status = 1 where notificationId = ?",[$request->input("notifId")]);
            
            }
           echo "Successfully Submitted Answers";
        }/*else{
            echo "Released Form not found!";
        }*/
    }
    function masterSearch(Request $request){
        $q = $request->input("q");
        $uniId=session('uniId');
        $results = array();

        $uniArr =   DB::select("select 'img/logos/' as FilePath, u.UniLogo as Picture,u.UniName as ItemName,('getUniversityProfile?id=') as Link,u.UniId as ItemId from universities u where u.UniName like '%{$q}%'");
        $programArr =   DB::select("select 'img/logos/programs/' as FilePath, p.Logo as Picture, p.ProgramName as ItemName,('getUniversityProgramsSpecific?id=') as Link,p.ProgramId as ItemId from programs p where p.ProgramName like '%{$q}%'");
        $projectArr =   DB::select("select 'img/logos/programs/' as FilePath, p.Banner as Picture,p.ProjectName as ItemName,('getUniversityProject?id=') as Link,p.ProjectId as ItemId from projects p where p.ProjectName like '%{$q}%'");
        $activityArr =   DB::select("select 'img/logos/programs/' as FilePath, p.Banner as Picture,a.ActivityName as ItemName,('getActivityPage?id=') as Link,a.ActivityId as ItemId from projects p,activities a where p.ProjectId = a.ProjectId and a.ActivityName like '%{$q}%'");
        //$accountArr =   DB::select("select 'img/logos/dp/' as FilePath, p.Banner as Picture,a.ActivityName as ItemName,('getActivityPage?id=') as Link,a.ActivityId as ItemId from activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityName like '%{$q}%'");
        
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
        if(!empty($activityArr)){
            foreach($activityArr as $activity){
                array_push($results,$activity);
            }
        }
        /*if(!empty($accountArr)){
            foreach($accountArr as $acc){
                array_push($results,$acc);
            }
        }*/
        //print_r($results);
        echo json_encode($results);
        /*
        $programArr = 
        $projectArr = 
        $activityArr = 
        $accountArr = 
        */

    }
    
    function checkAttendanceMobile(Request $request){
        $userType = "Registered User";
        $activityId = $request->input('activityId');
        $activity = DB::select("select * from activities where ActivityId = ?",[$activityId]);
        if(empty($activity)){
            echo "Activity Not Found";
            return;
        }
        $activity=$activity[0];
        $activity->Schedules = DB::select("select * from schedules where ProgramId = ? order by SchedDate asc",[$activityId]);

        $activity->Volunteers = DB::select("select * from volunteers v,accounts a where v.AccountId = a.AccountId and v.VolunteerStatus = 1 and v.ProgramId = ?",[$activityId]);
        $activity->Beneficiaries = DB::select("select * from beneficiaries v,accounts a where v.AccountId = a.AccountId and v.BenStatus = 1 and v.ProgramId = ?",[$activityId]);




        //ang pag add sa attendance na jud
        $addAttendanceToDate = $request->input('addAttendanceToDate');
        $addAttendanceToDate = date('Y-m-d',strtotime($addAttendanceToDate));
        $addVolAttndance = $request->input('volAtt');
        if(!empty($request->input('toEditVol'))){
            DB::delete("delete from volunteerattendances where VolunteerId in (select VolunteerId from volunteers where ProgramId = ?) and AttendanceDate = ?",[$activityId,$addAttendanceToDate]);
            foreach($activity->Volunteers as $volunteer){
                if(empty($addVolAttndance)){
                    DB::insert("insert into volunteerattendances (AttendanceDate,VolunteerId,Status) values(?,?,?)",[$addAttendanceToDate,$volunteer->VolunteerId,"Absent"]);
                }elseif(in_array($volunteer->VolunteerId,$addVolAttndance)){

                    DB::insert("insert into volunteerattendances (AttendanceDate,VolunteerId,Status) values(?,?,?)",[$addAttendanceToDate,$volunteer->VolunteerId,"Present"]);
                }else{
                    DB::insert("insert into volunteerattendances (AttendanceDate,VolunteerId,Status) values(?,?,?)",[$addAttendanceToDate,$volunteer->VolunteerId,"Absent"]);


                }
            }
        }

        $addBenAttendance = $request->input('benAtt');

        if(!empty($request->input('toEditBen'))){
            DB::delete("delete from beneficiaryattendances where BeneficiaryId in (select BeneficiaryId from beneficiaries where ProgramId = ?) and AttendanceDate = ?",[$activityId,$addAttendanceToDate]);
            foreach($activity->Beneficiaries as $beneficiary){
               if(empty($addBenAttendance)){
                    DB::insert("insert into beneficiaryattendances (AttendanceDate,BeneficiaryId,Status) values(?,?,?)",[$addAttendanceToDate,$beneficiary->BeneficiaryId,"Absent"]);

                }elseif(in_array($beneficiary->BeneficiaryId,$addBenAttendance)){
                    DB::insert("insert into beneficiaryattendances (AttendanceDate,BeneficiaryId,Status) values(?,?,?)",[$addAttendanceToDate,$beneficiary->BeneficiaryId,"Present"]);
                }else{
                     DB::insert("insert into beneficiaryattendances (AttendanceDate,BeneficiaryId,Status) values(?,?,?)",[$addAttendanceToDate,$beneficiary->BeneficiaryId,"Absent"]);

                }
            }
        }

        //end sa pag attendance na jud

        foreach($activity->Schedules as $schedule){
            $volAttendances = array();
            foreach($activity->Volunteers as $volunteer){
                $attendance = DB::select("select * from volunteerattendances where VolunteerId = ? and AttendanceDate = ?",[$volunteer->VolunteerId,$schedule->SchedDate]);
                $attendanceStatus;
                if(empty($attendance)){
                    $attendanceStatus = "no record";
                }else{
                    $attendanceStatus = $attendance[0]->Status;
                }
                $vol = new \StdClass();
                $vol->Name = $volunteer->Name." ".$volunteer->LastName;
                $vol->VolId = $volunteer->VolunteerId;
                $vol->AttendanceStatus = $attendanceStatus;
                array_push($volAttendances,$vol);

            }   
            $schedule->VolunteerAttendances = $volAttendances;
        }

        foreach($activity->Schedules as $schedule){
            $benAttendances = array();
            foreach($activity->Beneficiaries as $beneficiary){
                $attendance = DB::select("select * from beneficiaryattendances where BeneficiaryId = ? and AttendanceDate = ?",[$beneficiary->BeneficiaryId,$schedule->SchedDate]);
                $attendanceStatus;
                if(empty($attendance)){
                    $attendanceStatus = "no record";
                }else{
                    $attendanceStatus = $attendance[0]->Status;
                }
                $ben = new \StdClass();
                $ben->Name = $beneficiary->Name." ".$beneficiary->LastName;
                $ben->BenId = $beneficiary->BeneficiaryId;
                $ben->AttendanceStatus = $attendanceStatus;

                array_push($benAttendances,$ben);

            }   
            $schedule->BeneficiaryAttendances = $benAttendances;
        }



        return View('checkAttendanceMobile',["activity"=>$activity,"selectedDate"=>$addAttendanceToDate]);
    }
}
