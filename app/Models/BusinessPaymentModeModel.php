<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BusinessPaymentModeModel extends Model
{
     protected $table="business_payment_mode";
     protected $fillable=['business_id',
     					  'title'
                         ];
}
