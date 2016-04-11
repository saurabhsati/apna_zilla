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
    	$curl = url('/').'/payumoney/cancle';

		$parameter_post = array (	'key' => 'gtKFFx', 'txnid' => uniqid( 'animesh_' ), 'amount' => rand( 0, 100 ),
			'firstname' => 'Test', 'email' => 'test@payu.in', 'phone' => '1234567890',
			'productinfo' => 'Product Info', 'surl' => $surl, 'furl' => $furl);
		$salt ='eCwWELxi';


		$run=$this->pay_page($parameter_post, $salt);
		return redirect($run);

	 	$page_title = 'Payment';
    }
    public function payment_success()
	{

		echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";

	}

	public function payment_fail()
	{
		echo "payment fail". "<pre>" . print_r( $_POST, true ) . "</pre>";
	}

	public function payment_cancle()
	{
		echo "payment cancle". "<pre>" . print_r( $_POST, true ) . "</pre>";

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
			$this->payu->show_reponse( $result );
		}
		else
		{
			$host = (isset( $_SERVER['https'] ) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['surl'] = $host;
			if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['furl'] = $host;

			$result = $this->pay( $params, $salt );
			$run_url=$this->payu->show_page( $result );
			//echo $run_url;
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
