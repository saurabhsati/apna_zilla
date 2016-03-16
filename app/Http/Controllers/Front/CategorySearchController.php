<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\CityModel;
use DB,Event;
use Session;
class CategorySearchController extends Controller
{
    public function index($cat_slug,$cat_id)
    {
    	$page_title	='List Of Category ';
        $obj_sub_category = CategoryModel::where('parent',$cat_id)->orderBy('is_popular', 'DESC')->get();
	 	if($obj_sub_category)
	 	{
	 		$arr_sub_category = $obj_sub_category->toArray();
	 	}
      return view('front.category_search',compact('page_title','arr_sub_category','cat_slug','cat_id'));
    }
    public function get_business($cat_id)
    {
    	$page_title	='Business List';

        // get business listing by category id
    	$arr_business = array();
 		$obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
 		if($obj_business_listing)
 		{
            $obj_business_listing->load(['business_by_category','business_rating']);
 			$arr_business = $obj_business_listing->toArray();
        }
//dd($arr_business);
        //BusinessListingModel::where('',)

        // Getting Related Categories

        $obj_sub_category = CategoryModel::where('cat_id',$cat_id)->get();
        if($obj_sub_category)
        {
            $sub_category = $obj_sub_category->toArray();
        }

        if(sizeof($sub_category)>0)
        {
          $main_cat_id=$sub_category[0]['parent'];
           $obj_parent_category = CategoryModel::where('cat_id',$main_cat_id)->get();
            if($obj_parent_category)
            {
                $parent_category = $obj_parent_category->toArray();
            }

        }

        $obj_sub_cat = CategoryModel::where('parent',$main_cat_id)->orderBy('is_popular', 'DESC')->get();
        if($obj_sub_cat)
        {
            $arr_sub_cat = $obj_sub_cat->toArray();
        }

      return view('front.listing.index',compact('page_title','arr_business','arr_sub_cat','parent_category','sub_category'));
    }
    public function search_location(Request $request)
    {
        $arr=array();
        $arr=$request->all();

        $city=Session::get('preferred_city');
        $city_all='';

         if($city!='')
          {
              $city_all = '/'.$city;
          }
          else
          {
            $cityall = '/city';
          }
        if($request->has('term'))
       {
          $search_location  = $request->input('term');
          $search_city = $request->input('city_name');
          $search_category_id = $request->input('category_id');
          $search_slug  = str_slug($search_location,'-');
          $search_city !='' ? ($city_all = '/'.$search_city) : ($city = '');

         $obj_business_listing = CityModel::with(['business_details'])->where('city_title', 'like', "%".$search_location."%")->get();
         $arr_search  = $obj_business_listing->toArray();
         $link = '';
         if(sizeof($arr_search)>0){
          foreach ($arr_search as $key => $value)
          {
            foreach ($value['business_details'] as $key => $business)
              {
              $link = url('/').$city_all.'/all-options/'.$search_category_id;

               $label[] = $business['area'];
              $searchresult[$key]['link'] = url('/').$city_all.'/all-options/'.$search_category_id;
              }
          }
          print_r($label);
         }


          $input = array_map("unserialize", array_unique(array_map("serialize", $searchresult)));
        $input[] = array('label'=>$search_location, 'cat_name'=>'in all categories', 'link'=>url('/').$city_all.'/all-options/'.$search_category_id);
        return response()->json($input);
       }
        //echo"test";
    }
}
