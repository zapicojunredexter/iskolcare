<?php
use Illuminate\Http\Request;
use App\Http\Middleware\Test;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sample', function (Request $request) {
    /*session(['sample'=>'1']);
    echo session('sample');*/
    
	View::addLocation('modal');
    //  return view('forms/addProgramForm');
   // return View('editUniversity');
    $data='asd';
    return View('profileDashBoard',['sampleD'=>$data]);

});




//landing page
Route::get('/','HomeController@home');
Route::post('/login','HomeController@login');
Route::get('/logout','HomeController@logout');
//Route::get('/registration','HomeController@registration')->middleware(Test::class);
Route::get('/registration','HomeController@registration');

//start sa actual registration
Route::post('becomeSubscriber','SubscribersController@becomeSubscriber');
Route::post('normalRegistration','RegUsersController@normalRegistration');
Route::get('getAllUniUserAccounts','CoordinatorsController@getAllUniUserAccounts');
Route::get('getUserAccountDetails','CoordinatorsController@getUserAccountDetails');
Route::get('deleteAccount','SubscribersController@deleteAccount');
Route::get('chooseFromSubscription','SubscribersController@chooseFromSubscription');
Route::get('payWithPayPal','PaypalPaymentController@payWithPayPal');
Route::get('fails','PaypalPaymentController@fails');
Route::get('success','PaypalPaymentController@success');

//start sa profiles and univerrsities

Route::get('viewProfile','CoordinatorsController@viewProfile');
Route::get('getCoordinatorsProgramPage','CoordinatorsController@getCoordinatorsProgramPage');
Route::get('getProfile','RegUsersController@getProfile');
Route::get('getUnreadNotifications','RegUsersController@getUnreadNotifications');
Route::get('getUniversityListsJson','RegUsersController@getUniversityListsJson');
Route::post('changeDisplayPic','RegUsersController@changeDisplayPic');
Route::get('editOrganizations','RegUsersController@editOrganizations');
Route::get('deleteOrganization','RegUsersController@deleteOrganization');

Route::get('addOrganization','RegUsersController@addOrganization');

Route::get('getUniversityProfile','HomeController@getUniversityProfile');
Route::get('getUniversityProject','HomeController@getUniversityProject');
Route::get('getUniversityAnnouncements','HomeController@getUniversityAnnouncements');
Route::get('getUniversityPrograms','HomeController@getUniversityPrograms');
Route::get('getUniversityProgramsSpecific','HomeController@getUniversityProgramsSpecific');
Route::get('getUniversityProjects','HomeController@getUniversityProjects');

Route::post('editProfile','RegUsersController@editProfile');
Route::get('addAnnouncement','CoordinatorsController@addAnnouncement');
Route::get('deleteAnnouncement','CoordinatorsController@deleteAnnouncement');
Route::get('editAnnouncement','CoordinatorsController@editAnnouncement');
Route::post('editUniversity','SubscribersController@editUniversity');
//asd
Route::get('manageUserAccounts','CoordinatorsController@manageUserAccounts');


Route::get('viewPendingProposals','CoordinatorsController@viewPendingProposals');    
//start sa programs
Route::get('getProgramPage','HomeController@getProgramPage');
Route::post('addProgram','SubscribersController@addProgram');
Route::get('editProgram','SubscribersController@editProgram');
Route::get('deleteProgram','SubscribersController@deleteProgram');
Route::get('addCoordinator','SubscribersController@addCoordinator');
Route::get('editCoordinator','SubscribersController@editCoordinator');
Route::get('deleteCoordinator','SubscribersController@deleteCoordinator');
Route::get('reassignCoordinator','SubscribersController@reassignCoordinator');
Route::get('unassignCoordinator','SubscribersController@unassignCoordinator');
Route::get('getCoordinatorsProgram','CoordinatorsController@getCoordinatorsProgram');


//start sa projects
Route::get('addProject','CoordinatorsController@addProject');
//Route::get('editCoordinator','SubscribersController@editCoordinator');
Route::get('editProject','CoordinatorsController@editProject');
Route::get('deleteProject','SubscribersController@deleteProject');


//start sa activities
Route::get('addActivity','CoordinatorsController@addActivity');
Route::get('editActivity','CoordinatorsController@editActivity');
Route::get('deleteActivity','CoordinatorsController@deleteActivity');
Route::get('approveActivity','SubscribersController@approveActivity');
Route::get('approveActivities','SubscribersController@approveActivities');
Route::get('rejectActivities','SubscribersController@rejectActivities');
Route::get('approveProjects','SubscribersController@approveProjects');
Route::get('rejectProjects','SubscribersController@rejectProjects');
Route::get('getUpcomingActivities','HomeController@getUpcomingActivities');
Route::get('getActivityPage','RegUsersController@getActivityPage');
Route::get('getAllActivities','RegUsersController@getAllActivities');

Route::get('addActivitySchedule','CoordinatorsController@addActivitySchedule');
Route::get('editActivitySchedule','CoordinatorsController@editActivitySchedule');
Route::get('deleteActivitySchedule','CoordinatorsController@deleteActivitySchedule');
Route::get('setCoordinates','CoordinatorsController@setCoordinates');

Route::get('approvePhoto','SubscribersController@approvePhoto');
Route::get('approveUnapprovedPhotos','SubscribersController@approveUnapprovedPhotos');

Route::get('addSponsor','CoordinatorsController@addSponsor');

Route::get('deleteActivitySponsor','CoordinatorsController@deleteActivitySponsor');



//start sa volunteers and beneficiaries
Route::get('addApprovedParticipants','CoordinatorsController@addApprovedParticipants');
Route::get('deletePendingParticipants','CoordinatorsController@deletePendingParticipants');

