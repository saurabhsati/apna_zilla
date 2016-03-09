<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function index()
    {
    	return view('front.contact_us');
    }
}
