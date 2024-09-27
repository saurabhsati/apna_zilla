<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishModel extends Model
{
    use SoftDeletes;

    protected $table = 'dishes';

    protected $fillable = ['restaurant_id',
        'category_id',
        'name',
        'price',
        'description',
        'dish_image',
        'is_veg',
        'is_active'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\RestaurantModel', 'restaurant_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'category_id', 'id');
    }
}
