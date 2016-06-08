<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use App\Models\MemberCostModel;


class MembershipPlanController extends Controller
{
	public function __construct()
	{
       $json                           = array();
    }
    public function assign_membership(Request $request)
    {
    	    $category_id               = $request->input('main_category_id');
			$arr_data['business_id ']  = $request->input('business_id');
			$arr_data['business_name'] = $request->input('business_name');
			$arr_data['user_id']       = $request->input('user_id');
			$arr_data['category_id']   = $category_id;
			$arr_cost_data             = $arr_membership_plan = array();

	        $obj_cost_data = MemberCostModel::where('category_id',$category_id)->first();
	        if($obj_cost_data)
	        {
	            $arr_cost_data = $obj_cost_data->toArray();
	        }
	        if(sizeof($arr_cost_data)>0)
	        {
	            $obj_membership_plan = MembershipModel::orderBy('plan_id','DESC')->get();
	            if($obj_membership_plan)
	            {
	                $arr_membership_plan = $obj_membership_plan->toArray();
	            }
	            foreach ($arr_membership_plan as $key => $membership_plan)
	            {
	                if($membership_plan['title']=='Premium')
	                {
	                    $arr_membership_plan[$key]['price']=$arr_cost_data['premium_cost'];
	                }
	                if($membership_plan['title']=='Gold')
	                {
	                    $arr_membership_plan[$key]['price']=$arr_cost_data['gold_cost'];
	                }
	                if($membership_plan['title']=='Basic')
	                {
	                    $arr_membership_plan[$key]['price']=$arr_cost_data['basic_cost'];
	                }


	            }

	            
	           
	        }

           if(isset($arr_membership_plan) && sizeof($arr_membership_plan)>0)
           {
	           	foreach ($arr_membership_plan as $key => $plan) 
	            {
	            	 $arr_data[$key]['plan_id']         = $plan['plan_id'];
	            	 $arr_data[$key]['title']           = $plan['title'];
	            	 $arr_data[$key]['description']     = $plan['description'];
	            	 $arr_data[$key]['no_normal_deals'] = $plan['no_normal_deals'];
	            	 $arr_data[$key]['validity']        = $plan['validity'];
	            }
	        }

	        if($arr_data)
	        {
	           $json['data'] 	 = $arr_data;
	           $json['status']      = 'SUCCESS';
	           $json['message']     = 'Business Service Deleted Successfully ! .';

	        }
	        else
	        {
	           $json['status'] = 'ERROR';
	           $json['message']  = 'Error Occure while Deleting Business Service.';
	        }
	        return response()->json($json);
    }


    public function get_plan_cost(Request $request)
    {
        $category_id=$request->input('category_id');
        $plan_id=$request->input('plan_id');

        $arr_membership_plan=array();
        $obj_membership_plan = MembershipModel::where('plan_id',$plan_id)->first();
        if($obj_membership_plan)
        {
            $arr_membership_plan = $obj_membership_plan->toArray();
        }
        $validity=0;
        $price=0;

        if(sizeof($arr_membership_plan)>0)
        {   $arr_cost_data=array();
            $obj_cost_data = MemberCostModel::where('category_id',$category_id)->first();
            if($obj_cost_data)
            {
                $arr_cost_data = $obj_cost_data->toArray();
            }
                if(sizeof($arr_cost_data)>0)
                {
                    if($arr_membership_plan['title']=='Premium')
                    {
                        $price=$arr_cost_data['premium_cost'];

                    }
                    if($arr_membership_plan['title']=='Gold')
                    {
                        $price=$arr_cost_data['gold_cost'];

                    }
                     if($arr_membership_plan['title']=='Basic')
                    {
                        $price=$arr_cost_data['basic_cost'];

                    }
                    $validity=$arr_membership_plan['validity'];

                    $json['message']  = 'Business Memebrship Plan Cost Get Successfully ! .';
                    $json['status']   = "SUCCESS";
                    $json['price']    = $price;
                    $json['validity'] = $validity;
                    $json['plan_id']  = $plan_id;
                }
                else
                {
                    $json['message']='Error ! Business Payment for this category not available ! ';
                    $json['status']   = "ERROR";
                    $json['price']    = 0;
                    $json['validity'] = $validity;
                }

        }
        else
        {
              $json['message']='Error ! Business Plan Details Not Available! ';
              $json['status']   = "ERROR";
        }
        return response()->json($json);

    }



}
