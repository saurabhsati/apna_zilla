<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\DealModel;
use Validator;
use Session;
class DealController extends Controller
{
    //
    public function __construct()
    {
    	$this->BusinessListingModel = new BusinessListingModel();
    	$this->DealModel=new DealModel();
        $this->deal_public_img_path = url('/')."/uploads/deal/";
    	$this->deal_image_path = base_path().'/public/uploads/deal/';
    }
    public function index($enc_id)
    {
    	$page_title='Manage Deals';
    	$id=base64_decode($enc_id);
    	$arr_restaurant = array();
        $deal_public_img_path = $this->deal_public_img_path;
        $obj_business = $this->BusinessListingModel->where('id',$id)->first();

        if($obj_business)
        {
            $arr_business = $obj_business->toArray();
        }
        $obj_deal=$this->DealModel->with('business_info')->where('business_id',$id)->get();
        if($obj_deal)
        {
            $arr_deal = $obj_deal->toArray();
        }
    	return view('web_admin.deal.index',compact('page_title','arr_business','arr_deal','deal_public_img_path'));
    }
    public function create($enc_id)
    {
    	$page_title=' Create Deal';
    	$id=base64_decode($enc_id);
    	$obj_business = $this->BusinessListingModel->where('id',$id)->first();

        if($obj_business)
        {
            $arr_business = $obj_business->toArray();
        }
       // dd($arr_business);
    	return view('web_admin.deal.create',compact('page_title','arr_business'));
    }
    public function store(Request $request)
    {
    	$arr_rule	= array();
    	$arr_rule['name']='required';
    	$arr_rule['price']='required';
    	$arr_rule['discount_price']='required';
    	$arr_rule['description']='required';
    	$arr_rule['deal_image']='required';
    	$arr_rule['deal_type']='required';
    	$arr_rule['start_day']='required';
    	$arr_rule['end_day']='required';
    	$arr_rule['start_time']='required';
    	$arr_rule['end_time']='required';
    	$arr_rule['is_active']='required';

    	$validator=Validator::make($request->all(),$arr_rule);
    	if($validator->fails())
    	{
    		return redirect()->back()->withErrors($validator)->withInput();
    	}
    	if($request->hasFile('deal_image'))///image loaded/Not
	    	{
	    		$arr_image				 =	array();
	    		$arr_image['deal_image'] = $request->file('deal_image');
	    		$arr_image['deal_image'] = 'mimes:jpg,jpeg,png';;

	    		$image_validate = Validator::make(array('deal_image'=>$request->file('deal_image')),
	    										  array('deal_image'=>'mimes:jpg,jpeg,png'));


	    		if($request->file('deal_image')->isValid() && $image_validate->passes())
	    		{
	    			$image_path 		=	$request->file('deal_image')->getClientOriginalName();
	    			$image_extention	=	$request->file('deal_image')->getClientOriginalExtension();
	    			$image_name			=	sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

	    			$final_image = $request->file('deal_image')->move($this->deal_image_path, $image_name);

	    		}
	    		else
	    		{
	    			return redirect()->back();
	    		}
	    	}
	    	else
	    	{
	    		return redirect()->back();
	    	}
    	$form_data	= $request->all();
    	$data_arr['business_id']=$form_data['business_hide_id'];
    	$data_arr['name']=$form_data['name'];
    	$data_arr['price']=$form_data['price'];
    	$data_arr['deal_image']=$image_name ;
    	$data_arr['discount_price']=$form_data['discount_price'];
    	$data_arr['description']=$form_data['description'];
    	$data_arr['deal_type']=$form_data['deal_type'];
    	$data_arr['start_day']=date('Y-m-d',strtotime($form_data['start_day']));
    	$data_arr['end_day']=date('Y-m-d',strtotime($form_data['end_day']));
    	$data_arr['start_time']=$form_data['start_time'];
    	$data_arr['end_time']=$form_data['end_time'];
    	$data_arr['is_active']=$form_data['is_active'];
    	$deal_add = $this->DealModel->create($data_arr);
    	if($deal_add)
    	{
			Session::flash('success','Deal Created Successfully');
		}
		else
		{
		 	Session::flash('error','Problem Occurred While Creating Deal');
		}
		return redirect()->back();
    }
    public function edit($enc_id)
    {
        $page_title='Edit Deal';
        $deal_public_img_path = $this->deal_public_img_path;
        $id=base64_decode($enc_id);
        $obj_deal_arr=$this->DealModel->with('business_info')->where('id',$id)->first();
         if($obj_deal_arr)
        {
            $deal_arr = $obj_deal_arr->toArray();
        }
        return view('web_admin.deal.edit',compact('page_title','deal_arr','deal_public_img_path'));
    }
    public function update(Request $request,$enc_id)
    {
        $id=    base64_decode($enc_id);
        $arr_rule   = array();
        $arr_rule['name']='required';
        $arr_rule['price']='required';
        $arr_rule['discount_price']='required';
        $arr_rule['description']='required';
        $arr_rule['deal_type']='required';
        $arr_rule['start_day']='required';
        $arr_rule['end_day']='required';
        $arr_rule['start_time']='required';
        $arr_rule['end_time']='required';
        $arr_rule['is_active']='required';

        $validator=Validator::make($request->all(),$arr_rule);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data  = $request->all();
        $image_name=$form_data['old_image'];
        if($request->hasFile('deal_image'))///image loaded/Not
        {
                $arr_image               =  array();
                $arr_image['deal_image'] = $request->file('deal_image');
                $arr_image['deal_image'] = 'mimes:jpg,jpeg,png';;

                $image_validate = Validator::make(array('deal_image'=>$request->file('deal_image')),
                                                  array('deal_image'=>'mimes:jpg,jpeg,png'));


                if($request->file('deal_image')->isValid() && $image_validate->passes())
                {
                    $image_path         =   $request->file('deal_image')->getClientOriginalName();
                    $image_extention    =   $request->file('deal_image')->getClientOriginalExtension();
                    $image_name         =   sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

                    $final_image = $request->file('deal_image')->move($this->deal_image_path, $image_name);

                     $get_path = $this->deal_image_path.$form_data['old_image'];

                        $unlink_deal_image = FALSE;
                        if(is_readable($get_path))
                        {
                            $unlink_deal_image = unlink($get_path);

                        }
               }
                else
                {
                    return redirect()->back();
                }
            }


            $data_arr['name']=$form_data['name'];
            $data_arr['price']=$form_data['price'];
            $data_arr['deal_image']=$image_name ;
            $data_arr['discount_price']=$form_data['discount_price'];
            $data_arr['description']=$form_data['description'];
            $data_arr['deal_type']=$form_data['deal_type'];
            $data_arr['start_day']=date('Y-m-d',strtotime($form_data['start_day']));
            $data_arr['end_day']=date('Y-m-d',strtotime($form_data['end_day']));
            $data_arr['start_time']=$form_data['start_time'];
            $data_arr['end_time']=$form_data['end_time'];
            $data_arr['is_active']=$form_data['is_active'];
            $deal_update = $this->DealModel->where('id',$id)->update($data_arr);
            if($deal_update)
            {
                Session::flash('success','Deal Updated Successfully');
            }
            else
            {
                Session::flash('error','Problem Occurred While Updating Deal');
            }
            return redirect()->back();
    }
    public function toggle_status($enc_id,$action)////$enc_id = Deal id
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','Deal(s) Activated Successfully');
        }
        elseif($action=="block")
        {
            $this->_block($enc_id);

            Session::flash('success','Deal(s) Blocked Successfully');
        }
        elseif($action=="delete")
        {
            $this->_delete($enc_id);

            Session::flash('success','Deal(s) Deleted Successfully');
        }

        return redirect()->back();
    }

    public function delete($enc_id)////$enc_id = Deal id
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','Deal(s) Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occurred While Deleting Deal(s)');
        }
        return redirect()->back();
    }

    protected function _activate($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);
        return DealModel::where('id',$id)->update(array('is_active'=>1));
    }

    protected function _block($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);
        return DealModel::where('id',$id)->update(array('is_active'=>0));
    }

    protected function _delete($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

        $arr_deal = DealModel::select('id','deal_image')->where('id',$id)->first()->toArray();

        $get_path = $this->deal_image_path.$arr_deal['deal_image'];

        $unlink_deal_image = FALSE;
        if(is_readable($get_path))
        {
            $unlink_deal_image = unlink($get_path);  //////////////////Unlink Deal image

            if($unlink_deal_image==TRUE)
            {
                return DealModel::where('id',$id)->delete();//////////Soft Delete Deal
            }
        }

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
               Session::flash('success','Deal(s) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','Deal(s) Blocked Successfully');
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','Deal(s) Deleted Successfully');
            }

        }

        return redirect()->back();
    }
}
