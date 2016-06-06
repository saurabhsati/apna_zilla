<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Common\Services\GeneratePublicId;

use App\Models\EmailTemplateModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\UserModel;
use Sentinel;
use Validator;
use Mail;

class VenderController extends Controller
{
    public function __construct()
    {
    	$json                          = array();
        $this->profile_pic_base_path   = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');
        $this->objpublic = new GeneratePublicId();
    }
    /* List the venders by sales_executive public id RNT-NPNL5 */
    public function index(Request $request)
 	{
 		$sales_user_public_id=$request->input('public_id');
       
        $obj_user = Sentinel::createModel()->orderBy('created_at','DESC')->where('sales_user_public_id','=',$sales_user_public_id)->get();
        if($obj_user)
		{
			$json['data'] 	 = $obj_user;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Vender List !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Venders Record Found!';
		}
        return response()->json($json);
 	}
 	 /* create the venders by sales_executive public id */
 	public function store(Request $request)
 	{
 		$sales_user_public_id = $request->input('public_id');

 		$first_name           = $request->input('first_name');
 		$gender               = $request->input('gender');
 		$d_o_b                = $request->input('d_o_b');
 		$marital_status       = $request->input('marital_status');
 		$married_date         = $request->input('married_date');
 		$email                = $request->input('email');
 		$mobile_no            = $request->input('mobile_no');
 		$password             = $request->input('password');
 		$state                = $request->input('state');
 		$city                 = $request->input('city');
 		$pincode              = $request->input('pincode');
 		$area                 = $request->input('area');

 		$user = Sentinel::createModel();

        if(is_numeric($mobile_no) && strlen($mobile_no)==10)
        {
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
           

	        $profile_pic = "default.jpg";

	        if ($request->hasFile('profile_pic'))
	        {
	            $profile_pic_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array(
	                                                'profile_pic' => 'mimes:jpg,jpeg,png'
	                                            ));

	            if ($request->file('profile_pic')->isValid())
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
	               	 $json['status']  = 'ERROR';
               		 $json['message'] = 'Invalid Image Format!';
               		 return response()->json($json);
	            }

			}
			$arr_data['password']       	     = $password;
			$arr_data['first_name']     	     = $first_name;
			$arr_data['gender']         	     = $gender;
			$arr_data['d_o_b']          	     = date('Y-m-d',strtotime($d_o_b));
			$arr_data['marital_status'] 	     = $marital_status;
			$arr_data['married_date']   	     = date('Y-m-d',strtotime($married_date));
			$arr_data['country']				 = '1';
            $arr_data['state']          	     = $state;
			$arr_data['city']           	     = $city;
			$arr_data['pincode']        	     = $pincode;
			$arr_data['area']           	     = $area;
			$arr_data['sales_user_public_id']    = $sales_user_public_id;
			$arr_data['profile_pic']  			 = $profile_pic;
			$arr_data['is_active']   			 = '1';
			$arr_data['role']   				 = 'normal';
			
			$status = Sentinel::registerAndActivate($arr_data);

			if($status)
            {
            	$role = Sentinel::findRoleBySlug('normal');

                $user = Sentinel::findById($status->id);
                $user->roles()->attach($role);

                $id=$status->id;
                $public_id = $this->objpublic->generate_public_id($id);

                $insert_public_id = UserModel::where('id', '=', $id)->update(array('public_id' => $public_id));
				
                if($email!='')
                {
                	$obj_email_template = EmailTemplateModel::where('id','12')->first();
		            if($obj_email_template)
		            {
		                $arr_email_template = $obj_email_template->toArray();

		                $content = $arr_email_template['template_html'];
		                $content        = str_replace("##USER_FNAME##",$first_name,$content);
		                $content        = str_replace("##USER_EMAIL##",$email,$content);
		                $content        = str_replace("##USER_PASSWORD##",$password,$content);
		                $content        = str_replace("##APP_NAME##","RightNext",$content);
		                $content        = str_replace("##USER_PUBLIC_ID##",$public_id,$content);
		                //print_r($content);exit;
		                $content = view('email.front_general',compact('content'))->render();
		                $content = html_entity_decode($content);

		                $send_mail = Mail::send(array(),array(), function($message) use($email,$first_name,$arr_email_template,$content)
		                            {
		                                $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
		                                $message->to($email, $first_name)
		                                        ->subject($arr_email_template['template_subject'])
		                                        ->setBody($content, 'text/html');
		                            });
				    }

                }

				$json['status']  = 'SUCCESS';
				$json['message'] = 'Verder Created Successfully !';
            }
            else
	        {
	            $json['status']  = 'ERROR';
	            $json['message'] = 'Error Occure While Creating Verder  !';
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
     /* Edit the venders by id */
 	public function edit(Request $request)
 	{
		$id             = $request->input('id');

		$obj_user       = Sentinel::createModel();
		$arr_data       = array();

		$result = $obj_user::where('id',$id)->first();
		if($result)
		{
			$arr_result 					 = $result->toArray();
			$arr_data['id'] 	    		 = $arr_result['id'];
			$arr_data['email'] 		 		 = $arr_result['email'];
			$arr_data['mobile_no'] 			 = $arr_result['mobile_no'];
			$arr_data['first_name']  		 = $arr_result['first_name'];
			$arr_data['profile_pic'] 		 = url('/uploads/users/profile_pic').'/'.$arr_result['profile_pic'];
			$arr_data['d_o_b']              = $arr_result['d_o_b'];
	  		$arr_data['gender'] 	         = $arr_result['gender'];
	  		$arr_data['marital_status'] 	 = $arr_result['marital_status'];
	  		$arr_data['married_date'] 	     = $arr_result['married_date'];
	  		$arr_data['state'] 	     		 = $arr_result['state'];
	  		$arr_data['city'] 	    		 = $arr_result['city'];
	  		$arr_data['pincode'] 	 	     = $arr_result['pincode'];
	  		$arr_data['area'] 	    		 = $arr_result['area'];
		  	


			$json['data'] 	 = $arr_data;
			$json['status']	 = "SUCCESS";
			$json['message'] = 'Information get available.';	
    	  
        }
		else
		{
			$json['status']	  = "ERROR";
            $json['message']  = 'Information not available.';	
		}

		return response()->json($json);	
 	}
 	public function update(Request $request)
 	{
		$id             = $request->input('id');

		$first_name     = $request->input('first_name');
		$gender         = $request->input('gender');
		$d_o_b          = $request->input('d_o_b');
		$marital_status = $request->input('marital_status');
		$married_date   = $request->input('married_date');
		$email          = $request->input('email');
		$mobile_no      = $request->input('mobile_no');
		$password       = $request->input('password');
		$state          = $request->input('state');
		$city           = $request->input('city');
		$pincode        = $request->input('pincode');
		$area           = $request->input('area');

		$profile_pic = FALSE;
        if ($request->hasFile('profile_pic'))
        {
            $cv_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array(
                                                'profile_pic' => 'mimes:jpg,jpeg,png'
                                            ));

            if($request->file('profile_pic')->isValid())
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
                $json['status']	  = "ERROR";
                $json['message']  = 'Invalid Image Format.';
            }

        }

