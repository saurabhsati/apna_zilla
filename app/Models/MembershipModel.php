<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipModel extends Model
{
    use SoftDeletes;

    protected $table = 'membership_plans';

    protected $fillable = ['plan_id',
        'title',
        'description',
        'price',
        'validity',
        'description',
    ];
}
