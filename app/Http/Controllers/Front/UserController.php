<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

use App\Common\Services\GeneratePublicId;

use App\Models\UserModel;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\CountryModel;
use App\Models\ZipModel;
use App\Models\BusinessPaymentModeModel;
use App\Models\BusinessServiceModel;
use App\Models\BusinessTimeModel;
use App\Models\BusinessImageUploadModel;
use App\Models\BusinessCategoryModel;
use App\Models\FavouriteBusinessesModel;
use App\Models\UsersOrderModel;
use App\Models\DealsTransactionModel;

use App\Models\PlaceModel;
use Session;
use Sentinel;
use Validator;
use DB;
use URL;

class UserController extends Controller
{
 	public function __construct()
 	{
        $this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');

        $this->business_base_img_path = base_path().'/public'.config('app.project.img_path.business_base_img_path');
        $this->business_public_img_path = url('/').config('app.project.img_path.business_base_img_path');


        $this->BusinessImageUploadModel=new BusinessImageUploadModel();

        $arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);

         $this->objpublic = new GeneratePublicId();

        /*$this->business_public_upload_img_path = url('/')."/uploads/business/business_upload_image/";
        $this->business_base_upload_img_path = base_path()."/public/uploads/business/business_upload_image/";*/

 	}


 	public function store(Request $request)
    {
        $arr_rules = array();
        $arr_rules['first_name']   =   "required";
        $arr_rules['last_name']    =   "required";
        $arr_rules['mobile']       =   "required";
        //$arr_rules['email']        =   "required|email";
        $arr_rules['password']     =   "required|min:6|confirmed";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
          $json['status'] = "VALIDATION_ERROR";
          //return response()->json($json);
          //return redirect()->back()->withErrors($validator)->withInput();
        }

        $first_name     =  $request->input('first_name');
        $last_name      =  $request->input('last_name');
        $email          =  $request->input('email');
        $mobile_no      =  $request->input('mobile');
        $password       =  $request->input('password');


        if(is_numeric($mobile_no) && strlen($mobile_no)==10)
        {
            $mobile = $mobile_no;
            /* Duplication Check*/

            $user = Sentinel::createModel();
            if($email!='')
            {
                if($user->where('email',$email)->get()->count()>0)
                {
                	$json['status'] = "EMAIL_EXIST_ERROR";
                    $json['msg']    = "Email Id Already Exists";
                    return response()->json($json);
                }
            }
            if($user->where('mobile_no',$mobile)->get()->count()>0)
            {
                $json['status'] = "MOBILE_EXIST_ERROR";
                $json['msg']    = "Mobile No.Already Exists";
                return response()->json($json);
            }

            $mobile_otp =  mt_rand(0,66666);
            // dd($mobile_otp);
             $status = Sentinel::registerAndActivate([
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'mobile_no'  => $mobile_no,
                'password'   => $password,
                'mobile_OTP' => $mobile_otp,
                'is_active'  => '0'
               ]);

            if($status)
            {
                /*-------------send SMS OTP-----------------*/

    			$response  = $this->send_otp($mobile,$mobile_otp);
                //dd($response);
                if($response!='')
                {
                     /*------------------------------------------*/

                    /* Assign Normal Users Role */

                        $role = Sentinel::findRoleBySlug('normal');

                        $user = Sentinel::findById($status->id);

                         $enc_id=$status->id;
                        //$public_id=uniqid( 'RTN_' ,false);
                        $public_id = $this->objpublic->generate_public_id($enc_id);

                        $insert_public_id = UserModel::where('id', '=', $enc_id)->update(array('public_id' => $public_id));

                        //$user = Sentinel::getUser();

                        $user->roles()->attach($role);


                        $json['status']     = "SUCCESS";
                        $json['mobile_no']  = $mobile;
                    }
                    else
                    {
                        $json['status'] = "ERROR";
                        $json['msg']    = "Error while Registration";
                    }
                     return response()->json($json);

                }
                else
                {
                   $json['status'] = "OTP_ERROR";
                   $json['msg']    = "Mobile OTP Error.";

                }
                return response()->json($json);
        }
        else
        {
            $json['status'] = "MOBILE_ERROR";
            $json['msg']    = "Invalid Mobile No.";
        }

        return response()->json($json);
    }

    public function send_otp($mobile,$mobile_otp)
    {

        $url = "http://smsway.co.in/api/sendhttp.php?authkey=70Asotxsg0Q556948f8&mobiles='".$mobile."'&message=RightNext Registration OPT = '".$mobile_otp."'&sender=SMSWAY&route=4&country=91";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($ch);
        curl_close($ch);
       // $response='1';
        return $response;
    }

    public function otp_check(Request $request)
    {
        $otp            =  $request->input('otp');
        $mobile_no      =  $request->input('mobile_no');

        if(is_numeric($mobile_no) && strlen($mobile_no)==10)
        {
            $mobile = $mobile_no;

            $user = UserModel::where('mobile_no',$mobile)->where('mobile_OTP',$otp)->first()->toArray();

            if($user)
            {

                $active_account = UserModel::where('mobile_OTP',$otp)->update(['is_active'=>'1']);

                if($active_account)
                {

                   /* Session::set('user_id',$user['id']);
                    Session::set('user_name', $user['first_name']);
                    Session::set('user_mail', $user['email']);*/

                    $json['status'] = "SUCCESS";
                    Session::flash('success','You Are Registered Successfully.');
                }
                else
                {
                    $json['status'] = "ERROR";
                }
            }

        }
        else
        {
             $json['status'] = "MOBILE_ERROR";
        }

        return response()->json($json);
    }

    public function profile()
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
         if((Session::has('previous_url')))
        {
          
            if(Session::get('previous_url') !==url('/').'/')
            {
              return redirect(Session::get('previous_url'));
            
            }
            else
            {
        
                $id = Session::get('user_id');

                $user_id = base64_decode($id);

                $obj_user_info = UserModel::where('id','=',$user_id)->get();

                if($obj_user_info)
                {
                    $arr_user_info = $obj_user_info->toArray();
                }

                foreach ($arr_user_info as $users)
                {
                     Session::put('user_mail', $users['email']);
                     Session::put('user_first_name', $users['first_name']);
                     //Session::put('user_middle_name', $users['middle_name']);
                     //Session::put('user_last_name', $users['last_name']);
                }

                 $profile_pic_public_path = $this->profile_pic_public_path;

                return view('front.user.profile',compact('arr_user_info','profile_pic_public_path'));
            }
        }
        else
        {
           return redirect('/');
        }
    }


    public function store_personal_details(Request $request)
    {

        $arr_rules = array();
        $arr_rules['first_name'] = "required";
        //$arr_rules['last_name'] = "required";
       // $arr_rules['email'] = "required";
        $arr_rules['mobile_no'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $id = $request->input('user_id');

        $dd                       =   $request->input('dd');
        $mm                       =   $request->input('mm');
        $yy                       =   $request->input('yy');
        $dob                      =   $yy.'-'.$mm.'-'.$dd;

        $married_date_dd                       =   $request->input('married_date_dd');
        $married_date_mm                       =   $request->input('married_date_mm');
        $married_date_yy                       =   $request->input('married_date_yy');
        $married_date                      =   $married_date_yy.'-'.$married_date_mm.'-'.$married_date_dd;

        $title                    =   $request->input('title');
        $first_name               =   $request->input('first_name');
       /* $middle_name              =   $request->input('middle_name');
        $last_name                =   $request->input('last_name');*/
        $marital_status           =   $request->input('marital_status');

        $city                     =   $request->input('city');
        $area                     =   $request->input('area');
        $pincode                  =   $request->input('pincode');
       /* $occupation               =   $request->input('occupation');*/
        $email                    =   $request->input('email');
        $mobile_no                =   $request->input('mobile_no');
       /* $home_landline            =   $request->input('home_landline');
        $std_home_landline        =   $request->input('std_home_landline');
        $office_landline          =   $request->input('office_landline');
        $std_office_landline      =   $request->input('std_office_landline');
        $extn_office_landline     =   $request->input('extn_office_landline');*/

        $gender                    =   $request->input('gender');
        $work_experience                    =   $request->input('work_experience');

        $obj_user_info = UserModel::where('id',$id)->get();

        if($obj_user_info!=FALSE)
        {
            $arr_user_info = $obj_user_info->toArray();
        }
       /* echo "<pre>";
        print_r($arr_user_info);
       */

        $user_id = $arr_user_info[0]['id'];

        $user = Sentinel::findById($user_id);

        $profile_pic = "default.jpg";

        if ($request->hasFile('profile_pic'))
        {
            $profile_pic_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array( 'profile_pic' => 'mimes:jpg,jpeg,png' ));

            if ($request->file('profile_pic')->isValid() && $profile_pic_valiator->passes())
            {
                $cv_path            = $request->file('profile_pic')->getClientOriginalName();
                $image_extension    = $request->file('profile_pic')->getClientOriginalExtension();
                $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;

                if(isset($arr_user_info[0]['profile_pic']))
                {
                  @unlink($this->profile_pic_base_path.'/'.$arr_user_info[0]['profile_pic']);
                }

                $request->file('profile_pic')->move( $this->profile_pic_base_path, $image_name);
                $profile_pic = $image_name;
            }
            else
            {
                return redirect()->back();
            }

        }
        else
        {
           if(isset($arr_user_info[0]['profile_pic']))
            {
               $profile_pic = $arr_user_info[0]['profile_pic'];
            }
            else
            {
               $profile_pic = "default.jpg";
            }

        }

        // echo $title;
        // echo "<br>";
        // //echo date("Y-m-d", strtotime($dob));
        // exit;
        $credentials = [
            'profile_pic'       =>    $profile_pic,
            //'title'             =>    $title,
            'first_name'        =>    $first_name,
           /* 'middle_name'       =>    $middle_name,
            'last_name'         =>    $last_name,*/
            'dd'                =>    $dd,
            'mm'                =>    $mm,
            'yy'                =>    $yy,
            'd_o_b'             =>    date("Y-m-d", strtotime($dob)),
            'married_date'      =>    date('Y-m-d',strtotime($married_date)),
            'marital_status'    =>    $marital_status,
            //'city'              =>    $city,
            'gender'            =>    $gender,
            'work_experience'   =>    $work_experience,
            /*'occupation'        =>    $occupation,*/
            'email'             =>    $email,
            'prefix_name'       =>    $title,
            'mobile_no'         =>    $mobile_no,
           /* 'home_landline'     =>    $home_landline,
            'std_home_landline' =>    $std_home_landline,
            'office_landline'       => $office_landline,
            'std_office_landline'   => $std_office_landline,
            'extn_office_landline'  => $extn_office_landline*/
        ];

        //dd($credentials);

        $status = UserModel::where('id',$id)->update($credentials);

        //$status = Sentinel::update($user, $credentials);

        if($status)
        {
           Session::flash('success','Profile Information Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Updating ');
        }

       return redirect()->back();
    }

    public function address()
    {
        $page_title = "Address";
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
         $arr_city = array();
        $obj_city_res = CityModel::get();
        if($obj_city_res != FALSE)
        {
            $arr_city = $obj_city_res->toArray();
        }
        $arr_state = array();
        $obj_state_res = StateModel::get();

        if( $obj_state_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
        $id = session('user_id');
        $user_id = base64_decode($id);
        $obj_user_info = UserModel::where('id','=',$user_id)->get();
        if($obj_user_info)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

        return view('front.user.address',compact('page_title','arr_user_info','arr_city','arr_state'));
    }

    public function store_address_details(Request $request)
    {

        $arr_rules = array();
        $arr_rules['city']               = "required";
        $arr_rules['state']               = "required";
        $arr_rules['area']               = "required";
        $arr_rules['pincode']            = "required";
        //$arr_rules['street_address']     = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id     =  $request->input('user_id');
        $arr_data['city']     = $request->input('city');
        $arr_data['state']     = $request->input('state');
        $arr_data['area']     = $request->input('area');
        $arr_data['pincode']     = $request->input('pincode');
        $arr_data['street_address']     = $request->input('street_address');

        $status = UserModel::where('id',$id)->update($arr_data);

        if($status)
        {
           Session::flash('success','Address Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Updating Address');
        }

/*        $id = session('user_id');
        $user_id = base64_decode($id);

        $user = Sentinel::findById($user_id);

        $city                = $request->input('city');
        $area                = $request->input('area');
        $pincode             = $request->input('pincode');
        $street_address      = $request->input('street_address');

        $credentials = [
            'city' => $city,
            'area' => $area,
            'pincode' => $pincode,
            'street_address' => $street_address
        ];
        $status = Sentinel::update($user, $credentials);
*/
        return redirect()->back();
    }

    public function my_business(Request $request,$page='1')
    {
        if(!Session::has('user_id'))
        {
            return redirect(url('/'));
        }
        $id = session('user_id');
         $user_id = base64_decode($id);

        $obj_business_info = BusinessListingModel::with(['category','membership_plan_details'])->where('user_id','=',$user_id)->with('reviews');

        $arr_business_info =  array();
        $cat_title =  "";
        if($obj_business_info)
        {
            //$arr_business_info = $obj_business_info->get()->toArray();

             $obj_main_category = CategoryModel::where('parent','0')->remember(1440)->get();
               if($obj_main_category)
                {
                    $arr_main_category = $obj_main_category->toArray();
                }
                $obj_sub_category = CategoryModel::where('parent','!=','0')->remember(1440)->get();
                if($obj_sub_category)
                {
                    $arr_sub_category = $obj_sub_category->toArray();
                }
        }
        
           $arr_business = [];
           $tmp_arr_business =$pagination_links= [];
           /* Pagination start*/
            if(count($obj_business_info)>0 && isset($obj_business_info))
            {
                $per_page =2;
                $data_arr=$obj_business_info->paginate($per_page);
                  

                if($data_arr)
                {
                    $tmp_arr_business   = $data_arr->toArray(); 
                    $pagination_links   = $data_arr->render();   
                    $arr_business       = $tmp_arr_business['data'];
                  
                }
           
            }

             $main_image_path="uploads/business/main_image";
            return view('front.user.my_business',compact('main_image_path','pagination_links','arr_main_category','arr_sub_category','arr_business'));
      
        
    }
    public function add_business()
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        //Getting all the details of the Category Table
       $obj_category = CategoryModel::where('parent','=',0)->select('cat_id','title')->orderBy('title','ASC')->get();

        if($obj_category)
        {
            $arr_category = $obj_category->toArray();
        }

   


        return view('front.user.add_business',compact('arr_category'));
    }


    public function get_state(Request $request)
    {
        $country_id   = $request->input('country_id');
        $json         =  array();
        $obj_result   = StateModel::where('country_id',$country_id)->get(['id','state_title']);
        if($obj_result)
        {
            $json = $obj_result->toArray();
        }

        return response()->json($json);
    }


    public function get_city(Request $request)
    {
        $state_id   = $request->input('state_id');
        $json         =  array();
        $obj_result   = CityModel::where('state_id',$state_id)->get(['id as city_id','city_title']);
        if($obj_result)
        {
            $json = $obj_result->toArray();
        }

        return response()->json($json);
    }

    public function get_zip(Request $request)
    {
        $city_id      = $request->input('city_id');
        $json         = array();
        $obj_result   = PlaceModel::where(array('city_id'=>$city_id))->distinct('postal_code')->get(['id as zip_id','postal_code']);
        if($obj_result)
        {
            $json = $obj_result->toArray();
        }

        return response()->json($json);
    }

    public function add_business_details(Request $request)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_rules = array();
        $arr_rules['business_name'] = "required";
        $arr_rules['business_cat']      = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $business_image  = "default_banner.jpg";

        if ($request->hasFile('business_image'))
        {
            $profile_pic_valiator = Validator::make(array('business_image'=>$request->file('business_image')),array( 'business_image' => 'mimes:jpg,jpeg,png' ));

            if ($request->file('business_image')->isValid() && $profile_pic_valiator->passes())
            {
                $cv_path            = $request->file('business_image')->getClientOriginalName();
                $image_extension    = $request->file('business_image')->getClientOriginalExtension();
                $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                $request->file('business_image')->move($this->business_base_img_path, $image_name);
                $business_image     = $image_name;
            }
            else
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }

        }

        
        $arr_data = array();
        $user_id = base64_decode(Session::get('user_id')) ;
        $arr_data['user_id']           =        $user_id;
        $arr_data['business_name']     =        $request->input('business_name');
        $business_cat                  =        $request->input('business_cat');

        //dd($business_cat);

        $arr_data['main_image']        =        $business_image;

        //dd($arr_data);

        $business_add = BusinessListingModel::create($arr_data);
        $business_id=$business_add->id;

         $business_cat_slug= $request->input('business_public_id');
         $public_id = $this->objpublic->generate_business_public_by_category($business_cat_slug,$business_id);
         BusinessListingModel::where('id', '=', $business_id)->update(array('busiess_ref_public_id' => $public_id));


          foreach ($business_cat as $key => $value)
        {
            $arr_cat_data['business_id']=$business_id;
            $arr_cat_data['category_id']=$value;
            $insert_data = BusinessCategoryModel::create($arr_cat_data);

        }
        if($insert_data)
        {
            Session::flash('success','Business Added Successfully');
            return redirect(url('/').'/front_users/add_location/'.base64_encode($business_id));
        }else {
            Session::flash('error','Error While Adding Business');
        }

        /*if($business_add)
        {
            $request->session()->put('category_id', $request->input('category'));
            return redirect(url('/')."front_users/contacts");
        }*/
        //Session::flash('success','Business Added Successfully');

        return redirect()->back();
    }


    public function add_location_details(Request $request)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_rules = array();
        //$arr_rules['building']      = "required";
        //$arr_rules['landmark']      = "required";
        $arr_rules['area']          = "required";
        $arr_rules['city']          = "required";
        $arr_rules['state']         = "required";
        $arr_rules['country']       = "required";
        $arr_rules['pincode']       = "required";
        $arr_rules['lat']       = "required";
        $arr_rules['lng']       = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = base64_decode(Session::get('user_id')) ;
       

        $arr_data = array();
        $business_id                   =        $request->input('business_id');
        //$arr_data['building']          =        $request->input('building');
        //$arr_data['landmark']          =        $request->input('landmark');
        $arr_data['area']              =        $request->input('area');
        //$arr_data['street']            =        $request->input('street');
        $arr_data['city']              =        $request->input('city');
        $arr_data['state']             =        $request->input('state');
        $arr_data['country']           =        $request->input('country');
        $arr_data['pincode']           =        $request->input('pincode');
        $arr_data['lat']               =        $request->input('lat');
        $arr_data['lng']               =        $request->input('lng');


        $location_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);
        if($location_add)
        {
            Session::flash('success','Location Information Added Successfully');
            return redirect(url('/').'/front_users/add_contacts/'.base64_encode($business_id));
        }else {
            Session::flash('error','Error While Adding Location Information');
        }

        return redirect()->back();
    }


    public function add_contacts_details(Request $request)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_rules = array();
        $arr_rules['prefix_name']      = "required";
        $arr_rules['contact_name']     = "required";
        $arr_rules['mobile_no']        = "required";
      /*  $arr_rules['landline_no']      = "required";
        $arr_rules['fax_no']           = "required";
        $arr_rules['toll_free_no']     = "required";
        $arr_rules['email']            = "required";
        $arr_rules['website']          = "required";
*/
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = base64_decode(Session::get('user_id')) ;
        
        $arr_data = array();
        $business_id                         =        $request->input('business_id');
        $arr_data['prefix_name']             =        $request->input('prefix_name');
        $arr_data['contact_person_name']     =        $request->input('contact_name');
        $arr_data['mobile_number']           =        $request->input('mobile_no');
        $arr_data['landline_number']         =        $request->input('landline_no');
        $arr_data['fax_no']                  =        $request->input('fax_no');
        $arr_data['toll_free_number']        =        $request->input('toll_free_no');
        $arr_data['email_id']                =        $request->input('email');
        $arr_data['website']                 =        $request->input('website');

        //$arr_data['user_id']               =        $user_id;
        //$arr_data['designation']           =        $request->input('designation');

        $location_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);
        if($location_add)
        {
            Session::flash('success','Contact Person\'s Information Added Successfully');
            return redirect(url('/').'/front_users/other_details/'.base64_encode($business_id ));
        }else {
            Session::flash('error','Error While Adding Contact Person\'s Information');
        }

        return redirect()->back();
    }

    public function add_other_details(Request $request)
    {
        //dd($request->all());
        $form_data=$request->all();
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_rules = array();
        $arr_rules['company_info']      = "required";
        $arr_rules['establish_year']    = "required";
        $arr_rules['keywords']          = "required";
        $arr_rules['payment_mode']          = "required";

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
        if($form_data['is_sunday']=='1')
        { 
            $arr_rules['sun_in']='required';
            $arr_rules['sun_out']='required';
        } 

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = base64_decode(Session::get('user_id')) ;

        $arr_data = array();
        $business_id                    =        $request->input('business_id');
        //$arr_data['user_id']          =        $user_id;
        $arr_data['company_info']       =        $request->input('company_info');
        $arr_data['establish_year']     =        $request->input('establish_year');
        $arr_data['keywords']           =        $request->input('keywords');

        // For adding Payment Modes.
        $arr_payment        =  array();
        $arr_payment        =  $request->input('payment_mode');
        if(count($arr_payment)>0)
        {
            foreach ($arr_payment as $key => $value)
            {
                BusinessPaymentModeModel::create(array('business_id'=>$business_id,'title'=>$value));
            }
        }



        $location_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=>$business_id))->update($arr_data);
        if($location_add)
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
            if($form_data['is_sunday']=='1')
            { 
                $arr_time['sun_open']    = $request->input('sun_in');
                $arr_time['sun_close']   = $request->input('sun_out');

            } 

            $business_time_add = BusinessTimeModel::create($arr_time);

            Session::flash('success','Other Information Added Successfully');
            return redirect(url('/').'/front_users/add_services/'.base64_encode( $business_id ));
        }else {
            Session::flash('error','Error While Adding Other Information');
        }

        return redirect()->back();
    }


    public function add_services_details(Request $request)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_rules = array();
        //$arr_rules['youtube_link']      = "required";
        $arr_rules['business_service']  = "required";

        $destinationPath = base_path()."/public/uploads/business/business_upload_image";

        $validator   = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = base64_decode(Session::get('user_id')) ;

        $arr_data = array();
        $business_services =  array();
        $business_id                    =        $request->input('business_id');
       // $arr_data['youtube_link']       =        $request->input('youtube_link');
        $business_services              =        $request->input('business_service');

        $files          = $request->file('business_image');
        $file_count     = count($files);

        //$arr_data['user_id']          =        $user_id;
        /* $arr_data['establish_year']  =        $request->input('establish_year');
        $arr_data['keywords']           =        $request->input('keywords');*/

        $services_add = BusinessListingModel::where(array('user_id'=>$user_id,'id'=> $business_id ))->update($arr_data);
        if($services_add)
        {
            if(count($business_services)>0)
            {
                foreach ($business_services as $key => $value)
                {
                    BusinessServiceModel::create(array('name'=>$value,'business_id'=>$business_id));
                }
            }

             if($file_count>0)
            {
                $uploadcount = 0;
                foreach($files as $file)
                {
                     if($file!=null)
                     {
                        //$destinationPath    = $this->business_base_img_path;
                        $fileName           = $file->getClientOriginalName();
                        $fileExtension      = strtolower($file->getClientOriginalExtension());
                        if(in_array($fileExtension,['png','jpg','jpeg']))
                        {
                            $filename = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                            $result   = $file->move($destinationPath,$filename);
                            if($result)
                            {
                              $arr_insert['image_name']=$filename;
                              $arr_insert['business_id']=$business_id;
                              $insert_data1 = $this->BusinessImageUploadModel->create($arr_insert);
                            }
                            $uploadcount ++;
                        }
                        else
                        {
                             Session::flash('error','Invalid file extension');
                             redirect()->back();
                        }
                    }
                }
            }

            Session::flash('success','Complete Business Information Added Successfully');
            return redirect('/front_users/add_business');


        }else {
            Session::flash('error','Error While Adding Services Information');
        }

        return redirect()->back();
    }



    public function show_business_contacts_details($enc_id)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
         $business_id =  base64_decode($enc_id);
         return view('front.user.add_contacts',compact('business_id'));
    }

    public function show_other_info_details($enc_id)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $business_id =  base64_decode($enc_id);
        return view('front.user.add_other_information',compact('business_id'));
    }

    public function show_location_details($enc_id)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }

        $obj_country_full_details = CountryModel::get();
        if($obj_country_full_details)
        {
         $arr_country = $obj_country_full_details->toArray();
        }

       $business_id =  base64_decode($enc_id);

       //dd($business_id);

        $obj_city_full_details = CityModel::get();

        if($obj_city_full_details){
            $arr_city = $obj_city_full_details->toArray();
        }
       /* $obj_zipcode_res = ZipModel::get();
        if( $obj_zipcode_res != FALSE)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }*/
        return view('front.user.add_location',compact('arr_city','business_id','arr_country'));
    }

    public function show_services_details($enc_id)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $business_id =  base64_decode($enc_id);
        return view('front.user.add_services',compact('business_id'));
    }

        /*Edit User Business*/

    public function edit_business_step1($enc_id)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
       $id = base64_decode($enc_id);
       $business_public_img_path = url('/')."/uploads/business/main_image/";
       $page_title ="Edit Business";
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
        $business_data=BusinessListingModel::with(['category'])->where('id',$id)->get()->toArray();
       //dd($business_data);
      return view('front.user.Edit_Business.edit_business_step1',compact('page_title','arr_parent_category','arr_category','business_data','enc_id','business_public_img_path'));
    }
    public function update_business_step1(Request $request,$enc_id)
    {
        if(Session::has('user_id'))
        {
            $business_base_img_upload_path = base_path()."/public/uploads/business/main_image";
            $id = base64_decode($enc_id);
            $arr_rules = array();
            $arr_rules['business_name'] = "required";
            $arr_rules['business_cat']      = "required";

            $validator = Validator::make($request->all(),$arr_rules);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $business_image=$request->input('business_image');
            if ($request->hasFile('business_image'))
            {
                $profile_pic_valiator = Validator::make(array('business_image'=>$request->file('business_image')),array( 'business_image' => 'mimes:jpg,jpeg,png' ));

                if ($request->file('business_image')->isValid() && $profile_pic_valiator->passes())
                {
                    $cv_path            = $request->file('business_image')->getClientOriginalName();
                    $image_extension    = $request->file('business_image')->getClientOriginalExtension();
                    $image_name         = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                    $request->file('business_image')->move($business_base_img_upload_path, $image_name);
                    $business_image     = $image_name;
                }
                else
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

            }
            $business_data['business_name']      = $request->input('business_name');
            $business_data['main_image']      = $business_image;
            //dd($business_data);
            $business_category = BusinessCategoryModel::where('business_id',$id);
            $res= $business_category->delete();
            $business_cat=$request->input('business_cat');
            if($business_cat)
            {
                foreach ($business_cat as $key => $value)
                {
                    $arr_cat_data['business_id']=$id;
                    $arr_cat_data['category_id']=$value;
                    $insert_data = BusinessCategoryModel::create($arr_cat_data);
                }
            }


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

            $business_data_res=BusinessListingModel::where('id',$id)->update($business_data);
            if($business_data_res)
            {
                Session::flash('success','Business Information Updated Successfully');

            }
            else
            {
                Session::flash('error','Error While Adding Business');
            }
            return redirect(url('/').'/front_users/edit_business_step2/'.base64_encode($id));
      }
      else
      {
        return redirect(url('/'));
      }


    }
    public function edit_business_step2($enc_id)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
       $id = base64_decode($enc_id);
       $page_title ="Edit Business";
       
        $obj_business_arr=BusinessListingModel::where('id',$id)->get();
        if( $obj_business_arr != FALSE)
        {
            $business_data = $obj_business_arr->toArray();
        }
        

      return view('front.user.Edit_Business.edit_business_step2',compact('page_title','business_data','enc_id'));
    }
    public function update_business_step2(Request $request,$enc_id)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $id = base64_decode($enc_id);
        $arr_rules = array();
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
         $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             //print_r( $validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //location input array
        //$business_data['building']=$request->input('building');
        //$business_data['street']=$request->input('street');
        //$business_data['landmark']=$request->input('landmark');
        $business_data['area']=$request->input('area');
        $business_data['city']=$request->input('city');
        $business_data['pincode']=$request->input('pincode');
        $business_data['state']=$request->input('state');
        $business_data['country']=$request->input('country');
        $business_data['lat']=$request->input('lat');
        $business_data['lng']=$request->input('lng');
        //dd($business_data);
         $business_data_res=BusinessListingModel::where('id',$id)->update($business_data);
        if($business_data_res)
        {
            Session::flash('success','Business Location Updated Successfully');

        }
        else
        {
            Session::flash('error','Error While Adding Business');
        }
        return redirect(url('/').'/front_users/edit_business_step3/'.base64_encode($id));
    }
    public function edit_business_step3($enc_id)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $id = base64_decode($enc_id);
        $page_title ="Edit Business";
        $business_data=BusinessListingModel::where('id',$id)->get()->toArray();
        return view('front.user.Edit_Business.edit_business_step3',compact('page_title','business_data','enc_id'));
    }
    public function update_business_step3(Request $request,$enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_rules = array();
           //contact info fields
        $arr_rules['contact_person_name']='required';
        $arr_rules['prefix_name']='required';
        $arr_rules['mobile_number']='required';
       /* $arr_rules['landline_number']='required';
        $arr_rules['fax_no']='required';
        $arr_rules['toll_free_number']='required';
        $arr_rules['email_id']='required';
        $arr_rules['website']='required';*/
        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             //print_r( $validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $business_data['contact_person_name']=$request->input('contact_person_name');
        $business_data['prefix_name']=$request->input('prefix_name');
        $business_data['mobile_number']=$request->input('mobile_number');
       /* $business_data['landline_number']=$request->input('landline_number');
        $business_data['fax_no']=$request->input('fax_no');
        $business_data['toll_free_number']=$request->input('toll_free_number');
        $business_data['email_id']=$request->input('email_id');
        $business_data['website']=$request->input('website');*/
        //dd($business_data);
         $business_data_res=BusinessListingModel::where('id',$id)->update($business_data);
        if($business_data_res)
        {
            Session::flash('success','Business Contact Information Updated Successfully');

        }
        else
        {
            Session::flash('error','Error While Adding Business');
        }
        return redirect(url('/').'/front_users/edit_business_step4/'.base64_encode($id));
    }
    public function edit_business_step4($enc_id)
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $id = base64_decode($enc_id);
        $page_title ="Edit Business";
        $business_data=BusinessListingModel::with(['payment_mode','business_times'])->where('id',$id)->get()->toArray();
        return view('front.user.Edit_Business.edit_business_step4',compact('page_title','business_data','enc_id'));
    }
    public function update_business_step4(Request $request,$enc_id)
    {
         $id = base64_decode($enc_id);
         $arr_rules = array();
         $arr_rules['company_info']='required';
         $arr_rules['establish_year']='required';
         $arr_rules['keywords']='required';
         $arr_all=$request->all();

        //business times
        $arr_rules['mon_in']='required';
        $arr_rules['mon_out']='required';
        $arr_rules['tue_in']='required';
        $arr_rules['tue_out']='required';
        $arr_rules['wed_in']='required';
        $arr_rules['wed_out']='required';
        $arr_rules['thu_in']='required';
        $arr_rules['thu_out']='required';
        $arr_rules['fri_in']='required';
        $arr_rules['fri_out']='required';
        $arr_rules['sat_in']='required';
        $arr_rules['sat_out']='required';
        if($arr_all['is_sunday']=='1')
        { 
            $arr_rules['sun_in']='required';
            $arr_rules['sun_out']='required';
        } 


         $validator=validator::make($request->all(),$arr_rules);

         if($validator->fails())
         {
             //print_r( $validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
         }

        
         $payment_mode=$arr_all['payment_mode'];
         $payment_count = count($payment_mode);
         //exit;
        if($payment_count>0)
        {
            foreach($payment_mode as $key =>$value) {
             if($value!=null)
             {

                    $arr_payment_mode_data['business_id']=$id;
                    $arr_payment_mode_data['title']=$value;
                    $insert_data = BusinessPaymentModeModel::create($arr_payment_mode_data);
            }

            }

        }
        $business_data['company_info']=$request->input('company_info');
        $business_data['establish_year']=$request->input('establish_year');
        $business_data['keywords']=$request->input('keywords');
        $business_data_res=BusinessListingModel::where('id',$id)->update($business_data);
        if($business_data_res)
        {

            $arr_time                = array();
            $arr_time['business_id'] = $id;
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
            if($arr_all['is_sunday']=='1')
            { 
                 $arr_time['sun_open']    = $request->input('sun_in');
                 $arr_time['sun_close']   = $request->input('sun_out');
            }
            else
            {
                $arr_time['sun_open']="";
                $arr_time['sun_close']="";
            } 

            $business_time_exist = BusinessTimeModel::where('business_id',$id)->first(['id','business_id']);

            if($business_time_exist)
            {
                $arr_exist = $business_time_exist->toArray();
                if(count($arr_exist) > 0)
                {
                    $business_time_update = BusinessTimeModel::where('business_id',$id)->update($arr_time);
                }
            }
            else {
                    $business_time_add = BusinessTimeModel::create($arr_time);
            }

            Session::flash('success','Business Other Information Updated Successfully');

        }
        else
        {
            Session::flash('error','Error While Adding Business');
        }
        return redirect(url('/').'/front_users/edit_business_step5/'.base64_encode($id));
    }
     public function edit_business_step5($enc_id)
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $id = base64_decode($enc_id);
        $page_title ="Edit Business";
        $business_public_img_path=url('/')."/uploads/business/business_upload_image/";
        $business_data=BusinessListingModel::with(['image_upload_details','service'])->where('id',$id)->get()->toArray();
        return view('front.user.Edit_Business.edit_business_step5',compact('page_title','business_data','enc_id','business_public_img_path'));
    }
    public function update_business_step5(Request $request,$enc_id)
    {
         $id = base64_decode($enc_id);
         $destinationPath = base_path()."/public/uploads/business/business_upload_image";
         $arr_rules = array();
         //$arr_rules['youtube_link']='required';
         $arr_rules['business_image']='required';
         $arr_rules['business_service']='required';
         $validator=validator::make($request->all(),$arr_rules);

         if($validator->fails())
         {
             //print_r( $validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
         }

         $arr_all=$request->all();
         $flag=1;
         $business_service=$arr_all['business_service'];
          if(sizeof($business_service))
          {
                foreach($business_service as $key =>$value) {
                 if($value!=null)
                 {

                        $arr_serv_data['business_id']=$id;
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
                      $arr_insert['business_id']=$id;
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
         //$business_data['youtube_link']=$request->input('youtube_link');
         //$business_data_res=BusinessListingModel::where('id',$id)->update($business_data);
        if($flag==1)
        {
            Session::flash('success','Business Media Information Updated Successfully');

        }
        else
        {
            Session::flash('error','Error While Adding Business');
        }
        return redirect(url('/').'/front_users/edit_business_step5/'.base64_encode($id));

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
    public function my_favourite_businesses(Request $request,$page='1')
    {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        if(Session::has('user_id'))
          {
          	$id = session('user_id');
            $user_id = base64_decode(Session::get('user_id'));
            $arr_fav    =$arr_paginate_business= array();
            $per_page = 2;

            $obj_fav = FavouriteBusinessesModel::with('business.reviews')->where('user_id',$user_id)->where('is_favourite','=','1')
                              ->paginate($per_page);
             if($obj_fav)
            {
                $tmp_arr_fav   = $obj_fav->toArray(); 
                $arr_paginate_business   = $obj_fav->render();   
                $arr_fav       = $tmp_arr_fav['data'];
            }
             $main_image_path="uploads/business/main_image";
             return view('front.user.my_favourite_businesses',compact('arr_fav','main_image_path','arr_paginate_business'));
          }
        
    }
    public function my_order(Request $request,$page='1')
    {
         if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        if(Session::has('user_id'))
        {
            $id = session('user_id');
            $user_id = base64_decode(Session::get('user_id'));
            $arr_order    =$arr_paginate_my_order= array();
            $per_page = 2;

            $obj_order = DealsTransactionModel::orderBy('created_at','DESC')->with('user_orders','order_deal.offers_info')->where('user_id',$user_id)
                              ->paginate($per_page);
             if($obj_order)
            {
                $tmp_arr_order   = $obj_order->toArray(); 
                $arr_paginate_my_order   = $obj_order->render();   
                $arr_order       = $tmp_arr_order['data'];
            }
                //  dd($arr_order);
            $deal_image_path="uploads/deal";
             return view('front.user.my_order',compact('arr_order','deal_image_path','arr_paginate_my_order'));

        }
    }

}
