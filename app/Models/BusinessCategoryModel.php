<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BusinessCategoryModel extends Model
{
     protected $table='business_category';
     protected $fillable=[
                         'business_id',
                         'category_id'
                         ];

   public function business_details()
    {
        return $this->belongsTo('App\Models\BusinessListingModel','cat_id','business_cat');
    }
    // Get business by category
    public function business_by_category()
    {

        return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }


    public function business_rating()
    {
        return $this->hasMany('App\Models\ReviewsModel','business_id','business_id');
    }
    public function match_city_name()
    {
        return $this->belongsTo('App\Models\CityModel','city','id');
    }

}
