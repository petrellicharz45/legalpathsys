<?php

namespace App\Http\Controllers\Legaloffice\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use App\Legaloffice;
use App\Mail\ForgetPassword;
use App\Mail\DoctorForgetPassword;
use Str;
use Mail;
use Hash;
use Auth;
use App\BannerImage;
use App\ManageText;
use App\ValidationText;
use App\EmailTemplate;
use App\Helpers\MailHelper;
use App\NotificationText;
class LegalofficeForgotPasswordController extends Controller
{
   public function forgetPassword(){
        $image=BannerImage::first();
        $website_lang=ManageText::all();
       return view('legaloffice.auth.forget-password',compact('image','website_lang'));
   }

   public function sendForgetEmail(Request $request){

    // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required'
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);

        $legals=Legaloffice::where('email',$request->email)->first();
        if($legals){
            $legals->forget_password_token=Str::random(100);
            $legals->save();

            $template=EmailTemplate::where('id',1)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{name}}',$legals->name,$message);

            $website_lang=ManageText::all();
            $reset_pass_text=$website_lang->where('lang_key','reset_password')->first()->custom_lang;

            MailHelper::setMailConfig();
            Mail::to($legals->email)->send(new DoctorForgetPassword($legals,$message,$subject,$reset_pass_text));

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','forget_pass')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return back()->with($notification);

        }else {

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','email_not_exist')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return back()->with($notification);
        }

   }

   public function resetPassword($token){
        $legals=Legaloffice::where('forget_password_token',$token)->first();
        $image=BannerImage::first();
        if($legals){
            $website_lang=ManageText::all();
            return view('legals.auth.reset-password',compact('legals','token','image','website_lang'));
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_token')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->route('legaloffice.forget.password')->with($notification);
        }
   }


   public function storeResetData(Request $request,$token){
        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required',
            'password'=>'required|confirmed'
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang,
            'password.confirmed' => $valid_lang->where('lang_key','confirm_pass')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);

        $legals=Legaloffice::where('forget_password_token',$token)->first();
        if($legals->email==$request->email){
            $legals->password=Hash::make($request->password);
            $legals->forget_password_token=null;
            $legals->save();

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','reset_pass')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return Redirect()->route('legaloffice.login')->with($notification);

        }else {
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','email_not_exist')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return back()->with($notification);
        }
   }


}
