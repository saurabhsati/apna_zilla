<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmailTemplate extends Model
{

    use SoftDeletes;
     protected $table = 'email_template';

    protected $fillable = ['template_name',
    						'template_subject',
    						'template_from',
    						'template_from_mail',
    						'template_html',
    						'template_variables',
    						'is_active'
    						];

}
