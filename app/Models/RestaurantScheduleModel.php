<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantScheduleModel extends Model
{
    protected $table = 'restaurant_schedule';

    protected $fillable = ['restaurant_id',
    						'mon_open',
    						'mon_close',
    						'tue_open',
    						'tue_close',
    						'wed_open',
    						'wed_close',
    						'thus_open',
    						'thus_close',
    						'fri_open',
    						'fri_close',
    						'sat_open',
    						'sat_close',
    						'sun_open',
    						'sun_close'];



}
