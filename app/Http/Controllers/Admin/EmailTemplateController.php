<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplateModel;
use Validator;
use Session;
class EmailTemplateController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index()
    {
    	 $page_title = "Manage Email Template";

        $arr_email_template = array();

        $obj_templates = EmailTemplateModel::get();

        if( $obj_templates != FALSE)
        {
            $arr_email_template = $obj_templates->toArray();
        }
        // dd($arr_tour_guides);

        return view('web_admin.email_template.index',compact('page_title','arr_email_template'));
    }

    public function create()
    {
    	$page_title = "Create Email Template";
        return view('web_admin.email_template.create',compact('page_title'));
    }

    public function store(Request $request)
    {
        $form_data = array();

        $form_data = $request->all();

        $arr_rules['template_name'] 	= "required";
        $arr_rules['template_subject'] 	= "required";
        $arr_rules['template_html'] 	= "required";
        $arr_rules['is_active'] 		= "required";
        $arr_rules['variables'] 		= "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             Session::flash('error','Please Fill All The Mandatory Fields');
             return redirect('/web_admin/email_template/create/')->withErrors($validator)->withInput();
        }
        $template_name  	= $form_data['template_name'];
        $template_subject  	= $form_data['template_subject'];
        $template_html  	= $form_data['template_html'];
        $is_active  		= $form_data['is_active'];
        $variables 			= $form_data['variables'];

        $arr_varaible = array();
        foreach ($variables as  $key => $value)
        {
        	$arr_varaible[$key] = "##".$value."##";

        }
        $string_varaibles = implode("~", $arr_varaible);

        $array_create = array(
        						'template_name' 		=> $template_name,
        						'template_subject' 		=> $template_subject,
        						'template_html' 		=> $template_html,
        						'is_active' 			=> $is_active,
        						'template_variables' 	=> $string_varaibles,
        						'template_from_mail' 	=> 'admin@kacamarin.com',
        						'template_from'			=> 'ADMIN'
        		);

        $email_template = EmailTemplateModel::create($array_create);
        if($email_template)
        {
        	Session::flash('success','Email Template Created Successfully');
 		}
 		else
 		{
 			Session::flash('error','Problem Occured, While Creating Email Template ');
 		}

       return redirect('/web_admin/email_template/create');
    }

    public function edit($email_template_id)
    {
        $id    = base64_decode($email_template_id);

        $page_title = "Edit Email Template";

        $arr_email_template =  array();
        $obj_email_template = EmailTemplateModel::where('id', $id)->first();
        if($obj_email_template)
        {
        	$arr_email_template = $obj_email_template->toArray();
        }

		if($arr_email_template)
      	{
            return view('web_admin.email_template.edit',compact('page_title','email_template_id','arr_email_template'));
        }
        else
        {
            return redirect('/web_admin/email_template/');
        }

        return view('web_admin.email_template.edit',compact('page_title','email_template_id','arr_email_template'));
    }

    public function update(Request $request, $email_template_id)
    {
    	$id = base64_decode($email_template_id);

        $form_data = array();

        $form_data = $request->all();

        $arr_rules['template_name'] 	= "required";
        $arr_rules['template_subject'] 	= "required";
        $arr_rules['template_html'] 	= "required";
        $arr_rules['is_active'] 		= "required";
        $arr_rules['template_from_mail']= "required";
        $arr_rules['template_from'] 	= "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             Session::flash('error','Please Fill All The Fields');
             return redirect('/web_admin/email_template/edit/'.base64_encode($email_template_id))->withErrors($validator)->withInput();
        }
        $template_name  	= $form_data['template_name'];
        $template_from_mail = $form_data['template_from_mail'];
        $template_from  	= $form_data['template_from'];
        $template_subject  	= $form_data['template_subject'];
        $template_html  	= $form_data['template_html'];
        $is_active  		= $form_data['is_active'];

        $array_update = array(
        						'template_name' 	=> $template_name,
        						'template_from_mail'=> $template_from_mail,
        						'template_from' 	=> $template_from,
								'template_subject' 	=> $template_subject,
        						'template_html' 	=> $template_html,
         						'is_active' 		=> $is_active,
        		);

        $email_template = EmailTemplateModel::where('id',$id);
        if($email_template)
        {
        	$status = $email_template->update($array_update);
	        if($status)
	        {
	        	Session::flash('success','Email Template Updated Successfully');
	 		}
	 		else
	 		{
	 			Session::flash('error','Problem Occured, While Updating Email Template ');
	 		}
            return redirect('/web_admin/email_template/');
        }
        else
        {
        	Session::flash('error','Problem Occured, While Updating Email Template ');
        }

        return redirect('/web_admin/email_template/edit/'.base64_encode($email_template_id));
    }


}
