<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FavouriteBusinessesModel extends Model
{

    use SoftDeletes;
    protected $table = 'favourite_businesses';
    protected $primaryKey = 'id';
    protected $fillable = [
						      'user_id',
						      'business_id',
						      'is_favourite'

						       ];

	public function business()
	{
		 return $this->hasMany('App\Models\BusinessListingModel',
          'id','business_id');
	}				       
}
