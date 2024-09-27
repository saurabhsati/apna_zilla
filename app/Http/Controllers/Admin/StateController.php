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
    public function __construct()
    {

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

       return view('web_admin.states.index',compact('page_title','arr_states'));
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

        /*---------- File uploading code starts here ------------*/

        $form_data = $request->all();


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
        return view('web_admin.states.show',compact('page_title','arr_state'));
    }

    public function edit($enc_id)
    {
    	$id = base64_decode($enc_id);
        $arr_state = array();

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

       return view('web_admin.states.edit',compact('page_title','arr_state'));
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

    public function export_excel($format="csv")//export excel file
    {
        if($format=="csv")
        {
            $arr_state = array();
            $obj_state = StateModel::with(['country_details'])->get();


            if($obj_state)
            {
                $arr_state = $obj_state->toArray();

                \Excel::create('STATE-'.date('Ymd').uniqid(), function($excel) use($arr_state)
                {
                    $excel->sheet('State', function($sheet) use($arr_state)
                    {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, array(
                            'Sr.No.','States','Country'
                        ));

                        if(sizeof($arr_state)>0)
                        {
                            $arr_tmp = array();
                            foreach ($arr_state as $key => $state)
                            {
                                $arr_tmp[$key][] = $key+1;
                                $arr_tmp[$key][] = $state['state_title'];
                                $arr_tmp[$key][] = $state['country_details']['country_name'];
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }
}
