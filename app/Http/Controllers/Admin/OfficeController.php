<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Office;
use App\Legaloffice;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $offices=Office::all();
        $legaloffices=Legaloffice::all();
        $website_lang=ManageText::all();
        return view('admin.office.index',compact('offices','legaloffices','website_lang'));
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
            'office'=>'required|unique:offices',
        ];
        $customMessages = [
            'office.required' => $valid_lang->where('lang_key','req_office')->first(),
            'office.unique' => $valid_lang->where('lang_key','req_office')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        Office::create([
            'office'=>$request->office,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.office.index')->with($notification);
    }


    public function update(Request $request, Office $office)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'office'=>'required|unique:offices,office,'.$office->id,
        ];
        $customMessages = [
            'office.required' => $valid_lang->where('lang_key','req_office')->first(),
            'office.unique' => $valid_lang->where('lang_key','req_office')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        $office->office=$request->office;
        $office->status=$request->status;
        $office->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.office.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Desgination  $desgination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $office>delete();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.office.index')->with($notification);
    }



    public function changeStatus($id){
        $office=Office::find($id);
        if($office->status==1){
            $office->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $office->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $office->save();
        return response()->json($message);

    }
}
