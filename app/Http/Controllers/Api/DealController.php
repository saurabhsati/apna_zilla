<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealModel;
use App\Models\CategoryModel;
use App\Models\DishModel;


class DealController extends Controller
{
    public function __construct()
    {
    	$json = array();
        $this->deal_image_path = base_path().'/public/uploads/deal/';
    }

    public function store(Request $request)
    {
        $deal_type         = $request->input('id');

        $restaurant_id     = $request->input('restaurant_id');
        $cuisine_id        = $request->input('cuisine_id');
        $name              = $request->input('name');
        $price             = $request->input('price');
        $description       = $request->input('description');
        $start_time        = $request->input('start_time');
        $end_time          = $request->input('end_time');
        $start_day         = $request->input('start_day');
        $end_day           = $request->input('end_day');

        $arr_data['restaurant_id']  = $restaurant_id;
        $arr_data['cuisine_id']     = $cuisine_id;
        $arr_data['name']           = $name;
        $arr_data['price']          = $price;
        $arr_data['description']    = $description;
        $arr_data['deal_type']      = $deal_type;
        $arr_data['start_time']     = $start_time;
        $arr_data['end_time']       = $end_time;
        $arr_data['start_day']      = $start_day;
        $arr_data['end_day']        = $end_day;

        if($request->hasFile('deal_image'))
        {
            $cv_path            = $request->file('deal_image')->getClientOriginalName();
            $image_extension    = $request->file('deal_image')->getClientOriginalExtension();
            $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
            $final_image        = $request->file('deal_image')->move($this->deal_image_path,$image_name);          
        }

        $arr_data['deal_image'] = $image_name;
        $result = DealModel::create($arr_data);

        if($result)
        {
            $json['status']  = "SUCCESS";
        }   
        else
        {
            $json['status']  = "ERROR";
        }

        return response()->json($json);
    }

    public function edit(Request $request)
    {
        $id     = $request->input('id');
        $obj_result = DealModel::where('id',$id)->first();
        if($obj_result)
        {
            $arr_result = $obj_result->toArray();

            if(count($arr_result) > 0)
            {
                $start_day_data  = $arr_result['start_day'];
                $end_day_data    = $arr_result['end_day'];
               
                $start_day_data = date("Y-m-d", strtotime($start_day_data));  
                $end_day_data   = date("Y-m-d", strtotime($end_day_data));  
                  
                $days[] = date("D", strtotime($start_day_data));  
               
                $current_day = $start_day_data;  
                while($current_day < $end_day_data)
                {  
                  $current_day = date("Y-m-d", strtotime("+1 day", strtotime($current_day)));  
                  $days[]      = date("D", strtotime($current_day));  
                }  

                $arr_data['id']               = $arr_result['id'];
                $arr_data['restaurant_id']    = $arr_result['restaurant_id'];
                $arr_data['cuisine_id']       = $arr_result['cuisine_id'];
                $arr_data['name']             = $arr_result['name'];
                $arr_data['price']            = $arr_result['price'];
                $arr_data['description']      = $arr_result['description'];
                $arr_data['deal_image']       = $arr_result['deal_image'];
                $arr_data['deal_type']        = $arr_result['deal_type'];
                $arr_data['days']             = $days;
                $arr_data['start_time']       = $arr_result['start_time'];
                $arr_data['end_time']         = $arr_result['end_time'];
                $arr_data['redeem_count']     = $arr_result['redeem_count'];

                if(count($arr_data) > 0)
                {
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
                $json['status']  = "ERROR";
            }

        }
        else
        {
             $json['status']  = "ERROR";
        } 
    
        return response()->json($json);
    }


    public function update(Request $request)
    {
        $id     = $request->input('id');
        
        $restaurant_id     = $request->input('restaurant_id');
        $cuisine_id        = $request->input('cuisine_id');
        $name              = $request->input('name');
        $price             = $request->input('price');
        $description       = $request->input('description');
        $start_time        = $request->input('start_time');
        $end_time          = $request->input('end_time');
        $start_day         = $request->input('start_day');
        $end_day           = $request->input('end_day');
        $deal_type         = $request->input('deal_type');

        $arr_data['restaurant_id']  = $restaurant_id;
        $arr_data['cuisine_id']     = $cuisine_id;
        $arr_data['name']           = $name;
        $arr_data['price']          = $price;
        $arr_data['description']    = $description;
        $arr_data['deal_type']      = $deal_type;
        $arr_data['start_time']     = $start_time;
        $arr_data['end_time']       = $end_time;
        $arr_data['start_day']      = $start_day;
        $arr_data['end_day']        = $end_day;

        if($request->hasFile('deal_image'))
        {
            $cv_path            = $request->file('deal_image')->getClientOriginalName();
            $image_extension    = $request->file('deal_image')->getClientOriginalExtension();
            $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
            
            if($image_name)
            {
                $deal_result = DealModel::where('id',$id)->first();
                if($deal_result)
                {
                    $arr_result     = $deal_result->toArray();
                    $unlink_path    = $this->deal_image_path.$arr_result['deal_image'];
                    $unlink_image   = unlink($unlink_path);
                    if($unlink_image==TRUE)
                    {
                        $final_image  = $request->file('deal_image')->move($this->deal_image_path,$image_name);          
                    }
                }   
                $deal_image = $image_name; 
            }
            
        }
        else
        {
            $deal_result = DealModel::where('id',$id)->first();
            if($deal_result)
            {
                $arr_result  = $deal_result->toArray();
                $deal_image  = $arr_result['deal_image'];
            }   
        }

        $arr_data['deal_image'] = $deal_image;
        $result = DealModel::where('id',$id)->update($arr_data);

        if($result)
        {
            $json['status']  = "SUCCESS";
        }   
        else
        {
            $json['status']  = "ERROR";
        }

        return response()->json($json);
    }

    public function get_menus()
    {
        $obj_category = CategoryModel::get();
        if($obj_category)
        {
            $arr_data     = $obj_category->toArray();
            if(count($arr_data) > 0)
            {
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

    public function get_sub_menus(Request $request)
    {
        $category_id = $request->input('id');
        $restaurant_id = $request->input('restaurant_id'); 
        
        $obj_result = DishModel::where(array('category_id'=>$category_id,'restaurant_id'=>$restaurant_id))->get();           
        if($obj_result)
        {
            $arr_data   = $obj_result->toArray();
            if(count($arr_data) > 0)
            {
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


    public function featured_deals(Request $request)
    {
        $restaurant_id  = $request->input('id');
        $arr_condition  = array('restaurant_id'=>$restaurant_id,'is_active'=>'1');
        $obj_result     = DealModel::where($arr_condition)->orderBy('avg_rating','DESC')->get(['id','deal_image','name','is_veg','description','price','avg_rating']);
        
        if($obj_result)
        {
            $arr_result = $obj_result->toArray();
            if(count($arr_result)>0)
            {
                /*image isveg price name dec avg_rating*/
                $arr_data['featured_deals'] = $arr_result;
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

}
