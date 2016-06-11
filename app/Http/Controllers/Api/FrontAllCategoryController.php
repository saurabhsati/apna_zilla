<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\BusinessCategoryModel;
use App\Models\BusinessListingModel;
use App\Models\FavouriteBusinessesModel;

class FrontAllCategoryController extends Controller
{
	public function __construct()
	{
       $json    = array();
    }

	public function get_all_main_Category()
	{
		    $arr_category = $data = array();
	    	$where_arr=array('parent'=>0);
	    	$obj_main_category = CategoryModel::where('is_active','1')->where($where_arr)->get();
	 		if($obj_main_category)
	 		{
	 			$arr_category = $obj_main_category->toArray();
	 		}
	 	
	    	if(isset($arr_category) && sizeof($arr_category)>0)
			{
				foreach ($arr_category as $key => $cat) 
				{
					$data[$key]['cat_id']       = $cat['cat_id'];
					$data[$key]['title']        = $cat['title'];
					$data[$key]['cat_slug']     = $cat['cat_slug'];
					$data[$key]['cat_ref_slug'] = $cat['cat_ref_slug'];
				}
			$json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Main Category List !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Main Category Record Found!';
		}
             return response()->json($json);	 	
	}

	public function get_business_details(Request $request)
	{
		  $data     = array();
		  $cat_id   = $request->input('cat_id');
		  $city     = $request->input('city');
		  $cat_slug = $request->input('cat_slug');

		$obj_sub_category = CategoryModel::where('parent',$cat_id)->where('is_active','1')->orderBy('is_popular', 'DESC')->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}
	    if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
		{
			foreach ($arr_sub_category as $key => $sub_cat) 
				{
					$data[$key]['cat_id']     = $sub_cat['cat_id'];
					$data[$key]['title']      = $sub_cat['title'];
					$data[$key]['is_popular'] = $sub_cat['is_popular'];
				}
		    $json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Sub Categories List of Main Category !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Sub Category of Main Category Record Found!';
		}
             return response()->json($json);	 	
	     
   
	}

	public function get_business_listing(Request $request)
	{
		  $data     = array();
		  $cat_id   = $request->input('cat_id');
		  $city     = $request->input('city');
		  $user_id     = $request->input('user_id');


		  /* Get Business by category */
            $obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
            if($obj_business_listing)
            {
              $obj_business_listing->load(['business_by_category','business_rating']);
              $arr_business_by_category = $obj_business_listing->toArray();
            }
            $key_business_cat=array();
            if(sizeof($arr_business_by_category)>0)
            {
                foreach ($arr_business_by_category as $key => $value) 
                {
                  $key_business_cat[$value['business_id']]=$value['business_id'];
                }
            }


          $obj_business_listing= $arr_data_business =$total_review =[];


        if(sizeof($key_business_cat)>0)
        {
            $result = $key_business_cat;

            $arr_business = array();
            if(sizeof($result)>0)
            {
              /* fetch business records by id's */
               $obj_business_listing = BusinessListingModel::where('city',$city)->where('is_active','1')->whereIn('id', $result)->get();
            }
         }
          
         if($obj_business_listing)
	        {
	            $arr_data_business = $obj_business_listing->toArray();
	        }
	       if($user_id !="")
           {
              
            
              $arr_fav_business = array();
              $str = "";
              $obj_favourite = FavouriteBusinessesModel::where(array('user_id'=>$user_id ,'is_favourite'=>"1" ))->get(['business_id']);

              if($obj_favourite)
              {
                $obj_favourite->toArray();

                foreach ($obj_favourite as $key => $value)
                {
                  array_push($arr_fav_business, $value['business_id']);
                }
              }
              else
              {
                $arr_fav_business = array();
              }
          }
          else
          {
              $arr_fav_business = array();
          }

		if(isset($arr_data_business) && sizeof($arr_data_business)>0)
		{
			foreach ($arr_data_business as $key => $business) 
				{
					if(in_array($business['id'], $arr_fav_business))
					{
						$data[$key]['is_favourite']            = 1;
					}
					else
					{
						$data[$key]['is_favourite']            = 0;
					}

					$data[$key]['id']            = $business['id'];
					$data[$key]['business_name'] = $business['business_name'];
					$data[$key]['main_image']    = $business['main_image'];
					$data[$key]['area']          = $business['area'];
					$data[$key]['city']          = $business['city'];
					$data[$key]['pincode']       = $business['pincode'];
					$data[$key]['mobile_number'] = $business['mobile_number'];
					$data[$key]['avg_rating']    = $business['avg_rating'];
				}

		    $json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Business Listing !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Record Found in Business Listing!';
		}
           return response()->json($json);	 	
	}

}
