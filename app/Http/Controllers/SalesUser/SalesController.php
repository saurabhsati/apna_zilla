<?php
namespace App\Http\Controllers\SalesUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\CategoryModel;
use Sentinel;
use Session;
use Validator;
use App\Http\Controllers\Common\GeneratorController;


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
 		$page_title = "Manage Sales Users";

        $arr_user = array();
        $obj_user = Sentinel::createModel()->where('role','=','sales')->get();

        return view('web_admin.sales_user.index',compact('page_title','obj_user'));
 	}

 	public function create()
 	{
 		$page_title = "Sales User: Create ";

 		return view('web_admin.sales_user.create',compact('page_title'));
 	}

 	public function store(Request $request)
 	{
 	  	$arr_rules = array();
        $arr_rules['first_name'] = "required";
        $arr_rules['middle_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['gender'] = "required";
        $arr_rules['d_o_b'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['password'] = "required|min:6";
        // $arr_rules['role'] ="required";
        $arr_rules['marital_status'] = "required";
        $arr_rules['city'] = "required";
        $arr_rules['area'] = "required";
        $arr_rules['occupation'] = "required";
        $arr_rules['work_experience'] = "required";

        $arr_rules['street_address'] = "required";
        $arr_rules['mobile_no'] = "required";
        $arr_rules['home_landline'] = "required";
        $arr_rules['office_landline'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $first_name       = $request->input('first_name');
        $middle_name       = $request->input('middle_name');
        $last_name       = $request->input('last_name');
        $gender       = $request->input('gender');
        $d_o_b       = $request->input('d_o_b');
        $email          = $request->input('email');
        $password   = $request->input('password');
        $marital_status       = $request->input('marital_status');
        // $role       = $request->input('role');
        $city       = $request->input('city');
        $area       = $request->input('area');
        $occupation       = $request->input('occupation');
        $work_experience       = $request->input('work_experience');
        $street_address     = $request->input('street_address');
        $mobile_no     = $request->input('mobile_no');
        $home_landline     = $request->input('home_landline');
        $office_landline     = $request->input('office_landline');

        /* Duplication Check*/
        $user = Sentinel::createModel();

        if($user->where('email',$email)->get()->count()>0)
        {
        	Session::flash('error','User Already Exists with this email id');
            return redirect()->back();
        }


        $profile_pic = "default.jpg";

        if ($request->hasFile('profile_pic'))
        {
            $profile_pic_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array(
                                                'profile_pic' => 'mimes:jpg,jpeg,png'
                                            ));

            if ($request->file('profile_pic')->isValid() && $profile_pic_valiator->passes())
            {

                $cv_path = $request->file('profile_pic')->getClientOriginalName();
                $image_extension = $request->file('profile_pic')->getClientOriginalExtension();
                $image_name = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                $request->file('profile_pic')->move(
                    $this->profile_pic_base_path, $image_name
                );

                $profile_pic = $image_name;
            }
            else
            {
                return redirect()->back();
            }

        }


         $status = Sentinel::registerAndActivate([
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'gender' => $gender,
            'd_o_b' => date('Y-m-d',strtotime($d_o_b)),
            'email' => $email,
            'password' => $password,
            'marital_status' => $marital_status,
           	'role' => "sales",
            'street_address' => $street_address,
            'city' =>$city,
            'area' => $area,
            'occupation' => $occupation,
            'work_experience' => $work_experience,
            'mobile_no' => $mobile_no,
            'home_landline' => $home_landline,
            'office_landline' => $office_landline,
            'is_active' => '1',
            'profile_pic'=>$profile_pic
        ]);

        if($status)
        {
			/* Assign Sales Users Role */
            $enc_id=$status->id;
            $public_id = (new GeneratorController)->alphaID($enc_id);


            //$user = Sentinel::create('public_id');
            $role = Sentinel::findRoleBySlug('sales');

            $user = Sentinel::findById($status->id);
        //$user = Sentinel::getUser();

            $user->roles()->attach($role);

            Session::flash('success','User Created Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Creating User ');
        }

        return redirect()->back();
	}

public function edit($enc_id)
 	{
 		$id = base64_decode($enc_id);
 		$page_title = "User: Edit ";

 		$arr_user_data = array();
 		$obj_user = Sentinel::findById($id);

 		if($obj_user)
 		{
 			$arr_user_data = $obj_user->toArray();
 		}

 		$profile_pic_public_path = $this->profile_pic_public_path;

        return view('web_admin.sales_user.edit',compact('page_title','arr_user_data','profile_pic_public_path'));

 	}

 	public function update(Request $request, $enc_id)
    {
        $user_id = base64_decode($enc_id);
        $arr_rules = array();

        $arr_rules['first_name'] = "required";
        $arr_rules['middle_name'] = "required";
        $arr_rules['last_name'] = "required";
        $arr_rules['email'] = "required|email";
        $arr_rules['password'] = "min:6";
        $arr_rules['street_address'] = "required";
        $arr_rules['gender'] = "required";
        $arr_rules['marital_status'] = "required";
        $arr_rules['d_o_b'] = "required";
        // $arr_rules['role'] = "required";
        $arr_rules['city'] = "required";
        $arr_rules['area'] = "required";
        $arr_rules['mobile_no'] = "required";
        $arr_rules['home_landline'] = "required";
        $arr_rules['office_landline'] = "required";


        $validator=Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name');
        $last_name = $request->input('last_name');
        $email      = $request->input('email');
        $password   = $request->input('password',FALSE);
        $street_address      = $request->input('street_address');
        $gender         = $request->input('gender');
        $marital_status      = $request->input('marital_status');
        $d_o_b      = $request->input('d_o_b');
        // $role       =$request->input('role');
        $city      = $request->input('city');
        $area      = $request->input('area');
        $mobile_no      = $request->input('mobile_no');
        $home_landline      = $request->input('home_landline');
        $office_landline      = $request->input('office_landline');


        $user=Sentinel::createModel();

        if($user->where('email',$email)->whereNotIn('id',[$user_id])->get()->count()>0)
        {
            Session::flash('error','User Already Exists with this email id');
            return redirect()->back();
        }

         $profile_pic = FALSE;
        if ($request->hasFile('profile_pic'))
        {
            $cv_valiator = Validator::make(array('profile_pic'=>$request->file('profile_pic')),array(
                                                'profile_pic' => 'mimes:jpg,jpeg,png'
                                            ));

            if ($request->file('profile_pic')->isValid() && $cv_valiator->passes())
            {

                $cv_path = $request->file('profile_pic')->getClientOriginalName();
                $image_extension = $request->file('profile_pic')->getClientOriginalExtension();
                $image_name = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                $request->file('profile_pic')->move(
                    $this->profile_pic_base_path, $image_name
                );

                $profile_pic = $image_name;
            }
            else
            {
                return redirect()->back();
            }

        }

        $arr_data = [
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'email' => $email,
            'street_address' => $street_address,
            'gender' => $gender,
            'marital_status' => $marital_status,
            'd_o_b'    => date('Y-m-d',strtotime($d_o_b)),
            // 'role'  => $role,
            'city' => $city,
            'area' => $area,
            'mobile_no' => $mobile_no,
            'home_landline' => $home_landline,
            'office_landline' => $office_landline,

        ];

        if($password!=FALSE)
        {
            $arr_data['password'] = $password;
        }

        if($profile_pic!=FALSE)
        {
            $arr_data['profile_pic'] = $profile_pic;
        }

        $user = Sentinel::findById($user_id);

        $status = Sentinel::update($user,$arr_data);

        if($status)
        {
            Session::flash('success','User Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Updating User ');
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
               Session::flash('success','User(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','User(s) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','User(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }

   public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','User(s) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','User(s) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','User(s) Deleted Successfully');
        }

        return redirect()->back();
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        $user = Sentinel::createModel()->where('id',$id)->first();

        $user->is_active = "1";

        return $user->save();
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        $user = Sentinel::createModel()->where('id',$id)->first();

        $user->is_active = "0";

        return $user->save();
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
        $user = Sentinel::findById($id);
		return $user->delete();
    }

}
