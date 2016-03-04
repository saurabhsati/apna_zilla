<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SalesModel;
use Sentinel;
use Session;
use Validator;

class SalesController extends Controller
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
 		$page_title = "Manage Business";

        $arr_user = array();
        $obj_user = SalesModel::get();

        return view('web_admin.sales_user.index',compact('page_title','obj_user'));
 	}

 	public function create()
 	{
 		$page_title = "Business: Create ";

 		return view('web_admin.sales_user.create',compact('page_title'));
 	}

 	public function store(Request $request)
 	{
 	$arr_rules	=	array();
    	$arr_rules['business_name']='required';
    	$arr_rules['business_cat']='required';
    	$arr_rules['user_id']='required';
    	$arr_rules['main_image']='required';
    	$arr_rules['hours_of_operation']='required';
    	$arr_rules['company_info']='required';
    	$arr_rules['keywords']='required';
    	$arr_rules['youtube_link']='required';
    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/sales/create')->withErrors($validator)->withInput();
        }
        $form_data=$request->all();
        $arr_data['business_name']=$form_data['business_name'];
        $arr_data['is_active']='2';
        $arr_data['business_cat']=$form_data['business_cat'];
        if($request->hasFile('main_image'))
        {
            $fileName       = $form_data['main_image'];
            $fileExtension  = strtolower($request->file('main_image')->getClientOriginalExtension());
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                  $request->file('main_image')->move($this->business_base_img_path,$filename);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }

        $arr_data['main_image'] = $filename;
        $arr_data['hours_of_operation']=$form_data['hours_of_operation'];
    	$arr_data['company_info']=$form_data['company_info'];
    	$arr_data['keywords']=$form_data['keywords'];
    	$arr_data['youtube_link']=$form_data['youtube_link'];
        $arr_data['user_id']=$form_data['user_id'];
        $insert_data=SalesModel::create($arr_data);
         if($insert_data)
        {
        	Session::flash('success','Business Created successfully');

        }
        else
        {
        	Session::flash('error','Error Occurred While Creating Business List ');
        }
        return redirect()->back();
}
}