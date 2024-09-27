<?php

namespace App\Http\Middleware;

use App\Models\UserModel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
//use App\Models\UserMembershipModel;
use Closure;

class SentinelCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Sentinel::check();

        if ($user) {
            $role = Sentinel::findRoleBySlug('sales');

            if (Sentinel::inRole($role)) {

                $arr_condition = ['id' => $user->id, 'is_active' => '1'];

                $sale_user_active = UserModel::where($arr_condition)->first();
                //$user_membership_active  = UserMembershipModel::where($arr_condition)->first();

                if (! $sale_user_active) {
                    return redirect('/sales_user/');
                }

            }

        } else {
            return redirect('/');

        }

        return $next($request);
    }
}
