<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals';

    protected $fillable = ['restaurant_id',
    					   'cuisine_id',
    					   'name',
    					   'price',
    					   'description',
    					   'deal_image',
    					   'deal_type',
    					   'start_day',
    					   'end_day',
                           'start_time',
                           'end_time'];

    public function restaurant_info()
    {
        return $this->belongsTo('App\Models\RestaurantModel','restaurant_id','id');
    }                       

    public function dish_list()
    {
        return $this->hasMany('App\Models\DealDishModel','deal_id','id');
    }

    public function deal_type()
    {
        return $this->hasMany('App\Models\DealReviewModel','restaurant_id','restaurant_id');
    }

   /* public function deal_review()
    {
        return $this->belongsTo('App\Models\DealReviewModel','id','deal_id');
    }*/
}
