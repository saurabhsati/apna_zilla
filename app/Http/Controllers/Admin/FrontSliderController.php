<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FrontSliderModel;
use Validator;
use Session;
class FrontSliderController extends Controller
{
    //
    public function __construct()
    {
    	$this->slider_public_img_path = url('/')."/uploads/slider/";
        $this->slider_base_img_path = base_path()."/public/uploads/slider/";

        $this->slider                   = new FrontSliderModel;
    }
    public function index()
    {
    	$page_title	=	'Manage Front Slider';
    	$arr_slider = array();

        $obj_slider_res = $this->slider->get();

        if( $obj_slider_res != FALSE)
        {
            $arr_slider = $obj_slider_res->toArray();
        }

        // dd($arr_slider);
        $slider_public_img_path = $this->slider_public_img_path;

    	return view('web_admin.front_slider.index',compact('page_title','arr_slider','slider_public_img_path'));
    }
    public function create()
    {
    	$page_title	=	"Create ";
    	return view('web_admin.front_slider.create',compact('page_title'));
    }
    public function store(Request $request)
    {
    	$sort_order = $this->get_max_order();
    	$form_data = array();

        $arr_rules['title'] = "required";
        $arr_rules['link'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error','Please Fill All required Fields.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = $request->all();
        $arr_data['title']       	= $form_data['title'];
        $arr_data['link']       	= $form_data['link'];

        /*---------- File uploading code starts here ------------*/

        $form_data = $request->all();
         $fileName = "";
         $file_url = "";

	     if ($request->hasFile('image'))
	     {
            $file_name = $form_data['image'];
            $fileExtension = strtolower($request->file('image')->getClientOriginalExtension());

            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                // echo "hello";exit;
                $fileName = sha1(uniqid().$file_name.uniqid()).'.'.$fileExtension;
                $request->file('image')->move($this->slider_base_img_path, $fileName);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }

        $arr_data['image'] = $fileName;
        $arr_data['order_index'] = intval($sort_order)+1;
        $slider       = $this->slider->create($arr_data);
        if($slider)
         {
            Session::flash('success','Slider Information Created Successfully');
         }
         else
         {
            Session::flash('error','Problem Occured, While Storing Slider Information ');
         }
        return redirect('/web_admin/front_slider/create');
    }
    public function get_max_order()
    {
    	$get_existing_order = $this->slider
    	  								->select('order_index')
    	  								->get()
    	  								->toArray();


    	  $array_order = array();
    	  $max_order = 0;
    	  if(isset($get_existing_order) && count($get_existing_order) >0)
    	  {
        	  	foreach ($get_existing_order as $order)
        	  	{
        	  		if(intval($order['order_index']) > $max_order)
        	  		{
        	  			$max_order  = intval($order['order_index']);

        	  		}

        	  	}
    	  }
    	  return $max_order;
    }
    public function show($enc_id)
    {
    	$id = base64_decode($enc_id);
    	$slider_public_img_path=$this->slider_public_img_path;
    	$arr_slider=	array();
    	$obj_slider_data	=	$this->slider->where('id',$id)->first();
    	if($obj_slider_data)
    	{
    		$arr_slider=$obj_slider_data->toArray();
    	}

    	return view('web_admin.front_slider.show',compact('page_title','arr_slider','slider_public_img_path'));
    }
    public function edit($enc_id)
    {
    	$page_title ="Edit";
    	$id = base64_decode($enc_id);
    	$slider_public_img_path=$this->slider_public_img_path;
    	$obj_front_arr=$this->slider->where('id',$id)->first();
    	if($obj_front_arr)
    	{
    		$data_slider	= $obj_front_arr->toArray();
    	}
    	/*echo"<pre>";
    	print_r($data_slider);exit;*/
    	return view('web_admin.front_slider.edit',compact('page_title','data_slider','slider_public_img_path'));
    }
    public function update(Request $request ,$enc_id)
    {
    	$id	=base64_decode($enc_id);
    	$form_data = array();

        $arr_rules['title'] = "required";
        $arr_rules['link'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error','Invalid input');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = $request->all();
        $arr_data['title']       	= $form_data['title'];
        $arr_data['link']       	= $form_data['link'];

        /*---------- File uploading code starts here ------------*/

        $fileName = "";
        $file_url = "";
         if ($request->hasFile('image'))
	     {
            $file_name = $form_data['image'];
            $fileExtension = strtolower($request->file('image')->getClientOriginalExtension());

            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                 $fileName = sha1(uniqid().$file_name.uniqid()).'.'.$fileExtension;
                $request->file('image')->move($this->slider_base_img_path, $fileName);
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }

            $file_url = $fileName;
        }
        else
        {
        	 $slider       = $this->slider->where('id',$id)->first();
        	 $data_fetch=$slider->toArray();
        	 $fileName=$data_fetch['image'];

        }
        $arr_data['image'] = $fileName;
        $slider       = $this->slider->where('id',$id)->update($arr_data);
        if($slider)
        {
        	Session::flash('success','Slider Information Updated Successfully');
        }
        else
        {
        	Session::flash('error','Problem Occurred, While Updating Slider Information ');
        }
         return redirect('/web_admin/front_slider/edit/'.$enc_id);
    }
     public function save_order($slider_id, $order_index)
    {
    	$get_existing_order = $this->slider->where('id','<>',$slider_id)->select('order_index')->get()->toArray();
    	// dd($get_existing_order);
    	/*Check if order index in a number */
    	$check_number = is_numeric($order_index);
    	if(!$check_number)
    	{
    		$data['status'] = "NUMERIC";
    		$data['msg'] = "Please Do Not Enter Characters";
    		echo json_encode($data);
    		exit;
    	}

    	/* Check if orderindex is not duplicate */
    	$flag = 0;
    	foreach ($get_existing_order as $order)
    	{
    		if($order['order_index'] == $order_index )
    		{
    			$flag++;
    		}
    	}
    	if($flag > 0)
    	{
    		$data['status'] = "DUPLICATE";
    		$data['msg'] = "Please Do Not Enter Duplicate Order";
    		echo json_encode($data);
    		exit;
    	}

    	$slider = $this->slider->where('id',$slider_id);
    	$arr_update = array('order_index'=> $order_index);


    	$status = $slider->update($arr_update);
    	if($status)
    	{
    		$data['status'] = "SUCCESS";
    		$data['msg'] = "Order Stored Successfully";
    		echo json_encode($data);
    		exit;
    	}
    	else
    	{
    		$data['status'] = "ERROR";
    		$data['msg'] = "Error While Changing The Order";
    		echo json_encode($data);
    		exit;
    	}
    }
     public function delete($slider_id)
    {
        if($this->_delete($slider_id))
        {
            Session::flash('success','Slider Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Deleting Slider');
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
            Session::flash('error','Problem Occurred, While Doing Multi Action');
            return redirect()->back();

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
                $this->_delete($record_id);

                Session::flash('success','Slider(s) Deleted Successfully');
            }
        }

        return redirect()->back();
    }


    protected function _delete($slider_id)
    {
        $id = base64_decode($slider_id);

        $pre_slider_image_record = $this->slider->where('id',$id)->get()->toArray();

        if(!empty($pre_slider_image_record) && count($pre_slider_image_record) > 0)
        {
            foreach ($pre_slider_image_record as $arr_slider)
            {
                if($arr_slider['image'] !="")
                {
                     $unlink_path    = $this->slider_base_img_path.$arr_slider['image'];
                     $unlink_image   = unlink($unlink_path);
                }
            }
        }

        $slider = FrontSliderModel::where('id',$id)->first();

        return $slider->delete();
    }
}
