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
use App\Models\ReviewsModel;
use App\Common\Services\GeneratePublicId;
use Validator;
use Session;
use Sentinel;
use Mail;
use Carbon\Carbon as Carbon;

class SalesExecutiveBusinessController extends Controller
{
    	public function __construct()
    	{
       $json                                  = array();
       $this->business_public_img_path        = url('/')."/uploads/business/main_image/";
       $this->business_base_img_path          = base_path()."/public/uploads/business/main_image";
       $this->BusinessImageUploadModel        = new BusinessImageUploadModel();
       $this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
       $this->business_base_upload_img_path   = base_path()."/public/uploads/business/business_upload_image/";
       $this->objpublic                       = new GeneratePublicId();
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
            $obj_business_listing = BusinessListingModel::orderBy('id','DESC')
                                              ->where('sales_user_public_id',$sales_user_public_id)
            																  ->with(['category','user_details','reviews','membership_plan_details'])->get();
            																  	      
            																  	      //->get(['id','busiess_ref_public_id','business_name','main_image']);
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
                     $arr_data[$key]['is_verified']           = $business['is_verified'];
                     $arr_data[$key]['id']                    = $business['id'];

                     if(isset($business['user_details']) && sizeof($business['user_details'])>0)
                     {
                          $arr_data[$key]['vender_first_name']        = $business['user_details']['first_name'];
                          $arr_data[$key]['vender_public_id']         = $business['user_details']['public_id'];
                     }
                     $arr_data[$key]['reviews']    = sizeof($business['reviews']);
                     $arr_data[$key]['is_feature'] = sizeof($business['membership_plan_details']);
                     $sub_category_title           = $main_cat_title='';
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
                          if(strlen($sub_category_title)>0 && isset($sub_category_title))
                          {
                             $arr_data[$key]['sub_category_title'] = implode(',',$sub_category_title);
                          }  
                          else{
                            $arr_data[$key]['sub_category_title'] = array();
                          }

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

      /*Add business basic information step 1 */
      public function store_business_step1(Request $request)
      {
        $arr_data                         = array();
        $form_data                        = $request->all();
        $arr_data['user_id']              = $request->input('user_id');
        $arr_data['sales_user_public_id'] = $request->input('sales_user_public_id');
        $arr_data['business_added_by']    = ucfirst($request->input('business_added_by'));
        $arr_data['business_name']        = $request->input('business_name');
        $business_cat                     = explode(",",$request->input('business_cat'));
        $main_image                       = $request->input('main_image');
     
        //Upload Image 
        if($request->hasFile('main_image'))
            {
                $fileName                    = $request->input('main_image');
                $fileExtension               = strtolower($request->file('main_image')->getClientOriginalExtension());
                if(in_array($fileExtension,['png','jpg','jpeg']))
                {
                      $filename = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                      $request->file('main_image')->move($this->business_base_img_path,$filename);
                }
                else
                {
                    $json['status']  = "ERROR";
                    $json['message'] = 'Invalid Image Format .';
                }

                $file_url               = $fileName;
                $arr_data['main_image'] = $filename;
            }
            else
            {
                $json['status']  = "ERROR";
                $json['message'] = 'Please Select Image.';
            }
        
        //End Upload Image
 
        $insert_data = BusinessListingModel::create($arr_data);
        
        //create business public id 
        $business_id                     = $insert_data->id;
        $business_cat_slug = $form_data['business_public_id'];
        $public_id         = $this->objpublic->generate_business_public_by_category($business_cat_slug,$business_id);
        $business                        = BusinessListingModel::find($business_id);
        $business->busiess_ref_public_id = $public_id;
        $business->save();

        //Add business category
        if(sizeof($business_cat)>0)
        {
           foreach ($business_cat as $key => $value)
            {
                $arr_cat_data['business_id'] = $business_id;
                $arr_cat_data['category_id'] = $value;
                $insert_data                 = BusinessCategoryModel::create($arr_cat_data);
            }
        }

        if($business_id > 0)
        {
          $json['status']      = 'SUCCESS';
          $json['message']     = 'Business Created Successfully.';
          $json['business_id'] = $business_id;
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Creating Business.';
        }
        return response()->json($json);
      }

      /* Add business Store Location  step2*/
      public function store_business_step2(Request $request)
      {
        $arr_data            = array();
        $business_id         = $request->input('business_id');
        $arr_data['area']    = $request->input('area');
        $arr_data['city']    = $request->input('city');
        $arr_data['pincode'] = $request->input('pincode');
        $arr_data['state']   = $request->input('state');
        $arr_data['country'] = $request->input('country');
        $arr_data['lat']     = $request->input('lat');
        $arr_data['lng']     = $request->input('lng');

        $locationUpadte = BusinessListingModel::where('id', '=', $business_id)->update($arr_data);

        if($locationUpadte)
        {
          $json['status']      = 'SUCCESS';
          $json['message']     = 'Business Location Successfully Updated.';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Creating Business.';
        }
       return response()->json($json);
      }
      public function store_business_step3(Request $request)
      {
        /*$arr_data                   = array();
        $business_id                = $request->input('business_id');
        $arr_data['company_info']   = $request->input('company_info');
        $arr_data['establish_year'] = $request->input('establish_year');
        $arr_data['keywords']       = $request->input('keywords');
        $contactInfoUpadte = BusinessListingModel::where('id', '=', $business_id)->update($arr_data);
        if($contactInfoUpadte)
        {
          $json['status']  = 'SUCCESS';
          $json['message'] = 'Business Contact info Successfully Updated.';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Creating Business.';
        }
        return response()->json($json);*/
         $business_id                          = $request->input('business_id');

         $business_data['prefix_name']         = $request->input('prefix_name');
         $business_data['contact_person_name'] = $request->input('contact_person_name');
         $business_data['mobile_number']       = $request->input('mobile_number');

         $business_data_res=BusinessListingModel::where('id',$business_id)->update($business_data);

          if($business_data_res)
          {
              $json['business_id'] = $business_id;
              $json['status']      = 'SUCCESS';
              $json['message']     = 'Business Third Step Updated Successfully ! .';
          }
          else
          {
               $json['status']  = 'ERROR';
               $json['message'] = 'Error Occure while Updating Business.';
          }

          return response()->json($json);
      }
      public function store_business_step4(Request $request)
      {
        $arr_data    = array();
        $business_id = $request->input('business_id');
        $arr_data['company_info']   = $request->input('company_info');
        $arr_data['establish_year'] = $request->input('establish_year');
        $arr_data['keywords']       = $request->input('keywords');
        $payment_mode               = explode(",",$request->input('payment_mode'));
        $otherUpadte                = BusinessListingModel::where('id', '=', $business_id)->update($arr_data);

        if(sizeof($payment_mode)>0)
        {
          foreach ($payment_mode as $key => $value)
                {
                    $arr_paymentmode_data['business_id']=$business_id;
                    $arr_paymentmode_data['title']=$value;
                    $insert_data = BusinessPaymentModeModel::create($arr_paymentmode_data);
                }
        }
        $arr_time               = array();
        $arr_time['business_id'] = $business_id;
        $arr_time['mon_open']   = $request->input('mon_open');
        $arr_time['mon_close']  = $request->input('mon_close');
        $arr_time['tue_open']   = $request->input('tue_open');
        $arr_time['tue_close']  = $request->input('tue_close');
        $arr_time['wed_open']   = $request->input('wed_open');
        $arr_time['wed_close']  = $request->input('wed_close');
        $arr_time['thus_open']  = $request->input('thus_open');
        $arr_time['thus_close'] = $request->input('thus_close');
        $arr_time['fri_open']   = $request->input('fri_open');
        $arr_time['fri_close']  = $request->input('fri_close');
        $arr_time['sat_open']   = $request->input('sat_open');
        $arr_time['sat_close']  = $request->input('sat_close');
        
        if($request->input('is_sunday') == '1')
        { 
            $arr_time['sun_open']  = $request->input('sun_open');
            $arr_time['sun_close'] = $request->input('sun_close');
        } 

        $business_time_add = BusinessTimeModel::create($arr_time);
        
        if($business_time_add)
        {
          $json['status']  = 'SUCCESS';
          $json['message'] = 'Business Other info Successfully Updated.';

        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Creating Business.';

        }

        return response()->json($json);
      }

      public function store_business_step5(Request $request)
      {
        $arr_data    = array();
        $business_id = $request->input('business_id');
       
        $files            = $request->file('business_image');
        $business_service = explode(",",$request->input('business_service'));
        
        /*Gallery image upload*/ 
        $file_count  = count($files);
        $uploadcount = 0;
        if(isset($files) && sizeof($files)>0)
        {
             foreach($files as $file) 
             {
                $destinationPath = $this->business_base_upload_img_path;
                $fileName        = $file->getClientOriginalName();
                $fileExtension   = strtolower($file->getClientOriginalExtension());
                if(in_array($fileExtension,['png','jpg','jpeg']))
                {
                      $filename = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                      $file->move($destinationPath,$filename);
                      $arr_insert['image_name']  = $filename;
                      $arr_insert['business_id'] = $business_id;
                      $insert_data1              = BusinessImageUploadModel::create($arr_insert);
                      $uploadcount ++;
                }
                else
                {
                     $json['status']  = "ERROR";
                     $json['message'] = 'Invalid Image Format .';
                     return response()->json($json);
                }
            }
        }

        //Add bussiness service
        if(isset($business_service) && sizeof($business_service)>0)
        {
            foreach ($business_service as $key => $value)
            {
                if($value!=null)
                {
                    $arr_serv_data['business_id']=$business_id;
                    $arr_serv_data['name']=$value;
                    $insert_data = BusinessServiceModel::create($arr_serv_data);
                }
                else
                {
                  $json['status']  = "ERROR";
                  $json['message'] = 'Invalid Service Data .';
                  return response()->json($json);
                }
            }
        }

        $json['status']  = 'SUCCESS';
        $json['message'] = 'Business gallery images and services successfully updated.';

        return response()->json($json);
      }
    
     //end add business
     
     //edit  business 
    public function edit(Request $request)
    {
       $business_id = $request->input('business_id');

       $business_public_img_path = url('/')."/uploads/business/main_image/";

       $page_title ="Edit Business";

       $parent_obj_category = CategoryModel::where('parent','=',0)->select('cat_id','title')->orderBy('title','ASC')->get();

        if($parent_obj_category)
        {
            $arr_main_category = $parent_obj_category->toArray();
        }

        $obj_sub_category = CategoryModel::where('parent','!=','0')->get();

        if($obj_sub_category)
        {
            $arr_sub_category = $obj_sub_category->toArray();
        }

        $obj_business_data=BusinessListingModel::with(['category','payment_mode','business_times','image_upload_details','service'])->where('id',$business_id)->first();

        if($obj_business_data)
        {
          $business_data=$obj_business_data->toArray();
        }

         $arr_data=[];

        if(isset($business_data) && sizeof($business_data)>0)
        {
          /* Step 1 Data */
          $arr_data['busiess_ref_public_id']= $business_data['busiess_ref_public_id'];
          $arr_data['user_id']= $business_data['user_id'];
          $arr_data['sales_user_public_id']= $business_data['sales_user_public_id'];
          $arr_data['business_added_by']= $business_data['business_added_by'];
          $arr_data['business_id']   = $business_data['id'];
          $arr_data['main_image']    = url('/uploads/business/main_image').'/'.$business_data['main_image'];
          $arr_data['business_name'] = $business_data['business_name'];
         

           $sub_category_title=$main_cat_title='';
           if(isset($business_data['category']) && sizeof($business_data['category'])>0)
           {
              foreach ($business_data['category'] as $key2 => $selected_category) 
              {
                foreach ($arr_sub_category as $key3 => $sub_category)
                {
                   if ($sub_category['cat_id']==$selected_category['category_id'])
                   {

                      $sub_category_title[] = $sub_category['title'];

                      foreach ($arr_main_category as $key4 => $main_category)
                      {
                        if($main_category['cat_id']==$sub_category['parent'])
                        {
                          $main_cat_title[]=$main_category['title'];
                          $arr_data['main_category_title']   = $main_cat_title[0];
                        }

                      }
                   }
                }
                 $arr_data['sub_category_title']    = implode(',',$sub_category_title);

              }
           }

          /* Step 2 Data */
          $arr_data['area']        = $business_data['area'];
          $arr_data['country']     = $business_data['country'];
          $arr_data['state']       = $business_data['state'];
          $arr_data['city']        = $business_data['city'];
          $arr_data['lat']         = $business_data['lat'];
          $arr_data['lng']         = $business_data['lng'];
          $arr_data['pincode']     = $business_data['pincode'];

          /* Step 3 Data */
          $arr_data['prefix_name']             =        $business_data['prefix_name'];
          $arr_data['contact_person_name']     =        $business_data['contact_person_name'];
          $arr_data['mobile_number']           =        $business_data['mobile_number'];


          /* Step 4 Data */
          $arr_data['company_info']   = strip_tags($business_data['company_info']);
          $arr_data['establish_year'] = $business_data['establish_year'];
          $arr_data['keywords']       = strip_tags($business_data['keywords']);

           if(isset($business_data['business_times']) && sizeof($business_data['business_times'])>0)
          {
              foreach ($business_data['business_times'] as $time) 
              {
                   $arr_data['mon_open']   = $time['mon_open'];
                   $arr_data['mon_close']  = $time['mon_close'];
                   $arr_data['tue_open']   = $time['tue_open'];
                   $arr_data['tue_close']  = $time['tue_close'];
                   $arr_data['wed_open']   = $time['wed_open'];
                   $arr_data['wed_close']  = $time['wed_close'];
                   $arr_data['thus_open']  = $time['thus_open'];
                   $arr_data['thus_close'] = $time['thus_close'];
                   $arr_data['fri_open']   = $time['fri_open'];
                   $arr_data['fri_close']  = $time['fri_close'];
                   $arr_data['sat_open']   = $time['sat_open'];
                   $arr_data['sat_close']  = $time['sat_close'];
                   $arr_data['sun_open']   = $time['sun_open'];
                   $arr_data['sun_close']  = $time['sun_close'];
              }
          }
          $selected_payment_mode=array();
          if(isset($business_data['payment_mode']) && sizeof($business_data['payment_mode'])>0)
           {
              foreach ($business_data['payment_mode'] as $payment) 
              {
                $selected_payment_mode[]=$payment['title'];
              }
           }   
           $arr_data['selected_payment_mode']=implode(',', $selected_payment_mode);
         
 
          /* Step 5 Data */

          /* Uploaded Image Data*/

          $uploaded_image_gallery =array();
          if(isset($business_data['image_upload_details']) && sizeof($business_data['image_upload_details'])>0)
           {
              foreach ($business_data['image_upload_details'] as $key =>  $image_gallery) 
              {
                $uploaded_image_gallery[$key]['url']=url('/')."/uploads/business/business_upload_image/".$image_gallery['image_name'];
                $uploaded_image_gallery[$key]['image_name']=$image_gallery['image_name'];
              }
           } 
           $arr_data['uploaded_image_gallery']=$uploaded_image_gallery;  

          /* Services Data*/

           $services_array =array();
           if(isset($business_data['service']) && sizeof($business_data['service'])>0)
           {
              foreach ($business_data['service'] as $key => $serv) 
              {
                 $services_array[$key]['id']=$serv['id'];
                 $services_array[$key]['name']=$serv['name'];
              }
           } 
          $arr_data['business_services']= $services_array;  
         }
         
        if(sizeof($arr_data)>0)
        {
            $json['data']    = $arr_data;
            $json['status']  = 'SUCCESS';
            $json['message'] = 'Business  First Step Data Get Successfully !';
        }
        else
        {
            $json['status']  = 'ERROR';
            $json['message'] = 'No Business Record Found!';
        }
         return response()->json($json);
    }
    
    /*-------------Start update business----------------*/ 
    //Update business step1
    public function update_business_step1(Request $request)
    {
      $json        = array();
      $business_id = $request->input('business_id');
      $main_image  = $request->input('main_image');
      if($request->input('user_id')!='' || $request->input('user_id')!=null)
      {
        $business_data['user_id'] = $request->input('user_id');
      }
    
      if($request->hasFile('main_image'))
      {
          $profile_pic_valiator = Validator::make(array('main_image'=>$request->file('main_image')),array( 'main_image' => 'mimes:jpg,jpeg,png' ));

          if($request->file('main_image')->isValid() && $profile_pic_valiator->passes())
          {
              $cv_path                     = $request->file('main_image')->getClientOriginalName();
              $image_extension             = $request->file('main_image')->getClientOriginalExtension();
              $image_name                  = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
              $request->file('main_image')->move($this->business_base_img_path, $image_name);
              $main_image                  = $image_name;
              $business_data['main_image'] = $main_image;
          }
          else
          {
              return redirect()->back()->withErrors($validator)->withInput();
          }

      }

      $business_data['business_name'] = $request->input('business_name');
      $business_cat                   = explode(",", $request->input('business_cat'));
      $business_cat_slug              = $request->input('business_public_id');

      if($business_cat!=null || $business_cat!='')
      {
          $business_category = BusinessCategoryModel::where('business_id',$business_id);
          $res               = $business_category->delete();

          foreach ($business_cat as $key => $value)
          {
              $arr_cat_data['business_id'] = $business_id;
              $arr_cat_data['category_id'] = $value;
              $insert_data                 = BusinessCategoryModel::create($arr_cat_data);
          }
       
      }


       if($business_cat_slug)
       {
          $chk_business_category = [];
          $chk_business_category = BusinessListingModel::where('id', '=', $business_id)->where('busiess_ref_public_id',$business_cat_slug)->first();
           if($chk_business_category)
           {
              $arr_business = $chk_business_category->toArray();
              if(sizeof($arr_business)>0)
              {
                $business_data['busiess_ref_public_id'] = $business_cat_slug;
              }
            }
            else
            {
               $public_id                              = $this->objpublic->generate_business_public_by_category($business_cat_slug,$business_id);
               $business_data['busiess_ref_public_id'] = $public_id;
            }

        }
       

        $business_data_res = BusinessListingModel::where('id',$business_id)->update($business_data);
        if($business_data_res)
        {
            $json['business_id'] = $business_id;
            $json['status']      = 'SUCCESS';
            $json['message']     = 'Business First Step Updated Successfully ! .';
        }
        else
        {
             $json['status']  = 'ERROR';
             $json['message'] = 'Error Occure while Updating Business.';
        }
        return response()->json($json);
    }
   
    public function update_business_step2(Request $request)
    {
            $business_id              = $request->input('business_id');
            $business_data['area']    = $request->input('area');
            $business_data['country'] = $request->input('country');
            $business_data['state']   = $request->input('state');
            $business_data['city']    = $request->input('city');
            $business_data['pincode'] = $request->input('pincode');
            $business_data['lat']     = $request->input('lat');
            $business_data['lng']     = $request->input('lng');
            //dd($business_data);
            $business_data_res = BusinessListingModel::where('id',$business_id)->update($business_data);

            if($business_data_res)
            {
                $json['business_id'] = $business_id;
                $json['status']      = 'SUCCESS';
                $json['message']     = 'Business Second Step Updated Successfully ! .';
            }
            else
            {
                 $json['status']  = 'ERROR';
                 $json['message'] = 'Error Occure while Updating Business.';
            }

            return response()->json($json);
    }

    public function update_business_step3(Request $request)
    {
         $business_id                          = $request->input('business_id');

         $business_data['prefix_name']         = $request->input('prefix_name');
         $business_data['contact_person_name'] = $request->input('contact_person_name');
         $business_data['mobile_number']       = $request->input('mobile_number');

         $business_data_res=BusinessListingModel::where('id',$business_id)->update($business_data);

          if($business_data_res)
          {
              $json['business_id'] = $business_id;
              $json['status']      = 'SUCCESS';
              $json['message']     = 'Business Third Step Updated Successfully ! .';
          }
          else
          {
               $json['status']  = 'ERROR';
               $json['message'] = 'Error Occure while Updating Business.';
          }

          return response()->json($json);
    }
    public function update_business_step4(Request $request)
    {
        $business_id = $request->input('business_id');

        $business_data['company_info']   = $request->input('company_info');
        $business_data['establish_year'] = $request->input('establish_year');
        $business_data['keywords']       = $request->input('keywords');
        $is_sunday                       = $request->input('is_sunday');
  
        $payment_mode_arr = explode(",",$request->input('payment_mode'));
        //dd($payment_mode);
        $payment_count         = count($payment_mode_arr);
        $business_payment_mode = BusinessPaymentModeModel::where('business_id',$business_id);
        if($business_payment_mode)
        {
           $res= $business_payment_mode->delete();
        }
      
        if($payment_count>0)
        {
              foreach($payment_mode_arr as $key =>$value) 
              {
                 if($value!=null)
                 {
                        $arr_payment_mode_data['business_id'] = $business_id;
                        $arr_payment_mode_data['title']       = $value;
                        $insert_data                          = BusinessPaymentModeModel::create($arr_payment_mode_data);
                 }

              }

        }

        $business_data_res = BusinessListingModel::where('id',$business_id)->update($business_data);
        if($business_data_res)
        {

            $arr_time                = array();
            $arr_time['business_id'] = $business_id;
            $arr_time['mon_open']    = $request->input('mon_open');
            $arr_time['mon_close']   = $request->input('mon_close');
            $arr_time['tue_open']    = $request->input('tue_open');
            $arr_time['tue_close']   = $request->input('tue_close');
            $arr_time['wed_open']    = $request->input('wed_open');
            $arr_time['wed_close']   = $request->input('wed_close');
            $arr_time['thus_open']   = $request->input('thus_open');
            $arr_time['thus_close']  = $request->input('thus_close');
            $arr_time['fri_open']    = $request->input('fri_open');
            $arr_time['fri_close']   = $request->input('fri_close');
            $arr_time['sat_open']    = $request->input('sat_open');
            $arr_time['sat_close']   = $request->input('sat_close');
            if($is_sunday == '1')
            { 
                 $arr_time['sun_open']    = $request->input('sun_open');
                 $arr_time['sun_close']   = $request->input('sun_close');
            }
            else
            {
                $arr_time['sun_open']  = "";
                $arr_time['sun_close'] = "";
            } 

            $business_time_exist = BusinessTimeModel::where('business_id',$business_id)->first(['id','business_id']);

            if($business_time_exist)
            {
                $arr_exist = $business_time_exist->toArray();
                if(count($arr_exist) > 0)
                {
                    $business_time_update = BusinessTimeModel::where('business_id',$business_id)->update($arr_time);
                }
            }
            else 
            {
                    $business_time_add = BusinessTimeModel::create($arr_time);
            }

             $json['business_id'] = $business_id;
             $json['status']      = 'SUCCESS';
             $json['message']     = 'Business Fourth Step Updated Successfully ! .';

        }
        else
        {
           $json['status']  = 'ERROR';
           $json['message'] = 'Error Occure while Updating Business.';
        }

        return response()->json($json);



    }


    public function update_business_step5(Request $request)
    {
        $destinationPath = $this->business_base_upload_img_path;
        $business_id =$request->input('business_id');
        $flag=1;
        $business_service = explode(",",$request->input('business_service'));
        if(sizeof($business_service))
        {
              foreach($business_service as $key =>$value) 
              {
                 if($value!=null)
                 {

                        $arr_serv_data['business_id']=$business_id;
                        $arr_serv_data['name']=$value;
                        $insert_data = BusinessServiceModel::create($arr_serv_data);
                        if($insert_data)
                        {
                            $flag=1;
                        }
                        else
                        {
                             $flag=0;
                        }
                }
             }

        }

         $files = $request->file('business_image');
         $file_count = count($files);
         $uploadcount = 0;
         foreach($files as $file)
         {
             if($file!=null)
             {
                $fileName = $file->getClientOriginalName();
                $fileExtension  = strtolower($file->getClientOriginalExtension());
                $flag=1;
                if(in_array($fileExtension,['png','jpg','jpeg']))
                {
                      $filename                  = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                      $file->move($destinationPath,$filename);
                      $arr_insert['image_name']  = $filename;
                      $arr_insert['business_id'] = $business_id;
                      $insert_data1              = $this->BusinessImageUploadModel->create($arr_insert);
                      $uploadcount ++;
                }
                else
                {
                     Session::flash('error','Invalid file extension');
                     $flag=0;
                }
                
            }
         }

          if($flag==1)
          {
              $json['business_id'] = $business_id;
              $json['status']      = 'SUCCESS';
              $json['message']     = 'Business Fifth Step Updated Successfully ! .';

          }
          else
          {
             $json['status']   = 'ERROR';
             $json['message']  = 'Error Occure while Updating Business.';
          }
          return response()->json($json);
    }

    public function delete_gallery(Request $request)
    {
        $business_base_upload_img_path =base_path()."/public/uploads/business/business_upload_image/";

        $image_name=$request->input('image_name');

        $id=$request->input('id');

        $Business = $this->BusinessImageUploadModel->where('id',$id);
        $res= $Business->delete();
        if($res)
        {
           $business_base_upload_img_path.$image_name;
           if(unlink($business_base_upload_img_path.$image_name))
           {
           
              $json['status']      = 'SUCCESS';
              $json['message']     = 'Business Gallery Image Deleted Successfully ! .';

          }
          else
          {
             $json['status'] = 'ERROR';
             $json['message']  = 'Error Occure while Deleting Business Gallery.';
          }
          return response()->json($json);
        }
    }

    public function delete_service(Request $request)
    {
        $id=$request->input('id');
        $service = BusinessServiceModel::where('id',$id);
        $res= $service->delete();
        if($res)
        {

           $json['status']      = 'SUCCESS';
           $json['message']     = 'Business Service Deleted Successfully ! .';

        }
        else
        {
           $json['status'] = 'ERROR';
           $json['message']  = 'Error Occure while Deleting Business Service.';
        }
        return response()->json($json);
    }


    public function toggle_verifired_status(Request $request)
    {
      $json=array();
        $business_id           = $request->input('business_id');

        $obj_business = BusinessListingModel::where('id',$business_id)->first();
        if($obj_business)
        {
          $business = $obj_business->toArray();
        }
        if(isset($business) && sizeof($business)>0)
        {
            
                if($business['is_verified']== '0')
                {
                   $result = BusinessListingModel::where('id',$business_id)
                                                       ->update(array('is_verified'=>'1'));
                  $json['status']  = 'SUCCESS';
                    $json['message'] = 'Business Verify Successfully  !';
                }

                else if($business['is_verified']== '1')
                {

                  $result = BusinessListingModel::where('id',$business_id)
                                                   ->update(array('is_verified'=>'0'));
                  $json['status']  = 'SUCCESS';
                  $json['message'] = 'Business Un-Verify Successfully !';
                }

           
        }
         else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while verify Business.';

        }

        return response()->json($json);
       
    }

