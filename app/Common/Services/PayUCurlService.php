<?php
namespace App\Common\Services;

use \Session;
use App\Common\Services\PayUCookiesService;

class PayUCurlService {
	private $url = "";
	private $user_agent = "libCurl";
	private $return_result = false;
	private $referrer = false;
	private $cookies_on = false;
	private $proxy = array ();
	private $timeout = 30;
	private $cookies;
	private $headers;
	private $method = "GET";
	private $httpHeader = "application/x-www-form-urlencoded";

	public $error = 0;
	public $info = array ();

	function __construct ( $url = false )
	{
		$this->cookies = new PayUCookiesService();
		$this->url = $url;
		$this->info['total_time'] = time();
	}

	function __destruct ()
	{

	}

	private function getHost ( $url )
	{
		$url = str_replace( array ( "http://", "https://" ), "", $url );

		$tmp = explode( "/", $url );
		return $tmp[0];
	}

	private function getQuery ( $url )
	{
		$url = str_replace( array ( "http://", "https://" ), "", $url );
		$tmp = explode( "/", $url, 2 );
		return "/" . $tmp[1];
	}

	private function _parseRawData ( $rawData )
	{
		$array = explode( "\r\n\r\n", $rawData, 2 );
		$this->header_data = $array[0];
		$this->content = $array[1];
		$this->_parseHeaders( $array[0] );
	}

	private function _parseHeaders ( $rawHeaders )
	{
		$rawHeaders = trim( $rawHeaders );
		$headers = explode( "\r\n", $rawHeaders );

		foreach ( $headers as $header ) {
			if ( preg_match( "|http/1\.. (\d+)|i", $header, $match ) ) {
				$this->status_code = $match[1];
				continue;
			}

			$headerArray = explode( ":", $header );
			$headerName = trim( $headerArray[0] );
			$headerValue = trim( $headerArray[1] );

			if ( preg_match( "|set-cookie2?|i", $headerName ) ) $this->cookies->add( $headerValue );
			if ( isset( $headerName ) ) $this->headers[strtolower( $headerName )] = $headerValue;
		}

		if ( isset( $this->headers["location"] ) ) {
			$this->url = $this->headers["location"];
			$this->exec();
		}
	}

	public function setopt ( $name, $value = false )
	{
		switch ( $name ) {
		case CURLOPT_URL :
			$this->url = $value;
			$this->proxy["port"] = substr( $this->url, 0, 5 ) === 'https' ? 443 : 80;
			break;
		case CURLOPT_USERAGENT :
			$this->user_agent = $value;
			break;
		case CURLOPT_POST :
			$this->method = ($value == true) ? "POST" : "GET";
			break;
		case CURLOPT_POSTFIELDS :
			$this->post_data = $value;
			break;
		case CURLOPT_RETURNTRANSFER :
			$this->return_result = ($value == true);
			break;
		case CURLOPT_REFERER :
			$this->referrer = $value;
			break;
		case CURLOPT_HEADER :
			$this->options["header"] = ($value == true);
			break;
		case CURLOPT_PROXY :
			list ( $this->proxy["host"], $this->proxy["port"] ) = explode( ":", $value );
			break;
		case CURLOPT_CONNECTTIMEOUT : /* Fall through. */
		case CURLOPT_TIMEOUT :
			$this->timeout = ($value >= 0) ? $value : 30;
			break;
		case CURLOPT_PORT :
			$this->proxy["port"] = $value ? $value : (substr( $this->url, 0, 5 ) === 'https' ? 443 : 80);
			break;
		case CURLOPT_HTTPHEADER :
			$this->httpHeader = substr( implode( ";", $value ), 0, - 1 );
			break;
		}
	}

	public function setoptArray ( $options )
	{
		foreach ( $options as $name => $value )
			$this->setopt( $name, $value );
	}

	public function exec ()
	{
		$errno = false;
		$errstr = false;
		$url = $this->url;

		$host = $this->getHost( $url );
		$query = $this->getQuery( $url );

		$this->proxy["host"] = $host;

		if ( isset( $this->proxy["port"] ) ) {
			$this->proxy["host"] = (443 === $this->proxy["port"]) ? "ssl://$host" : $host;
			$fp = pfsockopen( $this->proxy["host"], $this->proxy["port"], $errno, $errstr, $this->timeout );
			$request = $query;
		} else {
			$fp = pfsockopen( $host, 80, $errno, $errstr, $this->timeout );
			$request = $query;
		}

		if ( ! $fp ) { /*trigger_error($errstr, E_WARNING);*/ $this->error = 1;
			return;
		}

		$headers = $this->method . " $request HTTP/1.0 \r\nHost: $host \r\n";
		if ( $this->user_agent ) $headers .= "User-Agent: " . $this->user_agent . "\r\n";
		if ( $this->referrer ) $headers .= "Referrer: " . $this->referrer . "\r\n";
		if ( $this->method == "POST" ) {
			$headers .= "Content-Type: " . $this->httpHeader . "\r\n";
			$headers .= "Content-Length: " . strlen( $this->post_data ) . "\r\n";
		}

		if ( $this->cookies_on ) $headers .= $this->cookies->createHeader();
		$headers .= "Connection: Close\r\n\r\n";
		if ( "POST" == $this->method ) $headers .= $this->post_data;
		$headers .= "\r\n\r\n";

		fwrite( $fp, $headers );
		$rawData = "";
		while ( ! feof( $fp ) )
			$rawData .= fread( $fp, 512 );
			/* fclose($fp); /* Too lazy to read the docs.*/
		$this->info['total_time'] = time() - $this->info['total_time'];

		$this->_parseRawData( $rawData );
		if ( $this->options["header"] ) $this->content = $rawData;
		if ( $this->return_result ) return $this->content;
		echo $this->content;
	}

}

?>