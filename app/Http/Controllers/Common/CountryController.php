<?php
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\PlaceModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use Validator;
use Session;
use Input;
use Auth;

class CountryController extends Controller
{


    public function __construct()
    {

    }

    public function get_public_id(Request $request)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            /*List category by keyword*/
            $arr_obj_list = UserModel::where('role','=','normal')
                                           ->where('is_active','=',1)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("public_id", 'like', "%".$search_term."%");

                                             })->get();
             if($arr_obj_list != FALSE)
                {

                            $arr_list = $arr_obj_list->toArray();
                            $arr_final_list = array();
                            if(sizeof($arr_list)>0)
                            {
                                foreach ($arr_list as $key => $user)
                                {
                                    $arr_final_list[$key]['user_id'] = $user['id'];
                                    $arr_final_list[$key]['label'] = $user['public_id'];
                                    $arr_final_list[$key]['span'] = 'Refer to - '.$user['first_name'];


                                    $key++;
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
    public function get_sales_user_public_id(Request $request,$sales_user_public_id)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            $sales_user_public_id = $sales_user_public_id;
            /*List category by keyword*/
            $arr_obj_list = UserModel::where('role','=','normal')
                                           ->where('is_active','=',1)
                                           ->where('sales_user_public_id','=',$sales_user_public_id)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("public_id", 'like', "%".$search_term."%");

                                             })->get();
             if($arr_obj_list != FALSE)
                {

                            $arr_list = $arr_obj_list->toArray();
                            $arr_final_list = array();
                            if(sizeof($arr_list)>0)
                            {
                                foreach ($arr_list as $key => $user)
                                {
                                    $arr_final_list[$key]['user_id'] = $user['id'];
                                    $arr_final_list[$key]['label'] = $user['public_id'];
                                    $arr_final_list[$key]['span'] = 'Refer to - '.$user['first_name'];


                                    $key++;
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

    public function get_states($country_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_states = StateModel::select('id','state_title','country_id')
                                       ->where('country_id',$country_id)
                                       ->orderBy('state_title','ASC')->get();

        if($obj_states != FALSE)
        {
            $arr_state =  $obj_states->toArray();
        }
        if(sizeof($arr_state)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_state'] = $arr_state;
        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_state'] = array();
        }
        return response()->json($arr_response);
    }

    public function get_subcategory($main_cat_id)
    {
        $arr_state = array();
        $arr_response = array();
        $obj_main__category = CategoryModel::where('cat_id',$main_cat_id)->select('cat_id','cat_ref_slug')->first();
        if($obj_main__category != FALSE)
        {
            $arr_main_cat =  $obj_main__category->toArray();
        }
        $obj_category = CategoryModel::where('parent',$main_cat_id)->select('cat_id','title')->get();

        if($obj_category != FALSE)
        {
            $arr_sub_cat =  $obj_category->toArray();
        }

        if(sizeof($arr_sub_cat)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_sub_cat'] = $arr_sub_cat;
            $arr_response['arr_main_cat'] = $arr_main_cat;

        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_sub_cat'] = array();
            $arr_response['arr_main_cat'] = $arr_main_cat;
        }
        return response()->json($arr_response);
    }
    public function get_cities($state_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_cities = CityModel::select('id','city_title','state_id')
                                       ->where('state_id',$state_id)
                                       ->orderBy('city_title','ASC')->get();

        if($obj_cities != FALSE)
        {
            $arr_citiy =  $obj_cities->toArray();
        }

        if(sizeof($arr_citiy)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_city'] = $arr_citiy;
        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_city'] = array();
        }
        return response()->json($arr_response);
    }
    public function get_postalcode($city_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_postalcode = PlaceModel::select('id','postal_code','city_id')
                                       ->where('city_id',$city_id)
                                       ->orderBy('place_name','ASC')->get();

        if($obj_postalcode != FALSE)
        {
            $arr_postalcode =  $obj_postalcode->toArray();
        }

        if(sizeof($arr_postalcode)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_postalcode'] = $arr_postalcode;
        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_postalcode'] = array();
        }
        return response()->json($arr_response);
    }
    public function get_nearby_state($state_id,$country_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_states = StateModel::select('id','state_title','country_id')
                                       ->where('country_id',$country_id)
                                       ->where('id','<>',$state_id)
                                       ->orderBy('state_title','ASC')->get();

        if($obj_states != FALSE)
        {
            $arr_state =  $obj_states->toArray();
        }

        if(sizeof($arr_state)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_state'] = $arr_state;
        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_state'] = array();
        }
        return response()->json($arr_response);
    }

    public function get_nearby_city($city_id,$state_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_cities = CityModel::select('id','city_title')
                                       ->where('state_id',$state_id)
                                       ->where('id','<>',$city_id)
                                       ->orderBy('city_title','ASC')->get();

        if($obj_cities != FALSE)
        {
            $arr_citiy =  $obj_cities->toArray();
        }

        if(sizeof($arr_citiy)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['arr_city'] = $arr_citiy;
        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['arr_city'] = array();
        }
        return response()->json($arr_response);
    }
}


