<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
	use SoftDeletes;
	
    protected $table = "categories";
     protected $fillable = ['cat_desc', 'cat_slug','cat_meta_description','cat_meta_keyword', 'parent','cat_img','cat_thumb','cat_order','is_active','cat_logo','is_priceable'];

    /**
     *  Relation with  category_lang record .
     */

     /**
     *  Relation with  self .
     */
    public function parent_category()
    {
        return $this->belongsTo('App\Model\Category','parent','cat_id');
    }

    public function parent_category_with_lang()
    {
        return $this->hasMany('App\Model\CategoryLang','fk_cat_id','parent');
    }

    /**
     *  Relation with  self . Child Category
     */
    public function child_category()
    {
        return $this->hasMany('App\Model\Category','parent','cat_id');
    }


    public function brands()
    {
        return $this->hasMany('App\Model\CategoryBrand','fk_cat_id','cat_id');   
    }

    public function ads()
    {
        return $this->hasMany('App\Model\Ad','subcategory_id_fk','cat_id');      
    }

    public function paginated_ads()
    {
        return $this->ads()->paginate(10);
    }

    public function delete_child_category()
    {
        $this->child_category()->delete();
    }
    
    public function attribute()
    {
      return $this->hasMany('App\Model\Attribute','fk_category_id','cat_id');
    }
}