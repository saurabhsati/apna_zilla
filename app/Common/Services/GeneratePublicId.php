<?php

namespace App\Common\Services;

use \Session;
use \Hashids\Hashids;

class GeneratePublicId
 {
 	function __construct ()
	{}

	function __destruct ()
	{}
	public function generate_public_id($in)
    {
        $hashids = new Hashids('RightNext',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
         return  strtoupper('RNT-'.$hashids->encode($in));

    }
 }

?>