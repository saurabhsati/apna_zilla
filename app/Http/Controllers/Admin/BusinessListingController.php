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
           $this->objpublic = new GeneratePublicId();
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
        $business_listing =[];
    	$obj_business_listing = BusinessListingModel::with(['category','user_details','reviews','membership_plan_details'])->orderBy('created_at','DESC')->get();
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }
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
        $obj_category = CategoryModel::where('parent','=',0)->select('cat_id','title')->orderBy('title','ASC')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

       
        return view('web_admin.business_listing.create',compact('page_title','arr_user','arr_category'));
    }
    public function store(Request $request)
    {
        //echo'<pre>';
       // print_r($request->all());exit;

        $arr_rules	=	array();
        //business fields
    	$arr_rules['tmp_user_id']='required';
        $arr_rules['business_name']='required';
        $arr_rules['business_cat']='required';
        $arr_rules['main_image']='required';


        //location fields
       // $arr_rules['building']='required';
        //$arr_rules['street']='required';
       // $arr_rules['landmark']='required';
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
        //$arr_rules['landline_number']='required';
        //$arr_rules['fax_no']='required';
        //$arr_rules['toll_free_number']='required';
        //$arr_rules['email_id']='required';
        //$arr_rules['website']='required';
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
    	//$arr_rules['youtube_link']='required';
    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            //print_r($validator->errors()->all());exit;
            return redirect('/web_admin/business_listing/create')->withErrors($validator)->withInput();
        }
        $form_data=$request->all();
        $arr_data['user_id']=$form_data['tmp_user_id'];


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
        $arr_data['building']=$request->input('building');
        $arr_data['street']=$request->input('street');
        $arr_data['landmark']=$request->input('landmark');
        $arr_data['area']=$request->input('area');
        $arr_data['city']=$request->input('city');
        $arr_data['pincode']=$request->input('pincode');
        $arr_data['state']=$request->input('state');
        $arr_data['country']=$request->input('country');
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
        $business_cat_slug=$form_data['business_public_id'];
        $public_id = $this->objpublic->generate_business_public_by_category($business_cat_slug,$business_id);
        BusinessListingModel::where('id', '=', $business_id)->update(array('busiess_ref_public_id' => $public_id));

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
         $ser_count = count($business_service);
         //exit;
        if($ser_count>0)
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
 		$parent_obj_category = CategoryModel::where('parent','=',0)->select('cat_id','title')->orderBy('title','ASC')->get();

 		if($parent_obj_category)
 		{
 			$arr_parent_category = $parent_obj_category->toArray();
 		}
        $obj_category = CategoryModel::orderBy('title','ASC')->get();

        if($obj_category)
        {
            $arr_category = $obj_category->toArray();
        }
 		$obj_user_res = UserModel::where('role','normal')->get();
        if( $obj_user_res != FALSE)
        {
            $arr_user = $obj_user_res->toArray();
        }


        //dd($arr_place);
         $arr_upload_image = array();
        $obj_upload_image_res = BusinessImageUploadModel::where('business_id',$id)->get();

        if( $obj_upload_image_res != FALSE)
        {
            $arr_upload_image = $obj_upload_image_res->toArray();
        }

        $business_data=BusinessListingModel::with(['category','user_details','image_upload_details','service','business_times','payment_mode'])->where('id',$id)->get()->toArray();
 		//dd($business_data);
         return view('web_admin.business_listing.edit',compact('page_title','arr_parent_category','business_data','arr_user','arr_category','business_public_img_path','business_base_upload_img_path','arr_upload_image'));

 	}
 	public function update(Request $request,$enc_id)
 	{

 		$id	=base64_decode($enc_id);
        $arr_all  = array();
        $arr_all=$request->all();
        /*echo"<pre>";
        print_r($arr_all);exit;*/
        $business_service=$arr_all['business_service'];
        $payment_mode=$arr_all['payment_mode'];
        //dd($payment_mode);
        $form_data	= array();
 		$business_data = array();
 		$arr_rules = array();

 		$arr_rules['business_name'] = "required";
 		//$arr_rules['business_cat'] = "required";
 		$arr_rules['tmp_user_id'] = "required";

        //location fields
        //$arr_rules['building']='required';
        //$arr_rules['street']='required';
        //$arr_rules['landmark']='required';
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
        //$arr_rules['landline_number']='required';
       // $arr_rules['fax_no']='required';
        //$arr_rules['toll_free_number']='required';
       // $arr_rules['email_id']='required';
        //$arr_rules['website']='required';

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
    	//$arr_rules['youtube_link']='required';



        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             //print_r( $validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user=Sentinel::createModel();

        $business_data['business_name']      = $request->input('business_name');
        $business_data['user_id']=$request->input('tmp_user_id');

        $business_cat=$request->input('business_cat');
        if(sizeof($business_cat)>0 && $business_cat!=null )
        {

            $business_category = BusinessCategoryModel::where('business_id',$id);
            $res= $business_category->delete();
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



        //$business_data['hours_of_operation']=$request->input('hours_of_operation');
    	$business_data['company_info']=$request->input('company_info');
        $business_data['establish_year']=$request->input('establish_year');
    	$business_data['keywords']=$request->input('keywords');
    	$business_data['youtube_link']=$request->input('youtube_link');

         $business_cat_slug=$request->input('business_public_id');
         $chk_business_category=[];
         $chk_business_category=BusinessListingModel::where('id', '=', $id)->where('busiess_ref_public_id',$business_cat_slug)->first();
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
             $public_id = $this->objpublic->generate_business_public_by_category($business_cat_slug,$id);
             $business_data['busiess_ref_public_id']= $public_id;
             //BusinessListingModel::where('id', '=', $id)->update(array('busiess_ref_public_id' => $public_id));
           }
           //dd($arr_business);
        
        

         /*  echo"<pre>";
        print_r($business_data);exit;*/
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
        $obj_business_arr=BusinessListingModel::where('id',$id)->get();
        if( $obj_business_arr != FALSE)
        {
            $business = $obj_business_arr->toArray();
        }
        if( $business != FALSE)
        {
             $arr_place = array();

            $obj_place_res = PlaceModel::where('id',$business[0]['pincode'])->get();

            if( $obj_place_res != FALSE)
            {
                $arr_place = $obj_place_res->toArray();
            }
        }
        $business_data = array();
        $business_data=BusinessListingModel::with(['user_details','city_details','zipcode_details','country_details','state_details','category','service','image_upload_details','payment_mode'])->where('id',$id)->get()->toArray();
         //dd($business_data);
         return view('web_admin.business_listing.show',compact('page_title','business_data','business_public_img_path','business_base_upload_img_path','arr_main_category','arr_place','arr_sub_category'));

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
    public function toggle_verifired_status($enc_id,$action)
    {
        if($action=="verified")
        {
            $this->_verifired($enc_id);

            Session::flash('success','Business(es) verified Successfully');
        }
        elseif($action=="unverified")
        {
            $this->_unverifired($enc_id);

            Session::flash('success','Business(es) Un-Verified Successfully');
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
            Session::flash('error','Problem Occurred, While Doing Multi Action');
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
     protected function _verifired($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = BusinessListingModel::where('id',$id)->first();

        $Business->is_verified = "1";

        return $Business->save();
    }

    protected function _unverifired($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = BusinessListingModel::where('id',$id)->first();

        $Business->is_verified = "0";

        return $Business->save();
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
        $Business = BusinessListingModel::where('id',$id);
		return $Business->delete();
    }

    public function assign_membership($enc_business_id,$enc_user_id,$enc_category_id)
    {
        $page_title="Assign Membership";
        $business_id=base64_decode($enc_business_id);

        $user_id=base64_decode($enc_user_id);
        $category_id=base64_decode($enc_category_id);
        $arr_cost_data=array();
        $obj_cost_data = MemberCostModel::where('category_id',$category_id)->first();
        if($obj_cost_data)
        {
            $arr_cost_data = $obj_cost_data->toArray();
        }
        if(sizeof($arr_cost_data)>0)
        {
            $obj_membership_plan = MembershipModel::get();
            if($obj_membership_plan)
            {
                $arr_membership_plan = $obj_membership_plan->toArray();
            }
            return view('web_admin.business_listing.admin_assign_membership',compact('page_title','arr_membership_plan','enc_business_id','enc_user_id','enc_category_id'));

        }
        else
        {
            Session::flash('error','Error ! Business Category Cost Not Present ,Firstly add the plan cost for this business category ! ');
            return redirect()->back();
        }


    }
    public function get_plan_cost(Request $request)
    {
         $category_id=base64_decode($request->input('category_id'));
         $plan_id=$request->input('plan_id');

        $obj_membership_plan = MembershipModel::where('plan_id',$plan_id)->first();
        if($obj_membership_plan)
        {
            $arr_membership_plan = $obj_membership_plan->toArray();
        }
        $validity=0;
        $price=0;

        if(sizeof($arr_membership_plan)>0)
        {   $arr_cost_data=array();
            $obj_cost_data = MemberCostModel::where('category_id',$category_id)->first();
            if($obj_cost_data)
            {
                $arr_cost_data = $obj_cost_data->toArray();
            }
                if(sizeof($arr_cost_data)>0)
                {
                    if($arr_membership_plan['title']=='Premium')
                    {
                        $price=$arr_cost_data['premium_cost'];

                    }
                    if($arr_membership_plan['title']=='Gold')
                    {
                        $price=$arr_cost_data['gold_cost'];

                    }
                     if($arr_membership_plan['title']=='Basic')
                    {
                        $price=$arr_cost_data['basic_cost'];

                    }
                    $validity=$arr_membership_plan['validity'];

                    $arr_response['status'] ="SUCCESS";
                    $arr_response['price'] =$price;
                    $arr_response['validity'] = $validity;
                }
                else
                {
                    Session::flash('error','Error ! Business Category Cost Not Present ,Firstly add the plan cost for this category ! ');
                    $arr_response['status'] ="CategoryCostAbsent";
                    $arr_response['price'] =0;
                    $arr_response['validity'] = $validity;
                }

        }
        else
        {
             $arr_response['status'] ="ERROR";
            //$arr_response['arr_state'] = array();
        }
        return response()->json($arr_response);

    }
    public function purchase_plan(Request $request)
    {

        $arr_rules=array();
        $arr_rules['business_id']='required';
        $arr_rules['user_id']='required';
        $arr_rules['category_id']='required';
        $arr_rules['plan_id']='required';
        $arr_rules['price']='required';
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $business_id=base64_decode($request->input('business_id'));
        $user_id=base64_decode($request->input('user_id'));
        $category_id=base64_decode($request->input('category_id'));
        $plan_id=$request->input('plan_id');
        $price=$request->input('price');
        $validity=$request->input('validity');

        $arr_data['business_id']=$business_id;
        $arr_data['user_id']=$user_id;
        $arr_data['category_id']=$category_id;
        $arr_data['membership_id']=$plan_id;
        $arr_data['price']=$price;
        $arr_data['transaction_status']='Active';
        $arr_data['start_date']=date('Y-m-d');
        $arr_data['expire_date']=date('Y-m-d', strtotime("+".$validity."days"));
       // dd($arr_data);
        $transaction = TransactionModel::create($arr_data);

        if($transaction)
        {
            $obj_single_transaction=TransactionModel::where('id',$transaction->id)->first();
            if($obj_single_transaction)
            {
                $obj_single_transaction->load(['user_records']);
                $obj_single_transaction->load(['membership']);
                $obj_single_transaction->load(['business']);
                $obj_single_transaction->load(['category']);

                $arr_single_transaction = $obj_single_transaction->toArray();
            }
            $first_name=ucfirst($arr_single_transaction['user_records']['first_name']);
            $email=ucfirst($arr_single_transaction['user_records']['email']);
            $business_name=ucfirst($arr_single_transaction['business']['business_name']);
            $plan=ucfirst($arr_single_transaction['membership']['title']);
            $category=ucfirst($arr_single_transaction['category']['title']);
            $expiry_date=date('d-M-Y',strtotime($arr_single_transaction['expire_date']));
            //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();

            $obj_email_template = EmailTemplateModel::where('id','13')->first();
            if($obj_email_template)
            {
                $arr_email_template = $obj_email_template->toArray();

                $content        = $arr_email_template['template_html'];
                $content         = str_replace("##USER_FNAME##",$first_name,$content);
                $content        = str_replace("##BUSINESS_NAME##",$business_name,$content);
                $content        = str_replace("##CATEGORY##",$category,$content);
                $content        = str_replace("##TRANS_ID##","Payment Done BY Admin",$content);
                $content        = str_replace("##TRANS_STATUS##","Active",$content);

                $content        = str_replace("##MODE##","Payment Hand Over To Admin",$content);
                $content        = str_replace("##EXPIRY##",$expiry_date,$content);
                $content        = str_replace("##PLAN##",$plan,$content);
                $content        = str_replace("##APP_LINK##","RightNext",$content);
                 //print_r($content);exit;
                $content = view('email.front_general',compact('content'))->render();
                $content = html_entity_decode($content);

                $send_mail = Mail::send(array(),array(), function($message) use($email,$first_name,$arr_email_template,$content)
                            {
                                $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                $message->to($email, $first_name)
                                        ->subject($arr_email_template['template_subject'])
                                        ->setBody($content, 'text/html');
                            });

                //return $send_mail;
            if($send_mail)
            {
              Session::flash('success','Success ! Membership Assign Successfully! ');
            }
            else
            {
              Session::flash('error','Membership Assign Successfully But Mail Not Delivered Yet !');
            }
         }
       }
        /*if($transaction)
        {
            Session::flash('success','Membership Assign Successfully');
        }
        else
        {
            Session::flash('error','Error Occurred While Updating Business List ');
        }*/
        return redirect(url('/web_admin/business_listing'));
    }

    public function export_excel($format="csv")//export excel file
    {
        if($format=="csv")
        {
            $arr_business_list = array();
            $obj_business_list = BusinessListingModel::with(['user_details','category_details.category_business','get_sub_category.category_list.parent_category'])->get();
            //dd($obj_business_list);

            if($obj_business_list)
            {
                $arr_business_list = $obj_business_list->toArray();

                \Excel::create('BUSINESS_LIST-'.date('Ymd').uniqid(), function($excel) use($arr_business_list)
                {
                    $excel->sheet('Business_list', function($sheet) use($arr_business_list)
                    {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, array(
                            'Sr.No.','Business Name','Business Category :: Sub-Category', 'Full Name', 'Email', 'mobile No.'
                        ));

                        if(sizeof($arr_business_list)>0)
                        {
                            $arr_tmp = array();
                            foreach ($arr_business_list as $key => $business_list)
                            {
                                $arr_tmp[$key][] = $key+1;
                                $arr_tmp[$key][] = $business_list['business_name'];

                                $cat_subcat_title = '';
                                foreach($business_list['get_sub_category'] as $cat_subcat)
                                {
                                    $cat_subcat_title.=  $cat_subcat['category_list']['parent_category']['title'].' :: '.$cat_subcat['category_list']['title'];
                                    $cat_subcat_title.= ', ';
                                }
                                $arr_tmp[$key][] = $cat_subcat_title;

                                $arr_tmp[$key][] = $business_list['user_details']['first_name'].' '.$business_list['user_details']['last_name'];
                                $arr_tmp[$key][] = $business_list['user_details']['email'];
                                $arr_tmp[$key][] = $business_list['user_details']['mobile_no'];
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }

      /* Business Listing End */

   }
