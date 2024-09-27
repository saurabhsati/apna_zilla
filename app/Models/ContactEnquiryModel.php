<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContactEnquiryModel extends Model
{

    use SoftDeletes;
    protected $table = 'contact_us';

    protected $fillable = ['full_name',
    					   'email_address',
    					   'mobile_no',
    					   'message'
    					  ];
}
