<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
    	return view('front.listing.index');
    }
    public function list_details()
    {
    	return view('front.listing.detail');
    }
}
