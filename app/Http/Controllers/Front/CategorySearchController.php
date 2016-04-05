<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\FavouriteBusinessesModel;
use App\Models\UserModel;

use App\Models\CityModel;
use DB,Event;
use Session;
use URL;
use Meta;
//use Request;

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
      $page_title	=ucfirst(str_replace('-',' ',$cat_slug));

      $obj_sub_category = CategoryModel::where('parent',$cat_id)->orderBy('is_popular', 'DESC')->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}
      return view('front.category_search',compact('page_title','arr_sub_category','cat_slug','cat_id','c_city'));
    }

    public function get_business($city,$cat_id)
    {
     $page_title	='Business List';

     //dd($request->all());
      //echo $cat_id;

      // get business listing by city and category id
     if($cat_id==0)
         {
           Session::forget('category_serach');
           Session::forget('category_id');
           Session::forget('distance');


           $arr_business =$arr_sub_cat=$parent_category=$sub_category= array();
          return view('front.listing.index',compact('page_title','arr_business','arr_sub_cat','parent_category','sub_category','city'));
          //return redirect()->back();
         }
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

      $obj_business_listing_cat = BusinessCategoryModel::where('category_id',$cat_id)->get();
      if($obj_business_listing_cat)
      {
        $obj_business_listing_cat->load(['business_by_category','business_rating']);
        $arr_business_by_category = $obj_business_listing_cat->toArray();
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

            $obj_business_listing = BusinessListingModel::whereIn('id', $result)->with(['reviews']);
            if( Session::has('review_rating'))
            {
                $obj_business_listing->orderBy('avg_rating','DESC');
            }
            else
            {
                $obj_business_listing->orderBy('visited_count','DESC');
            }

            $obj_business_listing=$obj_business_listing
                          ->get();


              if(Session::has('user_mail'))
              {
                  $obj_user = UserModel::where('email',Session::get('user_mail'))->first(['id']);
                  $user_id  = $obj_user->id;
                  $arr_fav_business = array();
                  $str = "";
                  $obj_favourite = FavouriteBusinessesModel::where(array('user_id'=>$user_id ,'is_favourite'=>"1" ))->get(['business_id']);

                  if($obj_favourite)
                  {
                    $obj_favourite->toArray();

                    foreach ($obj_favourite as $key => $value)
                    {
                      array_push($arr_fav_business, $value['business_id']);
                    }
                  }
                  else
                  {
                    $arr_fav_business = array();
                  }
              }
              else
              {
                  $arr_fav_business = array();
               }

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

        $mete_title = "";
        if(isset($parent_category[0]['title']) && sizeof($parent_category[0]['title']))
        {
          $mete_title = $parent_category[0]['title'];
        }

        $meta_desp = "";
        if(isset($parent_category[0]['cat_meta_description']) && sizeof($parent_category[0]['cat_meta_description']))
        {
          $meta_desp = $parent_category[0]['cat_meta_description'];
        }

        $meta_keyword = array();
        if(isset($parent_category[0]['cat_meta_keyword']) && sizeof($parent_category[0]['cat_meta_keyword']))
        {
          $meta_keyword = explode(',',$parent_category[0]['cat_meta_keyword']);
        }


        Meta::setDescription($meta_desp);
        Meta::addKeyword($meta_keyword);


      return view('front.listing.index',compact('page_title','arr_business','arr_fav_business','arr_sub_cat','parent_category','sub_category','city'));
    }


     /* Search by location */
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
                                                 })->with(['reviews']);

                                               // ->get();
//dd($obj_business_listing->toSql());
//dd($arr_business);
                                                 /*$obj_business_listing->toSql();
                                                  dd($obj_business_listing);
                                                 exit;*/
                                                 //echo Session::get('location_latitude');
                if(Session::has('location_latitude') && Session::has('location_longitude'))
                {
                    $latitude=Session::has('location_latitude') ? Session::get('location_latitude'):'51.033320760';
                    $longitude=Session::has('location_longitude') ? Session::get('location_longitude'):'13.757242110';


               /* if(Session::has('preferred_latitude') && Session::has('preferred_longitude'))
                {
                    $latitude=Session::has('preferred_latitude') ? Session::get('preferred_latitude'):'51.033320760';
                    $longitude=Session::has('preferred_latitude') ? Session::get('preferred_longitude'):'13.757242110';*/
                     $qutt='*,ROUND( 6371 * acos (
                        cos ( radians('.$latitude.') )
                        * cos( radians( `lat` ) )
                        * cos( radians( `lng` ) - radians('.$longitude.') )
                        + sin ( radians('.$latitude.') )
                        * sin( radians( `lat` ) )
                      ),2) as distance';

                      $obj_business_listing = $obj_business_listing->selectRaw($qutt);
                       $distance=Session::has('distance') ? Session::get('distance'):'1';
                      //exit;
                      $search_range=$distance;
                      if($search_range==TRUE)
                      {
                          $obj_business_listing = $obj_business_listing->having('distance', '< ', $search_range);
                      }

                }
                 if( Session::has('review_rating'))
                {
                  $obj_business_listing->orderBy('avg_rating','DESC');

                }else
                {
                 $obj_business_listing->orderBy('visited_count','DESC');

                }


                $obj_business_listing= $obj_business_listing

                                        ->get();
                //dd($obj_business_listing->toArray);

                if($obj_business_listing)
                {
                  $arr_business = $obj_business_listing->toArray();
                   //dd($arr_business);
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
        return view('front.listing.index',compact('page_title','arr_business','city','arr_sub_cat','parent_category','sub_category','loc','category_set'));
    }
    public function set_location_lat_lng(Request $request)
    {
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            Session::put('location_latitude',$lat);
            Session::put('location_longitude',$lng);
            $result['status'] ="1";
            return response()->json($result);

    }

    public function set_distance_range(Request $request)
    {
            $business_search_by_location = $request->input('business_search_by_location');
            $search_under_category = $request->input('search_under_category');
            $search_under_city = $request->input('search_under_city');
            $distance = $request->input('distance');
            Session::put('distance',$distance);
            $result['status'] ="1";
            return response()->json($result);
    }

    public function set_rating()
    {
            Session::forget('location_latitude');
            Session::forget('location_longitude');
            Session::forget('distance');
            Session::put('review_rating','higher');
            $result['status'] ="1";
            return response()->json($result);
    }
    public function clear_rating()
    {
            Session::forget('review_rating');
            $result['status'] ="1";
            return response()->json($result);
    }
}
