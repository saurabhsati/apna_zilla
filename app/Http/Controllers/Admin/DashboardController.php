<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class DashboardController extends Controller
{
 	public function __construct()
 	{
 		$arr_except_auth_methods = array();
 		$this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
 	}   

 	public function index()
 	{
 		// Sentinel::logout();
	
 		$page_title = "Dashboard";

 		
 		return view('web_admin.dashboard.dashboard',compact('page_title','page_title'));
 	}	

}
