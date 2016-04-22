<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaticPageModel extends Model
{

    use SoftDeletes;
    protected $table = 'static_pages';
    protected $fillable = ['static_page_id',
    						'page_slug',
						    'page_title',
						    'page_desc',
							'meta_title',
							'meta_keyword',
						    'meta_desc',
						    ];
}
