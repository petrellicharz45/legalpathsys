<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Desgination;
use App\Lawyer;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Illuminate\Http\Request;

class DesginationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $desginations=Desgination::all();
        $lawyers=Lawyer::all();
        $website_lang=ManageText::all();
        return view('admin.desgination.index',compact('desginations','lawyers','website_lang'));
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
            'desgination'=>'required|unique:desginations',
        ];
        $customMessages = [
            'desgination.required' => $valid_lang->where('lang_key','req_desgination')->first(),
            'desgination.unique' => $valid_lang->where('lang_key','req_desgination')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        Desgination::create([
            'desgination'=>$request->desgination,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.desgination.index')->with($notification);
    }


    public function update(Request $request, Desgination $desgination)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'desgination'=>'required|unique:desginations,desgination,'.$desgination->id,
        ];
        $customMessages = [
            'desgination.required' => $valid_lang->where('lang_key','req_desgination')->first(),
            'desgination.unique' => $valid_lang->where('lang_key','req_desgination')->first(),
        ];
        $this->validate($request, $rules, $customMessages);

        $desgination->desgination=$request->desgination;
        $desgination->status=$request->status;
        $desgination->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.desgination.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Desgination  $desgination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desgination $desgination)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $desgination->delete();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.desgination.index')->with($notification);
    }



    public function changeStatus($id){
        $desgination=Desgination::find($id);
        if($desgination->status==1){
            $desgination->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $desgination->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $desgination->save();
        return response()->json($message);

    }
}
