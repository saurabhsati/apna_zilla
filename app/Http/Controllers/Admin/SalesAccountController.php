<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use Sentinel;
use Session;
use Validator;

class SalesAccountController extends Controller
{
 	public function __construct()
    {
        $arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);

        $this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');      
    }   

 	public function index()
 	{
 		$page_title = "Sales User Dashboard";

 		return view('web_admin.sales_user_account.dashboard',compact('page_title'));
 	}

 	public function business_listing()
 	{
 	$page_title	='Manage Business Listing';
   
    return view('web_admin.sales_user_account.index',compact('page_title'));                                           
 	}

 	public function profile()
 	{
 		$page_title = "Sales User Profile";

 		return view('web_admin.sales_user_account.profile',compact('page_title'));
 	}

 	public function create_business()
 	{
 		$page_title = 'Create Business';

 		$obj_category = CategoryModel::where('parent','!=',[0])->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

 		return view('web_admin.sales_user_account.create_business',compact('page_title'));
 	}

 	public function store_business(Request $request)
    {
    	$arr_rules	=	array();
        //business fields
    	$arr_rules['user_id']='required';
        $arr_rules['business_name']='required';
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
        //other fields
    	$arr_rules['hours_of_operation']='required';
    	$arr_rules['company_info']='required';
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


        $arr_data['business_cat']=$form_data['business_cat'];
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
        }
        $arr_data['main_image'] = $filename;

        //location input array
        $arr_data['building']=$form_data['building'];
        $arr_data['street']=$form_data['street'];
        $arr_data['landmark']=$form_data['landmark'];
        $arr_data['area']=$form_data['area'];
        $arr_data['city']=$form_data['city'];
        $arr_data['pincode']=$form_data['pincode'];
        $arr_data['state']=$form_data['state'];
        $arr_data['country']=$form_data['country'];

        //Contact input array
        $arr_data['contact_person_name']=$form_data['contact_person_name'];
        $arr_data['mobile_number']=$form_data['mobile_number'];
        $arr_data['landline_number']=$form_data['landline_number'];
        $arr_data['fax_no']=$form_data['fax_no'];
        $arr_data['toll_free_number']=$form_data['toll_free_number'];
        $arr_data['email_id']=$form_data['email_id'];
        $arr_data['website']=$form_data['website'];


        //other input array
        $arr_data['hours_of_operation']=$form_data['hours_of_operation'];
    	$arr_data['company_info']=$form_data['company_info'];
    	$arr_data['keywords']=$form_data['keywords'];
    	$arr_data['youtube_link']=$form_data['youtube_link'];

         $insert_data=$this->BusinessListingModel->create($arr_data);
         $business_id=$insert_data->id;
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
        	Session::flash('success','Business Created successfully');

        }
        else
        {
        	Session::flash('error','Error Occurred While Creating Business List ');
        }
        return redirect()->back();

    }
 	
 }