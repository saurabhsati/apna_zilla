<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
	use SoftDeletes;
	
    protected $table = "sales";

    protected $fillable = ['first_name',
    					   'middle_name',
    					   'last_name',
    					   'gender',
    					   'd_o_b',
    					   'email',
    					   'password',
    					   'street_address',
    					   'city',
    					   'area',
    					   'occupation',
    					   'work_experience',
    					   'mobile_no',
    					   'home_landline',
    					   'office_landline',
    					   'is_active',
    					   'profile_pic'];


}
