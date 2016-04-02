<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BusinessSendEnquiryModel extends Model
{
	 protected $table="business_send_enquiry";
     protected $fillable=['business_id',
     					  'name',
     					  'email',
     					  'mobile',
     					  'subject',
     					  'message',
                         ];
}
