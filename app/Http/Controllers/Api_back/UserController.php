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


    public function register(Request $request)
    {
    	$email 		 = $request->input('email');
    	$password 	 = $request->input('password');
    	$firstname   = $request->input('first_name');
    	$lastname	 = $request->input('last_name');
    	$mobile_no	 = $request->input('mobile_no');

    	
    	$obj_user = Sentinel::createModel(); 				// Creating User Model instance.

    	if(!$obj_user->where('email',$email)->first())		// Checking duplicate entry.
    	{
    		$user_register = Sentinel::register(array('email'=>$email,'password'=>$password));
			if($user_register)
			{
				$arr_data['first_name'] = $firstname;
				$arr_data['last_name'] 	= $lastname;
				$arr_data['mobile_no'] 	= $mobile_no;					
			
				$register = $obj_user::where('id',$obj_user->where('email',$email)->first()->id)->update($arr_data);
				if($register)
				{
					$json['status'] = 'SUCCESS';
				}

			}

    	}
    	else
    	{
    		$json['status'] = 'ERROR';
    	} 

		return response()->json($json);
    }


    public function edit(Request $request)
    {
    	$id = $request->input('id');
    	$obj_user = Sentinel::createModel(); 
		$arr_data = array();

		$result = $obj_user::where('id',$id)->first();
		if($result)
		{
		  	$arr_result 			= $result->toArray();
		  	$arr_data['id'] 		= $arr_result['id'];
		  	$arr_data['email'] 		= $arr_result['email'];
		  	$arr_data['first_name'] = $arr_result['first_name'];
		  	$arr_data['last_name'] 	= $arr_result['last_name'];
		  	$arr_data['profile_pic']= $arr_result['profile_pic'];
		  	$arr_data['mobile_no'] 	= $arr_result['mobile_no'];
	 	 	$arr_data['address'] 	= $arr_result['address'];
			$arr_data['is_active'] 	= $arr_result['is_active'];

			$json['data'] 	= $arr_data;
			$json['status']	= "SUCCESS";
		}
		else
		{
			$json['status']	= "SUCCESS";	
		}

		return response()->json($json);	
   	}	

   	public function update(Request $request)
   	{
   		$id			 = $request->input('id');
   		$email 		 = $request->input('email');
    	$first_name  = $request->input('first_name');
    	$last_name	 = $request->input('last_name');
    	$mobile_no	 = $request->input('mobile_no');
    	$address	 = $request->input('address');

    	$obj_user = Sentinel::createModel(); 				// Creating User Model instance.

    	$arr_data['email'] 		= $email ;
    	$arr_data['first_name'] = $first_name ; 
    	$arr_data['last_name'] 	= $last_name ;
    	$arr_data['mobile_no'] 	= $mobile_no ;
    	$arr_data['address'] 	= $address ;
    	
    	if($request->hasFile('profile_pic'))
    	{
    		$cv_path 			= $request->file('profile_pic')->getClientOriginalName();
	        $image_extension 	= $request->file('profile_pic')->getClientOriginalExtension();
	        $image_name 		= sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
	        if($image_name)
	        {
	        	$result = $obj_user::where('id',$id)->first();
	    		if($result)
	    		{
	    			$arr_result  	= $result->toArray();
	    		  	$unlink_path    = $this->profile_pic_base_path.$arr_result['profile_pic'];
                    $unlink_image   = unlink($unlink_path);
                    if($unlink_image==TRUE)
                    {
                        $final_image = $request->file('profile_pic')->move($this->profile_pic_base_path,$image_name);          
                    }

	    		}	
				$profile_pic = $image_name; 
	        }
	        
    	}
    	else
    	{
    		$result = $obj_user::where('id',$id)->first();
    		if($result)
    		{
    			$arr_result  = $result->toArray();
    			$profile_pic = $arr_result['profile_pic'];
    		}	
    	}

    	$arr_data['profile_pic'] = $profile_pic;
    	$result_update = $obj_user::where('id',$id)->update($arr_data);

    	if($result_update)
    	{
    		$json['status'] = "SUCCESS";
    	}
    	else
    	{
    		$json['status'] = "ERROR";
    	}

		return response()->json($json);
   	}

    public function forget_password(Request $request)
    {
        $email = $request->input('email');

        $data = array();
        $data['email']  = $email;     
        $data['new_password']  =  base64_encode(rand()) ;
        
        $obj_user = Sentinel::createModel();

        $update_password = $obj_user::where('email',$email)->update(['password'=> Hash::make($data['new_password'])]);
        if($update_password)
        {
            $subject = "Epatchy | Forget Password";
            $result = Mail::send('api.email.forget_password_mail', $data, function ($message)use ($email,$subject) 
            {
                $message->from('admin@epatchy.com','Epatchy Admin');
                $message->to($email);
                $message->subject($subject);
            });
            if($result)
            {
                $json['status'] = "SUCCESS";
            }
            else
            {
                $json['status'] = "ERROR"; 
            }
        }
        else
        {
          $json['status'] = "ERROR";  
        }
        return response()->json($json);
    }

}
