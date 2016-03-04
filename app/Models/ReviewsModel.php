<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReviewsModel extends Model
{
    //
    protected $table = 'reviews';

    protected $fillabel = ['business_id',
    						'name',
    						'mobile_number',
    						'email',
    						'ratings',
    						'message',
    						'is_active'];

	public function business_details()
    {
    	return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }

}
