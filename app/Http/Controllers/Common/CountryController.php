<?php 
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\StateModel; 
use App\Model\CityModel; 
use Validator;
use Session;
use Input;
use Auth;
 
class CountryController extends Controller
{

  /*
    | Constructor : creates instances of model class 
    |               & handles the admin authantication
    | auther : Jasmeen 
    | Date : 09/12/2015
    | @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->locale = \App::getLocale(); 
        $this->record_lang = "1";  // English Default 

        if($this->locale=="en")
        {
            $this->record_lang = "1"; // English 
        }
        else if($this->locale=="de")
        {
           
            $this->record_lang = "2"; // German 
        }
    }


      /*
    | get_states : function to generate States belongs 
    |              to specific country
    | auther : Jasmeen 
    | Date : 02/02/2016
    | @param :  int $country_id
    | @return \Illuminate\Http\Response
    */

    public function get_states($country_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_states = StateModel::select('id','state_title','countries_id')
                                       ->where('countries_id',$country_id)
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

    public function get_nearby_state($state_id,$country_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_states = StateModel::select('id','state_title','countries_id')
                                       ->where('countries_id',$country_id)
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
 

