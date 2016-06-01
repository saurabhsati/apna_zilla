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
use App\Models\DealsOffersModel;
use App\Models\CountryModel;
use App\Models\ZipModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\TransactionModel;

use Sentinel;
use Session;
use Validator;
use Hash;
use DB;




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

        
         if(Session::has('public_id'))
         {
          $sales_user_public_id=Session::get('public_id');
         }
         else
         {
            return view('sales_user.account.login');
         }
        $vender_count =  $business_listing_count = $deals_count = $membership_transaction_count=0;
        $obj_user      = $obj_business_listing = $obj_deal = $obj_transaction=[];
       

        $obj_user     = Sentinel::createModel()->where('sales_user_public_id','=',$sales_user_public_id)->where('role','=','normal')->get();
        if($obj_user!= FALSE)
        {
            $vender_count=  sizeof($obj_user->toArray());
        }

        $obj_business_listing = BusinessListingModel::where('sales_user_public_id',$sales_user_public_id)->get();
        if($obj_business_listing)
        {
            $business_listing_count = sizeof($obj_business_listing->toArray());
        }

        $obj_deal=DealsOffersModel::where('public_id',$sales_user_public_id)->get();
        if($obj_deal)
         {
            $deals_count = sizeof($obj_deal->toArray());
         }
         $obj_transaction = TransactionModel::where('sales_user_public_id',$sales_user_public_id)->get();

        if($obj_transaction)
        {
              $membership_transaction_count = sizeof($obj_transaction->toArray());
        }

        $users = DB::table('users')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year,DAY(created_at) as day, COUNT(id) as user_count'))
              ->where('role','=','normal')
              ->where('sales_user_public_id','=',$sales_user_public_id)
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();
        $users_array = json_decode(json_encode($users), True);

        //dd($users_array);
        $businesses = DB::table('business')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as business_count'))
              ->where('sales_user_public_id','=',$sales_user_public_id)
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();
        $businesses_array = json_decode(json_encode($businesses), True);

        $deals = DB::table('deals')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as deal_count'))
              ->where('public_id',$sales_user_public_id)
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();

        $deals_array = json_decode(json_encode($deals), True);
	return view('sales_user.account.dashboard',compact('page_title','vender_count','business_listing_count','deals_count','membership_transaction_count','users_array','businesses_array','deals_array'));

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
            $first_name = $sales_user['first_name'];
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
                            Session::put('first_name', $first_name);
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
        $arr_rules['first_name']    = 'required';

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
        $first_name = $request->input('first_name');
        $update_arr =array();
        $update_arr=array('profile_pic'=>$profile_pic,'office_landline'=>$office_landline,'street_address'=>$street_address,'first_name'=>$first_name);
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