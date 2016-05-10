<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DealsTransactionModel;
use Validator;
use Session;
class DealsOffersTransactionController extends Controller
{
    public function __construct()
    {
    	$arr_except_auth_methods = array();
    	$this->middleware('\App\Http\Middleware\SentinelCheck',['except'=> $arr_except_auth_methods]);
    }

    public function index()
    {
    	$page_title = 'Deals & Offers Transaction :Manage';

    	$arr_transaction = array();
 		$obj_transaction = DealsTransactionModel::orderBy('id','ASC')->get();

 		if($obj_transaction)
 		{
 			$obj_transaction->load(['user_records','user_orders','order_deal.offers_info']);
 			 $arr_transaction = $obj_transaction->toArray();
        }
       // dd($arr_transaction);
        return view('web_admin.deals_offers_order_transaction.index',compact('page_title','arr_transaction'));
    }

    public function view($enc_id)
    {
    	$id = base64_decode($enc_id);

    	$page_title = 'Deals & Offers Transaction: View';

    	$arr_single_transaction = array();
    	$obj_single_transaction = DealsTransactionModel::where('id',$id)->first();

    	if($obj_single_transaction)
    	{
    		$obj_single_transaction->load(['user_records','user_orders','order_deal.offers_info']);
            $arr_single_transaction = $obj_single_transaction->toArray();
    	}
    	//dd($arr_single_transaction);
    	return view('web_admin.deals_offers_order_transaction.view',compact('page_title','arr_single_transaction'));
    }
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title = 'Deals & Offers Transaction: Edit';

        $arr_single_transaction = array();
        $obj_single_transaction = DealsTransactionModel::where('id',$id)->first();

        if($obj_single_transaction)
        {
            $obj_single_transaction->load(['user_records','user_orders','order_deal.offers_info']);
            $arr_single_transaction = $obj_single_transaction->toArray();
        }
        //dd($arr_single_transaction);
        return view('web_admin.deals_offers_order_transaction.edit',compact('page_title','arr_single_transaction'));
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
        $transaction_status_update = DealsTransactionModel::where('id',$id)->update($arr_data);

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
