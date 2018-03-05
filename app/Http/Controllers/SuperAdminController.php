<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;


class SuperAdminController extends Controller
{
    //
    function validate(){
        if(session('type')==="Super Admin"){
            return true;
        }else{
            return false;
        }
    }
    function getSubscriptions(Request $request){
        if(self::validate()){
            $subscriptions = DB::select("select * from subscriptions");
            print_r($subscriptions);
        }else{
            return View('RestrictedAccess');
        }
    }
    function addSubscription(Request $request){
        if(self::validate()){
            
            $subName = $request->input('subName');
            $subDuration = $request->input('subDuration');
            $subDescription = $request->input('subDescription');
            $subPrice = $request->input('subPrice');
            
            $subName = "sample";
            $subDuration = "sample duration";
            $subPrice = "sample price";
            $subDescription = "sample description";
            
            DB::insert("insert into subscriptions (SubscriptionName,SubscriptionDuration,SubscriptionPrice,SubscriptionDescription) values (?,?,?,?)",[$subName,$subDuration,$subPrice,$subDescription]);
            
                

        }else{
            return View('RestrictedAccess');
        }
    }
    function editSubscription(Request $request){
        if(self::validate()){
            $subId = $request->input('subId');
            $subName = $request->input('subName');
            $subDuration = $request->input('subDuration');
            $subPrice = $request->input('subPrice');
            
            $subId = 2;
            $subName = "123";
            $subDuration = "123";
            $subPrice = "123";
            
            DB::update("update subscriptions set SubscriptionName = ?, SubscriptionDuration = ?, SubscriptionPrice = ? where SubscriptionId = ?",[$subName,$subDuration,$subPrice,$subId]);

        }else{
            return View('RestrictedAccess');
        }
    }
    function deleteSubscription(Request $request){
        if(self::validate()){
            $id = $request->input("subId");
            $id = 2;
            DB::delete("delete from subscriptions where SubscriptionId = ?",[$id]);
            
            //DB::update("update subscriptions set SubscriptionName = ?, SubscriptionDuration = ?, SubscriptionPrice = ? where SubscriptionId = ?",//[$subName,$subDuration,$subPrice,$subId]);

        }else{
            return View('RestrictedAccess');
        }
    }
    
    function getSubscribedSchools(Request $request){
        if(self::validate()){
            
            $subscribed = DB::select("select * from universities u,subscribers s where s.SubscriberId = u.SubscriberId order by s.Status desc");
            
            return View('getSubscribedSchools',['subscribed'=>$subscribed]);

        }else{
            return View('RestrictedAccess');
        }
    }
    function enableAccount(Request $request){
      if(self::validate()){
            
            $subId = $request->input('subId');
            DB::update("update subscribers set status = 1 where SubscriberId = ?",[$subId]);
            return back();

        }else{
            return View('RestrictedAccess');
        }  
    }
    function disableAccount(Request $request){
      if(self::validate()){
            
            
            $subId = $request->input('subId');
          
            DB::update("update subscribers set status = 0 where SubscriberId = ?",[$subId]);
            return back();
        }else{
            return View('RestrictedAccess');
        }  
    }
    
}
