<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\ManagePage;
use App\Opportunity;
use App\Opportunitytypes;
Use App\Application;
use App\MeetingHistory;
use App\BannerImage;
use App\Navigation;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Hash;
use Image;
use File;
use Illuminate\Pagination\Paginator;

class ApplicationController extends Controller
{
    protected $banner;

    public function __construct()
    {

        
        $this->title_meta=ManagePage::first();
        $this->middleware('auth:web');
        $this->banner=BannerImage::first();
    }

    public function application($id){
        $opportunity=Opportunity::all()->where('id',$id)->first();
        $title_meta=$this->title_meta;
        $user=Auth::user();
        $website_lang=ManageText::all();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.application.index',compact('user','banner','title_meta','opportunity','navigation','website_lang'));
    
    }

    
    public function applicationStore(Request $request)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $user=Auth::guard('web')->user();

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
              'email'=>'required',
            'phone'=>'required',
            'cv'=>'required',
           
          
           
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
             'cv.required' => $valid_lang->where('lang_key','req_cv')->first(),
            
        ];
        $this->validate($request, $rules, $customMessages);

        $pdf=$request->cv;
        $extention=$pdf->getClientOriginalExtension();
        $pdf_path= time().'.'.$extention;
        
        $request->cv->move('uploads/pdf',$pdf_path);
       

        $apply=$request->application;
        $extention=$apply->getClientOriginalExtension();
        $apply_path= time().'.'.$extention;
        
        $request->application->move('uploads/pdf',$apply_path);
       
       

        $application=Application::create([
            'job_id'=>$request->job_id,
                'name'=>$request->name,
                'application'=>$apply_path,
               'cv'=>$pdf_path,
                 
                  'email'=>$request->email,
                
                'phone'=>$request->phone,
                
                
            ]);
         $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);;
    }

}