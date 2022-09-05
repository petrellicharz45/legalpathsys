<?php

namespace App\Http\Controllers\Legaloffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Department;
use App\Location;
use App\Office;
use App\Legaloffice;
use App\ManageText;
use App\ValidationText;
use Auth;
use Image;
use File;
use Hash;
use App\NotificationText;
class LegalofficeProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:legal');
    }
    public function profile(){
        $legals=Auth::guard('legal')->user();
        $offices=Office::all();
        $website_lang=ManageText::all();
        return view('legaloffice.profile.index',compact('legals','offices','website_lang'));
    }

    public function updateProfile(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'phone'=>'required',
            'office'=>'required',
            'about'=>'required',
            'address'=>'required',
           
            'experiences'=>'required',
           
        ];

        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
            'office.required' => $valid_lang->where('lang_key','req_office')->first(),
            'about.required' => $valid_lang->where('lang_key','req_about')->first()->custom_lang,
            'address.required' => $valid_lang->where('lang_key','req_address')->first()->custom_lang,
            'experiences.required' => $valid_lang->where('lang_key','req_experience')->first()->custom_lang,

        ];
        $this->validate($request, $rules, $customMessages);



        if($request->image){
            $old_image=$request->old_image;
            $image=$request->image;
            $extention=$image->getClientOriginalExtension();
            $name= 'legal-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_path='uploads/custom-images/'.$name;


            Image::make($image)
                ->resize(500,null,function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->crop(300,320)
                ->save(public_path($image_path));

            Legaloffice::where('id',Auth::guard('legal')->user()->id)->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'image'=>$image_path,
                'office'=>$request->office,
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'linkedin'=>$request->linkedin,
                'about'=>$request->about,
                'address'=>$request->address,
               
                'experience'=>$request->experiences,
                
            ]);

            if(File::exists(public_path($old_image)))unlink(public_path($old_image));

        }else{
            Legaloffice::where('id',Auth::guard('legal')->user()->id)->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'office'=>$request->office,
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'linkedin'=>$request->linkedin,
                'about'=>$request->about,
                'address'=>$request->address,
               
                'experience'=>$request->experiences,
                
            ]);
        }



        $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');


        return redirect()->route('legaloffice.profile')->with($notification);
    }


    public function changePassword(Request $request){
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'password'=>'required|confirmed'
        ];

        $customMessages = [
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang,
            'password.confirmed' => $valid_lang->where('lang_key','confirm_pass')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);


        Legaloffice::where('id',Auth::guard('legal')->user()->id)->update(['password'=>Hash::make($request->password)]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');


        return redirect()->route('legaloffice.profile')->with($notification);
    }



    public function prescriptionContactUpdate(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
        $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
        return redirect()->back()->with($notification);
        }
        // end
        $valid_lang=ValidationText::all();
        $rules = [
            'prescription_email'=>'required',
            'prescription_phone'=>'required',
            'prescription_address'=>'required',
        ];

        $customMessages = [
            'prescription_email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'prescription_phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
            'prescription_address.required' => $valid_lang->where('lang_key','req_address')->first()->custom_lang
        ];
        $this->validate($request, $rules, $customMessages);


        $legals=Auth::guard('legal')->user();
        $legals->prescription_email=$request->prescription_email;
        $legals->prescription_phone=$request->prescription_phone;
        $legals->prescription_address=$request->prescription_address;
        $legals->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->back()->with($notification);
    }

}
