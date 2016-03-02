<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessListingModel extends Model
{
    //
    protected $table='business';
    protected $fillable=['business_name', 'user_id','is_active','business_cat'];
     public function user_details()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
     public function categoty_details()
    {
    	return $this->belongsTo('App\Models\CategoryModel','business_cat','cat_id');
    }
}
