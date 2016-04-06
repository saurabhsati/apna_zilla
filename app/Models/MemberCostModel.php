<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCostModel extends Model
{
     protected $table = 'membership_cost_category';

    protected $fillable = [ 'id',
    						'category_id',
    						'premium_cost',
    						'gold_cost',
    						'basic_cost'
    					  ];
     public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel','category_id','cat_id');
    }
}
