<?php

namespace App\Common\Services;

use Hashids\Hashids;

class GeneratePublicId
{
    public function __construct() {}

    public function __destruct() {}

    /* Generate USer Public id*/
    public function generate_public_id($in)
    {
        /*$hashids = new Hashids('RightNext',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
         return  strtoupper('RNT-'.$hashids->encode($in));*/
        $l = 'RNT';
        $public_id = $l.sprintf('%05d', $in);

        return $public_id;

    }

    /* Generate Business Public id*/
    public function generate_business_public_by_category($cat_ref_slug, $in)
    {
        /*  $hashids = new Hashids('RightNext',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
           return  strtoupper('RNT-'.$cat_ref_slug.'-'.$hashids->encode($in));*/
        $l = 'RNT'.$cat_ref_slug;
        $public_id = $l.sprintf('%05d', $in);

        return $public_id;

    }
}
