<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlaceModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Paginate;
use Session;
use Validator;

class PlaceController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {

        $page_title = 'Manage Places';

        $obj_places_res = PlaceModel::with(['country_details', 'state_details', 'city_details']);

        $arr_paginated_places = [];
        $perPage = 5000;
        $curPage = $request->input('page', '1'); // reads the query string, defaults to 1

        // clone the query to make 100% sure we don't have any overwriting
        $itemQuery = clone $obj_places_res;
        $all_records = clone $obj_places_res;
        // this does the sql limit/offset needed to get the correct subset of items
        $items = $itemQuery->forPage($curPage, $perPage)->get();

        // manually run a query to select the total item count
        // use addSelect instead of select to append
        $totalResult = $obj_places_res->addSelect(DB::raw('count(*) as record_count'))->get();

        $totalItems = 1;
        if (isset($totalResult[0])) {
            $totalItems = $totalResult[0]->record_count;
        }

        // make the paginator, which is the same as returned from paginate()
        // all() will return an array of models from the collection.

        $this->Paginator = new Paginator($items->all(), $perPage, $curPage);
        $arr_paginated_places = $this->Paginator->toArray();

        $arr_paginated_places['total'] = $totalItems;
        $arr_paginated_places['last_page'] = (int) ceil($totalItems / $perPage);

        //dd($arr_paginated_places);
        return view('web_admin.places.index', compact('page_title', 'arr_paginated_places'));
    }

    public function show($enc_id)
    {
        $page_title = 'Show Place';
        $id = base64_decode($enc_id);
        $arr_places = [];
        $obj_places_res = PlaceModel::where('id', $id)->with(['country_details', 'state_details', 'city_details'])->get();

        if ($obj_places_res != false) {
            $arr_places = $obj_places_res->toArray();
        }

        return view('web_admin.places.show', compact('page_title', 'arr_places'));
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_place = [];

        $page_title = 'Edit Place';

        $obj_places_res = PlaceModel::where('id', $id)->with(['country_details', 'state_details', 'city_details'])->get();

        if ($obj_places_res != false) {
            $arr_place = $obj_places_res->toArray();
        }

        return view('web_admin.places.edit', compact('page_title', 'arr_place'));
    }

    public function update($enc_id, Request $request)
    {
        $id = base64_decode($enc_id);
        $arr_rules = [];
        $arr_rules['place_name'] = 'required';
        $arr_rules['postal_code'] = 'required';
        $arr_rules['latitude'] = 'required';
        $arr_rules['longitude'] = 'required';
        // $arr_rules['is_popular'] = "required";

        echo $check_popular = $request->input('is_popular');

        if ($check_popular == 'on') {
            $is_popular = 1;
        } else {
            $is_popular = 0;
        }

        $validator = Validator::make($request->all(), $arr_rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = [];
        $form_data = $request->all();

        $arr_data['place_name'] = $form_data['place_name'];
        $arr_data['postal_code'] = $form_data['postal_code'];
        $arr_data['latitude'] = $form_data['latitude'];
        $arr_data['longitude'] = $form_data['longitude'];

        //dd($arr_data);

        if (PlaceModel::where('id', $id)->update($arr_data)) {
            Session::flash('success', 'Place Updated Successfully');
        } else {
            Session::flash('error', 'Problem Occurred, While Updating Place');
        }

        return redirect('/web_admin/places/edit/'.$enc_id);
    }

    public function toggle_status($enc_id, $action)
    {
        if ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'Place/Places Activated Successfully');
        } elseif ($action == 'deactivate') {
            $this->_block($enc_id);

            Session::flash('success', 'Place/Places Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/places');
    }

    public function delete($enc_id)
    {
        if ($this->_delete($enc_id)) {
            Session::flash('success', 'Place/Places Deleted Successfully');
        } else {
            Session::flash('error', 'Problem Occurred While Deleting Place/Places');
        }

        return redirect()->back();
    }

    public function multi_action(Request $request)
    {
        $arr_rules = [];
        $arr_rules['multi_action'] = 'required';
        $arr_rules['checked_record'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect('/web_admin/places')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if (is_array($checked_record) && count($checked_record) <= 0) {
            Session::flash('error', 'Problem Occured, While Doing Multi Action');

            return redirect('/web_admin/places');

        }

        foreach ($checked_record as $key => $record_id) {
            if ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'Places Deleted Successfully');
            } elseif ($multi_action == 'activate') {
                $this->_activate($record_id);
                Session::flash('success', 'Places Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'Places Blocked Successfully');
            }
        }

        return redirect('/web_admin/places');
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        return PlaceModel::where('id', $id)
            ->update(['is_active' => '1']);
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        return PlaceModel::where('id', $id)
            ->update(['is_active' => '0']);
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        return PlaceModel::where('id', $id)->delete();
    }

    public function export_excel($format = 'csv')//export excel file
    {
        ini_set('max_execution_time', 9000000);

        if ($format == 'csv') {
            $arr_place = [];
            $obj_place = PlaceModel::with(['country_details', 'state_details', 'city_details'])->get();
            //dd($obj_place->toArray());
            if ($obj_place) {
                $arr_place = $obj_place->toArray();

                \Excel::create('PLACE-'.date('Ymd').uniqid(), function ($excel) use ($arr_place) {
                    $excel->sheet('Place', function ($sheet) use ($arr_place) {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, [
                            'Sr.No.', 'Place', 'City::State/Region :: Country', 'Postal Code',
                        ]);

                        if (count($arr_place) > 0) {
                            $arr_tmp = [];
                            foreach ($arr_place as $key => $place) {
                                $arr_tmp[$key][] = $key + 1;
                                $arr_tmp[$key][] = $place['place_name'];
                                $arr_tmp[$key][] = $place['city_details']['city_title'].'::'.$place['state_details']['state_title'].'::'.$place['country_details']['country_name'];
                                $arr_tmp[$key][] = $place['postal_code'];
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }
}
