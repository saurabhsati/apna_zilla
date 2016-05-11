<?php
namespace App\Http\Controllers\Front;

/*use Illuminate\Http\Request;*/
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealsOffersModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\BusinessListingModel;
use App\Models\DealcategoryModel;
use Meta;
use Request;

class DealController extends Controller
{
 	public function __construct()
 	{

 	}

 	public function index($city='Mumbai')
 	{

 		$page_title = "Deals and Offers";

    $deal_image_path="uploads/deal";

     //by city
    /*$obj_business_listing_city = CityModel::where('city_title',$city)->get();
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
      }*/

      $obj_business_listing = BusinessListingModel::where('city',$city)->where('is_active','1')->get();
      if($obj_business_listing)
      {
          $obj_business_listing = $obj_business_listing->toArray();
      }
       $key_business_city=array();
     if(sizeof($obj_business_listing)>0)
      {
        foreach ($obj_business_listing as $key => $value) {
          $key_business_city[$value['id']]=$value['id'];
        }
      }
  
  	$obj_deals_info = DealsOffersModel::where('is_active','1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->orderBy('created_at','DESC')->get();

 		if($obj_deals_info)
 		{
 			$arr_deals_info = $obj_deals_info->toArray();
		}
 		$obj_deals_max_dis_info = DealsOffersModel::where('is_active','1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->orderBy('discount_price','DESC')->get();

 		if($obj_deals_max_dis_info)
 		{
 			$arr_deals_max_dis_info = $obj_deals_max_dis_info->toArray();
		}


   $obj_deals_default_loc = DealsOffersModel::where('is_active','1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->get();
  if($obj_deals_default_loc)
  {
      $arr_deals_loc_info = $obj_deals_default_loc->toArray();
  }
   //dd($arr_deals_max_dis_info);

 		return view('front.deal.index',compact('deal_image_path','page_title','arr_deals_info','arr_deals_max_dis_info','arr_deals_loc_info','city'));
 	}
 	public function deals_by_category($city,$cat_slug,$sub_cat_slug='')
 	{
         $deal_image_path="uploads/deal";
        if($sub_cat_slug=='')
        {
          $cat_explode =[];
         // $cat_explode=$cat_slug.split('/_(.+)?/')[1];//preg_split("^([^-]*)-(.*)",$cat_slug);
          $cat_explode=preg_split('[cat-]',$cat_slug);
          if(sizeof($cat_explode)>0)
          {
           $obj_category_info = CategoryModel::where('cat_slug',$cat_explode[1])->get();
           //dd($obj_category_info->toArray());
          }

        }
        else
        {
           $obj_category_info = CategoryModel::where('cat_slug',$sub_cat_slug)->get();

        }
        $arr_category_info=array();
        $arr_deals_max_dis_info=array();
        $arr_deals_info=array();
        $arr_deals_loc_info=array();

        //by city
       /* $obj_business_listing_city = CityModel::where('city_title',$city)->get();
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
          }*/
      $obj_business_listing = BusinessListingModel::where('city',$city)->where('is_active','1')->get();
      if($obj_business_listing)
      {
          $obj_business_listing = $obj_business_listing->toArray();
      }
       $key_business_city=array();
     if(sizeof($obj_business_listing)>0)
      {
        foreach ($obj_business_listing as $key => $value) {
          $key_business_city[$value['id']]=$value['id'];
        }
      }
        // By category






        if($obj_category_info)
        {
            $arr_category_info = $obj_category_info->toArray();
        }
        if( sizeof($arr_category_info)>0)
        {
          //dd($arr_category_info);
          $cat_id='';
          $cat_id=$arr_category_info[0]['cat_id'];

          /* Get Business by Sub-Category Selected */
           if($sub_cat_slug=='')
            {
              
                 $obj_deal_listing_cat = DealcategoryModel::where('main_cat_id',$cat_id)->get();
            }
            else
            {
                  $obj_deal_listing_cat = DealcategoryModel::where('sub_cat_id',$cat_id)->get();
            }

         if($obj_deal_listing_cat)
          {
            $arr_deal_category = $obj_deal_listing_cat->toArray();
          }
          $key_deal_cat=array();
          if(sizeof($arr_deal_category)>0)
          {
              foreach ($arr_deal_category as $key => $value) {
                $key_deal_cat[$value['deal_id']]=$value['deal_id'];
              }
          }
         
          if(sizeof($key_deal_cat)>0)
          {  
                $obj_deals_info = DealsOffersModel::where('is_active','1')->whereIn('id',$key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->orderBy('created_at','DESC')->get();

                if($obj_deals_info)
                {
                    $arr_deals_info = $obj_deals_info->toArray();
                }

                $obj_deals_max_dis_info = DealsOffersModel::where('is_active','1')->whereIn('id',$key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->orderBy('discount_price','DESC')->get();

                if($obj_deals_max_dis_info)
                {
                    $arr_deals_max_dis_info = $obj_deals_max_dis_info->toArray();
                }

               $obj_deals_default_loc = DealsOffersModel::where('is_active','1')->whereIn('id',$key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$key_business_city)->get();
              if($obj_deals_default_loc)
              {
                  $arr_deals_loc_info = $obj_deals_default_loc->toArray();
              }
          }
          else
          {
            $arr_deals_info=$arr_deals_loc_info=$arr_deals_max_dis_info=[];
          }


       }



        //dd($arr_deals_info);
 		return view('front.deal.index',compact('deal_image_path','page_title','arr_deals_info','arr_deals_max_dis_info','arr_deals_loc_info','city'));
 	}
 	public function details($deal='deals',$deal_slug,$enc_id)
 	{
 		 $page_title = "Details";
     $deal_image_path="uploads/deal";
 		 $id = base64_decode($enc_id);
     $city = Request::segment(1);


      $obj_business_listing = BusinessListingModel::where('city',$city)->where('is_active','1')->get();
      if($obj_business_listing)
      {
          $obj_business_listing = $obj_business_listing->toArray();
      }
       $key_business_city=array();
     if(sizeof($obj_business_listing)>0)
      {
        foreach ($obj_business_listing as $key => $value) {
          $key_business_city[$value['id']]=$value['id'];
        }
      }
     


 		 $obj_deals_info = DealsOffersModel::with(['offers_info','deals_slider_images','category_info'])->where('id',$id)->get();
     $main_category_ids=$sub_category_ids=[];
         
   		if($obj_deals_info)
   		{
   			$deals_info = $obj_deals_info->toArray();
        foreach ($deals_info[0]['category_info'] as $key => $value) 
          {
            if(!array_key_exists( $value['main_cat_id'], $main_category_ids))
             {
                  $main_category_ids[$value['main_cat_id']]= $value['main_cat_id'];
             }
              if(!array_key_exists( $value['sub_cat_id'], $main_category_ids))
             {
                  $sub_category_ids[$value['sub_cat_id']]= $value['sub_cat_id'];
             }
          }
  		}
      $mete_title = "";
        if(isset($deals_info[0]['name']) && sizeof($deals_info[0]['name']))
        {
           $mete_title = $deals_info[0]['name'];
        }

        $meta_desp = "";
        if(isset($deals_info[0]['description']) && sizeof($deals_info[0]['description']))
        {
           $meta_desp = $deals_info[0]['description'];
        }


        //exit;
        Meta::setTitle($mete_title);
        // Meta::setDescription($meta_desp);
        Meta::addKeyword($mete_title);
	     /* Releted deals*/
          /* if(sizeof($sub_category_ids)>0 && isset($sub_category_ids))
            {
              
                 $obj_deal_listing_by_sub_cat = DealcategoryModel::whereIn('sub_cat_id',$sub_category_ids)->get();
                  if($obj_deals_info)
                  {
                    $deals_info_sub_cat = $obj_deals_info->toArray();
                  }

            }*/
            if(sizeof($main_category_ids)>0 && isset($main_category_ids))
            {
                  $obj_deal_listing_by_main_cat = DealcategoryModel::whereIn('main_cat_id',$main_category_ids)->get();
                  if($obj_deal_listing_by_main_cat)
                  {
                    $deals_info_main_cat = $obj_deal_listing_by_main_cat->toArray();
                  }
            }

            $key_deal_cat=array();
            if(sizeof($deals_info_main_cat)>0)
            {
                foreach ($deals_info_main_cat as $key => $value) {
                  $key_deal_cat[$value['deal_id']]=$value['deal_id'];
                }
            }
            if(sizeof($key_deal_cat)>0)
             {  
                $obj_related_deals_info = DealsOffersModel::where('is_active','1')
                                                          ->whereIn('id',$key_deal_cat)
                                                          ->where('id','!=',$id)
                                                          ->where('end_day', '>=', date('Y-m-d').' 00:00:00')
                                                          ->whereIn('business_id',$key_business_city)
                                                          ->orderBy('created_at','DESC')
                                                          ->limit(4)
                                                          ->get();

                if($obj_related_deals_info)
                {
                    $arr_related_deals_info = $obj_related_deals_info->toArray();
                }
            }
         // dd($deals_info );
       
      

 		return view('front.deal.detail',compact('deal_image_path','page_title','deals_info','arr_related_deals_info'));
 	}
    public function fetch_location_deal(Request $request)
    {
        $deal_image_path="uploads/deal";
        $loc_lat = $request->input('loc_lat');
        $loc_lng = $request->input('loc_lng');
        $search_under_city = $request->input('search_under_city');
        $business_search_by_location = $request->input('business_search_by_location');

        //by city
          $obj_business_listing_city = CityModel::where('city_title',$search_under_city)->get();
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
        //by location
        $loc=str_replace('-',' ',$business_search_by_location);

        $obj_business_loc = BusinessListingModel::where(function ($query) use ($loc)
                                                  {
                                                   $query->orwhere("area", 'like', "%".$loc."%")
                                                   ->orwhere("street", 'like', "%".$loc."%")
                                                   ->orwhere("landmark", 'like', "%".$loc."%")
                                                   ->orwhere("building", 'like', "%".$loc."%");
                                                 })->get();
          if($obj_business_loc)
          {
            $arr_business_by_loc = $obj_business_loc->toArray();
          }
          $key_business_loc=array();
          if(sizeof($arr_business_by_loc)>0)
          {
              foreach ($arr_business_by_loc as $key => $value) {
                $key_business_loc[$value['id']]=$value['id'];
              }
          }
          $busiess_result=[];
          if(sizeof($key_business_city)>0 && sizeof($key_business_loc))
          {
              $busiess_result = array_intersect($key_business_city,$key_business_loc);

          }
          $html='';
          if(sizeof($busiess_result)>0 && isset($busiess_result))
          {
                $obj_deals_info = DealsOffersModel::where('end_day', '>=', date('Y-m-d').' 00:00:00')->whereIn('business_id',$busiess_result)->get();

              if($obj_deals_info)
              {
                  $arr_deals_info = $obj_deals_info->toArray();
              }

                if(sizeof($arr_deals_info)>0)
                {
                  foreach ($arr_deals_info as $key => $deal)
                    {
                         $html.='<a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ','-',$deal['name'])).'/'.base64_encode($deal['id']).'"><div class="col-sm-6 col-md-3 col-lg-3">
                                  <div class="dels">
                                  <div class="deals-img"><span class="discount ribbon">'.$deal['discount_price'].'%</span><img src="'.
                                  get_resized_image_path($deal['deal_image'],$deal_image_path,200,250).
                                  '"alt="img"  /></div>
                                  <div class="deals-product">
                                  <div class="deals-nm"><a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ','-',$deal['name'])).'/'.base64_encode($deal['id']).'">'.$deal['name'].'</a></div>
                                  <div class="online-spend"></div>
                                          <div class="price-box">
                                          <div class="price-new">£'.round($deal['price']-(($deal['price'])*($deal['discount_price']/100))).'</div>
                                              <div class="price-old">£'.$deal['price'].'</div>
                                              <div class="view"><a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ','-',$deal['name'])).'/'.base64_encode($deal['id']).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                          </div>
                                  </div>
                                  </div>
                                  </div></a>';


                    }
                }

         }
          echo $html;
    }
}