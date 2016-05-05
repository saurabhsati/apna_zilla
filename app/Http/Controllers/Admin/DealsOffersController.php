<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealsOffersModel;
use App\Models\CategoryModel;
use App\Models\BusinessListingModel;
use App\Models\DealsSliderImagesModel   ;
use Validator;
use Session;

class DealsOffersController extends Controller
{
	public function __construct()
	{
		 $this->deal_public_img_path = url('/')."/uploads/deal/";
    	 $this->deal_image_path = base_path().'/public/uploads/deal/';

         $this->deal_public_upload_img_path = url('/')."/uploads/deal/deal_slider_images/";
          $this->deal_base_upload_img_path = base_path()."/public/uploads/deal/deal_slider_images/";
    }

   
    public function index($status="all")
    {
    	$deal_public_img_path='';
    	$deal_public_img_path = $this->deal_public_img_path;
    	$obj_deal= $arr_deal=[];
    	if($status== 'all')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->orderBy('created_at','DESC')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	else if($status== 'active')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->where('end_day', '>=', date('Y-m-d').' 00:00:00')->orderBy('created_at','DESC')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	else if($status== 'expired')
    	{
    		$obj_deal=DealsOffersModel::with('business_info')->where('end_day', '<', date('Y-m-d').' 00:00:00')->orderBy('created_at','DESC')->get();
            if($obj_deal)
             {
                $arr_deal = $obj_deal->toArray();
             }
    	}
    	return view('web_admin.deals_offers.index',compact('page_title','arr_deal','deal_public_img_path'));

    }
    public function create()
    {
    	$page_title="Create Deals";
    	$obj_main_category = CategoryModel::where('parent','0')->where('is_allow_to_add_deal',1)->get();
    	if($obj_main_category)
        {
            $arr_main_category = $obj_main_category->toArray();
        }
       
       
         return view('web_admin.deals_offers.create',compact('page_title','arr_main_category'));
    }

