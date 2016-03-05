<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\CategoryModel;
use Sentinel;
use Session;
use Validator;

class SalesAccountController extends Controller
{
 	public function __construct()
    {
        $arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);

        $this->profile_pic_base_path = base_path().'/public'.config('app.project.img_path.user_profile_pic');
        $this->profile_pic_public_path = url('/').config('app.project.img_path.user_profile_pic');      
    }   

 	public function index()
 	{
 		$page_title = "Sales User Dashboard";

 		return view('web_admin.sales_user_account.dashboard',compact('page_title'));
 	}

 	public function business_listing()
 	{
 	$page_title	='Manage Business Listing';
   
    return view('web_admin.sales_user_account.index',compact('page_title'));                                           
 	}

 	public function profile()
 	{
 		$page_title = "Sales User Profile";

 		return view('web_admin.sales_user_account.profile',compact('page_title'));
 	}

 	public function create_business()
 	{
 		$page_title = 'Create Business';

 		$obj_category = CategoryModel::where('parent','!=',[0])->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

 		return view('web_admin.sales_user_account.create_business',compact('page_title'));
 	}
 	
 }