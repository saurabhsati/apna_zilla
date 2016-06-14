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
					$data[$key]['cat_img']      = url('/uploads/category').'/'.$cat['cat_img'];
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

	public function get_all_sub_category(Request $request)
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
			$json['message'] = 'All Sub Category!';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Record Found!';
		}
             return response()->json($json);	 	
	     
   
	}

	public function get_business_listing(Request $request)
	{
		  $data    = array();
		  $cat_id  = $request->input('cat_id');
		  $city    = $request->input('city');
		  $user_id = $request->input('user_id');

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
              $str              = "";
              $obj_favourite    = FavouriteBusinessesModel::where(array('user_id'=>$user_id ,'is_favourite'=>"1" ))->get(['business_id']);
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
					$data[$key]['main_image']    = url('/uploads/business/main_image').'/'.$business['main_image'];
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

	public function get_business_details(Request $request)
	{
         $business_id  = $request->input('business_id');
         $user_id  = $request->input('user_id');
         $_business    = $data =array();
         $obj_business = BusinessListingModel::where('id',$business_id)->first();
       
        if( $obj_business != FALSE)
        {
            $_business = $obj_business->toArray();
        }
       
        if(sizeof($_business)>0)
        {
          $visited_count=$_business['visited_count'];
          $update_visited_count= $visited_count+1;
          $update_data['visited_count']=$update_visited_count;
          BusinessListingModel::where('id',$business_id)->update($update_data);
        }
       
        $arr_business_details = array();

         $obj_business_details = BusinessListingModel::where(array('id'=>$business_id,'is_active'=>'1'))->with(['business_times','also_list_category','image_upload_details','payment_mode','category_details','service','reviews'=>function($query){
          $query->where('is_active','1');
         }])->first();
       
         if($obj_business_details)
         {
           $arr_business_details=$obj_business_details->toArray();
         }


       if($user_id !="")
       {
              $arr_fav_business = array();
              $str              = "";
              $obj_favourite    = FavouriteBusinessesModel::where(array('user_id'=>$user_id ,'is_favourite'=>"1" ))->get(['business_id']);
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
		
		if(in_array($arr_business_details['id'], $arr_fav_business))
		{
			$data['is_favourite']            = 1;
		}
		else
		{
			$data['is_favourite']            = 0;
		}

		$data['business_name']  = $arr_business_details['business_name'];
		$data['main_image']     = url('/uploads/business/main_image').'/'.$arr_business_details['main_image'];
		$data['area']           = $arr_business_details['area'];
		$data['city']           = $arr_business_details['city'];
		$data['pincode']        = $arr_business_details['pincode'];
		$data['mobile_number'] = $arr_business_details['mobile_number'];
		$data['lat']           = $arr_business_details['lat'];
		$data['lng']           = $arr_business_details['lng'];
		$data['avg_rating']    = $arr_business_details['avg_rating'];
		$data['is_verified']    = $arr_business_details['is_verified'];
		$data['about']         = $arr_business_details['company_info'];
				
	    $business_times=[]; 
   	    foreach ($arr_business_details['business_times'] as $key => $value) 
		{			
			$business_times[$key]['business_times']['mon_open']   = $value['mon_open'];
			$business_times[$key]['business_times']['mon_close']  = $value['mon_close'];
			$business_times[$key]['business_times']['tue_open']   = $value['tue_open'];
			$business_times[$key]['business_times']['tue_close']  = $value['tue_close'];
			$business_times[$key]['business_times']['wed_open']   = $value['wed_open'];
			$business_times[$key]['business_times']['wed_close']  = $value['wed_close'];	
			$business_times[$key]['business_times']['thus_open']  = $value['thus_open'];
			$business_times[$key]['business_times']['thus_close'] = $value['thus_close'];	
			$business_times[$key]['business_times']['fri_open']   = $value['fri_open'];
			$business_times[$key]['business_times']['fri_close']  = $value['fri_close'];	
			$business_times[$key]['business_times']['sat_open']   = $value['sat_open'];
			$business_times[$key]['business_times']['sat_close']  = $value['sat_close'];	
			$business_times[$key]['business_times']['sun_open']   = $value['sun_open'];
			$business_times[$key]['business_times']['sun_close']  = $value['sun_close'];	
		}
      
       $image_upload_details=[];

		foreach ($arr_business_details['image_upload_details'] as $key => $value) 
		{
			$image_upload_details[$key]['image_name'] = url('/uploads/business/business_upload_image').'/'.$value['image_name'];
		}

		$service=[];
		foreach ($arr_business_details['service'] as $key => $value) 
		{
			$service[$key]['name'] = $value['name'];
		}

		foreach ($arr_business_details['also_list_category'] as $key => $value) 
		{
           $sub_category='';

            $obj_sub_category = CategoryModel::where('cat_id',$value['category_id'])->get();
            if($obj_sub_category)
            {
                $sub_category = $obj_sub_category->toArray();
            }
			foreach ($sub_category as $key => $value) 
			{
				$data[$key]['also_list_category']['name'] =  $value['title']; 
		    }
         
		}

       	$payment_mode=[];
		foreach ($arr_business_details['payment_mode'] as $key => $value) 
		{
			$payment_mode[$key]['title'] = $value['title'];
		}
		$reviews=[];
		foreach ($arr_business_details['reviews'] as $key => $value) 
		{
			$reviews[$key]['name']    = $value['name'];
			$reviews[$key]['message'] = $value['message'];
			$reviews[$key]['date']    = $value['created_at'];
		}
	    $data['business_times']       = $business_times;
	    $data['image_upload_details'] = $image_upload_details;
	    $data['service']              = $service;
	    $data['payment_mode']         = $payment_mode;
	    $data['reviews']              = $reviews;


	    if(isset($arr_business_details) && sizeof($arr_business_details)>0)
		{
 
		    $json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Business details !';
		}
		else
		{

			$json['status']  = 'ERROR';
			$json['message'] = ' No Business details available !';
		}	
           return response()->json($json);	 	
	}

}
