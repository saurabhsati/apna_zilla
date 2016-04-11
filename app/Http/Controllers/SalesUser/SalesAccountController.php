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
use Hash;

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
        $this->RestaurantReviewModel = new RestaurantReviewModel();
        $this->BusinessImageUploadModel = new BusinessImageUploadModel();

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

        foreach($record as $sales_user)
        {
            $public_id = $sales_user['public_id'];
        }


        $user = Sentinel::authenticate($arr_creds);
        //dd($user);

        if($user)
        {
            if($user)
               {
                  $user_details = $user->toArray();
               }
               if(sizeof($user_details))
               {
                   if($user_details['is_active']==1)
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
                         Session::flash('error','Your account is block by Admin');
                         return redirect()->back();
                    }
                }
        }
        else
        {
            Session::flash('error','Invalid Credentials');
            return redirect()->back();
        }
    }


    public function edit_profile()
    {
        if ($user = Sentinel::getUser())
        {
            $page_title ="Edit Profile";

            $sales_user_arr=$user->toArray();
            return view('sales_user.account.profile',compact('page_title','sales_user_arr'));
        }
    }

     public function update_profile(Request $request)
    {
        $obj_sales_user = Sentinel::getUser();////Get Sales User's all information

        if($obj_sales_user)
        {
            $arr_sales_user = $obj_sales_user->toArray();
        }

        $arr_rules = array();
        $arr_rules['office_landline']   = 'required';
        $arr_rules['street_address']    = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

         $profile_pic = $arr_sales_user ['profile_pic']?$arr_sales_user ['profile_pic']: "default.jpg";

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
        $profile_pic    =$profile_pic;
        $office_landline      = $request->input('office_landline');
        $street_address = $request->input('street_address');
        $update_arr =array();
        $update_arr=array('profile_pic'=>$profile_pic,'office_landline'=>$office_landline,'street_address'=>$street_address);
        $update_profile = Sentinel::update($obj_sales_user,$update_arr);

        if($update_profile)
            {
                Session::flash('success','Profile Updated Successfully');
            }
            else
            {
                Session::flash('error','Error while updating profile');
            }

            return redirect()->back();
    }

    public function change_password()
    {
        $page_title = 'Change Password';
        return view('sales_user.account.change_password',compact('page_title'));
    }

    public function update_password(Request $request)
    {
        $obj_sales_user = Sentinel::getUser();////Get Admin all information

        $arr_rules                      = array();
        $arr_rules['current_password']  = 'required';
        $arr_rules['new_password']      = 'required';
        $arr_rules['confirm_password']  = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $old_password     = $request->input('current_password');
        $new_password     = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if(Hash::check($old_password,$obj_sales_user->password))////check old_password==detabase password
        {

            $update_password = Sentinel::update($obj_sales_user,['password'=>$new_password]);
            if($update_password)
            {
                Session::flash('success','Password Changed Successfully');

            }
            else
            {
                Session::flash('error','Error while changing password');
            }

            return redirect()->back();
        }
        else
        {
            Session::flash('error','Incorrect Old Password');
            return redirect()->back();
        }
    }




   public function logout()
    {
        Session::flush();
        return redirect('/sales_user');
    }

 }