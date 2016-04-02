<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;
use App\Models\SiteSettingModel;
use App\Models\EmailTemplateModel;
use Validator;
use Session;
use Sentinel;
use Mail;

class ContactUsController extends Controller
{
    public function index()
    {
    	$page_title='Contact Us';
        $arr_site_setting = array();
        $obj_site_setting = SiteSettingModel::first();

        if($obj_site_setting)
        {
            $arr_site_setting = $obj_site_setting->toArray();
        }
        //dd($arr_site_setting);
        return view('front.contact_us',compact('page_title','arr_site_setting'));
    }

    public function store(Request $request)
    {
    	$arr_rules = array();
       // dd($request->all());
    	$arr_rules['name'] = "required";
    	$arr_rules['mobile_no'] = "required";
    	$arr_rules['email'] = "required";
    	$arr_rules['message'] = "required";

    	$validator = Validator::make($request->all(),$arr_rules);

    	if($validator->fails())
    	{
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	 $name = $request->input('name');
    	 $mobile_no = $request->input('mobile_no');
    	 $email = $request->input('email');
    	 $message = $request->input('message');


        $status = ContactEnquiryModel::create(['full_name'=> $name,
        									'mobile_no' => $mobile_no,
        									'email_address' => $email,
        									'message' => $message
        								  ]);

        if($status)
        {
             $obj_email_template = EmailTemplateModel::where('id','9')->first();
            if($obj_email_template)
            {
                $arr_email_template = $obj_email_template->toArray();

                $content = $arr_email_template['template_html'];

                $content        = str_replace("##USER FULL NAM##",$name,$content);
                $content        = str_replace("##USER EMAILID##",$email,$content);
                $content        = str_replace("##USER CONTACT NUMBER##",$email,$content);




                $content = view('email.contact_us_user',compact('content'))->render();
                $content = html_entity_decode($content);

                $send_mail = Mail::send(array(),array(), function($message) use($email,$name,$arr_email_template,$content)
                            {
                                $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                $message->to($email, $name)
                                        ->subject($arr_email_template['template_subject'])
                                        ->setBody($content, 'text/html');
                            });

                return $send_mail;
            }
            //echo 'success';

        	//Session::flash('success','Contact Enquiry Sent successfully');
        }

        else
        {
           // echo 'error';

        	//Session::flash('error','Problem occured while sending contact enquiry');
        }
        return redirect()->back();

    }
}
