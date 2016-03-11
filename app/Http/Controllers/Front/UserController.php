<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Session;
use Sentinel;
use Validator;
use DB;

class UserController extends Controller
{
 	public function __construct()
 	{

 		// $arr_except_auth_methods = array();
 		// $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
 	}

        
 	public function store(Request $request)
    {    
        $arr_rules = array();
        $arr_rules['first_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['password'] = "required|min:6|confirmed";
        
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())                                                                 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $first_name       = $request->input('first_name');
        $last_name       = $request->input('last_name');
        $email          = $request->input('email');
        $password      = $request->input('password');

        /* Duplication Check*/
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
        	Session::flash('error','User Already Exists with this email id');
            return redirect()->back();
        }

         $status = Sentinel::registerAndActivate([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            
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
        return view('front.user.profile');
    }

 }
