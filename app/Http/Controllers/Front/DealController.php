<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealModel;
use Meta;

class DealController extends Controller
{
 	public function __construct()
 	{

 	}

 	public function index()
 	{
 		$page_title = "Deals and Offers";

 		$obj_deals_info = DealModel::get();

 		if($obj_deals_info)
 		{
 			$arr_deals_info = $obj_deals_info->toArray();
		}
 		$obj_deals_max_dis_info = DealModel::orderBy('discount_price','DESC')->get();

 		if($obj_deals_max_dis_info)
 		{
 			$arr_deals_max_dis_info = $obj_deals_max_dis_info->toArray();
		}
		//dd($arr_deals_max_dis_info);
 		return view('front.deal.index',compact('page_title','arr_deals_info','arr_deals_max_dis_info'));
 	}
 	public function deals_by_category()
 	{
 		return view('front.deal.index',compact('page_title','arr_deals_info','arr_deals_max_dis_info'));
 	}
 	public function details($enc_id)
 	{
 		$page_title = "Details";
 		 $id = base64_decode($enc_id);
 		 $obj_deals_info = DealModel::where('id',$id)->get();

 		if($obj_deals_info)
 		{
 			$deals_info = $obj_deals_info->toArray();
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
		//dd($deals_info);
 		return view('front.deal.detail',compact('page_title','deals_info'));
 	}
}