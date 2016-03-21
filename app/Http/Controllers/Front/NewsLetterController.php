<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\NewsLetterModel;

use Session;

 
class NewsLetterController extends Controller
{

	private $NewsLetterModel; 
    
    public function __construct()
    {

    }

    public function index(Request $request)
    {
    	$email = $request->input('email');

        if(NewsLetterModel::where('email_address',$email)->get()->count()>0)
        {
            Session::flash('error','Record with this Email Already Exists');
            return redirect()->back();
        }
       
        $status = NewsLetterModel::create(['email_address'=>$email,
        									'is_active' => 1
        								  ]);             
	      
	    
	     

	        if($status)
	        {
	            Session::flash('success','News Letter Subscribed Successfully');
	        }   
	        else
	        {
	            Session::flash('error','Problem Occured While Subscribing');
	        }   

        	return redirect()->back(); 
    }
	
}
