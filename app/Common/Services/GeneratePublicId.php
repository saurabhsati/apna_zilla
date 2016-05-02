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
	/* Generate USer Public id*/
	public function generate_public_id($in)
    {
        $hashids = new Hashids('RightNext',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
         return  strtoupper('RNT-'.$hashids->encode($in));

    }
    /* Generate Business Public id*/
	public function generate_public_id($cat_ref_slug,$in)
    {
        $hashids = new Hashids('RightNext',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
         return  strtoupper('RNT-'.$cat_ref_slug.'-'.$hashids->encode($in));

    }
 }

?>