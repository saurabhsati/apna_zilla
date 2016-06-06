<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Services\GeneratePublicId;

use App\Models\UserModel;
use App\Models\EmailTemplate;

use Sentinel;
use Mail;
use Hash;
use Reminder;
use URL;

class UserController extends Controller
{       
	public function __construct()
	{
        $json                          = array();
		$this->profile_pic_base_path   = base_path().'/public'.config('app.project.img_path.user_profile_pic');
		$this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
		
		/*/uploads/users/profile_pic*/
		$this->objpublic = new GeneratePublicId();
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
	}

    /*public function test(Request $request)
    {
        dd("test11");
    }*/

	/* User  Login Service*/

    public function login(Request $request)
    {
        

        $email_or_mobile = $request->input('email');
    	$password = $request->input('password');
        if(is_numeric($email_or_mobile))
        {
        	
            if(strlen($email_or_mobile)==10)
            { 
       
            	 $arr_creds['mobile_no'] = $email_or_mobile;
            }
            else
            {
                $json['status']  = 'ERROR';
                $json['message'] = 'Invalid Mobile Number !';
            }
        }
        else
        {
        	 $arr_creds['email'] = $email_or_mobile;
        }
        $arr_creds['password']  = $request->input('password');
      

        $user = Sentinel::stateless($arr_creds);
		if($user)
		{
            $user_info               = $user->toArray();
            
            $profile_image           = url('/uploads/users/profile_pic').'/'.$user_info['profile_pic'];
            $arr_data                = $user_info;
            $arr_data['profile_pic'] = $profile_image;


            $json['data']            = $arr_data;
            $json['status']  = 'SUCCESS';
			$json['message'] = 'Login successfully !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'Invalid Login Credentials !';
		}

		return response()->json($json);
    }


    /* User  Chnage Password Service*/
     public function change_password(Request $request)
    {
        $user_id          = $request->input('user_id');
        $old_password     = $request->input('current_password');
        $new_password     = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        $obj_user = Sentinel::createModel(); 
        $result_user = $obj_user::where('id',$user_id)->first();
        if($result_user)
        {   
            if(count($result_user)>0)
            {
                $arr_result = $result_user->toArray();
                //dd($arr_result);
                if(Hash::check($old_password,$arr_result['password']))
                {
                    if($new_password == $confirm_password)
                    {
                        $result = $obj_user::where('id',$user_id)->update(array('password'=> Hash::make($confirm_password)));
                        if($result)
                        {
                            $json['status'] = 'SUCCESS';
                            $json['message']  = 'Password changed successfully.';
                        }
                        else
                        {
                            $json['status'] = 'ERROR';
                            $json['message']  = 'Error while updating password.';
                        }
                    }
                    else
                    {
                        $json['status'] = 'ERROR';
                        $json['message']  = 'Confirm password does not match.';
                    }   
                }
                else
                {
                    $json['status'] = 'ERROR';
                    $json['message']  = 'Incorrect old password.';
                }
            }
            else
            {
                $json['status'] = 'ERROR';
                $json['message']  = 'Error while retrieving information.';                
            }
        }
        else
        {
            $json['status'] = 'ERROR';
            $json['message']  = 'Error while retrieving information.';                
        }

        return response()->json($json);

    }

    /* User Register Service */

