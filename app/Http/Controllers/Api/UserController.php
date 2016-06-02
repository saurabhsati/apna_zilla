<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Mail;
use Hash;

class UserController extends Controller
{

	public function __construct()
	{
		$json = array();
		$this->profile_pic_base_path = base_path().'/public/uploads/users/profile_pic/';

		/*
		$this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
		*/
		/*/uploads/users/profile_pic*/

        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
	}

    public function login(Request $request)
    {
        $email = $request->input('email');
    	$password = $request->input('password');
        dd($email);
        
		$user = Sentinel::stateless(array('email'=>$email,'password'=>$password));
		if($user)
		{
			$json['data'] 	= $user;
			$json['status'] = 'SUCCESS';
		}
		else
		{
			$json['status'] = 'ERROR';
		}

		return response()->json($json);
    }


   

}
