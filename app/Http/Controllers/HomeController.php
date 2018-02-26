<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
class HomeController extends Controller
{
 
    function home(){
        if (session()->has('accountId')) {
           return redirect('getProfile');
        }else{
            return View('index');
        }
    }
    function login(Request $request){
        $username=$request->input('username');
        $password=$request->input('password');
        
        $results = DB::select("select * from subscribers s,universities u where s.Username=? and s.Password=? and u.SubscriberId=s.SubscriberId",[$username,$password]);
        
        $res = new \stdClass();
        $flag=false;
        
        if(sizeof($results)>0){
            if($results[0]->Status === 1){
                session(['accountId'=>$results[0]->SubscriberId]);
                session(['maxPrograms'=>$results[0]->MaxPrograms]);
                session(['name'=>$results[0]->ExtensionHeadName]);
                session(['type'=>'Director']);
                session(['pic'=>$results[0]->UniLogo]);
                session(['uniId'=>$results[0]->UniId]);
                $res->Message='Successful Login';
                    
            }else{
                $flag=true;
                $res->Message='University Account has been disabled';
            
            }
            
        }else{
            $results = DB::select("select * from accounts where Username=? and Password=?",[$username,$password]);
            if(sizeof($results)>0){
                $checkIfDisabled = DB::select("select * from universities u,subscribers s where s.SubscriberId = u.SubscriberId and u.UniId = ?",[$results[0]->UniversityId]);
                if(!empty($checkIfDisabled)){
                    if($checkIfDisabled[0]->Status === 1){
                        $flag=true;
                        session(['name'=>$results[0]->Name]);
                        session(['lastName'=>$results[0]->LastName]);
                        session(['accountId'=>$results[0]->AccountId]);
                        session(['accountType'=>$results[0]->AccountType]);
                        $id=$results[0]->AccountId;
                        session(['pic'=>$results[0]->DisplayPic]);
                        session(['uniId'=>$results[0]->UniversityId]);
                        $results = DB::select("select * from coordinators where isActive=1 and AccountId=?",[$id]);
                        if(sizeof($results)>0){
                            session(['type'=>'Coordinator']);
                            session(['programId'=>$results[0]->ProgramId]);
                            $results = DB::select("select * from programs where ProgramId=?",[$results[0]->ProgramId]);
                            session(['programUniId'=>$results[0]->UniversityId]);
                        }else{
                            session(['type'=>'Registered User']);

                        }
                        
                        $res->Message='Successful Login';
                    }else{
                        $res->Message='University Account has been disabled';
             
                    }
                }
            }else{
                $admin=DB::select("select * from admins where Username = ?",[$username]);
                if(!empty($admin)){
                    session(['type'=>'Super Admin']);
                    session(['name'=>$admin[0]->Name]);
                    session(['accountId'=>$admin[0]->AdminId]);
                    
                    $res->Message='Successful Login';
                }else
                    $res->Message='User not found';
            }
        }
        if(empty($username))
            $res->Message = "Username must not be empty";
        if(empty($password))
            $res->Message = "Password must not be empty";
        if(empty($username) && empty($password))
            $res->Message = "Fields must not be empty";
        echo json_encode($res);
    }
    function logout(Request $request){
        $request->session()->forget('name');
        $request->session()->forget('accountId');
        $request->session()->forget('lastName');
        $request->session()->forget('pic');
        
        $request->session()->forget('programId');
        $request->session()->forget('uniId');
        $request->session()->forget('type');
        $request->session()->forget('accountType');
        return redirect('/');
    }
    
    function registration(Request $request){
        $type=$request->input('type');
        if($type==='free'){
            return View('freeRegistration');     
        }else if($type==='subsc'){
            return View('subscriberRegistration');
        }
    }
    
