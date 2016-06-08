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
       $this->business_base_upload_img_path   = base_path()."/public/uploads/business/business_upload_image/";
       $this->objpublic                       = new GeneratePublicId();
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
        																  ->with(['category','reviews','membership_plan_details'])->get();
        																  
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
                 $arr_data[$key]['id']                    = $business['id'];

                 $sub_category_title=$main_cat_title=$main_cat_id='';

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
          		    	 		   			$main_cat_id=$main_category['cat_id'];
                                $arr_data[$key]['main_category_title']   = $main_cat_title[0];
          		    	 		   		}

          		    	 		    }
          	    	 		   }
          	    	    }
                      if($sub_category_title!='')
                      {
                         $arr_data[$key]['sub_category_title']    = implode(',',$sub_category_title);
                      }

              	   	}
                 }
                 $arr_data[$key]['user_id']   = $business['user_id'];
                 $arr_data[$key]['main_cat_id']   = $main_cat_id;
                 $arr_data[$key]['review_star_count'] = sizeof($business['reviews']);
                 $arr_data[$key]['establish_year']    = $business['establish_year'];
                 $arr_data[$key]['area']              = $business['area'];
                 $arr_data[$key]['mobile_number']     = $business['mobile_number'];
                 $arr_data[$key]['membership_plan']   = sizeof($business['membership_plan_details']);
                

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
    
    public function store_business_step1(Request $request)
    {
         $arr_data=array();
         $arr_data['user_id']              = $request->input('user_id');
         $arr_data['business_added_by']    = ucfirst($request->input('business_added_by'));
         $arr_data['business_name']        =  $request->input('business_name');

         $business_cat                     =   explode(",",$request->input('business_cat'));
         $main_image                       =  $request->input('main_image');

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

          $insert_data = BusinessListingModel::create($arr_data);

          $business_id = $insert_data->id;

          $business_main_cat_slug=$request->input('business_main_cat_slug');

          $public_id = $this->objpublic->generate_business_public_by_category($business_main_cat_slug,$business_id);

          BusinessListingModel::where('id', '=', $business_id)->update(array('busiess_ref_public_id' => $public_id));

          $insert_data=0;

          if(isset($business_cat) && sizeof($business_cat)>0)
          {
              foreach ($business_cat as $key => $value)
              {
                  $arr_cat_data['business_id']=$business_id;
                  $arr_cat_data['category_id']=$value;
                  $insert_data = BusinessCategoryModel::create($arr_cat_data);
              }
          }
      
         if($insert_data)
          {
               $json['business_id'] = $business_id;
               $json['status']      = 'SUCCESS';
               $json['message']     = 'Business First Step completed Successfully ! .';
          }
          else
          {
               $json['status']   = 'ERROR';
               $json['message']  = 'Error Occure while Submiting your Business.';
          }

            
          return response()->json($json);
    }

    public function store_business_step2(Request $request)
    {
        $business_id         = $request->input('business_id');
        $user_id             = $request->input('user_id');

        $arr_data['area']    = $request->input('area');
        $arr_data['city']    = $request->input('city');
        $arr_data['state']   = $request->input('state');
        $arr_data['country'] = $request->input('country');
        $arr_data['pincode'] = $request->input('pincode');
        $arr_data['lat']     = $request->input('lat');
        $arr_data['lng']     = $request->input('lng');

        $location_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);

        if($location_add)
        {
            $json['business_id'] = $business_id;
            $json['status']      = 'SUCCESS';
            $json['message']     = 'Business Second Step completed Successfully ! .';
        }
        else 
        {
            $json['status']   = 'ERROR';
            $json['message']  = 'Error Occure while Creating Business.';
        }
         return response()->json($json);
    }

    public function store_business_step3(Request $request)
    {
        $business_id         = $request->input('business_id');
        $user_id             = $request->input('user_id');

        $arr_data['prefix_name']             =        $request->input('prefix_name');
        $arr_data['contact_person_name']     =        $request->input('contact_person_name');
        $arr_data['mobile_number']           =        $request->input('mobile_number');


        $location_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);

        if($location_add)
        {
           
            $json['business_id'] = $business_id;
            $json['status']      = 'SUCCESS';
            $json['message']     = 'Business Third Step completed Successfully ! .';
        }
        else 
        {
            $json['status']   = 'ERROR';
            $json['message']  = 'Error Occure while Creating Business.';
        }
         return response()->json($json);

    }

    public function store_business_step4(Request $request)
    {
        $json        = array();
        $business_id = $request->input('business_id');
        $user_id     = $request->input('user_id');

        $arr_data['company_info']   = $request->input('company_info');
        $arr_data['establish_year'] = $request->input('establish_year');
        $arr_data['keywords']       = $request->input('keywords');
        $payment_mode               =  explode(",",$request->input('payment_mode'));

        $insert_data =0;

         $insert_data = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);


        if(isset($payment_mode) && sizeof($payment_mode)>0)
        {
              foreach ($payment_mode as $key => $value)
              {
                  $arr_paymentmode_data['business_id'] = $business_id;
                  $arr_paymentmode_data['title']       = $value;
                  $insert_data                         = BusinessPaymentModeModel::create($arr_paymentmode_data);
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
                  $json['business_id'] = $business_id;
                  $json['status']      = 'SUCCESS';
                  $json['message']     = 'Business Fourth Step completed Successfully ! .';
              }
              else
              {
                   $json['status'] = 'ERROR';
                   $json['message']  = 'Error Occure while Creating Business.';
              }

          }
          return response()->json($json);
    }

    public function store_business_step5(Request $request)
    {
        $json                           = array();
        $business_id      = $request->input('business_id');
        $user_id          = $request->input('user_id');
        $business_service = explode(",",$request->input('business_service'));
        $files            = $request->file('business_image');
        $insert_data =$insert_data1=0;
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
            }
        }
        $file_count = count($files);
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
                      $insert_data1              = $this->BusinessImageUploadModel->create($arr_insert);
                      $uploadcount ++;
                }
                else
                {
                     $json['status']                = "ERROR";
                     $json['message']               = 'Invali Image Format .';
                }
            }
        }
        if($insert_data || $insert_data1)
        {
            $json['business_id'] = $business_id;
            $json['status']      = 'SUCCESS';
            $json['message']     = 'Business Fifth Step completed Successfully ! .';
        }
        else
        {
             $json['status']  = 'ERROR';
             $json['message'] = 'Error Occure while Creating Business.';
        }

        return response()->json($json);
    }

    public function edit_business_step(Request $request)
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

                $arr_data['business_id']           = $business_data['id'];
                $arr_data['busiess_ref_public_id']           = $business_data['busiess_ref_public_id'];
                $arr_data['main_image']            = url('/uploads/business/main_image').'/'.$business_data['main_image'];
                $arr_data['business_name']         = $business_data['business_name'];
               

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
                      $uploaded_image_gallery[$key]['id']=$image_gallery['id'];
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
    public function update_business_step1(Request $request)
    {
            $json        = array();
            $business_id = $request->input('business_id');
            $main_image  = $request->input('main_image');

            if ($request->hasFile('main_image'))
            {
                $profile_pic_valiator = Validator::make(array('main_image'=>$request->file('main_image')),array( 'main_image' => 'mimes:jpg,jpeg,png' ));

                if ($request->file('main_image')->isValid() && $profile_pic_valiator->passes())
                {
                    $cv_path            = $request->file('main_image')->getClientOriginalName();
                    $image_extension    = $request->file('main_image')->getClientOriginalExtension();
                    $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                    $request->file('main_image')->move($this->business_base_img_path, $image_name);
                    $main_image     = $image_name;
                }
                else
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

            }
            $business_data['business_name'] = $request->input('business_name');
            $business_data['main_image']    = $main_image;
            $business_cat                   =  explode(",",$request->input('business_cat'));
            $business_cat_slug              = $request->input('business_public_id');

            if($business_cat!=null)
            {
                $business_category = BusinessCategoryModel::where('business_id',$business_id);
                $res= $business_category->delete();

                foreach ($business_cat as $key => $value)
                {
                    $arr_cat_data['business_id']=$business_id;
                    $arr_cat_data['category_id']=$value;
                    $insert_data = BusinessCategoryModel::create($arr_cat_data);
                }
            }


             
             $chk_business_category=[];
             $chk_business_category=BusinessListingModel::where('id', '=', $business_id)->where('busiess_ref_public_id',$business_cat_slug)->first();
             if($chk_business_category)
             {
                  $arr_business = $chk_business_category->toArray();
                  if(sizeof($arr_business)>0)
                  {
                    $business_data['busiess_ref_public_id']= $business_cat_slug;
                  }
              }
              else
              {
                 $public_id = $this->objpublic->generate_business_public_by_category($business_cat_slug,$business_id);
                 $business_data['busiess_ref_public_id']= $public_id;
              }

              $business_data_res=BusinessListingModel::where('id',$business_id)->update($business_data);
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
            $business_data_res=BusinessListingModel::where('id',$business_id)->update($business_data);

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
               $json['status'] = 'ERROR';
               $json['message']  = 'Error Occure while Updating Business.';
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
       

         $payment_mode_arr               =  explode(",",$request->input('payment_mode'));
        //dd($payment_mode);
        $payment_count = count($payment_mode_arr);
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
                        $arr_payment_mode_data['business_id']=$business_id;
                        $arr_payment_mode_data['title']=$value;
                        $insert_data = BusinessPaymentModeModel::create($arr_payment_mode_data);
                 }

              }

        }

        $business_data_res               = BusinessListingModel::where('id',$business_id)->update($business_data);
        if($business_data_res)
        {

            $arr_time                = array();
            $arr_time['business_id'] = $business_id;
            $arr_time['mon_open']    = $request->input('mon_in');
            $arr_time['mon_close']   = $request->input('mon_out');
            $arr_time['tue_open']    = $request->input('tue_in');
            $arr_time['tue_close']   = $request->input('tue_out');
            $arr_time['wed_open']    = $request->input('wed_in');
            $arr_time['wed_close']   = $request->input('wed_out');
            $arr_time['thus_open']   = $request->input('thu_in');
            $arr_time['thus_close']  = $request->input('thu_out');
            $arr_time['fri_open']    = $request->input('fri_in');
            $arr_time['fri_close']   = $request->input('fri_out');
            $arr_time['sat_open']    = $request->input('sat_in');
            $arr_time['sat_close']   = $request->input('sat_out');
            if($is_sunday=='1')
            { 
                 $arr_time['sun_open']    = $request->input('sun_in');
                 $arr_time['sun_close']   = $request->input('sun_out');
            }
            else
            {
                $arr_time['sun_open']="";
                $arr_time['sun_close']="";
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
           $json['status'] = 'ERROR';
           $json['message']  = 'Error Occure while Updating Business.';
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
                      $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                      $file->move($destinationPath,$filename);
                      $arr_insert['image_name']=$filename;
                      $arr_insert['business_id']=$business_id;
                      $insert_data1=$this->BusinessImageUploadModel->create($arr_insert);
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
             $json['status'] = 'ERROR';
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
    




}
