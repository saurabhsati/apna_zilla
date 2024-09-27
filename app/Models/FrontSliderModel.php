<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontSliderModel extends Model
{
    use SoftDeletes;

    protected $table = 'front_slider';

    // public $translationModel        = 'App\Model\FrontSliderTranslationModel';
    public $translationForeignKey = 'slider_id';
    //public $translatedAttributes    = ['title','link','image'];

    protected $fillable = [
        'public_key',
        'title',
        'link',
        'image',
        'order_index',
    ];
}
