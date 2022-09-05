<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\ViewBook;
use App\Library;
use App\MeetingHistory;
use App\BannerImage;
use App\Navigation;
use App\ManageText;
use Illuminate\Pagination\Paginator;

class ViewController extends Controller
{
    protected $banner;
    public function __construct()
    {

        $this->middleware('auth:web');
        $this->banner=BannerImage::first();
    }

    public function view($pdf){
        $libraries=Library::all()->where('pdf',$pdf)->first();
        $user=Auth::guard('web')->user();
        
        ViewBook::create([
            'user_id'=>$user->id,
             'book_id'=>$libraries->id,
                
            ]);
            return view('client.library.viewpdf',compact('libraries','user'));
    
    }

}