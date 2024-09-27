<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use App\Models\DealcategoryModel;
use App\Models\DealsOffersModel;
use App\Models\DealsSliderImagesModel;
use App\Models\MembershipModel;
use Illuminate\Http\Request;
use Session;
use Validator;

class DealsOffersController extends Controller
{
    public function __construct()
    {
        $this->deal_public_img_path = url('/').'/uploads/deal/';
        $this->deal_image_path = base_path().'/public/uploads/deal/';

        $this->deal_public_upload_img_path = url('/').'/uploads/deal/deal_slider_images/';
        $this->deal_base_upload_img_path = base_path().'/public/uploads/deal/deal_slider_images/';
    }

    public function index($status = 'all')
    {
        $page_title = 'View Deals';
        $deal_public_img_path = '';
        $deal_public_img_path = $this->deal_public_img_path;
        $obj_deal = $arr_deal = [];
        if ($status == 'all') {
            $obj_deal = DealsOffersModel::with(['business_info', 'offers_info'])->orderBy('created_at', 'DESC')->get();
            if ($obj_deal) {
                $arr_deal = $obj_deal->toArray();
            }
        } elseif ($status == 'active') {
            $obj_deal = DealsOffersModel::with(['business_info', 'offers_info'])->where('end_day', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'DESC')->get();
            if ($obj_deal) {
                $arr_deal = $obj_deal->toArray();
            }
        } elseif ($status == 'expired') {
            $obj_deal = DealsOffersModel::with(['business_info', 'offers_info'])->where('end_day', '<', date('Y-m-d').' 00:00:00')->orderBy('created_at', 'DESC')->get();
            if ($obj_deal) {
                $arr_deal = $obj_deal->toArray();
            }
        }

        return view('web_admin.deals_offers.index', compact('page_title', 'arr_deal', 'deal_public_img_path'));

    }

    public function create()
    {
        $page_title = 'Create Deals';
        $obj_main_category = CategoryModel::where('parent', '0')
            ->where('is_active', '1')
            ->where('is_allow_to_add_deal', 1)->get();
        if ($obj_main_category) {
            $arr_main_category = $obj_main_category->toArray();
        }

        return view('web_admin.deals_offers.create', compact('page_title', 'arr_main_category'));
    }

    public function get_business_by_user($user_id)
    {
        $obj_business_listing = BusinessListingModel::where('user_id', $user_id)->with(['membership_plan_details'])->orderBy('created_at', 'DESC')->get();
        if ($obj_business_listing) {
            $all_business_listing = $obj_business_listing->toArray();
        }
        $business_ids = [];
        foreach ($all_business_listing as $key => $business) {
            if (count($business['membership_plan_details']) > 0) {
                foreach ($business['membership_plan_details'] as $key => $membership_data) {
                    if ($membership_data['expire_date'] >= date('Y-m-d').' 00:00:00') {

                        $plan_id = $membership_data['membership_id'];
                        if ($plan_id == 1) {
                            $no_of_deals = 'unlimited';
                        } else {
                            $obj_plan = MembershipModel::where('plan_id', $plan_id)->first();
                            if ($obj_plan) {
                                $arr_plan = $obj_plan->toArray();
                                $no_of_deals = $arr_plan['no_normal_deals'];

                            }
                        }
                        $obj_deal = DealsOffersModel::with('business_info')->where('business_id', $membership_data['business_id'])->get();
                        if ($obj_deal) {
                            $arr_deal = $obj_deal->toArray();
                            $total_deal_count = count($arr_deal);
                        }
                        if ($no_of_deals == 'unlimited' || $no_of_deals > $total_deal_count) {
                            if (! array_key_exists($membership_data['business_id'], $business_ids)) {
                                $business_ids[$membership_data['business_id']] = $membership_data['business_id'];
                            }

                        }
                    }
                }

            }

        }
        $obj_business_listing = BusinessListingModel::with(['membership_plan_details'])->whereIn('id', $business_ids)->orderBy('created_at', 'DESC')->get();
        if ($obj_business_listing) {
            $business_listing = $obj_business_listing->toArray();
        }
        if (count($business_listing) > 0) {
            $arr_response['status'] = 'SUCCESS';
            $arr_response['business_listing'] = $business_listing;

        } else {
            $arr_response['status'] = 'ERROR';
            $arr_response['business_listing'] = [];

        }

        return response()->json($arr_response);
    }

