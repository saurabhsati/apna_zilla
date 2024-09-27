<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsSliderImagesModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals_slider_images';

    protected $fillable = [
        'deal_id',
        'image_name',
    ];
}
