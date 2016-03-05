<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\ReviewsModel;
use Session;
use Validator;
class ReviewController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index($enc_id)
    {

        $id = base64_decode($enc_id);
    	$obj_reviews = ReviewsModel::with(['business_details'])->where('business_id',$id)->get();
        $arr_reviews = array();

        if($obj_reviews)
        {
            $arr_reviews = $obj_reviews->toArray();
        }
        $page_title = "Business Review :Manage ";
	    return view('web_admin.reviews.index',compact('page_title','arr_reviews','enc_id'));
    }
    public function view($enc_id)
    {
    	$id = base64_decode($enc_id);
        $page_title = " Business Review :View";

        $arr_review_view = array();
        $obj_review_view =ReviewsModel::with(['business_details'])->where('id',$id)->first();

        if($obj_review_view)
        {
            $arr_review_view = $obj_review_view->toArray();
        }
         return view('web_admin.reviews.view',compact('page_title','arr_review_view'));
    }
    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Review(s) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','Review(s) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','Review(s) Deleted Successfully');
        }

        return redirect()->back();
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        return ReviewsModel::where('id',$id)->update(array('is_active'=>1));
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        return ReviewsModel::where('id',$id)->update(array('is_active'=>0));
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);
        return ReviewsModel::where('id',$id)->delete();
    }
     public function delete($enc_id)
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','Review(s) Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Deleting Review(s)');
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
               Session::flash('success','Review(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Review(s) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Review(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
}
