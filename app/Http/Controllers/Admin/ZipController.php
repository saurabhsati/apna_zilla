<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ZipModel;
use Validator;
use Session;
class ZipController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index()
    {
    	 $page_title = "Manage Zipcode";
        $arr_zipcode = array();

        $obj_zipcode_res = ZipModel::get();

        if($obj_zipcode_res)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }
        return view('web_admin.zipcode.index',compact('page_title','arr_zipcode'));
    }
    public function create()
    {
        $page_title = "Create Zipcode";
        return view('web_admin.zipcode.create',compact('page_title'));
    }
    public function store(Request $request)
    {

    }
    public function show($enc_id)
    {
        $page_title =   "Show ZipCode";
        $id=base64_decode($enc_id);
        $arr_country    =   array();
        $obj_zipcode_arr    =ZipModel::where('id',$id)->get();
        if($obj_zipcode_arr)
        {
            $arr_zipcode= $obj_zipcode_arr->toArray();
        }
       return view('web_admin.zipcode.show',compact('page_title','arr_zipcode'));


    }
    public function edit($enc_id)
    {
        $page_title =   "Edit ZipCode";
        $id=base64_decode($enc_id);
        $arr_country    =   array();
        $obj_zipcode_arr    =ZipModel::where('id',$id)->get();
        if($obj_zipcode_arr)
        {
            $arr_zipcode= $obj_zipcode_arr->toArray();
        }
       return view('web_admin.zipcode.edit',compact('page_title','arr_zipcode'));
    }
    public function update(Request $request ,$enc_id)
    {
        $id         =   base64_decode($enc_id);
        $form_data  =   array();

        $arr_rules['zipcode']   =   'required';

        $validator=Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error','Please fill the fields.');
            return back()->withErrors($validator)->withInput();
        }
        $form_data['zipcode']      =   $request->input('zipcode');
        $form_data['latitude']     =   $request->input('latitude');
        $form_data['longitude']    =   $request->input('longitude');
        $result=ZipModel::where('id',$id)->update($form_data);
        if($result)
        {
            Session::flash('success','ZipCode Updated Successfully ..!');
            return redirect()->back();
        }
        else
        {
            Session::flash('error','Error Occurred While Updating ZipCode !');
            return redirect()->back();
        }

    }
    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','ZipCode(s) Activated Successfully');
        }
        elseif($action=="deactivate")
        {
            $this->_block($enc_id);

            Session::flash('success','ZipCode(s) Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/zipcode');
    }

    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/zipcode')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect('/web_admin/zipcode');

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','ZipCode(s) Deleted Successfully');
            }
            elseif($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','ZipCode(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','ZipCode(s) Blocked Successfully');
            }
        }

        return redirect('/web_admin/zipcode');
    }

    public function delete($enc_id)
    {
        $this->_delete($enc_id);
        Session::flash('success','ZipCode(s) Deleted Successfully');
        return redirect()->back();
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

         return ZipModel::where('id',$id)
                  ->update(['is_active'=>'1']);
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        return ZipModel::where('id',$id)
                  ->update(['is_active'=>'0']);
    }

    protected function _delete($enc_id)
    {
         $id = base64_decode($enc_id);
        return ZipModel::where('id',$id)
                  ->delete();
    }

}
