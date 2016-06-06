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

class BusinessController extends Controller
{
	public function __construct()
	{
	 	   $this->business_public_img_path = url('/')."/uploads/business/main_image/";
    	   $this->business_base_img_path = base_path()."/public/uploads/business/main_image";

           $this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
           $this->business_base_upload_img_path = base_path()."/public/uploads/business/business_upload_image/";
           $this->objpublic = new GeneratePublicId();
	}

   public function index(Request $request)
   {
  		$sales_user_public_id=$request->input('public_id');

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
        $obj_business_listing = BusinessListingModel::orderBy('id','DESC')->where('sales_user_public_id',$sales_user_public_id)
        																  ->with(['category'=>function ($query) 
        																  		  { 
        																  		  //$query->select('id','business_id');
        																  		  },
        																  		  'user_details',
        																  		  'reviews',
        																  		  'membership_plan_details'])->get();
        																  	      
        																  	      //->get(['id','busiess_ref_public_id','business_name','main_image']);
   	    if($obj_business_listing)
   	    {
   	    	$business_listing=$obj_business_listing->toArray();
   	    }

   	    

 	     foreach ($business_listing as $key => $business)
    	 {
    	 	foreach ($business['category'] as $key => $selected_category) 
    	 	{
    	 		foreach ($arr_sub_category as $key => $sub_category)
    	 		{
	    	 		   if ($sub_category['cat_id']==$selected_category['category_id'])
	    	 		   {
	    	 		 		$sub_category_title[]	=	$sub_category['title'];
	    	 		 		foreach ($arr_main_category as $key => $main_category)
		    	 		    {
		    	 		   		if($main_category['cat_id']==$sub_category['parent'])
		    	 		   		{
		    	 		   			$main_cat_title[]=$main_category['title'];
		    	 		   		}

		    	 		    }
	    	 		   }
	    	 		  
    	 		}

    	 	}
    	 	$business_listing[$key]['main_category_title']=$main_cat_title[0];
    	 	$business_listing[$key]['sub_category_title']=implode(',',$sub_category_title);
    	 }

        
      

   }

    public function store(Request $request)
    {
         dd($request->all());
         $user_id                          = $request->input('user_id');
         $arr_data['sales_user_public_id'] = $request->input('sales_user_public_id');
         $arr_all=$request->all();
        
         $arr_all['business_added_by']     = $request->input('business_added_by');
         $arr_all['business_name']         =  $request->input('business_name');

         $business_cat_arr                =   explode(",",$request->input('business_cat'));
         $payment_mode                    =   explode(",",$request->input('payment_mode'));
         $business_service                =   explode(",",$request->input('business_service'));

         $main_image                      =  $request->input('main_image'); 

         //location  fields
         $arr_all['area']       =     $request->input('area');
         $arr_all['city']       =      $request->input('city');
         $arr_all['pincode']    =      $request->input('pincode');
         $arr_all['state']      =      $request->input('state');
         $arr_all['country']    =      $request->input('country');
         $arr_all['lat']        =      $request->input('lat');
         $arr_all['lng']        =      $request->input('lng');

          $arr_all['company_info']                     =  $request->input('company_info');
          $arr_all['establish_year']                   =  $request->input('establish_year');
          $arr_all['keywords']                         =  $request->input('keywords');

          //Contact input array
          $contact_person_name  =       $request->input('contact_person_name');
          $mobile_number        =       $request->input('mobile_number');
          
         //business times
          $arr_time=array();
          $arr_time['mon_open']                          =  $request->input('mon_in');  
          $arr_time['mon_close']                         =  $request->input('mon_out');
          $arr_time['tue_open']                          =  $request->input('tue_in');
          $arr_time['tue_close']                         =  $request->input('tue_out');
          $arr_time['wed_open ']                         =  $request->input('wed_in');
          $arr_time['wed_close']                         =  $request->input('wed_out');
          $arr_time['thus_open']                         =  $request->input('thus_in');
          $arr_time['thus_close']                        =  $request->input('thus_out');
          $arr_time['fri_open']                          =  $request->input('fri_in');
          $arr_time['fri_close']                         =  $request->input('fri_out');
          $arr_time['sat_open']                          =  $request->input('sat_in');
          $arr_time['sat_close']                         =  $request->input('sat_out');
          $is_sunday                           =  $request->input('is_sunday');

          if($is_sunday=='1')
          { 
              $arr_time['sun_open']    = $request->input('sun_in');
              $arr_time['sun_close']   = $request->input('sun_out');

          } 
            
        if($request->hasFile('main_image'))
        {
          $fileName                    = $request->input('main_image');
          $fileExtension               = strtolower($request->file('main_image')->getClientOriginalExtension());
          if(in_array($fileExtension,['png','jpg','jpeg']))
          {
                $filename              =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                $request->file('main_image')->move($this->business_base_img_path,$filename);
          }
          else
          {
              $json['status']                = "ERROR";
              $json['message']               = 'Invali Image Format .';
          }

          $file_url              = $fileName;
          $arr_data['main_image'] = $filename;
        }
        else
        {
            $json['status']                = "ERROR";
            $json['message']               = 'Please Select Image.';
        }
        dd($request->all());
        $insert_data = BusinessListingModel::create($arr_data);
        $business_id = $insert_data->id;
          
    }
}
