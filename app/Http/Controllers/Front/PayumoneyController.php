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
use Session;
use URL;
class PayumoneyController extends Controller
{
	private $payu;

	public function __construct()
	{
		 $this->payu = new PayUPaymentService('eCwWELxi');

	}

    public function index(Request $request)
    {


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


		$parameter_post = array (	'key' => 'gtKFFx', 'txnid' => uniqid( 'RTN_' ), 'amount' =>$price,
			'firstname' =>$user_name, 'email' => $user_mail,
			'productinfo' =>  $business_name, 'surl' => $surl, 'furl' => $furl);
		$salt ='eCwWELxi';
		//print_r($request->all());



		$arr_data['business_id']=$business_id;
        $arr_data['user_id']=$user_id;
        $arr_data['category_id']=$category_id;
        $arr_data['membership_id']=$plan_id;
        $arr_data['transaction_id']=$parameter_post['txnid'];
        $arr_data['price']=$price;
        $arr_data['transaction_status']='Pending';
        $arr_data['start_date']=date('Y-m-d');
        $arr_data['expire_date']=date('Y-m-d', strtotime("+".$validity."days"));
        //dd($arr_data);
        $transaction = TransactionModel::create($arr_data);

        //dd($parameter_post);

		$run=$this->pay_page($parameter_post, $salt);
		return redirect($run);

	 	$page_title = 'Payment';
    }
    public function payment_success()
	{
		$arr_data['mihpayid']=$_POST['mihpayid'];
		$arr_data['mode']=$_POST['mode'];
        $arr_data['transaction_status']=$_POST['status'];
        $transaction = TransactionModel::where('transaction_id',$_POST['txnid'])->update($arr_data);
		//echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();
		 Session::flash('success_payment','Success ! Payment done successfully ! ');
		 return redirect(url('/').'/front_users/my_business');
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
