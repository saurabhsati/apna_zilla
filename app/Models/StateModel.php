<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    protected $table = 'state';
    protected $fillable = ['public_key', 'state_title','state_image', 'state_slug','countries_id'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','countries_id','id');
    }

}
