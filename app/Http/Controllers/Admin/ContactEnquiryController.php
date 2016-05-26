<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiryModel;
use Session;
use Validator;
use DB;

class ContactEnquiryController extends Controller
{
    public function __construct()
    {
      $arr_except_auth_methods = array();
      $this->middleware('\App\Http\Middleware\SentinelCheck',['except'=> $arr_except_auth_methods]);
    }

      /*
    | Index : Display listing of Contacted Users/Visitors
    | auther : Danish
    | Date : 26/02/2016
    | @return \Illuminate\Http\Response
    */

    public function index()
    {
       $page_title = "Contacted Users";
       $obj_arr_contact = ContactEnquiryModel::orderBy('contact_us_id','DESC')->get();
       $arr_contact=[];
       if($obj_arr_contact)
       {
        $arr_contact=$obj_arr_contact->toArray();
       }

     	 return view('web_admin.contact_enquiry.index',compact('page_title','arr_contact'));
    }

    /*
    | Show() : Display detail information regarding specific record
    | auther : Danish
    | Date : 26/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function show($enc_id)
    {
       $page_title = "Show Contacted Users";
       $id = base64_decode($enc_id);

       $arr_contact = ContactEnquiryModel::where('contact_us_id',$id)->first()->toArray();

       return view('web_admin.contact_enquiry.show',compact('page_title','arr_contact'));
    }


  }