<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealReviewModel extends Model
{
     use SoftDeletes;
    
    protected $table = "deal_reviews";

    protected $fillable = ['restaurant_id',
    						'deal_id',
    						'email',
    						'ratings',
    						'message'];

    public function deal_info()
    {
    	return $this->belongsTo('App\Models\DealModel','deal_id','id');
    }	

    				
}
