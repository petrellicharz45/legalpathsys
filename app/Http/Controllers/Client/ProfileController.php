<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Application;
use App\Opportunity;
use App\Opportunitytype;
use App\Library;
use App\ViewBook;
use App\Story;
use App\CaseCategory;
use App\User;
use App\Order;
use App\Appointment;
use App\Setting;
use App\BannerImage;
use App\ManagePage;
use Hash;
use Image;
use File;
use App\ManageText;
use App\Navigation;
use App\ValidationText;
use App\NotificationText;
use App\ContactInformation;
use Illuminate\Pagination\Paginator;
class ProfileController extends Controller
{
    protected $banner;
    public function __construct()
    {
        $this->title_meta=ManagePage::first();
      
        $this->middleware('auth:web');
        $this->banner=BannerImage::first();
    }
    public function dashboard(){
        $user=Auth::user();
        $views=ViewBook::where('user_id',$user->id)->first();
        $mybooks=Library::where('id',$views->book_id)->get();
        $books=Library::where('id','!=',$views->book_id)->get();
        $stories=Story::where('user_id',$user->id)->get();
$others=Story::where('user_id','!=',$user->id)->get();
        $storyCategories=CaseCategory::all();
        $appointments=Appointment::where('user_id',$user->id)->get();
        $orders=Order::where('user_id',$user->id)->get();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.dashboard',compact('user','views','mybooks','books','storyCategories','others','stories','appointments','orders','banner','navigation','website_lang'));
    }

    public function account(){
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.account',compact('user','banner','navigation','website_lang'));
    }

    public function appointments(){
        $user=Auth::user();
        $currency=Setting::first();
        Paginator::useBootstrap();
        $appointments=Appointment::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.appointment',compact('user','appointments','currency','banner','navigation','website_lang'));
    }

    public function downloadFile($file){
        $filepath= public_path() . "/uploads/custom-images/".$file;
        return response()->download($filepath);
    }


    public function showAppointment($id){
        $user=Auth::user();
        $currency=Setting::first();
        $appointment=Appointment::find($id);
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        $setting=Setting::first();
        if($appointment){
            if($appointment->user_id==$user->id){
                if($appointment->already_treated==1){
                    $isRtl=$setting->text_direction;
                    return view('client.profile.show-appointment',compact('user','appointment','currency','banner','navigation','website_lang','setting','isRtl'));
                }else{
                    $notify_lang=NotificationText::all();
                    $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
                    $notification=array('messege'=>$notification,'alert-type'=>'error');

                    return redirect()->route('client.appointment')->with($notification);
                }
            }else{
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return redirect()->route('client.appointment')->with($notification);
            }
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','wrong')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('client.appointment')->with($notification);
        }
    }

    public function orders(){
        $user=Auth::user();
        Paginator::useBootstrap();
        $orders=Order::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        $currency=Setting::first();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.order',compact('user','orders','currency','banner','navigation','website_lang'));
    }


    public function showOrder($id){
        $order=Order::find($id);
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $text=ManageText::first();
        $currency=Setting::first();
        $setting=Setting::first();
        $contact=ContactInformation::first();
        $website_lang=ManageText::all();
        return view('client.profile.show-order',compact('user','order','banner','navigation','text','currency','setting','contact','website_lang'));
    }

    public function storyCreate()
    {

        $user=Auth::user();
        $categories=CaseCategory::all();
        $website_lang=ManageText::all();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.story',compact('user','banner','categories','navigation','website_lang'));
    
        
        
    }

   


     public function storyStore(Request $request)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $user=Auth::guard('web')->user();

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
       

        $story=Story::create([
            'user_id'=>$user->id,
                'title'=>$request->title,
                
               'image'=>$name,
                 
                  'case_category_id'=>$request->case_category_id,
                
                'description'=>$request->description,
                
                
            ]);
         $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }


    public function applicationStore(Request $request)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $user=Auth::guard('web')->user();

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
              'email'=>'required',
            'phone'=>'required',
            'cv'=>'required',
            'application'=>'required',
          
           
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
             'cv.required' => $valid_lang->where('lang_key','req_cv')->first(),
             'application.required' => $valid_lang->where('lang_key','req_application')->first(),
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->cv;
        $extention=$image->getClientOriginalExtension();
        $name= 'application-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->cv->move('uploads/pdf',$name);

        $app=$request->apllication;
        $extention=$app->getClientOriginalExtension();
        $apply= 'application-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        

        
        $request->application->move('uploads/pdf',$apply);
       

        $application=Apllication::create([
            'job_id'=>$request->job_id,
                'name'=>$request->name,
                'application'=>$apply,
               'cv'=>$name,
                 
                  'email'=>$request->email,
                
                'phone'=>$request->phone,
                
                
            ]);
         $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return view('client.opportunity.index')->with($notification);
    }
    public function view($pdf){
        $libraries=Library::all()->where('pdf',$pdf)->first();
        $user=Auth::guard('web')->user();
        
       
            return view('client.library.viewpdf',compact('libraries'));
    
    }
    

    public function updateProfile(Request $request) {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.Auth::user()->id,
            'phone'=>'required',
            'age'=>'required',
            'occupation'=>'required',
            'gender'=>'required',
            'address'=>'required',
            'country'=>'required',
            'city'=>'required',
        ];

        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','req_name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','req_email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','req_phone')->first()->custom_lang,
            'age.required' => $valid_lang->where('lang_key','req_age')->first()->custom_lang,
            'occupation.required' => $valid_lang->where('lang_key','req_occupation')->first()->custom_lang,
            'gender.required' => $valid_lang->where('lang_key','req_gender')->first()->custom_lang,
            'address.required' => $valid_lang->where('lang_key','req_address')->first()->custom_lang,
            'country.required' => $valid_lang->where('lang_key','req_country')->first()->custom_lang,
            'city.required' => $valid_lang->where('lang_key','req_city')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);



        $current_user=Auth::user();
        $image_name=$current_user->image;

        // inset user profile image
        if($request->file('image')){
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= $request->name.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->resize(1000,null,function ($constraint) {
                    $constraint->aspectRatio();
                })

                ->save(public_path($image_name));


            $old_image=User::where('id',Auth::user()->id)->first();
            if($old_image->image)
            {
                if(File::exists(public_path($old_image->image)))unlink(public_path($old_image->image));

            }
        }

        User::where('id',Auth::user()->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'guardian_name'=>$request->guardian_name,
            'guardian_phone'=>$request->guardian_phone,
            'age'=>$request->age,
            'occupation'=>$request->occupation,
            'gender'=>$request->gender,
            'address'=>$request->address,
            'country'=>$request->country,
            'city'=>$request->city,
            'image'=>$image_name,
            'date_of_birth'=>$request->date_of_birth,
            'ready_for_appointment'=>1
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return back()->with($notification);


    }

    public function changePassword(){
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $website_lang=ManageText::all();
        return view('client.profile.change-password',compact('user','banner','navigation','website_lang'));
    }
    public function storePassword(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'password'=>'required|confirmed',
        ];

        $customMessages = [
            'password.required' => $valid_lang->where('lang_key','req_pass')->first()->custom_lang,
            'password.confirmed' => $valid_lang->where('lang_key','confirm_pass')->first()->custom_lang,


        ];
        $this->validate($request, $rules, $customMessages);


        $user=Auth::user();
        $user->password=Hash::make($request->password);
        $user->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return back()->with($notification);
    }


}
