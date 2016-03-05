<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontSliderModel extends Model
{
    //
    protected $table = 'front_slider';

   // public $translationModel        = 'App\Model\FrontSliderTranslationModel';
    public $translationForeignKey   = 'slider_id';
    //public $translatedAttributes    = ['title','link','image'];

    protected $fillable			 	= [
	    								'public_key',
	    								'title',
	    								'link',
	    								'image',
	    								'order_index'
	    								];
}
