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
 		$obj_business = BusinessListingModel::select('business_cat','id')->get();
 		if($obj_business)
 		{
 			$arr_business = $obj_business->toArray();

 		}

 		$sec_arr=array();
 		foreach($arr_business as $business)
 		{
 			$arr=array();
 			$arr[]=explode(',',$business['business_cat']);


 			foreach($arr[0] as $key =>$value)
 			{

 				if(!array_key_exists($value,$sec_arr))
 				{
 					$sec_arr[$value]='1';
 				}
 				else
 				{
 					$v = $sec_arr[$value]+1;
 					$sec_arr[$value]=$v;
 				}

 			}

 		}
 		 $cat_img_path = url('/').config('app.project.img_path.category');
 		return view('front.home',compact('page_title','arr_category','arr_category','sec_arr','cat_img_path'));
    }
}
