<?php

namespace App\Http\Controllers\Admin;

use App\ProbonoCase;
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
class ProbonoCaseController extends Controller
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
        $probonos=ProbonoCase::with('category')->get();
        $website_lang=ManageText::all();
        return view('admin.probono.index',compact('probonos','website_lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=CaseCategory::all();
        $website_lang=ManageText::all();
        return view('admin.probono.create',compact('categories','website_lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
              'case_category_id'=>'required',
            'description'=>'required',
            'image'=>'required',
          
           
        ];
        $customMessages = [
            'title.required' => $valid_lang->where('lang_key','req_book_tile')->first(),
            'description.required' => $valid_lang->where('lang_key','req_description')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first(),
             'case_category_id.required' => $valid_lang->where('lang_key','req_category')->first(),
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'story-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->image->move('uploads/pdf',$name);
       


        ProbonoCase::create([
           
            'title'=>$request->title,
            
           'image'=>$name,
             
              'case_category_id'=>$request->case_category_id,
            
            'description'=>$request->description,
            
            
        ]);


        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.probono.index')->with($notification);
    }


    public function edit(ProbonoCase $probono)
    {
        $categories=CaseCategory::all();
        $website_lang=ManageText::all();
        return view('admin.probono.edit',compact('categories','probono','website_lang'));
    }


    public function update(Request $request, ProbonoCase $probono)
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
              'case_category_id'=>'required',
            'description'=>'required',
            'image'=>'required',
          
           
        ];
        $customMessages = [
            'title.required' => $valid_lang->where('lang_key','req_book_tile')->first(),
            'description.required' => $valid_lang->where('lang_key','req_description')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first(),
             'case_category_id.required' => $valid_lang->where('lang_key','req_category')->first(),
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'story-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->image->move('uploads/pdf',$name);
       



        $probono->title=$request->title;
        
       $probono->image=$name;
         
        $probono->case_category_id=$request->case_category_id;
        
        $probono->description=$request->description;
        
            $probono->save();

            // delete Old Image
            if(File::exists(public_path($name)))unlink(public_path($name));

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.probono.index')->with($notification);

    }


    public function destroy(ProbonoCase $probono)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $old_thumbnail=$probono->image;
        
        $probono->delete();

        if(File::exists(public_path($old_thumbnail)))unlink(public_path($old_thumbnail));
      

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.probono.index')->with($notification);
    }
    // manage blog status
    public function changeStatus($id){
        $probono=ProbonoCase::find($id);
        if($probono->status==1){
            $probono->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $probono->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $probono->save();
        return response()->json($message);

    }


}
