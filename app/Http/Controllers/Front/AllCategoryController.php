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

        $arr_category = array();
        $where_arr=array('parent'=>0);
        $obj_main_category = CategoryModel::where('is_active','1')->where($where_arr)->get();
        if($obj_main_category)
        {
            $arr_category = $obj_main_category->toArray();
        }

        $obj_sub_category = CategoryModel::where('is_active','1')->where('parent','!=',0)->get();
        if($obj_sub_category)
        {
            $sub_category = $obj_sub_category->toArray();
        }
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
