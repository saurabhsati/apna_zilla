<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DishReviewModel extends Model
{

    use SoftDeletes;

    protected $table = "dish_reviews";

    protected $fillable = ['restaurant_id',
    						'dish_id',
    						'email',
    						'ratings',
    						'message'];


    public function dish_info()
    {
    	return $this->belongsTo('App\Models\DishModel','dish_id','id');
    }


}
