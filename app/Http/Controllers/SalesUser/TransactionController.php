<?php

namespace App\Http\Controllers\SalesUser;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TransactionModel;

use Validator;
use Session;
class TransactionController extends Controller
{
    public function index()
    {
    	$page_title = 'Transaction :Manage';
    	 if(Session::has('public_id')){
    	  $sales_user_public_id=Session::get('public_id');
         }else
         {
 			return view('sales_user.account.login');
         }
    	$arr_transaction = array();
 		$obj_transaction = TransactionModel::where('sales_user_public_id',$sales_user_public_id)->orderBy('id','DESC')->get();

 		if($obj_transaction)
 		{
 			$obj_transaction->load(['user_records']);
 			$obj_transaction->load(['membership']);
            $obj_transaction->load(['business']);
            $obj_transaction->load(['category']);
            $arr_transaction = $obj_transaction->toArray();
        }
       // dd($arr_transaction);
        return view('sales_user.transaction.index',compact('page_title','arr_transaction'));
    }

    public function view($enc_id)
    {
    	$id = base64_decode($enc_id);

    	$page_title = 'Transaction: View';

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

    	return view('sales_user.transaction.view',compact('page_title','arr_single_transaction'));
    }
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title = 'Transaction: Edit';

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

        return view('sales_user.transaction.edit',compact('page_title','arr_single_transaction'));
    }
    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules                  = array();
        $arr_rules['status']    = "required";
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $arr_data                                = array();
        $arr_data['transaction_status']           = $request->input('status');
        $transaction_status_update = TransactionModel::where('id',$id)->update($arr_data);

        if($transaction_status_update)
        {
            Session::flash('success','Transaction Updated Successfully');
        }
        else
        {
            Session::flash('error','Error While Updating Transaction details');
        }
        return redirect()->back();
    }
}
