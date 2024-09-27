<?php

namespace App\Http\Middleware;

use App\Models\SiteSettingModel;
use Closure;
use Illuminate\Http\Request;

class CheckForMaintenanceMode
{
    private $SiteSettingModel;

    public function __construct()
    {
        $this->SiteSettingModel = new SiteSettingModel;
    }

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $request->url();

        if (strpos($url, 'admin') === false) {
            $arr_data = $this->SiteSettingModel->first()->toArray();

            if (count($arr_data) > 0 && $arr_data['site_status'] == 0) {
                return response('Be right back , Currently website is in maintenance mode !', 503);
            }
        }

        return $next($request);
    }
}
