<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\NewsLetterModel;
use App\Models\SiteSettingModel;
use App\Models\EmailTemplateModel;
use Validator;
use Session;
use Input; 
use Mail;
 
class NewsLetterController extends Controller
{

    /*
    | Constructor : creates instances of model class 
    |               & handles the admin authantication
    | auther : Danish 
    | Date : 12/12/2015
    | @return \Illuminate\Http\Response
    */

    private $NewsLetterModel; 
    
    public function __construct()
    {

    }

     /*
    | Index : Display listing of NewsLetter
    | auther : Danish 
    | Date : 24/02/2016
    | @return \Illuminate\Http\Response
    */ 
 
    public function index()
    {
        $page_title = "Manage NewsLetter"; 
        $arr_data = array();  
        $res = NewsLetterModel::all();

        if($res != FALSE)
        {
            $arr_data = $res->toArray();
        }
       
        return view('web_admin.news_letter.index',compact('page_title','arr_data'));
    }

}