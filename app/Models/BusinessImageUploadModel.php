<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessImageUploadModel extends Model
{
    //
    protected $table="business_upload_image";
     protected $fillable=['business_id',
     					  'image_name'
                         ];
}
