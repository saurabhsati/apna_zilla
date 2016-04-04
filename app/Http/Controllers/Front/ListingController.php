<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\CategoryModel;
use App\Models\ReviewsModel;
use App\Models\UserModel;
use App\Models\CityModel;
use App\Models\FavouriteBusinessesModel;
use App\Models\BusinessSendEnquiryModel;

use Sentinel;
use Session;
use Validator;
use Meta;

class ListingController extends Controller
{
    public function __construct()
    {

    }

    public function list_details($city,$slug_area,$enc_id)
    {
        $enc_id;
        $id = base64_decode($enc_id);
        if($id=='')
        {

          return redirect()->back();
         }
         $obj_business = BusinessListingModel::where('id',$id)->first();
        if( $obj_business != FALSE)
        {
            $_business = $obj_business->toArray();
        }
        if(sizeof($_business)>0)
        {
          $visited_count=$_business['visited_count'];
          $update_visited_count= $visited_count+1;
          $update_data['visited_count']=$update_visited_count;
          BusinessListingModel::where('id',$id)->update($update_data);
        }
        $page_title ='List Details';

        $arr_business_details = array();
        $obj_business_details = BusinessListingModel::where('id',$id)->first();
        if($obj_business_details)
        {
            $obj_business_details->load(['business_times','also_list_category','reviews','image_upload_details','payment_mode','country_details','state_details','category_details','service']);
            $arr_business_details = $obj_business_details->toArray();
        }

        //related listing business start
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

        $arr_business_by_category = array();
        $obj_business_listing = BusinessCategoryModel::where('category_id',$arr_business_details['category_details']['category_id'])->limit(4)->get();

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
          if(($key = array_search($id, $result)) !== false){
             unset($result[$key]);
             }
          $all_related_business = array();
          if(sizeof($result)>0)
          {

            $obj_business_listing = BusinessListingModel::whereIn('id', $result)->with(['reviews'])->get();
            if($obj_business_listing)
            {
              $all_related_business = $obj_business_listing->toArray();

            }
          }
      }
       // dd($result);
        //related listing business end

         $obj_category = CategoryModel::where('parent','!=','0')->get();
        if($obj_category)
        {
            $all_category = $obj_category->toArray();
        }
         if($slug_area!='')
         {
               $search_by=explode("@", $slug_area);
             if($search_by!='')
              {
                 Session::put('search_by', str_replace('-',' ',$search_by[0]));
                 Session::put('business_id', $enc_id);
              }
              //echo Session::get('search_by');
         }
        $sub_category='';
        $obj_sub_category = CategoryModel::where('cat_id',$arr_business_by_category[0]['category_id'])->get();
        if($obj_sub_category)
        {
            $sub_category = $obj_sub_category->toArray();
        }
         $parent_category='';
         if(sizeof($sub_category)>0)
        {
          $main_cat_id=$sub_category[0]['parent'];
           $obj_parent_category = CategoryModel::where('cat_id',$main_cat_id)->get();
            if($obj_parent_category)
            {
                $parent_category = $obj_parent_category->toArray();
            }
        }


