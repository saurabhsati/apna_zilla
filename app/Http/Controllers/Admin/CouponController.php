<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Validator;

class CouponController extends Controller
{
    /*
    | Constructor : creates instances of model class
    |               & handles the admin authantication
    | auther :
    | Date   :
    | @return \Illuminate\Http\Response
    */
    public function __construct()
    {
        $this->arr_view_data = [];
        $this->module_url_path = url('web_admin/coupons');
        $this->module_title = 'Coupons';
        $this->module_view_folder = 'web_admin.coupon';

    }
    /*
    | Index  : Display listing of Coupon
    | auther : gayatri
    | Date   : 21-05-2016
    | @return \Illuminate\Http\Response
    */

    public function index()
    {
        $arr_attractions = [];

        $obj_coupon_res = CouponModel::orderBy('id', 'desc')->get();

        if ($obj_coupon_res) {
            $arr_coupon = $obj_coupon_res->toArray();
        }
        //  dd($arr_coupon);
        $this->arr_view_data['page_title'] = Str::singular($this->module_title);
        $this->arr_view_data['module_title'] = Str::plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_coupon'] = $arr_coupon;

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }

    public function create()
    {
        $page_title = 'Create Coupon';
        $this->arr_view_data['page_title'] = Str::singular($this->module_title);
        $this->arr_view_data['module_title'] = Str::plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    public function store(Request $request)
    {
        $form_data = [];

        $form_data = $request->all();

        $arr_rules['coupon_code'] = 'required';
        $arr_rules['discount_type'] = 'required';
        $arr_rules['discount'] = 'required';
        $arr_rules['start_date'] = 'required';
        $arr_rules['end_date'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            // print_r($validator->errors()->all());exit;

            Session::flash('error', 'Please Fill All The Required Fields');

            return redirect('web_admin/coupons/create/')->withErrors($validator)->withInput();
        }

        $coupon_code = $form_data['coupon_code'];
        $discount_type = $form_data['discount_type'];
        $discount = $form_data['discount'];
        $start_date = $form_data['start_date'];
        $end_date = $form_data['end_date'];

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        /* Duplication Check */

        $obj_is_duplicate = CouponModel::where('coupon_code', $coupon_code)
            ->where('type', $discount_type)
            ->where('discount', $discount)
            ->where('start_date', $start_date)
            ->where('end_date', $end_date)
            ->get();

        $is_duplicate = [];
        if ($obj_is_duplicate) {
            $is_duplicate = $obj_is_duplicate->toArray();
        }
        if (count($is_duplicate) > 0) {

            Session::flash('error', 'Coupon Code with Given Details Already Exists');

            return redirect('/web_admin/coupons/create/');
        }

        $array_create = [
            'coupon_code' => $coupon_code,
            'type' => $discount_type,
            'discount' => $discount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        $coupon = CouponModel::create($array_create);
        if ($coupon) {
            Session::flash('success', 'Coupon Created Successfully');
        } else {
            Session::flash('error', 'Problem Occured, While Creating Coupon ');
        }

        return redirect()->back();
    }

    public function delete($coupon_id)
    {
        if ($this->_delete($coupon_id)) {
            Session::flash('success', 'Coupon Deleted Successfully');
        } else {
            Session::flash('error', 'Problem Occured While Deleting Coupon');
        }

        return redirect()->back();
    }

    public function multi_action(Request $request)
    {
        $arr_rules = [];
        $arr_rules['multi_action'] = 'required';
        $arr_rules['checked_record'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            Session::flash('error', 'Please Select Any Record(s)');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if (is_array($checked_record) && count($checked_record) <= 0) {
            Session::flash('error', 'Problem Occured, While Doing Multi Action');

            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id) {
            if ($multi_action == 'delete') {
                $this->_delete($record_id);

                Session::flash('success', 'Coupon(s) Deleted Successfully');
            }
        }

        return redirect()->back();
    }

    protected function _delete($coupon_id)
    {
        $id = base64_decode($coupon_id);
        $coupon = CouponModel::where('id', $id)->first();

        return $coupon->delete();
    }

    public function edit($coupon_id)
    {
        $id = base64_decode($coupon_id);

        $page_title = 'Edit Coupon';

        $arr_coupon = [];
        $obj_coupon = CouponModel::where('id', $id)->first();
        if ($obj_coupon) {
            $arr_coupon = $obj_coupon->toArray();
        }

        $page_title = 'Edit Coupon';
        $this->arr_view_data['page_title'] = Str::singular($this->module_title);
        $this->arr_view_data['module_title'] = Str::plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['coupon_id'] = $coupon_id;
        $this->arr_view_data['arr_coupon'] = $arr_coupon;
        if ($arr_coupon) {
            return view($this->module_view_folder.'.edit', $this->arr_view_data);
        } else {
            return redirect('/web_admin/coupons');
        }

        return view($this->module_view_folder.'.edit', $this->arr_view_data);
    }

    public function update(Request $request, $coupon_id)
    {
        $id = base64_decode($coupon_id);

        $form_data = [];

        $form_data = $request->all();

        $arr_rules['coupon_code'] = 'required';
        $arr_rules['discount_type'] = 'required';
        $arr_rules['discount'] = 'required';
        $arr_rules['start_date'] = 'required';
        $arr_rules['end_date'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            Session::flash('error', 'Please Fill All The English Language Fields');

            return redirect('/web_admin/coupons/create/')->withErrors($validator)->withInput();
        }
        $coupon_code = $form_data['coupon_code'];
        $discount_type = $form_data['discount_type'];
        $discount = $form_data['discount'];
        $start_date = $form_data['start_date'];
        $end_date = $form_data['end_date'];

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        $array_update = [
            'coupon_code' => $coupon_code,
            'type' => $discount_type,
            'discount' => $discount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        $coupon = CouponModel::where('id', $id);
        if ($coupon) {
            $status = $coupon->update($array_update);
            if ($status) {
                Session::flash('success', 'Coupon Updated Successfully');
            } else {
                Session::flash('error', 'Problem Occured, While Updating Coupon ');
            }
        } else {
            Session::flash('error', 'Problem Occured, While Updating Coupon ');
        }

        return redirect('/web_admin/coupons/edit/'.$coupon_id);
    }
}