    public function get_business_by_user($user_id)
    {
    	 $obj_business_listing = BusinessListingModel::where('user_id',$user_id)->with(['membership_plan_details'])->orderBy('created_at','DESC')->get();
        if($obj_business_listing)
        {
            $all_business_listing = $obj_business_listing->toArray();
        }
        $business_ids=[];
        foreach ($all_business_listing as $key => $business) {
        	if(sizeof($business['membership_plan_details'])>0)
        	{
        		foreach ($business['membership_plan_details'] as $key => $membership_data) {
        			if($membership_data['expire_date'] >=date('Y-m-d').' 00:00:00')
        			{
        				if(!array_key_exists($membership_data['business_id'],$business_ids))
        				{
        				  $business_ids[$membership_data['business_id']]=$membership_data['business_id'];
        			    }
        			}
        		}
        		
        	}
        	
        }
         $obj_business_listing = BusinessListingModel::with(['membership_plan_details'])->whereIn('id',$business_ids)->orderBy('created_at','DESC')->get();
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }
         if(sizeof($business_listing)>0)
        {
            $arr_response['status'] ="SUCCESS";
            $arr_response['business_listing'] = $business_listing;
           

        }
        else
        {
            $arr_response['status'] ="ERROR";
            $arr_response['business_listing'] = array();
            
        }
        return response()->json($arr_response);
    }

    public function store(Request $request)
    {
    	$arr_rule	= array();
    	$arr_rule['business']          = 'required';
    	$arr_rule['deal_main_image']   = 'required';
    	$arr_rule['title']             = 'required';
    	$arr_rule['name']              = 'required';
    	$arr_rule['price']             = 'required';
    	$arr_rule['discount_price']    = 'required';
    	$arr_rule['deal_type']         = 'required';
    	$arr_rule['start_day']         = 'required';
    	$arr_rule['end_day']           = 'required';
    	$arr_rule['description']       = 'required';
    	$arr_rule['things_to_remember']= 'required';
        $arr_rule['how_to_use']        = 'required';
    	$arr_rule['about']             = 'required';
    	$arr_rule['facilities']        = 'required';
    	$arr_rule['cancellation_policy']= 'required';
    	$arr_rule['is_active']          = 'required';

    	$validator=Validator::make($request->all(),$arr_rule);
    	if($validator->fails())
    	{
             print_r($validator->errors()->all());exit;
           
    		//return redirect()->back()->withErrors($validator)->withInput();
    	}

    	if($request->hasFile('deal_main_image'))///image loaded/Not
	    	{
	    		$arr_image				 =	array();
	    		$arr_image['deal_main_image'] = $request->file('deal_main_image');
	    		$arr_image['deal_main_image'] = 'mimes:jpg,jpeg,png';;

	    		$image_validate = Validator::make(array('deal_main_image'=>$request->file('deal_main_image')),
	    										  array('deal_main_image'=>'mimes:jpg,jpeg,png'));


	    		if($request->file('deal_main_image')->isValid() && $image_validate->passes())
	    		{
	    			$image_path 		=	$request->file('deal_main_image')->getClientOriginalName();
	    			$image_extention	=	$request->file('deal_main_image')->getClientOriginalExtension();
	    			$image_name			=	sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

	    			$final_image = $request->file('deal_main_image')->move($this->deal_image_path, $image_name);

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
	     //dd($form_data);
         $data_arr['business_id']           = $request->input('business');
         $data_arr['title']                 = $request->input('title');
         $data_arr['name']                  = $request->input('name');
         $data_arr['price']                 = $request->input('price');
         $data_arr['discount_price']        = $request->input('discount_price');
         $data_arr['deal_type']             = $request->input('deal_type');
         $data_arr['deal_image']            = $image_name ;
         $data_arr['start_day']             = date('Y-m-d',strtotime($request->input('start_day')));
         $data_arr['end_day']               = date('Y-m-d',strtotime($request->input('end_day')));
         $data_arr['description']           = $request->input('description');
         $data_arr['things_to_remember']    = $request->input('things_to_remember');
         $data_arr['how_to_use']            = $request->input('how_to_use');
         $data_arr['facilities']            = $request->input('facilities');
         $data_arr['about']                 = $request->input('about');
         $data_arr['cancellation_policy']   = $request->input('cancellation_policy');
         $data_arr['is_active']             = $request->input('is_active');
        // dd($data_arr);
         $deal_add = DealsOffersModel::create($data_arr);
            $deal_id=$deal_add->id;

          $files = $request->file('deal_image');
         $file_count = count($files);
         $uploadcount = 0;
         foreach($files as $file) {
         $destinationPath = $this->deal_base_upload_img_path;
         $fileName = $file->getClientOriginalName();
            $fileExtension  = strtolower($file->getClientOriginalExtension());
            if(in_array($fileExtension,['png','jpg','jpeg']))
            {
                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                  $file->move($destinationPath,$filename);
                  $arr_insert['image_name']=$filename;
                  $arr_insert['deal_id']=$deal_id;
                  $insert_data1=DealsSliderImagesModel::create($arr_insert);
                  $uploadcount ++;
            }
            else
            {
                 Session::flash('error','Invalid file extension');
            }
        }
          if($deal_add)
            {
                Session::flash('success','Deal Created successfully');
            }
            else
            {
                Session::flash('error','Error Occurred While Creating Deal ');
            }

            return redirect()->back();



    }
    public function edit($enc_id)
    {
        $page_title='Edit Deal';
        $deal_base_upload_img_path='';

        $deal_base_upload_img_path =$this->deal_public_upload_img_path ;
        $deal_public_img_path =$this->deal_public_img_path;

        $id=base64_decode($enc_id);
        $obj_deal_arr=DealsOffersModel::with(['business_info','deals_slider_images'])->where('id',$id)->first();
         if($obj_deal_arr)
        {
            $deal_arr = $obj_deal_arr->toArray();
        }
        
        return view('web_admin.deals_offers.edit',compact('page_title','deal_arr','deal_public_img_path','deal_base_upload_img_path'));
    }

    public function update(Request $request,$enc_id)
    {
        //  dd($request->all());
        $id=    base64_decode($enc_id);

        $arr_rule['title']             = 'required';
        $arr_rule['name']              = 'required';
        $arr_rule['price']             = 'required';
        $arr_rule['discount_price']    = 'required';
        $arr_rule['deal_type']         = 'required';
        $arr_rule['start_day']         = 'required';
        $arr_rule['end_day']           = 'required';
        $arr_rule['description']       = 'required';
        $arr_rule['things_to_remember']= 'required';
        $arr_rule['how_to_use']        = 'required';
        $arr_rule['about']             = 'required';
        $arr_rule['facilities']        = 'required';
        $arr_rule['cancellation_policy']= 'required';
        $arr_rule['is_active']          = 'required';

        $validator=Validator::make($request->all(),$arr_rule);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $form_data  = $request->all();
        $image_name=$form_data['old_image'];
        if($request->hasFile('deal_main_image'))///image loaded/Not
        {
                $arr_image               =  array();
                $arr_image['deal_main_image'] = $request->file('deal_main_image');
                $arr_image['deal_main_image'] = 'mimes:jpg,jpeg,png';;

                $image_validate = Validator::make(array('deal_main_image'=>$request->file('deal_main_image')),
                                                  array('deal_main_image'=>'mimes:jpg,jpeg,png'));


                if($request->file('deal_main_image')->isValid() && $image_validate->passes())
                {
                    $image_path         =   $request->file('deal_main_image')->getClientOriginalName();
                    $image_extention    =   $request->file('deal_main_image')->getClientOriginalExtension();
                    $image_name         =   sha1(uniqid().$image_path.uniqid()).'.'.$image_extention;

                    $final_image = $request->file('deal_main_image')->move($this->deal_image_path, $image_name);

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
         $data_arr['title']                 = $request->input('title');
         $data_arr['name']                  = $request->input('name');
         $data_arr['price']                 = $request->input('price');
         $data_arr['discount_price']        = $request->input('discount_price');
         $data_arr['deal_type']             = $request->input('deal_type');
         $data_arr['deal_image']            = $image_name ;
         $data_arr['start_day']             = date('Y-m-d',strtotime($request->input('start_day')));
         $data_arr['end_day']               = date('Y-m-d',strtotime($request->input('end_day')));
         $data_arr['description']           = $request->input('description');
         $data_arr['things_to_remember']    = $request->input('things_to_remember');
         $data_arr['how_to_use']            = $request->input('how_to_use');
         $data_arr['facilities']            = $request->input('facilities');
         $data_arr['about']                 = $request->input('about');
         $data_arr['cancellation_policy']   = $request->input('cancellation_policy');
         $data_arr['is_active']             = $request->input('is_active');
         $deal_update = DealsOffersModel::where('id',$id)->update($data_arr);


         $files = $request->file('deal_image');

         $file_count = count($files);
         if($file_count>0)
         {
            $uploadcount = 0;
            foreach($files as $file) 
            {
                     if($file!=null)
                     {
                         $destinationPath = $this->deal_base_upload_img_path;
                         $fileName = $file->getClientOriginalName();
                            $fileExtension  = strtolower($file->getClientOriginalExtension());

                            if(in_array($fileExtension,['png','jpg','jpeg']))
                            {
                                  $filename =sha1(uniqid().$fileName.uniqid()).'.'.$fileExtension;
                                  $file->move($destinationPath,$filename);
                                  $arr_insert['image_name']=$filename;
                                  $arr_insert['deal_id']=$id;
                                  $insert_data1=DealsSliderImagesModel::create($arr_insert);
                                  $uploadcount ++;
                            }
                            else
                            {
                                 Session::flash('error','Invalid file extension');
                            }
                     }
            }
         }
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
     public function delete_gallery(Request $request)
    {
        $deal_base_upload_img_path =$this->deal_base_upload_img_path;
        $image_name=$request->input('image_name');
        $id=$request->input('id');
        $Business = DealsSliderImagesModel::where('id',$id);
        $res= $Business->delete();
        if($res)
        {
             $deal_base_upload_img_path.$image_name;
           if(unlink($deal_base_upload_img_path.$image_name))
           {
            echo "done";
           }
        }

    }

}
