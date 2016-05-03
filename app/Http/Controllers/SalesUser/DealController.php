<?php

namespace App\Http\Controllers\SalesUser;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BusinessListingModel;
use App\Models\BusinessCategoryModel;
use App\Models\CategoryModel;
use App\Models\SalesDealModel;
use App\Models\TransactionModel;
use App\Models\MembershipModel;
use Validator;
use Session;
use Carbon\Carbon as Carbon;
class DealController extends Controller
{
    //
     public function __construct()
    {
    	$this->BusinessListingModel = new BusinessListingModel();
    	$this->DealModel=new SalesDealModel();
        $this->deal_public_img_path = url('/')."/uploads/deal/";
    	$this->deal_image_path = base_path().'/public/uploads/deal/';
    }
    public function index($enc_id)
    {
    	$page_title='Manage Deals';
    	$id=base64_decode($enc_id);
    	$arr_restaurant = array();
        $deal_public_img_path = $this->deal_public_img_path;
        $obj_tran_data=TransactionModel::where('business_id',$id)->first();
        $transaction_details=array();
        $arr_plan=array();
        $no_of_deals=$add_deal=0;
        if($obj_tran_data)
        {
            $transaction_details = $obj_tran_data->toArray();
        }
         if(sizeof($transaction_details)>0)
         {
           $expired_date = new Carbon($transaction_details['expire_date']);
            $now = Carbon::now();
            $difference = ($expired_date->diff($now)->days < 1)
                ? 'today'
                : $expired_date->diffForHumans($now);
            if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false) 
            {

               
                $plan_id=$transaction_details['membership_id'];
                if($plan_id==1)
                {
                    $no_of_deals="unlimited";
                }
                else
                {
                    $obj_plan=MembershipModel::where('plan_id',$plan_id)->first();
                    if($obj_plan)
                    {
                        $arr_plan=$obj_plan->toArray();
                        $no_of_deals=$arr_plan['no_normal_deals'];

                    }
                }
                 
                $obj_business = BusinessListingModel::where('id',$id)->first();
                if($obj_business)
                {
                    $arr_business = $obj_business->toArray();
                }
                $obj_deal = SalesDealModel::with('business_info')->where('business_id',$id)->get();
                if($obj_deal)
                {
                    $arr_deal = $obj_deal->toArray();
                    $total_deal_count=count($arr_deal);
                }
                if($no_of_deals=="unlimited")
                {
                    $add_deal=1;
                }
                else if($no_of_deals>$total_deal_count)
                {
                    $add_deal=1;
                }
                else
                {
                    $add_deal=0;
                }
            }
            else
            {
                $data_arr['is_active']=0;
                $this->DealModel->where('business_id',$id)->update($data_arr);
                $add_deal='expired';
             }
         }
        //dd($add_deal );
        return view('sales_user.deal.index',compact('page_title','arr_business','arr_deal','deal_public_img_path','add_deal','expired_date'));
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
         $obj_business_category = BusinessCategoryModel::where('business_id',$arr_business['id'])->get();
        if(sizeof($obj_business_category)>0)
        {
            $business_sub_category = $obj_business_category->toArray();
            if($business_sub_category)
            {
                $obj_sub_category = CategoryModel::where('cat_id',$business_sub_category[0]['category_id'])->get();
                if($obj_sub_category)
                {
                    $parent_category_id='';
                     $category = $obj_sub_category->toArray();
                     $parent_category_id=$category[0]['parent'];
                }
            }
        }
        $obj_tran_data=TransactionModel::where('business_id',$id)->first();
        $transaction_details=array();
        if($obj_tran_data)
        {
            $transaction_details = $obj_tran_data->toArray();
        }
         if(sizeof($transaction_details)>0)
         {
            $expired_date=$transaction_details['expire_date'];
         }
        //dd($expired_date);
    	return view('sales_user.deal.create',compact('page_title','arr_business','parent_category_id','expired_date'));
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
    	/*$arr_rule['start_time']='required';
    	$arr_rule['end_time']='required';*/
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
        $data_arr['parent_category_id']=$form_data['parent_category_id'];
    	$data_arr['name']=$form_data['name'];
    	$data_arr['price']=$form_data['price'];
    	$data_arr['deal_image']=$image_name ;
    	$data_arr['discount_price']=$form_data['discount_price'];
    	$data_arr['description']=$form_data['description'];
    	$data_arr['deal_type']=$form_data['deal_type'];
    	$data_arr['start_day']=date('Y-m-d',strtotime($form_data['start_day']));
    	$data_arr['end_day']=date('Y-m-d',strtotime($form_data['end_day']));
    	/*$data_arr['start_time']=$form_data['start_time'];
    	$data_arr['end_time']=$form_data['end_time'];*/
    	$data_arr['is_active']=$form_data['is_active'];
        $data_arr['public_id']=session('public_id');
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
        if(sizeof($deal_arr)>0)
        {
        $obj_tran_data=TransactionModel::where('business_id',$deal_arr['business_id'])->first();
        $transaction_details=array();
        if($obj_tran_data)
        {

            $transaction_details = $obj_tran_data->toArray();
        }
         if(sizeof($transaction_details)>0)
         {
            $expired_date=$transaction_details['expire_date'];
         }
        }
        else
        {
            $expired_date='';
        }
        return view('sales_user.deal.edit',compact('page_title','deal_arr','deal_public_img_path','expired_date'));
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
       /* $arr_rule['start_time']='required';
        $arr_rule['end_time']='required';*/
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
           /* $data_arr['start_time']=$form_data['start_time'];
            $data_arr['end_time']=$form_data['end_time'];*/
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
        return SalesDealModel::where('id',$id)->update(array('is_active'=>1));
    }

    protected function _block($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);
        return SalesDealModel::where('id',$id)->update(array('is_active'=>0));
    }

    protected function _delete($enc_id)////$enc_id = Deal id
    {
        $id = base64_decode($enc_id);

        $arr_deal = SalesDealModel::select('id','deal_image')->where('id',$id)->first()->toArray();

        $get_path = $this->deal_image_path.$arr_deal['deal_image'];

        $unlink_deal_image = FALSE;
        if(is_readable($get_path))
        {
            $unlink_deal_image = unlink($get_path);  //////////////////Unlink Deal image

            if($unlink_deal_image==TRUE)
            {
                return SalesDealModel::where('id',$id)->delete();//////////Soft Delete Deal
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
