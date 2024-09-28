<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Validator;

class StaticPageController extends Controller
{
    //
    public function __construct() {}

    public function index()
    {
        $page_title = 'Manage CMS';
        $page_info = [];

        $res = StaticPageModel::orderBy('id', 'DESC')->get();

        if ($res != false) {
            $page_info = $res->toArray();
        }

        return view('web_admin.static_page.index', compact('page_info', 'page_title'));
    }

    public function create()
    {
        $page_title = 'Create CMS';

        return view('web_admin.static_page.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $form_data = [];

        $arr_rules = [];
        $arr_rules['page_title'] = 'required';
        //$arr_rules['page_desc']='required';
        $arr_rules['meta_title'] = 'required';
        $arr_rules['meta_keyword'] = 'required';
        $arr_rules['meta_desc'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);
        if ($validator->fails()) {
            Session::flash('error', 'Please enter the all details');

            return redirect('/web_admin/static_pages/create')->withErrors($validator)->withInput();
        }
        $form_data = $request->all();
        $arr_data = [];
        $arr_data['page_slug'] = Str::slug($form_data['page_title']);
        $arr_data['is_active'] = 1;
        $arr_data['page_title'] = $form_data['page_title'];
        $arr_data['page_desc'] = $form_data['page_desc'];
        $arr_data['meta_title'] = $form_data['meta_title'];
        $arr_data['meta_keyword'] = $form_data['meta_keyword'];
        $arr_data['meta_desc'] = $form_data['meta_desc'];

        $insert_data = StaticPageModel::create($arr_data);
        if ($insert_data) {
            Session::flash('success', 'Page Created  Successfully');
        } else {
            Session::flash('error', 'Error While Creating Page ');
        }

        return redirect('web_admin/static_pages/create');
    }

    public function edit($enc_id)
    {
        $page_title = 'Edit Page';

        $id = base64_decode($enc_id);

        $arr_data = [];
        $obj_static_page = StaticPageModel::where('id', $id)->first();
        if ($obj_static_page) {
            $data_page = $obj_static_page->toArray();
        }

        return view('web_admin.static_page.edit', compact('page_title', 'data_page', 'enc_id'));

    }

    public function update(Request $request, $enc_id)
    {

        $id = base64_decode($enc_id);

        $form_data = [];

        $arr_rules = [];
        $arr_rules['page_title'] = 'required';
        $arr_rules['page_desc'] = 'required';
        $arr_rules['meta_title'] = 'required';
        $arr_rules['meta_keyword'] = 'required';
        $arr_rules['meta_desc'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);
        if ($validator->fails()) {
            Session::flash('error', 'Please enter the all fields ');

            return redirect('/web_admin/static_pages/edit/'.$enc_id)->withErrors($validator)->withInput();
        }
        $form_data = $request->all();

        $arr_data = [];
        $arr_data['page_title'] = $form_data['page_title'];
        $arr_data['page_desc'] = $form_data['page_desc'];
        $arr_data['meta_title'] = $form_data['meta_title'];
        $arr_data['meta_keyword'] = $form_data['meta_keyword'];
        $arr_data['meta_desc'] = $form_data['meta_desc'];
        $obj_static_page_update = StaticPageModel::where('id', $id)->update($arr_data);
        if ($obj_static_page_update) {
            Session::flash('success', 'Page Updated successfully');

            return redirect()->back();
        } else {
            Session::flash('error', 'Error While Updating Page ');

            return redirect()->back();
        }
    }

    public function toggle_status($enc_id, $action)
    {
        if ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'Page Activated Successfully');
        } elseif ($action == 'block') {
            $this->_block($enc_id);

            Session::flash('success', 'Page Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/static_pages');
    }

    public function delete($enc_id)
    {
        if ($this->_delete($enc_id)) {
            Session::flash('success', 'Page Deleted Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Deleting Page ');
        }

        return redirect()->back();
    }

    public function multi_action(Request $request)
    {
        $arr_data = [];
        $arr_rules['multi_action'] = 'required';
        $arr_rules['checked_record'] = 'required';
        $validator = Validator::make($request->all(), $arr_rules);
        if ($validator->fails()) {
            Session::flash('error', 'Please fill the all fields');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');
        if (is_array($checked_record) && count($checked_record) <= 0) {
            Session::flash('error', 'Please Checked Record To an Action ');
        }
        //print_r($checked_record);exit;
        foreach ($checked_record as $key => $record_id) {
            if ($multi_action == 'activate') {
                $this->_activate($record_id);
                Session::flash('success', 'Page(s) Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'Page(s) Blocked Successfully');
            } elseif ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'Page(s) Deleted Successfully');
            }
        }

        return redirect()->back();
    }

    protected function _activate($enc_id)
    {

        $id = base64_decode($enc_id);

        $static_page = StaticPageModel::where('id', $id)->first();

        $static_page['is_active'] = '1';

        return $static_page->save();
    }

    protected function _block($enc_id)
    {

        $id = base64_decode($enc_id);

        $static_page = StaticPageModel::where('id', $id)->first();

        $static_page['is_active'] = '0';

        return $static_page->save();
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        return StaticPageModel::where('id', $id)->delete();
    }
}
