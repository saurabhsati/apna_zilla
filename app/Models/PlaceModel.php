<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlaceModel extends Model
{

    use SoftDeletes;
	protected $table="places";
    protected $fillable=[
                         'country_id',
                         'city_id',
                         'state_id',
                         'postal_code',
                         'place_name',
                         'latitude',
                         'longitude'

                         ];
     public function country_details()
    {
    	return $this->belongsTo('App\Models\CountryModel','country_id','id');
    }
    public function state_details()
    {
    	 return $this->belongsTo('App\Models\StateModel','state_id','id');
    }
    public function city_details()
    {
    	 return $this->belongsTo('App\Models\CityModel','city_id','id');
    }
}
