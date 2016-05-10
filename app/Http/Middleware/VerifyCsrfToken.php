<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	'payumoney/success',
    	'payumoney/fail',
    	'payumoney/cancel',
    	'payumoney',
        'order/payment',
        'order/success',
        'order/fail',
        'order/cancel'
        

    ];
}
