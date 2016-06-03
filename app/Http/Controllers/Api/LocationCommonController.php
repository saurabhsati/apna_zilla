<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\PlaceModel;
use Input;

class LocationCommonController extends Controller
{
    public function __construct()
    {
        $json                          = array();
    }   
     
    /* Get state by city (India 1) */
	public function get_states_by_country(Request $request)
    {
        $country_id = $request->input('country_id');
        $arr_state = array();
        $json = array();

        $obj_states = StateModel::select('id','state_title','country_id')
                                       ->where('country_id',$country_id)
                                       ->orderBy('state_title','ASC')->get();

        if($obj_states != FALSE)
        {
            $arr_state =  $obj_states->toArray();
        }
        if(sizeof($arr_state)>0)
        {
            $json['status'] ="SUCCESS";
            $json['data'] = $arr_state;
            $json['message']  = 'Information Get Successfully.';
        }
        else
        {
            $json['status'] ="ERROR";
            $json['arr_state'] = array();
        }
        return response()->json($json);
    }

     /* Get city by state (Maharastra  21) */
    public function get_cities_by_state(Request $request)
    {
        $state_id = $request->input('state_id');
        $arr_state = array();
        $json = array();

        $obj_cities = CityModel::select('id','city_title','state_id')
                                       ->where('state_id',$state_id)
                                       ->orderBy('city_title','ASC')->get();

        if($obj_cities != FALSE)
        {
            $arr_citiy =  $obj_cities->toArray();
        }

        if(sizeof($arr_citiy)>0)
        {
            $json['status'] ="SUCCESS";
            $json['data'] = $arr_citiy;
        }
        else
        {
            $json['status'] ="ERROR";
            $json['data'] = array();
        }
        return response()->json($json);
    }

    /* Get pincode by city (Nashik  411) */
  
    public function get_postalcode_by_city(Request $request)
    {
        $city_id = $request->input('city_id');
        $arr_state = array();
        
        $obj_postalcode = PlaceModel::select('id','postal_code','city_id')
                                       ->where('city_id',$city_id)
                                       ->orderBy('place_name','ASC')->get();

        if($obj_postalcode != FALSE)
        {
            $arr_postalcode =  $obj_postalcode->toArray();
        }

        if(sizeof($arr_postalcode)>0)
        {
            $json['status'] ="SUCCESS";
            $json['data'] = $arr_postalcode;
        }
        else
        {
            $json['status'] ="ERROR";
            $json['data'] = array();
        }
        return response()->json($json);
    }
}
