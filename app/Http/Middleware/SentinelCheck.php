<?php

namespace App\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\UserMembershipModel;
use App\Models\RestaurantModel;


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
        /*if(!Sentinel::check())
        {
            return redirect('/');
        }

        $user = Sentinel::check();

        if($user)
        {   
            $role = Sentinel::findRoleBySlug('restaurant_admin');
           
            if(Sentinel::inRole($role))
            {  
               
                $arr_condition           = array('user_id'=>$user->id,'is_active'=>'1');

                $user_restaurant_active  = RestaurantModel::where($arr_condition)->first();
                $user_membership_active  = UserMembershipModel::where($arr_condition)->first();

                if(!$user_restaurant_active)
                {
                    return redirect('/restaurant_admin/restaurants/create');
                }

                if(!$user_membership_active)
                {
                    return redirect('/restaurant_admin/restaurants/create');
                }

            }
           
        }
*/
        return $next($request);
    }
}
