<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StateModel extends Model
{
    protected $table = 'states';
    protected $fillable = [
						    'state_title',
						    'country_id'
						      ];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    }

}
