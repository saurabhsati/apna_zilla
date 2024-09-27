<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersOrderModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_orders';

    protected $fillable = [
        'deal_id',
        'order_id',
        'offer_id',
        'order_quantity',
        'order_status',
        'mode',

    ];
}
