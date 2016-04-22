<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class BusinessCategoryModel extends Model
{

    use SoftDeletes;
    use Rememberable;
     protected $table='business_category';
     protected $fillable=[
                         'business_id',
                         'category_id'
                         ];

   public function business_details()
    {
        return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
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

    public function category_list()
    {
        return $this->belongsTo('App\Models\CategoryModel','category_id','cat_id');
    }

    public function category_business()
    {
        return $this->belongsTo('App\Models\CategoryModel','id','cat_id');
    }
}
