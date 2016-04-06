<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TransactionModel;

use Validator;
use Session;

class TransactionController extends Controller
{
    public function __construct()
    {
    	$arr_except_auth_methods = array();
    	$this->middleware('\App\Http\Middleware\SentinelCheck',['except'=> $arr_except_auth_methods]);
    }

    public function index()
    {
    	$page_title = 'Transaction :Manage';

    	$arr_transaction = array();
 		$obj_transaction = TransactionModel::orderBy('id','ASC')->get();

 		if($obj_transaction)
 		{
 			$obj_transaction->load(['user_records']);
 			$obj_transaction->load(['membership']);

            $arr_transaction = $obj_transaction->toArray();
        }
       // dd($arr_transaction);
        return view('web_admin.transaction.index',compact('page_title','arr_transaction'));
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

    		$arr_single_transaction = $obj_single_transaction->toArray();
    	}

    	return view('web_admin.transaction.view',compact('page_title','arr_single_transaction'));
    }
}