    public function register(Request $request)
    {
        $first_name       = $request->input('first_name');
    	$last_name        = $request->input('last_name');
    	$email            = $request->input('email');
    	$mobile_no        = $request->input('mobile_no');
    	$password         = $request->input('password');
    	$confirm_password = $request->input('confirm_password');

    	$mobile_otp       = mt_rand(0,66666);

        if(is_numeric($mobile_no) && strlen($mobile_no)==10)
        {
            $user = Sentinel::createModel();
            if($email!='')
            {
            	$obj_email_arr_count =[];
            	$email_exist=0;
            		
            	$obj_email_arr_count = $user->where('email',$email)->get();
            	if($obj_email_arr_count)
            	{
            		$email_exist=sizeof($obj_email_arr_count->toArray());
            	}
            	 if($email_exist>0)
                {
               		 $json['status']  = 'ERROR';
               		 $json['message'] = 'Email Already Exist !';
               		 return response()->json($json);
               	}
                else
                {
                	$arr_data['email'] = $email;
                }	
            }
            if($mobile_no!='')
            {
            	$obj_mobile_arr_count =[];
            	$mobile_exist=0;
            		
            	$obj_mobile_arr_count=$user->where('mobile_no',$mobile_no)->get();
            	if($obj_mobile_arr_count)
            	{
            		$mobile_exist=sizeof($obj_mobile_arr_count->toArray());
            	}

                if($mobile_exist>0)
                {
               		 $json['status']  = 'ERROR';
               		 $json['message'] = ' Mobile Number Already Exist!';
               		 return response()->json($json);
                }
                else
                {
                	$arr_data['mobile_no'] = $mobile_no;
                }
            }
            if($confirm_password == $password)
            {
            	$arr_data['password'] 	 = $password;
			}
            else
            {
            	$json['status'] = 'ERROR';
                $json['message']  = 'Confirm password does not match !';
                return response()->json($json);
            }

			$arr_data['first_name']  = $first_name;
			$arr_data['last_name'] 	 = $last_name;
			$arr_data['mobile_OTP']  = $mobile_otp;
			$arr_data['is_active']   = '0';
			$status = Sentinel::registerAndActivate($arr_data);

			if($status)
            {
            	$role = Sentinel::findRoleBySlug('normal');

                $user = Sentinel::findById($status->id);

                $id=$status->id;
                $public_id = $this->objpublic->generate_public_id($id);

                $insert_public_id = UserModel::where('id', '=', $id)->update(array('public_id' => $public_id));
				$user->roles()->attach($role);

				$json['status']  = 'SUCCESS';
				$json['message'] = 'Register successfully !';
            }
            else
	        {
	            $json['status']  = 'ERROR';
	            $json['message'] = 'Error Occure In Registration !';
	            return response()->json($json);
	        }
			
			
         }
         else
         {
            $json['status'] = 'ERROR';
            $json['message']  = 'Invalid Mobile Number !';
            return response()->json($json);
         }
          return response()->json($json);
	}

	/*  Profile Edit Service */
	public function edit(Request $request)
	{
	    $id   = $request->input('id');
	    $obj_user = Sentinel::createModel();
		$arr_data = array();

		$result = $obj_user::where('id',$id)->first();
		if($result)
		{
			$arr_result 			 = $result->toArray();
			$arr_data['id'] 	     = $arr_result['id'];
			$arr_data['email'] 		 = $arr_result['email'];
			$arr_data['first_name']  = $arr_result['first_name'];
			$arr_data['profile_pic'] = url('/uploads/users/profile_pic').'/'.$arr_result['profile_pic'];
			$arr_data['is_active'] 	 = $arr_result['is_active'];
			$arr_data['role']		 = $arr_result['role'];
		    $role               = $arr_result['role'];

			if($role=='Normal')
		  	{
		  		$arr_data['prefix_name']         = $arr_result['prefix_name'];
		  		$arr_data['mobile_no'] 			 = $arr_result['mobile_no'];
			    $arr_data['d_o_b']               = $arr_result['d_o_b'];
		  		$arr_data['gender'] 	         = $arr_result['gender'];
		  		$arr_data['marital_status'] 	 = $arr_result['marital_status'];
		  		$arr_data['married_date'] 	     = $arr_result['married_date'];
		  	}
		  	else if($role=='admin' || $role=='sales')
		  	{
		  		$arr_data['office_landline'] 	 = $arr_result['office_landline'];
		  		$arr_data['street_address'] 	 = $arr_result['street_address'];
		  	}


		  	$json['data'] 	= $arr_data;
			$json['status']	= "SUCCESS";
    	  
        }
		else
		{
			$json['status']	= "ERROR";
            $json['message']  = 'Information not available.';	
		}

		return response()->json($json);	
	}

