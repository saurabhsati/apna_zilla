<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BusinessServiceModel extends Model
{

    use SoftDeletes;
	protected $table='business_service';
    protected $fillable=[
                         'business_id',
                         'name'
                         ];
}
