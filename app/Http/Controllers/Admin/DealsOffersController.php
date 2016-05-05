<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealsOffersModel;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;


class DealsOffersController extends Controller
{
	public function __construct()
	{
		 $this->deal_public_img_path = url('/')."/uploads/deal/";
    	 $this->deal_image_path = base_path().'/public/uploads/deal/';
    }

   
    public function index($status="all")
    {
    	$deal_public_img_path='';
    	$deal_public_img_path = $this->deal_public_img_path;
    	$obj_deal= $arr_deal=[];
    	if($status== 'all')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	else if($status== 'active')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	else if($status== 'expired')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->where('end_day', '<', date('Y-m-d').' 00:00:00')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	return view('web_admin.deals_offers.index',compact('page_title','arr_deal','deal_public_img_path'));

    }
    public function create()
    {
    	$page_title="Create Deals";
    	$obj_main_category = CategoryModel::where('parent','0')->where('is_allow_to_add_deal',1)->get();
    	if($obj_main_category)
        {
            $arr_main_category = $obj_main_category->toArray();
        }
       
       
         return view('web_admin.deals_offers.create',compact('page_title','arr_main_category'));
    }

    public function get_business_by_user($user_id)
    {
    	 $obj_business_listing = BusinessListingModel::where('user_id',$user_id)->with(['membership_plan_details'])->orderBy('created_at','DESC')->get();
        if($obj_business_listing)
        {
            $all_business_listing = $obj_business_listing->toArray();
        }
        //echo sizeof($all_business_listing);
        //dd($all_business_listing);
        $business_ids=[];
        foreach ($all_business_listing as $key => $business) {
        	if(sizeof($business['membership_plan_details'])>0)
        	{
        		foreach ($business['membership_plan_details'] as $key => $membership_data) {
        			if($membership_data['expire_date'] >=date('Y-m-d').' 00:00:00')
        			{
        				if(!array_key_exists($membership_data['business_id'],$business_ids))
        				{
        				  $business_ids[$membership_data['business_id']]=$membership_data['business_id'];
        			    }
        			}
        		}
        		
        	}
        	
        }
         $obj_business_listing = BusinessListingModel::with(['membership_plan_details'])->whereIn('id',$business_ids)->orderBy('created_at','DESC')->get();
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }
         if(sizeof($business_listing)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['business_listing'] = $business_listing;
           

        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['business_listing'] = array();
            
        }
        return response()->json($arr_response);
    }

    public function store(Request $request)
    {
    	$arr_rule	= array();
    	$arr_rule['business']='required';

    	$arr_rule['deal_image']='required';

    	$arr_rule['title']='required';
    	$arr_rule['name']='required';
    	$arr_rule['price']='required';
    	$arr_rule['discount_price']='required';
    	$arr_rule['deal_type']='required';
    	$arr_rule['start_day']='required';
    	$arr_rule['end_day']='required';

    	$arr_rule['description']='required';
    	$arr_rule['things_to_remember']='required';
    	$arr_rule['how_to_use']='required';
    	$arr_rule['facilities']='required';
    	$arr_rule['cancellation_policy']='required';
    	$arr_rule['description']='required';
    	
    	
    	
    	$arr_rule['is_active']='required';

    	$validator=Validator::make($request->all(),$arr_rule);
    	if($validator->fails())
    	{
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	if($request->hasFile('deal_image'))///image loaded/Not
	    	{
	    		$arr_image				 =	array();
	    		$arr_image['deal_image'] = $request->file('deal_image');
	    		$arr_image['deal_image'] = 'mimes:jpg,jpeg,png';;

	    		$image_validate = Validator::make(array('deal_image'=>$request->file('deal_image')),
	    										  array('deal_image'=>'mimes:jpg,jpeg,png'));


	    		if($request->file('deal_image')->isValid() && $image_validate->passes())
	    		{
	    			$image_path 		=	$request->file('deal_image')->getClientOriginalName();
	    			$image_extention	=	$request->file('deal_image')->getClientOriginalExtension();
	    			$image_name			=	sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

	    			$final_image = $request->file('deal_image')->move($this->deal_image_path, $image_name);

	    		}
	    		else
	    		{
	    			return redirect()->back();
	    		}
	    	}
	    	else
	    	{
	    		return redirect()->back();
	    	}
	     $form_data	= $request->all();
	     dd($form_data);
        //$data_arr['business_id']=$form_data['business_hide_id'];






    }


}