    public function store(Request $request)
    {
        $arr_rule = [];
        $arr_rule['business'] = 'required';
        $arr_rule['deal_main_image'] = 'required';
        $arr_rule['title'] = 'required';
        $arr_rule['name'] = 'required';
        $arr_rule['price'] = 'required';
        $arr_rule['discount_price'] = 'required';
        $arr_rule['deal_type'] = 'required';
        $arr_rule['start_day'] = 'required';
        $arr_rule['end_day'] = 'required';
        $arr_rule['description'] = 'required';
        $arr_rule['things_to_remember'] = 'required';
        $arr_rule['how_to_use'] = 'required';
        $arr_rule['about'] = 'required';
        $arr_rule['facilities'] = 'required';
        $arr_rule['cancellation_policy'] = 'required';
        $arr_rule['is_active'] = 'required';
        $arr_rules['json_location_point'] = 'required';

        $validator = Validator::make($request->all(), $arr_rule);
        if ($validator->fails()) {
            // print_r($validator->errors()->all());exit;

            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('deal_main_image')) {///image loaded/Not
            $arr_image = [];
            $arr_image['deal_main_image'] = $request->file('deal_main_image');
            $arr_image['deal_main_image'] = 'mimes:jpg,jpeg,png';

            $image_validate = Validator::make(['deal_main_image' => $request->file('deal_main_image')],
                ['deal_main_image' => 'mimes:jpg,jpeg,png']);

            if ($request->file('deal_main_image')->isValid()) {
                $image_path = $request->file('deal_main_image')->getClientOriginalName();
                $image_extention = $request->file('deal_main_image')->getClientOriginalExtension();
                $image_name = sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

                $final_image = $request->file('deal_main_image')->move($this->deal_image_path, $image_name);

            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
        $form_data = $request->all();
        // dd($form_data);
        $data_arr['business_id'] = $request->input('business');
        $main_business_cat = $request->input('main_business_cat');
        $sub_category = $request->input('business_cat');
        $data_arr['title'] = $request->input('title');
        $data_arr['name'] = $request->input('name');
        $data_arr['price'] = $request->input('price');
        $data_arr['discount_price'] = $request->input('discount_price');
        $data_arr['deal_type'] = $request->input('deal_type');
        $data_arr['deal_image'] = $image_name;
        $data_arr['start_day'] = date('Y-m-d', strtotime($request->input('start_day')));
        $data_arr['end_day'] = date('Y-m-d', strtotime($request->input('end_day')));
        $data_arr['description'] = $request->input('description');
        $data_arr['things_to_remember'] = $request->input('things_to_remember');
        $data_arr['how_to_use'] = $request->input('how_to_use');
        $data_arr['facilities'] = $request->input('facilities');
        $data_arr['about'] = $request->input('about');
        $data_arr['cancellation_policy'] = $request->input('cancellation_policy');
        $data_arr['json_location_point'] = $request->input('json_location_point');
        $data_arr['is_active'] = $request->input('is_active');
        // dd($data_arr);
        $deal_add = DealsOffersModel::create($data_arr);
        $deal_id = $deal_add->id;

        $files = $request->file('deal_image');
        $file_count = count($files);
        $uploadcount = 0;
        foreach ($files as $file) {
            $destinationPath = $this->deal_base_upload_img_path;
            $fileName = $file->getClientOriginalName();
            $fileExtension = strtolower($file->getClientOriginalExtension());
            if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                $filename = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                $file->move($destinationPath, $filename);
                $arr_insert['image_name'] = $filename;
                $arr_insert['deal_id'] = $deal_id;
                $insert_data1 = DealsSliderImagesModel::create($arr_insert);
                $uploadcount++;
            } else {
                Session::flash('error', 'Invalid file extension');
            }
        }
        foreach ($sub_category as $key => $value) {
            $arr_cat_data['deal_id'] = $deal_id;
            $arr_cat_data['main_cat_id'] = $main_business_cat;
            $arr_cat_data['sub_cat_id'] = $value;
            $insert_data = DealcategoryModel::create($arr_cat_data);

        }
        if ($deal_add) {
            Session::flash('success', 'Deal Created successfully');
        } else {
            Session::flash('error', 'Error Occurred While Creating Deal ');
        }

        return redirect()->back();

    }

    public function edit($enc_id)
    {
        $page_title = 'Edit Deal';
        $deal_base_upload_img_path = '';

        $deal_base_upload_img_path = $this->deal_public_upload_img_path;
        $deal_public_img_path = $this->deal_public_img_path;

        $id = base64_decode($enc_id);
        $obj_deal_arr = DealsOffersModel::with(['business_info', 'deals_slider_images', 'category_info'])->where('id', $id)->first();
        if ($obj_deal_arr) {
            $deal_arr = $obj_deal_arr->toArray();
        }
        $obj_main_category = CategoryModel::where('parent', '0')->where('is_allow_to_add_deal', 1)->get();
        if ($obj_main_category) {
            $arr_main_category = $obj_main_category->toArray();
        }
        $obj_category = CategoryModel::where('parent', '!=', '0')->get();
        if ($obj_category) {
            $arr_category = $obj_category->toArray();
        }

        return view('web_admin.deals_offers.edit', compact('page_title', 'deal_arr', 'deal_public_img_path', 'arr_category', 'arr_main_category', 'deal_base_upload_img_path'));
    }

    public function update(Request $request, $enc_id)
    {

        //  dd($request->all());
        $id = base64_decode($enc_id);

        $arr_rule['title'] = 'required';
        $arr_rule['name'] = 'required';
        $arr_rule['price'] = 'required';
        $arr_rule['discount_price'] = 'required';
        $arr_rule['deal_type'] = 'required';
        $arr_rule['start_day'] = 'required';
        $arr_rule['end_day'] = 'required';
        $arr_rule['description'] = 'required';
        $arr_rule['things_to_remember'] = 'required';
        $arr_rule['how_to_use'] = 'required';
        $arr_rule['about'] = 'required';
        $arr_rule['facilities'] = 'required';
        $arr_rule['cancellation_policy'] = 'required';
        $arr_rule['is_active'] = 'required';
        $arr_rules['json_location_point'] = 'required';

        $validator = Validator::make($request->all(), $arr_rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data = $request->all();
        $image_name = $form_data['old_image'];
        if ($request->hasFile('deal_main_image')) {///image loaded/Not
            $arr_image = [];
            $arr_image['deal_main_image'] = $request->file('deal_main_image');
            $arr_image['deal_main_image'] = 'mimes:jpg,jpeg,png';

            $image_validate = Validator::make(['deal_main_image' => $request->file('deal_main_image')],
                ['deal_main_image' => 'mimes:jpg,jpeg,png']);

            if ($request->file('deal_main_image')->isValid()) {
                $image_path = $request->file('deal_main_image')->getClientOriginalName();
                $image_extention = $request->file('deal_main_image')->getClientOriginalExtension();
                $image_name = sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

                $final_image = $request->file('deal_main_image')->move($this->deal_image_path, $image_name);

                $get_path = $this->deal_image_path.$form_data['old_image'];
                $unlink_deal_image = false;
                if (is_readable($get_path)) {
                    $unlink_deal_image = unlink($get_path);

                }
            } else {
                return redirect()->back();
            }
        }
        $data_arr['title'] = $request->input('title');
        $data_arr['name'] = $request->input('name');
        $main_business_cat = $request->input('main_business_cat');
        $data_arr['price'] = $request->input('price');
        $data_arr['discount_price'] = $request->input('discount_price');
        $data_arr['deal_type'] = $request->input('deal_type');
        $data_arr['deal_image'] = $image_name;
        $data_arr['start_day'] = date('Y-m-d', strtotime($request->input('start_day')));
        $data_arr['end_day'] = date('Y-m-d', strtotime($request->input('end_day')));
        $data_arr['description'] = $request->input('description');
        $data_arr['things_to_remember'] = $request->input('things_to_remember');
        $data_arr['how_to_use'] = $request->input('how_to_use');
        $data_arr['facilities'] = $request->input('facilities');
        $data_arr['about'] = $request->input('about');
        $data_arr['cancellation_policy'] = $request->input('cancellation_policy');
        $data_arr['is_active'] = $request->input('is_active');
        $data_arr['json_location_point'] = $request->input('json_location_point');
        $deal_update = DealsOffersModel::where('id', $id)->update($data_arr);

        $files = $request->file('deal_image');

        $file_count = count($files);
        if ($file_count > 0) {
            $uploadcount = 0;
            foreach ($files as $file) {
                if ($file != null) {
                    $destinationPath = $this->deal_base_upload_img_path;
                    $fileName = $file->getClientOriginalName();
                    $fileExtension = strtolower($file->getClientOriginalExtension());

                    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                        $filename = sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                        $file->move($destinationPath, $filename);
                        $arr_insert['image_name'] = $filename;
                        $arr_insert['deal_id'] = $id;
                        $insert_data1 = DealsSliderImagesModel::create($arr_insert);
                        $uploadcount++;
                    } else {
                        Session::flash('error', 'Invalid file extension');
                    }
                }
            }
        }

        $deal_sub_cat = $request->input('business_cat');
        if (count($deal_sub_cat) > 0 && $deal_sub_cat != null) {

            $deal_category = DealcategoryModel::where('deal_id', $id);
            $res = $deal_category->delete();
            foreach ($deal_sub_cat as $key => $value) {
                $arr_cat_data['deal_id'] = $id;
                $arr_cat_data['main_cat_id'] = $main_business_cat;
                $arr_cat_data['sub_cat_id'] = $value;
                $insert_data = DealcategoryModel::create($arr_cat_data);
            }
        }
        if ($deal_update) {
            Session::flash('success', 'Deal Updated Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Updating Deal');
        }

        return redirect()->back();
    }

    public function delete_gallery(Request $request)
    {
        $deal_base_upload_img_path = $this->deal_base_upload_img_path;
        $image_name = $request->input('image_name');
        $id = $request->input('id');
        $Business = DealsSliderImagesModel::where('id', $id);
        $res = $Business->delete();
        if ($res) {
            $deal_base_upload_img_path.$image_name;
            if (unlink($deal_base_upload_img_path.$image_name)) {
                echo 'done';
            }
        }

    }

    public function toggle_status($enc_id, $action)////$enc_id = Deal id
    {
        if ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'Deal(s) Activated Successfully');
        } elseif ($action == 'block') {
            $this->_block($enc_id);

            Session::flash('success', 'Deal(s) Blocked Successfully');
        } elseif ($action == 'delete') {
            $this->_delete($enc_id);

            Session::flash('success', 'Deal(s) Deleted Successfully');
        }

