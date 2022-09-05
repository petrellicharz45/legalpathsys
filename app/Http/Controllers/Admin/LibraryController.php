<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Library;
use App\Category;
use App\Department;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use Illuminate\Http\Request;

use Image;
use File;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $departments=Department::all();
          $categories=Category::all();
        $library=Library::all();
              $website_lang=ManageText::all();
        return view('admin.library.index',compact('library','website_lang'));
    }
     public function create()
    {
        $departments=Department::orderBy('name','asc')->get();
          $categories=Category::orderBy('category','asc')->get();
        $library=Library::all();
              $website_lang=ManageText::all();
        return view('admin.library.create',compact('library','departments','categories','website_lang'));
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
            'book_title'=>'required',
            'author'=>'required',
            'pdf'=>'required',
             'type'=>'required',
              'category'=>'required',
            'description'=>'required',
            'image'=>'required',
            'show_homepage'=>'required',
           
        ];
        $customMessages = [
            'book_title.required' => $valid_lang->where('lang_key','req_book_tile')->first(),
            'author.required' => $valid_lang->where('lang_key','req_author')->first(),
            'pdf.unique' => $valid_lang->where('lang_key','req_pdf')->first(),
            'description.required' => $valid_lang->where('lang_key','req_description')->first(),
            'show_homepage.required' => $valid_lang->where('lang_key','req_show_homepage')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first(),
             'category.required' => $valid_lang->where('lang_key','req_category')->first(),
                'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            
        ];
        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'library-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        $image_path='uploads/custom-images/'.$name;
        Image::make($image)
            ->resize(500,null,function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path($image_path));


 $pdf=$request->pdf;
        $extention=$pdf->getClientOriginalExtension();
        $pdf_path= time().'.'.$extention;
        
        $request->pdf->move('uploads/pdf',$pdf_path);
       

        $library=Library::create([
                'book_title'=>$request->book_title,
                'author'=>$request->author,
               'image'=>$image_path,
                 'pdf'=>$pdf_path,
                  'category'=>$request->category,
                 'type'=>$request->type,
                'description'=>$request->description,
                'show_homepage'=>$request->show_homepage,
                
            ]);
         $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.library.index')->with($notification);
    }


    public function edit(Library $library)
    {
        $departments=Department::orderBy('name','asc')->get();
          $categories=Category::orderBy('category','asc')->get();

        $website_lang=ManageText::all();
        return view('admin.library.edit',compact('library','departments','categories','website_lang'));
    }


    public function update(Request $request, Library $library)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'book_title'=>'required',
            'author'=>'required',
            'pdf'=>'required',
              'category'=>'required',
                'type'=>'required',
            'description'=>'required',
            'image'=>'required',
            'show_homepage'=>'required',
           
        ];
        $customMessages = [
            'book_title.required' => $valid_lang->where('lang_key','req_book_tile')->first(),
            'author.required' => $valid_lang->where('lang_key','req_author')->first(),
            'pdf.unique' => $valid_lang->where('lang_key','req_pdf')->first(),
              'category.required' => $valid_lang->where('lang_key','req_category')->first(),
                'type.required' => $valid_lang->where('lang_key','req_type')->first(),
            'description.required' => $valid_lang->where('lang_key','req_description')->first(),
            'show_homepage.required' => $valid_lang->where('lang_key','req_show_homepage')->first(),
            'image.required' => $valid_lang->where('lang_key','req_img')->first(),
            
        ];
        $this->validate($request, $rules, $customMessages);



        // upload new image
        $image_path=$library->image;
        if($request->image){
            $old_image=$library->image;
            $image=$request->image;
            $extention=$image->getClientOriginalExtension();
            $name= 'library-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_path='uploads/custom-images/'.$name;
            Image::make($image)
                ->resize(500,null,function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path($image_path));

                if(File::exists(public_path($old_image)))unlink(public_path($old_image));

        }
        $pdf=$request->pdf;
        $extention=$pdf->getClientOriginalExtension();
        $pdf_path= time().'.'.$extention;
        
        $request->pdf->move('uploads/pdf',$pdf_path);
       


        Library::where('id',$library->id)->update([
          'book_title'=>$request->book_title,
                'author'=>$request->author,
               'image'=>$image_path,
                 'pdf'=>$pdf_path,
                 'category'=>$request->category,
                 'type'=>$request->type,
                
                'description'=>$request->description,
                'show_homepage'=>$request->show_homepage,

        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.library.index')->with($notification);

    }

     public function destroy($id)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        Library::destroy($id);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.library.index')->with($notification);
    }


}
