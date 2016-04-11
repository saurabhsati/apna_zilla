<?php

namespace App\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
//use App\Models\UserMembershipModel;
use App\Models\UserModel;


class SentinelCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Sentinel::check();

        if($user)
        {
            $role = Sentinel::findRoleBySlug('sales');

            if(Sentinel::inRole($role))
            {

                $arr_condition           = array('id'=>$user->id,'is_active'=>'1');

                $sale_user_active  = UserModel::where($arr_condition)->first();
                //$user_membership_active  = UserMembershipModel::where($arr_condition)->first();

                if(!$sale_user_active)
                {
                    return redirect('/sales_user/');
                }

            }

        }

        return $next($request);
    }
}
