<?php
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\PlaceModel;
use Validator;
use Session;
use Input;
use Auth;

class CountryController extends Controller
{


    public function __construct()
    {

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


