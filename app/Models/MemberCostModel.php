<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberCostModel extends Model
{
    use SoftDeletes;

    protected $table = 'membership_cost_category';

    protected $fillable = ['id',
        'category_id',
        'premium_cost',
        'gold_cost',
        'basic_cost',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\CategoryModel::class, 'category_id', 'cat_id');
    }
}
