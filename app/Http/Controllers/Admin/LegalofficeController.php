<?php
namespace App\Http\Controllers\Admin;

use App\Legaloffice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Office;
use App\Department;
use App\Location;
use App\Mail\LegalofficeLoginInformation;
use Mail;
use Image;
use File;
use Str;
use Hash;
use App\Setting;
use App\EmailTemplate;
use App\Schedule;
use App\Message;
use App\Appointment;
use App\Helpers\MailHelper;
use App\MeetingHistory;
use App\ZoomMeeting;
use App\ZoomCredential;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class LegalofficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {

        $legals=Legaloffice::all();
        $currency=Setting::first();
        $schedules=Schedule::all();
        $messages=Message::all();
        $appointments=Appointment::all();
        $website_lang=ManageText::all();
        return view('admin.legaloffice.index',compact('legals','currency','schedules','messages','appointments','website_lang'));
    }


    public function create()
    {
      
        $locations=Location::orderBy('location','asc')->get();
        $offices=Office::orderBy('office','asc')->get();
        $website_lang=ManageText::all();
        return view('admin.legaloffice.create',compact('locations','offices','website_lang'));
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
            'name'=>'required',
            'email'=>'required|unique:legaloffices',
            'phone'=>'required',
            'password'=>'required',
            'office'=>'required',
            'image'=>'required',
           
            'location'=>'required',
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang,
            'office.required' => $valid_lang->where('lang_key','req_office')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first()->custom_lang,
            
            'location.required' => $valid_lang->where('lang_key','req_location')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'legaloffice-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        $image_path='uploads/custom-images/'.$name;
        Image::make($image)
            ->resize(500,null,function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path($image_path));


        $legaloffice=Legaloffice::create([
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'email'=>$request->email,
                'phone'=>$request->phone,
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'linkedin'=>$request->linkedin,
                'password'=>Hash::make($request->password),
                'office'=>$request->office,
                'image'=>$image_path,
                'location_id'=>$request->location,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'about'=>$request->about,
                'address'=>$request->address,
                'experience'=>$request->experiences,
                'status'=>$request->status,
                'show_homepage'=>$request->show_homepage
            ]);

        $website_lang=ManageText::all();
        $login_here_text=$website_lang->where('lang_key','legaloffice_login_here')->first();

        $template=EmailTemplate::where('id',3)->first();
        $message=$template->description;
        $subject=$template->subject;
        $message=str_replace('{{legaloffice_name}}',$legaloffice->name,$message);
        $message=str_replace('{{email}}',$legaloffice->email,$message);
        $message=str_replace('{{password}}',$request->password,$message);
        MailHelper::setMailConfig();
        Mail::to($legaloffice->email)->send(new LegalofficeLoginInformation($message,$subject,$login_here_text));
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }


    public function edit(Legaloffice $legals)
    {

        $locations=Location::orderBy('location','asc')->get();
        $offices=Office::orderBy('office','asc')->get();
        $website_lang=ManageText::all();
        return view('admin.legaloffice.edit',compact('locations','offices','legals','website_lang'));
    }


   
    public function update(Request $request, Legaloffice $legals)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


       
        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:legaloffices',
            'phone'=>'required',
            'password'=>'required',
            'office'=>'required',
            'image'=>'required',
           
            'location'=>'required',
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang,
            'office.required' => $valid_lang->where('lang_key','req_office')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first()->custom_lang,
            
            'location.required' => $valid_lang->where('lang_key','req_location')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'legaloffice-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        $image_path='uploads/custom-images/'.$name;
        Image::make($image)
            ->resize(500,null,function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path($image_path));


        Legaloffice::where('id',$legals->id)->update([
            'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'email'=>$request->email,
                'phone'=>$request->phone,
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'linkedin'=>$request->linkedin,
                'password'=>Hash::make($request->password),
                'office'=>$request->office,
                'image'=>$image_path,
                'location_id'=>$request->location,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'about'=>$request->about,
                'address'=>$request->address,
                'experience'=>$request->experiences,
                'status'=>$request->status,
                'show_homepage'=>$request->show_homepage
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.legaloffice.index')->with($notification);

    }


    public function destroy(Request $request, $id)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $legals=Legaloffice::find($id);
    
        $legal_id=$id;
        Message::where('lawyer_id',$legal_id)->delete();
        MeetingHistory::where('lawyer_id',$legal_id)->delete();
        ZoomMeeting::where('lawyer_id',$legal_id)->delete();
        ZoomCredential::where('lawyer_id',$legal_id)->delete();
        $legals->delete();

    

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.legaloffice.index')->with($notification);
    }

     // change lawer status
     public function changeStatus(Request $request, $id){
        $legals=Legaloffice::find($id);
        if($legals->status==1){
            $legals->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $legals->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $legals->save();
        return response()->json($message);

    }
}
