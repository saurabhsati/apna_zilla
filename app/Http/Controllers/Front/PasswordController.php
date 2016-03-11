<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;

use Session;
use Sentinel;
use Validator;
use DB;

class UserController extends Controller
{
 	public function __construct()
 	{

 		// $arr_except_auth_methods = array();
 		// $this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
 	}
	public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        $password_reset = PasswordResetModel::where('token',$token)->first();
        if($password_reset != NULL)
        {
            return view('front.reset_password')->with('token', $token)->with('password_reset',(array)$password_reset);   
        }
        else
        {
            return redirect('/');
        }
    }

      /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });
        switch ($response) {
            case Password::PASSWORD_RESET:
                 return redirect('/')->with('status', trans($response));
            default:
                return redirect()->back()
                            ->withInput($request->only('email'))
                            ->withErrors(['email' => trans($response)]);
        }
    }

 	 
 }