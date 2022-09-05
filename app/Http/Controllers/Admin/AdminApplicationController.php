<?php

namespace App\Http\Controllers\Admin;

use App\Opportunity;
use App\Opportunitytype;
use App\ManageText;
use App\ValidationText;
use App\Application;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Str;
use Storage;
use File;
use App\NotificationText;
class AdminApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('admin')->user();
        $opportunity=Opportunity::with('type')->where('user_id',$user->id)->get();
        $application=Application::with('job')->get();
        $website_lang=ManageText::all();
        return view('admin.application.index',compact('application','opportunity','website_lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function destroy(Application $application)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
  
        $application->delete();

      
      

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.application.index')->with($notification);
    }

    // manage opportunity status
    public function changeStatus($id){
        $application=Application::find($id);
        if($application->status==1){
            $application->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $application->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $opportunity->save();
        return response()->json($message);

    }

}