<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Services\PayUCookiesService;
use App\Common\Services\PayUCurlService;
use App\Common\Services\PayUMiscService;
use App\Common\Services\PayUMoneyService;
use App\Common\Services\PayUPaymentService;
use App\Models\TransactionModel;
use App\Models\EmailTemplateModel;
use Session;
use URL;
use Mail;
class PayumoneyController extends Controller
{
	private $payu;

	public function __construct()
	{
		 $this->payu = new PayUPaymentService('eCwWELxi');

	}

    public function index(Request $request)
    {

    	$page_title = 'Payment';
    	$surl = url('/').'/payumoney/success';
    	$furl = url('/').'/payumoney/fail';
    	$curl = url('/').'/payumoney/cancel';

    	$user_name=($request->input('user_name'));
		 $user_mail=($request->input('user_mail'));
		 $user_id=base64_decode($request->input('user_id'));
         $category_id=base64_decode($request->input('category_id'));
         $plan_id=$request->input('plan_id');
         $price=$request->input('price');
         $validity=$request->input('validity');
         $business_id=base64_decode($request->input('business_id'));
		 $business_name=base64_decode($request->input('business_name'));



		//print_r($request->all());exit;


		$txnid=uniqid( 'RTN_' );


        //dd($parameter_post);
        if($price==0)
        {
        	//print_r($request->all());exit;
		        $arr_data['business_id']=$business_id;
		        $arr_data['user_id']=$user_id;
		        $arr_data['category_id']=$category_id;
		        $arr_data['membership_id']=$plan_id;
		        $arr_data['transaction_id']=$txnid;
		        $arr_data['price']=$price;
		        $arr_data['transaction_status']='Active';
		        $arr_data['start_date']=date('Y-m-d');
		        $arr_data['expire_date']=date('Y-m-d', strtotime("+".$validity."days"));
		        //dd($arr_data);
		        $transaction = TransactionModel::create($arr_data);
		        if($transaction)
	            {
				 Session::flash('success_payment','Success ! Basic Membership Plan assign successfully ! ');

				}
				else
	            {
	                Session::flash('error_payment','Error While Assigning Basic Membership Plan  !');

	            }
        	    return redirect(url('/').'/front_users/my_business');
        }
        else
        {
	        $arr_data['business_id']=$business_id;
	        $arr_data['user_id']=$user_id;
	        $arr_data['category_id']=$category_id;
	        $arr_data['membership_id']=$plan_id;
	        $arr_data['transaction_id']=$txnid;
	        $arr_data['price']=$price;
	        $arr_data['transaction_status']='Pending';
	        $arr_data['start_date']=date('Y-m-d');
	        $arr_data['expire_date']=date('Y-m-d', strtotime("+".$validity."days"));
	        //dd($arr_data);
	        $transaction = TransactionModel::create($arr_data);
	        $parameter_post = array (	'key' => 'gtKFFx', 'txnid' =>$txnid , 'amount' =>$price,
				'firstname' =>$user_name, 'email' => $user_mail,
				'productinfo' =>  $business_name, 'surl' => $surl, 'furl' => $furl);
			$salt ='eCwWELxi';
			$run=$this->pay_page($parameter_post, $salt);
			return redirect($run);


	  }
    }
    public function payment_success()
	{
		$arr_data['mihpayid']=$_POST['mihpayid'];
		$arr_data['mode']=$_POST['mode'];
        $arr_data['transaction_status']=$_POST['status'];
        $transaction_id=$_POST['txnid'];
       // dd($_POST);
        $transaction = TransactionModel::where('transaction_id',$transaction_id)->update($arr_data);
        if($transaction)
        {

        	$obj_single_transaction=TransactionModel::where('transaction_id',$_POST['txnid'])->first();
        	if($obj_single_transaction)
	    	{
	    		$obj_single_transaction->load(['user_records']);
		    	$obj_single_transaction->load(['membership']);
            	$obj_single_transaction->load(['business']);
            	$obj_single_transaction->load(['category']);

	    		$arr_single_transaction = $obj_single_transaction->toArray();
	    	}
	    	$first_name=ucfirst($arr_single_transaction['user_records']['first_name']);
	    	$email=ucfirst($arr_single_transaction['user_records']['email']);
	    	$business_name=ucfirst($arr_single_transaction['business']['business_name']);
	    	$plan=ucfirst($arr_single_transaction['membership']['title']);
	    	$category=ucfirst($arr_single_transaction['category']['title']);
	    	$transaction_id=$_POST['txnid'];
	    	$transaction_status=$_POST['status'];
	    	$payment_mode=$arr_data['mode'];
	    	$expiry_date=date('d-M-Y',strtotime($arr_single_transaction['expire_date']));
			//echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();

			$obj_email_template = EmailTemplateModel::where('id','13')->first();
            if($obj_email_template)
            {
                $arr_email_template = $obj_email_template->toArray();

                $content	    = $arr_email_template['template_html'];
                $content   	    = str_replace("##USER_FNAME##",$first_name,$content);
                $content        = str_replace("##BUSINESS_NAME##",$business_name,$content);
                $content        = str_replace("##CATEGORY##",$category,$content);
                $content        = str_replace("##TRANS_ID##",$transaction_id,$content);
                $content        = str_replace("##TRANS_STATUS##",$transaction_status,$content);

                $content        = str_replace("##MODE##",$payment_mode,$content);
                $content        = str_replace("##EXPIRY##",$expiry_date,$content);
                $content        = str_replace("##PLAN##",$plan,$content);
                $content        = str_replace("##APP_LINK##","RightNext",$content);
                 //print_r($content);exit;
                $content = view('email.front_general',compact('content'))->render();
                $content = html_entity_decode($content);

                $send_mail = Mail::send(array(),array(), function($message) use($email,$first_name,$arr_email_template,$content)
                            {
                                $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                $message->to($email, $first_name)
                                        ->subject($arr_email_template['template_subject'])
                                        ->setBody($content, 'text/html');
                            });

                //return $send_mail;
            if($send_mail)
            {
			 Session::flash('success_payment','Success ! Payment done successfully ! ');
			 return redirect(url('/').'/front_users/my_business');
			}
			else
            {
                Session::flash('error_payment','Payment done successfully But Mail Not Delivered Yet !');
                 return redirect(url('/').'/front_users/my_business');
            }
        }
      }
		//echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";

	}

