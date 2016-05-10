<?php

namespace App\Common\Services;
use App\Common\Services\PayUPayUMiscServiceService;
use \Session;

class PayUMoneyService
{
	protected $pay_test_url;
	protected $pay_production_url;
	protected $pay_salt;
	protected $pay_key;
	protected $pay_test_mode;
	private $url;
	private $salt;
	private $params = array ();

	public function __construct($salt, $env = 'test')
	{
        /*$this->pay_test_url = 'https://test.payu.in/_payment';
        $this->pay_production_url = 'https://secure.payu.in/_payment';
        $this->pay_key = "gtKFFx";
        $this->salt ='eCwWELxi';
       	$this->pay_test_mode = TRUE;*/
       	$this->salt = $salt;

		switch ( $env ) {
		case 'test' :
			$this->url = 'https://test.payu.in/';
			break;
		case 'prod' :
			$this->url = 'https://secure.payu.in/';
			break;
		default :
			$this->url = 'https://test.payu.in/';
		}

    }

    public function __destruct ()
	{
		unset( $this->url );
		unset( $this->salt );
		unset( $this->params );
	}

	public function __set ( $key, $value )
	{
		$this->params[$key] = $value;
	}

	public function __get ( $key )
	{
		return $this->params[$key];
	}

	public function pay ( $params = null )
	{
		if ( is_array( $params ) ) foreach ( $params as $key => $value )
			$this->params[$key] = $value;

		 $error = $this->check_params();

		if ( $error === true ) {
			$this->params['hash'] = PayUMiscService::get_hash( $this->params, $this->salt );
			$result = PayUMiscService::curl_call( $this->url . '_payment?type=merchant_txn', http_build_query( $this->params ) );
			//dd($result);
			if(sizeof($result)>0)
			{
					$transaction_id = ($result['curl_status'] === PayUMiscService::SUCCESS) ? $result['result'] : null;
					//die();
					if ( empty( $transaction_id ) ) return array (
						'status' => 0,
						'data' => $result['error'] );

					return array (
						'status' => PayUMiscService::SUCCESS,
						'data' => $this->url . '_payment_options?mihpayid=' . $transaction_id );
			}
		}
		else {
			return array ( 'status' => PayUMiscService::FAILURE, 'data' => $error );
		}
	}

	private function check_params ()
	{
		if ( empty( $this->params['key'] ) ) return $this->error( 'key' );
		if ( empty( $this->params['txnid'] ) ) return $this->error( 'txnid' );
		if ( empty( $this->params['amount'] ) ) return $this->error( 'amount' );
		if ( empty( $this->params['firstname'] ) ) return $this->error( 'firstname' );
		/*if ( empty( $this->params['email'] ) ) return $this->error( 'email' );*/
		if ( empty( $this->params['phone'] ) ) return $this->error( 'phone' );
		if ( empty( $this->params['productinfo'] ) ) return $this->error( 'productinfo' );
		if ( empty( $this->params['surl'] ) ) return $this->error( 'surl' );
		if ( empty( $this->params['furl'] ) ) return $this->error( 'furl' );

		return true;
	}

	private function error ( $key )
	{
		return 'Mandatory parameter ' . $key . ' is empty';
	}














	/*public function send_request($url,array $arr_fields,$type = "POST",$follow_location = TRUE,$return_transfer=FALSE)
	{

		$ch = curl_init();

		if($type == "GET")
		{
			$url.= implode('&',$arr_fields);
		}
		else
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arr_fields);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,$return_transfer);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,$follow_location);

		$response = curl_exec($ch);
		// dd($response);
		curl_close($ch);

		return $response;

	}*/




}
