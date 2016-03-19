<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReviewsModel extends Model
{
    //
    protected $table = 'reviews';

    protected $fillable = ['business_id',
                            'title',
                            'message',
    						'mobile_number',
    						'email',
    						'ratings',
    				        'name',
    						'is_active'
                           ];

	public function business_details()
    {
    	return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }

}
