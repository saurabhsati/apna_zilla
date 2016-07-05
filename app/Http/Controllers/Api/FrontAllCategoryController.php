<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\BusinessCategoryModel;
use App\Models\BusinessListingModel;
use App\Models\FavouriteBusinessesModel;
use App\Models\CityModel;
use App\Models\DealModel;

class FrontAllCategoryController extends Controller
{
	public function __construct()
	{
       $json    = array();
    }

	public function get_all_city()
	{

		    $arr_city = $data = array();
	    	$where_arr=array('parent'=>0);
	    	$obj_city = CityModel::get();
	 		if($obj_city)
	 		{
	 			$arr_city = $obj_city->toArray();
	 		}
	 	//dd($arr_city);
		    	if(isset($arr_city) && sizeof($arr_city)>0)
			{
				foreach ($arr_city as $key => $city) 
				{
					$data[$key]['id']         = $city['id'];
					$data[$key]['city_title'] = $city['city_title'];
    			}
			$json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'City List !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No City Record Found!';
		}
             return response()->json($json);	 	
	}	


	public function get_popular_and_normal_Category(Request $request)
	{
			$cat_id  = $request->input('cat_id');
			$data = array();
	    	
	    	$obj_main_category = CategoryModel::where('parent',$cat_id)->where('is_popular','1')->get();
	 		if($obj_main_category)
	 		{
	 			$arr_popular_category = $obj_main_category->toArray();
	 		}

            $popular_cat=[];
		    if(isset($arr_popular_category) && sizeof($arr_popular_category)>0)
			{
				foreach ($arr_popular_category as $key => $cat) 
				{
					$popular_cat[$key]['cat_id'] = $cat['cat_id'];
					$popular_cat[$key]['title']  = $cat['title'];
    			}
    		}

			$normal_cat=[];
	    	$obj_main_category = CategoryModel::where('parent',$cat_id)->where('is_popular','0')->get();
	 		if($obj_main_category)
	 		{
	 			$arr_normal_category = $obj_main_category->toArray();
	 		}

		    if(isset($arr_normal_category) && sizeof($arr_normal_category)>0)
			{
				foreach ($arr_normal_category as $key => $cat) 
				{
					$normal_cat[$key]['cat_id'] = $cat['cat_id'];
					$normal_cat[$key]['title']  = $cat['title'];
    			}
    		}


	        $data['popular_cat']       = $popular_cat;
	        $data['normal_cat']        = $normal_cat;

			$json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'popular and normal category';
             return response()->json($json);	 	

    		
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



	public function all_business_and_deals(Request $request)
	{		
		  $data       = $arr_final_list   = array();
		  $serch_name = $request->input('serch_name');
		  $city       = $request->input('city');

           $deal_data =$business_data =array();  
            /* Serch text as business name */
            $obj_business_listing = BusinessListingModel::where('city',$city)
                                    ->where(function ($query) use ($serch_name) {
                                    $query->where('business_name','like',"%".$serch_name."%")
                                    ->orWhere('keywords','like',"%".$serch_name."%");
                                    })->get();
                                 
            if($obj_business_listing)
            {
                $arr_business = $obj_business_listing->toArray();
                $arr_final_business = array();
                if(sizeof($arr_business)>0)
                {
                    foreach ($arr_business as $key => $business)
                    {
                        $business_data[$key]['id']            = $business['id'];
                        $business_data[$key]['name'] = $business['business_name'];
                        $business_data[$key]['type']          = 'Business';
                       
                    }
                }
            }
       
            /* Deals by search text */
             $obj_deals_info = DealModel::where('is_active','1')
                                        ->where('name','like',"%".$serch_name."%")
                                        ->orderBy('created_at','DESC')->get();
                                    
            if($obj_deals_info)
            {
                $arr_deals_info = $obj_deals_info->toArray();
                $arr_final_business = array();
                if(sizeof($arr_deals_info)>0)
                {
                    foreach ($arr_deals_info as $ckey => $deal)
                    {
                        $deal_data[$ckey]['id']   = $deal['id'];
                        $deal_data[$ckey]['name'] = $deal['name'];
                        $deal_data[$ckey]['type'] = 'deal_detail';
                    }
                }
            }

	    $data['Business']    = $business_data;
	    $data['Deals']       = $deal_data;
  
	    $json['data'] 	 = $data;
		$json['status']  = 'SUCCESS';
		$json['message'] = 'Business and deal details !';
	
	     return response()->json($json);	 	
          
	}

	public function all_sub_category()
	{
		  $data     = array();

            $obj_sub_category = CategoryModel::where('parent','!=',0)
                                           ->where('is_active','=',1)
                                           ->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}

  	 	
	    if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
		{
			foreach ($arr_sub_category as $key => $sub_cat) 
				{
					$data[$key]['id']     = $sub_cat['cat_id'];
					$data[$key]['name']      = $sub_cat['title'];
					$data[$key]['cat_slug']   = $sub_cat['cat_slug'];
					$data[$key]['type']   = "sub_category";
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
        
       // dd($arr_fav_business);
		if(isset($arr_data_business) && sizeof($arr_data_business)>0)
		{
			foreach ($arr_data_business as $key => $business) 
				{

					if(in_array($business['id'], $arr_fav_business))
					{
						$data[$key]['is_favourite']  = 1;
					}
					else
					{
						$data[$key]['is_favourite']  = 0;
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
          $visited_count                = $_business['visited_count'];
          $update_visited_count         = $visited_count+1;
          $update_data['visited_count'] = $update_visited_count;
          BusinessListingModel::where('id',$business_id)->update($update_data);
        }
       
        $arr_business_details = array();

         $obj_business_details = BusinessListingModel::where(array('id'=>$business_id,'is_active'=>'1'))->with(['business_times','also_list_category.category_list','image_upload_details','payment_mode','category_details','service','reviews'=>function($query){
          $query->where('is_active','1');
         }])->first();
       
         if($obj_business_details)
         {
           $arr_business_details=$obj_business_details->toArray();
         }


//dd( $arr_business_details );


        if($arr_business_details)
        {
                $arr_business_by_category = array();

               $arr_business_by_category = array();
                $obj_business_listing = BusinessCategoryModel::where('category_id',$arr_business_details['category_details']['category_id'])->limit(4)->get();

                if($obj_business_listing)
                {
                    $obj_business_listing->load(['business_by_category','business_rating']);
                    $arr_business_by_category = $obj_business_listing->toArray();

                }
                 $key_business_cat=array();

              if(sizeof($arr_business_by_category)>0)
              {
                  foreach ($arr_business_by_category as $key => $value) {
                    $key_business_cat[$value['business_id']]=$value['business_id'];
                  }
              }
               if( sizeof($key_business_cat)>0)
              {
                  $result = $key_business_cat;
                  if(($key = array_search($business_id, $result)) !== false){
                     unset($result[$key]);
                     }
                  $all_related_business = array();
                  if(sizeof($result)>0)
                  {

                    $obj_business    = BusinessListingModel::where('city',$arr_business_details['city'])->whereIn('id', $result)->with(['reviews'])->get();

                    if($obj_business)
                    {
                      $all_related_business = $obj_business->toArray();

                    }
                  }
              }
          }


//dd($all_related_business);
          	$related_business=[];
   	    foreach ($all_related_business as $key => $value) 
		{			
			$related_business[$key]['id']                    = $value['id'];
			$related_business[$key]['busiess_ref_public_id'] = $value['busiess_ref_public_id'];
			$related_business[$key]['business_name']         = $value['business_name'];
			$related_business[$key]['main_image']            = url('/uploads/business/main_image').'/'.$value['main_image'];
			$related_business[$key]['area']                  = $value['area'];
			$related_business[$key]['city']                  = $value['city'];
			$related_business[$key]['state']                 = $value['state'];
			$related_business[$key]['country']               = $value['country'];	
			
			
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

		$data['business_name'] = $arr_business_details['business_name'];
		$data['main_image']    = url('/uploads/business/main_image').'/'.$arr_business_details['main_image'];
		$data['area']          = $arr_business_details['area'];
		$data['city']          = $arr_business_details['city'];
		$data['pincode']       = $arr_business_details['pincode'];
		$data['mobile_number'] = $arr_business_details['mobile_number'];
		$data['lat']           = $arr_business_details['lat'];
		$data['lng']           = $arr_business_details['lng'];
		$data['avg_rating']    = $arr_business_details['avg_rating'];
		$data['is_verified']   = $arr_business_details['is_verified'];
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

		$aa =[];
		foreach ($arr_business_details['also_list_category'] as $key => $value) 
		{          
			$aa[$key]['also_list_category'] =  $value['category_list']['title']; 
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
	    $data['reviews']              = $reviews;
	    $data['also_list_category']       = $aa;
	    $data['related_businesss']       = $related_business;


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
