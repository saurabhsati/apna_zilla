<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMembershipModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_membership';

    protected $fillable = [
        'user_id',
        'membership_id',
        'membership_name',
        'membership_price',
        'no_normal_deals',
        'no_instant_deals',
        'no_featured_deals',
        'is_active'];

    /* public function restaurant()
     {
         return $this->belongsTo('App\Models\RestaurantModel','restaurant_id','id');
     }

     public function category()
     {
         return $this->belongsTo('App\Models\CategoryModel','category_id','id');
     }	*/
}
