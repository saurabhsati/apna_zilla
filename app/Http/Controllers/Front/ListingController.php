<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;

use Session;
use Validator;

class ListingController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $page_title ='Listing';
    	return view('front.listing.index',compact('page_title'));
    }
    public function list_details($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title ='List Details';
    	   
        $arr_business_details = array();
        $obj_business_details = BusinessListingModel::where('id',$id)->first();
        if($obj_business_details)
        {
            $obj_business_details->load(['business_times','image_upload_details','country_details','state_details','category_details']);
            $arr_business_details = $obj_business_details->toArray();
        }
        
 dd($arr_business_details);
        return view('front.listing.detail',compact('page_title','arr_business_details'));
    }
}
