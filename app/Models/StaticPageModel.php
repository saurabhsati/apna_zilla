<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageModel extends Model
{
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
