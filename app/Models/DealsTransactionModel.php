<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsTransactionModel extends Model
{
    use SoftDeletes;

    protected $table = 'deal_transaction_details';

    protected $fillable = ['order_id',
        'transaction_id',
        'user_id',
        'price',
        'start_date',
        'expire_date',
        'transaction_status',
        'mode',
        'deal_id',
    ];

    public function user_records()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id', 'id');
    }

    public function user_orders()
    {
        return $this->hasMany('App\Models\UsersOrderModel', 'order_id', 'order_id');
    }

    public function order_deal()
    {
        return $this->belongsTo('App\Models\DealsOffersModel', 'deal_id', 'id');
    }
}
