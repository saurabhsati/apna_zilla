<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\GeneratorController;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;

use Validator;
use Session;
use DB;

class CityController extends Controller
{
    //
    public function __construct()
    {
    	$this->city_public_img_path = url('/')."/uploads/cities/";
        $this->city_base_img_path = base_path()."/public/uploads/cities/";
    }
    public function index()
    {
    	$page_title	=	"Manage City";
    	$arr_cities = array();

        $obj_cities_res = CityModel::with(['country_details','state_details'])->get();

        if( $obj_cities_res != FALSE)
        {
            $arr_cities = $obj_cities_res->toArray();
        }
        $city_public_img_path = $this->city_public_img_path;
    	return view('web_admin.cities.index',compact('page_title','arr_cities','city_public_img_path'));
    }
    public function create()
    {
    	$page_title="Create City";
    	$arr_country = array();

        $obj_countries_res = CountryModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_country = $obj_countries_res->toArray();
        }
        $arr_state = array();

        $obj_state_res = StateModel::get();

        if( $obj_countries_res != FALSE)
        {
            $arr_state = $obj_state_res->toArray();
        }
        return view('web_admin.cities.create',compact('page_title','arr_country'));
    }

    public function store(Request $request)
    {
    	$arr_rules	=	array();
    	$arr_rules['country_name']='required';
    	$arr_rules['state']='required';
    	$arr_rules['city_title']='required';

    	$validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/countries')->withErrors($validator)->withInput();
        }
    	$form_data	=array();
    	$form_data	=$request->all();
        $arr_data['countries_id'] = $form_data['country_name'];
        $arr_data['city_title'] = $form_data['city_title'];
        $arr_data['city_slug'] = str_slug($form_data['city_title'], "-");

        if(isset($form_data['state']))
             $arr_data['state_id'] = $form_data['state'];

        if($request->hasFile('image'))
        {
            $fileName       = $form_data['image'];
            $fileExtension  = strtolower($request->file('image')->getClientOriginalExtension());
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                  $request->file('image')->move($this->city_base_img_path,$filename);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }

        $arr_data['city_image'] = $filename;

        if(CityModel::create($arr_data))
        {

            $last_inserted_id = DB::getPdo()->lastInsertId();

            /* Update Countries public key */
            $public_key = (new GeneratorController)->alphaID($last_inserted_id);

            CityModel::where('id',$last_inserted_id)
                                ->update(['public_key'=>$public_key]);

            Session::flash('success','City Inserted Successfully');

        }
        else
        {

            Session::flash('error','Problem Occured, While  Insering record ');
             break;
        }



       return redirect('/web_admin/cities/create');
    }
    public function show($enc_id)
    {
        $page_title =   "Show city";
        $id = base64_decode($enc_id);
        $arr_cities = array();
        $obj_city_res = CityModel::where('id',$id)->with(['country_details','state_details'])->get();

        if( $obj_city_res != FALSE)
        {
            $arr_cities = $obj_city_res->toArray();
        }


        $city_public_img_path = $this->city_public_img_path;
        return view('web_admin.cities.show',compact('page_title','arr_cities','city_public_img_path'));
    }
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_city = array();

        $page_title = "Edit City";

        $obj_cities_res = CityModel::where('id',$id)->with(['country_details','state_details'])->get();

        if( $obj_cities_res != FALSE)
        {
            $arr_city = $obj_cities_res->toArray();
        }

        $city_public_img_path = $this->city_public_img_path;

        return view('web_admin.cities.edit',compact('page_title','arr_city','city_public_img_path'));
    }
    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $arr_rules = array();
        $arr_rules['city_title'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = array();
        $form_data = $request->all();


        $arr_data['city_title'] = $form_data['city_title'];


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
                $request->file('image')->move($this->city_base_img_path, $fileName);

            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;

            $arr_data['city_image'] = $fileName;
        }



        /*---------- File uploading code ends ------------*/


        if(CityModel::where('id',$id)->update($arr_data))
        {
            Session::flash('success','City Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured, While Updating State');
        }

        return redirect('/web_admin/cities/edit/'.$enc_id);
    }
     public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','City/Cities Activated Successfully');
        }
        elseif($action=="deactivate")
        {
            $this->_block($enc_id);

            Session::flash('success','City/Cities Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/cities');
    }
    public function delete($enc_id)
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','City/Cities Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Deleting City/Cities');
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
            return redirect('/web_admin/cities')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect('/web_admin/cities');

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','City(ies) Deleted Successfully');
            }
            elseif($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','City(ies) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','City(ies) Blocked Successfully');
            }
        }

        return redirect('/web_admin/cities');
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        return CityModel::where('id',$id)
                  ->update(['is_active'=>'1']);
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        return CityModel::where('id',$id)
                  ->update(['is_active'=>'0']);
    }
    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);
        return CityModel::where('id',$id)->delete();
    }

    public function export_excel($format="csv")//export excel file
    {

        if($format=="csv")
        {
            $arr_city = array();
            $obj_city = CityModel::with(['state_details','country_details'])->get();
         

            if($obj_city)
            {
                $arr_city = $obj_city->toArray();

                \Excel::create('CITY-'.date('Ymd').uniqid(), function($excel) use($arr_city) 
                {
                    $excel->sheet('City', function($sheet) use($arr_city) 
                    {
                        $sheet->cell('A1', function($cell) {
                            $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        });

                        $sheet->row(2, array(
                            'Sr. No.', 'City','State/Region :: Country'
                        ));

                        if(sizeof($arr_city)>0)
                        {
                            $arr_tmp = array();
                            foreach ($arr_city as $key => $cites) 
                            {
                                $arr_tmp[$key][] = $key+1;
                                $arr_tmp[$key][] = $cites['city_title'];
                                $arr_tmp[$key][] = $cites['state_details']['state_title'].' :: '.$cites['country_details']['country_name'];
                            }    

                            $sheet->rows($arr_tmp);
                        }

                    });
                    

                })->export('csv');
            }
        }
    }

}
