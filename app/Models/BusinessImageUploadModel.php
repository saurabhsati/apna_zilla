<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessImageUploadModel extends Model
{

    use SoftDeletes;
    protected $table="business_upload_image";
     protected $fillable=['business_id',
     					  'image_name'
                         ];
}
