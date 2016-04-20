<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use App\Models\MemberCostModel;

use Session;
class MembershipPlanController extends Controller
{
	 public function assign_membership($enc_business_id,$enc_business_name,$enc_user_id,$enc_category_id)
    {
    	//echo $enc_user_id;
        $page_title="Assign Membership";
        $business_id=base64_decode($enc_business_id);
        $business_name=base64_decode($enc_business_name);

        $user_id=base64_decode($enc_user_id);
        $category_id=base64_decode($enc_category_id);
        $arr_cost_data=array();
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
            //dd($arr_membership_plan);
            return view('front.user.pay_membership',compact('page_title','arr_membership_plan','enc_business_id','enc_user_id','enc_category_id','enc_business_name'));

        }
        else
        {
            Session::flash('error_payment','Error ! Business Payment for this category not available !');
            return redirect()->back();
        }


    }
    public function get_plan_cost(Request $request)
    {
         $category_id=base64_decode($request->input('category_id'));
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

                    $arr_response['status'] ="SUCCESS";
                    $arr_response['price'] =$price;
                    $arr_response['validity'] = $validity;
                    $arr_response['plan_id']=$plan_id;
                }
                else
                {
                    Session::flash('error_payment','Error ! Business Payment for this category not available ! ');
                    $arr_response['status'] ="CategoryCostAbsent";
                    $arr_response['price'] =0;
                    $arr_response['validity'] = $validity;
                }

        }
        else
        {
             $arr_response['status'] ="ERROR";
            //$arr_response['arr_state'] = array();
        }
        return response()->json($arr_response);

    }
}
