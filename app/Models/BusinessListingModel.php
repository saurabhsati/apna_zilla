<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BusinessCategoryModel;
class BusinessListingModel extends Model
{
    //
    protected $table='business';
    protected $fillable=['business_name',
                         'user_id',
                         'seller_public_id',
                         'is_active',
                         'business_cat',
                         'business_added_by',
                         'main_image',
                         'building',
                         'street',
                         'landmark',
                         'area',
                         'city',
                         'pincode',
                         'state',
                         'country',
                          'contact_person_name',
                         'mobile_number',
                         'landline_number',
                         'fax_no',
                         'toll_free_number',
                         'email_id',
                         'website',
                         'hours_of_operation',
                         'company_info',
                         'establish_year',
                         'keywords',
                         'youtube_link',
                         ];
     public function user_details()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function category()
    {
    	return $this->hasMany('App\Models\BusinessCategoryModel','business_id','id');
    }
    public function get_sub_category()
    {
        return $this->hasMany('App\Models\BusinessCategoryModel','business_id','id');
    }

    public function reviews()
    {
        //(forign key ,local key)
        return $this->hasMany('App\Models\ReviewsModel','business_id','id');
    }
    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country','id');
    }
    public function state_details()
    {
        return $this->belongsTo('App\Models\StateModel','state','id');
    }
    public function city_details()
    {
        return $this->belongsTo('App\Models\CityModel','city','id');
    }

    public function zipcode_details()
    {
        return $this->belongsTo('App\Models\ZipModel','pincode','id');
    }
    public function image_upload_details()
    {
        return $this->hasMany('App\Models\BusinessImageUploadModel','business_id','id');
    }
     public function services()
    {
        return $this->hasMany('App\Models\BusinessImageUploadModel','business_id','id');
    }
    public function service()
    {
        return $this->hasMany('App\Models\BusinessServiceModel','business_id','id');
    }

    public function business_times()
    {
        return $this->belongsTo('App\Models\BusinessTimeModel','id','business_id');
    }


}
