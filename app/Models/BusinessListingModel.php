<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class BusinessListingModel extends Model
{
    use SoftDeletes;

    //use Rememberable;
    protected $table = 'business';

    protected $fillable = ['business_name',
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
        'lat',
        'lng',
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
        'sales_user_public_id',
        'busiess_ref_public_id',
    ];

    public function user_details()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->hasMany(\App\Models\BusinessCategoryModel::class, 'business_id', 'id');
    }

    public function category_details()
    {
        return $this->belongsTo(\App\Models\BusinessCategoryModel::class, 'id', 'business_id');
    }

    public function get_sub_category()
    {
        return $this->hasMany(\App\Models\BusinessCategoryModel::class, 'business_id', 'id');
    }

    public function reviews()
    {
        //(forign key ,local key)
        return $this->hasMany(\App\Models\ReviewsModel::class, 'business_id', 'id');
    }

    public function country_details()
    {
        return $this->belongsTo(\App\Models\CountryModel::class, 'country', 'id');
    }

    public function state_details()
    {
        return $this->belongsTo(\App\Models\StateModel::class, 'state', 'id');
    }

    public function city_details()
    {
        return $this->belongsTo(\App\Models\CityModel::class, 'city', 'id');
    }

    public function zipcode_details()
    {
        return $this->belongsTo(\App\Models\PlaceModel::class, 'pincode', 'id');
    }

    public function image_upload_details()
    {
        return $this->hasMany(\App\Models\BusinessImageUploadModel::class, 'business_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(\App\Models\BusinessImageUploadModel::class, 'business_id', 'id');
    }

    public function service()
    {
        return $this->hasMany(\App\Models\BusinessServiceModel::class, 'business_id', 'id');
    }

    public function business_times()
    {
        return $this->hasMany(\App\Models\BusinessTimeModel::class, 'business_id', 'id');
    }

    public function also_list_category()
    {
        return $this->hasMany(\App\Models\BusinessCategoryModel::class, 'business_id', 'id');
    }

    public function payment_mode()
    {
        return $this->hasMany(\App\Models\BusinessPaymentModeModel::class, 'business_id', 'id');
    }

    public function membership_plan_details()
    {
        return $this->hasMany(\App\Models\TransactionModel::class, 'business_id', 'id');
    }
}
