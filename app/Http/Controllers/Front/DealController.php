<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\BuyInBulkModel;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\DealcategoryModel;
use App\Models\DealsOffersModel;
use Illuminate\Http\Request;
use Meta;
use Request as SegmentRequest;
use Session;
use Validator;

class DealController extends Controller
{
    public function __construct()
    {
        $this->deal_public_upload_img_path = '/uploads/deal/deal_slider_images/';
        $this->main_deal_public_upload_img_path = '/uploads/deal/';
    }

    public function index($city = 'Delhi')
    {

        $page_title = 'Deals and Offers';

        // $deal_image_path="uploads/deal";
        $deal_image_path = $this->main_deal_public_upload_img_path;

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

        $obj_business_listing = BusinessListingModel::where('city', $city)->where('is_active', '1')->get();
        if ($obj_business_listing) {
            $obj_business_listing = $obj_business_listing->toArray();
        }

        $key_business_city = [];

        if (count($obj_business_listing) > 0) {
            foreach ($obj_business_listing as $key => $value) {
                $key_business_city[$value['id']] = $value['id'];
            }
        }

        $obj_deals_info = DealsOffersModel::where('is_active', '1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->/*whereIn('business_id',$key_business_city)->*/ orderBy('created_at', 'DESC')->get();

        if ($obj_deals_info) {
            $arr_deals_info = $obj_deals_info->toArray();
        }
        $obj_deals_max_dis_info = DealsOffersModel::where('is_active', '1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->orderBy('discount_price', 'DESC')->get();

        if ($obj_deals_max_dis_info) {
            $arr_deals_max_dis_info = $obj_deals_max_dis_info->toArray();
        }

        $obj_deals_default_loc = DealsOffersModel::where('is_active', '1')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->get();
        if ($obj_deals_default_loc) {
            $arr_deals_loc_info = $obj_deals_default_loc->toArray();
        }
        //dd($arr_deals_max_dis_info);

        return view('front.deal.index', compact('deal_image_path', 'page_title', 'arr_deals_info', 'arr_deals_max_dis_info', 'arr_deals_loc_info', 'city'));
    }

    public function deals_by_category($city, $cat_slug, $sub_cat_slug = '')
    {
        $deal_image_path = 'uploads/deal';
        if ($sub_cat_slug == '') {
            $cat_explode = [];
            // $cat_explode=$cat_slug.split('/_(.+)?/')[1];//preg_split("^([^-]*)-(.*)",$cat_slug);
            $cat_explode = preg_split('[cat-]', $cat_slug);
            if (count($cat_explode) > 0) {
                $obj_category_info = CategoryModel::where('cat_slug', $cat_explode[1])->get();
                //dd($obj_category_info->toArray());
            }

        } else {
            $obj_category_info = CategoryModel::where('cat_slug', $sub_cat_slug)->get();

        }
        $arr_category_info = [];
        $arr_deals_max_dis_info = [];
        $arr_deals_info = [];
        $arr_deals_loc_info = [];

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
        $obj_business_listing = BusinessListingModel::where('city', $city)->where('is_active', '1')->get();
        if ($obj_business_listing) {
            $obj_business_listing = $obj_business_listing->toArray();
        }
        $key_business_city = [];
        if (count($obj_business_listing) > 0) {
            foreach ($obj_business_listing as $key => $value) {
                $key_business_city[$value['id']] = $value['id'];
            }
        }
        // By category

        if ($obj_category_info) {
            $arr_category_info = $obj_category_info->toArray();
        }
        if (count($arr_category_info) > 0) {
            //dd($arr_category_info);
            $cat_id = '';
            $cat_id = $arr_category_info[0]['cat_id'];

            /* Get Business by Sub-Category Selected */
            if ($sub_cat_slug == '') {

                $obj_deal_listing_cat = DealcategoryModel::where('main_cat_id', $cat_id)->get();
            } else {
                $obj_deal_listing_cat = DealcategoryModel::where('sub_cat_id', $cat_id)->get();
            }

            if ($obj_deal_listing_cat) {
                $arr_deal_category = $obj_deal_listing_cat->toArray();
            }
            $key_deal_cat = [];
            if (count($arr_deal_category) > 0) {
                foreach ($arr_deal_category as $key => $value) {
                    $key_deal_cat[$value['deal_id']] = $value['deal_id'];
                }
            }

            if (count($key_deal_cat) > 0) {
                $obj_deals_info = DealsOffersModel::where('is_active', '1')->whereIn('id', $key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->/*whereIn('business_id',$key_business_city)->*/ orderBy('created_at', 'DESC')->get();

                if ($obj_deals_info) {
                    $arr_deals_info = $obj_deals_info->toArray();
                }

                $obj_deals_max_dis_info = DealsOffersModel::where('is_active', '1')->whereIn('id', $key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->/*whereIn('business_id',$key_business_city)->*/ orderBy('discount_price', 'DESC')->get();

                if ($obj_deals_max_dis_info) {
                    $arr_deals_max_dis_info = $obj_deals_max_dis_info->toArray();
                }

                $obj_deals_default_loc = DealsOffersModel::where('is_active', '1')->whereIn('id', $key_deal_cat)->where('end_day', '>=', date('Y-m-d').' 00:00:00')->where('json_location_point', 'like', '%'.$city.'%')->/*whereIn('business_id',$key_business_city)->*/ get();
                if ($obj_deals_default_loc) {
                    $arr_deals_loc_info = $obj_deals_default_loc->toArray();
                }
            } else {
                $arr_deals_info = $arr_deals_loc_info = $arr_deals_max_dis_info = [];
            }

        }

        //dd($arr_deals_info);
        return view('front.deal.index', compact('deal_image_path', 'page_title', 'arr_deals_info', 'arr_deals_max_dis_info', 'arr_deals_loc_info', 'city'));
    }

    public function details($deal, $deal_slug, $enc_id)
    {
        $page_title = 'Details';
        $deal_image_path = 'uploads/deal';
        $deal_base_upload_img_path = '';
        $deal_slider_upload_img_path = $this->deal_public_upload_img_path;
        $id = base64_decode($enc_id);
        $city = SegmentRequest::segment(1);

        $obj_business_listing = BusinessListingModel::where('city', $city)->where('is_active', '1')->get();
        if ($obj_business_listing) {
            $obj_business_listing = $obj_business_listing->toArray();
        }
        $key_business_city = [];
        if (count($obj_business_listing) > 0) {
            foreach ($obj_business_listing as $key => $value) {
                $key_business_city[$value['id']] = $value['id'];
            }
        }

        $obj_deals_info = DealsOffersModel::with(['offers_info', 'deals_slider_images', 'category_info'])->where('id', $id)->where('is_active', '1')->get();

        $main_category_ids = $sub_category_ids = [];

        if ($obj_deals_info) {
            $deals_info = $obj_deals_info->toArray();

            foreach ($deals_info[0]['category_info'] as $key => $value) {
                if (! array_key_exists($value['main_cat_id'], $main_category_ids)) {
                    $main_category_ids[$value['main_cat_id']] = $value['main_cat_id'];
                }
                if (! array_key_exists($value['sub_cat_id'], $main_category_ids)) {
                    $sub_category_ids[$value['sub_cat_id']] = $value['sub_cat_id'];
                }
            }
        }

        $mete_title = '';
        if (isset($deals_info[0]['name']) && count($deals_info[0]['name'])) {
            $mete_title = $deals_info[0]['name'];
        }

        $meta_desp = '';
        if (isset($deals_info[0]['description']) && count($deals_info[0]['description'])) {
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
        if (count($main_category_ids) > 0 && isset($main_category_ids)) {
            $obj_deal_listing_by_main_cat = DealcategoryModel::whereIn('main_cat_id', $main_category_ids)->get();
            if ($obj_deal_listing_by_main_cat) {
                $deals_info_main_cat = $obj_deal_listing_by_main_cat->toArray();
            }
        }

        $key_deal_cat = [];
        if (count($deals_info_main_cat) > 0) {
            foreach ($deals_info_main_cat as $key => $value) {
                $key_deal_cat[$value['deal_id']] = $value['deal_id'];
            }
        }
        if (count($key_deal_cat) > 0) {
            $obj_related_deals_info = DealsOffersModel::where('is_active', '1')
                ->whereIn('id', $key_deal_cat)
                ->where('id', '!=', $id)
                ->where('end_day', '>=', date('Y-m-d').' 00:00:00')
                ->whereIn('business_id', $key_business_city)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

            if ($obj_related_deals_info) {
                $arr_related_deals_info = $obj_related_deals_info->toArray();
            }
        }
        // dd($deals_info );

        return view('front.deal.detail', compact('deal_image_path', 'page_title', 'deals_info', 'arr_related_deals_info', 'deal_slider_upload_img_path'));
    }

    public function fetch_location_deal(Request $request)
    {
        $deal_image_path = 'uploads/deal';
        $loc_lat = $request->input('loc_lat');
        $loc_lng = $request->input('loc_lng');
        $search_under_city = $request->input('search_under_city');
        $business_search_by_location = $request->input('business_search_by_location');

        $loc = str_replace('-', ' ', $business_search_by_location);

        $html = '';
        $obj_deals_info = DealsOffersModel::where(function ($query) use ($loc) {
            $query->where('json_location_point', 'like', '%'.$loc.'%');
        })->where('end_day', '>=', date('Y-m-d').' 00:00:00')->get();

        if (count($obj_deals_info) > 0 && isset($obj_deals_info)) {

            if ($obj_deals_info) {
                $arr_deals_info = $obj_deals_info->toArray();
            }
            //dd($arr_deals_info);
            if (count($arr_deals_info) > 0) {
                foreach ($arr_deals_info as $key => $deal) {

                    $arr_departture_point = [];
                    if (isset($deal['json_location_point'])) {
                        $arr_departture_point = json_decode($deal['json_location_point'], true);
                    }
                    $location_count = $brought_count = 0;
                    if (count($arr_departture_point) > 0) {
                        $location_count = count($arr_departture_point);
                    }
                    if (! empty($deal['redeem_count'])) {
                        $brought_count = $deal['redeem_count'];
                    }

                    $html .= '<a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ', '-', $deal['name'])).'/'.base64_encode($deal['id']).'"><div class="col-sm-6 col-md-3 col-lg-3">
                                  <div class="dels">
                                  <div class="deals-img"><span class="discount ribbon">'.$deal['discount_price'].'%</span><img src="'.
                             get_resized_image_path($deal['deal_image'], $deal_image_path, 200, 250).
                             '"alt="img"  /></div>
                                  <div class="deals-product">
                                  <div class="deals-nm"><a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ', '-', $deal['name'])).'/'.base64_encode($deal['id']).'">'.$deal['name'].'</a></div>
                                  <p> '.$location_count.' Location<p> 
                                  <p> '.$brought_count.' Bought<p> 
                            

                                  <div class="online-spend"></div>
                                          <div class="price-box">
                                          <div class="price-new"><i class="fa fa-inr"></i> '.round($deal['price'] - (($deal['price']) * ($deal['discount_price'] / 100))).'</div>
                                              <div class="price-old"><i class="fa fa-inr"></i> '.$deal['price'].'</div>
                                              <div class="view"><a href="'.url('/').'/'.$search_under_city.'/deals/'.urlencode(str_replace(' ', '-', $deal['name'])).'/'.base64_encode($deal['id']).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                          </div>
                                  </div>
                                  </div>
                                  </div></a>';

                }
            }

        }
        echo $html;
    }

    public function bulk_booking_form(Request $request)
    {
        if (! (Session::has('user_id'))) {
            return redirect('/');
        }
        $page_title = 'Booking form';
        $form_data = $request->all();
        $city = SegmentRequest::segment(1);

        return view('front.bulk_booking_form.create', compact('page_title', 'form_data', 'city'));

    }

    public function booking_order(Request $request)
    {
        if (! (Session::has('user_id'))) {
            return redirect('/');
        }
        $arr_rules['deal_id'] = 'required';
        $arr_rules['name'] = 'required';
        $arr_rules['email_id'] = 'required';
        $arr_rules['quantity'] = 'required';
        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $arr_booking['deal_id'] = $request->input('deal_id');
        $arr_booking['name'] = $request->input('name');
        $arr_booking['organization'] = $request->input('organization');
        $arr_booking['email'] = $request->input('email_id');
        $arr_booking['phone_no'] = $request->input('phone_no');
        $arr_booking['quantity'] = $request->input('quantity');

        $dealUrl = $request->input('deal_url');
        $deal_city = $request->input('city');
        $booking_add = BuyInBulkModel::create($arr_booking);
        if ($booking_add) {

            Session::flash('dealUrl', $dealUrl);
            Session::flash('deal_city', $deal_city);
            Session::flash('success', ' Great! Thanks for filling out the form! Our representative wil contact you within 1 business day to understand your requirements.');

            return redirect(url('/').'/bulk-order/bulk-booking');
        } else {
            Session::flash('error', 'Error While Bulk Booking Deal ');

            return redirect(url('/').'/bulk-order/bulk-booking');
        }

    }

    public function bulk_booking()
    {
        return view('front.bulk_booking_form.booking_success ');
    }
}
