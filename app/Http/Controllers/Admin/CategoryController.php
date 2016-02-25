<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Session;
use Validator;
use DB;
use App\Http\Controllers\Common\GeneratorController;

class CategoryController extends Controller
{
 	public function __construct()
 	{
 		$arr_except_auth_methods = array();
 		$this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
        $this->cat_img_path = base_path().'/public/'.config('app.project.img_path.category');
        $this->cat_img_public_path = url('/').config('app.project.img_path.category');

 	}   

 	public function index()
 	{
 		$page_title = "Category: Manage ";

 		$arr_category = array();
 		$obj_category = CategoryModel::where('parent','0')->get();

 		if($obj_category)
 		{
 			$arr_category = $obj_category->toArray();
 		}

 		return view('web_admin.category.index',compact('page_title','arr_category'));
 	}	

 	public function create(Request $request,$enc_cat_id=FALSE)
 	{
 		$page_title = "Create Category";

        $arr_category = array();
        $obj_category = CategoryModel::where('parent',0)->get();

        if($obj_category!=FALSE)
        {
        foreach ($obj_category as $key => $category) 
        {
            $arr_category = $obj_category->toArray();
        }

        }
        return view('web_admin.category.create',compact('page_title','arr_category','enc_cat_id'));
    }


 	public function store(Request $request)
    {
        $arr_rules = array();
        $arr_rules['category'] = "required";
        $arr_rules['title'] = "required";
        $arr_rules['cat_meta_keyword'] = "required";
        $arr_rules['cat_meta_description'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails()==TRUE)
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $category = $request->input('category');
        $title = $request->input('title');
        $is_priceable = $request->input('is_priceable','0');
        $cat_meta_keyword = $request->input('cat_meta_keyword');
        $cat_meta_description = $request->input('cat_meta_description');

        $cat_slug = str_slug($title);
        
         /* update public key in Category table*/
        $cat_id=CategoryModel::first()->cat_id;           
        $public_id = (new GeneratorController)->alphaID($cat_id);  

        $cat_img = "default_category.png";
        if((int)$category==0)
        {
            if ($request->hasFile('cat_img')) 
            {
                $cv_valiator = Validator::make(array('cat_img'=>$request->file('cat_img')),array(
                                                    'cat_img' => 'mimes:jpg,jpeg,png'
                                                )); 

                if ($request->file('cat_img')->isValid() && $cv_valiator->passes())
                {

                    $cv_path = $request->file('cat_img')->getClientOriginalName();
                    $image_extension = $request->file('cat_img')->getClientOriginalExtension();
                    $image_name = sha1(uniqid().$cv_path.uniqid()).'.'.$image_extension;
                    $request->file('cat_img')->move(
                    $this->cat_img_path, $image_name
                    );
                  
                    $cat_img = $image_name;     
                }
                else
                {
                    return redirect()->back();
                }

            }
        }   


        $arr_cat = array();
        $arr_cat['public_id']=$public_id;
        $arr_cat['cat_desc'] = "NA";
        $arr_cat['cat_slug'] = $cat_slug;
        $arr_cat['parent'] = $category;
        $arr_cat['cat_order'] = "0";
        $arr_cat['is_active'] = "1";
        $arr_cat['is_priceable'] = $is_priceable;
        $arr_cat['cat_img'] = $cat_img;
        $arr_cat['cat_thumb'] =$cat_img;

        $arr_cat['cat_meta_keyword'] =$cat_meta_keyword;
        $arr_cat['cat_meta_description'] =$cat_meta_description;
        
        $status=CategoryModel::create($arr_cat);
        $status->save();
        /* Insert in Category Lang */

        if($status)
        {
            Session::flash('success','Category Added Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured, While Adding Category');
        }
    
        return redirect()->back();
    }

    

 	public function edit($enc_id)
 	{
 		$id = base64_decode($enc_id);
 		$page_title = "Category: Edit ";

 		$arr_data = array();
 		$obj_data = CategoryModel::where('cat_id',$id)->first();

 		if($obj_data)
 		{
 			$arr_data = $obj_data->toArray();
 		}

 		return view('web_admin.category.edit',compact('page_title','arr_data'));
 	}

 	public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_rules = array();
        $arr_rules['category'] = "required";
        $arr_rules['is_active'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data = $request->only(['category','is_active']);

        /* Duplication Check*/

        if(CategoryModel::where('category',$arr_data['category'])->where('id','<>',$id)->get()->count()>0)
        {
            Session::flash('error','Category Already Exists');
            return redirect()->back();
        }

        $status = CategoryModel::where('id',$id)->update($arr_data);

        if($status)
        {   
            Session::flash('success','Category Updated Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Updating Category ');
        }   

        return redirect()->back();
    }

     public function show_sub_categories($enc_id)
    {
        $parent_cat_id = base64_decode($enc_id);
        $page_title = "Manage Category/Sub Category";

        /* Get Current Category Name */

        $obj_main_category = CategoryModel::where('cat_id',$parent_cat_id)->first();

        if($obj_main_category!=FALSE)
        {
            $arr_main_category = $obj_main_category->toArray();
        }


        /* Fetch Complete List*/
        $arr_sub_category = array();
        $arr_category = array();

        $obj_category = CategoryModel::where('parent',$parent_cat_id)->get();

        if($obj_category!=FALSE)
        {
            foreach ($obj_category as $key => $category) 
            {
               $category->child_category;
            }
            $arr_sub_category = $obj_category->toArray();
        }

        /* Get All Parent Category */
        $obj_category = CategoryModel::where('parent',0)->get();

        if($obj_category!=FALSE)
        {
          $arr_category = $obj_category->toArray();
        }    

        return view('web_admin.category.show_sub_categories',compact('page_title','arr_sub_category','arr_category','enc_id'));
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
               Session::flash('success','Category(s) Activated Successfully'); 
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);    
               Session::flash('success','Category(s) Blocked Successfully');   
            }
            elseif($multi_action=="delete")
            {
               $this->_delete($record_id);    
               Session::flash('success','Category(s) Deleted Successfully');  
            }
             
        }

        return redirect()->back();
    }

    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {   
            $this->_activate($enc_id);

            Session::flash('success','Category(s) Activated Successfully');                 
        }
        elseif($action=="block")
        {
            $this->_block($enc_id); 

            Session::flash('success','Category(s) Blocked Successfully');                
        }
        return redirect()->back();
    }

    public function delete($enc_id)
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','Category(s) Deleted Successfully');                   
        }
        else
        {
            Session::flash('error','Problem Occured While Deleting Category(s)');                      
        }
        return redirect()->back();
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        return CategoryModel::where('cat_id',$id)->update(array('is_active'=>1));    
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        return CategoryModel::where('cat_id',$id)->update(array('is_active'=>0));    
    }

    protected function _delete($enc_id)
    {
    	$id = base64_decode($enc_id);
		return CategoryModel::where('cat_id',$id)->delete();  
    }

      public function __update_unique_category_id($id)
    {
        if(!$id) return FALSE;
        return CategoryModel::where('cat_id',$id)->update(array('public_id'=>alpha_id($id)));
    }

}
