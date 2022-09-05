<?php

namespace App\Http\Controllers\Admin;

use App\Story;
use App\CaseCategory;
use App\ManageText;
use App\ValidationText;
use App\CaseComment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Str;
use Storage;
use File;
use App\NotificationText;
class CaseController extends Controller
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
        $cases=Story::with('category')->get();
        $website_lang=ManageText::all();
        return view('admin.case.case.index',compact('cases','website_lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function destroy(Story $case)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $old_thumbnail=$case->image;
        
        $case->delete();

        if(File::exists(public_path($old_thumbnail)))unlink(public_path($old_thumbnail));
      

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.case.index')->with($notification);
    }

    // manage case status
    public function changeStatus($id){
        $case=Story::find($id);
        if($case->status==1){
            $case->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $case->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $case->save();
        return response()->json($message);

    }


}