        return redirect()->back();
    }

    public function delete($enc_id)////$enc_id = Deal id
    {
        if ($this->_delete($enc_id)) {
            Session::flash('success', 'Deal(s) Deleted Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Deleting Deal(s)');
        }

        return redirect()->back();
    }

    protected function _activate($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

        return DealsOffersModel::where('id', $id)->update(['is_active' => 1]);
    }

    protected function _block($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

        return DealsOffersModel::where('id', $id)->update(['is_active' => 0]);
    }

    protected function _delete($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

        $arr_deal = DealsOffersModel::select('id', 'deal_image')->where('id', $id)->first()->toArray();

        $get_path = $this->deal_image_path.$arr_deal['deal_image'];

        $unlink_deal_image = false;
        if (is_readable($get_path)) {
            $unlink_deal_image = unlink($get_path);  //////////////////Unlink Deal image

            if ($unlink_deal_image == true) {
                return DealsOffersModel::where('id', $id)->delete(); //////////Soft Delete Deal
            }
        }

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
                Session::flash('success', 'Deal(s) Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'Deal(s) Blocked Successfully');
            } elseif ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'Deal(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }

    public function export_excel($format = 'csv')//export excel file
    {
        if ($format == 'csv') {
            $arr_deal_list = [];
            $obj_deal_list = DealsOffersModel::with(['business_info', 'offers_info'])->get();
            //dd($obj_business_list);

            if ($obj_deal_list) {
                $arr_deal_list = $obj_deal_list->toArray();

                \Excel::create('DEALS_LIST-'.date('Ymd').uniqid(), function ($excel) use ($arr_deal_list) {
                    $excel->sheet('Deal_list', function ($sheet) use ($arr_deal_list) {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, [
                            'Sr.No.', 'Business Name', 'Business Public Id', 'Deal Title', 'Discount', 'Start Date ', 'End Date',
                        ]);

                        if (count($arr_deal_list) > 0) {
                            $arr_tmp = [];
                            foreach ($arr_deal_list as $key => $deal_list) {
                                $arr_tmp[$key][] = $key + 1;
                                $arr_tmp[$key][] = $deal_list['business_info']['business_name'];
                                $arr_tmp[$key][] = $deal_list['business_info']['busiess_ref_public_id'];
                                $arr_tmp[$key][] = $deal_list['title'];
                                $arr_tmp[$key][] = $deal_list['discount_price'];
                                $arr_tmp[$key][] = date('d-m-Y', strtotime($deal_list['start_day']));
                                $arr_tmp[$key][] = date('d-m-Y', strtotime($deal_list['end_day']));
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }
}
