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
             
              $data[$key]['price']              = $value['price'];
              $data[$key]['start_date']         = $value['start_date'];
              $data[$key]['expire_date']        = $value['expire_date'];

      	        $obj_deal_name = DealModel::Where('id',$value['deal_id'])->get();
		 		if($obj_deal_name)
		 		{
		 			 $arr_deal_name = $obj_deal_name->toArray();
		        }
		        foreach ($arr_deal_name as $key => $deals) 
		        {
		        	 $data[$key]['deal_name']            = $deals['name'];
		        }
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

     public function store(Request $request)
     {
        $id =  $request->input('id');
        $arr_data['transaction_status']  = $request->input('status');
        $arr_single_transaction = array();
        $obj_single_transaction = DealsTransactionModel::where('id',$id)->first();

        if($obj_single_transaction)
        {
            $obj_single_transaction->load(['user_records','user_orders','order_deal.offers_info']);
            $arr_single_transaction = $obj_single_transaction->toArray();
        }

     }
}
