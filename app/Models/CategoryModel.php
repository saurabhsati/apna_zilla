<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
	use SoftDeletes;
	
    protected $table = "categories";
    protected $fillable = ['category','is_active'];

}
