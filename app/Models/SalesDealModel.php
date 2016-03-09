<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDealModel extends Model
{
    //
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
                           'end_time'];

    public function business_info()
    {
        return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }
}
