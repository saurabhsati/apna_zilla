<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TransactionModel extends Model
{

    use SoftDeletes;
    protected $table = 'transaction_details';

    protected $fillable = ['order_id',
    						'transaction_id',
                            'business_id',
                            'category_id',
    						'user_id',
    						'membership_id',
    						'price',
    						'start_date',
    						'expire_date',
                            'transaction_status',
                            'sales_user_public_id'
                            ];

    public function user_records()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }

    public function membership()
    {  
    	return $this->belongsTo('App\Models\MembershipModel','membership_id','plan_id');
    }
      public function business()
    {
        return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }
      public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel','category_id','cat_id');
    }

}
