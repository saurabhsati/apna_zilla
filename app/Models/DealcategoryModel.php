<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealcategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals_category';

    protected $fillable = [
        'deal_id',
        'main_cat_id',
        'sub_cat_id',
    ];
}
