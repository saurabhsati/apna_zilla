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
       $json                           = array();
       $this->business_public_img_path = url('/')."/uploads/business/main_image/";
       $this->business_base_img_path   = base_path()."/public/uploads/business/main_image";

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
        // dd($request->all());
         $arr_data=array();
         $arr_data['user_id']              = $request->input('user_id');
         $arr_data['sales_user_public_id'] = $request->input('sales_user_public_id');
         
        
         $arr_data['business_added_by']     = ucfirst($request->input('business_added_by'));
         $arr_data['business_name']         =  $request->input('business_name');

         $business_cat_arr                =   explode(",",$request->input('business_cat'));
         $payment_mode                    =   explode(",",$request->input('payment_mode'));
         $business_service                =   explode(",",$request->input('business_service'));

         $main_image                      =  $request->input('main_image'); 

         //location  fields
          $arr_data['area']                = $request->input('area');
          $arr_data['city']                = $request->input('city');
          $arr_data['pincode']             = $request->input('pincode');
          $arr_data['state']               = $request->input('state');
          $arr_data['country']             = $request->input('country');
          $arr_data['lat']                 = $request->input('lat');
          $arr_data['lng']                 = $request->input('lng');

          $arr_data['company_info']        = $request->input('company_info');
          $arr_data['establish_year']      = $request->input('establish_year');
          $arr_data['keywords']            = $request->input('keywords');

          $arr_data['contact_person_name'] = $request->input('contact_person_name');
          $arr_data['mobile_number']       = $request->input('mobile_number');
          
         
          
            
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
        //dd($arr_data);
          $insert_data = BusinessListingModel::create($arr_data);
          $business_id = $insert_data->id;

           $business_main_cat_slug=$request->input('business_main_cat_slug');
          $public_id = $this->objpublic->generate_business_public_by_category($business_main_cat_slug,$business_id);
          BusinessListingModel::where('id', '=', $business_id)->update(array('busiess_ref_public_id' => $public_id));
          if(isset($business_cat) && sizeof($business_cat))
          {
            foreach ($business_cat as $key => $value)
            {
                $arr_cat_data['business_id']=$business_id;
                $arr_cat_data['category_id']=$value;
                $insert_data = BusinessCategoryModel::create($arr_cat_data);
            }
          }
          if(isset($payment_mode) && sizeof($payment_mode))
          {
            foreach ($payment_mode as $key => $value)
            {
                $arr_paymentmode_data['business_id']=$business_id;
                $arr_paymentmode_data['title']=$value;
                $insert_data = BusinessPaymentModeModel::create($arr_paymentmode_data);
            }
          }
          if(isset($business_service) && sizeof($business_service))
          {
              foreach ($business_service as $key => $value)
              {
                  if($value!=null)
                  {
                      $arr_serv_data['business_id']=$business_id;
                      $arr_serv_data['name']=$value;
                      $insert_data = BusinessServiceModel::create($arr_serv_data);
                 }
              }
          }

          $files = $request->file('business_image');
          $file_count = count($files);
          $uploadcount = 0;
          if(isset($files) && sizeof($files))
          {
               foreach($files as $file) 
               {
                  $destinationPath = $this->business_base_upload_img_path;
                  $fileName = $file->getClientOriginalName();
                  $fileExtension  = strtolower($file->getClientOriginalExtension());
                  if(in_array($fileExtension,['png','jpg','jpeg']))
                  {
                        $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                        $file->move($destinationPath,$filename);
                        $arr_insert['image_name']=$filename;
                        $arr_insert['business_id']=$business_id;
                        $insert_data1=$this->BusinessImageUploadModel->create($arr_insert);
                        $uploadcount ++;
                  }
                  else
                  {
                       $json['status']                = "ERROR";
                       $json['message']               = 'Invali Image Format .';
                  }
              }
          }
          if($insert_data)
          {
              $arr_time                = array();
              $arr_time['business_id'] = $business_id;
              $arr_time['mon_open']    = $request->input('mon_in');
              $arr_time['mon_close']   = $request->input('mon_out');
              $arr_time['tue_open']    = $request->input('tue_in');
              $arr_time['tue_close']   = $request->input('tue_out');
              $arr_time['wed_open']    = $request->input('wed_in');
              $arr_time['wed_close']   = $request->input('wed_out');
              $arr_time['thus_open']   = $request->input('thus_in');
              $arr_time['thus_close']  = $request->input('thus_out');
              $arr_time['fri_open']    = $request->input('fri_in');
              $arr_time['fri_close']   = $request->input('fri_out');
              $arr_time['sat_open']    = $request->input('sat_in');
              $arr_time['sat_close']   = $request->input('sat_out');
              if($request->input('is_sunday')=='1')
              { 
                  $arr_time['sun_open']    = $request->input('sun_in');
                  $arr_time['sun_close']   = $request->input('sun_out');

              } 

              $business_time_add = BusinessTimeModel::create($arr_time);

              if($business_time_add)
              {
                   $json['status'] = 'SUCCESS';
                   $json['message']  = 'Business Created Successfully.';
              }
              else
              {
                   $json['status'] = 'ERROR';
                   $json['message']  = 'Error Occure while Creating Business.';
              }

          }
        return response()->json($json);
          
    }
}
