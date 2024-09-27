<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewsModel extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = ['business_id',
        'user_id',
        'title',
        'message',
        'mobile_number',
        'email',
        'ratings',
        'name',
        'is_active',
    ];

    public function business_details()
    {
        return $this->belongsTo('App\Models\BusinessListingModel', 'business_id', 'id');
    }
}
