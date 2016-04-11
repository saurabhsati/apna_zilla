<?php

namespace App\Common\Services;

use \Session;

class PayUCookiesService {
	
	private $cookies;

	function __construct ()
	{}

	function __destruct ()
	{}

	public function add ( $cookie )
	{
		list ( $data, $etc ) = explode( ";", $cookie, 2 );
		list ( $name, $value ) = explode( "=", $data );
		$this->cookies[trim( $name )] = trim( $value );
	}

	public function createHeader ()
	{
		if ( 0 == count( $this->cookies ) || ! is_array( $this->cookies ) ) return "";
		$output = "";
		foreach ( $this->cookies as $name => $value )
			$output .= "$name=$value; ";
		return "Cookies: $output\r\n";
	}

}
?>