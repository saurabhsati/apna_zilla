<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use App\Models\MemberCostModel;
use App\Models\BusinessListingModel;
use App\Models\TransactionModel;
use App\Models\EmailTemplateModel;
use Mail;

class MembershipPlanController extends Controller
{
	public function __construct()
	{
       $json = array();
    }
    public function assign_membership(Request $request)
    {
    	    $arr_data     = array();
            $category_id               = $request->input('main_category_id');
			$arr_data['business_id ']  = $request->input('business_id');
			$arr_data['business_name'] = $request->input('business_name');
			$arr_data['user_id']       = $request->input('user_id');
			$arr_data['category_id']   = $category_id;
			$arr_cost_data             = $arr_membership_plan =  array();

	        $obj_cost_data = MemberCostModel::where('category_id',$category_id)->first();
	        if($obj_cost_data)
	        {
	            $arr_cost_data = $obj_cost_data->toArray();
	        }
	        if(sizeof($arr_cost_data)>0)
	        {
	            $obj_membership_plan = MembershipModel::orderBy('plan_id','DESC')->select('plan_id','title','description', 'no_normal_deals', 'validity')->get();
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
          

	        if($arr_membership_plan)
	        {
	           $json['data'] 	 = $arr_membership_plan;
	           $json['status']      = 'SUCCESS';
	           $json['message']     = 'Membership Plan ! .';
	        }
	        else
	        {
	           $json['status'] = 'ERROR';
	           $json['message']  = 'Error occure while getting membership plan.';
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
    public function manual_plan_purchase(Request $request)
    {        
        $sales_user_public_id = $request->input('sales_user_public_id');

        $arr_data    =    $transaction = array();
        $business_id = $request->input('business_id');
        $user_id     = $request->input('user_id');
        $category_id = $request->input('category_id');
        $plan_id     = $request->input('plan_id');
        $price       = $request->input('price');
        $validity    = $request->input('validity');
        $start_date  = date('Y-m-d');
       
        $arr_data['business_id']          = $business_id;
        $arr_data['user_id']              = $user_id;
        $arr_data['category_id']          = $category_id;
        $arr_data['membership_id']        = $plan_id;
        $arr_data['price']                = $price;
        $arr_data['transaction_status']   = 'Active';
        $arr_data['sales_user_public_id'] = $sales_user_public_id;
        $arr_data['start_date']           = $start_date;
        $arr_data['expire_date']          = date('Y-m-d', strtotime("+".$validity."days"));
       
        
        $transaction = TransactionModel::create($arr_data);
        
        if($transaction)
        {
             $obj_single_transaction=TransactionModel::where('id',$transaction->id)->first();
             $transaction_id='TXN'.$transaction->id;
             $update_arr_data['transaction_id']        =    $transaction_id;
             $transaction = TransactionModel::where('id',$transaction->id)->update($update_arr_data);

            if($obj_single_transaction)
            {
                $obj_single_transaction->load(['user_records']);
                $obj_single_transaction->load(['membership']);
                $obj_single_transaction->load(['business']);
                $obj_single_transaction->load(['category']);

                $arr_single_transaction = $obj_single_transaction->toArray();
            }
            $first_name    = ucfirst($arr_single_transaction['user_records']['first_name']);
            $email         = ucfirst($arr_single_transaction['user_records']['email']);
            $business_name = ucfirst($arr_single_transaction['business']['business_name']);
            $plan          = ucfirst($arr_single_transaction['membership']['title']);
            $category      = ucfirst($arr_single_transaction['category']['title']);
            $expiry_date   = date('d-M-Y',strtotime($arr_single_transaction['expire_date']));
            //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();

            $obj_email_template = EmailTemplateModel::where('id','13')->first();
            if($obj_email_template)
            {
                $arr_email_template = $obj_email_template->toArray();

                $content        = $arr_email_template['template_html'];
                $content         = str_replace("##USER_FNAME##",$first_name,$content);
                $content        = str_replace("##BUSINESS_NAME##",$business_name,$content);
                $content        = str_replace("##CATEGORY##",$category,$content);
                $content        = str_replace("##TRANS_ID##",$transaction_id,$content);
                $content        = str_replace("##TRANS_STATUS##","Active",$content);

                $content        = str_replace("##MODE##","Payment Hand Over To Sales User",$content);
                $content        = str_replace("##EXPIRY##",$expiry_date,$content);
                $content        = str_replace("##PLAN##",$plan,$content);
                $content        = str_replace("##APP_LINK##","RightNext",$content);
                 //print_r($content);exit;
                $content = view('email.front_general',compact('content'))->render();
                $content = html_entity_decode($content);
                $send_mail ='';
                if($email!='')
                {
                            $send_mail = Mail::send(array(),array(), function($message) use($email,$first_name,$arr_email_template,$content)
                                {
                                    $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                    $message->to($email, $first_name)
                                            ->subject($arr_email_template['template_subject'])
                                            ->setBody($content, 'text/html');
                                });
                }
               else
                {
                    $json['message']='success ! uccess ! Membership Assign Successfully!! ';
                    $json['status']   = "SUCCESS";
                }
                //return $send_mail;
                if($send_mail)
                {
                    $json['message']='success ! Success ! Membership Assign Successfully ! ';
                    $json['status']   = "SUCCESS";
                }
                else
                {   $json['message']='Error ! Membership Assign Successfully But Mail Not Delivered Yet ! ';
                    $json['status']   = "ERROR";
                }
           }
         }
       
        return response()->json($json);

    }
}





