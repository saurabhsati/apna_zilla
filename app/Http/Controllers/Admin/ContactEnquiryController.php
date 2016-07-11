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




    public function delete($enc_id)////$enc_id = Deal id
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','Deal(s) Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occurred While Deleting Deal(s)');
        }
        return redirect()->back();
    }

  

    protected function _delete($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

       /* $arr_deal = DealModel::select('id','deal_image')->where('id',$id)->first()->toArray();

        $get_path = $this->deal_image_path.$arr_deal['deal_image'];

        $unlink_deal_image = FALSE;
        if(is_readable($get_path))
        {
            $unlink_deal_image = unlink($get_path);  //////////////////Unlink Deal image

            if($unlink_deal_image==TRUE)
            {
                return DealModel::where('id',$id)->delete();//////////Soft Delete Deal
            }
        }
*/
    }

    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


       /* $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Any Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is suppliedsizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
           if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Deal(s) Deleted Successfully');
            }
        return redirect()->back();*/
    }


  }