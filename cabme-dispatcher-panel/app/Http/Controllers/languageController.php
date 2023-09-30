<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\language;
use App\Models\Requests;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Validator;
use App;

// use Illuminate\Support\Facades\Validator;

class languageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function change(Request $request)
    {
        
        App::setLocale($request->lang);
        
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }
    public function getCode($slugid){
        $data = DB::table('language')
        ->where('code','=',$slugid)
        ->get();
        
        return response()->json($data);
    }
   
    public function getLangauage()
    {
         $data = DB::table('language')
         ->where('status','=','true')
         ->get();
         return response()->json($data);
       // $language = language::all();
        
       // return view("layouts.header")->with("language", $language);

    }

   
     

}
