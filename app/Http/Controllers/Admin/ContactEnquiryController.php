<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiryModel;
use Session;

class ContactEnquiryController extends Controller
{
    public function __construct()
    {
        $arr_except_auth_methods = [];
        $this->middleware('\App\Http\Middleware\SentinelCheck', ['except' => $arr_except_auth_methods]);
    }

    /*
    | Index : Display listing of Contacted Users/Visitors
    | auther : Danish
    | Date : 26/02/2016
    | @return \Illuminate\Http\Response
    */

    public function index()
    {
        $page_title = 'Contacted Users';
        $obj_arr_contact = ContactEnquiryModel::orderBy('contact_us_id', 'DESC')->get();
        $arr_contact = [];
        if ($obj_arr_contact) {
            $arr_contact = $obj_arr_contact->toArray();
        }

        return view('web_admin.contact_enquiry.index', compact('page_title', 'arr_contact'));
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
        $page_title = 'Show Contacted Users';
        $id = base64_decode($enc_id);

        $arr_contact = ContactEnquiryModel::where('contact_us_id', $id)->first()->toArray();

        return view('web_admin.contact_enquiry.show', compact('page_title', 'arr_contact'));
    }

    public function toggle_status($enc_id, $action)
    {
        if ($action == 'delete') {
            $this->_delete($enc_id);

            Session::flash('success', 'ContactEnquiry(s) Deleted Successfully');
        } elseif ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'ContactEnquiry(s) Activated Successfully');
        } elseif ($action == 'deactivate') {
            $this->_block($enc_id);

            Session::flash('success', 'ContactEnquiry(s) Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/contact_enquiry');
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        return ContactEnquiryModel::where('contact_us_id', $id)->delete();
    }
}
