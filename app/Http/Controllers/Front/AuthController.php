<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\EmailTemplate;

use Sentinel;
use Validator;
use Session;
use Mail;
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

            $login_status = Sentinel::login($existing_user); // process login a user

            Session::flash('success','You are Successfully Login .');
            
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

        if($status)
        {   
            $user = Sentinel::findById($status->id);

            $id = $status->id;
            $user = Sentinel::findById($status->id);
            $role = Sentinel::findRoleBySlug('user');

            $user->roles()->attach($role); /* Assign Normal Users Role */

            $preferences = $this->create_preferences($status->id);  /* Create Preference for user */

            $email_id = $email;

            $data['name']                   = $name;
            $data['email']                  = $email;
            $data['plain_text_password']    = $password;
           
            $send_mail = $this->via_social_registration_send_mail($arr_data);

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

            Session::flash('success','You are Successfully Login .');
            
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

            $preferences = $this->create_preferences($status->id);  /* Create Preference for user */

            $email_id = $email;

            $data['name']                   = $fname.' '.$lname;
            $data['email']                  = $email;
            $data['plain_text_password']    = $password;
           
            $send_mail = $this->via_social_registration_send_mail($arr_data);

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

       public function process_login(Request $request)
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
}
