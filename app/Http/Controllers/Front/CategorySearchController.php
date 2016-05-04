<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

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
use View;
//use Request;

class CategorySearchController extends Controller
{
    public function index($city,$cat_slug,$cat_id)
    {
      $page_title =ucfirst(str_replace('-',' ',$cat_slug));

      /* Set City Ether by share location or search a particular city*/
      if(Session::has('search_city_title'))
      {
        $c_city=Session::get('search_city_title');
      }
      else if(Session::has('city'))
      {
        $c_city=Session::get('city');
      }
      else
      {
        $c_city='Mumbai';
      }

      /* Get Sub-Categories under parent category */

      $obj_sub_category = CategoryModel::where('parent',$cat_id)->where('is_active','1')->orderBy('is_popular', 'DESC')->get();
  	 	if($obj_sub_category)
  	 	{
  	 		$arr_sub_category = $obj_sub_category->toArray();
  	 	}

      return view('front.category_search',compact('page_title','arr_sub_category','cat_slug','cat_id','c_city'));
    }

    public function get_business(Request $request,$city,$cat_id,$ajax_set='false')
    {
        $page_title	='Business List';
        Session::forget('distance');
        Session::forget('location_latitude');
        Session::forget('location_longitude');

        /* Get Business By Category and City  */
        if($cat_id==0)
        {
          Session::forget('category_serach');
          Session::forget('category_id');
          Session::forget('distance');

          $arr_business =$arr_sub_cat=$parent_category=$sub_category= array();
          return view('front.listing.index',compact('page_title','arr_business','arr_sub_cat','parent_category','sub_category','city'));
        }

        /* Get Business by city selected */
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

        /* Get Business by Sub-Category Selected */
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

        /* Merge the business by city and Business by category result  and generate the complete business id's array */
         $obj_business_listing=[];
        if(sizeof($key_business_city)>0 && sizeof($key_business_cat))
        {
            $result = array_intersect($key_business_city,$key_business_cat);

            $arr_business = array();
            if(sizeof($result)>0)
            {
              /* fetch business records by id's */
              $obj_business_listing = BusinessListingModel::where('is_active','1')->whereIn('id', $result)->with(['reviews']);

              /* Get business records list order by review as Descending order */
              if( Session::has('review_rating'))
              {
                  $obj_business_listing->orderBy('avg_rating','DESC');
              }
              else
              {
                 /* Get business records list order by mostly visited as Descending order */
                  $obj_business_listing->orderBy('visited_count','DESC');
              }


           }
        }

        /* Get  Main Category data*/
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
        /* Get All related Sub category  data*/
        $obj_sub_cat = CategoryModel::where('parent',$main_cat_id)->orderBy('is_popular', 'DESC')->get();
        if($obj_sub_cat)
        {
            $arr_sub_cat = $obj_sub_cat->toArray();
        }

        /* If User has login see he can see their favorite  business */
        if(Session::has('user_id'))
        {
              $user_id  = base64_decode(Session::get('user_id'));
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

        /* Set the meta title ,keywords & description on page business listing*/
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
       $main_image_path="uploads/business/main_image";
       if($ajax_set=='false' && sizeof($obj_business_listing)>0)
       {
         // $obj_business_listing = $obj_business_listing->get();

          $obj_business_listing = $obj_business_listing->paginate(2);
             if($obj_business_listing)
              {
                $arr_business = [];
                $total_pages = 0;
                $current_page = 0;
                $per_page = 0;
                $last_page = 0;
                $arr_tmp = $obj_business_listing->toArray();
                //dd($arr_tmp);
                if( isset($arr_tmp['data']) && sizeof($arr_tmp['data'])>0)
                {
                  $arr_business = $arr_tmp['data'];
                  $total_pages =  $arr_tmp['total'];
                  $current_page = $arr_tmp['current_page'];
                  $per_page = $arr_tmp['per_page'];
                  $last_page = $arr_tmp['last_page'];
                }
                else
                {
                  $arr_business = $arr_tmp;
                }

              }
          return view('front.listing.index',compact('page_title','total_pages','current_page','per_page','arr_business','arr_fav_business','arr_sub_cat','parent_category','sub_category','city','main_image_path'));
       }
       else if(sizeof($obj_business_listing)>0)
       {
          $page=$request->input('page');
          $view_set= $request->input('view_set');

          $obj_business_listing = $obj_business_listing->paginate(2);

          if($obj_business_listing)
          {
            $arr_business = [];

            $arr_tmp = $obj_business_listing->toArray();

            if(sizeof($arr_tmp['data'])>0)
            {
              $arr_business = $arr_tmp['data'];

              if($view_set=='list_view_is_set')
              {
                 $view  = View::make('front.listing._list_view_load_more_business',compact('arr_business','main_image_path','city'));
              }
              else
              {
                $view  = View::make('front.listing._grid_view_load_more_business',compact('arr_business','main_image_path','city'));
              }
              if($view!='')
              {
                $arr_data['content']  = $view->render();
              }
              else
              {
                $arr_data['content']  = "no_data";
              }
              $arr_data['page']  = $arr_tmp['current_page'];
              return response()->json($arr_data);
            }


          }


       }
       else
       {
       //dd("test");
        $arr_business =[];
          return view('front.listing.index',compact('page_title','total_pages','current_page','per_page','arr_business','arr_fav_business','arr_sub_cat','parent_category','sub_category','city','main_image_path'));
       }
    }


     /* Search by location */
    public function search_business_by_location(Request $request,$city,$cat_loc,$cat_id,$page='1')
    {

          $page_title ='Search by Location ';
          /* explode the category & location string */
          $cat_location=explode('@',$cat_loc);
          if(!empty($cat_location))
          {
             $loc=str_replace('-',' ',$cat_location[1]);
             $category_set=str_replace('-',' ',$cat_location[0]);
          }


           /* Get Business by city selected */
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

            /* Get Business by category */
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
             $obj_business_listing=[];
            /* Merge the business by city and Business by category result  and generate the complete business id's array */

            if(sizeof($key_business_city)>0 && sizeof($key_business_cat))
            {
                $result = array_intersect($key_business_city,$key_business_cat);
                $arr_business = array();
                if(sizeof($result)>0)
                {
                  $obj_business_listing = BusinessListingModel::whereIn('id',$result)->with(['reviews']);


                  /* If Location lat & log has been set by session calculate the distance range and get the business under that range */
                  if(Session::has('location_latitude') && Session::has('location_longitude'))
                  {
                      $latitude=Session::has('location_latitude') ? Session::get('location_latitude'):'51.033320760';
                      $longitude=Session::has('location_longitude') ? Session::get('location_longitude'):'13.757242110';
                      $qutt='*,ROUND( 6379 * acos (
                          cos ( radians('.$latitude.') )
                          * cos( radians( `lat` ) )
                          * cos( radians( `lng` ) - radians('.$longitude.') )
                          + sin ( radians('.$latitude.') )
                          * sin( radians( `lat` ) )
                        ),2) as distance';

                        $obj_business_listing = $obj_business_listing->selectRaw($qutt);
                        if(Session::has('distance'))
                        {
                         $distance=Session::get('distance');
                         $search_range=(int)$distance;
                         //echo $search_range;exit;

                         if($obj_business_listing)
                          {
                              $obj_business_listing = $obj_business_listing->having('distance', ' < ', $search_range);
                          }
                        }
                        else
                        {
                          if($obj_business_listing)
                          {
                              $obj_business_listing = $obj_business_listing->having('distance', ' < ', 100);
                          }
                        }


                  }
                   //dd($obj_business_listing->get());
                  /* Get business records list order by review as Descending order */
                  if( Session::has('review_rating'))
                  {
                    $obj_business_listing->orderBy('avg_rating','DESC');

                  }else
                  {
                   $obj_business_listing->orderBy('visited_count','DESC');

                  }


              }
          }
          /* Get Sub -Category data */
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


