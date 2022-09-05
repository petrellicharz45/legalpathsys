<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Opportunitytype;
use App\Opportunity;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Illuminate\Http\Request;

class OpportunitytypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $opportunitytypes=Opportunitytype::all();
        $opportunity=Opportunity::all();
        $website_lang=ManageText::all();
        return view('admin.opportunitytype.index',compact('opportunitytypes','opportunity','website_lang'));
    }


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
            'type'=>'required|unique:opportunitytypes',
        ];
        $customMessages = [
            'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            'type.unique' => $valid_lang->where('lang_key','req_type')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        Opportunitytype::create([
            'type'=>$request->type,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.opportunitytype.index')->with($notification);
    }


    public function update(Request $request, Opportunitytype $opportunitytype)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'type'=>'required|unique:opportunitytypes,type,'.$opportunitytype->id,
        ];
        $customMessages = [
            'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            'type.unique' => $valid_lang->where('lang_key','req_type')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        $opportunitytype->type=$request->type;
        $opportunitytype->status=$request->status;
        $opportunitytype->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.opportunitytype.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Opportunitytype  $opportunitytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opportunitytype $opportunitytype)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $opportunitytype->delete();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.opportunitytype.index')->with($notification);
    }



    public function changeStatus($id){
        $opportunitytype=Opportunitytype::find($id);
        if($opportunitytype->status==1){
            $opportunitytype->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $opportunitytype->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $opportunitytype->save();
        return response()->json($message);

    }
}
