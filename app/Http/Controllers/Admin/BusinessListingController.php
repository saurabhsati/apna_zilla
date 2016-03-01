<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BusinessListingModel;
use App\Models\UserModel;
use Validator;
use Session;
class BusinessListingController extends Controller
{
    //
    public function __construct()
    {
    	 $this->UserModel = new UserModel();
    	 $this->BusinessListingModel = new BusinessListingModel();

    }
    public function index()
    {
    	$page_title	='Manage Business Listing';
    	$business_listing	=array();
    	$business_listing=$this->BusinessListingModel->with(['user_details'])->get()->toArray();
    	return view('web_admin.business_listing.index',compact('page_title','business_listing'));
    }
    public function edit($enc_id)
 	{
 		$id = base64_decode($enc_id);
 		$page_title = "Business Listing: Edit ";

 		$arr_business_data = array();
 		$business_data=$this->BusinessListingModel->with(['user_details'])->where('id',$id)->get()->toArray();
 		return view('web_admin.business_listing.edit',compact('page_title','business_data'));

 	}
 	public function update(Request $request,$enc_id)
 	{
 		/*$id	=base64_decode($enc_id);
 		$form_data	= array();
 		$arr_rules = array();

 		$arr_rules['business_name'] = "required";
        $arr_rules['title'] = "required";
        $arr_rules['first_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['city'] = "required";
        $arr_rules['mobile_no'] = "required";



        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data['business_name']      = $request->input('business_name');
        $form_data['title']      = $request->input('title');
        $form_data['first_name ']= $request->input('first_name');
        $form_data['last_name'] = $request->input('last_name');
        $form_data['email']      = $request->input('email');
        $form_data['city']      = $request->input('city');
        $form_data['mobile_no']      = $request->input('mobile_no');
        $business_data=$this->BusinessListingModel->with(['user_details'])->where('id',$id)->update($form_data);
        if($business_data)
        {
        	Session::flash('success','Business Updated successfully');

        }
        else
        {
        	Session::flash('error','Error Occurred While Updating Business List ');
        }*/
        return redirect()->back();
   	}
   	public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Business(es) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','Business(es) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','Business(es) Deleted Successfully');
        }

        return redirect()->back();
    }
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Any Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','Business(es) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Business(es) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Business(es) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
     protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessListingModel->where('id',$id)->first();

        $Business->is_active = "1";

        return $Business->save();
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessListingModel->where('id',$id)->first();

        $Business->is_active = "0";

        return $Business->save();
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
        $Business = $this->BusinessListingModel->where('id',$id);
		return $Business->delete();
    }

}
