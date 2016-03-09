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
        $page_title ='Listing';
    	return view('front.listing.index',compact('page_title'));
    }
    public function list_details()
    {
        $page_title ='List Details';
    	return view('front.listing.detail',compact('page_title'));
    }
}
