<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeOptionValueModel extends Model
{
    use SoftDeletes;

    protected $table = 'attribute_option_value';

    protected $fillable = [
        'attribute_id_fk',
        'value',
        'sort_order',
        'is_default_selected',
        'created_at',
        'updated_at',

    ];
}
