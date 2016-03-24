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


use Sentinel;
use Session;
use Validator;

class ListingController extends Controller
{
    public function __construct()
    {

    }

    public function list_details($city,$slug_area,$enc_id)
    {
        $id = base64_decode($enc_id);
        $page_title ='List Details';

        $arr_business_details = array();
        $obj_business_details = BusinessListingModel::where('id',$id)->first();
        if($obj_business_details)
        {
            $obj_business_details->load(['business_times','also_list_category','reviews','image_upload_details','country_details','state_details','category_details','service']);
            $arr_business_details = $obj_business_details->toArray();
        }

        //related listing business start
        $arr_business = array();
        $obj_business_listing = BusinessCategoryModel::where('category_id',$arr_business_details['category_details']['category_id'])->limit(4)->get();

        if($obj_business_listing)
        {
            $obj_business_listing->load(['business_by_category']);
            $arr_business = $obj_business_listing->toArray();

        }
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

      //dd($arr_business_details);
        return view('front.listing.detail',compact('page_title','arr_business_details','arr_business','all_category','city','search_by'));
    }


    public function store_reviews(Request $request,$enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules = array();
        $arr_rules['title'] = "required";
        $arr_rules['review'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title       =  $request->input('title');
        $name        =  $request->input('name');
        $review      =  $request->input('review');
        $mobile_no   =  $request->input('mobile_no');
        $email       =  $request->input('email');

        $arr_data = array();
        $arr_data['title'] = $title;
        $arr_data['name'] = $name;
        $arr_data['message'] = $review;
        $arr_data['mobile_number'] = $mobile_no;
        $arr_data['email'] = $email;

        $arr_data['business_id'] = $id;

        $review_info          =  array(['title'=> $arr_data['title'],
                                        'name' => $arr_data['name'],
                                        'message'=> $arr_data['message'],
                                        'business_id'=> $arr_data['business_id'],
                                        'mobile_number'=> $arr_data['mobile_number'],
                                        'email' => $arr_data['email']]);


        $status = ReviewsModel::create(['title'=> $arr_data['title']]);

        foreach ($review_info as $review)
        {
            $arr_rev['title'] = $review['title'];
            $arr_rev['name'] = $review['name'];
            $arr_rev['message'] = $review['message'];
            $arr_rev['business_id'] = $review['business_id'];
            $arr_rev['mobile_number'] = $review['mobile_number'];
            $arr_rev['email'] = $review['email'];
        }

       $status = ReviewsModel::create($arr_rev);

        if($status)
        {
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

    public function sms_email($enc_id)
    {
        if ($user = Sentinel::getUser())
        {
            $arr_user_info = $user->toArray();
        }
        return view('front.listing.sms_email',compact('arr_user_info'));
    }

}
