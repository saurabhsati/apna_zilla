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
       $page_title = "Contacted Users/Visitors List";   
       $arr_contact = ContactEnquiryModel::get()->toArray(); 
     	 
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
       $page_title = "Show Contacted User/Visitor";  
       $id = base64_decode($enc_id);

       $arr_contact = ContactEnquiryModel::where('contact_us_id',$id)->first()->toArray(); 
        
       return view('web_admin.contact_enquiry.show',compact('page_title','arr_contact'));
    }


  }