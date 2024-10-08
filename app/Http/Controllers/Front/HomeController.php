<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BusinessListingModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\LocationModel;
use App\Models\BusinessCategoryModel;
use App\Models\PlaceModel;
use App\Models\DealModel;
use Session;
use Cache;

class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        
        $page_title	='Home';
        
        if(Session::has('city'))
        {
        	$current_city=Session::get('city');
        }
        else if(Session::has('search_city_title'))
        {
            $current_city=Session::get('search_city_title');
        }
        else
        {
           $current_city='Delhi';
           Session::put('share_lat',28.6538);
           Session::put('share_lng',77.229);
            
        }
    	$arr_category = array();

    	$where_arr=array('is_popular'=>1,'parent'=>0,'is_active'=>1);
    	$obj_main_category = CategoryModel::where($where_arr)->remember(15)->get();
 		if($obj_main_category)
 		{
 			$arr_category = $obj_main_category->toArray();
 		}

 		$obj_sub_category = CategoryModel::where('parent','!=',0)->get();
 		if($obj_sub_category)
 		{
 			$sub_category = $obj_sub_category->toArray();
 		}

 		$arr_business = array();
 		$obj_business_listing = BusinessListingModel::with(['category'])->get();
 		if($obj_business_listing)
 		{
 			$arr_business = $obj_business_listing->toArray();

 		}
 		//dd($arr_business);
 		$category_business=array();
 		foreach ($arr_business as $business)
 		{

 			if(sizeof($business['category'])>0)
 			{
	 			foreach ($business['category'] as $key => $cat)
	 			{

	 				if(!array_key_exists($cat['category_id'], $category_business))
	 				{
	 				  $category_business[$cat['category_id']]=1;
	 			    }
	 			    else
	 			    {
	 			    	$category_business[$cat['category_id']]=$category_business[$cat['category_id']]+1;
	 			    }

 				}
	 		}
	 		else
	 		{
                //$category_business[$cat['category_id']]='0';
	 			$category_business['category_id']=array('0');
	 		}
 		}
    //set first explore category business on home page
        $first_cat_images='';
        $obj_explore_category = CategoryModel::where('is_explore_directory',1)->get();
        if($obj_explore_category)
        {
            $explore_category = $obj_explore_category->toArray();
            $first_cat_images=$explore_category[0]['cat_img'];
        }

        if(sizeof( $explore_category)>0)
        {
            $key_sub_cat=[];
             $obj_sub_category = CategoryModel::where('parent',$explore_category[0]['cat_id'])->get();
            if($obj_sub_category)
            {
                $arr_sub_category = $obj_sub_category->toArray();
            }
            if(sizeof($arr_sub_category)>0)
            {
              foreach ($arr_sub_category as $key => $value) {
                $key_sub_cat[$value['cat_id']]=$value['cat_id'];
              }
            }
             $obj_business_listing_cat = BusinessCategoryModel::whereIn('category_id',$key_sub_cat)->get();
             if($obj_business_listing_cat)
            {
                $business_cat_listing = $obj_business_listing_cat->toArray();
            }
            $cat_ids=array();
            $business_ids=array();
            foreach ($business_cat_listing as $key => $value) {
                if(!array_key_exists($value['category_id'],$cat_ids))
                {
                    $cat_ids[$value['category_id']]=$value['category_id'];
                    $business_ids[$value['business_id']]=$value['business_id'];
                }
                else
                {
                    $business_ids[$value['business_id']]=$value['business_id'];
                }

            }
             $obj_business_listing = BusinessListingModel::where('is_active','1')->whereIn('id', $business_ids)->orderBy('created_at', 'DESC')->take(8)->get();
            if($obj_business_listing)
            {
                $business_listing = $obj_business_listing->toArray();
            }
       }
        //dd($business_listing);

 		//dd();
           $main_image_path="uploads/business/main_image";
 		 $cat_img_path = url('/').config('app.project.img_path.category');
 		return view('front.home',compact('page_title','first_cat_images','main_image_path','arr_category','sub_category','category_business','arr_exp_sub_category','cat_img_path','current_city','explore_category','business_listing'));
    }




    //share location
    //test

    public function locate_location(Request $request)
    {
    	 $lat=$request->input('lat');
    	 $lng=$request->input('lng');

         Session::put('share_lat',$lat);
         Session::put('share_lng',$lng);

    	 //$url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $lat, $lng);
             $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=AIzaSyBTxXd1ZVgKmI4y4_Pg2PXw2LCOIPHDMeM");
		    // $content = file_get_contents($url); // get json content
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

            $content = curl_exec($ch);
            curl_close($ch);
            //var_dump($content);
		    $metadata = json_decode($content, true); //json decoder
            $result=array();
            if(sizeof($metadata['results']))
            {
                $result = $metadata['results'][0];
                $city = "";
                if(sizeof($result)>0)
                {
                        for($i=0, $len=count($result['address_components']); $i<$len; $i++)
                        {
                            $ac = $result['address_components'][$i];
                           if(in_array('locality',$ac['types']))
                            {
                                $city = $ac['long_name'];
                            }


                        }
                        if($city != '')
                        {
                            Session::put('city', $city);
                               $obj_city = CityModel::where('city_title',$city)->first();
                                if($obj_city)
                                {
                                    $arr_city = $obj_city->toArray();
                                    if(!empty($arr_city))
                                    {
                                        Session::put('city_id', $arr_city['id']);
                                    }

                                }
                        }
                        else
                        {
                                 Session::put('city', 'Delhi');
                                 $obj_city = CityModel::where('city_title',"Delhi")->first();
                                if($obj_city)
                                {
                                    $arr_city = $obj_city->toArray();
                                    if(!empty($arr_city))
                                    {
                                        Session::put('city_id', $arr_city['id']);
                                    }

                                }
                        }
                        $response['status']='done';
                        $response['city']=$city;
                        return response()->json($response);
                       // echo "done";
                    }
                }
                else
                {
                    //echo "fail";
                     $response['status']='fail';
                      $response['city']='';
                     return response()->json($response);
                }


 	}
    public function get_city_auto(Request $request)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            $arr_obj_city = CityModel::where('is_active','=',1)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("city_title", 'like', "%".$search_term."%");
                                                                                        })->get();
            $arr_list_city = array();
            if($arr_obj_city)
            {
                $arr_list_city = $arr_obj_city->toArray();

                $arr_final_city_list = array();

                if(sizeof($arr_list_city)>0)
                {
                    foreach ($arr_list_city as $key => $list)
                    {
                        $arr_final_city_list[$key]['id'] = $list['id'];
                        $arr_final_city_list[$key]['label'] = $list['city_title'];

                    }

                }

            }
             if(sizeof($arr_final_city_list)>0)
            {
                 return response()->json($arr_final_city_list);
            }
            else
            {
                return response()->json(array());
            }

        }
        else
        {
           return response()->json(array());
        }

    }
 	public function get_category_auto(Request $request)
 	{
 		if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            /*List category by keyword*/
            $arr_obj_list = CategoryModel::where('parent','!=',0)
                                           ->where('is_active','=',1)
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("title", 'like', "%".$search_term."%")
                                             ->orwhere("cat_desc", 'like', "%".$search_term."%")
                                             ->orwhere("cat_meta_description", 'like', "%".$search_term."%");
                                             })->get();

            $arr_list = array();
            if($arr_obj_list)
            {
                $arr_list = $arr_obj_list->toArray();
                $arr_final_list = array();
                if(sizeof($arr_list)>0)
                {
                    foreach ($arr_list as $key => $list)
                    {
                        $arr_final_list[$key]['cat_id'] = $list['cat_id'];
                        $arr_final_list[$key]['label'] = $list['title'];
                        $arr_final_list[$key]['span'] = 'in business category';
                        $arr_final_list[$key]['data_type'] = 'list';
                    }

                }

            }

            if(Session::has('search_city_id'))
            {
                $city=Session::get('search_city_id');
            }
            else
            {
                $city=Session::get('city_id');
            }
            $ckey=sizeof($arr_final_list);


            /* Serch text as business name */
            $obj_business_listing = BusinessListingModel::where('city',$city)
                                    ->where(function ($query) use ($search_term) {
                                    $query->where('business_name','like',"%".$search_term."%")
                                    ->orWhere('keywords','like',"%".$search_term."%");
                                    })->get();
                                  //  return response()->json($obj_business_listing);
            if($obj_business_listing)
            {
                $arr_business = $obj_business_listing->toArray();
                $arr_final_business = array();
                if(sizeof($arr_business)>0)
                {
                    foreach ($arr_business as $key => $business)
                    {

                        $slug_business=str_slug($business['business_name']);
                        $slug_area=str_slug($business['area']);

                        $arr_final_list[$ckey]['business_id'] = base64_encode($business['id']);
                        $arr_final_list[$ckey]['label'] = $business['business_name'];
                        $arr_final_list[$ckey]['span'] = 'in business profile';
                        $arr_final_list[$ckey]['city'] = $business['city'];
                        $arr_final_list[$ckey]['slug']=$slug_business.'@'.$slug_area;
                        $arr_final_list[$ckey]['data_type'] = 'detail';
                        $ckey++;
                    }
                }


            }

            /* Deals by search text */
            $cckey=sizeof($arr_final_list);

            $obj_deals_info = DealModel::where('is_active','1')
                                        ->where('name','like',"%".$search_term."%")
                                        ->orderBy('created_at','DESC')->get();

            if($obj_deals_info)
            {
                $arr_deals_info = $obj_deals_info->toArray();
                $arr_final_business = array();
                if(sizeof($arr_deals_info)>0)
                {
                    foreach ($arr_deals_info as $key => $deal)
                    {
                        $arr_final_list[$cckey]['deal_id'] = base64_encode($deal['id']);
                        $arr_final_list[$cckey]['label'] = $deal['name'];
                        $arr_final_list[$cckey]['span'] = 'in deal';

                        $arr_final_list[$cckey]['slug']=urlencode(str_replace(' ','-',($deal['name'])));
                        $arr_final_list[$cckey]['data_type'] = 'deal_detail';
                        $cckey++;
                    }
                }
            }

                                    //return response()->json($obj_business_listing);
           if(sizeof($arr_final_list)>0)
            {
                 return response()->json($arr_final_list);
            }
            else
            {
                 return response()->json(array());
            }

        }
        else
        {
           return response()->json(array());
        }
 	}
    public function get_location_auto(Request $request)
    {
         Session::forget('location_latitude');
         Session::forget('location_longitude');
         Session::forget('review_rating','higher');
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            if(Session::has('search_city_title'))
            {
                $current_city=Session::get('search_city_title');
            }
            else if(Session::has('city'))
            {
                $current_city=Session::get('city');
            }
            else
            {
                $current_city='Delhi';
            }
             $arr_city=[];
             $obj_city_arr=CityModel::where('city_title',$current_city)->first();
             if($obj_city_arr)
             {
                $arr_city=$obj_city_arr->toArray();
             }
              $arr_obj_location = PlaceModel::where("city_id",$arr_city['id'])
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("place_name", 'like', "%".$search_term."%");
                                             
                                             /*->orwhere("admin_name2", 'like', "%".$search_term."%");*/
                                             })->get();
             $arr_list_location = array();
            if($arr_obj_location)
            {
                $arr_list_location = $arr_obj_location->toArray();

                $arr_final_location_list = array();

                if(sizeof($arr_list_location)>0)
                {
                    foreach ($arr_list_location as $key => $list)
                    {
                        $arr_final_location_list[$key]['id'] = $list['id'];
                        $arr_final_location_list[$key]['label'] = $list['place_name'];
                        $arr_final_location_list[$key]['loc_slug'] = str_slug($list['place_name']);
                        $arr_final_location_list[$key]['loc_lat'] = $list['latitude'];
                        $arr_final_location_list[$key]['loc_lng'] = $list['longitude'];
                        $arr_final_location_list[$key]['loc'] = str_replace('-',' ',($list['place_name']));
                         Session::put('business_search_by_location',$list['place_name']);


                    }

                }

            }
             if(sizeof($arr_final_location_list)>0)
            {
                 return response()->json($arr_final_location_list);
            }
            else
            {
                return response()->json(array());
            }

        }
         else
        {
           return response()->json(array());
        }

    }

    public function get_deal_category_auto(Request $request)
    {
        if($request->has('term'))
        {
            $search_term='';
            $search_term = $request->input('term');
            $arr_obj_deal_cat =CategoryModel::where('is_active','1')->where('is_allow_to_add_deal',1) /*CityModel::where('is_active','=',1)*/
                                            ->where(function ($query) use ($search_term) {
                                             $query->where("title", 'like', "%".$search_term."%");
                                                                                        })->get();
            $arr_list_deal_cat = array();
            if($arr_obj_deal_cat)
            {
                $arr_list_deal_cat = $arr_obj_deal_cat->toArray();

                $arr_final_deal_list = array();

                if(sizeof($arr_list_deal_cat)>0)
                {
                    foreach ($arr_list_deal_cat as $key => $list)
                    {
                        $arr_final_deal_list[$key]['id'] = $list['cat_id'];
                        $arr_final_deal_list[$key]['label'] = $list['title'];
                        $arr_final_deal_list[$key]['slug'] = $list['cat_slug'];
                    }

                }

            }
             if(sizeof($arr_final_deal_list)>0)
            {
                 return response()->json($arr_final_deal_list);
            }
            else
            {
                return response()->json(array());
            }

        }
        else
        {
           return response()->json(array());
        }
    }
    public function set_city(Request $request)
    {
            $city_id = $request->input('city_id');
            $city_title = $request->input('city_title');
            Session::forget('location_latitude');
            Session::forget('location_longitude');
            Session::put('search_city_id', $city_id);
            Session::put('search_city_title', $city_title);

            $result['status'] ="1";
            return response()->json($result);
    }
    public function get_business_by_exp_categry(Request $request)
    {
         $main_image_path="uploads/business/main_image";
        $exp_cat=$request->input('exp_cat');
        $obj_main_category = CategoryModel::where('cat_id',$exp_cat)->remember(60)->get();
        if($obj_main_category)
        {
            $arr_category = $obj_main_category->toArray();
            $first_cat_images=$arr_category[0]['cat_img'];
        }
         $obj_sub_category = CategoryModel::where('parent',$exp_cat)->get();
        if($obj_sub_category)
        {
            $arr_sub_category = $obj_sub_category->toArray();
        }
        $key_sub_cat=[];
        if(sizeof($arr_sub_category)>0)
        {
          foreach ($arr_sub_category as $key => $value) {
            $key_sub_cat[$value['cat_id']]=$value['cat_id'];
          }
        }
        $obj_business_listing_cat = BusinessCategoryModel::whereIn('category_id',$key_sub_cat)->get();
         if($obj_business_listing_cat)
        {
            $business_cat_listing = $obj_business_listing_cat->toArray();
        }
        $cat_ids=array();
        $business_ids=array();
        foreach ($business_cat_listing as $key => $value) {
            if(!array_key_exists($value['category_id'],$cat_ids))
            {
                $cat_ids[$value['category_id']]=$value['category_id'];
                $business_ids[$value['business_id']]=$value['business_id'];
            }
            else
            {
                $business_ids[$value['business_id']]=$value['business_id'];
            }

        }
         $obj_business_listing = BusinessListingModel::where('is_active','1')->whereIn('id', $business_ids)->orderBy('created_at', 'DESC')->take(8)->with(['reviews'])->get();
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }
        //dd($business_listing);
         
        $html='';
        if(sizeof($business_listing)>0)
        {
         foreach ($business_listing as $key => $business)
         {
             $slug_business=str_slug($business['business_name']);
             $slug_area=str_slug($business['area']);
             $business_area=$slug_business.'@'.$slug_area;
             if(!empty($business['city']))
              {
                $city=$business['city'];
              }
              else
              {
                $city='Delhi';
              }
            $html.='<a href="'.url('/').'/'.$city.'/'.$business_area.'/'.base64_encode($business['id']).'"><div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                                 <div class="first-cate-img">
                                    <img class="over-img" alt="" src="'.get_resized_image_path($business['main_image'],$main_image_path,205,270) .'">
                                     ';
                                     if($business['is_verified']==1){
                                        $html.='<img class="first-cate-veri" src="'.url('/').'/assets/front/images/verified.png" alt="write_review"/>';
                                    }
                                  $html.='</div>
                                 <div class="first-cate-white">
                                    <div class="f1_container">
                                       <div class="f1_card shadow">
                                          <div class="cate-addre-block-two front face">
                                          <div class="img-hm img_circle">
                                          <img alt="" src="'.get_resized_image_path($first_cat_images,'uploads/category',16,16) .'">
                                          </div>
                                          <div class="img-hm1">
                                          <img alt="" src="'.url('/').'/assets/front/images/cate-address-ica.png">
                                          </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="resta-name">
                                       <h6>'.$business['business_name'].'</h6>
                                       <span></span>
                                    </div>
                                    <div class="resta-content">
                                       '.$business['area'].'
                                    </div>
                                        <div class="resta-rating-block">';
                                    for($i=0;$i<round($business['avg_rating']);$i++)
                                        {
                                       $html.='<i class="fa fa-star star-acti"></i>';
                                        }
                                       for($i=0;$i<(5-round($business['avg_rating']));$i++){
                                      $html.='<i class="fa fa-star"></i>';
                                       }
                                    $html.='
                                 </div></div>
                    </div></a>';
               }
         }
        echo $html;
  }

  public function get_business_history(Request $request)
  {
     $main_image_path="uploads/business/main_image";
     $history=$request->input('history');
     $url1=explode('|',$history);
     $url=array_unique($url1);
     $arr_business_id=array();
     if(count($url)>0)
     {
        foreach ($url as $key => $value)
         {
            $string =  $value;
           $explode = explode('|', $string); // split all parts

            $end = '';
            $begin = '';

            if(count($explode) > 0){
               $end = array_pop($explode); // removes the last element, and returns it
                $explode2 = explode('/', $end);
               if(count($explode2)>0)
               {

                      $arr_business_id[$key]['id']=base64_decode($explode2[2]);
                      $arr_business_id[$key]['link']=$end;
                }
            }

        }
     }


      $business_ids=array();

      $business_cities=array();
      if(count($arr_business_id)>0)
      {
        foreach ($arr_business_id as $key => $value)
         {
            if(!array_key_exists($value['id'],$business_ids))
            {
               $business_ids[$value['id']]=$value['id'];

            }


        }
        foreach ($arr_business_id as $key => $value)
         {
            if(!array_key_exists($value['link'],$business_cities))
            {
               $business_cities[$value['link']]=$value['link'];
            }


        }

        $obj_business_listing = BusinessListingModel::where('is_active','1')->whereIn('id', $business_ids)->with(['reviews'])->get();
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }

        if(sizeof($business_listing)>0 )
        {

         foreach ($business_listing as $key => $business)
         {
          foreach ($arr_business_id as $key => $data)
           {
            if ($data['id'] == $business['id'])
             {
               $business_listing[$key]['link']=$data['link'];
             }
           }
         }
       }

        $html='';
        if(sizeof($business_listing)>0 )
        {

         foreach ($business_listing as $key => $business_data)
         {

            $html.='<a href="'.url('/').'/'.$business_data['link'].'"><div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                                 <div class="first-cate-img">
                                    <img class="over-img" alt="" src="'.get_resized_image_path($business_data['main_image'],$main_image_path,205,270) .'">';
                                    if($business_data['is_verified']==1)
                                    {
                                        $html.='<img class="first-cate-veri" src="'.url('/').'/assets/front/images/verified.png" alt="write_review"/>';
                                    }

                                $html.='</div>
                                 <div class="first-cate-white">
                                       <div class="resta-name">
                                       <h6>'.$business_data['business_name'].'</h6>
                                       <span></span>
                                    </div>
                                    <div class="resta-content">
                                       '. $business_data['building'].' '.$business_data['street'].' '.$business_data['landmark'].' '.$business_data['area'].' '.'-'.$business_data['pincode'].'
                                    </div>
                                        <div class="resta-rating-block">';
                                    for($i=0;$i<round($business_data['avg_rating']);$i++)
                                        {
                                       $html.='<i class="fa fa-star star-acti"></i>';
                                        }
                                       for($i=0;$i<(5-round($business_data['avg_rating']));$i++){
                                      $html.='<i class="fa fa-star"></i>';
                                       }
                                    $html.='
                                 </div></div>
                    </div></a>';
               }

         }
        echo $html;
    }
  }
}