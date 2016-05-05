<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsOffersModel extends Model
{
       use SoftDeletes;

    protected $table = 'deals';
    protected $fillable = ['business_id',
                           'title',
              					   'name',
              					   'price',
                           'discount_price',
              					   'description',
              					   'deal_image',
              					   'deal_type',
              					   'start_day',
              					   'end_day',
                           'start_time',
                           'end_time',
                           'description',
                           'things_to_remember',
                           'how_to_use',
                           'about',
                           'facilities',
                           'cancellation_policy',
                           'parent_category_id'
                           ];

    public function business_info()
    {
        return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }
       public function deals_slider_images()
    {
        return $this->hasMany('App\Models\DealsSliderImagesModel','deal_id','id');
    }
}
