<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $table = 'coupon';

    protected $fillable = ['coupon_code', 'type', 'discount', 'start_date', 'end_date', 'status'];
}
