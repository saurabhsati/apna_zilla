<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
 		echo "profile";
 		//test
 		/*if ($user = Sentinel::getUser())
		{
			print_r($user);
		    // User is logged in and assigned to the `$user` variable.
		}*/
 	}
 	public function updateprofile()
 	{

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