        $arr_data = [
		            'first_name' 	=> $first_name,
		            'email'      	=> $email,
		            'gender' 		=> $gender,
		            'marital_status' => $marital_status,
		            'd_o_b'    		=> date('Y-m-d',strtotime($d_o_b)),
		            'married_date'  => date('Y-m-d',strtotime($married_date)),
		            'city' 			=> $city,
		            'state'			=>$state,
		            'pincode'		=>$pincode,
		            'area' 			=> $area,
		            'mobile_no' 	=> $mobile_no
		          ];

        if($password!=FALSE)
        {
            $arr_data['password'] = $password;
        }

        if($profile_pic!=FALSE)
        {
            $arr_data['profile_pic'] = $profile_pic;
        }

        $user = Sentinel::findById($id);

        $status = Sentinel::update($user,$arr_data);

        if($status)
        {

			$json['data'] 	 = $arr_data;
			$json['status']	 = "SUCCESS";
			$json['message'] = 'Vender Details Updates Successfully !.';	
    	  
        }
		else
		{
			$json['status']	  = "ERROR";
            $json['message']  = 'Information not available.';	
		}

		return response()->json($json);	
 	}
 	public function toggle_status(Request $request)
 	{
 		$json               = array();

 		$id             = $request->input('id');
		$action             = $request->input('action');
		 if($action=="activate")
        {
            $this->_activate($id);
            $json['status']	 = "SUCCESS";
			$json['message'] = 'Vender Activate Successfully !.';	
		}
        elseif($action=="block")
        {
            $this->_block($id);
            $json['status']	 = "SUCCESS";
			$json['message'] = 'Vender Block Successfully !.';	
		}
        elseif($action=="delete")
        {
            $this->_delete($id);
            $json['status']	 = "SUCCESS";
			$json['message'] = 'Vender Delete Successfully !.';	
        }
		return response()->json($json);	

 	}

 	public function multi_action(Request $request)
    {
        $arr_rules             = array();
        $json                  = array();
        $multi_action          = $request->input('multi_action');
        $checked_id_string = $request->input('checked_id_string');

        $checked_record_arr = explode(",",$checked_id_string);
        
 		
        /* Check if array is supplied*/
        if(isset($checked_record_arr) && sizeof($checked_record_arr)>0)
        {
        	 //dd($multi_action);
 		
	        foreach ($checked_record_arr as $key => $id)
	        {
	        	if($multi_action=="activate")
	            {
	               $this->_activate($id);
	               $json['status']	 = "SUCCESS";
				   $json['message']  = 'Vender Activate Successfully !.';
	            }
	            elseif($multi_action=="block")
	            {
	               $this->_block($id);
	               $json['status']	 = "SUCCESS";
				   $json['message'] = 'Vender Blocked Successfully !.';
				    
	            }
	            elseif($multi_action=="delete")
	            {
	               $this->_delete($id);
	               $json['status']	 = "SUCCESS";
				   $json['message'] = 'Vender Deleted Successfully !.';
	            }

	        }
	    }
	    else
	    {
              $json['status']	     = "ERROR";
			  $json['message']       = 'Problem Occured, While Doing Multi Action';	
        }


        return response()->json($json);
    }

    protected function _activate($id)
    {
        $user = Sentinel::createModel()->where('id',$id)->first();

        $user->is_active = "1";

        return $user->save();
    }

    protected function _block($id)
    {
    	$user = Sentinel::createModel()->where('id',$id)->first();

        $user->is_active = "0";

        return $user->save();
    }

    protected function _delete($id)
    {
    	 $user = Sentinel::findById($id);
		return $user->delete();
    }
}