    function getUniversityProfile(Request $request){
        $id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        if(!empty($uniDetails)){
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        //$uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        
        $test = DB::select("select * from posts where UniId='$id' order by PostDate desc");
        //$uniDetails[0]->Posts = $this->arrayPaginator($test,$request);
        $uniDetails[0]->Posts = ($test);
        //print_r($test);
        //print_r($uniDetails[0]->Posts);
        
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        return View("getUniversityProfile",['university'=>$uniDetails[0]]);
        }else{
            return View("notFound",["message"=>"University does not exists"]);
        }
    }

    function arrayPaginator($array,$request){
        $page = Input::get('page',1);
        $perPage =10;
        $offset = ($page & $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array,$offset,$perPage,true),count($array),$perPage,$page,
            ['path'=>$request->url(),'query'=>$request->query()]);
    }
    
    function getUniversityAnnouncements(Request $request){
        $id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        $uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        $type=session('type');
        if($type==='Coordinator'){
            return View("getUniversityAnnouncements",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId,'programId'=>session('programId')]);
        }else{
            return View("getUniversityAnnouncements",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId]);
        }
        
    }
    
    function getUniversityPrograms(Request $request){
        $id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        $uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        $type=session('type');
        if($type==='Coordinator'){
            return View("getUniversityPrograms",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId,'programId'=>session('programId')]);
        }else{
            return View("getUniversityPrograms",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId]);
        }
        
    }
    
     function getUniversityProgramsSpecific(Request $request){
        /*$id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        $uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        $type=session('type');
        if($type==='Coordinator'){
            echo "asd";
            //return View("getUniversityProgramsSpecific",['type'=>$type,'uniDetails'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId,'programId'=>session('programId')]);
        }else{
            return View("getUniversityProgramsSpecific",['type'=>$type,'uniDetails'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId]);
        }
         */
         $notifId=$request->input('notifId');
        if(!empty($notifId)){
            DB::update("update notifications set Status=1 where NotificationId=?",[$notifId]);
        }  
         
            $id=$request->input('id');
            $program = DB::select("select * from programs p,universities u where u.UniId = p.UniversityId and p.ProgramId=?",[$id]);
            $type=session('type');
            if(sizeof($program)>0){
                $program=$program[0];
                $program->Projects = DB::select("select * from projects where Level='Program' and Status= ? and ProgramId=? order by ProjectId desc",["Approved",$id]);
                
                
                $coordinators=DB::select("select * from coordinators c,accounts a where a.AccountId=c.AccountId and c.ProgramId='$id'");
                
                
                return View('getUniversityProgramsSpecific',['program'=>$program,'coordinators'=>$coordinators]);
            
                /*if(!empty($program->Projects)){
                    
                    foreach($program->Projects as $project){
                        $project->Activities=DB::select("select * from activities where ProjectId=?",[$project->ProjectId]);
                    }
                    $uniId=$program->UniversityId;
                    
                                        
                    
                    //$university=DB::select("select * from universities where UniId=?",[$uniId]);
                    $users=DB::select("select * from accounts where UniversityId = ?",[$uniId]);
                    $coordinators=DB::select("select * from coordinators c,accounts a where a.AccountId=c.AccountId and c.ProgramId='$id'");
                    return View('getUniversityProgramsSpecific',['program'=>$program,'type'=>$type,'coordinators'=>$coordinators,"accounts"=>$users]);
            
                }else{
                    $uniId=$program->UniversityId;
                    $university=DB::select("select * from universities where UniId='$uniId'");
                    

                    return View('getUniversityProgramsSpecific',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'coordinators'=>$coordinators]);
                }*/
            }else{
                echo 'program record does not exists';
            }
            
        
    }
    
    
    function getUniversityProjects(Request $request){
        $id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        $uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        $type=session('type');
        if($type==='Coordinator'){
            return View("getUniversityProjects",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId,'programId'=>session('programId')]);
        }else{
            return View("getUniversityProjects",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId]);
        }
        
    }


   /* function getUniversityAnnouncements(Request $request){
        $id=$request->input('id');
        $uniDetails = DB::select("select * from universities where UniId='$id'");
        $uniDetails[0]->Programs=DB::select("select * from Programs where UniversityId='$id'");
        $uniDetails[0]->Posts=DB::select("select * from posts where UniId='$id' order by PostId desc");
        $uniDetails[0]->InstProjects=DB::select("select * from projects p where p.Level=? and p.ProgramId=?",["Institution",$id]);
        foreach($uniDetails[0]->InstProjects as $instProjects){
            $instProjects->Activities = DB::select("select * from activities where ProjectId=?",[$instProjects->ProjectId]);
        }
        $type=session('type');
        if($type==='Coordinator'){
            return View("getUniversityAnnouncements",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId,'programId'=>session('programId')]);
        }else{
            return View("getUniversityAnnouncements",['type'=>$type,'university'=>$uniDetails[0],'uniId'=>$uniDetails[0]->UniId]);
        }
        
    }*/
    
    function getUniversityProject(Request $request){
        $id=$request->input('id');
        $project = DB::select("select * from projects where ProjectId=?",[$id]);
        if(!empty($project)){
                
            $project = $project[0];
            $uniDetails = null;
            if($project->Level === "Institution"){
                $uniDetails  = DB::select("select * from universities where UniId = ?",[$project->ProgramId]);
                $uniDetails = $uniDetails[0];
            }else{
                $uniDetails  = DB::select("select * from universities u,programs p where p.UniversityId = u.UniId and p.ProgramId = ?",[$project->ProgramId]);
                $uniDetails = $uniDetails[0];
            }
            $project->Activities = DB::select("select ActivityName,ActivityId from activities where ProjectId = ? and ActivityStatus = ?",[$project->ProjectId,"Approved"]);
            /*$i=0;
            foreach($project->Activities as $activity){
                $volCount = DB::select("select count(VolunteerId) as Co from volunteers where VolunteerStatus = 1 and ProgramId = ?",[$activity->ActivityId]);
                $benCount = DB::select("select count(BeneficiaryId) as Co from beneficiaries where BenStatus = 1 and ProgramId = ?",[$activity->ActivityId]);
                
                if(!empty($volCount))
                    $activity->VCount = $volCount[0]->Co;
                else
                    $activity->VCount = 0;
                if(!empty($benCount))
                    $activity->BCount = $benCount[0]->Co;
                else
                    $activity->BCount = 0;
            }*/

            //$test=DB::select("select Month(v.ApprovedDate) from  projects p,activities a,volunteers v where v.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and v.VolunteerStatus = ? and v.ApprovedDate <> ? ",[1,"-"]);
            //$volCounter = DB::select("select count(Month(v.ApprovedDate)) as VolCount,Month(v.ApprovedDate),Year(v.ApprovedDate) from projects p,activities a,volunteers v where v.ProgramId = a.ActivityId and a.ProjectId = p.ProjectId and v.VolunteerStatus = ? and v.ApprovedDate <> ? group by Month(v.ApprovedDate),Year(v.ApprovedDate)",[1,"-"]);
            

            $datesArray = array();
            $startDate = date("Y-m-d");
            array_unshift($datesArray,$startDate);
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));
            array_unshift($datesArray, date("Y-m-d",strtotime("-1 months",strtotime($datesArray[0]))));

            $finalDatesArray = array();
            foreach($datesArray as $date){
                $volCount = DB::select("select count(v.VolunteerId) as VolCount from activities a,volunteers v where v.ProgramId = a.ActivityId and a.ProjectId = ? and v.VolunteerStatus = ? and Month(v.ApprovedDate) = ? and Year(v.ApprovedDate) = ?",[$id,1,substr($date,5,2),substr($date,0,4)]);
                $benCount = DB::select("select count(b.BeneficiaryId) as BenCount from activities a,beneficiaries b where b.ProgramId = a.ActivityId and a.ProjectId = ? and b.BenStatus = ? and Month(b.ApprovedDate) = ? and Year(b.ApprovedDate) = ?",[$id,1,substr($date,5,2),substr($date,0,4)]);

                $dateOb = new \stdClass();
                $dateOb->Date = $date;
                $dateOb->VolCount = $volCount[0]->VolCount;
                $dateOb->BenCount = $benCount[0]->BenCount;
                array_push($finalDatesArray,$dateOb);
            }

            //check if can edit
            $canEdit = 0;
            //check user type
            if(session('type') === "Director"||session('type') === "Coordinator"){
                //check if my university
                if($uniDetails->UniId===session('uniId')){
                    //check if program level
                    if(!empty($uniDetails->ProgramName)){
                        //check whether can really edit
                        if(session('type') === "Director"||(session('type') === "Coordinator" && $project->ProgramId === session('programId'))){
                            $canEdit = 1;
                        }
                    }else{
                        //check if director ba jud for inst level projects
                        if(session('type') === "Director"){
                            $canEdit = 1;
                        }
                    }
                }
            }
            
            return View("getUniversityProject",['university'=>$uniDetails,'project'=>$project,'finalDatesArray'=>$finalDatesArray,'canEdit'=>$canEdit]);

        }else{
            echo "project not found";
        }
        
        
    }
    function getProgramPage(Request $request){
        
            $id=$request->input('id');
                //return redirect('getUniversityProfile?id='.$id);
            $program = DB::select("select * from programs where ProgramId='$id'");
            $type=session('type');
            if(sizeof($program)>0){
                 $program=$program[0];
                $program->Projects = DB::select("select * from projects where Level='Program' and ProgramId='$id'");
                
                
                $coordinators=DB::select("select * from coordinators c,accounts a where a.AccountId=c.AccountId and c.ProgramId='$id'");
                
                if(!empty($program->Projects)){
                    
                    foreach($program->Projects as $project){
                        $project->Activities=DB::select("select * from activities where ProjectId='$project->ProjectId'");
                    }
                    $uniId=$program->UniversityId;
                    
                    
                    
                    $university=DB::select("select * from universities where UniId='$uniId'");

                    if($type==='Coordinator'){
                        return View('getProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'programId'=>session('programId'),'coordinators'=>$coordinators]);
                        
                    }else{
                        return View('getProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'coordinators'=>$coordinators]);
                    }
                }else{
                    $uniId=$program->UniversityId;
                    $university=DB::select("select * from universities where UniId='$uniId'");
                    

                    return View('getProgramPage',['university'=>$university[0],'program'=>$program,'type'=>$type,'uniId'=>$uniId,'coordinators'=>$coordinators]);
                }
            }else{
                echo 'program record does not exists';
            }
            
      
   
	}
    function getUpcomingActivities(Request $request){
        /*before sa trapping
        $uniId = session('uniId');
        echo $uniId;
        $upcomingActivities = DB::select("select * from programs p, activities a, projects j, universities u where u.uniId=p.UniversityId and p.ProgramId=j.ProgramId and j.ProjectId=a.ProjectId and a.ActivityStatus='Approved' and j.Status='Approved' and u.UniId = ?",[$uniId]);
        
        return View('getUpcomingActivities',['type'=>session('type'),'upcomingActivities'=>$upcomingActivities]);
        */
        //echo date('Y-m-d');
        /*$upcomingActivities = DB::select("select ac.ActivityId,ac.ActivityName,pj.ProgramId,pj.ProjectId,pj.Banner,pj.ProjectName,pj.Level from projects pj,activities ac,schedules sc where sc.ProgramId = ac.ActivityId and ac.ProjectId = pj.ProjectId and sc.SchedDate >= ? and ac.ActivityStatus = ? and pj.Status = ?",[date('Y-m-d'),"Approved","Approved"]);
        //print_r($upcomingActivities);
        foreach($upcomingActivities as $activity){
            if($activity->Level === "Institution"){
                $activity->MadeBy = DB::select("select * from universities where UniId = ?",[$activity->ProgramId]);
            }else{
                $activity->MadeBy = DB::select("select * from universities u,programs p where p.UniversityId = u.UniId and p.ProgramId = ?",[$activity->ProgramId]);
            }
        }*/

//        $upcomingActivities = DB::select("select ac.ActivityName,ac.ActivityId,pr.ProjectId,pr.ProjectId,pr.Banner,pr.ProjectName,sc.SchedDate from activities ac,projects pr,schedules sc where pr.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId order by sc.SchedDate desc");a
        $upcomingActivities = DB::select("select ac.ActivityName,ac.ActivityId,pr.ProjectId,pr.ProjectId,pr.Banner,pr.ProjectName,sc.SchedDate from activities ac,projects pr,schedules sc where sc.SchedDate>= ? and pr.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and ac.ActivityStatus = 'Approved' and pr.Status = 'Approved' and (((pr.Level = 'Institution' and pr.ProgramId = ?) or (pr.Level = 'Program' and pr.ProgramId in (select pr1.ProgramId from programs pr1 where pr1.UniversityId = ?))) or ((pr.Level = 'Institution' and pr.ProgramId <> ?) or (pr.Level = 'Program' and pr.ProgramId in (select pr2.ProgramId from programs pr2 where pr2.UniversityId <> ?)))) order by sc.SchedDate desc",[date("Y-m-d"),session('uniId'),session('uniId'),session('uniId'),session('uniId')]);
        return View('getUpcomingActivities',['upcomingActivities'=>$upcomingActivities]);
        /*$uniId = session('uniId');
        $upcomingActivities = DB::select("select * from programs p, activities a, projects j, universities u where u.uniId=p.UniversityId and p.ProgramId=j.ProgramId and j.ProjectId=a.ProjectId and a.ActivityStatus='Approved' and j.Status='Approved' and u.UniId = ?",[$uniId]);
        
        $upcomingActivities = DB::select("select distinct(ActivityId), pj.Level, pj.Banner, ac.ActivityName, pg.UniversityId, un.UniName, pj.ProjectName, pg.ProgramId,pg.ProgramName from universities un,programs pg, projects pj, activities ac, schedules sc where un.UniId = pg.UniversityId and pg.UniversityId = ? and pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and ac.ActivityId = sc.ProgramId and pj.Status = 'Approved' and ac.ActivityStatus = 'Approved' and sc.SchedDate = ? order by ac.ActivityId desc",[$uniId,date('Y-m-d')]);

        $test  = DB::select("select * from universities un, projects pj, programs pg, activities ac where un.UniId = ? and un.UniId = pg.UniversityId and pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and pj.Status = ? and ac.ActivityStatus = ?",[$uniId,"Approved","Approved"]);
        $test  = DB::select("select * from universities un, projects pj, programs pg, activities ac where un.UniId = ? and un.UniId = pg.UniversityId and pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId",[$uniId]);
        $otherUnis = DB::select("select * from universities un, projects pj, programs pg, activities ac where un.UniId = pg.UniversityId and pg.ProgramId = pj.ProgramId and pj.ProjectId = ac.ProjectId and ac.isExclusive = ?",[0]);
        
        $resultArray = array();
        foreach($test as $t){
            $sched = DB::select("select * from schedules where ProgramId = ? and SchedDate >= ?",[$t->ActivityId, date('Y-m-d')]);
            
            if(sizeof($sched) > 0)
                array_push($resultArray,$t);
            
        }

        foreach($otherUnis as $t){
            $sched = DB::select("select * from schedules where ProgramId = ? and SchedDate >= ?",[$t->ActivityId, date('Y-m-d')]);
            
            if(sizeof($sched) > 0)
                array_push($resultArray,$t);
            
        }*/
        //return View('getUpcomingActivities',['type'=>session('type'),'upcomingActivities'=>$resultArray]);

    }
}
