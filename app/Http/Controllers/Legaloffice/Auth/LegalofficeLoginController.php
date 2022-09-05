<?php

namespace App\Http\Controllers\Legaloffice\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Admin;
use App\Legaloffice;
use App\BannerImage;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Hash;
class LegalofficeLoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/legaloffice/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:legal')->except('legalLogout');
    }


    public function legalLoginForm(){
        $image=BannerImage::first();
        $website_lang=ManageText::all();
        return view('legaloffice.auth.login',compact('image','website_lang'));
    }

    public function storeLoginInfo(Request $request){
        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required|email',
            'password'=>'required',
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang
        ];
        $this->validate($request, $rules, $customMessages);



        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $isDoctor=Legaloffice::where('email',$request->email)->first();
        if($isDoctor){
            if(Hash::check($request->password,$isDoctor->password)){
                if(Auth::guard('legal')->attempt($credential,$request->remember)){

                    $notify_lang=NotificationText::all();
                    $notification=$notify_lang->where('lang_key','login')->first()->custom_lang;
                    $notification=array('messege'=>$notification,'alert-type'=>'success');

                    return Redirect()->intended(route('legaloffice.dashboard'))->with($notification);
                }

                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return Redirect()->back()->withInput($request->only('email,remember'))->with($notification);
            }else{

                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','credential')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return back()->with($notification);
            }

        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','credential')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return back()->with($notification);
        }



    }

    public function legalLogout(){
        Auth::guard('legal')->logout();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','logout')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('legaloffice.login')->with($notification);
    }

}
