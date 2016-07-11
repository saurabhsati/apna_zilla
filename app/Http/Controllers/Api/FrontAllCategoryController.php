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
use App\Models\ReviewsModel;
use App\Models\StateModel;
use App\Models\BusinessSendEnquiryModel;
use App\Models\UserModel;
use DB;


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
		  $data       = $arr_final_list =$arr_sub_category   = array();
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
                        $business_data[$key]['name']         = $business['business_name'];
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

       
        $obj_sub_category = CategoryModel::where('parent','!=',0)
        								   ->where('title','like',"%".$serch_name."%")
                                           ->where('is_active','=',1)
                                           ->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}

  	 	$sub_category=[];
	    if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
		{
			    foreach ($arr_sub_category as $key => $sub_cat) 
				{
					$sub_category[$key]['id']       = $sub_cat['cat_id'];
					$sub_category[$key]['name']     = $sub_cat['title'];
					$sub_category[$key]['cat_slug'] = $sub_cat['cat_slug'];
					$sub_category[$key]['type']     = "sub_category";
				}
 		}
	    $data['Business']    = $business_data;
	    $data['Deals']       = $deal_data;
	    $data['sub_category'] = $sub_category;
  
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
		  $data         = array();
		  $cat_id       = $request->input('cat_id');
		  $city         = $request->input('city');
		  $user_id      = $request->input('user_id');
		  $latitude     = $request->input('latitude');
		  $longitude    = $request->input('longitude');
		  $distance     = $request->input('distance');
		  $most_popular = $request->input('most_popular');
		  $rating       = $request->input('rating');


         $business_data  =[];
		
		  /* Get Business by category */
            $obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
            if($obj_business_listing)
            {
              $obj_business_listing->load(['business_by_category','business_rating']);
              $arr_business_by_category = $obj_business_listing->toArray();
            }
            $key_business_cat=$arr_palces=array();
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
      	           $obj_business_listing = BusinessListingModel::with(['reviews'])
  	                                                            ->where('city',$city)
  	                                                            ->where('is_active','1')
  	                                                            ->whereIn('id', $result)
      	                                                        ->get();
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
      
            if(sizeof($key_business_cat)>0)
            {
                $result = $key_business_cat;
                $business_data  =[];

                if(sizeof($result)>0)
                {
                  $obj_business_listing = BusinessListingModel::whereIn('id',$result)->with(['reviews']);

			      if($rating==1)
			      {
			          $obj_business_listing->orderBy('avg_rating','DESC');
			      }
			      else
			      	if($most_popular==1)
			      {
			         /* Get business records list order by mostly visited as Descending order */
			          $obj_business_listing->orderBy('visited_count','DESC');
			      }
			  
                  /* If Location lat & log has been set by session calculate the distance range and get the business under that range */
                  if(isset($latitude) && isset($longitude) && $latitude!='' && $longitude!='')
                   {
                       
                        $qutt='*,ROUND( 6379 * acos (
                          cos ( radians('.$latitude.') )
                          * cos( radians( `lat` ) )
                          * cos( radians( `lng` ) - radians('.$longitude.') )
                          + sin ( radians('.$latitude.') )
                          * sin( radians( `lat` ) )
                        ),2) as distance';

                        $obj_business_listing = $obj_business_listing->selectRaw($qutt);
                       	
                       	if($distance!='')
                        {                     
                             $search_range=(int)$distance;
                             if($obj_business_listing)
	                          {
	                             $obj_business_listing = $obj_business_listing->having('distance', ' < ', $search_range);
	                          }
                        }
                        else
                        {    if($obj_business_listing)
	                          {
	                              $obj_business_listing = $obj_business_listing->having('distance', ' < ', 10);
	                          }
                        }

                        if ($obj_business_listing)
                        {
                        	 $arr_distance  =$obj_business_listing->get()->toArray();
                        }
                                       
                   		if(isset($arr_distance) && $arr_distance!='')
                   		{	

	                   		foreach ($arr_distance as $key => $value) 
	                   		{
	                   			$business_data[$key]['id']       = $value['id'];

								if(in_array($value['id'], $arr_fav_business))
								{
								$business_data[$key]['is_favourite']   = 1;
								}
								else
								{
								$business_data[$key]['is_favourite']   = 0;
								}
								$business_data[$key]['review_count']   = count($value['reviews']);
								$business_data[$key]['business_name']  = $value['business_name'];
								$business_data[$key]['main_image']     = url('/uploads/business/main_image').'/'.$value['main_image'];
								$business_data[$key]['area']           = $value['area'];
								$business_data[$key]['city']           = $value['city'];
								$business_data[$key]['pincode']        = $value['pincode'];
								$business_data[$key]['mobile_number']  = $value['mobile_number'];
								$business_data[$key]['avg_rating']     = $value['avg_rating'];
								$business_data[$key]['is_verified']    = $value['is_verified'];
								$business_data[$key]['visited_count']  = $value['visited_count'];
								$business_data[$key]['establish_year'] = "Estd.in" .$value['establish_year'];
								$business_data[$key]['distance']       = $value['distance'];
	                   		}	

                        }
 		            }
 		            else
 		            {
 		            		

 		            		foreach ($arr_data_business as $key => $value) 
 		            		{



 		            			$business_data[$key]['id']           = $value['id'];
								if(in_array($value['id'], $arr_fav_business))
								{
								$business_data[$key]['is_favourite']   = 1;
								}
								else
								{
								$business_data[$key]['is_favourite']   = 0;

								}
								$business_data[$key]['review_count']   = count($value['reviews']);
								$business_data[$key]['business_name']  = $value['business_name'];
								$business_data[$key]['main_image']     = url('/uploads/business/main_image').'/'.$value['main_image'];
								$business_data[$key]['area']           = $value['area'];
								$business_data[$key]['city']           = $value['city'];
								$business_data[$key]['pincode']        = $value['pincode'];
								$business_data[$key]['mobile_number']  = $value['mobile_number'];
								$business_data[$key]['avg_rating']     = $value['avg_rating'];
								$business_data[$key]['is_verified']    = $value['is_verified'];
								$business_data[$key]['visited_count']  = $value['visited_count'];
								$business_data[$key]['establish_year'] = "Estd.in" .$value['establish_year'];
								//$business_data[$key]['distance']       = $value['distance'];

							}
					}



	            }
	         }  
      
            $result_city_id  = CityModel::select('id')->where('city_title',$city)->first();  
	    	$arr_id = $result_city_id->toArray();

				
			$json['id'] 	         = $arr_id['id'];
			$json['business_data'] 	 = $business_data;
			$json['status']          = 'SUCCESS';
			$json['message']         = 'Business Listing !';
          		
           return response()->json($json);	 	
	}

	public function get_all_city_places(Request $request)
	{
         $city_id =  $request->input('city_id');
 
 	     $city_place = CityModel::with(['city_places'])->where('id', $city_id)->get();
	    
	    if($city_place)
	    {
	    	$arr_palces	= $city_place->toArray();
	    }
	    $places=[];
		foreach ($arr_palces as $pkey => $val) 
		{
			 foreach ($val['city_places'] as $key => $value)
			  {
				$places[$key]['id']         = $value['id'];
				$places[$key]['place_name'] = $value['place_name'];
				$places[$key]['latitude']   = $value['latitude'];
				$places[$key]['longitude']  = $value['longitude'];
			  } 
		}

		$json['place_details'] 	 = $places;
		$json['status']          = 'SUCCESS';
		$json['message']         = 'All Places of City';
      
        return response()->json($json);
	}

	public function get_business_details(Request $request)
	{
	     $business_id  = $request->input('business_id');
	     $user_id      = $request->input('user_id');
	     $city         = $request->input('city');
	     
	     $_business    = $data =array();
	     $obj_business = BusinessListingModel::where('id',$business_id)->first();
       
        if( $obj_business != FALSE)
        {
            $_business = $obj_business->toArray();
        }
        else
        {
        	$json['status']  = 'ERROR';
			$json['message'] = ' No Business details available !';
			return response()->json($json);
        }
   
        if(sizeof($_business)>0)
        {
          $visited_count                = $_business['visited_count'];
          $update_visited_count         = $visited_count+1;
          $update_data['visited_count'] = $update_visited_count;
          BusinessListingModel::where('id',$business_id)->update($update_data);
        }
       
        $arr_business_details = array();

         $obj_business_details = BusinessListingModel::where(array('id'=>$business_id,'is_active'=>'1'))->with(['business_times','user_details','also_list_category.category_list','image_upload_details','payment_mode','category_details','service','reviews'=>function($query){
          $query->where('is_active','1');
         }])->first();
       
         if($obj_business_details)
         {
           $arr_business_details=$obj_business_details->toArray();
         }

//dd($arr_business_details);
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
                  if(($key = array_search($business_id, $result)) !== false)
                  {
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
   	    if(isset($all_related_business) && $all_related_business!='')
   	    {
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
		
		if(isset($arr_business_details['id']))
	     {	
				if(in_array($arr_business_details['id'], $arr_fav_business))
				{
					$data['is_favourite']            = 1;
				}
				else
				{
					$data['is_favourite']            = 0;
				}
	     }	
		$data['business_name'] = isset($arr_business_details['business_name']) ?  $arr_business_details['business_name']:"";
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
/*
        $city_detalis=[];
		$city =CityModel::select('city_title')->where('id',$arr_business_details['city'])->get();
		if($city)
		{
	    	$city_detalis =$city->toArray();	
		}
		
		foreach($city_detalis as $val)
		{		
	      $data['page_url']  = url('/').'/'.$val['city_title'].'/'.str_slug($arr_business_details['business_name'],'-').'@'.str_slug($arr_business_details['area'],'-').'/'.base64_encode($arr_business_details['id']);
		}
*/
		 $data['page_url']  = url('/').'/'.$city.'/'.str_slug($arr_business_details['business_name'],'-').'@'.str_slug($arr_business_details['area'],'-').'/'.base64_encode($arr_business_details['id']);
		
	 
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
		
       $obj_business_rating_count = BusinessListingModel::with(array('reviews'=>function ($query)
                                    {
                                        $query->select(['ratings','business_id', DB::raw('count(*) as total_rating')]);
                                        $query->groupBy('ratings'); 
                                    }
                                    ))->where('id',$business_id)->first();
        if($obj_business_rating_count)
        {
            $business_rating_count = $obj_business_rating_count->toArray();
        }

	            $star1 = 0;
	            $star2 = 0;
	            $star3 = 0;
	            $star4 = 0;
	            $star5 = 0;
                               
              if(isset($business_rating_count['reviews']) && sizeof($business_rating_count['reviews'])>0 )
                {
                    foreach($business_rating_count['reviews'] as $review)
                    {
                      
                      if($review['ratings']==1)
                      { 
                        $star1=$review['total_rating'];  
                      }
                       if($review['ratings']==2)
                      { 
                      
                        $star2=$review['total_rating'];  
                      }
                       if($review['ratings']==3)
                      {                                 
                        $star3=$review['total_rating'];  
                      }
                       if($review['ratings']==4)
                      {                                
                        $star4=$review['total_rating'];  

                      }
                       if($review['ratings']==5)
                      { 
                       $star5=$review['total_rating'];  
                      }

              }
          }                        
                 
               $no_of_rating = $star1 + $star2 + $star3 + $star4 + $star5;
          // dd($no_of_rating);
                if($star1 != 0)
                {
                    $star1 = ($star1/$no_of_rating); 
                    $star1 = $star1 *100;
                    $star1 = round($star1);
                }
                else
                {
                  $star1 = 0;
                }
                
                if($star2 != 0)
                {
                  $star2 = ($star2/$no_of_rating); 
                  $star2 = $star2 *100;
                  $star2 = round($star2);
                }
                else
                {
                  $star2 = 0;
                }
                
                if($star3 != 0)
                {
                  $star3 = ($star3/$no_of_rating); 
                  $star3 = $star3 *100;
                  $star3 = round($star3);
                }
                else
                {
                  $star3 = 0;
                }

                if($star4 !=0)
                {
                  $star4 = ($star4/$no_of_rating);
                  $star4 = $star4 *100;
                  $star4 = round($star4);
                }
                else
                {
                  $star4 = 0;
                }

                if($star5 !=0)
                {
                  $star5 = ($star5/$no_of_rating); 
                  $star5 = $star5 *100;
                  $star5 = round($star5);
                }
                else
                {
                  $star5 = 0;
                }
             
			 $data['reviews_star']['star1']    = $star1;
			 $data['reviews_star']['star2']    = $star2;
			 $data['reviews_star']['star3']    = $star3;
			 $data['reviews_star']['star4']    = $star4;
			 $data['reviews_star']['star5']    = $star5;

 		$reviews=[];
		foreach ($arr_business_details['reviews'] as $key => $value) 
		{
			$reviews[$key]['name']    = $value['name'];
			$reviews[$key]['message'] = $value['message'];
			$reviews[$key]['ratings'] = $value['ratings'];			
			$reviews[$key]['date']    =date('F Y',strtotime($value['created_at'])) ;
			
			if($user_id == $value['user_id'] )
			{	
				$profile_pic=[];
				$image = UserModel::select('profile_pic')->where('id',$user_id)->first();
				if($image) 
				{
				     $profile_pic=$image;	
				}
							    
			      $reviews[$key]['image']   =url('/uploads/users/profile_pic').'/'.$profile_pic['profile_pic'];
			 }
			 else
			 {
			 	 $reviews[$key]['image']   =url('/assets/front/images/testi-user.png');
			 }     
		}
	//get_resized_image_path($user['profile_pic'],'/assets/front/images',200,200)
		//http://localhost/justdial/public/assets/front/images/testi-user.png
		//dd($arr_business_details['user_details']['profile_pic']);

	    $data['business_times']       = $business_times;
	    $data['image_upload_details'] = $image_upload_details;
	    $data['service']              = $service;
	    $data['payment_mode']         = $payment_mode;
	    $data['reviews']              = $reviews;
	    $data['also_list_category']   = $aa;
	    $data['related_businesss']    = $related_business;
	   

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

    public function store_reviews(Request $request)
    {
	    $rating    = $request->input('rating');
	    $name      = $request->input('name');
	    $review    = $request->input('review');
	    $mobile_no = $request->input('mobile_no');
	    $email     = $request->input('email');
	    $id        = $request->input('business_id');
	    $user_id   = $request->input('user_id');

        $arr_data                  = array();
        $arr_data['ratings']       = $rating;
        $arr_data['name']          = $name;
        $arr_data['message']       = $review;
        $arr_data['mobile_number'] = $mobile_no;
        $arr_data['email']         = $email;
        $arr_data['business_id']   = $id;
        $arr_data['user_id']       = $user_id;

        $status = ReviewsModel::create($arr_data);

        if($status)
        {
           $business_rating = BusinessListingModel::where('id',$arr_data['business_id'])->with(['reviews'])->get()->toArray();
           $reviews=0;
             
              if(isset($business_rating[0]['reviews']) && sizeof($business_rating[0]['reviews'])>0)
              {
                foreach($business_rating[0]['reviews'] as $business_review)
                {
                   $reviews=$reviews+$business_review['ratings'];
                }

             }
             if(sizeof($business_rating[0]['reviews']))
              {
                $tot_review=sizeof($business_rating[0]['reviews']);
                $avg_review=($reviews/$tot_review);
              }
              else
              {
                $avg_review= $tot_review=0;
              }

			 if (isset($business_rating[0]['reviews']) ) 
			  {
			      $business_data['avg_rating']=round($avg_review);
			  }
			$business_data=BusinessListingModel::where('id',$id)->update($business_data);
		}		          
        

	    if($business_data)
		{		   
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Review Submitted Successfully';
		}
		else
		{
  			$json['status']  = 'ERROR';
			$json['message'] = 'Problem Occurred While Submitting Review';
		}	
           return response()->json($json);	 	
    }

    public function store_sms_details(Request $request)
    {
        $name        = $request->input('name');
        $email       = $request->input('email');
        $mobile      = $request->input('mobile');
        $business_id = $request->input('business_id');
        $user_id = $request->input('user_id');

        $arr_data                = array();
        $arr_data['name']        = $name;
        $arr_data['email']       = $email;
        $arr_data['mobile']      = $mobile;
        $arr_data['business_id'] = $business_id;
        $arr_data['user_id']     = $user_id;

        $status = BusinessSendEnquiryModel::create($arr_data);
        if($status)
        {          	 					
          	 $json['status']    = "SUCCESS";
          	 $json['message']    ="sms details store Successfully";
        }
       	else
       	{	
            $json['status'] = "MOBILE_ERROR";
            $json['message']    = "error while sms details store";
        }    
        
        return response()->json($json);
    }



}
