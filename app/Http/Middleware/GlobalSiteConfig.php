<?php

namespace App\Http\Middleware;
use  App\Models\SiteSettingModel;
use App\Models\CityModel;
use App\Models\StaticPageModel;
use Closure;

class GlobalSiteConfig
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

        /* Site Settings Contact info*/
        $arr_site_settings = SiteSettingModel::first()->toArray();
        view()->share('site_settings', $arr_site_settings);
          /* Popular city info*/
         $obj_popular_cities = CityModel::where('is_popular','1')->take(6)->get();
          if( $obj_popular_cities != FALSE)
        {
            $arr_cities = $obj_popular_cities->toArray();
        }
        view()->share('popular_cities', $arr_cities);
        $data_page='';
        $obj_static_page=StaticPageModel::where('page_slug','about-us')->first();
        if($obj_static_page)
        {
            $data_page=$obj_static_page->toArray();
        }
          view()->share('about_us', $data_page);
        return $next($request);
    }
}
