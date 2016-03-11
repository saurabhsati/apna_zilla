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

}
