<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\CategoryModel;

class CategoryController extends Controller
{
    public function get_sub_category($id)
    {
        $obj_category = CategoryModel::where('parent', $id)->where('is_active', '1')->get();

        $arr_category = [];
        $arr_response = [];

        if ($obj_category && count($obj_category) > 0) {
            $arr_category = $obj_category->toArray();

            $arr_response['status'] = 'SUCCESS';
            $arr_response['data'] = $arr_category;
        } else {
            $arr_response['status'] = 'ERROR';
            $arr_response['data'] = $arr_category;
        }

        return response()->json($arr_response);
    }
}
