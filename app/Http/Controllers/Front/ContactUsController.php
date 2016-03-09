<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function index()
    {
    	$page_title='Contact Us';
    	return view('front.contact_us',compact('page_title'));
    }
}
