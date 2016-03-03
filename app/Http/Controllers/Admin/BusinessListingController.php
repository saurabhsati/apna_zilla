<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BusinessListingModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\BusinessLocationModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\ZipModel;
use App\Models\CityModel;
use Validator;
use Session;
use Sentinel;
class BusinessListingController extends Controller
{
    //
    public function __construct()
    {
    	$arr_except_auth_methods = array();
        $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
    	 //$this->UserModel = new UserModel();
    	  $this->BusinessListingModel = new BusinessListingModel();
    	  $this->BusinessLocationModel = new BusinessLocationModel();

    }
    public function index()
    {
    	$page_title	='Manage Business Listing';
    	$business_listing	=array();
    	$business_listing=$this->BusinessListingModel->with(['categoty_details','user_details'])->get()->toArray();
    	return view('web_admin.business_listing.index',compact('page_title','business_listing'));
    }
    public function create()
    {
    	$page_title="Create Business List";

    	$obj_user_res = UserModel::where('role','sales')->get();
        if( $obj_user_res != FALSE)
        {
            $arr_user = $obj_user_res->toArray();
        }
        $obj_category = CategoryModel::where('parent','0')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

        return view('web_admin.business_listing.create',compact('page_title','arr_user','arr_category'));
    }
    public function store(Request $request)
    {
    	$arr_rules	=	array();
    	$arr_rules['business_name']='required';
    	$arr_rules['business_cat']='required';
    	$arr_rules['user_id']='required';

    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/business_listing/create')->withErrors($validator)->withInput();
        }
        $form_data=$request->all();
        $arr_data['business_name']=$form_data['business_name'];
        $arr_data['is_active']='2';
        $arr_data['business_cat']=$form_data['business_cat'];
        $arr_data['user_id']=$form_data['user_id'];
        $insert_data=$this->BusinessListingModel->create($arr_data);
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
    public function edit($enc_id)
 	{
 		$id = base64_decode($enc_id);
 		$page_title = "Business Listing: Edit ";

 		$business_data = array();
 		$obj_category = CategoryModel::where('parent','0')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}
 		$obj_user_res = UserModel::where('role','sales')->get();
        if( $obj_user_res != FALSE)
        {
            $arr_user = $obj_user_res->toArray();
        }
 		$business_data=$this->BusinessListingModel->with(['user_details'])->where('id',$id)->get()->toArray();
 		return view('web_admin.business_listing.edit',compact('page_title','business_data','arr_user','arr_category'));

 	}
 	public function update(Request $request,$enc_id)
 	{
 		$id	=base64_decode($enc_id);
 		$form_data	= array();
 		$business_data = array();
 		$arr_rules = array();

 		$arr_rules['business_name'] = "required";
 		$arr_rules['business_cat'] = "required";
 		$arr_rules['user_id'] = "required";
       /* $arr_rules['title'] = "required";
        $arr_rules['first_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['city'] = "required";
        $arr_rules['mobile_no'] = "required";*/



        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user=Sentinel::createModel();

        $business_data['business_name']      = $request->input('business_name');
        $business_data['business_cat']=$request->input('business_cat');
        $business_data['user_id']=$request->input('user_id');


       /* $form_data['title']      = $request->input('title');
        $form_data['first_name']= $request->input('first_name');
        $form_data['last_name'] = $request->input('last_name');
        $form_data['email']      = $request->input('email');
        $form_data['city']      = $request->input('city');
        $form_data['mobile_no']      = $request->input('mobile_no');*/

		/*$user = Sentinel::findById($user_id);
        $user_data = Sentinel::update($user['id'],$form_data);
*/
        $business_data=$this->BusinessListingModel->where('id',$id)->update($business_data);

        if($business_data /*&& $user_data*/)
        {
        	Session::flash('success','Business Updated successfully');

        }
        else
        {
        	Session::flash('error','Error Occurred While Updating Business List ');
        }
        return redirect()->back();
   	}
   	public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Business(es) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','Business(es) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','Business(es) Deleted Successfully');
        }

        return redirect()->back();
    }
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Any Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','Business(es) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Business(es) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Business(es) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
     protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessListingModel->where('id',$id)->first();

        $Business->is_active = "1";

        return $Business->save();
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessListingModel->where('id',$id)->first();

        $Business->is_active = "0";

        return $Business->save();
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
        $Business = $this->BusinessListingModel->where('id',$id);
		return $Business->delete();
    }

    /* Location Start */
    public function location($enc_id)
    {
    	$page_title	="Business Locations";
    	$id =base64_decode($enc_id);
    	$business_locations	=array();
    	$business_locations=$this->BusinessLocationModel->with('city_details','zipcode_details','country_details','state_details')->where('business_id',$id)->get()->toArray();
    	return view('web_admin.business_listing.location.index',compact('page_title','business_locations','id'));
    }
     public function multi_action_loc(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please Select Any Record(s)');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="activate")
            {
               $this->_activate_loc($record_id);
               Session::flash('success','Business Location(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block_loc($record_id);
               Session::flash('success','Business Location(s) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete_loc($record_id);
                Session::flash('success','Business Location(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
    public function edit_location($enc_id)
    {
    	$id=base64_decode($enc_id);
    	$page_title="Edit Location";

    	$obj_countries_res = CountryModel::get();
        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }
        $obj_zipcode_res = ZipModel::get();
        if( $obj_zipcode_res != FALSE)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }
        $arr_city = array();
        $obj_city_res = CityModel::get();
        if($obj_city_res != FALSE)
        {
            $arr_city = $obj_city_res->toArray();
        }
        $arr_state = array();
        $obj_state_res = StateModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
        $business_locations	=array();
    	$business_locations=$this->BusinessLocationModel->with('city_details','zipcode_details','country_details','state_details')->where('id',$id)->first()->toArray();
    	return view('web_admin.business_listing.location.edit',compact('page_title','business_locations','arr_state','arr_country','arr_zipcode','arr_city'));
    }
    public function create_location($enc_id)
    {
    	$id=base64_decode($enc_id);
    	$page_title="Create Location";


    	$obj_countries_res = CountryModel::get();
        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }
        $obj_zipcode_res = ZipModel::get();
        if( $obj_zipcode_res != FALSE)
        {
            $arr_zipcode = $obj_zipcode_res->toArray();
        }
        $arr_city = array();
        $obj_city_res = CityModel::get();
        if($obj_city_res != FALSE)
        {
            $arr_city = $obj_city_res->toArray();
        }
        $arr_state = array();
        $obj_state_res = StateModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
        return view('web_admin.business_listing.location.create',compact('page_title','arr_state','arr_country','arr_zipcode','arr_city','id'));

    }
    public function store_location($enc_id,Request $request )
    {

    	$id=base64_decode($enc_id);
    	$form_data	= array();
    	$form_data['business_id']=$id;
    	$form_data['building']=$request->input('building');
		$form_data['street']=$request->input('street');
		$form_data['landmark']=$request->input('landmark');
		$form_data['area']=$request->input('area');
		$form_data['city']=$request->input('city');
		$form_data['pincode']=$request->input('pincode');
		$form_data['state']=$request->input('state');
		$form_data['country']=$request->input('country');
		$save_locations=$this->BusinessLocationModel->create($form_data);
		if($save_locations)
		{
			Session::flash('success','Business Location Created successfully');
        }
        else
        {
        	Session::flash('error','Error Occurred While Creating Business Location  ');
        }
        return redirect()->back();
    }
    public function update_location(Request $request ,$enc_id)
    {
    	$id=base64_decode($enc_id);

    	$arr_rules = array();

 		$arr_rules['building'] = "required";
 		$arr_rules['street'] = "required";
        $arr_rules['landmark'] = "required";
        $arr_rules['area'] = "required";
        $arr_rules['city'] = "required";
        $arr_rules['pincode'] = "required";
        $arr_rules['state'] = "required";
        $arr_rules['country'] = "required";
        $validator=validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    	$form_data	= array();
    	$form_data['building']=$request->input('building');
		$form_data['street']=$request->input('street');
		$form_data['landmark']=$request->input('landmark');
		$form_data['area']=$request->input('area');
		$form_data['city']=$request->input('city');
		$form_data['pincode']=$request->input('pincode');
		$form_data['state']=$request->input('state');
		$form_data['country']=$request->input('country');
		$update_locations=$this->BusinessLocationModel->where('id',$id)->update($form_data);
		if($update_locations)
		{
			Session::flash('success','Business Location Updated successfully');
        }
        else
        {
        	Session::flash('error','Error Occurred While Updating Business Location  ');
        }
        return redirect()->back();

    }
    public function location_toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate_loc($enc_id);

            Session::flash('success','Business location(s) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block_loc($enc_id);

            Session::flash('success','Business location(s) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete_loc($enc_id);

            Session::flash('success','Business location(s) Deleted Successfully');
        }

        return redirect()->back();
    }
      protected function _activate_loc($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessLocationModel->where('id',$id)->first();

        $Business->is_active = "1";

        return $Business->save();
    }

    protected function _block_loc($enc_id)
    {
        $id = base64_decode($enc_id);

        $Business = $this->BusinessLocationModel->where('id',$id)->first();

        $Business->is_active = "0";

        return $Business->save();
    }

    protected function _delete_loc($enc_id)
    {
    	$id = base64_decode($enc_id);
        $Business = $this->BusinessLocationModel->where('id',$id);
		return $Business->delete();
    }
    /* Location End */
}
