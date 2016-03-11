<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {

    	$page_title	='Home';

    	$arr_category = array();
 		$obj_category = CategoryModel::where('is_popular','1')->get();
 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

 		$arr_business = array();
 		$obj_business_listing = BusinessListingModel::with(['category'])->get();
 		if($obj_business_listing)
 		{
 			$arr_business = $obj_business_listing->toArray();

 		}
 		$category_business=array();
 		foreach ($arr_business as $business)
 		{

 			if(sizeof($business['category'])>0)
 			{
	 			foreach ($business['category'] as $key => $cat)
	 			{
	 				if(!array_key_exists($cat['category_id'], $category_business))
	 				{
	 				  $category_business[$cat['category_id']]=1;
	 			    }
	 			    else
	 			    {
	 			    	$category_business[$cat['category_id']]=$category_business[$cat['category_id']]+1;
	 			    }

 				}
	 		}
	 		else
	 		{
	 			$category_business[$value['id']]='0';
	 		}


 		}

 		 $cat_img_path = url('/').config('app.project.img_path.category');
 		return view('front.home',compact('page_title','arr_category','category_business','cat_img_path'));
    }
}
