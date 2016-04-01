<?php

namespace App\Http\Middleware;
use  App\Models\SiteSettingModel;
use App\Models\CityModel;
use App\Models\StaticPageModel;
use App\Models\CategoryModel;
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

        $deal_category='';
        $obj_allow_deal_category = CategoryModel::where('is_allow_to_add_deal',1)->get();
        if($obj_allow_deal_category)
        {
            $deal_category = $obj_allow_deal_category->toArray();
        }
         view()->share('deal_category', $deal_category);
        return $next($request);
    }
}
