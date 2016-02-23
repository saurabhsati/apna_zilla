<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipModel extends Model
{
    protected $table = 'membership';

    protected $fillable = ['membership',
    						'price',
    						'no_normal_deals',
    						'no_instant_deals',
    						'no_featured_deals',
    						'description'];
}
