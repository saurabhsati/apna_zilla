<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettingModel;
use Illuminate\Http\Request;
use Session;
use Validator;

class SiteSettingController extends Controller
{
    public function __construct()
    {
        $arr_except_auth_method = [];
        $this->middleware(\App\Http\Middleware\SentinelCheck::class, ['except' => $arr_except_auth_method]);
    }

    public function index()
    {
        $page_title = 'Site Setting : Manage';

        $arr_site_setting = [];
        $obj_site_setting = SiteSettingModel::first();

        if ($obj_site_setting) {
            $arr_site_setting = $obj_site_setting->toArray();
        }

        return view('web_admin.site_setting.index', compact('page_title', 'arr_site_setting'));
    }

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules = [];
        $arr_rules['website_name'] = 'required';
        $arr_rules['address'] = 'required';
        $arr_rules['contact_number'] = 'required';
        $arr_rules['phone_number'] = 'required';
        $arr_rules['map_iframe'] = 'required';
        $arr_rules['email'] = 'required';
        $arr_rules['meta_keyword'] = 'required';
        $arr_rules['meta_desc'] = 'required';
        $arr_rules['facebook_url'] = 'required';
        $arr_rules['twitter_url'] = 'required';
        $arr_rules['youtube_url'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $arr_data = [];
        $arr_data['site_name'] = $request->input('website_name');
        $arr_data['site_address'] = $request->input('address');
        $arr_data['site_contact_number'] = $request->input('contact_number');
        $arr_data['phone_number'] = $request->input('phone_number');
        $arr_data['map_iframe'] = $request->input('map_iframe');
        $arr_data['meta_keyword'] = $request->input('meta_keyword');
        $arr_data['meta_desc'] = $request->input('meta_desc');
        $arr_data['site_email_address'] = $request->input('email');
        $arr_data['site_status'] = $request->input('site_status');
        $arr_data['fb_url'] = $request->input('facebook_url');
        $arr_data['twitter_url'] = $request->input('twitter_url');
        $arr_data['youtube_url'] = $request->input('youtube_url');
        $site_setting_update = SiteSettingModel::where('site_settting_id', $id)->update($arr_data);

        if ($site_setting_update) {
            Session::flash('success', 'Website-Settings Updated Successfully');
        } else {
            Session::flash('error', 'Error While Updating Website-Settings');
        }

        return redirect('web_admin/site_settings');
    }
}
