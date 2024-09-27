<?php

namespace App\Http\Middleware;

use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\SiteSettingModel;
use App\Models\StaticPageModel;
use Closure;

class GlobalSiteConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /* Site Settings Contact info*/
        view()->share('site_settings', $this->site_settings());
        /* Popular city info*/

        view()->share('popular_cities', $this->get_popular_cities());

        view()->share('about_us', $this->get_about_us_content());

        view()->share('deal_category', $this->all_deal_category());
        view()->share('allow_deal_sub_category', $this->all_deal_sub_category());

        return $next($request);
    }

    public function get_popular_cities()
    {
        $arr_cities = [];
        $obj_popular_cities = CityModel::where('is_active', '1')->where('is_popular', '1')->take(6)->get();
        if ($obj_popular_cities != false) {
            $arr_cities = $obj_popular_cities->toArray();
        }

        return $arr_cities;
    }

    public function site_settings()
    {
        $arr_cities = [];
        $arr_site_settings = SiteSettingModel::first();
        if ($arr_site_settings != false) {
            $site_settings = $arr_site_settings->toArray();
        }

        return $site_settings;
    }

    public function get_about_us_content()
    {
        $arr_content = [];
        $obj_static_page = StaticPageModel::where('is_active', '1')->where('page_slug', 'about-us')->first();
        if ($obj_static_page) {
            $arr_content = $obj_static_page->toArray();
        }

        return $arr_content;
    }

    public function all_deal_category()
    {
        $deal_category = [];
        $obj_allow_deal_category = CategoryModel::where('is_active', '1')->where('is_allow_to_add_deal', 1)->get();
        if ($obj_allow_deal_category) {
            $deal_category = $obj_allow_deal_category->toArray();

            return $deal_category;
            //dd($deal_category);
        }
    }

    public function all_deal_sub_category()
    {
        $deal_category = $allow_deal_sub_category = [];

        $obj_allow_deal_category = CategoryModel::where('is_active', '1')->where('is_allow_to_add_deal', 1)->get();
        if ($obj_allow_deal_category) {
            $deal_category = $obj_allow_deal_category->toArray();
            $key_deal_main_cat = [];
            if (count($deal_category) > 0) {
                foreach ($deal_category as $key => $value) {
                    $key_deal_main_cat[$value['cat_id']] = $value['cat_id'];
                }
            }
            if (count($key_deal_main_cat) > 0) {
                $obj_allow_deal_sub_category = CategoryModel::whereIn('parent', $key_deal_main_cat)->get();
                if ($obj_allow_deal_sub_category) {
                    $allow_deal_sub_category = $obj_allow_deal_sub_category->toArray();
                }
            }
        }

        return $allow_deal_sub_category;
    }
}
