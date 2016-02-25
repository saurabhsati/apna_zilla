<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AttributeOptionValueModel;


class AttributeModel extends Model
{
    //use SoftDeletes;

    protected $table = 'attribute';


    protected $fillable = ['fk_category_id', 
                            'attribute_code', 
    						'backend_type',
    						'frontend_input',
    						'frontend_label',
    						'frontend_label_de',
    						'frontend_class',
    						'fk_attribute_validation',
    						'is_global',
    						'is_visible',
    						'is_required',
    						'is_user_define',
    						'default_value',
    						'is_fillterable',
    						'position',
    						'is_advance_search',
    						'range_min',
    						'range_max',
    						'is_searchable',
    						'front_fitter_type',
    						'is_active',
    						'created_at',
    						'updated_at'];

    /**
     *  Relation with  AttributeOptionValue.
     */
    public function option_values()
    {
        return $this->hasMany('App\Models\AttributeOptionValue','attribute_id_fk','attribute_id');
    }

    public function delete_option_values()
    {
        $this->option_values()->delete();
    }

}

