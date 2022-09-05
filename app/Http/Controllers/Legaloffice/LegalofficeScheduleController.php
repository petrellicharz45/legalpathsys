<?php

namespace App\Http\Controllers\Legaloffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\ManageText;
class LegalofficeScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:legal');
    }
    public function index(){
        $legals=Auth::guard('legal')->user();
        $website_lang=ManageText::all();
        return view('legaloffice.schedule.index',compact('legals','website_lang'));
    }
}