Route::get('addVolunteer','RegUsersController@addVolunteer');
Route::get('addVolunteers','CoordinatorsController@addVolunteers');
Route::get('addApprovedVolunteers','CoordinatorsController@addApprovedVolunteers');
Route::get('editVolunteer','CoordinatorsController@editVolunteer');
Route::get('deleteVolunteer','CoordinatorsController@deleteVolunteer');

Route::get('addBeneficiary','RegUsersController@addBeneficiary');
Route::get('addBeneficiaries','CoordinatorsController@addBeneficiaries');
Route::get('addApprovedBeneficiary','CoordinatorsController@addApprovedBeneficiary');
Route::get('deleteBeneficiary','CoordinatorsController@deleteBeneficiary');


//getting sa forms

Route::get('getParticipantsAnswer','CoordinatorsController@getParticipantsAnswer');
Route::get('getEditProgramForm','SubscribersController@getEditProgramForm');

Route::get('createCertificates','CoordinatorsController@createCertificates');
Route::post('uploadCertificates','CoordinatorsController@uploadCertificates');

Route::get('getAllEvaluationTools','CoordinatorsController@getAllEvaluationTools');
Route::get('addEvaluationTool','CoordinatorsController@addEvaluationTool');
Route::get('editEvaluationTool','CoordinatorsController@editEvaluationTool');
Route::get('deleteEvaluationTool','CoordinatorsController@deleteEvaluationTool');
Route::get('getEvaluationTool','CoordinatorsController@getEvaluationTool');
Route::get('addQuestion','CoordinatorsController@addQuestion');
Route::get('deleteQuestion','CoordinatorsController@deleteQuestion');
Route::get('editQuestion','CoordinatorsController@editQuestion');
Route::get('getQuestion','CoordinatorsController@getQuestion');
Route::get('assignEvaluationTool','CoordinatorsController@assignEvaluationTool');
Route::get('editReleasedForm','CoordinatorsController@editReleasedForm');
Route::get('deleteReleasedForm','CoordinatorsController@deleteReleasedForm');


Route::get('fillUpEvaluationForm','RegUsersController@fillUpEvaluationForm');

//ssa
Route::post('submitEvaluationForm','RegUsersController@submitEvaluationForm');
Route::get('getResults','CoordinatorsController@getResults');
Route::get('getReleasedForm','CoordinatorsController@getReleasedForm');
//start of attendance
Route::get('manageAttendance','CoordinatorsController@manageAttendance');
Route::get('addAttendanceRecords','CoordinatorsController@addAttendanceRecords');
Route::get('editAttendanceRecords','CoordinatorsController@editAttendanceRecords');


// start of mobile reqeusts

Route::get('mobileLogin','MobileController@mobileLogin');

Route::get('getUniversityDetails','MobileController@getUniversityDetails');

Route::get('mobileAttendance','MobileController@mobileAttendance');
Route::get('fillUpReleasedForm','MobileController@fillUpReleasedForm');
Route::get('getMobileNotifications','MobileController@getMobileNotifications');
Route::get('getCoordinatorsActivities','MobileController@getCoordinatorsActivities');
Route::get('addAnnouncementMobile','MobileController@addAnnouncementMobile');
Route::get('mobileSubmitEvalForm','MobileController@mobileSubmitEvalForm');


Route::get('getProjectsHistorySummary','MobileController@getProjectsHistorySummary');
Route::get('masterSearch','MobileController@masterSearch');




Route::get('mobilesample',function(Request $request){
    $userType = "Registered User";
    $activityId = $request->input('activityId');
   return View('TestWV',["activityId"=>$activityId,"userType"=>$userType]);
});
Route::post('uploadPhotosFromMobile',function(Request $request){
    $activityId=$request->input('activityId');
    $userType = $request->input('userType');
    $status = 0;
    //DB::update('update projects set Banner=? where ProjectId=?', [$projectId.'-project-banner-photo.jpg',$projectId]);
    if($userType === "Director"){
        $status = 1;
    }
    $pics = DB::select("select * from pictures p where p.ActivityId = ? and p.PictureId = (select Max(PictureId) from pictures s where s.ActivityId = ?)",[$activityId,$activityId]);
    if(!empty($pics)){
        $pics = $pics[0];
        $split = explode("-",$pics->FilePath);
        $request->file('images')->move('img/activities',$activityId.'-'.($split[1] + 1).'-activity-photo.jpg');
        $filePath = $activityId.'-'.($split[1] + 1).'-activity-photo.jpg';
        DB::insert("insert into pictures (FilePath,ActivityId,Status) values (?,?,?)",[$filePath,$activityId,$status]);
    }else{
        $request->file('images')->move('img/activities',$activityId.'-1-activity-photo.jpg');
        
        $filePath = $activityId.'-1-activity-photo.jpg';
        DB::insert("insert into pictures (FilePath,ActivityId,Status) values (?,?,?)",[$filePath,$activityId,$status]);
    }
    echo "Successfully uploaded file";
    
});
Route::get('printCertificates',function(Request $request){
    $activityId = $request->input('actId');
    $fontSize = $request->input('size');
    $volunteers = DB::select('select * from volunteers v, accounts a where a.AccountId = v.AccountId and v.ProgramId = ?',[$activityId]);
    return View('includes.printCertificates',['volunteers'=>$volunteers,'fontSize'=>$fontSize]);
});
//fb api
Route::get('fb',function(Request $request){
    $link = "http://127.0.0.1:8000/getActivityPage?id=1";
    $link = $request->input('link');
    return view('fb-api.index',["link"=>$link]);
});
Route::get('app',function(){
    //echo 'haha';
    return view('fb-api.index');
});
Route::get('sample',function(){
    //echo 'haha';
   // return view('fb-api.sample');
    //return View('forms.uploadCertificateForm');
    return View('notFound');
});