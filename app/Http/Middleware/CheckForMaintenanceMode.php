<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Models\SiteSettingModel;
use Closure;

class CheckForMaintenanceMode 
{
    private $SiteSettingModel;

    public function __construct()
    {
        $this->SiteSettingModel = new  SiteSettingModel(); 
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $request->url();
        
        if(strpos($url, 'admin')===FALSE)
        {
            $arr_data = $this->SiteSettingModel->first()->toArray();

            if (sizeof($arr_data)>0 && $arr_data['site_status']==0) 
            {
               return response('Be right back , Currently website is in maintenance mode !', 503); 
            }
        }

        return $next($request);
    }
}