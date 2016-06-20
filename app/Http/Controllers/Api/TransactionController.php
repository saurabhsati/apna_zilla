<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DealsTransactionModel;
use App\Models\DealModel;

class TransactionController extends Controller
{

    public function index()
    {
 		$obj_transaction = DealsTransactionModel::orderBy('id','DESC')->get();

 		if($obj_transaction)
 		{
 			$obj_transaction->load(['user_records','user_orders','order_deal.offers_info']);
 			 $arr_tansaction = $obj_transaction->toArray();
 	    }

       // dd($arr_tansaction);
            $data =array();
           foreach ($arr_tansaction as $key => $value) 
           {
              $data[$key]['transaction_id']     = $value['transaction_id'];
              $data[$key]['transaction_status'] = $value['transaction_status'];
              $data[$key]['username']           = $value['user_records']['first_name'];
              $data[$key]['deal_name']            = $arr_deal_name['name'];
              $data[$key]['price']              = $value['price'];
              $data[$key]['start_date']         = $value['start_date'];
              $data[$key]['expire_date']        = $value['expire_date'];
           }  
          
       if($data)
        { 
           $json['data']    = $data;
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Business Review  ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Listing Business Review';
        }
        return response()->json($json);
     }
}
