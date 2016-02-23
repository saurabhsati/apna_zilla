<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\RestaurantModel;
use App\Models\DealModel;
use App\Models\RestaurantReviewModel;
use App\Models\DishModel;

class RestaurantController extends Controller
{
    public function __construct()
    {
    	$json = array();
    }

    public function edit(Request $request)
    {
    	$id = $request->input('id'); 
   		 
      $obj_restaurant = RestaurantModel::where('id',$id)->first();

   		if($obj_restaurant)
   		{
   			$arr_result = $obj_restaurant->toArray();
   			if(count($arr_result)>0)
   			{	
   				$arr_data['id']  		    = $arr_result['id'];
   				$arr_data['user_id']  	= $arr_result['user_id'];  
   				$arr_data['cuisine_id'] = $arr_result['cuisine_id'];
   				$arr_data['name']  		  = $arr_result['name'];
   				$arr_data['description']= $arr_result['description'];
   				$arr_data['address']  	= $arr_result['address'];
   				$arr_data['contact_no'] = $arr_result['contact_no'];
   				$arr_data['logo_image'] = $arr_result['logo_image'];
   				$arr_data['cover_image']= $arr_result['cover_image'];
          $arr_data['email']      = $arr_result['email'];
   				
   				$json['data']	= $arr_data;
   				$json['status'] = "SUCCESS";
   			}
   			else
   			{
   				$json['status'] = "ERROR";
   			}
   		}
   		else
   		{
   			$json['status'] = "ERROR";
   		}

   		return response()->json($json); 
    }

   /* public function update(Request $request)
    {
      $id = $request->input('id');

      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
      $ = $request->input('');
     

      return response()->json($json); 
    }*/



    public function about_us(Request $request)
    {
    	$id = $request->input('id'); 
   		$obj_restaurant = RestaurantModel::where('id',$id)->first();

   		if($obj_restaurant)
   		{
   			$arr_result = $obj_restaurant->toArray();
   			if(count($arr_result)>0)
   			{	
   				$arr_data['description'] = $arr_result['description'];
   				$arr_data['lat']   		   = $arr_result['lat'];
   				$arr_data['lng']         = $arr_result['lng'];
   				$arr_data['avg_rating']  = $arr_result['avg_rating'];

     				$obj_deal_result = DealModel::where('restaurant_id',$id)->get();
     				if($obj_deal_result)
     				{	
     					$arr_deal_result =  $obj_deal_result->toArray();
     					if(count($arr_deal_result)>0)
     					{
                $arr_data['deal_count']   = count($arr_deal_result);
                $obj_restaurant_reviews   = RestaurantReviewModel::where('restaurant_id',$id)->get();
                if($obj_restaurant_reviews)
                {
                  $arr_reviews_result =  $obj_restaurant_reviews->toArray();
                  if(count($arr_reviews_result)>0)
                  {
                    $arr_data['review_count'] = count($arr_reviews_result);  
                  }
                }         	
              }
     				}
          $json['data']   = $arr_data;
          $json['status'] = "SUCCESS";

   			}
   			else
   			{
   				$json['status'] = "ERROR";
   			}
   		}
   		else
   		{
   			$json['status'] = "ERROR";
   		}
   		return response()->json($json); 
    }

    public function menu(Request $request)
    {
    	$id  			       = $request->input('id');
    	$arr_condition 	 = array('restaurant_id'=>$id,'is_active'=>'1');
    	$obj_deal 		   = DealModel::where($arr_condition)->get(['id','name','description','deal_image']);

   		if($obj_deal)
   		{
   			$arr_result = $obj_deal->toArray();
   			if(count($arr_result)>0)
   			{
          //most popular dishes.
          $obj_dish = DishModel::where($arr_condition)->orderBy('avg_rating','DESC')->get(['id','name','is_veg','price','avg_rating']);
          if($obj_dish)
          {
            $arr_dish_result  = $obj_dish->toArray();
            $arr_data['popular _dishes'] = $arr_dish_result;
          }
          $arr_data['active_deals'] = $arr_result;
          $json['data']             = $arr_data;
          $json['status']           = "SUCCESS";
   			}
   			else
	   		{
	   			$json['status'] = "ERROR";
	   		}
   		}
   		else
   		{
   			$json['status'] = "ERROR";
   		}

    	return response()->json($json);
    }

}
