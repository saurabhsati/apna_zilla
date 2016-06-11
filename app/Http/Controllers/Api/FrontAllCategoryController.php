<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;



class FrontAllCategoryController extends Controller
{
	public function __construct()
	{
       $json                           = array();
    }

	public function get_all_main_Category()
	{
		    $arr_category = $data = array();
	    	$where_arr=array('parent'=>0);
	    	$obj_main_category = CategoryModel::where('is_active','1')->where($where_arr)->get();
	 		if($obj_main_category)
	 		{
	 			$arr_category = $obj_main_category->toArray();
	 		}
	 	
	    	if(isset($arr_category) && sizeof($arr_category)>0)
			{
				foreach ($arr_category as $key => $cat) 
				{
					$data[$key]['cat_id']       = $cat['cat_id'];
					$data[$key]['title']        = $cat['title'];
					$data[$key]['cat_slug']     = $cat['cat_slug'];
					$data[$key]['cat_ref_slug'] = $cat['cat_ref_slug'];
				}
			$json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Main Category List !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Main Category Record Found!';
		}
             return response()->json($json);	 	
	}

	public function get_all_sub_categories_category(Request $request)
	{
		  $data     = array();
		  $cat_id   = $request->input('cat_id');
		  $city     = $request->input('city');
		  $cat_slug = $request->input('cat_slug');

		$obj_sub_category = CategoryModel::where('parent',$cat_id)->where('is_active','1')->orderBy('is_popular', 'DESC')->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}
	    if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
		{
			foreach ($arr_sub_category as $key => $sub_cat) 
				{
					$data[$key]['cat_id']     = $sub_cat['cat_id'];
					$data[$key]['title']      = $sub_cat['title'];
					$data[$key]['is_popular'] = $sub_cat['is_popular'];
				}
		    $json['data'] 	 = $data;
			$json['status']  = 'SUCCESS';
			$json['message'] = 'Sub Categories List of Main Category !';
		}
		else
		{
			$json['status']  = 'ERROR';
			$json['message'] = 'No Sub Category of Main Category Record Found!';
		}
             return response()->json($json);	 	
	     
   
	}

}
