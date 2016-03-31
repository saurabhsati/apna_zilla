<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\UserModel;

use Sentinel;
use Validator;
use Session;
use Mail;
use Hash;
use Activation;
use URL;

class AuthController extends Controller
{
    public function __construct()
    {
    } 

    public function register_via_google_plus(Request $request)
    {
        $arr_rules = array();
        $arr_rules['name'] = "required";
        $arr_rules['email'] = "required|email";
     
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $data['status'] = "ERROR";
            $data['msg'] = "Validation Error";
            return response()->json($data);
        }

        $name         = $request->input('name');
        $email        = $request->input('email');    
        
        $array_name     = explode(" ",$name);
        $first_name     = $array_name[0];
        $last_name      = "";

        if(!empty($array_name[1]))
        {
            $last_name = $array_name[1];
        }

        /* -------------     Generate a Password    ------------------------ */
        $digits = 8;
        $password =  rand(pow(10, $digits-1), pow(10, $digits)-1);

        /* Existing User Check */
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
            $credentials = [ 'email' => $email ];
            $existing_user = Sentinel::findUserByCredentials($credentials);

            $user_first_name = $existing_user->first_name;
            $user_email = $existing_user->email;

            //dd($existing_user->toArray());

            Session::set('user_name', $user_first_name);
            Session::set('user_mail', $user_email);

            $login_status = Sentinel::login($existing_user); // process login a user

            Session::flash('success','Login Successfull');
            
            $data['status'] = "SUCCESS";
            $data['msg']    = "Redirect to my account page";
            return response()->json($data);
        }

        $arr_data = [
                        
                    'first_name'            => $first_name,
                    'last_name'             => $last_name,
                    'email'                 => $email,
                    'password'              => $password,
                    'is_active'             => '1',
                    'via_social'            => '1',
                    'ask_for_old_password'  => '0'
        ];
        $status = Sentinel::registerAndActivate($arr_data);
