<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StateModel extends Model
{
    protected $table = 'states';
    protected $fillable = ['public_key', 'state_title','state_image', 'state_slug','countries_id'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','countries_id','id');
    }

}
