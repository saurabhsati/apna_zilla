<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TransactionModel;
class TransactionController extends Controller
{

    public function index()
    {
    	$arr_transaction = array();
 		$obj_transaction = TransactionModel::orderBy('id','DESC')->get();

        if($obj_transaction)
        {
            $arr_transaction = $obj_transaction->toArray();
        }

        dd($arr_transaction); exit;
 	}
}
