<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StaticPageModel;
use Session;
class CMSController extends Controller
{
     public function __construct()
    {
    }

   public function aboutus()
    {
        $page_title='About Us';
    	return view('front.about_us',compact('page_title'));
    }

    public function page($slug)
    {
    	$page_slug=$slug;
    	$arr_data 	=	array();
        $page_title ='CMS';
    	$obj_static_page=StaticPageModel::where('page_slug',$page_slug)->first();
    	if($obj_static_page)
    	{
    		$data_page=$obj_static_page->toArray();
    	}
    	//dd($data_page);
    	return view('front.static_page',compact('data_page','page_title'));
    }
}