	/* Profile Update Service*/
    public function update(Request $request)
    {
       $json =array();
        $id			     = $request->input('id');
    	$obj_user = Sentinel::createModel();
    	if($request->hasFile('profile_pic'))
    	{
    		$cv_path 			= $request->file('profile_pic')->getClientOriginalName();
	        $image_extension 	= $request->file('profile_pic')->getClientOriginalExtension();
	        $image_name 		= sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
	         $request->file('profile_pic')->move(
                    $this->profile_pic_base_path, $image_name
                );
	        $profile_pic = $image_name; 
	        
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
    	    	
    	$result = $obj_user::where('id',$id)->first();
		if($result)
		{
			$arr_result     = $result->toArray();
			$role           = $arr_result['role'];


			
			$arr_data['first_name']     = $request->input('first_name');
			$arr_data['email']          = $request->input('email');
		  	$arr_data['profile_pic']    = $profile_pic;

			if($role=='Normal')
		  	{
		  		/* prefix_name => 0- Mr. 1-Ms. 2.Mrs. */
		  		$arr_data['prefix_name']         = $request->input('prefix_name');

		  		$arr_data['mobile_no'] 			 = $request->input('mobile_no');

			    $arr_data['d_o_b']               = date('Y-m-d',strtotime($request->input('d_o_b')));

			    /* gender => male,female */	
		  		$arr_data['gender'] 	         = $request->input('gender');

		  		 /* marital_status => Married,Un Married */	
		  		$arr_data['marital_status'] 	 = $request->input('marital_status');

		  		$arr_data['married_date'] 	     = date('Y-m-d',strtotime($request->input('married_date')));
		  	}
		  	else if($role=='admin' || $role=='sales')
		  	{
		  	    $arr_data['office_landline'] 	 = $request->input('office_landline');
		  		$arr_data['street_address'] 	 = $request->input('street_address');
		  	}
		  	//dd($arr_data);
		  	$result_update = $obj_user::where('id',$id)->update($arr_data);
		  	if($result_update)
		  	{
		  		$json['status']	= "SUCCESS";
                $json['message']  = 'Profile Updated successfully ! ';
		  	}
		  	else
		  	{
		  		$json['status']	= "ERROR";
                $json['message']  = 'Error Occure While Updating Profile ! ';	
		  	}


		}

    	return response()->json($json);

    }

    /* Recover Password Service
       check valid email and send the reset password link through email
     */
    public function recover_password(Request $request)
    {
            $email = $request->input('email');

            $data = array();
	        $data['email']  = $email;     
	        $data['new_password']  =  rand();
        
	        $obj_user = Sentinel::createModel();
	        ///Hash::make($data['new_password']
	        $update_password = $obj_user::where('email',$email)->update(['password'=>Hash::make($data['new_password'])]);
	        if($update_password)
	        {
				$subject = "RightNext | Recover Password";
	            
	        	$content = view('email.recover_password',compact('content'))->render();
                $content = html_entity_decode($content);
                $send_mail =0;
                if(!empty($email))
                {
	                $send_mail = Mail::send('api.email.forget_password_mail', $data, function ($message)use ($email,$subject)
	                            {
	                                $message->from('admin@rightnext.com','RightNext Admin');
	                                $message->to($email)
	                                        ->subject($subject);
	                           });
	            }
	            if($send_mail)
	            {
	                $json['status']   = "SUCCESS";
	                $json['message']  = 'Password Updated Successfully, Your new password is sent to your email.';
	            }
	            else
	            {
	                $json['status']   = "ERROR";
	                $json['message']  = 'Error while sending forgot password email.'; 
	            }
	        }
	         else
	        {
	          $json['status'] = "ERROR";
	          $json['message']  = 'Invalid Email Id You Have Provided !';  
	          return response()->json($json);
	        }
	        
	        return response()->json($json);

    }

   


    /* Edit Front user address */
    public function edit_address(Request $request)
    {
    	$id   = $request->input('id');
    	$obj_user_info = UserModel::select(['state','city','area','pincode','first_name'])->where('id','=',$id)->first();
        if($obj_user_info)
        {
            $arr_user_info = $obj_user_info->toArray();
        }
        if($arr_user_info)
        {

         	$json['data'] 	= $arr_user_info;
			$json['status']	= "SUCCESS";
			$json['message']  = 'User Address Detail Get Successfully !';
    	  
        }
		else
		{
			$json['status']	= "ERROR";
            $json['message']  = 'Information not available.';	
		}
		   return response()->json($json);

    }

    /* Update Front user address */
    public function update_address(Request $request)
    {
    	$id     =  $request->input('user_id');

        $arr_data['city']           = $request->input('city_id');
        $arr_data['state']          = $request->input('state_id');
        $arr_data['area']           = $request->input('area');
        $arr_data['pincode']        = $request->input('pincode');
        
        $status = UserModel::where('id',$id)->update($arr_data);

        if($status)
        {
            $json['status'] = 'SUCCESS';
            $json['message']  = 'Address Updated Successfully.';
        }
        else
        {
            $json['status'] = 'ERROR';
            $json['message']  = 'Error while updating address .';
        }
         return response()->json($json);
    }

    
    


}
