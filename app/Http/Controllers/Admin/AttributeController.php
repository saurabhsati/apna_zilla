<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Attribute;
use App\Model\AttributeOptionValue;
use App\Model\AttributeValidation;
use Validator;
use Session;


class AttributeController extends Controller
{

    protected $CategoryModel;
    protected $AttributeModel;
    protected $AttributeOptionValueModel;
    protected $AttributeValidationModel;

    public function __construct()
    {
        $this->CategoryModel = new Category();
        $this->AttributeModel = new Attribute();
        $this->AttributeOptionValueModel = new AttributeOptionValue();
        $this->AttributeValidationModel = new AttributeValidation();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($enc_id)
    {
        $page_title = "Manage Attribute";

        $category_id = base64_decode($enc_id);

        $arr_front_end_inputs = config('app.project.front_end_inputs');
        $arr_categoty = $this->CategoryModel->get();

        if ($arr_categoty)
        {
            $arr_categoty = $arr_categoty->toArray();
        }

        $arr_attributes = $this->AttributeModel->where('fk_category_id',$category_id)->get();

        foreach ($arr_attributes as $attribute) 
        {
            $attribute = $attribute->option_values;
        }

        if ($arr_attributes) 
        {
          $arr_attributes = $arr_attributes->toArray();
        }
        
        return view('web_admin.attribute.index',compact('page_title','arr_front_end_inputs','arr_categoty','arr_attributes','enc_id'));

    }



    /**
     * Show the form for creating a new resource.
     * Auther: sagar sainkar
     * Date: 18-12-2015
     * @return \Illuminate\Http\Response
     */
    public function create($enc_id)
    {
        $page_title = "Create Attribute";

        $category_id =  base64_decode($enc_id);

        $arr_front_end_inputs = config('app.project.front_end_inputs');

        
        $arr_category = $this->CategoryModel->where('cat_id',$category_id)->first();
        if ($arr_category) 
        {
            $arr_category = $arr_category->ToArray();
        }

        //dd($arr_category);

        $arr_attributes_validations = $this->AttributeValidationModel->get();
        if ($arr_attributes_validations) 
        {
           $arr_attributes_validations->toArray();
        }

        return view('web_admin.attribute.create',compact('page_title','arr_front_end_inputs','enc_id','arr_category','arr_attributes_validations'));
    }

    /**
     * Store a newly created resource in storage.
     * Auther: sagar sainkar
     * Date: 18-12-2015
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $arr_rules = array();
        $arr_rules['fk_category_id'] = "required";
        $arr_rules['attribute_code'] = "required";
        $arr_rules['frontend_input'] = "required";
        $arr_rules['frontend_label'] = "required";
        $arr_rules['frontend_label_de'] = "required";



        $arr_option_values = array();

        $from_data = $request->all();
        // /dd($from_data);
        

        if (isset($from_data['is_fillterable']) && $from_data['is_fillterable']==1) 
        {
            $arr_rules['front_fitter_type'] = "required";
        }


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (isset($from_data) && sizeof($from_data) > 0) 
        {
            unset($from_data['_token']);

            $from_data['attribute_code'] = str_slug($from_data['attribute_code'], "_");

            $status_attribute = $this->AttributeModel->create($from_data);
            $att_id = $status_attribute->id;
        }

        if (isset($att_id) && $att_id!="") 
        {
            if (isset($from_data['sort_order']) && sizeof($from_data['sort_order']) > 0)
            {  
                foreach ($from_data['sort_order'] as $key => $value) 
                {
                    if ($from_data['value'][$key]!="" && $from_data['sort_order'][$key]!="") 
                    {
                        $arr_option_values[$key]['attribute_id_fk'] = $att_id;
                        $arr_option_values[$key]['value'] = $from_data['value'][$key];
                        $arr_option_values[$key]['sort_order'] = $from_data['sort_order'][$key];
                        if ($key==$from_data['default_index']) 
                        {
                            $arr_option_values[$key]['is_default_selected'] = 1;
                        }    
                        else
                        {
                            $arr_option_values[$key]['is_default_selected'] = 0;
                        }
                    }
                    
                }
               
            }
        }

        
        


        if (isset($arr_option_values) && sizeof($arr_option_values)>0) 
        {
           foreach ($arr_option_values as $key => $value) 
           {
              $status = $this->AttributeOptionValueModel->create($value);
            
           }
        }


        
        
        if($status_attribute)
        {   
            Session::flash('success','Attribute Created Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Creating Attribute ');
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
            return redirect('/web-admin/categories')->withErrors($validator)->withInput();
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
               Session::flash('success','Attribute(s) Activated Successfully'); 
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);    
               Session::flash('success','Attribute(s) Blocked Successfully');   
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);    
                Session::flash('success','Attribute(s) Deleted Successfully');  
            }
             
        }

        return redirect()->back();
    }

    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {   
            $this->_activate($enc_id);

            Session::flash('success','Attribute(s) Activated Successfully');                 
        }
        elseif($action=="block")
        {
            $this->_block($enc_id); 

            Session::flash('success','Attribute(s) Blocked Successfully');                
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id); 

            Session::flash('success','Attribute(s) Deleted Successfully');                
        }

        return redirect()->back();
    }



    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        /* Block Child Attribute */
        $obj_attribute = $this->AttributeModel->where('attribute_id',$id)->first();

        if($obj_attribute!=FALSE)
        {
            return $this->AttributeModel->where('attribute_id',$id)->update(['is_active'=>'1']);    
        }       


    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        /* Block Child Attribute */
        $obj_attribute = $this->AttributeModel->where('attribute_id',$id)->first();

        if($obj_attribute!=FALSE)
        {
            return $this->AttributeModel->where('attribute_id',$id)->update(['is_active'=>'0']);    
        }
    
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        $obj_attribute = $this->AttributeModel->where('attribute_id',$id)->first();
        $obj_attribute->delete_option_values();
        return  $this->AttributeModel->where('attribute_id',$id)->delete();
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_attribute = $this->AttributeModel->where('attribute_id',$id)->first();
        $obj_attribute->option_values;
        if ($obj_attribute) 
        {
            $arr_attribute = $obj_attribute->toArray();    
        }

        $page_title = "Edit Attribute";

        $arr_front_end_inputs = config('app.project.front_end_inputs');
        $arr_categoty = $this->CategoryModel->get();
        if ($arr_categoty) 
        {
            $arr_categoty = $arr_categoty->ToArray();
        }

        $arr_attributes_validations = $this->AttributeValidationModel->get();
        if ($arr_attributes_validations) 
        {
           $arr_attributes_validations->toArray();
        }

        //dd($arr_attribute);

        return view('web_admin.attribute.edit',compact('page_title','arr_attribute','arr_front_end_inputs','arr_categoty','arr_attributes_validations'));
        
        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enc_id)
    {
        $attribute_id = base64_decode($enc_id);

        if (isset($attribute_id) && $attribute_id > 0) 
        {

            $arr_rules = array();
            $arr_rules['fk_category_id'] = "required";
            $arr_rules['attribute_code'] = "required";
            $arr_rules['frontend_input'] = "required";
            $arr_rules['frontend_label'] = "required";
            $arr_rules['frontend_label_de'] = "required";

            $arr_option_values = array();

            $from_data = $request->all();
            //dd($from_data);
            

            if (isset($from_data['is_fillterable']) && $from_data['is_fillterable']==1) 
            {
                $arr_rules['front_fitter_type'] = "required";    
            }


            $validator = Validator::make($request->all(),$arr_rules);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }



            if (isset($attribute_id) && $attribute_id!="") 
            {
                if (isset($from_data['sort_order']) && sizeof($from_data['sort_order']) > 0)
                {  
                    foreach ($from_data['sort_order'] as $key => $value) 
                    {
                        if ($from_data['value'][$key]!="" && $from_data['sort_order'][$key]!="" && $from_data['opt_value_id'][$key]!="") 
                        {
                            $arr_option_values[$key]['attribute_option_value_id'] = $from_data['opt_value_id'][$key];
                            $arr_option_values[$key]['attribute_id_fk'] = $attribute_id;
                            $arr_option_values[$key]['value'] = $from_data['value'][$key];
                            $arr_option_values[$key]['sort_order'] = $from_data['sort_order'][$key];
                            if ($key==$from_data['default_index']) 
                            {
                                $arr_option_values[$key]['is_default_selected'] = 1;
                            }
                            else
                            {
                                $arr_option_values[$key]['is_default_selected'] = 0;   
                            }
                        }
                    }
                   
                }

            }

            if (isset($arr_option_values) && sizeof($arr_option_values)>0) 
            {
               foreach ($arr_option_values as $key => $value) 
               {
                    if (isset($value['attribute_option_value_id']) && $value['attribute_option_value_id'] == 0) 
                    {
                        $create_status_value = $this->AttributeOptionValueModel->create($value);   
                    }
                    elseif (isset($value['attribute_option_value_id']) && $value['attribute_option_value_id'] > 0) 
                    {
                        $update_status_value = $this->AttributeOptionValueModel->where('attribute_option_value_id',$value['attribute_option_value_id'])->update($value);
                    }
                  
               }
            }


            if (isset($from_data) && sizeof($from_data) > 0) 
            {
                unset($from_data['_token']);
                unset($from_data['value']);
                unset($from_data['sort_order']);
                unset($from_data['is_default_selected']);
                unset($from_data['default_index']);
                unset($from_data['opt_value_id']);
                
                $from_data['attribute_code'] = str_slug($from_data['attribute_code'], "_");
                
                $status_attribute_update = $this->AttributeModel
                                                ->where('attribute_id', $attribute_id)
                                                ->update($from_data);
            }

            //dd($status_attribute_update);

            
            if($status_attribute_update)
            {   
                Session::flash('success','Attribute Updated Successfully');
            }
            else
            {
                Session::flash('error','Problem Occured While Updating Attribute ');
            }   

            return redirect()->back();

        }
     
    }


    public function delete_option_values($enc_id)
    {
        $opt_value_id = base64_decode($enc_id);
        if ($opt_value_id) 
        {
            $status_delete = $this->AttributeOptionValueModel->where('attribute_option_value_id',$opt_value_id)
                                                            ->delete();
        }

        if ($status_delete) 
        {
            $data['status'] = "success";
            $data['msg'] = "Option Value Deleted Successfully.";
            echo json_encode($data);
            exit();
        }
        else
        {
            $data['status'] = "error";
            $data['msg'] = "Error while deleting Option Value.";
            echo json_encode($data);
            exit();

        }
        

    }

    
}
