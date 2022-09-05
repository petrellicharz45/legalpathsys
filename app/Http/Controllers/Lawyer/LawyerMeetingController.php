<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;

use App\ZoomMeeting;
use App\ZoomCredential;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;
use Auth;
use App\Appointment;
use App\EmailTemplate;
use App\User;
use Mail;
use App\Mail\SendZoomMeetingLink;
use App\Helpers\MailHelper;
use App\MeetingHistory;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class LawyerMeetingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function __construct()
    {
        $this->middleware('auth:lawyer');
    }


    public function index(){
        $lawyer=Auth::guard('lawyer')->user();
        $meetings=ZoomMeeting::where('lawyer_id',$lawyer->id)->orderBy('start_time','desc')->get();
        $website_lang=ManageText::all();
        return view('lawyer.zoom.meeting.index',compact('meetings','website_lang'));
    }

    public function show($id)
    {
        $meeting = $this->get($id);
        $website_lang=ManageText::all();
        return view('meetings.index', compact('meeting','website_lang'));
    }

    public function createForm(){
        $lawyer=Auth::guard('lawyer')->user();
        $appointments=Appointment::where('lawyer_id',$lawyer->id)->select('user_id')->groupBy('user_id')->get();
        $patients=$appointments;
        $users=User::whereIn('id',$patients)->get();
        $website_lang=ManageText::all();
        return view('lawyer.zoom.meeting.create',compact('patients','users','website_lang'));
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
            'topic'=>'required',
            'client'=>'required',
            'start_time'=>'required',
            'duration'=>'required|numeric',
        ];

        $customMessages = [
            'topic.required' => $valid_lang->where('lang_key','req_topic')->first()->custom_lang,
            'client.required' => $valid_lang->where('lang_key','req_client')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','req_start_time')->first()->custom_lang,
            'duration.required' => $valid_lang->where('lang_key','req_duration')->first()->custom_lang,

        ];
        $this->validate($request, $rules, $customMessages);


        $lawyer=Auth::guard('lawyer')->user();
        $data=array();
        $data['start_time']=$request->start_time;
        $data['topic']=$request->topic;
        $data['duration']=$request->duration;
        $data['agenda']=$lawyer->name;
        $data['host_video']=1;
        $data['participant_video']=1;
        $response= $this->create($data);
        if($response['success']){
            $meeting=new ZoomMeeting();
            $meeting->lawyer_id=$lawyer->id;
            $meeting->start_time=date('Y-m-d H:i:s',strtotime($response['data']['start_time']));
            $meeting->topic=$request->topic;
            $meeting->duration=$request->duration;
            $meeting->meeting_id=$response['data']['id'];
            $meeting->password=$response['data']['password'];
            $meeting->join_url=$response['data']['join_url'];
            $meeting->save();




            if($request->client==-1){
                $lawyer=Auth::guard('lawyer')->user();
                $appointments=Appointment::where('lawyer_id',$lawyer->id)->select('user_id')->groupBy('user_id')->get();
                $clients=$appointments;
                $users=User::whereIn('id',$clients)->get();
                $meeting_link=$response['data']['join_url'];
                foreach($users as $user){
                    $history=new MeetingHistory();
                    $history->lawyer_id=$lawyer->id;
                    $history->user_id=$user->id;
                    $history->meeting_id=$meeting->meeting_id;
                    $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                    $history->duration=$meeting->duration;
                    $history->save();

                    // send email
                    $template=EmailTemplate::where('id',8)->first();
                    $message=$template->description;
                    $subject=$template->subject;
                    $message=str_replace('{{client_name}}',$user->name,$message);
                    $message=str_replace('{{lawyer_name}}',$lawyer->name,$message);
                    $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                    MailHelper::setMailConfig();
                    Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
                }
            }else{

                $user=User::where('id',$request->client)->first();
                $meeting_link=$response['data']['join_url'];
                $history=new MeetingHistory();
                $history->lawyer_id=$lawyer->id;
                $history->user_id=$user->id;
                $history->meeting_id=$meeting->meeting_id;
                $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                $history->duration=$meeting->duration;
                $history->save();

                // send email
                $template=EmailTemplate::where('id',8)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{client_name}}',$user->name,$message);
                $message=str_replace('{{lawyer_name}}',$lawyer->name,$message);
                $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
            }


            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->back()->with($notification);
        }

    }

    public function editForm($id){
        $meeting=ZoomMeeting::find($id);
        if($meeting){
            $lawyer=Auth::guard('lawyer')->user();
            if($meeting->lawyer_id){
                $lawyer=Auth::guard('lawyer')->user();
                $appointments=Appointment::where('lawyer_id',$lawyer->id)->select('user_id')->groupBy('user_id')->get();
                $client=$appointments;
                $users=User::whereIn('id',$client)->get();
                $website_lang=ManageText::all();
                return view('lawyer.zoom.meeting.edit',compact('meeting','users','website_lang'));
            }else{
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return redirect()->route('lawyer.zoom-meetings')->with($notification);
            }
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }

    }
    public function updateMeeting($id, Request $request)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'topic'=>'required',
            'client'=>'required',
            'start_time'=>'required',
            'duration'=>'required|numeric',
        ];

        $customMessages = [
            'topic.required' => $valid_lang->where('lang_key','req_topic')->first()->custom_lang,
            'client.required' => $valid_lang->where('lang_key','req_client')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','req_start_time')->first()->custom_lang,
            'duration.required' => $valid_lang->where('lang_key','req_duration')->first()->custom_lang,

        ];
        $this->validate($request, $rules, $customMessages);


        $lawyer=Auth::guard('lawyer')->user();
        $data=array();
        $data['start_time']=$request->start_time;
        $data['topic']=$request->topic;
        $data['duration']=$request->duration;
        $data['agenda']=$lawyer->name;
        $data['host_video']=1;
        $data['participant_video']=1;

        $response=$this->update($id, $data);

        if($response['success']){
            $success=$response['data'];

            $meeting=ZoomMeeting::where('meeting_id',$id)->first();
            $meeting->lawyer_id=$lawyer->id;
            $meeting->start_time=date('Y-m-d H:i:s',strtotime($success['data']['start_time']));
            $meeting->topic=$request->topic;
            $meeting->duration=$request->duration;
            $meeting->meeting_id=$success['data']['id'];
            $meeting->password=$success['data']['password'];
            $meeting->join_url=$success['data']['join_url'];
            $meeting->save();


            if($request->client==-1){
                $lawyer=Auth::guard('lawyer')->user();
                $appointments=Appointment::where('lawyer_id',$lawyer->id)->select('user_id')->groupBy('user_id')->get();
                $clients=$appointments;
                $users=User::whereIn('id',$clients)->get();
                $meeting_link=$success['data']['join_url'];
                foreach($users as $user){
                    $history=new MeetingHistory();
                    $history->lawyer_id=$lawyer->id;
                    $history->user_id=$user->id;
                    $history->meeting_id=$meeting->meeting_id;
                    $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                    $history->duration=$meeting->duration;
                    $history->save();

                    // send email
                    $template=EmailTemplate::where('id',8)->first();
                    $message=$template->description;
                    $subject=$template->subject;
                    $message=str_replace('{{client_name}}',$user->name,$message);
                    $message=str_replace('{{lawyer_name}}',$lawyer->name,$message);
                    $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);

                    MailHelper::setMailConfig();
                    Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
                }
            }else{
                $user=User::where('id',$request->client)->first();
                $meeting_link=$success['data']['join_url'];
                $history=new MeetingHistory();
                $history->lawyer_id=$lawyer->id;
                $history->user_id=$user->id;
                $history->meeting_id=$meeting->meeting_id;
                $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                $history->duration=$meeting->duration;
                $history->save();
                // send email
                $template=EmailTemplate::where('id',8)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{client_name}}',$user->name,$message);
                $message=str_replace('{{lawyer_name}}',$lawyer->name,$message);
                $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
            }


            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }
    }

    public function destroy($id)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $meeting=ZoomMeeting::find($id);
        $response=$this->delete($meeting->meeting_id);
        if($response['success']){
            MeetingHistory::where('meeting_id',$meeting->meeting_id)->delete();
            MeetingHistory::where('meeting_id',$meeting->meeting_id)->delete();
            $meeting_id=$meeting->meeting_id;
            ZoomMeeting::where('meeting_id',$meeting_id)->delete();

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('lawyer.zoom-meetings')->with($notification);
        }
    }



    public function meetingHistory(){
        $lawyer=Auth::guard('lawyer')->user();
        $histories=MeetingHistory::where('lawyer_id',$lawyer->id)->orderBy('meeting_time','desc')->get();
        $website_lang=ManageText::all();
        return view('lawyer.zoom.meeting.history',compact('histories','website_lang'));
    }

    public function upCommingMeeting(){
        $lawyer=Auth::guard('lawyer')->user();
        $histories=MeetingHistory::where('lawyer_id',$lawyer->id)->orderBy('meeting_time','desc')->get();
        $website_lang=ManageText::all();
        return view('lawyer.zoom.meeting.upcoming',compact('histories','website_lang'));
    }
}
