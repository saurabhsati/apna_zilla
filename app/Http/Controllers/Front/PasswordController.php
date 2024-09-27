<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetModel;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct() {}

    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        $password_reset = PasswordResetModel::where('token', $token)->first();
        if ($password_reset != null) {
            return view('front.password.reset_password')->with('token', $token)->with('password_reset', (array) $password_reset);
        } else {
            return redirect('/');
        }
    }

    /**
     * Reset the given user's password.
     *
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