    public function _active_status(Request $request)
    {
        $business_id         = $request->input('business_id');
        $Business            = BusinessListingModel::where('id',$business_id)->first();
        $is_active           = $request->input('is_active');
        $Business->is_active = $is_active;
        $business_active     = $Business->save();

        if($business_active)
        {
           $json['status']      = 'SUCCESS';
           $json['message']     = 'Business Updated Successfully ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while verify Business.';
        }

        return response()->json($json);
       
    }

    public function _delete(Request $request)
    {
        $business_id     = $request->input('business_id');
        $Business        = BusinessListingModel::where('id',$business_id)->first();
        $business_delete = $Business->delete();

        if($business_delete)
        {
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Business delete Successfully ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while delete Business.';
        }

        return response()->json($json);
       
    }

     public function review_index(Request $request)
    {
       $business_id= $request->input('business_id');
       $obj_reviews = ReviewsModel::with(['business_details'])->where('business_id',$business_id)->get();
        $arr_reviews = array();

        if($obj_reviews)
        {
            $arr_reviews = $obj_reviews->toArray();
        }
        $data=[];
        if(isset($arr_reviews) && sizeof($arr_reviews)>0)
        {
          foreach ($arr_reviews as $key => $review)
           {
            $data[$key]['id']            = $review['id'];
            $data[$key]['name']          = $review['name'];
            $data[$key]['mobile_number'] = $review['mobile_number'];
            $data[$key]['email']         = $review['email'];
            $data[$key]['ratings']       = $review['ratings'];
            $data[$key]['message']       = $review['message'];
          }
        }
        if($data)
        { 
           $json['data']    = $data;
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Business Review List ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Listing Business Review';
        }

        return response()->json($json);
    }
    public function show_review(Request $request)
    {
         $review_id     = $request->input('review_id');

        $arr_review_view = array();
        $obj_review_view =ReviewsModel::with(['business_details'])->where('id',$review_id)->first();
        if($obj_review_view)
        {
            $arr_review_view = $obj_review_view->toArray();
        }
        $data=[];
        if(isset($arr_review_view) && sizeof($arr_review_view)>0)
        {
          
              $data['id']            = $arr_review_view['id'];
              $data['business_name'] = $arr_review_view['business_details']['business_name'];
              $data['name']          = $arr_review_view['name'];
              $data['mobile_number'] = $arr_review_view['mobile_number'];
              $data['email']         = $arr_review_view['email'];
              $data['ratings']       = $arr_review_view['ratings'];
              $data['message']       = $arr_review_view['message'];
             }

        if($data)
        { 
           $json['data']    = $data;
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Business Review  ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Listing Business Review';
        }

        return response()->json($json);
    }    

    public function review_toggle_status(Request $request)
    {        
          $review_id             = $request->input('review_id');
          $action                = $request->input('action');

          $json =[];
          if($action=="activate")
          {
              $this->review_activate($review_id);
              $json['status']  = "SUCCESS";
              $json['message'] = 'Review Activate Successfully !.'; 
          }
          elseif($action=="block")
          {
               $this->review_block($review_id);
               $json['status']  = "SUCCESS";
               $json['message'] = 'Review Block Successfully !.';  
          }
          elseif($action=="delete")
          {
             //dd('asdfs');
               $this->review_delete($review_id);    
               $json['status']  = "SUCCESS";
               $json['message'] = 'Review Delete Successfully !.';
          }
          return response()->json($json); 
    }

    protected function review_activate($review_id)
    {
        $review = ReviewsModel::where('id',$review_id)->first();
        $review->is_active = "1";
         return $review->save();
    }
    protected function review_block($review_id)
    {
        $review = ReviewsModel::where('id',$review_id)->first();
        $review->is_active = "0";
        return $review->save();
    }
    protected function review_delete($review_id)
    {
      return ReviewsModel::where('id',$review_id)->delete();
    }
}
