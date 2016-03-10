<?php
namespace App\Http\Controllers\SalesUser;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use App\Models\BusinessImageUploadModel;
use App\Models\RestaurantReviewModel;

use App\Models\CountryModel;
use App\Models\ZipModel;
use App\Models\CityModel;
use App\Models\StateModel;
use Sentinel;
use Session;
use Validator;


class SalesAccountController extends Controller
{
 	public function __construct()
    {   
       $arr_except_auth_methods = array();
       $arr_except_auth_methods[] = 'login';
       $arr_except_auth_methods[] = 'process_login';
       
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
        $this->UserModel = new UserModel();
        $this->BusinessListingModel = new BusinessListingModel();
        $this->RestaurantReviewModel= new RestaurantReviewModel();
        $this->BusinessImageUploadModel=new BusinessImageUploadModel();
        $this->business_public_img_path = url('/')."/uploads/business/main_image/";
        $this->business_base_img_path = base_path()."/public/uploads/business/main_image";

        $this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
        $this->business_base_upload_img_path = base_path()."/public/uploads/business/business_upload_image/";

        $this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');      
    }   

 	public function index()
 	{
 		$page_title = "Sales User Dashboard";

 		return view('sales_user.account.dashboard',compact('page_title'));
 	}

    public function login()
    {   
         return view('sales_user.account.login');
    }

    public function process_login(Request $request)
    {
        $arr_creds =  array();
        $arr_creds['email'] = $request->input('email');
        $arr_creds['password'] = $request->input('password');

        $record = UserModel::where('email','=',$arr_creds['email'])
                              ->get()->toArray();

        $public_id = $record[0]['public_id'];        
        

        $user = Sentinel::authenticate($arr_creds);


        if($user)
        {
            /* Check if Users Role is Sales */
            $role = Sentinel::findRoleBySlug('sales');
            if(Sentinel::inRole($role))
            {
                Session::put('public_id', $public_id);
                return redirect('sales_user/dashboard');
            }
            else
            {
                Session::flash('error','Not Sufficient Privileges');
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error','Invalid Credentials');
            return redirect()->back();
        }
    }

 	public function business_listing()
 	{
        $page_title = "Business Listing";

        $public_id = session('public_id');

        $obj_business_info = BusinessListingModel::where('seller_public_id','=',$public_id)->get();

        if( $obj_business_info != FALSE)
        {
            $arr_business_info = $obj_business_info->toArray();
        }

       $user_id = $arr_business_info[0]['user_id'];
        
       $obj_user_info = UserModel::where('id','=',$user_id)->get();

        if($obj_user_info != FALSE)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

        return view('sales_user.business.index',compact('page_title','arr_business_info','arr_user_info'));                                     
 	}


 	public function profile()
 	{
 		$page_title = "Sales User Profile";

 		return view('sales_user.account.profile',compact('page_title'));
 	}

 	
    public function create_user(Request $request,$enc_id=FALSE)
    {
        $page_title = "Create User ";

        return view('sales_user.user.create_user',compact('page_title','enc_id'));
    }

    public function store_user(Request $request)
    {
        $arr_rules = array();
        $arr_rules['first_name'] = "required";
        $arr_rules['middle_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['gender'] = "required";
        $arr_rules['d_o_b'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['password'] = "required|min:6";
        // $arr_rules['role'] ="required";
        $arr_rules['marital_status'] = "required";
        $arr_rules['city'] = "required";
        $arr_rules['area'] = "required";
        $arr_rules['occupation'] = "required";
        $arr_rules['work_experience'] = "required";

        $arr_rules['street_address'] = "required";
        $arr_rules['mobile_no'] = "required";
        $arr_rules['home_landline'] = "required";
        $arr_rules['office_landline'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())                                                                 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

                                                                
        $first_name       = $request->input('first_name');
        $middle_name       = $request->input('middle_name');
        $last_name       = $request->input('last_name');
        $gender       = $request->input('gender');
        $d_o_b       = $request->input('d_o_b');
        $email          = $request->input('email');
        $password   = $request->input('password');
        $marital_status       = $request->input('marital_status');
        // $role       = $request->input('role');
        $city       = $request->input('city');
        $area       = $request->input('area');
        $occupation       = $request->input('occupation');
        $work_experience       = $request->input('work_experience');
        $street_address     = $request->input('street_address');
        $mobile_no     = $request->input('mobile_no');
        $home_landline     = $request->input('home_landline');
        $office_landline     = $request->input('office_landline');
        /* Duplication Check*/
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
            Session::flash('error','User Already Exists with this email id');
            return redirect()->back();
        }


        $profile_pic = "default.jpg";

        if ($request->hasFile('profile_pic'))
        {
            $profile_pic_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array(
                                                'profile_pic' => 'mimes:jpg,jpeg,png'
                                            ));

            if ($request->file('profile_pic')->isValid() && $profile_pic_valiator->passes())
            {

                $cv_path = $request->file('profile_pic')->getClientOriginalName();
                $image_extension = $request->file('profile_pic')->getClientOriginalExtension();
                $image_name = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                $request->file('profile_pic')->move(
                    $this->profile_pic_base_path, $image_name
                );

                $profile_pic = $image_name;
            }
            else
            {
                return redirect()->back();
            }

        }


         $status = Sentinel::registerAndActivate([
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'gender' => $gender,
            'd_o_b' => date('Y-m-d',strtotime($d_o_b)),
            'email' => $email,
            'password' => $password,
            'marital_status' => $marital_status,
            'role' => "normal",
            'street_address' => $street_address,
            'city' =>$city,
            'area' => $area,
            'occupation' => $occupation,
            'work_experience' => $work_experience,
            'mobile_no' => $mobile_no,
            'home_landline' => $home_landline,
            'office_landline' => $office_landline,
            'is_active' => '1',
            'profile_pic'=>$profile_pic
        ]);

        if($status)
        {
            $enc_id = base64_encode($status->id);

            /* Assign Normal Users Role */
            $user = Sentinel::findById($status->id);
            Session::flash('success','User Created Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Creating User ');
        }

        return Redirect::to('sales_user/business/create_business/'.$enc_id);    
    }

    public function create_business(Request $request,$enc_id=FALSE)
    {
        $page_title = 'Create Business';

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

        return view('sales_user.business.create_business',compact('page_title','arr_category','arr_country','arr_zipcode','arr_city','arr_state','enc_id'));
    }


 	public function store_business(Request $request)
    {
        //dd($request->all());
       
    	$arr_rules	=	array();
        //business fields
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
            return redirect('/sales_user/business/create_business')->withErrors($validator)->withInput();
        }
        $form_data=$request->all();
        // Decoding user id
        // $user_id=BusinessListingModel::first()->user_id;
        // $public_seller_id = (new GeneratorController)->alphaID($user_id);

        $arr_data['is_active']='2';
        $arr_data['business_added_by']=$form_data['business_added_by'];
        $arr_data['business_name']=$form_data['business_name'];
        
        $business_cat=$form_data['business_cat'];
        if(sizeof($business_cat)>0){
        $business_categories=implode(',',$business_cat);
        $arr_data['business_cat']=$business_categories;

        }
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
        // $arr_data['public_seller_id'] = $public_seller_id;
        $arr_data['main_image'] = $filename;
        $enc_id = $form_data['user_id'];
        $public_id = session('public_id');

        $arr_data['seller_public_id'] = $public_id;
        $arr_data['user_id'] =base64_decode($enc_id);

    
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

         $insert_data=BusinessListingModel::create($arr_data);
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

   public function logout()
    {
        Sentinel::logout();
        return redirect('/sales_user');
    }

 	
 }