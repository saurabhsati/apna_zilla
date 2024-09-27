<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LocationModel extends Model
{

    use SoftDeletes;
    protected $table="locations";
    protected $fillable=['country_code',
                         'postal_code',
                         'place_name',
                         'admin_name1',
                         'admin_name2',
                         'admin_name3',
                         'latitude',
                         'longitude',
                         ];

}
