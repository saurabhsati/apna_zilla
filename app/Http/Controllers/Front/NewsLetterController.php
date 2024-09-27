<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\NewsLetterModel;
use Illuminate\Http\Request;
use Session;

class NewsLetterController extends Controller
{
    private $NewsLetterModel;

    public function __construct() {}

    public function index(Request $request)
    {
        $email = $request->input('email');
        if (NewsLetterModel::where('email_address', $email)->get()->count() > 0) {
            echo 'exist';
            //Session::flash('error','Your Are Already Subscribe For This Email ID');
            //return redirect()->back();
        } else {
            $status = NewsLetterModel::create(['email_address' => $email, 'is_active' => 1]);
            if ($status) {
                echo 'success';
                //Session::flash('success','News Letter Subscribed Successfully');
            } else {
                echo 'fail';
                //Session::flash('error','Problem Occurred While Subscribing');
            }

        }
        exit;
    }
}
