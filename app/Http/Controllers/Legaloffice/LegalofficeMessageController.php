<?php

namespace App\Http\Controllers\Legaloffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\Message;
use App\User;
use App\BannerImage;
use App\ManageText;
use Auth;
use Pusher\Pusher;
class LegalofficeMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:legal');
    }
    public function index(){
        $legals=Auth::guard('legal')->user();
        $users=Appointment::with('user')->where('lawyer_id',$legals->id)->groupBy('user_id')->select('user_id')->get();
        $profile_image=BannerImage::first();
        $profile_image=$profile_image->default_profile;
        $website_lang=ManageText::all();
        return view('legaloffice.message.index',compact('users','profile_image','website_lang'));
    }

    public function messageBox($id){
        $user=User::find($id);
        $user_id=$user->id;
        $legal=Auth::guard('legal')->user();
        $my_id=$legals->id;
        Message::where(['lawyer_id'=>$my_id,'user_id'=>$user_id])->update(['lawyer_view'=>1]);

        $messages = Message::where(['lawyer_id'=>$my_id,'user_id'=>$user_id])->get();


        $users=Appointment::with('user')->where('lawyer_id',$legals->id)->groupBy('user_id')->select('user_id')->get();
        $profile_image=BannerImage::first();
        $profile_image=$profile_image->default_profile;

        $website_lang=ManageText::all();
        return view('lawyer.message.single-message',compact('users','profile_image','messages','user_id','website_lang'));


    }

    public function getMessage($user_id){

        $legals=Auth::guard('legal')->user();
        $my_id=$legals->id;
        Message::where(['lawyer_id'=>$my_id,'user_id'=>$user_id])->update(['lawyer_view'=>1]);

        $messages = Message::where(['lawyer_id'=>$my_id,'user_id'=>$user_id])->get();
        $website_lang=ManageText::all();
        return view('legaloffice.message.message-box',compact('messages','website_lang'));

    }

    public function sendMessage(Request $request){
        $this->validate($request,[
            'receiver_id'=>'required',
            'message'=>'required'
        ]);


        $legals=Auth::guard('legal')->user();
        Message::create([
            'lawyer_id'=>$legals->id,
            'user_id'=>$request->receiver_id,
            'message'=>$request->message,
            'send_lawyer'=>$legals->id
        ]);

       return response()->json(['user_id'=>$request->receiver_id]);

    }
}
