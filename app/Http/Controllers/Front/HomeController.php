<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use Session;
class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {

    	$page_title	='Home';
    	$city = Session::get('city');
        if(!empty($city))
        {
        	$current_city=$city;
        }
        else
        {
        	$current_city='Mumbai';
        }
    	$arr_category = array();
    	$where_arr=array('is_popular'=>1,'parent'=>0);
    	$obj_main_category = CategoryModel::where($where_arr)->get();
 		if($obj_main_category)
 		{
 			$arr_category = $obj_main_category->toArray();
 		}

 		$obj_sub_category = CategoryModel::where('parent','!=',0)->get();
 		if($obj_sub_category)
 		{
 			$sub_category = $obj_sub_category->toArray();
 		}

 		$arr_business = array();
 		$obj_business_listing = BusinessListingModel::with(['category'])->get();
 		if($obj_business_listing)
 		{
 			$arr_business = $obj_business_listing->toArray();

 		}
 		//dd($arr_business);
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
	 			$category_business[$cat['category_id']]='0';
	 		}


 		}
 		//dd($sub_category);
 		 $cat_img_path = url('/').config('app.project.img_path.category');
 		return view('front.home',compact('page_title','arr_category','sub_category','category_business','cat_img_path','current_city'));
    }
    public function locate_location(Request $request)
    {
    	 $lat=$request->input('lat');
    	 $lng=$request->input('lng');
    	 $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $lat, $lng);

		    $content = file_get_contents($url); // get json content

		    $metadata = json_decode($content, true); //json decoder
		    if(count($metadata['results']) > 0) {
			    $city = $metadata['results'][0]['address_components']['2']['long_name'];

			    Session::put('city', $city);
			    echo 'done';
			}
			else
			{
		    	echo 'fail';
	    	}
 	}
 	public function get_category_auto(Request $request,$category)
 	{
 		if($request->has('term'))
        {
            $search_term = $request->input('term');
            $arr_obj_list = CategoryModel::where('title','like',"%".$search_term."%")
                                                ->orWhere('cat_desc','like',"%".$search_term."%")
                                                ->orWhere('cat_meta_description','like',"%".$search_term."%")
                                                ->get();

            $arr_list = array();
            if($arr_obj_list)
            {
                $arr_list = $arr_obj_list->toArray();

                $arr_final_list = array();

                if(sizeof($arr_list)>0)
                {
                    foreach ($arr_list as $key => $list)
                    {
                    	//$arr_final_list[$key]['value'] = $list['cat_id'];
                        $arr_final_list[$key]['id'] = $list['cat_id'];
                        $arr_final_list[$key]['label'] = $list['title'];


                    }

                    return response()->json($arr_final_list);
                }
                else
                {
                   return response()->json(array());
                }
            }
            else
            {
              return response()->json(array());
            }
        }
        else
        {
           return response()->json(array());
        }
 	}

}
