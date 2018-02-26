<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;


class RegUsersController extends Controller
{
    function normalRegistration(Request $request){

        $name=$request->input('name');
        $lname=$request->input('lastName');
        $username=$request->input('username');
        $password=$request->input('password');
        $contactNumber=$request->input('contactNumber');
        $address=$request->input('address');
        $emailAddress=$request->input('emailAddress');
        $bdate=$request->input('birthdate');
        $gender=$request->input('gender');
        $accountType=$request->input('accountType');
        $contPerson=$request->input('contPerson');
        $contPersonContNum=$request->input('contPersonContNum');
        $citizenship=$request->input('citizenship');
        $results = DB::select("select * from subscribers where Username=?",[$username]);
        if(sizeof($results)===0){
            if(empty($contactNumber)){
                $contactNumber = '-';
            }
            if(empty($contactNumber)){
                $contactNumber = '-';
            }
            if(empty($address)){
                $address = '-';
            }
            if(empty($emailAddress)){
                $emailAddress = '-';
            }
            if(empty($bdate)){
                $bdate = '-';
            }
            if(empty($gender)){
                $gender  = '-';
            }
            if(empty($contPerson)){
                $contPerson  = '-';
            }
            if(empty($contPersonContNum)){
                $contPersonContNum  = '-';
            }
            if(empty($citizenship)){
                $citizenship  = '-';
            }
            $displaypic = ($gender==="Male")?"display-pic-male.png":"display-pic-female.png";
        
             $results = DB::select("select * from accounts where Username='$username'");
            if(sizeof($results)===0){
                $uniId = session("uniId");

                DB::insert('insert into accounts (Name,LastName,Username,Password,ContactNumber,Address,EmailAddress,Gender,Birthday,UniversityId,AccountType,Citizenship,ContPerson,ContPersonContNumber,DisplayPic) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name,$lname,$username,$password,$contactNumber,$address,$emailAddress,$gender,$bdate,$uniId,$accountType,$citizenship,$contPerson,$contPersonContNum,$displaypic]);
                
                /*session(['name'=>$name]);
                $results = DB::select("select * from accounts where Username='$username'");
                session(['accountId'=>$results[0]->AccountId]);
                session(['type'=>'Registered User']);
                
                session(['pic'=>$results[0]->DisplayPic]);*/
                
                //return redirect('/getProfile');
                //return redirect()->route('login', ['username'=>$username], ['password'=>$password]);
                echo "Successfully added new account";
               //return back();
            }else{
                echo "Username is already taken";
            }
        }else{
            echo "Chosen username already exists";
        }
    }
    
     function getAllActivities(Request $request){
        $id=session('accountId');
        $type=session('type');
        $activities = DB::select("select * from activities where status='Approved'");
        return View('allActivities',['activities'=>$activities]);
        
        
	}
    function getUniversityListsJson(Request $request){
        $universities = DB::select("select u.UniId,u.UniName,u.UniLogo from universities u,subscribers s where s.SubscriberId = u.SubscriberId and s.Status = 1");
        echo json_encode($universities);
    }
    function getUnreadNotifications(Request $request){
        $type=session("type");
        if($type==="Coordinator"){
            $type="Registered User";
        }
        if(empty(session('accountId'))){
            $message = new \stdClass();
            $message->Message = "Session is empty";
            echo json_encode($message);
        }else{
            $notifications=DB::select("select * from notifications where Recipient=? and status=0 and RecipientId = ? order by notificationId desc",[$type,session('accountId')]);
            //$notifications=json_encode($notifications);
            echo json_encode($notifications);
            
        }
    }
    
    function getProfile(Request $request){
        $notifId=$request->input('notifId');
        if(!empty($notifId)){
            DB::update("update notifications set Status=1 where NotificationId=?",[$notifId]);
        }
        $id=session('accountId');
        $type=session('type');

        if(empty($id)){
            return redirect('');
        }

        if($type==='Director'){
            
            $subDetails = DB::select("select * from subscribers where SubscriberId=?",[$id]);
            $uniDetails = DB::select("select * from universities where SubscriberId=?",[$id]);
            //$upcomingActivities = DB::select("select ac.ActivityName,ac.ActivityId,pj.Banner,sc.SchedDate,sc.SchedTime from projects pj,programs pg,activities ac,schedules sc where pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and sc.SchedDate >= ? and pg.UniversityId = ? and pj.Status = ? and ac.ActivityStatus = ? and pj.Level=?",[date('Y-m-d'),session('uniId'),"Approved","Approved","Program"]);
            $upcomingActivities = DB::select("select ac.ActivityName,ac.ActivityId,pj.Banner,sc.SchedDate,sc.SchedTime from projects pj,programs pg,activities ac,schedules sc where pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and sc.SchedDate >= ? and pg.UniversityId = ? and pj.Status = ? and ac.ActivityStatus = ? and pj.Level=?",[date('Y-m-d'),session('uniId'),"Approved","Approved","Program"]);
            $upcomingInstLevel=DB::select("select ac.ActivityName,ac.ActivityId,pj.Banner,sc.SchedDate,sc.SchedTime from activities ac,projects pj,schedules sc where ac.ProjectId = pj.ProjectId and sc.ProgramId = ac.ActivityId and pj.Level=? and pj.ProgramId = ? and sc.SchedDate >= ?",["Institution",session('uniId'),date('Y-m-d')]);
            return View('profileDashBoard',['data'=>$subDetails[0],'university'=>$uniDetails[0],'upcomingActivities'=>$upcomingActivities,'upcomingInstLevel'=>$upcomingInstLevel]);
            
        }else{
            if($type!="Super Admin"){
                    
                $account = DB::select("select * from accounts where AccountId=?",[$id]);
                
                
                
                //$volHist = DB::select("select * from volunteers v, activities a, projects p where a.ProjectId=p.ProjectId and a.ActivityId=v.ProgramId and v.VolunteerStatus=1 and v.AccountId=? and a.ActivityStatus = ?",[$id,"Approved"]);    
                //$partHist = DB::select("select * from beneficiaries b,activities a, projects p where a.ProjectId=p.ProjectId and a.ActivityId=b.programId and b.BenStatus=1 and b.AccountId=?",[$id]);
            
                $volHist = DB::select("select a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from volunteers v, activities a,projects p,schedules s where v.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and v.AccountId = ? and s.SchedDate < ? and v.VolunteerStatus group by a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$id,date("Y-m-d"),1]);
                $partHist = DB::select("select a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from beneficiaries b, activities a,projects p,schedules s where b.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and b.AccountId = ? and s.SchedDate < ? and b.BenStatus = ? group by a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$id,date("Y-m-d"),1]);
                
                if(sizeof($account>0)){
                $account[0]->volHist=$volHist;
                $account[0]->partHist=$partHist;

                //TODO unya ni kai lisod
                //query for activities person logged in is participating as
                $upcomingAsVol = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from volunteers v, activities a,projects p,schedules s where v.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and v.AccountId = ? and s.SchedDate > ? and v.VolunteerStatus group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$id,date("Y-m-d"),1]);
                $upcomingAsBen = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from beneficiaries b, activities a,projects p,schedules s where b.ProgramId = a.ActivityId and s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and b.AccountId = ? and s.SchedDate > ? and b.BenStatus = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",$id,date("Y-m-d"),1]);
                
                $upcomingActivities = array();
                if(session('type')==="Coordinator"){
                    $upcomingAsCoo = DB::select("select s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId from activities a,projects p,schedules s where s.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and a.ActivityStatus = ? and p.Status = ? and s.SchedDate > ? and p.Level = ? and p.ProgramId = ? group by s.SchedDate,a.ActivityName,a.ActivityId,p.ProjectName,p.Banner,p.ProjectId",["Approved","Approved",date("Y-m-d"),"Program",session("programId")]);
                    foreach($upcomingAsCoo as $uc){
                        $activity = new \stdClass();
                        $activity = $uc;
                        $activity->As = "Coordinator";
                        array_push($upcomingActivities,$activity);
                    }
                }
                foreach($upcomingAsVol as $uv){
                    $activity = new \stdClass();
                    $activity = $uv;
                    $activity->As = "Volunteer";
                    array_push($upcomingActivities,$activity);
                }
                foreach($upcomingAsBen as $ub){
                    $activity = new \stdClass();
                    $activity = $ub;
                    $activity->As = "Beneficiary";
                    array_push($upcomingActivities,$activity);
                }
                return View('profileDashBoard',['data'=>$account[0],'upcomingActivities'=>$upcomingActivities]);
                
                }else{
                    echo "user not found";
                }
            }else{

                $subscriptionTransctions = DB::select("select t.TransacId,u.UniName,t.TransactionDate,t.PaymentType from subscribers s,universities u,transactions t where u.SubscriberId =s.SubscriberId  and s.SubscriberId = t.SubscriberId order by t.TransactionDate");
                $monthsYears = DB::select("select month(TransactionDate) as Month,year(TransactionDate) as Year from transactions group by year(TransactionDate),month(TransactionDate) order by TransactionDate");
                return View('profileDashBoard',["subscriptionTransctions"=>$subscriptionTransctions,"monthsYears"=>$monthsYears]);
            
            }
        }
        
	}
    
    function changeDisplayPic(Request $request){
        //$img=$request->input('photo');
        //$img->move('img',$img->getClientOriginalName());
        
        if(empty(filesize($request->file('photo')))){
            echo "file size too large";
            return;
        }
        if($request->input('for')==='RegUserDp'){
            $accountId=session('accountId');
            DB::update('update accounts set DisplayPic=? where AccountId=?', [$accountId.'.jpg',$accountId]);
            session(['pic'=>$accountId.'.jpg']);
            $request->file('photo')->move('img\dp',$accountId.'.jpg');
            DB::update("update posts set PosterDp = ? where PosterDetails = ?",[$accountId.".jpg","Coordinator - ".session("accountId")]);
        
        }elseif($request->input('for')==='ChangeUniCp'){
            $uniId=session('uniId');
            DB::update('update universities set CoverPhoto=? where UniId=?', [$uniId.'-cover-photo.jpg',session('uniId')]);
            $request->file('photo')->move('img\logos',$uniId.'-cover-photo.jpg');
        }elseif($request->input('for')==='ChangeUniLogo'){
          
            $uniId=session('uniId');
            echo "naa ngare";
            DB::update('update universities set UniLogo=? where UniId=?', [$uniId.'-university-logo-photo.jpg',session('uniId')]);
            $request->file('photo')->move('img\logos',$uniId.'-university-logo-photo.jpg');
            session(['pic'=>$uniId.'-university-logo-photo.jpg']);
            DB::update("update posts set PosterDp = ? where PosterDetails = ?",["../logos/".$uniId."-university-logo-photo.jpg","Director - ".session("accountId")]);
        
        }elseif($request->input('for')==='ChangeProgramLogo'){
            $programId=$request->input('programId');
            DB::update('update programs set Logo=? where ProgramId=?', [$programId.'-program-logo-photo.jpg',$programId]);
            $request->file('photo')->move('img\logos\programs',$programId.'-program-logo-photo.jpg');
           
        }elseif($request->input('for')==='ChangeProjectBanner'){
            $projectId=$request->input('projectId');
            DB::update('update projects set Banner=? where ProjectId=?', [$projectId.'-project-banner-photo.jpg',$projectId]);
            $request->file('photo')->move('img\logos\programs',$projectId.'-project-banner-photo.jpg');
            
             if(session('type')==='Coordinator'){
                
                $project=DB::select("select * from projects where ProjectId=?",[$projectId]);
                
                
                DB::insert("insert into notifications (Description,LinksTo,Recipient,RecipientId) values (?,?,?,?)",[session('name')." ".session('lastName')." changed the project banner of ".$project[0]->ProjectName, "getCoordinatorsProgramPage?id=".$project[0]->ProgramId,"Director",session('programUniId')]);
                
                
            }elseif(session('type')==='Director'){
                
            }
        }elseif($request->input('for')==='uploadActivityPhotos'){
         
            /*$activityId = $request->input("activityId");
            $pics = DB::select("select * from pictures where ActivityId = ? order by PictureId asc",[$activityId]);
            print_r($pics);
           //if(!empty($pics))
             //   $id=$pics[sizeof($pics)-1]->PictureId+1;
            //else
              //  $id=1;
            $actPicId=sizeof($pics)+1;
            if(session("type")==="Director"){
                $request->file('photo')->move('img\activities',$activityId.'-'.$actPicId.'-activity-photo.jpg');
                $path = $activityId.'-'.$actPicId.'-activity-photo.jpg';
                DB::insert('insert into pictures (FilePath,ActivityId,Status) values(?,?,?)',[$path,$activityId,1]);
            }else{
                $request->file('photo')->move('img\activities',$activityId.'-'.$actPicId.'-activity-photo.jpg');
                $path = $activityId.'-'.$actPicId.'-activity-photo.jpg';
                DB::insert('insert into pictures (FilePath,ActivityId,Status) values(?,?,?)',[$path,$activityId,0]);
            }
            */
            //ari test
            $activityId = $request->input("activityId");
            $pics = DB::select("select * from pictures where ActivityId = ? order by PictureId asc",[$activityId]);
            $actPicId=sizeof($pics)+1;
            if(session("type")==="Director"){
                
                
                $input=$request->all();
                $images = array();
                
                if($files=$request->file("images")){
                    foreach($files as $file){
                        $file->move('img\activities',$activityId.'-'.$actPicId.'-activity-photo.jpg');
                        $path = $activityId.'-'.$actPicId.'-activity-photo.jpg';
                        DB::insert('insert into pictures (FilePath,ActivityId,Status) values(?,?,?)',[$path,$activityId,1]);
                        
                        $actPicId++;
                    }
                }
            }else{
                $input=$request->all();
                $images = array();
                
                if($files=$request->file("images")){
                    foreach($files as $file){
                        $file->move('img\activities',$activityId.'-'.$actPicId.'-activity-photo.jpg');
                        $path = $activityId.'-'.$actPicId.'-activity-photo.jpg';
                        DB::insert('insert into pictures (FilePath,ActivityId,Status) values(?,?,?)',[$path,$activityId,0]);
                        
                        $actPicId++;
                }
            }
            
            
            
            
        }
        
        }
        $request->input('for');
    return back();
    }
    function editOrganizations(Request $request){
        $id=session('accountId');
        $organizations=DB::select("select * from organizations where AccountId=?",[$id]);
        return View('forms.editOrganizations',['organizations'=>$organizations]);
    }
    function addOrganization(Request $request){
        $pos=$request->input('pos');
        $id=session('accountId');
        $org=$request->input('org');
        DB::insert('insert into organizations (AccountId,OrgName,Position) values (?, ?, ?)', [$id,$org,$pos]);
        echo "success";
    }
    function deleteOrganization(Request $request){
        $id=$request->input('id');
        DB::delete('delete from organizations where OrgId=?',[$id]);
        echo "successfully deleted organization entry";
    }
    function editProfile(Request $request){
        if($request->input('accountId')!==null){
            $id=$request->input('accountId');
        }else{
            $id=session('accountId');    
        }
        $type=session('type');
        if($type==='Director' && empty($request->input('accountId'))){
            //return redirect('getUniversityProfile?id='.$id);
            $id=$request->input('id');
            $password=$request->input('password');
            $emailAd=$request->input('emailAd');
            $contNumber=$request->input('contNumber');
            $address=$request->input('address');
            
            DB::update('update subscribers set ContactNumber = ?,Address=?,EmailAddress=?,Password=?
                where SubscriberId = ?', [$contNumber,$address,$emailAd,$password,$id]);
            
        }else{
            $name=$request->input('name');
            $lName=$request->input('lName');
            $password=$request->input('password');
            $contactNumber=$request->input('contactNumber');
            $address=$request->input('address');
            $emailAddress=$request->input('emailAddress');
            $accountType=$request->input('accountType');
            $gender=$request->input('gender');

            $contPerson=$request->input('contPerson');
            $contPersonContNum=$request->input('contPersonContNum');
            
            echo $gender;
            DB::update('update accounts set Name = ?,LastName=?,Password=?,ContactNumber=?,Address=?,EmailAddress=?,AccountType=?,Gender=?,ContPerson=?,ContPersonContNumber=?
                where AccountId = ?', [$name,$lName,$password,$contactNumber,$address,$emailAddress,$accountType,$gender,$contPerson,$contPersonContNum,$id]);
            return back();
        }
        // return redirect('/getProfile');
	}

    function addVolunteer(Request $request){

        /*$programId=$request->input('programId');
        $accountId=session('accountId');
        $status=0;
        $type=$request->input('type');
        DB::insert('insert into volunteers (ProgramId,AccountId,VolunteerStatus,Type) values (?, ?, ?, ?)', [$programId,$accountId,$status,$type]);
        return back();*/
        $programId=$request->input('programId');
        $accountId=session('accountId');
        $status=0;
        $madeByUniId = $request->input('madeByUniId');
        $type=session('accountType');
        if(strpos($type,'Volunteer')===0){
            echo 'volunter ra sha';
            if($type === 'Volunteer - Faculty')
                $type = 'Faculty';
            elseif($type === 'Volunteer - Faculty')
                $type = 'Student';
            else
                $type = 'External';
        }else{
            // if user is not a volunteer by default
            $type='External';
        }
        
        if(session('uniId') == $madeByUniId){
        }else{
            $type='External';
        }
        DB::insert('insert into volunteers (ProgramId,AccountId,VolunteerStatus,Type) values (?, ?, ?, ?)', [$programId,$accountId,$status,$type]);
        return back();
    }

    
    function addBeneficiary(Request $request){

        /*$programId=$request->input('programId');
        $accountId=session('accountId');
        $status=0;
        $type=session('accountType');
        $type=$request->input('type');
        DB::insert('insert into beneficiaries (ProgramId,AccountId,BenStatus,Type) values (?, ?, ?, ?)', [$programId,$accountId,$status,$type]);
        return back();*/

        $programId=$request->input('programId');
        $accountId=session('accountId');
        $status=0;
        $madeByUniId = $request->input('madeByUniId');
        $type=$request->input('type');
        $type=session('accountType');
        if(strpos($type,'Beneficiary')===0){
            echo 'beneficiary ra sha';

            if($type === 'Beneficiary - Leader')
                $type = 'Leader';
            else
                $type = 'Member';
        }else{
            echo 'non beneficiary';
            $type='Member';
        }
        if(session('uniId') == $madeByUniId){
        }else{
            $type='External';
        }
        echo $type;
        DB::insert('insert into beneficiaries (ProgramId,AccountId,BenStatus,Type) values (?, ?, ?, ?)', [$programId,$accountId,$status,$type]);
        return back();
    }
    
    
    function getActivityPage(Request $request){
            //print_r($request->uri);
            
            $notifId=$request->input("notifId");
            if(!empty($notifId)){
                DB::update("update notifications set status=1 where NotificationId=?",[$notifId]);
            }
        
            $actId=$request->input('id');
                //return redirect('getUniversityProfile?id='.$id);
           // $activity = DB::select("select * from activities where ActivityId='$id'");
        
            $activity=DB::select("select * from activities a,projects p where p.ProjectId = a.ProjectId and a.ActivityId = ?",[$actId]);
        
            if(sizeof($activity)>0){
                $activity=$activity[0];
                if($activity->Level==="Program"){
                    $activity->MadeBy=DB::select("select * from programs p,universities u where u.UniId = p.UniversityId and p.ProgramId = ?",[$activity->ProgramId])[0];
                }elseif($activity->Level==="Institution"){
                    $activity->MadeBy=DB::select("select * from universities u where u.UniId = ?",[$activity->ProgramId])[0];
                }
                
                

                $activity->Schedules = DB::select("select * from schedules where ProgramId = ?",[$activity->ActivityId]);

                $activity->Volunteers = DB::select("select * from volunteers v,accounts a,universities u where a.UniversityId = u.UniId and a.AccountId = v.AccountId and v.ProgramId = ?",[$activity->ActivityId]);
                $activity->Beneficiaries = DB::select("select * from beneficiaries b ,accounts a,universities u where a.UniversityId = u.UniId and a.AccountId = b.AccountId and b.ProgramId = ?",[$activity->ActivityId]);
                
                $canVolunteer=0;
                if(session('type')==="Registered User"){
                    $testVol=DB::select("select * from volunteers where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                    if(sizeof($testVol)===0){
                        $canVolunteer=1;
                    }
                }elseif(session('type')==="Coordinator"){
                    if($activity->Level==="Program"){
                        if(session("programId")!==$activity->ProgramId){
                            $testVol=DB::select("select * from volunteers where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                            if(sizeof($testVol)===0){
                                $canVolunteer=1;
                            }
                        }
                    }elseif($activity->Level==="Institution"){
                        $testVol=DB::select("select * from volunteers where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                        if(sizeof($testVol)===0){
                            $canVolunteer=1;
                        }
                    }
                }
                
                
                $canParticipate=0;
                if(session('type')==="Registered User"){
                    $testVol=DB::select("select * from beneficiaries where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                    if(sizeof($testVol)===0){
                        $canParticipate=1;
                    }
                }elseif(session('type')==="Coordinator"){
                    if($activity->Level==="Program"){
                        if(session("programId")!==$activity->ProgramId){
                            $testVol=DB::select("select * from beneficiaries where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                            if(sizeof($testVol)===0){
                                $canParticipate=1;
                            }
                        }
                    }elseif($activity->Level==="Institution"){
                        $testVol=DB::select("select * from beneficiaries where ProgramId=? and AccountId=?",[$activity->ActivityId,session('accountId')]);
                        if(sizeof($testVol)===0){
                            $canParticipate=1;
                        }
                    }
                }
                
                
                $uniId=session('uniId');
                
                //$evaluationTools=DB::select("select * from evaluationtools where UniId=?",[$uniId]);
                $evaluationTools = array();
                if(session('type') === 'Coordinator'){
                    $evaluationTools = DB::select("select * from evaluationtools where ProgramId = ?",[session('programId')]);
                }elseif(session('type') === 'Director'){
                    $evaluationTools = DB::select("select * from evaluationtools where UniId = ?",[session('uniId')]);
                }

                $activity->ReleasedForms=DB::select("select * from releasedforms where  ActivityId=?",[$activity->ActivityId]);
                
                
                //start sa uni users
                
                if(session("type")==="Director"){
                    $uniUsers = DB::select("select * from accounts where UniversityId = ? and AccountId not in (select Accountid from volunteers where ProgramId = ?) and AccountId not in (select Accountid from beneficiaries where ProgramId = ?) order by AccountType desc",[$uniId,$actId,$actId]);
                    $activity->uniUsers = $uniUsers;
                }elseif(session("type")==="Coordinator"){
                    $uniUsers = DB::select("select * from accounts where UniversityId = ? and AccountId <> ? and AccountId not in (select Accountid from volunteers where ProgramId = ?) and AccountId not in (select Accountid from beneficiaries where ProgramId = ?) order by AccountType desc",[$uniId,session("accountId"),$actId,$actId]);
                    $activity->uniUsers = $uniUsers;
                }
                
                
                
                //start sa released forms
                
                $activity->ReleasedForms = DB::select("select * from releasedforms r, evaluationtools e where e.EvaluationFormId =  r.FormId and r.ActivityId = ?",[$actId]);
                
                $activity->Photos = DB::select("select * from pictures where ActivityId = ?",[$actId]);
                
               
                
                
                
                //start sa sponsors
                
                $activity->Sponsors = DB::select("select * from sponsors s, activitysponsors a where s.SponsorId = a.SponsorId and a.ActivityId = ?",[$activity->ActivityId]);
                
                //$activity->AllSponsors = DB::select("select * from sponsors sp, activitysponsors ac, activities at, projects pj, programs pg where sp.SponsorId = ac.SponsorId and ac.ActivityId = at.ActivityId and at.ProjectId = pj.ProjectId and pj.ProgramId = pg.ProgramId and pg.UniversityId = ?",[$uniId]);
                $activity->AllSponsors = DB::select("select sp.SponsorId,sp.SponsorName,sp.SponsorAddress,sp.SponsorContactNo from sponsors sp, activitysponsors ac, activities at, projects pj where sp.SponsorId = ac.SponsorId and ac.ActivityId = at.ActivityId and at.ProjectId = pj.ProjectId and ((pj.Level = ? and pj.ProgramId in (select Programid from programs where UniversityId = ?))||(pj.Level = ? and pj.ProgramId = ?)) group by sp.SponsorId,sp.SponsorName,sp.SponsorAddress,sp.SponsorContactNo",["Program",session('uniId'),"Institution",session('uniId')]);
                
                
                //check if can edit

                $canEdit = 0;
                if(session('type') === "Director"||session('type') === "Coordinator"){
                    if($activity->MadeBy->UniId === session('uniId')){
                        $canEdit = 1;
                    }
                    if(session('type')==="Coordinator" && (!empty($activity->MadeBy->ProgramId) && $activity->MadeBy->ProgramId !== session('programId'))){
                        $canEdit = 0;
                    }
                }
                //echo $canEdit;
                
                
                return View("getActivityPage",["activity"=>$activity,"canVolunteer"=>$canVolunteer,"canParticipate"=>$canParticipate,"canEdit"=>$canEdit,"evaluationTools"=>$evaluationTools]);
            }else{
                echo "activity not found in db";
            }
        
    
	}
    
    
     
	function fillUpEvaluationForm(Request $request){
        $relfId=$request->input("relfId");
        $releasedForm=DB::select("select * from releasedforms rf,activities ac where ac.ActivityId=rf.ActivityId and rf.ReleasedFormId=?",[$relfId]);
        if(!empty($releasedForm)){
            $releasedForm=$releasedForm[0];
            $today = date("Y-m-d");
            if($today >= $releasedForm->FromDate && $today <= $releasedForm->ToDate){
                $formId=$releasedForm->FormId;
                $form=DB::select("select * from evaluationtools where EvaluationFormId=?",[$formId]);

                if(!empty($form)){
                    $form=$form[0];
                    $form->Question=DB::select("select * from questions where FormId = ?",[$form->EvaluationFormId]);
                    foreach($form->Question as $question){
                        $question->Choices = DB::select("select * from choices where QuestionId = ?",[$question->QuestionId]);
                    }
                    $releasedForm->Form=$form;
                    $notifId=$request->input("notifId");
                    return View("forms.fillUpEvaluationForm",["releasedForm"=>$releasedForm,"notifId"=>$notifId]);
                }else{
                    echo "form does not exists";
                }
            }else{
                echo "Released form is currently unavailable";
            }
            
        }else{
            echo "released form does not exists";
        }
			
	}

    function submitEvaluationForm(Request $request){
        
        $relfId=$request->input("relfId");
        $releasedForm=DB::select("select * from releasedforms where ReleasedFormId = ?",[$relfId]);
        DB::update("update releasedforms set totalResponses = totalResponses + 1 where ReleasedFormId = ?",[$relfId]);
        $releasedForm=$releasedForm[0];
        $form=DB::select("select * from EvaluationTools where EvaluationFormId = ?",[$releasedForm->FormId]);
        $form=$form[0];
        $releasedForm->Form=$form;
        $releasedForm->Form->Questions = DB::select("select * from questions where FormId = ?",[$form->EvaluationFormId]);
        
        foreach($releasedForm->Form->Questions as $question){
            if($question->QuestionType==="Checkbox"){
                if(!empty($request->input($question->QuestionId))){
                    foreach($request->input($question->QuestionId) as $answer){
                    DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,$answer,session("accountId")]);
                    
                    }
                }else{
                    DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,"-",session("accountId")]);
                    
                }
            }else{
                if(trim($request->input($question->QuestionId))!==""){
                    DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,$request->input($question->QuestionId),session("accountId")]);
                    
                }else{
                    
                DB::insert("insert into submittedanswers (ReleasedFormId,QuestionId,Answer,SubmittedBy) values (?,?,?,?)",[$releasedForm->ReleasedFormId,$question->QuestionId,"-",session("accountId")]);
                
                }
            }
        }
        DB::update("update notifications set Status = 1 where notificationId = ?",[$request->input("notifId")]);
        return redirect('/getProfile'); 
	}
    
    
	/*
	function (Request $request){
			
	}
	*/
}
