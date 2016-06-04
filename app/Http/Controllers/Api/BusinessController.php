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
        
         $user_id                         =  $request->input('user_id');

         $arr_all=$request->all();

         $arr_all['business_name']        =  $request->input('business_name');
         $business_cat                    =  $request->input('business_cat');
         $business_cat_arr                =   explode(",",$business_cat);
         $main_image                      =  $request->input('main_image'); 

         //location fields
         $area                            =  $request->input('area');
         $city                            =  $request->input('city');
         $pincode                         =  $request->input('pincode');
         $state                           =  $request->input('state');
         $country                         =  $request->input('country');
         $lat                             =  $request->input('lat');
         $lng                             =  $request->input('lng');

         //business times
          $mon_in                          =  $request->input('mon_in');  
          $mon_out                         =  $request->input('mon_out');
          $tue_in                          =  $request->input('tue_in');
          $tue_out                         =  $request->input('tue_out');
          $wed_in                          =  $request->input('wed_in');
          $wed_out                         =  $request->input('wed_out');
          $thus_in                         =  $request->input('thus_in');
          $thus_out                        =  $request->input('thus_out');
          $fri_in                          =  $request->input('fri_in');
          $fri_out                         =  $request->input('fri_out');
          $sat_in                          =  $request->input('sat_in');
          $sat_out                         =  $request->input('sat_out');
          $is_sunday                       =  $request->input('is_sunday');

          if($is_sunday=='1')
          { 
              $sun_open   = $request->input('sun_in');
              $sun_close   = $request->input('sun_out');

          } 

          $company_info                     =  $request->input('company_info');
          $establish_year                   =  $request->input('establish_year');
          $keywords                         =  $request->input('keywords');

          //Contact input array
          $contact_person_name  =       $request->input('contact_person_name');
          $mobile_number        =       $request->input('mobile_number');
          $email_id             =       $request->input('email_id');


      
        if($request->hasFile('main_image'))
        {
          $fileName                    = $request->input'main_image');
          $fileExtension               = strtolower($request->file('main_image')->getClientOriginalExtension());
          if(in_array($fileExtension,['png','jpg','jpeg'))
          {
                $filename              =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                $request->file('main_image')->move($this->business_base_img_path,$filename);
          }
          else
          {
              $json['status']                = "ERROR";
              $json['message']               = 'Information not available.';
          }

          $file_url              = $fileName;
          $main_image              = $filename;
        }
        else
        {
            $json['status']                = "ERROR";
            $json['message']               = 'Information not available.';
        }
          
    }
}
