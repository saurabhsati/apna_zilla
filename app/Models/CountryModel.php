<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    //
    protected $table = 'countries';
    protected $primaryKey = 'id';
     protected $fillable = ['public_key', 'country_code','country_image','country_name', 'country_slug'];
}
