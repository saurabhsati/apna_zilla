<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    //
    protected $table="city";
    protected $fillable=['public_key', 'city_title','city_image', 'city_slug','countries_id','state_id'];
    public function country_details()
    {
    	return $this->belongsTo('App\Models\CountryModel','countries_id','id');
    }
    public function state_details()
    {
    	 return $this->belongsTo('App\Models\StateModel','state_id','id');
    }
}
