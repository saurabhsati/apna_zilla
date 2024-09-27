<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealsOffersModel;
use App\Models\OffersModel;
use Illuminate\Http\Request;
use Session;
use Validator;

class OffersController extends Controller
{
    public function index($enc_id)
    {
        $page_title = ' View Offers';

        $id = base64_decode($enc_id);
        $obj_offers = OffersModel::with('deal_info')->where('deal_id', $id)->get();
        if ($obj_offers) {
            $arr_offers = $obj_offers->toArray();
        }
        $obj_deal = DealsOffersModel::where('id', $id)->first();
        if ($obj_deal) {
            $arr_deal = $obj_deal->toArray();
        }

        //dd($arr_offers);
        return view('web_admin.offers.index', compact('page_title', 'arr_offers', 'arr_deal'));

    }

    public function create($enc_id)
    {
        $page_title = ' Create Offers';
        $id = base64_decode($enc_id);
        $obj_deal = DealsOffersModel::where('id', $id)->first();
        if ($obj_deal) {
            $arr_deal = $obj_deal->toArray();
        }

        return view('web_admin.offers.create', compact('page_title', 'arr_deal'));

    }

    public function store(Request $request)
    {
        $arr_rule = [];
        $arr_rule['deal_id'] = 'required';
        $arr_rule['title'] = 'required';
        $arr_rule['description'] = 'required';
        $arr_rule['main_price'] = 'required';
        $arr_rule['discount'] = 'required';
        $arr_rule['discounted_price'] = 'required';
        $arr_rule['limit'] = 'required';
        $arr_rule['valid_from'] = 'required';
        $arr_rule['valid_until'] = 'required';
        $arr_rule['is_active'] = 'required';

        $validator = Validator::make($request->all(), $arr_rule);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data = $request->all();
        $data_arr['deal_id'] = $form_data['deal_id'];
        $data_arr['title'] = $form_data['title'];
        $data_arr['description'] = $form_data['description'];
        $data_arr['main_price'] = $form_data['main_price'];
        $data_arr['discount'] = $form_data['discount'];
        $data_arr['name'] = $form_data['name'];
        $data_arr['discounted_price'] = $form_data['discounted_price'];
        $data_arr['limit'] = $form_data['limit'];
        $data_arr['is_active'] = $form_data['is_active'];
        $data_arr['valid_from'] = date('Y-m-d', strtotime($form_data['valid_from']));
        $data_arr['valid_until'] = date('Y-m-d', strtotime($form_data['valid_until']));

        $offers_add = OffersModel::create($data_arr);
        if ($offers_add) {
            Session::flash('success', 'Offer Created Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Creating Offer');
        }

        return redirect()->back();
    }

    public function show($enc_id)
    {
        $page_title = ' Show Offers';
        $id = base64_decode($enc_id);
        $obj_offers = OffersModel::with('deal_info')->where('id', $id)->get();
        if ($obj_offers) {
            $arr_offers = $obj_offers->toArray();
        }

        // dd($arr_offers);
        return view('web_admin.offers.show', compact('page_title', 'arr_offers'));
    }

    public function edit($enc_id)
    {
        $page_title = ' Edit Offers';
        $id = base64_decode($enc_id);
        $obj_offers = OffersModel::with('deal_info')->where('id', $id)->get();
        if ($obj_offers) {
            $arr_offers = $obj_offers->toArray();
        }

        // dd($arr_offers);
        return view('web_admin.offers.edit', compact('page_title', 'arr_offers'));
    }

    public function update(Request $request, $enc_id)
    {
        $arr_rule = [];
        $id = base64_decode($enc_id);
        $arr_rule['title'] = 'required';
        $arr_rule['description'] = 'required';
        $arr_rule['main_price'] = 'required';
        $arr_rule['discount'] = 'required';
        $arr_rule['discounted_price'] = 'required';
        $arr_rule['limit'] = 'required';
        $arr_rule['valid_from'] = 'required';
        $arr_rule['valid_until'] = 'required';
        $arr_rule['is_active'] = 'required';

        $validator = Validator::make($request->all(), $arr_rule);
        if ($validator->fails()) {
            // print_r($validator->errors()->all());exit;
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data = $request->all();
        $data_arr['deal_id'] = $form_data['deal_id'];
        $data_arr['title'] = $form_data['title'];
        $data_arr['name'] = $form_data['name'];
        $data_arr['description'] = $form_data['description'];
        $data_arr['main_price'] = $form_data['main_price'];
        $data_arr['discount'] = $form_data['discount'];
        $data_arr['discounted_price'] = $form_data['discounted_price'];
        $data_arr['limit'] = $form_data['limit'];
        $data_arr['is_active'] = $form_data['is_active'];

        $data_arr['valid_from'] = date('Y-m-d', strtotime($form_data['valid_from']));
        $data_arr['valid_until'] = date('Y-m-d', strtotime($form_data['valid_until']));

        $offers_update = OffersModel::where('id', $id)->update($data_arr);
        if ($offers_update) {
            Session::flash('success', 'Offers Updated Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Updating Offers');
        }

        return redirect()->back();
    }

    public function toggle_status($enc_id, $action)////$enc_id = Deal id
    {
        if ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'Offers(s) Activated Successfully');
        } elseif ($action == 'block') {
            $this->_block($enc_id);

            Session::flash('success', 'Offers(s) Blocked Successfully');
        } elseif ($action == 'delete') {
            $this->_delete($enc_id);

            Session::flash('success', 'Offers(s) Deleted Successfully');
        }

        return redirect()->back();
    }

    public function delete($enc_id)////$enc_id = Offers id
    {
        if ($this->_delete($enc_id)) {
            Session::flash('success', 'Offers(s) Deleted Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Deleting Offers(s)');
        }

        return redirect()->back();
    }

    protected function _activate($enc_id)////$enc_id = Offers id
    {
        $id = base64_decode($enc_id);

        return OffersModel::where('id', $id)->update(['is_active' => 1]);
    }

    protected function _block($enc_id)////$enc_id = Offers id
    {
        $id = base64_decode($enc_id);

        return OffersModel::where('id', $id)->update(['is_active' => 0]);
    }

    protected function _delete($enc_id)////$enc_id = Offers id
    {
        $id = base64_decode($enc_id);

        return OffersModel::where('id', $id)->delete(); //////////Soft Delete Deal

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
            if ($multi_action == 'activate') {
                $this->_activate($record_id);
                Session::flash('success', 'Offer(s) Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'Offer(s) Blocked Successfully');
            } elseif ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'Offer(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
}
