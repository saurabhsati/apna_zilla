<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use App\Models\StateModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Http\Controllers\Common\GeneratorController;
class StateController extends Controller
{
    //
    public function __construct()
    {
    	$this->state_public_img_path = url('/')."/uploads/states/";
        $this->state_base_img_path = base_path()."/public/uploads/states/";
    }

    public function index()
    {
    	$page_title	=	"Manage States";
    	 $arr_states = array();

        $obj_countries_res = StateModel::get();

        if($obj_countries_res)
        {
            foreach ($obj_countries_res as $countries)
            {
                $countries->country_details;
            }

            $arr_states = $obj_countries_res->toArray();
        }

        $state_public_img_path = $this->state_public_img_path;
    	return view('web_admin.states.index',compact('page_title','arr_states','state_public_img_path'));
    }

    public function create()
    {
        $page_title = "Create State";
        $arr_country = array();

        $obj_countries_res = CountryModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }

        return view('web_admin.states.create',compact('page_title','arr_country'));
    }

    public function store(Request $request)
    {
        $form_data = array();
        $arr_rules['state_title'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = $request->all();
        $arr_data['state_title'] = $form_data['state_title'];
        $arr_data['countries_id'] = $form_data['country_id'];
        $arr_data['state_slug'] =str_slug($form_data['state_title'], "-");

        /*---------- File uploading code starts here ------------*/

        $form_data = $request->all();

         $fileName = "default.jpg";
         $file_url = "";

         if ($request->hasFile('image'))
         {
            $file_name = $form_data['image'];
            $fileExtension = strtolower($request->file('image')->getClientOriginalExtension());

            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                $fileName = sha1(uniqid().$file_name.uniqid()).'.'.$fileExtension;
                $request->file('image')->move($this->state_base_img_path, $fileName);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }

        $arr_data['state_image'] = $fileName;


        /*---------- File uploading code ends ------------*/
        $status = StateModel::create($arr_data);
        if($status)
        {
            $last_inserted_id = $status->id;

            /* Update Countries public key */
            $public_key = (new GeneratorController)->alphaID($last_inserted_id);

            StateModel::where('id',$last_inserted_id)
                             ->update(['public_key'=>$public_key]);

            Session::flash('success','State/Region Inserted Successfully');

        }
        else
        {

            Session::flash('error','Problem Occured, While  Insering record ');
             break;
        }



       return redirect('/web_admin/states/create');
    }

    public function show($enc_id)
    {
        $page_title = "Show State";
        $id = base64_decode($enc_id);
        $arr_state = array();
        $obj_countries_res = StateModel::where('id',$id)->get();

        if($obj_countries_res)
        {
            foreach ($obj_countries_res as $countries)
            {
                $countries->country_details;
            }

            $arr_state = $obj_countries_res->toArray();
        }

        $state_public_img_path = $this->state_public_img_path;

        return view('web_admin.states.show',compact('page_title','arr_state','state_public_img_path'));
    }

    public function edit($enc_id)
    {
    	 $id = base64_decode($enc_id);
        $arr_state = array();

       // $arr_states = $this->StateModel->where('id',$id)->first()->toArray();
        $page_title = "Edit State";

        $obj_countries_res = StateModel::where('id',$id)->get();

        if( $obj_countries_res != FALSE)
        {
            foreach ($obj_countries_res as $countries)
            {
                $countries->country_details;
            }

            $arr_state = $obj_countries_res->toArray();
        }

        $state_public_img_path = $this->state_public_img_path;
        return view('web_admin.states.edit',compact('page_title','arr_state','state_public_img_path'));
    }

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_rules = array();
        $arr_rules['state_title'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = array();
        $form_data = $request->all();


        $arr_data['state_title'] = $form_data['state_title'];


       /*---------- File uploading code starts here ------------*/


         $fileName = "";
         $file_url = "";

         if ($request->hasFile('image'))
         {
            $excel_file_name = $form_data['image'];
            $fileExtension = strtolower($request->file('image')->getClientOriginalExtension());

            if(in_array($fileExtension,['png','jpg','jpeg']))
            {

                $fileName = sha1(uniqid().$excel_file_name.uniqid()).'.'.$fileExtension;
                $request->file('image')->move($this->state_base_img_path, $fileName);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;

            $arr_data['state_image'] = $fileName;
        }



        /*---------- File uploading code ends ------------*/


        if(StateModel::where('id',$id)->update($arr_data))
        {
            Session::flash('success','State Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured, While Updating State');
        }

        return redirect('/web_admin/states/edit/'.$enc_id);
    }

    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','State(s) Activated Successfully');
        }
        elseif($action=="deactivate")
        {
            $this->_block($enc_id);

            Session::flash('success','State(s) Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/states');
    }

    public function multi_action(Request $request)
    {
    	$arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/states')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect('/web_admin/states');

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','State(s) Deleted Successfully');
            }
            elseif($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','State(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','State(s) Blocked Successfully');
            }
        }

        return redirect('/web_admin/states');
    }
    public function delete($enc_id)
    {
        $this->_delete($enc_id);
        Session::flash('success','State(s) Deleted Successfully');
        return redirect()->back();
    }
    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

         return StateModel::where('id',$id)
                  ->update(['is_active'=>'1']);
    }
    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        return StateModel::where('id',$id)
                  ->update(['is_active'=>'0']);
    }
    protected function _delete($enc_id)
    {
    	 $id = base64_decode($enc_id);
         CityModel::where('state_id',$id)->delete();
		return StateModel::where('id',$id)
                  ->delete();
    }

}
