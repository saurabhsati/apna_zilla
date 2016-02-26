<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipModel extends Model
{
    //
    protected $table='zipcode';
    protected $filltable=['zipcode,latitude,longitude'];
    public function country_details()
    {
    	return $this->belongsTo('App\Models\CountryModel','country_code','country_code');
    }
}
