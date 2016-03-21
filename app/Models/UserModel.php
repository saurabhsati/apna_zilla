<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
	use SoftDeletes;
	
    protected $table = "users";

    protected $fillable = ['first_name',
    					   'middle_name',
    					   'last_name',
    					   'gender',
    					   'dd',
                           'mm',
                           'yy',
    					   'email',
    					   'password',
    					   'street_address',
    					   'city',
    					   'area',
                           'pincode',
    					   'occupation',
    					   'work_experience',
    					   'mobile_no',
    					   'home_landline',
                           'std_home_landline',
                           'office_landline',
                           'std_office_landline',
                           'extn_office_landline',
                           'title',
    					   'is_active',
    					   'profile_pic'];


}
