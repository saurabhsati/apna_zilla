<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use Validator;
use Session;
class CountryController extends Controller
{
    //
    public function __construct()
    {
    	$this->country_base_img_path = base_path().'/public/uploads/countries/images/';
        $this->country_base_data_path = base_path().'/public/uploads/countries/data/';
        $this->country_public_img_path = url('/').'/uploads/countries/images/';
    }
    public function index()
    {

        $page_title = "Manage Countries";
        $arr_countries = array();

        $obj_countries_res = CountryModel::get();

        if($obj_countries_res)
        {
            $arr_countries = $obj_countries_res->toArray();
        }

        $country_public_img_path = $this->country_public_img_path;

        return view('web_admin.country.index',compact('page_title','arr_countries','country_public_img_path'));
    }
     public function show($enc_id)
    {
       $page_title = "Show Country";
       $id = base64_decode($enc_id);

       $arr_country = array();
       $obj_country = CountryModel::where('id',$id)->first();
       if($obj_country)
       {
          $arr_country = $obj_country->toArray();
       }

       $country_public_img_path = $this->country_public_img_path;

       return view('web_admin.country.show',compact('page_title','arr_country','country_public_img_path'));

    }
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $page_title = "Edit Country";

        $obj_country = CountryModel::where('id',$id)->first();
        if($obj_country)
        {
           $arr_country = $obj_country->toArray();
        }

        $country_public_img_path = $this->country_public_img_path;


        return view('web_admin.country.edit',compact('page_title','arr_country','country_public_img_path'));
    }
    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_rules = array();
        $arr_rules['country_name'] = "required";
        $arr_rules['country_code'] = "required";



        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect('/web_admin/countries/edit/'.$enc_id)->withErrors($validator)->withInput();
        }

        $form_data = array();
        $form_data = $request->all();


        $arr_data['country_name'] = $form_data['country_name'];
        $arr_data['country_code'] = strtoupper($form_data['country_code']);


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
                $request->file('image')->move($this->country_base_img_path, $fileName);

            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
            $arr_data['country_image'] = $fileName;
        }



        /*---------- File uploading code ends ------------*/


        if(CountryModel::where('id',$id)->update($arr_data))
        {
            Session::flash('success','Country Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured, While Updating Country');
        }

        return redirect('/web_admin/countries/edit/'.$enc_id);
    }
     public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Country(ies) Activated Successfully');
        }
        elseif($action=="deactivate")
        {
            $this->_block($enc_id);

            Session::flash('success','Country(ies) Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/countries');
    }


    public function delete($enc_id)
    {
        $this->_delete($enc_id);
        Session::flash('success','Country(ies) Deleted Successfully');
        return redirect()->back();
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        return CountryModel::where('id',$id)
                  ->update(['is_active'=>'1']);
    }
    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        return CountryModel::where('id',$id)
                  ->update(['is_active'=>'0']);
    }
     protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);
       return CountryModel::where('id',$id)->delete();
    }
     public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/countries')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect('/web_admin/countries');

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Country(ies) Deleted Successfully');
            }
            elseif($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','Country(ies) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Country(ies) Blocked Successfully');
            }
        }

        return redirect('/web_admin/countries');
    }
    public function create()
    {
        $page_title = "Create Country";

        return view('web_admin.country.create',compact('page_title','arr_country'));
    }
 	public function store(Request $request)
    {
        $form_data = array();

        /*---------- File uploading code starts here ------------*/

        $form_data = $request->all();

        $fileName = "";
        $file_url = "";

        if ($request->hasFile('excel_file'))
        {
            $excel_file_name = $form_data['excel_file'];
            $fileExtension = $request->file('excel_file')->getClientOriginalExtension();

            if($fileExtension == 'csv' || $fileExtension == 'xls' || $fileExtension == 'xlsx')
            {

                $fileName = sha1(uniqid().$excel_file_name.uniqid()).'.'.$fileExtension;
                $request->file('excel_file')->move($this->country_base_data_path, $fileName);

                $this->_parse_uploded_file($this->country_base_data_path."/".$fileName);

            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }


        /*---------- File uploading code ends ------------*/

       return redirect('/web_admin/countries/create');
    }
    public function _parse_uploded_file($file_name)
    {
        $success = 1;
        Excel::load($file_name, function($reader)
        {
            $results = $reader->get();
            if($results)
            {
                $result_arry =  $results->toArray();

                if(sizeof($result_arry) > 0)
                {
                    foreach ($result_arry as $ary)
                    {

                        $arr_data = array();
                        $arr_data['country_name'] =  $ary['country_name'];
                        $arr_data['country_code'] =  $ary['country_code'];
                        $arr_data['country_slug'] = str_slug($ary['country_name'], "-");


                        /* Duplication Check */
                        $success = 1;
                        if(CountryModel::where('country_code',$arr_data['country_code'])->exists()==FALSE)
                        {
                            $status = CountryModel::create($arr_data);
                            if($status)
                            {
                                $last_inserted_id = $status->id;

                                /* Update Countries public key */
                                $public_key = (new GeneratorController)->alphaID($last_inserted_id);

                                CountryModel::where('country_code',$arr_data['country_code'])
                                                    ->update(['public_key'=>$public_key]);

                                Session::flash('success','Country Inserted Successfully');

                            }
                            else
                            {
                                $success = 0;
                                Session::flash('error','Problem Occured, While  Insering record for country code: '.$this->CountryModel->country_code);
                                 break;
                            }
                        }
                        else
                        {
                            //update record
                            CountryModel::where('country_code',$arr_data['country_code'])
                                        ->update(['country_name' =>$arr_data['country_name'],
                                                  'country_slug' =>  $arr_data['country_slug']]);
                        }




                    } //foreach

                    if($success == 0)
                    {
                        Session::flash('error','Problem Occured, While Insering record for Country code :'.$this->CountryModel->country_code);
                        break;
                    }
                    else
                    {
                         Session::flash('success','Countries Inserted Successfully');
                    }

                } //if sizeof


            }


        });

    }



}
