<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageTemplate;
use App\Models\Cms;

class HomeController extends Controller
{
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $landingpage = LandingPageTemplate::first();
		
		return view('home')->with('landingpage',$landingpage);
    }
	
	public function cmspage($slug)
    {
        $cmspage = Cms::where('cms_slug',$slug)->where('cms_status','Publish')->first();
		
		$landingpage = LandingPageTemplate::first();
		
		if($cmspage){
			return view('home')->with('cmspage',$cmspage)->with('landingpage',$landingpage);	
		}else{
			abort(404);
		}
    }
}
