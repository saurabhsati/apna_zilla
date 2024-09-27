<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffersModel extends Model
{
    use SoftDeletes;

    protected $table = 'offers';
    protected $fillable = [
          					   'deal_id',
                       'title',
                       'name',
                       'description',
                       'is_active',
      	  					   'main_price',
      	               'discount',
      	  					   'discounted_price',
      	  					   'limit',
      	  					   'valid_from',
      	  					   'valid_until',
      	  					  ];
     public function deal_info()
    {
        return $this->belongsTo('App\Models\DealsOffersModel','deal_id','id');
    }

}
