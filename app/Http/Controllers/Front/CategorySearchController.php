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
   public function __construct()
    {
    }

    public function index($city,$cat_slug,$cat_id)
    {
      $current_city='';
      $current_city = Session::get('city');
      if(!empty($current_city))
      {
        $c_city=$current_city;
      }
      else
      {
        $c_city='Mumbai';
      }
      $page_title	='List Of Category ';
      $obj_sub_category = CategoryModel::where('parent',$cat_id)->orderBy('is_popular', 'DESC')->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}
      return view('front.category_search',compact('page_title','arr_sub_category','cat_slug','cat_id','c_city'));
    }

    public function get_business($city,$cat_id,Request $request)
    {
     $page_title	='Business List';

     //dd($request->all());
      //echo $city;

      // get business listing by city and category id

      $obj_business_listing_city = CityModel::where('city_title',$city)->get();
      if($obj_business_listing_city)
      {
        $obj_business_listing_city->load(['business_details']);
        $arr_business_by_city = $obj_business_listing_city->toArray();
      }
       $key_business_city=array();
       if(sizeof($arr_business_by_city)>0)
        {
          foreach ($arr_business_by_city[0]['business_details'] as $key => $value) {
            $key_business_city[$value['id']]=$value['id'];
          }
        }

      $obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
      if($obj_business_listing)
      {
        $obj_business_listing->load(['business_by_category','business_rating']);
        $arr_business_by_category = $obj_business_listing->toArray();
      }
      $key_business_cat=array();
      if(sizeof($arr_business_by_category)>0)
      {
          foreach ($arr_business_by_category as $key => $value) {
            $key_business_cat[$value['business_id']]=$value['business_id'];
          }
      }
      if(sizeof($key_business_city)>0 && sizeof($key_business_cat))
      {
          $result = array_intersect($key_business_city,$key_business_cat);

          $arr_business = array();
          if(sizeof($result)>0)
          {
            $obj_business_listing = BusinessListingModel::whereIn('id', $result)->with(['reviews'])->get();
            if($obj_business_listing)
            {
              $arr_business = $obj_business_listing->toArray();

            }
          }
      }

      // Get Sub category & Main Category data
        $obj_sub_category = CategoryModel::where('cat_id',$cat_id)->get();
        if($obj_sub_category)
        {
            $sub_category = $obj_sub_category->toArray();
        }
        if(count($sub_category) > 0) {
             Session::put('category_serach', $sub_category[0]['title']);
             Session::put('category_id', $sub_category[0]['cat_id']);
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

        //dd($arr_business);
      return view('front.listing.index',compact('page_title','arr_business','arr_sub_cat','parent_category','sub_category','city'));
    }
    public function search_business_by_location($city,$cat_loc,$cat_id)
    {
      $cat_location=explode('@',$cat_loc);
     // dd($cat_location);
      if(!empty($cat_location))
      {
         $loc=str_replace('-',' ',$cat_location[1]);
         $category_set=str_replace('-',' ',$cat_location[0]);
      }
//dd($loc_arr);
      $page_title ='Search by Location ';

      //by city
      $obj_business_listing_city = CityModel::where('city_title',$city)->get();
      if($obj_business_listing_city)
      {
        $obj_business_listing_city->load(['business_details']);
        $arr_business_by_city = $obj_business_listing_city->toArray();
      }
       $key_business_city=array();
       if(sizeof($arr_business_by_city)>0)
        {
          foreach ($arr_business_by_city[0]['business_details'] as $key => $value) {
            $key_business_city[$value['id']]=$value['id'];
          }
        }

        //by category
      $obj_business_listing = BusinessCategoryModel::where('category_id',$cat_id)->get();
      if($obj_business_listing)
      {
        $obj_business_listing->load(['business_by_category','business_rating']);
        $arr_business_by_category = $obj_business_listing->toArray();
      }
      $key_business_cat=array();
      if(sizeof($arr_business_by_category)>0)
      {
          foreach ($arr_business_by_category as $key => $value) {
            $key_business_cat[$value['business_id']]=$value['business_id'];
          }
      }

       if(sizeof($key_business_city)>0 && sizeof($key_business_cat))
      {
          $result = array_intersect($key_business_city,$key_business_cat);

          $arr_business = array();
          if(sizeof($result)>0)
          {
           // echo $loc;
            $obj_business_listing = BusinessListingModel::whereIn('id',$result)
                                            ->where(function ($query) use ($loc)
                                              {
                                               $query->orwhere("area", 'like', "%".$loc."%")
                                               ->orwhere("street", 'like', "%".$loc."%")
                                               ->orwhere("landmark", 'like', "%".$loc."%")
                                               ->orwhere("building", 'like', "%".$loc."%");
                                             })->with(['reviews'])
                                            ->get();
                                      // dd($obj_business_listing);
            if($obj_business_listing)
            {
              $arr_business = $obj_business_listing->toArray();

            }
          }
      }
        //dd($arr_business);
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
        //dd($loc);
return view('front.listing.index',compact('page_title','arr_business','city','arr_sub_cat','parent_category','sub_category','loc','category_set'));
    }
}
