<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Opportunity;
use App\Opportunitytype;
use App\ManageText;
use App\ValidationText;
use Auth;

use Image;
use Str;
use Storage;
use File;
use App\NotificationText;
class LawyerOpportunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:lawyer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('lawyer')->user();
        $opportunity=Opportunity::with('type')->where('user_id',$user->id)->get();
        $website_lang=ManageText::all();
        return view('lawyer.opportunity.index',compact('opportunity','website_lang'));
    }

    public function create()
    {
        $opportunitytypes=Opportunitytype::orderBy('type','asc')->get();
      
   
        $website_lang=ManageText::all();
        return view('lawyer.opportunity.create',compact('opportunitytypes','website_lang'));
    }


    public function store(Request $request)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $user=Auth::guard('lawyer')->user();

        $valid_lang=ValidationText::all();
        $rules = [
            'title'=>'required',
            'company'=>'required',
            'position'=>'required',
            'salary'=>'required',
            'file'=>'required',
        
            'type'=>'required',
        ];
        $customMessages = [
            'title.required' => $valid_lang->where('lang_key','req_title')->first()->custom_lang,
            'company.required' => $valid_lang->where('lang_key','req_company')->first(),
            'file.required' => $valid_lang->where('lang_key','unique_file')->first(),
            'salary.required' => $valid_lang->where('lang_key','req_salary')->first(),
           
            'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            'position.required' => $valid_lang->where('lang_key','req_position')->first(),
          
        ];
        $this->validate($request, $rules, $customMessages);

        $file=$request->file;
        $extention=$file->getClientOriginalExtension();
        $name= 'story-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->file->move('uploads/pdf',$name);
       

        $opportunity=Opportunity::create([
            'user_id'=>$user->id,
                'title'=>$request->title,
                'company'=>$request->company,
                'position'=>$request->position,
                'salary'=>$request->salary,
                'closing_date'=>$request->closing,
                'apply_link'=>$request->link,
                'quick_apply'=>$request->apply,
                'file'=>$name,
                'type_id'=>$request->type,
                'status'=>$request->status,
                'description'=>$request->description,
            ]);

        $website_lang=ManageText::all();
      
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('lawyer.opportunity.index')->with($notification);
    }


    public function edit(Opportunity $opportunity)
    {

        $opportunitytypes=Opportunitytype::orderBy('type','asc')->get();
        $website_lang=ManageText::all();
        return view('lawyer.opportunity.edit',compact('opportunity','opportunitytypes','website_lang'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'title'=>'required',
            'company'=>'required',
            'position'=>'required',
            'salary'=>'required',
            'file'=>'required',
        
            'type'=>'required',
        ];
        $customMessages = [
            'title.required' => $valid_lang->where('lang_key','req_title')->first()->custom_lang,
            'company.required' => $valid_lang->where('lang_key','req_company')->first(),
            'file.required' => $valid_lang->where('lang_key','unique_file')->first(),
            'salary.required' => $valid_lang->where('lang_key','req_salary')->first(),
           
            'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            'position.required' => $valid_lang->where('lang_key','req_position')->first(),
          
        ];
        $this->validate($request, $rules, $customMessages);

        $file=$request->file;
        $extention=$file->getClientOriginalExtension();
        $name= 'story-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->file->move('uploads/pdf',$name);
       

        Opportunity::where('id',$opportunity->id)->update([
            'title'=>$request->title,
            'company'=>$request->company,
            'position'=>$request->position,
            'salary'=>$request->salary,
            'closing_date'=>$request->closing,
            'file'=>$name,
            'apply_link'=>$request->link,
            'quick_apply'=>$request->apply,
            'type_id'=>$request->type,
            'status'=>$request->status,
            'description'=>$request->description,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('lawyer.opportunity.index')->with($notification);

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

        return redirect()->route('lawyer.opportunity.index')->with($notification);
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
