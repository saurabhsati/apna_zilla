<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReviewsModel extends Model
{
    //
    protected $table = 'reviews';

    protected $fillabel = ['fk_id',
    						'name',
    						'mobile_number',
    						'email',
    						'ratings',
    						'message',
    						'is_active'];
}
