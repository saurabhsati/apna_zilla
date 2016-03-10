<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ZipModel extends Model
{
    //
    protected $table='zipcode';
    protected $primaryKey = 'id';
    protected $filltable=['country_code,zipcode,latitude,longitude'];
    public function country_details()
    {
    	return $this->belongsTo('App\Models\CountryModel','country_code','country_code');
    }
}
