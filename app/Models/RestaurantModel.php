<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantModel extends Model
{
    use SoftDeletes;

    protected $table = 'restaurants';

    protected $fillable = ['user_id',
        'cuisine_id',
        'name',
        'description',
        'address',
        'contact_no',
        'lat',
        'lng',
        'instagram_id',
        'live_status',
        'logo_image',
        'cover_image',
        'is_active'];

    public function parent_user()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'user_id', 'id');
    }

    public function parent_cuisine()
    {
        return $this->belongsTo('App\Models\CuisineModel', 'cuisine_id', 'id');
    }

    public function restaurant_schedule()
    {
        return $this->hasOne(\App\Models\RestaurantScheduleModel::class, 'restaurant_id', 'id');
    }
}
