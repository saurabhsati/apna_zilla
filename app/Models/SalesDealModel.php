<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDealModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals';

    protected $fillable = ['business_id',
        'public_id',
        'name',
        'price',
        'discount_price',
        'description',
        'deal_image',
        'deal_type',
        'start_day',
        'end_day',
        'start_time',
        'end_time',
        'parent_category_id'];

    public function business_info()
    {
        return $this->belongsTo(\App\Models\BusinessListingModel::class, 'business_id', 'id');
    }
}