        Meta::setDescription($arr_business_details['company_info']);
        Meta::addKeyword($arr_business_details['keywords']);
      //dd($arr_business_details);
        return view('front.listing.detail',compact('page_title','arr_business_details','parent_category','all_related_business','all_category','city','search_by'));
    }


    public function store_reviews(Request $request)
    {
        $arr_rules = array();
        $arr_rules['rating'] = "required";
        $arr_rules['review'] = "required";
        $arr_rules['name'] = "required";
        $arr_rules['mobile_no'] = "required";
        $arr_rules['email'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

          $rating      =  $request->input('rating');
          $name        =  $request->input('name');
          $review      =  $request->input('review');
          $mobile_no   =  $request->input('mobile_no');
          $email       =  $request->input('email');
          $id          =  $request->input('business_id');


        $arr_data = array();
         $arr_data['ratings'] = $rating;
        $arr_data['name'] = $name;
        $arr_data['message'] = $review;
        $arr_data['mobile_number'] = $mobile_no;
        $arr_data['email'] = $email;
        $arr_data['business_id'] = $id;

       $status = ReviewsModel::create($arr_data);

        if($status)
        {
         $business_rating = BusinessListingModel::where('id',$arr_data['business_id'])->with(['reviews'])->get()->toArray();
         $reviews=0;
              if(isset($business_rating[0]['reviews']) && sizeof($business_rating[0]['reviews'])>0){
              foreach($business_rating[0]['reviews'] as $business_review){
                 $reviews=$reviews+$business_review['ratings'];
              }

             }
         if(sizeof($business_rating[0]['reviews']))
              {
                $tot_review=sizeof($business_rating[0]['reviews']);
                $avg_review=($reviews/$tot_review);
              }
              else
              {
                $avg_review= $tot_review=0;
              }

        $business_data['avg_rating']=round($avg_review);
        $business_data=BusinessListingModel::where('id',$id)->update($business_data);

          Session::flash('success','Review Submitted Successfully');
        }
        else
        {
          Session::flash('error','Problem Occured While Submitting Review ');
        }

        return redirect()->back();
    }

    public function share_business($enc_id)
    {
       $id = session('user_id');
        $user_id = base64_decode($id);

        $obj_user_info = UserModel::where('id','=',$user_id)->get();

        if($obj_user_info)
        {
            $arr_user_info = $obj_user_info->toArray();
        }

        foreach ($arr_user_info as $users)
        {
             Session::put('user_mail', $users['email']);
             Session::put('user_first_name', $users['first_name']);
             Session::put('user_middle_name', $users['middle_name']);
             Session::put('user_last_name', $users['last_name']);
        }

        $business_id = base64_decode($enc_id);
        $page_title = "Share Business";

        return view('front.listing.share_business',compact('business_id','page_title'));
    }




    public function add_to_favourite(Request $request)
    {
      $user_mail      = $request->input('user_mail');
      $business_id    = $request->input('business_id');

      $json      = array();
      $obj_user  = UserModel::where('email',$user_mail)->first(['id']);

      {
        $obj_fav = FavouriteBusinessesModel::where(array('user_id'=>$obj_user->id,'business_id'=>$business_id))->get();
        if($obj_fav)
        {
          $arr = $obj_fav->toArray();
          if(count($arr)>0)
          {
            if($arr[0]['is_favourite']== '0')
            {
              $result = FavouriteBusinessesModel::where(array('user_id'=>$obj_user->id,'business_id'=>$business_id))->update(array('is_favourite'=>'1'));
                $json['status'] = "favorites";
            }

            if($arr[0]['is_favourite']== '1')
            {
              $result = FavouriteBusinessesModel::where(array('user_id'=>$obj_user->id,'business_id'=>$business_id))->update(array('is_favourite'=>'0'));
              $json   = "un_favorites";
            }
          }
          else
          {
            $result = FavouriteBusinessesModel::create(array('user_id'=>$obj_user->id,'business_id'=>$business_id,'is_favourite'=>'1'));
            $json['status'] = "favorites";
          }
        }
      }

      return response()->json($json);
    }



    public function send_enquiry(Request $request)
    {
        $arr_rules = array();
        $arr_rules['name'] = "required";
        $arr_rules['mobile'] = "required";
        $arr_rules['email'] = "required";
        $arr_rules['subject'] = "required";
        $arr_rules['message'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name        =  $request->input('name');
        $email      =  $request->input('email');
        $mobile   =  $request->input('mobile');
        $subject       =  $request->input('subject');
        $message       =  $request->input('message');
        $business_id          =  $request->input('business_id');

        $arr_data = array();
        $arr_data['name'] = $name;
        $arr_data['email'] = $email;
        $arr_data['mobile'] = $mobile;
        $arr_data['subject'] = $subject;
        $arr_data['message'] = $message;
        $arr_data['business_id'] = $business_id;
        //dd($arr_data);
         $status = BusinessSendEnquiryModel::create($arr_data);

        if($status)
        {
           Session::flash('success','Enquiry Send Successfully');
        }
        else
        {
          Session::flash('error','Problem Occurred While Sending Enquiry ');
        }
         return redirect()->back();
    }
     public function send_sms(Request $request)
    {
        $arr_rules = array();
        $arr_rules['name'] = "required";
        $arr_rules['mobile'] = "required";
        $arr_rules['email'] = "required|email";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
           $json['status'] = "VALIDATION_ERROR";
            //return redirect()->back()->withErrors($validator)->withInput();
        }

        $name        =  $request->input('name');
        $email      =  $request->input('email');
        $mobile   =  $request->input('mobile');
        $mobile_otp =  mt_rand(0,66666);
        $business_id          =  $request->input('business_id');


        if(is_numeric($mobile) && strlen($mobile)==10)
        {
            $arr_data = array();
            $arr_data['name'] = $name;
            $arr_data['email'] = $email;
            $arr_data['mobile'] = $mobile;
            $arr_data['mobile_OTP'] = $mobile_otp;
            $arr_data['business_id'] = $business_id;

            $status = BusinessSendEnquiryModel::create($arr_data);
            $send_enquiry_id = $status->id;
            if($status)
            {
              $response  = $this->send_otp($mobile,$mobile_otp);
              if($response!='')
              {
                 $json['status']     = "SUCCESS";
                 $json['mobile_no']  = $mobile;
              }

            }
        }
        else
        {
            $json['status'] = "MOBILE_ERROR";
            $json['msg']    = "Invalid Mobile No.";
        }
          return response()->json($json);
    }
      public function send_otp($mobile,$mobile_otp)
    {

        $url = "http://smsway.co.in/api/sendhttp.php?authkey=70Asotxsg0Q556948f8&mobiles='".$mobile."'&message=Send SMS To RightNext OPT = '".$mobile_otp."'&sender=SMSWAY&route=4&country=91";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function sms_otp_check(Request $request)
    {
        $otp            =  $request->input('otp');
        $mobile_no      =  $request->input('mobile_no');

        if(is_numeric($mobile_no) && strlen($mobile_no)==10)
        {
            $mobile = $mobile_no;

            $user = BusinessSendEnquiryModel::where('mobile',$mobile)->where('mobile_OTP',$otp)->first()->toArray();

            if($user)
            {

                 $json['status'] = "SUCCESS";
                // Session::flash('success','SMS Send Successfully.');
            }
            else
            {
                $json['status'] = "ERROR";
            }


        }
        else
        {
             $json['status'] = "MOBILE_ERROR";
        }

        return response()->json($json);
    }

}