	public function payment_fail()
	{
		Session::flash('error_payment','Error ! While Doing payment ! ');
		 return redirect(url('/').'/front_users/my_business');
		//echo "payment fail". "<pre>" . print_r( $_POST, true ) . "</pre>";
	}

	public function payment_cancle()
	{
		Session::flash('error_payment','Info ! Payment Cancel ! ');
		 return redirect(url('/').'/front_users/my_business');
		//echo "payment cancle". "<pre>" . print_r( $_POST, true ) . "</pre>";

	}

	/**
	 * Displays the pay page.
	 *
	 * @param unknown $params
	 * @param unknown $salt
	 * @throws Exception
	 */
	public function pay_page ( $params, $salt )
	{
		if ( count( $_POST ) && isset( $_POST['mihpayid'] ) && ! empty( $_POST['mihpayid'] ) ) {
			$_POST['surl'] = $params['surl'];
			$_POST['furl'] = $params['furl'];
			$result = response( $_POST, $salt );

			$this->payment_success($result );
			//$this->payu->show_reponse( $result );
		}
		else
		{
			//$host = (isset( $_SERVER['https'] ) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			/*if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['surl'] = $host;
			if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['furl'] = $host;*/
			//dd($params['surl']);
			$result = $this->pay( $params, $salt );
			$run_url=$this->payu->show_page( $result );
			 return $run_url ;
		}
	}

	/**
	 * Returns the pay page url or the merchant js file.
	 *
	 * @param unknown $params
	 * @param unknown $salt
	 * @throws Exception
	 * @return Ambigous <multitype:number string , multitype:number Ambigous <boolean, string> >
	 */
	function pay ( $params, $salt )
	{
		if ( ! is_array( $params ) ) throw new Exception( 'Pay params is empty' );

		if ( empty( $salt ) ) throw new Exception( 'Salt is empty' );

		$payment = new PayUMoneyService( $salt );
		$result = $payment->pay( $params );
		unset( $payment );

		return $result;
	}
}
