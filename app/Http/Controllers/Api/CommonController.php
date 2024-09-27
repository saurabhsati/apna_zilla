<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\CityModel;
use App\Models\PlaceModel;
use App\Models\StateModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function __construct()
    {
        $json = [];
    }

    /* Get state by city (India 1) */
    public function get_states_by_country(Request $request)
    {
        $country_id = $request->input('country_id');
        $arr_state = [];
        $json = [];

        $obj_states = StateModel::select('id', 'state_title', 'country_id')
            ->where('country_id', $country_id)
            ->orderBy('state_title', 'ASC')->get();

        if ($obj_states != false) {
            $arr_state = $obj_states->toArray();
        }
        if (count($arr_state) > 0) {
            $json['status'] = 'SUCCESS';
            $json['data'] = $arr_state;
            $json['message'] = 'Information Get Successfully.';
        } else {
            $json['status'] = 'ERROR';
            $json['data'] = [];
            $json['message'] = 'No Records Found !.';
        }

        return response()->json($json);
    }

    /* Get city by state (Maharastra  21) */
    public function get_cities_by_state(Request $request)
    {
        $state_id = $request->input('state_id');
        $arr_state = [];
        $json = [];

        $obj_cities = CityModel::select('id', 'city_title', 'state_id')
            ->where('state_id', $state_id)
            ->orderBy('city_title', 'ASC')->get();

        if ($obj_cities != false) {
            $arr_citiy = $obj_cities->toArray();
        }

        if (count($arr_citiy) > 0) {
            $json['status'] = 'SUCCESS';
            $json['data'] = $arr_citiy;
            $json['message'] = 'Information Get Successfully.';
        } else {
            $json['status'] = 'ERROR';
            $json['data'] = [];
            $json['message'] = 'No Records Found !.';
        }

        return response()->json($json);
    }

    /* Get pincode by city (Nashik  411) */

    public function get_postalcode_by_city(Request $request)
    {
        $city_id = $request->input('city_id');
        $arr_state = [];

        $obj_postalcode = PlaceModel::select('id', 'postal_code', 'city_id')
            ->where('city_id', $city_id)
            ->orderBy('postal_code', 'ASC')
            ->groupBy('postal_code')
            ->get();

        if ($obj_postalcode != false) {
            $arr_postalcode = $obj_postalcode->toArray();
        }

        if (count($arr_postalcode) > 0) {
            $json['status'] = 'SUCCESS';
            $json['data'] = $arr_postalcode;
            $json['message'] = 'Information Get Successfully.';
        } else {
            $json['status'] = 'ERROR';
            $json['data'] = [];
            $json['message'] = 'No Records Found !.';
        }

        return response()->json($json);
    }

    /* Get Sub Category By Main Category*/
    public function get_sub_category_by_main(Request $request)
    {
        $id = $request->input('main_cat_id');
        $obj_category = CategoryModel::where('parent', $id)->get();

        $arr_category = [];
        $json = [];

        if ($obj_category && count($obj_category) > 0) {
            $arr_category = $obj_category->toArray();

            $json['status'] = 'SUCCESS';
            $json['data'] = $arr_category;
            $json['message'] = 'Information Get Successfully.';

        } else {
            $json['status'] = 'ERROR';
            $json['data'] = [];
            $json['message'] = 'No Records Found !.';
        }

        return response()->json($json);
    }

    public function get_main_category(Request $request)
    {
        $obj_category = CategoryModel::where('parent', '0')->get();

        $arr_category = [];
        $json = $data = [];

        if ($obj_category && count($obj_category) > 0) {
            $arr_category = $obj_category->toArray();
            $json['status'] = 'SUCCESS';
            $json['data'] = $arr_category;
            $json['message'] = 'Information Get Successfully.';

        } else {
            $json['status'] = 'ERROR';
            $json['data'] = [];
            $json['message'] = 'No Records Found !.';
        }

        return response()->json($json);
    }

    public function get_users_by_sales_executive(Request $request)
    {
        $sales_user_public_id = $request->input('sales_user_public_id');
        $obj_user = UserModel::where('sales_user_public_id', $sales_user_public_id)->get();

        $arr_user = [];
        $json = $data = [];

        if ($obj_user) {
            $arr_user = $obj_user->toArray();
        }

        if (isset($arr_user) && count($arr_user) > 0) {
            foreach ($arr_user as $key => $user) {
                $data[$key]['id'] = $user['id'];
                $data[$key]['public_id'] = $user['public_id'];
                $data[$key]['first_name'] = $user['first_name'];
            }
        }
        if ($data) {
            $json['data'] = $data;
            $json['status'] = 'SUCCESS';
            $json['message'] = 'User List ! .';
        } else {
            $json['status'] = 'ERROR';
            $json['message'] = 'Error Occure while Listing User';
        }

        return response()->json($json);
    }
}
