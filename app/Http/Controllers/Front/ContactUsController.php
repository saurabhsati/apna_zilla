<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ContactEnquiryModel;

use Validator;
use Session;
use Sentinel;


class ContactUsController extends Controller
{
    public function index()
    {
    	$page_title='Contact Us';

        $obj_user_info = Sentinel::check();
        
        if($obj_user_info)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

    	return view('front.contact_us',compact('page_title','arr_user_info'));
    }

    public function store(Request $request)
    {
    	$arr_rules = array();
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
        	Session::flash('success','Contact Enquiry Sent successfully');
        }

        else
        {
        	Session::flash('error','Problem occured while sending contact enquiry');
        }
        return redirect()->back();

    }
}
