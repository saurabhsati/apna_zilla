<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserModel;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\CountryModel;

use Session;
use Sentinel;
use Validator;
use DB;

class UserController extends Controller
{
 	public function __construct()
 	{
        $this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');      

        $arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);

 	}

        
 	public function store(Request $request)
    {    
        $arr_rules = array();
        $arr_rules['first_name']   =   "required";
        $arr_rules['last_name']    =   "required";
        $arr_rules['email']        =   "required|email";
        $arr_rules['password']     =   "required|min:6|confirmed";
        
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())                                                                 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $first_name     =  $request->input('first_name');
        $last_name      =  $request->input('last_name');
        $email          =  $request->input('email');
        $password       =  $request->input('password');

        /* Duplication Check*/
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
        	Session::flash('error','User Already Exists with this email id');
            return redirect()->back();
        }

         $status = Sentinel::registerAndActivate([
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'password'   => $password,
            
           ]);

        if($status)
        {
			/* Assign Normal Users Role */

            $role = Sentinel::findRoleBySlug('normal');

            $user = Sentinel::findById($status->id);
            
            //$user = Sentinel::getUser();

            $user->roles()->attach($role);
            
            Session::flash('success','User Created Successfully');
        }

        else
        {
            Session::flash('error','Problem Occured While Creating User ');
        }

        return redirect()->back();
    }

     public function profile()
    {
        $id = session('user_id');
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
             Session::put('user_middle_name', $users['middle_name']);
             Session::put('user_last_name', $users['last_name']);
        }

         $profile_pic_public_path = $this->profile_pic_public_path;

        return view('front.user.profile',compact('arr_user_info','profile_pic_public_path'));
    }


    public function store_personal_details(Request $request)
    {

        $arr_rules = array();
        $arr_rules['first_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['email'] = "required";
        $arr_rules['mobile_no'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())                                                                 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title             =    $request->input('title');
        $first_name        =    $request->input('first_name');
        $middle_name       =    $request->input('middle_name');
        $last_name         =    $request->input('last_name');
        $dd                =    $request->input('dd');
        $mm                =    $request->input('mm');
        $yy                =    $request->input('yy');

        $marital_status           =   $request->input('marital_status');
        $city                     =   $request->input('city');
        $area                     =   $request->input('area');
        $pincode                  =   $request->input('pincode');
        $occupation               =   $request->input('occupation');
        $email                    =   $request->input('email');
        $mobile_no                =   $request->input('mobile_no');
        $home_landline            =   $request->input('home_landline');
        $std_home_landline        =   $request->input('std_home_landline');
        $office_landline          =   $request->input('office_landline');
        $std_office_landline      =   $request->input('std_office_landline');
        $extn_office_landline     =   $request->input('extn_office_landline');

        $obj_user_info = UserModel::where('email','=',$email)->get();

        if($obj_user_info!=FALSE)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

        $user_id = $arr_user_info[0]['id'];
                
        $user = Sentinel::findById($user_id);

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

        $credentials = [
            'profile_pic'       =>    $profile_pic,
            'title'             =>    $title,
            'first_name'        =>    $first_name,
            'middle_name'       =>    $middle_name,
            'last_name'         =>    $last_name,
            'dd'                =>    $dd,
            'mm'                =>    $mm,
            'yy'                =>    $yy,
            'marital_status'    =>    $marital_status,
            'city'              =>    $city,
            'area'              =>    $area,
            'pincode'           =>    $pincode,
            'occupation'        =>    $occupation,
            'email'             =>    $email,
            'mobile_no'         =>    $mobile_no,
            'home_landline'     =>    $home_landline,
            'std_home_landline' =>    $std_home_landline,
            'office_landline'       => $office_landline,
            'std_office_landline'   => $std_office_landline,
            'extn_office_landline'  => $extn_office_landline
        ];


        $status = Sentinel::update($user, $credentials);

        if($status)
        {
           Session::flash('success','Updated Successfully');
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

        $id = session('user_id');
        $user_id = base64_decode($id);
        $obj_user_info = UserModel::where('id','=',$user_id)->get();
        if($obj_user_info)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

        return view('front.user.address',compact('page_title','arr_user_info'));
    }

    public function store_address_details(Request $request)
    {
        
        $arr_rules = array();
        $arr_rules['city']               = "required";
        $arr_rules['area']               = "required";
        $arr_rules['pincode']            = "required";
        $arr_rules['street_address']     = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())                                                                 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = session('user_id');
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

        return redirect()->back();
    }
    
    public function my_business()
    {
        $id = session('user_id');
        $user_id = base64_decode($id);

        $obj_business_info = BusinessListingModel::where('user_id','=',$user_id)->get();

        if($obj_business_info)
        {
            $arr_business_info = $obj_business_info->toArray();
        }

        foreach ($arr_business_info as $business) 
        {
            $cat_id = $business['business_cat'];
        }
     
       $obj_cat_details = CategoryModel::where('cat_id','=',$cat_id)->get();

       if($obj_cat_details)
       {
          $arr_cat_details = $obj_cat_details->toArray();
       }

       foreach ($arr_cat_details as $category) 
       {
           $cat_title = $category['title'];
       }
        
        return view('front.user.my_business',compact('arr_business_info','cat_title'));
    }

     public function edit_business($enc_id)
    {
      $buss_id = $enc_id;

      $business_id = base64_decode($enc_id);
      $page_title = "Edit Business";

      $obj_business_details = BusinessListingModel::where('id','=',$business_id)->get();

      if($obj_business_details)
      {
        $arr_business_details = $obj_business_details->toArray();
      }

      foreach ($arr_business_details as $business) 
      {
          $cat_id = $business['business_cat'];
          $city_id = $business['city'];
          $pincode = $business['pincode'];
          $state_id = $business['state'];
          $country_id = $business['country'];
      }
     

     $obj_cat_details = CategoryModel::where('cat_id','=',$cat_id)->get();
     if($obj_cat_details)
     {
        $arr_cat_details = $obj_cat_details->toArray();
     }

     foreach ($arr_cat_details as $category) 
     {
         $cat_title = $category['title'];
     }

     $obj_cat_full_details = CategoryModel::get();

     $arr_cat_full_details = $obj_cat_full_details->toArray();

    
     $obj_city_details = CityModel::where('id','=',$city_id)->get();
     if($obj_city_details)
     {
        $arr_city_details = $obj_city_details->toArray();
     }

     foreach ($arr_city_details as $city) 
     {
        $city_name = $city['city_title'];         
     }


     $obj_state_details = StateModel::where('id','=',$state_id)->get();
     if($obj_state_details)
     {
        $arr_state_details = $obj_state_details->toArray();
     }

     foreach ($arr_state_details as $state) 
     {
        $state_name = $state['state_title'];         
     }


     $obj_country_details = CountryModel::where('id','=',$country_id)->get();
     if($obj_country_details)
     {
        $arr_country_details = $obj_country_details->toArray();
     }

     foreach ($arr_country_details as $country)                                                                                                                                                                                                                                        
     {                                                                                                                                                                                     
        $country_name = $country['country_name'];                                                                                                                                                              
     }                                                                                                                                                                                                                                            

     
      return view('front.user.edit_business',compact('page_title','arr_business_details','arr_cat_details','arr_cat_full_details','cat_title','city_name','state_name','country_name','buss_id'));
    }                                                                                                                             

    public function update_business_details(Request $request,$enc_id)
    {
        $business_id = base64_decode($enc_id);

        $arr_data = array();
        $arr_data['business_name'] =  $request->input('business_name');
        $arr_data['building']      =  $request->input('building');
        $arr_data['landmark']      =  $request->input('landmark');
        $arr_data['area']          =  $request->input('area');
        $arr_data['business_cat']      =  $request->input('category');
                                                                              
        /* $arr_data['city'] = $request->input('city');
            $arr_data['pincode'] = $request->input('pincode');
            $arr_data['state'] = $request->input('state');
            $arr_data['country'] = $request->input('country');
        */
        $business_update = BusinessListingModel::where('id','=',$business_id)->update($arr_data);

        if($business_update)
        {
            return redirect()->back();
        }

    }
}
