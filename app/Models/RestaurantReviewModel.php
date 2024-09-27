<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantReviewModel extends Model
{
    use SoftDeletes;

    protected $table = 'restaurant_reviews';

    protected $fillabel = ['restaurant_id',
        'email',
        'ratings',
        'message',
        'is_active'];

    public function restaurant_deatails()
    {
        return $this->belongsTo('App\Models\RestaurantModel', 'restaurant_id', 'id');
    }
}
