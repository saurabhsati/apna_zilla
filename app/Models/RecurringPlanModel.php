<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RecurringPlanModel extends Model
{

    use SoftDeletes;

    protected $table = 'recurring_plans';

    protected $fillable = ['membership_name',
    						'membership_price',
    						'no_monthly_cycle'];
}
