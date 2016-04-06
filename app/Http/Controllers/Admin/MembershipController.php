<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use Validator;
use Session;

class MembershipController extends Controller
{


    public function __construct()
    {
        $arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Manage Membership Plans";

        $arr_ad_membership_plan = array();

        $arr_obj_ad_membership_plan = MembershipModel::get();

        if($arr_obj_ad_membership_plan!=FALSE)
        {
            $arr_ad_membership_plan = $arr_obj_ad_membership_plan->toArray();
        }

        return view('web_admin.membership_plan.index',compact('page_title','arr_ad_membership_plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Create Ad Plan";

        return view('web_admin.membership_plan.create',compact('page_title','arr_plan_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($enc_id)
    {
        $page_title = "Edit Membership Plan";

        $plan_id = base64_decode($enc_id);

        $arr_plan_data = array();
        $obj_plan_data = MembershipModel::where('plan_id',$plan_id)->first();

        if($obj_plan_data!=FALSE)
        {
            $arr_plan_data = $obj_plan_data->toArray();
        }
        else
        {
            return redirect()->back();
        }
       // dd( $arr_plan_data);
        return view('web_admin.membership_plan.edit',compact('page_title','arr_plan_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enc_id)
    {
        $plan_id = base64_decode($enc_id);

        $arr_rules = array();
        $arr_rules['description']       = "required";
        //$arr_rules['price']             = "required";
        $arr_rules['validity']          = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data = array();

        $arr_data['description']        = $request->input('description');
       // $arr_data['price']              = abs($request->input('price'));
        $arr_data['validity']           = abs($request->input('validity'));

        $unlimited_normal_deal   = $request->input('unlimited_normal_deal');
        $unlimited_instant_deal  = $request->input('unlimited_instant_deal');
        $unlimited_featured_deal = $request->input('unlimited_featured_deal');

        $arr_data['no_normal_deals']  = (isset($unlimited_normal_deal) && $unlimited_normal_deal=='on'?'Unlimited':$request->input('no_normal_deal'));
        $arr_data['no_instant_deals'] = (isset($unlimited_instant_deal) && $unlimited_instant_deal=='on'?'Unlimited':$request->input('no_instant_deal'));
        $arr_data['no_featured_deals']= (isset($unlimited_featured_deal) && $unlimited_featured_deal=='on'?'Unlimited':$request->input('no_featured_deal'));

        $status = MembershipModel::where('plan_id',$plan_id)->update($arr_data);

        if($status)
        {
            Session::flash('success','Membership Plan Updated Successfully');
        }
        else
        {
            Session::flash('error','PRoblem Occurred, While Updating Membership Plan');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function entity_attribute()
    {
        $page_title = "Create Ad Plan";

        return view('web_admin.ad_plan.create',compact('page_title','arr_plan_data'));
    }
}
