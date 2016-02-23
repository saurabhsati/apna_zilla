<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuisineModel extends Model
{
    protected $table = 'cuisine';

    protected $fillable = ['cuisine','is_active'];
}
