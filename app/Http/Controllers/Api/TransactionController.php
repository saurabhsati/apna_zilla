<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TransactionModel;
use App\Models\DealsTransactionModel;
use App\Models\DealModel;


class TransactionController extends Controller
{

    public function index()
    {
 		$arr_transaction = array();
 		$obj_transaction = TransactionModel::orderBy('id','DESC')->get();

 		if($obj_transaction)
 		{
 			$obj_transaction->load(['user_records']);
 			$obj_transaction->load(['membership']);
            $obj_transaction->load(['business']);
            $obj_transaction->load(['category']);
            $arr_transaction = $obj_transaction->toArray();
        }
            $data =array();
           foreach ($arr_transaction as $key => $value) 
           {
              $data[$key]['transaction_id']     = $value['transaction_id'];
              $data[$key]['transaction_status'] = $value['transaction_status'];
              $data[$key]['username']           = $value['user_records']['first_name'];
              $data[$key]['price']              = $value['price'];
              $data[$key]['start_date']         = $value['start_date'];
              $data[$key]['expire_date']        = $value['expire_date'];
              $data[$key]['category']           = $value['category']['title'];
              $data[$key]['business']           = $value['business']['business_name'];
              $data[$key]['membership']         = $value['membership']['title'];
              $data[$key]['User Email']         = $value['user_records']['email'];
           }   															
       
     
       if($data)
        { 
           $json['data']    = $data;
           $json['status']  = 'SUCCESS';
           $json['message'] = 'Transaction Details  ! .';
        }
        else
        {
          $json['status']  = 'ERROR';
          $json['message'] = 'Error Occure while Transaction Details';
        }
        return response()->json($json);
     }

     public function edit(Request $request)
     {
        $id     =  $request->input('id');
        $arr_single_transaction = array();
        $obj_single_transaction = TransactionModel::where('id',$id)->first();

        if($obj_single_transaction)
        {
            $obj_single_transaction->load(['user_records']);
            $obj_single_transaction->load(['membership']);
            $obj_single_transaction->load(['business']);
            $obj_single_transaction->load(['category']);

            $arr_single_transaction = $obj_single_transaction->toArray();
         }
               $data                       = array();
               $data['username']           = $arr_single_transaction['user_records']['first_name'];
               $data['business']           = $arr_single_transaction['business']['business_name'];
               $data['category']           = $arr_single_transaction['category']['title'];
               $data['price']              = $arr_single_transaction['price'];
               $data['transaction_status'] = $arr_single_transaction['transaction_status'];
               $data['membership']         = $arr_single_transaction['membership']['title'];

          $arr_data['transaction_status']  = $request->input('transaction_status');
           $result =TransactionModel::where('id',$id)->update($arr_data);
          if($data)
          {
        			$json['data'] 	 = $data;
        			$json['status']	 = "SUCCESS";
        			$json['message'] = 'Transaction Updated Successfully!.';	
          }
      		else
      		{
      			$json['status']	  = "ERROR";
                  $json['message']  = 'Error while transaction update';	
      		}
         return response()->json($json);
      }

     public function view(Request $request)
     {
        $id     =  $request->input('id');
        $arr_single_transaction = $arr_data=array();
        $obj_single_transaction = TransactionModel::where('id',$id)->first();

        if($obj_single_transaction)
        {
            $obj_single_transaction->load(['user_records']);
            $obj_single_transaction->load(['membership']);
            $obj_single_transaction->load(['business']);
            $obj_single_transaction->load(['category']);

            $arr_single_transaction = $obj_single_transaction->toArray();
        }
                  $data =array();
                  $data['username']           = $arr_single_transaction['user_records']['first_name'];
	              $data['business']           = $arr_single_transaction['business']['business_name'];
	              $data['category']           = $arr_single_transaction['category']['title'];
	              $data['price']              = $arr_single_transaction['price'];
	              $data['transaction_status'] = $arr_single_transaction['transaction_status'];
	              $data['membership']         = $arr_single_transaction['membership']['title'];
	              $data['start_date']         = $arr_single_transaction['start_date'];
	              $data['expire_date']        = $arr_single_transaction['expire_date'];
	     
        if($data)
        {
			$json['data'] 	 = $data;
			$json['status']	 = "SUCCESS";
			$json['message'] = 'Transaction Details';	
        }
		else
		{
			$json['status']	  = "ERROR";
            $json['message']  = 'Error while transaction details';	
		}
        return response()->json($json);
     }
}
