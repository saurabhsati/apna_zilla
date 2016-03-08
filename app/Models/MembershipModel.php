<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipModel extends Model
{
    protected $table = 'membership_plans';

    protected $fillable = [ 'plan_id',
    						'title',
    						'description',
    						'price',
    						'validity',
    						'description'
    					  ];
}
