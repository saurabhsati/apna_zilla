<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLocationModel extends Model
{
    protected $table='business_location';
    protected $fillable=[
                        'business_id',
                        'type',
                        'building',
					     'street',
					     'landmark',
					     'area',
					     'city',
					     'pincode',
					     'state',
					     'country'
					     ];
	public function country_details()
    {
    	return $this->belongsTo('App\Models\CountryModel','country','id');
    }
    public function state_details()
    {
    	return $this->belongsTo('App\Models\StateModel','state','id');
    }
	public function city_details()
    {
    	return $this->belongsTo('App\Models\CityModel','city','id');
    }

    public function zipcode_details()
    {
    	return $this->belongsTo('App\Models\ZipModel','pincode','id');
    }
}