//dd($status);
        if($status)
        {   
            $user = Sentinel::findById($status->id);

            $id = $status->id;
            $user = Sentinel::findById($status->id);
            $role = Sentinel::findRoleBySlug('user');

            $user->roles()->attach($role); /* Assign Normal Users Role */

            // /$preferences = $this->create_preferences($status->id);  /* Create Preference for user */

            $email_id = $email;

            $data['name']                   = $name;
            $data['email']                  = $email;
            $data['plain_text_password']    = $password;

             Session::set('user_name', $status->first_name);
             Session::set('user_mail', $status->email);
           
            Session::flash('success','Login Successfull');

            $data['status'] = "SUCCESS";
            $data['msg'] = "You Have Registered Successfully";
            return response()->json($data);
        }
        else
        {
            $data['status'] = "ERROR";
            $data['msg'] = "Problem Occured While Registration";
            return response()->json($data);
        }
    }   


    public function register_via_facebook(Request $request)
    {
        $arr_rules = array();
        $arr_rules['fname'] = "required";
        $arr_rules['lname'] = "required";
        $arr_rules['email'] = "required|email";
        
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $data['status'] = "ERROR";
            $data['msg'] = "Validation Error";
            return response()->json($data);
        }

        $fname         = $request->input('fname');
        $lname         = $request->input('lname');
        $email         = $request->input('email');    
        
        /* -------------     Generate a Password    ------------------------ */
        $digits = 8;
        $password =  rand(pow(10, $digits-1), pow(10, $digits)-1);

        /* Existing User Check */
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
            $credentials   = [ 'email' => $email ];
            $existing_user = Sentinel::findUserByCredentials($credentials);
            $login_status  = Sentinel::login($existing_user); // process login a user
            //dd($login_status);

            Session::set('user_name', $fname);
            Session::set('user_mail', $email);
            //Session::set('user_id', $email);

           Session::flash('success','Login Successfull');
            
            $data['status'] = "SUCCESS";
            $data['msg'] 	= "Redirect to my account page";
            return response()->json($data);
        }

        $arr_data = [
                        
                    'first_name'            => $fname,
                    'last_name'             => $lname,
                    'email'                 => $email,
                    'password'              => $password,
                    'is_active'             => '1',
                    'via_social'            => '1',
                    'ask_for_old_password'  => '0'
        ];
        $status = Sentinel::registerAndActivate($arr_data);

        if($status)
        {   
            $user = Sentinel::findById($status->id);

            $id   = $status->id;
            $user = Sentinel::findById($status->id);
            $role = Sentinel::findRoleBySlug('user');

            $user->roles()->attach($role); /* Assign Normal Users Role */

            //$preferences = $this->create_preferences($status->id);  /* Create Preference for user */

            $email_id = $email;

            $data['name']                   = $fname.' '.$lname;
            $data['email']                  = $email;
            $data['plain_text_password']    = $password;

            Session::set('user_name', $fname);
            Session::set('user_mail', $data['email']);

            Session::flash('success','Login Successfull');

            $data['status'] = "SUCCESS";
            $data['msg']    = "You Have Registered Successfully";
            return response()->json($data);
        }
        else
        {
            $data['status'] = "ERROR";
            $data['msg']    = "Problem Occured While Registration";
            return response()->json($data);
        }
    }

    public function via_social_registration_send_mail($arr_data)
    {
        // Retrieve Email Template 

        $obj_email_template = EmailTemplate::where('id','3')->first();
        if($obj_email_template)
        {
            $arr_email_template = $obj_email_template->toArray();

            $content = $arr_email_template['template_html'];

            $content = str_replace("##USER_FNAME##",        $arr_data['first_name'] , $content);
            $content = str_replace("##USER_EMAIL##",        $arr_data['email']      , $content);
            $content = str_replace("##USER_PLAIN_PASS##",   $arr_data['password']   , $content);
            $content = str_replace("##APP_LINK##",          config('app.project.name'), $content);

            $content = view('email.general',compact('content'))->render();
            $content = html_entity_decode($content);

            $send_mail = Mail::send(array(),array(), function($message) use($arr_data,$arr_email_template,$content)
                        {   
                            $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                            $message->to($arr_data['email'], $arr_data['first_name'])
                                    ->subject($arr_email_template['template_subject'])
                                    ->setBody($content, 'text/html');
                        });

            return $send_mail;
        }  
    }

    public function process_login_ajax(Request $request)
    {   
        $json = array();
        $arr_creds =  array();

        $email_or_mobile = $request->input('email');

        // $arr_creds['email'] = '';
        // $arr_creds['mobile_no'] ='';
        if(is_numeric($email_or_mobile))
        {
            
            if(strlen($email_or_mobile)==10)
            {
                $arr_creds['mobile_no'] = $email_or_mobile;
            }
            else
            {
                Session::flash('error','Incorrect Mobile No.');
                
            }    
        }
        else
        {
            $arr_creds['email'] = $email_or_mobile;
        }    
        


        $arr_creds['password']  = $request->input('password');

        $user = Sentinel::authenticate($arr_creds);
    
        if($user)
        {
            /* Check if Users Role is Admin */
            $role = Sentinel::findRoleBySlug('normal');
            if(Sentinel::inRole($role))
            {   
                if(is_numeric($email_or_mobile))
                {
                    $obj_user_info = UserModel::Where('mobile_no','=',$arr_creds['mobile_no'])->get();
                   
                }
                else
                {
                    $obj_user_info = UserModel::where('email','=',$arr_creds['email'])->get();  
                }
                
                
                if($obj_user_info);
                {
                   $arr_user_info = $obj_user_info->toArray();
                }
                
      
                foreach ($arr_user_info as $user)
                {
                    $user_id = base64_encode($user['id']) ;
                    Session::set('user_id', $user_id);
                    Session::set('user_name', $user['first_name']);
                    Session::set('user_mail', $user['email']);
                }
                Session::flash('success','Login Successfull.');
                $json = "SUCCESS";
                //return redirect('front_users/profile');
            }
            else
            {
                //Session::flash('error','Not Sufficient Privileges');
                $json =  'No Sufficient Privileges';
            }
        }
        else
        {
            //Session::flash('error','Invalid Credentials');
            $json =  'Invalid Credentials';
        }

        return response()->json($json);

    }

    public function process_login(Request $request)
    {
        $arr_creds =  array();
        $arr_creds['email']     = $request->input('email');
        $arr_creds['password']  = $request->input('password');

        $user = Sentinel::authenticate($arr_creds);

        if($user)
        {
            /* Check if Users Role is Admin */
            $role = Sentinel::findRoleBySlug('normal');
            if(Sentinel::inRole($role))
            {   
                $obj_user_info = UserModel::where('email','=',$arr_creds['email'])->get();
                // $obj_user_info = UserModel::where('email','=',$arr_creds['email'])
                //                          ->orWhere('mobile_no','=',$arr_creds['email'])
                //                          ->toSQL();

                // dd($obj_user_info);
                
                if($obj_user_info);
                {
                    $arr_user_info = $obj_user_info->toArray();
                }
                
                foreach ($arr_user_info as $user)
                {
                    $user_id = base64_encode($user['id']) ;
                    Session::put('user_id', $user_id);
                    Session::set('user_name', $user['first_name']);

                }
                Session::flash('success','Login Successfull.');
                return redirect('front_users/profile');
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


    public function process_login_for_share(Request $request,$enc_id)
    {

        $arr_creds =  array();
        $arr_creds['email'] = $request->input('email');
        $arr_creds['password'] = $request->input('password');

        $user = Sentinel::authenticate($arr_creds);

        if($user)
        {
            /* Check if Users Role is Admin */
            $role = Sentinel::findRoleBySlug('normal');
            if(Sentinel::inRole($role))
            {   
                // $obj_user_info = UserModel::where('email','=',$arr_creds['email'])->get();
                
                $obj_user_info = UserModel::where('email','=',$arr_creds['email'])
                                         ->orWhere('mobile_no','=',$arr_creds['email'])
                                         ->toSQL();

                dd($obj_user_info);

                if($obj_user_info);
                {
                    $arr_user_info = $obj_user_info->toArray();    
                }
                
                
                foreach ($arr_user_info as $user)
                {
                    $user_id = base64_encode($user['id']) ;
                    Session::put('user_id', $user_id);

                }
                return redirect('listing/share_business/'.$enc_id);
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


    public function logout()
    {
        Sentinel::logout();
        Session::flush();
        return redirect('/');
    }

    public function change_password()
    {
        /*$obj_admin = Sentinel::getUser();
        dd($obj_admin->password);*/
        $page_title = 'Change Password';
        return view('front.user.change_password',compact('page_title'));
    }

    public function update_password(Request $request)
    {
        $obj_user = Sentinel::getUser();////Get Admin all information
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

        if(Hash::check($old_password,$obj_user->password))////check old_password==detabase password
        {

            $update_password = Sentinel::update($obj_user,['password'=>$new_password]);
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

}
