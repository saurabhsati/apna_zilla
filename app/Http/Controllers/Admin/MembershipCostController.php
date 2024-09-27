<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\MemberCostModel;
use App\Models\CategoryModel;
use Validator;
use Session;
class MembershipCostController extends Controller
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
        $page_title = "Manage Membership Cost";

        $arr_membership_cost = array();

        $obj_membership_cost = MemberCostModel::orderBy('id','DESC')->with(['category'])->get();

        if($obj_membership_cost!=FALSE)
        {
            $arr_membership_cost = $obj_membership_cost->toArray();
        }

        //dd($arr_membership_cost);
        return view('web_admin.membership_cost.index',compact('page_title','arr_membership_cost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Add Membership Cost";
        $obj_category = CategoryModel::where('parent','0')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}
 		//dd($arr_category);
        return view('web_admin.membership_cost.create',compact('page_title','arr_category'));
    }
    public function store(Request $request)
    {
    	$arr_rules=array();
    	$arr_rules['category_id']='required';
    	$arr_rules['premium_cost']='required';
    	$arr_rules['gold_cost']='required';
    	$arr_rules['basic_cost']='required';
    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/business_listing/create')->withErrors($validator)->withInput();
        }
        $arr_data['category_id']=$request->input('category_id');
        $arr_data['premium_cost']=$request->input('premium_cost');
        $arr_data['gold_cost']=$request->input('gold_cost');
        $arr_data['basic_cost']=$request->input('basic_cost');

        $category_id= $arr_data['category_id'];
        $obj_chk_category = MemberCostModel::where('category_id',$category_id)->first();
        $chk_category=array();

        if($obj_chk_category)
 		{
 			$chk_category = $obj_chk_category->toArray();
 		}
 		if(sizeof($chk_category)>0)
 		{
 			 Session::flash('error','Cost already added for this category');
 		}
        else
       	{
       		$cost_added = MemberCostModel::create($arr_data);

            if($cost_added)
            {
                Session::flash('success','Membership Cost Added successfully');
            }
        	else
            {
                Session::flash('error','Error Occurred While Adding Membership Cost');
            }

         }
         return redirect()->back();
    }
     public function edit($enc_id)
    {
        $page_title = "Edit Membership Cost ";

        $id = base64_decode($enc_id);

        $arr_cost_data = array();
        $obj_cost_data = MemberCostModel::with(['category'])->where('id',$id)->first();
        if($obj_cost_data)
        {
            $arr_cost_data = $obj_cost_data->toArray();
        }

        $obj_category = CategoryModel::where('parent','0')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}
 		//dd($arr_cost_data);
        return view('web_admin.membership_cost.edit',compact('page_title','arr_cost_data','arr_category','enc_id'));
    }
    public function update(Request $request ,$enc_id)
    {
    	$arr_rules=array();
    	 $id = base64_decode($enc_id);
    	$arr_rules['premium_cost']='required';
    	$arr_rules['gold_cost']='required';
    	$arr_rules['basic_cost']='required';
    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/business_listing/create')->withErrors($validator)->withInput();
        }
        $arr_data['premium_cost']=$request->input('premium_cost');
        $arr_data['gold_cost']=$request->input('gold_cost');
        $arr_data['basic_cost']=$request->input('basic_cost');
        $update = MemberCostModel::where('id',$id)->update($arr_data);
        if($update)
 		{
  				Session::flash('success','Membership Cost Updated successfully');
        }
        else
        {
                Session::flash('error','Error Occurred While Updating Membership Cost');
        }
        return redirect()->back();
    }
}
