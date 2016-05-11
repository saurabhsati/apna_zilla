<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BuyInBulkModel;
use Validator;
use Session;
class BuyInBulkRequestController extends Controller
{
   public function index()
    {
    	$page_title = 'Buy In Bulk Request :Manage';

    	$arr_request = array();
 		$obj_request = BuyInBulkModel::orderBy('id','ASC')->get();

 		if($obj_request)
 		{
 			$obj_request->load(['order_deal']);
 			 $arr_request = $obj_request->toArray();
        }
       // dd($arr_request);
        return view('web_admin.deals_bulk_order_request.index',compact('page_title','arr_request'));
    }

    public function view($enc_id)
    {
    	$id = base64_decode($enc_id);

    	$page_title = 'Buy In Bulk: View';

    	$arr_single_request = array();
    	$obj_single_request = BuyInBulkModel::where('id',$id)->first();

    	if($obj_single_request)
    	{
    		$obj_single_request->load(['order_deal']);
            $arr_single_request = $obj_single_request->toArray();
    	}
    	//dd($arr_single_request);
    	return view('web_admin.deals_bulk_order_request.view',compact('page_title','arr_single_request'));
    }
}
