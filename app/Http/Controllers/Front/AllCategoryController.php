<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Session;
class AllCategoryController extends Controller
{
     public function __construct()
    {

    }
    public function index($city)
    {

    	$page_title	='All Categories';
        if(Session::has('search_city_title'))
        {
            $current_city=Session::get('search_city_title');
        }
    	else if(Session::has('city'))
        {
        	$current_city=Session::get('city');
        }
        else
        {
        	$current_city='Delhi';
        }
       //dd($arr_category);
 		$cat_img_path = url('/').config('app.project.img_path.category');
    	return view('front.allcategory.index',compact('page_title','current_city','arr_category','sub_category','cat_img_path'));
    }
    public function popular_city($city_title)
    {
        Session::put('search_city_title',$city_title);
        //Session::put('city', $city_title);
        return redirect($city_title.'/all-categories');
    }
}
