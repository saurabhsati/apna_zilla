<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
    	$arr_category = array();
    	$page_title	='Home';
 		$obj_category = CategoryModel::where('is_popular','1')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}
 		return view('front.home',compact('page_title'));
    }
}
