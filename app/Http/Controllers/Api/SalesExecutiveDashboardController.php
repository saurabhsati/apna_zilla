<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\DealsOffersModel;
use App\Models\TransactionModel;
use Sentinel;

class SalesExecutiveDashboardController extends Controller
{
   
   public function dashboard(Request $request)
   {
   		$sales_user_public_id=$request->input('public_id');
   		$json = $data  =array();

   		$vender_count = $business_listing_count = $deals_count = $membership_transaction_count =0;
   		$obj_user     = $obj_business_listing   = $obj_deal    = $obj_transaction =[];
       

        $obj_user     = Sentinel::createModel()->where('sales_user_public_id','=',$sales_user_public_id)->where('role','=','normal')->get();
       
        if($obj_user!= FALSE)
        {
            $vender_count=  sizeof($obj_user->toArray());

        }

        $obj_business_listing = BusinessListingModel::where('sales_user_public_id',$sales_user_public_id)->get();
        if($obj_business_listing)
        {
            $business_listing_count = sizeof($obj_business_listing->toArray());
        }

        $obj_deal=DealsOffersModel::where('public_id',$sales_user_public_id)->get();
       
        if($obj_deal)
         {
            $deals_count = sizeof($obj_deal->toArray());
         }
         $obj_transaction = TransactionModel::where('sales_user_public_id',$sales_user_public_id)->get();

        if($obj_transaction)
        {
              $membership_transaction_count = sizeof($obj_transaction->toArray());
        }


        $data['vender_count'] = $vender_count;
        $data['business_listing_count'] = $business_listing_count;
        $data['deals_count'] = $deals_count;
        $data['membership_transaction_count'] = $membership_transaction_count;

         if($data)
        { 
           $json['data']    = $data;
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Sales Dashboard count';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Sales Dashboard count';
        }

        return response()->json($json);
   }
}
