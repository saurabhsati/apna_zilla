<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\LocationModel;
use Session;
class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {

    	$page_title	='Home';
        if(Session::has('city'))
        {
        	$current_city=Session::get('city');
        }
        else
        {
            //Session::put('city', 'Mumbai');
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
    //share location
    public function locate_location(Request $request)
    {
    	 $lat=$request->input('lat');
    	 $lng=$request->input('lng');
    	 $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $lat, $lng);

		    $content = file_get_contents($url); // get json content

		    $metadata = json_decode($content, true); //json decoder
		    if(count($metadata['results']) > 0) {
			    $city = $metadata['results'][0]['address_components']['2']['long_name'];
                if(!empty($city))
                {
			       Session::put('city', $city);
                   $obj_city = CityModel::where('city_title',$city)->first();
                    if($obj_city)
                    {
                        $arr_city = $obj_city->toArray();
                        if(!empty($arr_city))
                        {
                            Session::put('city_id', $arr_city['id']);
                        }

                    }
                }
                else
                {
                     Session::put('city', 'Mumbai');
                     $obj_city = CityModel::where('city_title',"Mumbai")->first();
                    if($obj_city)
                    {
                        $arr_city = $obj_city->toArray();
                        if(!empty($arr_city))
                        {
                            Session::put('city_id', $arr_city['id']);
                        }

                    }
                }
			    echo 'done';
			}
			else
			{
		    	echo 'fail';
	    	}
 	}
    public function get_city_auto(Request $request)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            $arr_obj_city = CityModel::where('is_active','=',1)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("city_title", 'like', "%".$search_term."%")
                                             ->orwhere("city_slug", 'like', "%".$search_term."%");
                                             })->get();
            $arr_list_city = array();
            if($arr_obj_city)
            {
                $arr_list_city = $arr_obj_city->toArray();

                $arr_final_city_list = array();

                if(sizeof($arr_list_city)>0)
                {
                    foreach ($arr_list_city as $key => $list)
                    {
                        $arr_final_city_list[$key]['id'] = $list['id'];
                        $arr_final_city_list[$key]['label'] = $list['city_title'];
                    }

                }

            }
             if(sizeof($arr_final_city_list)>0)
            {
                 return response()->json($arr_final_city_list);
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
 	public function get_category_auto(Request $request)
 	{
 		if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            /*List category by keyword*/
            $arr_obj_list = CategoryModel::where('parent','!=',0)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("title", 'like', "%".$search_term."%")
                                             ->orwhere("cat_desc", 'like', "%".$search_term."%")
                                             ->orwhere("cat_meta_description", 'like', "%".$search_term."%");
                                             })->get();

            $arr_list = array();
            if($arr_obj_list)
            {
                $arr_list = $arr_obj_list->toArray();
                $arr_final_list = array();
                if(sizeof($arr_list)>0)
                {
                    foreach ($arr_list as $key => $list)
                    {
                        $arr_final_list[$key]['cat_id'] = $list['cat_id'];
                        $arr_final_list[$key]['label'] = $list['title'];
                        $arr_final_list[$key]['data_type'] = 'list';
                    }

                }

            }

            if(Session::has('search_city_id'))
            {
                $city=Session::get('search_city_id');
            }
            else
            {
                $city=Session::get('city_id');
            }
            $ckey=sizeof($arr_final_list);
            $obj_business_listing = BusinessListingModel::where('city',$city)
                                    ->where(function ($query) use ($search_term) {
                                    $query->where('business_name','like',"%".$search_term."%")
                                    ->orWhere('keywords','like',"%".$search_term."%");
                                    })->get();
                                  //  return response()->json($obj_business_listing);
            if($obj_business_listing)
            {
                $arr_business = $obj_business_listing->toArray();
                $arr_final_business = array();
                if(sizeof($arr_business)>0)
                {
                    foreach ($arr_business as $key => $business)
                    {

                        $slug_business=str_slug($business['business_name']);
                        $slug_area=str_slug($business['area']);

                        $arr_final_list[$ckey]['business_id'] = base64_encode($business['id']);
                        $arr_final_list[$ckey]['label'] = $business['business_name'];
                        $arr_final_list[$ckey]['city'] = $business['city'];
                        $arr_final_list[$ckey]['slug']=$slug_business.'@'.$slug_area;
                        $arr_final_list[$ckey]['data_type'] = 'detail';
                        $ckey++;
                    }
                }


            }
           if(sizeof($arr_final_list)>0)
            {
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
    public function get_location_auto(Request $request)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
             $arr_obj_location = LocationModel::where(function ($query) use ($search_term) {
                                             $query->where("place_name", 'like', "%".$search_term."%")
                                             ->orwhere("admin_name1", 'like', "%".$search_term."%")
                                             ->orwhere("admin_name2", 'like', "%".$search_term."%")
                                             ->orwhere("admin_name3", 'like', "%".$search_term."%");
                                             })->get();
             $arr_list_location = array();
            if($arr_obj_location)
            {
                $arr_list_location = $arr_obj_location->toArray();

                $arr_final_location_list = array();

                if(sizeof($arr_list_location)>0)
                {
                    foreach ($arr_list_location as $key => $list)
                    {
                        $arr_final_location_list[$key]['id'] = $list['id'];
                        $arr_final_location_list[$key]['label'] = $list['place_name'];
                        $arr_final_location_list[$key]['loc_slug'] = str_slug($list['place_name']);
                    }

                }

            }
             if(sizeof($arr_final_location_list)>0)
            {
                 return response()->json($arr_final_location_list);
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

    public function set_city(Request $request)
    {
            $city_id = $request->input('city_id');
            $city_title = $request->input('city_title');

            Session::put('search_city_id',$city_id);
            Session::put('search_city_title',$city_title);
            $result['status'] ="1";
            return response()->json($result);
    }

}
