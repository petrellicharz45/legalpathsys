<?php

namespace App\Http\Controllers\Admin;

use App\Opportunity;
use App\Opportunitytype;
use App\ManageText;
use App\ValidationText;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Str;
use Storage;
use File;
use App\NotificationText;
class OpportunityController extends Controller
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
        $opportunity=Opportunity::with('type')->get();
        $website_lang=ManageText::all();
        return view('admin.opportunity.index',compact('opportunity','website_lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function destroy(Opportunity $opportunity)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
  
        $opportunity->delete();

      
      

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.opportunity.index')->with($notification);
    }

    // manage opportunity status
    public function changeStatus($id){
        $opportunity=Opportunity::find($id);
        if($opportunity->status==1){
            $opportunity->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $opportunity->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $opportunity->save();
        return response()->json($message);

    }


}
