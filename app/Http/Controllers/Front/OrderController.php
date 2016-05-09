<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealsOffersModel;

class OrderController extends Controller
{
   public function index($offers,$enc_id)
   {
   	 $id = base64_decode($enc_id);
     $page_title ="Order Detail";
     /* Offers Ids & Quantity */
     $complite_arr=[];
     $explode_offers=explode('-',$offers);
     if(sizeof($explode_offers)>0)
     {
        foreach($explode_offers as $value)
        {
            $complite_arr[] = explode('_', $value);
         }
     }
     
 	  $obj_deal_arr=DealsOffersModel::with(['offers_info','deals_slider_images'])->where('id',$id)->first();
     if($obj_deal_arr)
    {
        $deal_arr = $obj_deal_arr->toArray();
    }
     $deal_image_path="uploads/deal";
    // dd($complite_arr);
    return view('front.order.order_detail',compact('page_title','deal_arr','deal_image_path','complite_arr'));
 

   }

}
