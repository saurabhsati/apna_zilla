<?php
namespace App\Common\Services;

use \Session;
use App\Common\Services\PayUMiscService;
use Exception;
class PayUPaymentService
{
    private $url;
	private $salt;
	private $params = array ();
	private $miss;


	public function __construct ( $salt, $env = 'test' )
	{
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

		$this->miss = new PayUMiscService();
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
			$this->params['hash'] = Misc::get_hash( $this->params, $this->salt );
			$result = $this->miss->curl_call( $this->url . '_payment?type=merchant_txn', http_build_query( $this->params ) );
			$transaction_id = ($result['curl_status'] === 1) ? $result['result'] : null;

			if ( empty( $transaction_id ) ) return array (
				'status' => 0,
				'data' => $result['error'] );

			return array (
				'status' => 1,
				'data' => $this->url . '_payment_options?mihpayid=' . $transaction_id );
		} else {
			return array ( 'status' => 0, 'data' => $error );
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
	public static function show_page ( $result )
	{
		if ( $result['status'] === PayUMiscService::SUCCESS )
		{

			return $result['data'];
		}
		else
		{
			throw new Exception( $result['data'] );
		}
	}
	public static function show_reponse ( $result )
	{
		if ( $result['status'] === PayUMiscService::SUCCESS )
		{

			$result['data']();
		}
		else
	    {return $result['data'];}
	}




}