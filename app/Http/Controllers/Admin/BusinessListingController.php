<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\ZipModel;
use App\Models\CityModel;
use App\Models\BusinessTimeModel;


use Validator;
use Session;
use Sentinel;

class BusinessListingController extends Controller
{
    //
    public function __construct()
    {
    	$arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
    	  $this->UserModel = new UserModel();
    	  $this->BusinessListingModel = new BusinessListingModel();
    	  $this->RestaurantReviewModel= new RestaurantReviewModel();
          $this->BusinessImageUploadModel=new BusinessImageUploadModel();

    	   $this->business_public_img_path = url('/')."/uploads/business/main_image/";
    	   $this->business_base_img_path = base_path()."/public/uploads/business/main_image";

           $this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
          $this->business_base_upload_img_path = base_path()."/public/uploads/business/business_upload_image/";

    }
     /* Business Listing Start */
    public function index()
    {
    	$page_title	='Manage Business Listing';
    	$business_public_img_path = $this->business_public_img_path;

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

    	$business_listing = BusinessListingModel::with(['category','user_details','reviews'])->get()->toArray();
    	//dd($business_listing);
        return view('web_admin.business_listing.index',compact('page_title','business_listing','business_public_img_path','arr_main_category','arr_sub_category'));
    }
    public function create()
    {
    	$page_title="Create Business List";

    	$obj_user_res = UserModel::where('role','normal')->get();
        if( $obj_user_res != FALSE)
        {
            $arr_user = $obj_user_res->toArray();
        }
        $obj_category = CategoryModel::get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

        $obj_countries_res = CountryModel::get();
        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }
        $obj_zipcode_res = ZipModel::get();
        if( $obj_zipcode_res != FALSE)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }
        $arr_city = array();
        $obj_city_res = CityModel::get();
        if($obj_city_res != FALSE)
        {
            $arr_city = $obj_city_res->toArray();
        }
        $arr_state = array();
        $obj_state_res = StateModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
        //dd($arr_category);
        return view('web_admin.business_listing.create',compact('page_title','arr_user','arr_category','arr_country','arr_zipcode','arr_city','arr_state'));
    }
    public function store(Request $request)
    {

        $arr_rules	=	array();
        //business fields
    	$arr_rules['user_id']='required';
        $arr_rules['business_name']='required';
        $arr_rules['business_cat']='required';
        $arr_rules['main_image']='required';


        //location fields
        $arr_rules['building']='required';
        $arr_rules['street']='required';
        $arr_rules['landmark']='required';
        $arr_rules['area']='required';
        $arr_rules['city']='required';
        $arr_rules['pincode']='required';
        $arr_rules['state']='required';
        $arr_rules['country']='required';
        //contact info fields
        $arr_rules['contact_person_name']='required';
        $arr_rules['mobile_number']='required';
        $arr_rules['landline_number']='required';
        $arr_rules['fax_no']='required';
        $arr_rules['toll_free_number']='required';
        $arr_rules['email_id']='required';
        $arr_rules['website']='required';
        //business times
        $arr_rules['mon_in']='required';
        $arr_rules['mon_out']='required';
        $arr_rules['tue_in']='required';
        $arr_rules['tue_out']='required';
        $arr_rules['wed_in']='required';
        $arr_rules['wed_out']='required';
        $arr_rules['thus_in']='required';
        $arr_rules['thus_out']='required';
        $arr_rules['fri_in']='required';
        $arr_rules['fri_out']='required';
        $arr_rules['sat_in']='required';
        $arr_rules['sat_out']='required';
        $arr_rules['sun_in']='required';
        $arr_rules['sun_out']='required';
        //other fields
    	//$arr_rules['hours_of_operation']='required';
    	$arr_rules['company_info']='required';
        $arr_rules['establish_year']='required';
    	$arr_rules['keywords']='required';
    	$arr_rules['youtube_link']='required';
    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/business_listing/create')->withErrors($validator)->withInput();
        }
        $form_data=$request->all();
        $arr_data['user_id']=$form_data['user_id'];
        $arr_data['is_active']='2';
        $arr_data['business_added_by']=$form_data['business_added_by'];
        $arr_data['business_name']=$form_data['business_name'];
        $business_cat=$form_data['business_cat'];
        $payment_mode=$form_data['payment_mode'];
        $business_service=$form_data['business_service'];
        if($request->hasFile('main_image'))
        {
            $fileName       = $form_data['main_image'];
            $fileExtension  = strtolower($request->file('main_image')->getClientOriginalExtension());
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                  $request->file('main_image')->move($this->business_base_img_path,$filename);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
            $arr_data['main_image'] = $filename;
        }
        else
        {
            return redirect()->back();
        }


        //location input array
        $arr_data['building']=$form_data['building'];
        $arr_data['street']=$form_data['street'];
        $arr_data['landmark']=$form_data['landmark'];
        $arr_data['area']=$form_data['area'];
        $arr_data['city']=$form_data['city'];
        $arr_data['pincode']=$form_data['pincode'];
        $arr_data['state']=$form_data['state'];
        $arr_data['country']=$form_data['country'];
        $arr_data['lat']=$request->input('lat');
        $arr_data['lng']=$request->input('lng');
        //Contact input array
        $arr_data['contact_person_name']=$form_data['contact_person_name'];
        $arr_data['mobile_number']=$form_data['mobile_number'];
        $arr_data['landline_number']=$form_data['landline_number'];
        $arr_data['fax_no']=$form_data['fax_no'];
        $arr_data['toll_free_number']=$form_data['toll_free_number'];
        $arr_data['email_id']=$form_data['email_id'];
        $arr_data['website']=$form_data['website'];


        //other input array
        //$arr_data['hours_of_operation']=$form_data['hours_of_operation'];
    	$arr_data['company_info']=$form_data['company_info'];
        $arr_data['establish_year']=$form_data['establish_year'];
    	$arr_data['keywords']=$form_data['keywords'];
    	$arr_data['youtube_link']=$form_data['youtube_link'];

        $insert_data = BusinessListingModel::create($arr_data);
        $business_id = $insert_data->id;

        foreach ($business_cat as $key => $value)
        {
            $arr_cat_data['business_id']=$business_id;
            $arr_cat_data['category_id']=$value;
            $insert_data = BusinessCategoryModel::create($arr_cat_data);

        }

        foreach ($payment_mode as $key => $value)
        {
            $arr_paymentmode_data['business_id']=$business_id;
            $arr_paymentmode_data['title']=$value;
            $insert_data = BusinessPaymentModeModel::create($arr_paymentmode_data);
        }
         foreach ($business_service as $key => $value)
        {
            $arr_serv_data['business_id']=$business_id;
            $arr_serv_data['name']=$value;
            $insert_data = BusinessServiceModel::create($arr_serv_data);
        }


         $files = $request->file('business_image');
         $file_count = count($files);
         $uploadcount = 0;
         foreach($files as $file) {
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
                 Session::flash('error','Invalid file extension');
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
            $arr_time['sun_open']    = $request->input('sun_in');
            $arr_time['sun_close']   = $request->input('sun_out');

            $business_time_add = BusinessTimeModel::create($arr_time);

            if($business_time_add)
            {
                Session::flash('success','Business Created successfully');
            }
        	else
            {
                Session::flash('error','Error Occurred While Creating Business List ');
            }

        }
        else
        {
        	Session::flash('error','Error Occurred While Creating Business List ');
        }
        return redirect()->back();

    }
    public function edit($enc_id)
 	{
 		$id = base64_decode($enc_id);
 		$page_title = "Business Listing: Edit ";
 		$business_public_img_path = $this->business_public_img_path;
        $business_base_upload_img_path =$this->business_public_upload_img_path;
 		$business_data = array();
 		$obj_category = CategoryModel::get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}
 		$obj_user_res = UserModel::where('role','normal')->get();
        if( $obj_user_res != FALSE)
        {
            $arr_user = $obj_user_res->toArray();
        }

        $obj_countries_res = CountryModel::get();
        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }
        $obj_zipcode_res = ZipModel::get();
        if( $obj_zipcode_res != FALSE)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }
        $arr_city = array();
        $obj_city_res = CityModel::get();
        if($obj_city_res != FALSE)
        {
            $arr_city = $obj_city_res->toArray();
        }
        $arr_state = array();
        $obj_state_res = StateModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
         $arr_upload_image = array();
        $obj_upload_image_res = BusinessImageUploadModel::where('business_id',$id)->get();

        if( $obj_upload_image_res != FALSE)
        {
            $arr_upload_image = $obj_upload_image_res->toArray();
        }

        $business_data=BusinessListingModel::with(['category','user_details','city_details','zipcode_details','country_details','state_details','image_upload_details','service','business_times','payment_mode'])->where('id',$id)->get()->toArray();
 		//dd($business_data);
         return view('web_admin.business_listing.edit',compact('page_title','business_data','arr_user','arr_category','business_public_img_path','business_base_upload_img_path','arr_state','arr_country','arr_zipcode','arr_city','arr_upload_image'));

 	}
 	public function update(Request $request,$enc_id)
 	{

 		$id	=base64_decode($enc_id);
        $arr_all  = array();
        $arr_all=$request->all();
        $business_service=$arr_all['business_service'];
        $payment_mode=$arr_all['payment_mode'];
        //dd($payment_mode);
        $form_data	= array();
 		$business_data = array();
 		$arr_rules = array();

 		$arr_rules['business_name'] = "required";
 		$arr_rules['business_cat'] = "required";
 		$arr_rules['user_id'] = "required";

        //location fields
        $arr_rules['building']='required';
        $arr_rules['street']='required';
        $arr_rules['landmark']='required';
        $arr_rules['area']='required';
        $arr_rules['city']='required';
        $arr_rules['pincode']='required';
        $arr_rules['state']='required';
        $arr_rules['country']='required';
        $arr_rules['lat']='required';
        $arr_rules['lng']='required';
        //contact info fields
        $arr_rules['contact_person_name']='required';
        $arr_rules['mobile_number']='required';
        $arr_rules['landline_number']='required';
        $arr_rules['fax_no']='required';
        $arr_rules['toll_free_number']='required';
        $arr_rules['email_id']='required';
        $arr_rules['website']='required';

        //business times
        $arr_rules['mon_in']='required';
        $arr_rules['mon_out']='required';
        $arr_rules['tue_in']='required';
        $arr_rules['tue_out']='required';
        $arr_rules['wed_in']='required';
        $arr_rules['wed_out']='required';
        $arr_rules['thus_in']='required';
        $arr_rules['thus_out']='required';
        $arr_rules['fri_in']='required';
        $arr_rules['fri_out']='required';
        $arr_rules['sat_in']='required';
        $arr_rules['sat_out']='required';
        $arr_rules['sun_in']='required';
        $arr_rules['sun_out']='required';

        //$arr_rules['hours_of_operation']='required';
    	$arr_rules['company_info']='required';
        $arr_rules['establish_year']='required';
    	$arr_rules['keywords']='required';
    	$arr_rules['youtube_link']='required';



        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user=Sentinel::createModel();

        $business_data['business_name']      = $request->input('business_name');
        $business_data['user_id']=$request->input('user_id');

        $business_category = BusinessCategoryModel::where('business_id',$id);
        $res= $business_category->delete();
        if($res)
        {
         $business_cat=$request->input('business_cat');

            foreach ($business_cat as $key => $value)
            {
                $arr_cat_data['business_id']=$id;
                $arr_cat_data['category_id']=$value;
                $insert_data = BusinessCategoryModel::create($arr_cat_data);
            }
        }
        $payment_count = count($payment_mode);
         //exit;
        if($payment_count>0){
        foreach($payment_mode as $key =>$value) {
         if($value!=null)
         {

                $arr_payment_mode_data['business_id']=$id;
                $arr_payment_mode_data['title']=$value;
                $insert_data = BusinessPaymentModeModel::create($arr_payment_mode_data);
        }

        }

       }
          $ser_count = count($business_service);
         //exit;
        if($ser_count>0){
        foreach($business_service as $key =>$value) {
         if($value!=null)
         {

                $arr_serv_data['business_id']=$id;
                $arr_serv_data['name']=$value;
                $insert_data = BusinessServiceModel::create($arr_serv_data);
        }

        }

       }

        $filename=$request->input('old_image');
		if($request->hasFile('main_image'))
        {
            $fileName       = $request->file('main_image');
            $fileExtension  = strtolower($request->file('main_image')->getClientOriginalExtension());
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                  $request->file('main_image')->move($this->business_base_img_path,$filename);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }

        $business_data['main_image'] = $filename;

       //location input array
        $business_data['building']=$request->input('building');
        $business_data['street']=$request->input('street');
        $business_data['landmark']=$request->input('landmark');
        $business_data['area']=$request->input('area');
        $business_data['city']=$request->input('city');
        $business_data['pincode']=$request->input('pincode');
        $business_data['state']=$request->input('state');
        $business_data['country']=$request->input('country');
        $business_data['lat']=$request->input('lat');
        $business_data['lng']=$request->input('lng');

        //Contact input array
        $business_data['contact_person_name']=$request->input('contact_person_name');
        $business_data['mobile_number']=$request->input('mobile_number');
        $business_data['landline_number']=$request->input('landline_number');
        $business_data['fax_no']=$request->input('fax_no');
        $business_data['toll_free_number']=$request->input('toll_free_number');
        $business_data['email_id']=$request->input('email_id');
        $business_data['website']=$request->input('website');

        //other input array



        $business_data['hours_of_operation']=$request->input('hours_of_operation');
    	$business_data['company_info']=$request->input('company_info');
        $business_data['establish_year']=$request->input('establish_year');
    	$business_data['keywords']=$request->input('keywords');
    	$business_data['youtube_link']=$request->input('youtube_link');



        $business_data=BusinessListingModel::where('id',$id)->update($business_data);

         $files = $request->file('business_image');

         $file_count = count($files);
        if($file_count>0){
         $uploadcount = 0;
         foreach($files as $file) {
         if($file!=null)
         {
             $destinationPath = $this->business_base_upload_img_path;
             $fileName = $file->getClientOriginalName();
                $fileExtension  = strtolower($file->getClientOriginalExtension());
                if(in_array($fileExtension,['png','jpg','jpeg']))
                {
                      $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                      $file->move($destinationPath,$filename);
                      $arr_insert['image_name']=$filename;
                      $arr_insert['business_id']=$id;
                      $insert_data1=$this->BusinessImageUploadModel->create($arr_insert);
                      $uploadcount ++;
                }
                else
                {
                     Session::flash('error','Invalid file extension');
                }
        }
        }
      }
        if($business_data /*&& $user_data*/)
        {
            $arr_time['business_id'] = $id;
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
            $arr_time['sun_open']    = $request->input('sun_in');
            $arr_time['sun_close']   = $request->input('sun_out');

            $business_time_update = BusinessTimeModel::where('business_id',$id)->update($arr_time);

            Session::flash('success','Business Updated successfully');

        }
        else
        {
        	Session::flash('error','Error Occurred While Updating Business List ');
        }
        return redirect()->back();
   	}
    public function delete_gallery(Request $request)
    {
       $business_base_upload_img_path =$this->business_base_upload_img_path;
        $image_name=$request->input('image_name');
        $id=$request->input('id');
        $Business = $this->BusinessImageUploadModel->where('id',$id);
        $res= $Business->delete();
        if($res)
        {
             $business_base_upload_img_path.$image_name;
           if(unlink($business_base_upload_img_path.$image_name))
           {
            echo "done";
           }
        }

    }
    public function delete_service(Request $request)
    {
       $id=$request->input('id');
        $service = BusinessServiceModel::where('id',$id);
        $res= $service->delete();
        if($res)
        {

            echo "done";

        }

    }
    public function delete_payment_mode(Request $request)
    {
       $id=$request->input('id');
        $payment_mode = BusinessPaymentModeModel::where('id',$id);
        $res= $payment_mode->delete();
        if($res)
        {

            echo "done";

        }

    }

    public function show($enc_id)
    {
        $id = base64_decode($enc_id);
        $page_title = "Business Listing: Show ";
        $business_public_img_path = $this->business_public_img_path;
        $business_base_upload_img_path =$this->business_public_upload_img_path;
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
        $business_data = array();
        $business_data=BusinessListingModel::with(['user_details','city_details','zipcode_details','country_details','state_details','category','service','image_upload_details','payment_mode'])->where('id',$id)->get()->toArray();
         //dd($business_data);
         return view('web_admin.business_listing.show',compact('page_title','business_data','business_public_img_path','business_base_upload_img_path','arr_main_category','arr_sub_category'));

    }
   	public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Business(es) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','Business(es) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','Business(es) Deleted Successfully');
        }

        return redirect()->back();
    }
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Any Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','Business(es) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Business(es) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Business(es) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
     protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = BusinessListingModel::where('id',$id)->first();

        $Business->is_active = "1";

        return $Business->save();
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = BusinessListingModel::where('id',$id)->first();

        $Business->is_active = "0";

        return $Business->save();
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
        $Business = BusinessListingModel::where('id',$id);
		return $Business->delete();
    }

    
      /* Business Listing End */

   }
