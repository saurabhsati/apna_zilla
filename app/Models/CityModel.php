<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityModel extends Model
{
    use SoftDeletes;

    protected $table = 'cities';

    protected $fillable = [
        'city_title',
        'country_id',
        'is_popular',
        'state_id'];

    public function country_details()
    {
        return $this->belongsTo(\App\Models\CountryModel::class, 'country_id', 'id');
    }

    public function state_details()
    {
        return $this->belongsTo(\App\Models\StateModel::class, 'state_id', 'id');
    }

    public function business_details()
    {
        return $this->hasMany(\App\Models\BusinessListingModel::class, 'city', 'id');
    }

    public function city_places()
    {
        return $this->hasMany(\App\Models\PlaceModel::class, 'city_id', 'id');
    }
}
