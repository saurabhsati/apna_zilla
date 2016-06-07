<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\BusinessImageUploadModel;
use App\Models\BusinessPaymentModeModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\RestaurantReviewModel;
use App\Models\BusinessServiceModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\PlaceModel;
use App\Models\CityModel;
use App\Models\BusinessTimeModel;

use App\Models\MembershipModel;
use App\Models\MemberCostModel;
use App\Models\TransactionModel;
use App\Models\EmailTemplateModel;
use App\Common\Services\GeneratePublicId;
use Validator;
use Session;
use Sentinel;
use Mail;
use Carbon\Carbon as Carbon;

class FrontBusinessController extends Controller
{



	public function __construct()
	{
       $json                           = array();
       $this->business_public_img_path = url('/')."/uploads/business/main_image/";
       $this->business_base_img_path   = base_path()."/public/uploads/business/main_image";

       $this->BusinessImageUploadModel=new BusinessImageUploadModel();

       $this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
       $this->business_base_upload_img_path = base_path()."/public/uploads/business/business_upload_image/";
       $this->objpublic = new GeneratePublicId();
	}



    public function index(Request $request)
    {
    	  $user_id=$request->input('user_id');

    	  $obj_main_category = CategoryModel::where('parent','0')->get();

        if($obj_main_category)
        {
            $arr_main_category = $obj_main_category->toArray();
        }

        $obj_sub_category = CategoryModel::where('parent','!=','0')->get();
        if($obj_sub_category)
        {
            $arr_sub_category = $obj_sub_category->toArray();
        }
        $obj_business_listing = BusinessListingModel::orderBy('id','DESC')->where('user_id','=',$user_id)
        																  ->with(['category','user_details','reviews','membership_plan_details'])->get();
        																  
   	    if($obj_business_listing)
   	    {
   	    	$business_listing=$obj_business_listing->toArray();
   	    }
        //dd($business_listing);
        $arr_data=[];
        if(isset($business_listing) && sizeof($business_listing)>0)
        {
     	     foreach ($business_listing as $key => $business)
        	 {

                 $arr_data[$key]['busiess_ref_public_id'] = $business['busiess_ref_public_id'];
                 $arr_data[$key]['main_image']            = url('/uploads/business/main_image').'/'.$business['main_image'];
                 $arr_data[$key]['business_name']         = $business['business_name'];
                 $arr_data[$key]['created_at']            = date('Y-m-d',strtotime($business['created_at']));
                 $arr_data[$key]['is_active']             = $business['is_active'];
                 $arr_data[$key]['id']                    = $business['id'];

                 if(isset($business['user_details']) && sizeof($business['user_details'])>0)
                 {
                      $arr_data[$key]['vender_first_name']         = $business['user_details']['first_name'];
                      $arr_data[$key]['vender_public_id']         = $business['user_details']['public_id'];
                 }




                 $sub_category_title=$main_cat_title='';
                 if(isset($business['category']) && sizeof($business['category'])>0)
                 {
              	  	foreach ($business['category'] as $key2 => $selected_category) 
              	  	{
              	  		foreach ($arr_sub_category as $key3 => $sub_category)
              	 	  	{
          	    	 		   if ($sub_category['cat_id']==$selected_category['category_id'])
          	    	 		   {
          	    	 		 		$sub_category_title[]	=	$sub_category['title'];
          	    	 		 		foreach ($arr_main_category as $key4 => $main_category)
          		    	 		    {
          		    	 		   		if($main_category['cat_id']==$sub_category['parent'])
          		    	 		   		{
          		    	 		   			$main_cat_title[]=$main_category['title'];
                                $arr_data[$key]['main_category_title']   = $main_cat_title[0];
          		    	 		   		}

          		    	 		    }
          	    	 		   }
          	    	    }
                       $arr_data[$key]['sub_category_title']    = implode(',',$sub_category_title);

              	   	}
                 }

         }
            $json['data']    = $arr_data;
            $json['status']  = 'SUCCESS';
            $json['message'] = 'Business List !';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'No Business Record Found!';
        }
       
        return response()->json($json);
        
       
    }

    public function store_business_step1()
    {

    }
}
