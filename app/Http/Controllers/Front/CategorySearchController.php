<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use DB,Event;
class CategorySearchController extends Controller
{
    public function index($cat_slug,$cat_id)
    {
    	$page_title	='List Of Category ';
    	$obj_sub_category = CategoryModel::where('parent',$cat_id)->orderBy('is_popular', 'DESC')->get();
	 	if($obj_sub_category)
	 	{
	 		$arr_sub_category = $obj_sub_category->toArray();
	 	}

      return view('front.category_search',compact('page_title','arr_sub_category','cat_slug','cat_id'));
    }
    public function get_business($cat_id)
    {
    	$page_title	='Business List';
    	$arr_business = array();
 		$obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
 		if($obj_business_listing)
 		{
            $obj_business_listing->load(['business_by_category']);
 			$arr_business = $obj_business_listing->toArray();

 		}
        //dd($arr_business);
		return view('front.listing.index',compact('page_title','arr_business'));
    }
}
