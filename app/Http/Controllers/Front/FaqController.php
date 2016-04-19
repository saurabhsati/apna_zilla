<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use Validator;
use Session;
class FaqController extends Controller
{
	 public function __construct()
    {

    }
	public function index()
    {
    	$page_title	="FAQ";
    	$obj_faq_pages = FaqModel::where('is_active',1)->where('parent',0)->get();
    	if($obj_faq_pages)
    	{
    		$faq_pages=$obj_faq_pages->toArray();
    	}
       // $sub_pages = FaqModel::where('parent','!=',0)->get()->toArray();
        //print_r($sub_pages);
       //dd($faq_pages);
        return view('front.faq',compact('page_title','faq_pages'));
    }
}
