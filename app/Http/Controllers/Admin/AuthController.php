<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Routing\UrlGenerator;
use Sentinel;
use Session;
use Validator;
use Hash;
use Auth;
use Cartalyst\Sentinel\Activations\EloquentActivation;

class AuthController extends Controller
{

 	public function __construct()
 	{
 		$this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
 	}


 	public function register()
 	{
 		return view('web_admin.login.login');
 	}

 	public function register_admin(Request $request)
 	{
 		if ($user = Sentinel::register($request->all()))
	{
		Session::flash('success','Registered Successfully!!!');
		return redirect()->back();
 	}
 		else
 		{
 			Session::flash('error','Invalid Credentials');
 			return redirect()->back();
 		}
 	}

	public function assignRole()
	{
		$role = Sentinel::findRoleBySlug('admin');

		$user = Sentinel::findById(1);
		//$user = Sentinel::getUser();

		$user->roles()->attach($role);

	}


	public function registerAndActivate()
	{

	$credentials = [
    'email'    => 'admin@justdial.com',
    'password' => '123456',
	];

	$user = Sentinel::registerAndActivate($credentials);

	}

	public function activation()
	{
		$user = Sentinel::findById(6);

		$activation = Activation::create($user);
	}

 	public function show_login()
 	{
 		return view('web_admin.login.login');
 	}

 	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

 	public function process_login(Request $request)
 	{
 		$arr_creds =  array();
 		$arr_creds['email'] = $request->input('email');
 		$arr_creds['password'] = $request->input('password');

 		$user = Sentinel::authenticate($arr_creds);

 		if($user)
 		{
 			/* Check if Users Role is Admin */
 			$role = Sentinel::findRoleBySlug('admin');
 			if(Sentinel::inRole($role))
 			{
 				return redirect('web_admin/dashboard');
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

 	public function change_password()
 	{
 		/*$obj_admin = Sentinel::getUser();
 		dd($obj_admin->password);*/
 		$page_title = 'Change Password';
 		return view('web_admin.login.change_password',compact('page_title'));
 	}

 	public function update_password(Request $request)
 	{
 		$obj_admin = Sentinel::getUser();////Get Admin all information

 		$arr_rules 						= array();
 		$arr_rules['current_password'] 	= 'required';
 		$arr_rules['new_password']		= 'required';
 		$arr_rules['confirm_password'] 	= 'required';

 		$validator = Validator::make($request->all(),$arr_rules);

 		if($validator->fails())
 		{
 			return redirect()->back()->withErrors($validator)->withInput();
 		}

 		$old_password 	  = $request->input('current_password');
 		$new_password 	  = $request->input('new_password');
 		$confirm_password = $request->input('confirm_password');

 		if(Hash::check($old_password,$obj_admin->password))////check old_password==detabase password
 		{

			$update_password = Sentinel::update($obj_admin,['password'=>$new_password]);
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
 	/* Edit Profile */
 	public function profile()
 	{

 		if ($user = Sentinel::getUser())
		{
			$arr_admin=$user->toArray();
			return view('web_admin.login.admin_profile',compact('page_title','arr_admin'));
		    // User is logged in and assigned to the `$user` variable.

 		$page_title ="Edit Profile";
 		if ($user = Sentinel::getUser())
		{
			$admin_arr=$user->toArray();
			return view('web_admin.login.admin_profile',compact('page_title','admin_arr'));

		}
 	}
 	public function updateprofile(Request $request)
 	{
 		$obj_admin = Sentinel::getUser();////Get Admin all information
 		 if($obj_admin)
                {
                       $admin_data   =   $obj_admin->toArray();
                 }
 		$arr_rules 						= array();
 		$arr_rules['office_landline']		= 'required';
 		$arr_rules['street_address'] 	= 'required';

 		$validator = Validator::make($request->all(),$arr_rules);

 		if($validator->fails())
 		{
 			return redirect()->back()->withErrors($validator)->withInput();
 		}

 		 $profile_pic = $admin_data ['profile_pic']?$admin_data ['profile_pic']: "default.jpg";

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
        $profile_pic 	=$profile_pic;
 		$office_landline 	  = $request->input('office_landline');
 		$street_address = $request->input('street_address');
 		$update_arr	=array();
 		$update_arr=array('profile_pic'=>$profile_pic,'office_landline'=>$office_landline,'street_address'=>$street_address);
 		$update_profile = Sentinel::update($obj_admin,$update_arr);
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

 	public function logout()
 	{
 		Sentinel::logout();
 		return redirect('/web_admin/login');
 	}

 	 protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