          /* Get Related Sub -Category data */

          $obj_sub_cat = CategoryModel::where('parent',$main_cat_id)->orderBy('is_popular', 'DESC')->get();
          if($obj_sub_cat)
          {
              $arr_sub_cat = $obj_sub_cat->toArray();
          }



          /* If User has login see he can see their favorite  business */
          if(Session::has('user_id'))
          {
              
              $user_id  = base64_decode(Session::get('user_id'));
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


          $main_image_path="uploads/business/main_image";

          /* Pagination on load 0r view more */

          if($page=='1' && count($obj_business_listing)>0 && isset($obj_business_listing))
          {
              $total_record_count = clone $obj_business_listing;
             $chk_arr=[];
              $chk_arr=$total_record_count->get()->toArray();
            // dd($chk_arr);
             if(isset($chk_arr) && sizeof($chk_arr)>0)
            {
            $totalResult = $total_record_count->addSelect(DB::raw('count(*) as record_count'))->get();
            /*if(isset($totalResult) && sizeof($totalResult)>0)
            {*/
                 $totalItems = 1;


                if(isset($totalResult[0]))
                {
                  $totalItems = $totalResult[0]->record_count;
                }



                $perPage =2;
                $curPage = $request->input('page','1');

                $itemQuery = clone $obj_business_listing;
                $all_records = clone $obj_business_listing;



                // this does the sql limit/offset needed to get the correct subset of items
                $items = $itemQuery->forPage($curPage, $perPage)->remember(15)->get();


                $this->Paginator = new Paginator($items->all(),$perPage, $curPage);
                $arr_paginate_business =  $this->Paginator->toArray();
                $arr_paginate_business['total']     =  $totalItems;
                $arr_paginate_business['last_page'] =  (int)ceil($totalItems/$perPage);
                //dd($arr_paginate_business);

                 $obj_business_listing = $obj_business_listing->get();

                   if($arr_paginate_business)
                      {
                        $arr_business = [];
                        $arr_tmp = $arr_paginate_business;
                        //dd($arr_tmp['data']);
                        if( isset($arr_tmp['data']) && sizeof($arr_tmp['data'])>0)
                        {
                          $arr_business = $arr_tmp['data'];
                          $total_pages =  $arr_tmp['total'];
                          $current_page = $arr_tmp['current_page'];
                          $per_page = $arr_tmp['per_page'];
                        }
                        else
                        {
                          $arr_business = $arr_tmp;
                        }

                      }
                }


              return view('front.listing.index',compact('page_title','total_pages','current_page','per_page','arr_business','arr_fav_business','arr_sub_cat','parent_category','sub_category','city','main_image_path','arr_paginate_business'));
           }
           else
           {
              $arr_business =[];

              return view('front.listing.index',compact('page_title','total_pages','current_page','per_page','main_image_path','page_title','arr_business','city','arr_sub_cat','parent_category','sub_category','loc','category_set','arr_fav_business'));
           }
        //return view('front.listing.index',compact('main_image_path','page_title','arr_business','city','arr_sub_cat','parent_category','sub_category','loc','category_set','arr_fav_business'));
    }

    public function set_location_lat_lng(Request $request)
    {
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            Session::put('location_latitude',$lat);
            Session::put('location_longitude',$lng);
            Session::forget('review_rating');
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
            Session::forget('location_latitude');
            Session::forget('location_longitude');

            $result['status'] ="1";
            return response()->json($result);
    }
}
