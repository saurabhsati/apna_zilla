<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BusinessSendEnquiryModel extends Model
{

    use SoftDeletes;
	 protected $table="business_send_enquiry";
     protected $fillable=['business_id',
                           'user_id',
     					  'name',
     					  'email',
     					  'mobile',
     					  'subject',
     					  'message',
     					  'mobile_OTP'
                         ];
}
