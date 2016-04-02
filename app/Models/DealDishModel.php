<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealDishModel extends Model
{
   use SoftDeletes;

    protected $table = 'deal_dishes';

    protected $fillable = ['category_id',
    					   'deal_id',
    					   'dish_id',
    					   'quantity',
                 'parent_category_id'];


    public function category()
    {
       return $this->belongsTo('App\Models\CategoryModel','category_id','id');
    }

}
