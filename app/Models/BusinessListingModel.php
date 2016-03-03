<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessListingModel extends Model
{
    //
    protected $table='business';
    protected $fillable=['business_name',
                         'user_id',
                         'is_active',
                         'business_cat',
                         'business_id',
                         'main_image',
                         'hours_of_operation',
                         'company_info',
                         'keywords',
                         'youtube_link',
                         ];
     public function user_details()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
     public function categoty_details()
    {
    	return $this->belongsTo('App\Models\CategoryModel','business_cat','cat_id');
    }
    public function reviews()
    {
        //(forign key ,local key)
        return $this->hasMany('App\Models\ReviewsModel','business_id','id');
    }
}
