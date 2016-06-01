<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BusinessListingModel;
use App\Models\DealsOffersModel;
use Session;
use Sentinel;

class DashboardController extends Controller
{
 	public function __construct()
 	{
 		$arr_except_auth_methods = array();
 		$this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
 	}   

 	public function index()
 	{
 		$page_title   = "Dashboard";

 		$vender_count = $sales_executive_count = $business_listing_count = $deals_count = 0;
 		$obj_user     = $obj_sales_executive  = $obj_business_listing = $obj_deal = [];

 		$obj_user     = Sentinel::createModel()->where('role','=','normal')->get();
 		if($obj_user!= FALSE)
 		{
 			$vender_count=	sizeof($obj_user->toArray());
 		}

 		$obj_sales_executive = Sentinel::createModel()->where('role','=','sales')->get();
 		if($obj_sales_executive!=FALSE)
 		{
 			$sales_executive_count=	sizeof($obj_sales_executive->toArray());
 		}

 		$obj_business_listing = BusinessListingModel::get();
        if($obj_business_listing)
        {
            $business_listing_count = sizeof($obj_business_listing->toArray());
        }

 		$obj_deal=DealsOffersModel::get();
        if($obj_deal)
         {
            $deals_count = sizeof($obj_deal->toArray());
         }
 		return view('web_admin.dashboard.dashboard',compact('page_title','page_title','vender_count','sales_executive_count','business_listing_count','deals_count'));
 	}	

}
