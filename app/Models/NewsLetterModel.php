<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class NewsLetterModel extends Model
{

    use SoftDeletes;
    protected $table = 'news_letter';

    protected $fillable = ['name', 'email_address', 'is_active'];

}
