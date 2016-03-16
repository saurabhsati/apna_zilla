<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\CategoryModel;
use App\Models\ReviewsModel;
use Session;
use Validator;

class ListingController extends Controller
{
    public function __construct()
    {

    }

    public function list_details($enc_id)
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


      //dd($arr_business_details);
        return view('front.listing.detail',compact('page_title','arr_business_details','arr_business','all_category'));
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

        $title       = $request->input('title');
        $review       = $request->input('review');

        $arr_data = array();
        $arr_data['title'] = $title;
        $arr_data['message'] = $review;
        $arr_data['business_id'] = $enc_id;

         $status = ReviewsModel::create(['title'=>$arr_data['title'],
                                        'message'=>$arr_data['message'],
                                        'business_id'=>$arr_data['business_id']
                                        ]);
        if($status)
        {
            Session::flash('success','Record Created Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Creating Record');
        }


    }
}
