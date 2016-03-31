<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\PlaceModel;

use Validator;
use Session;
use DB;
use Meta;
use Input;
use Redirect;
use Paginate;

class PlaceController extends Controller
{
   public function __construct()
    {

    }
    public function index(Request $request)
    {

    	$page_title	=	"Manage Places";


    	$obj_places_res = PlaceModel::with(['country_details','state_details','city_details']);

    	$arr_paginated_places = array();
        $perPage = 5000;
        $curPage = $request->input('page','1'); // reads the query string, defaults to 1

        // clone the query to make 100% sure we don't have any overwriting
        $itemQuery = clone $obj_places_res;
        $all_records = clone $obj_places_res;
        // this does the sql limit/offset needed to get the correct subset of items
        $items = $itemQuery->forPage($curPage, $perPage)->get();

        // manually run a query to select the total item count
        // use addSelect instead of select to append
        $totalResult = $obj_places_res->addSelect(DB::raw('count(*) as record_count'))->get();

        $totalItems = 1;
        if(isset($totalResult[0]))
        {
          $totalItems = $totalResult[0]->record_count;
        }

        // make the paginator, which is the same as returned from paginate()
        // all() will return an array of models from the collection.

        $this->Paginator = new Paginator($items->all(),$perPage, $curPage);
        $arr_paginated_places =  $this->Paginator->toArray();

        $arr_paginated_places['total'] =  $totalItems;
        $arr_paginated_places['last_page'] =  (int)ceil($totalItems/$perPage);

        //dd($arr_paginated_places);
    	return view('web_admin.places.index',compact('page_title','arr_paginated_places'));
    }

     public function show($enc_id)
    {
        $page_title =   "Show city";
        $id = base64_decode($enc_id);
        $arr_places = array();
        $obj_places_res = PlaceModel::where('id',$id)->with(['country_details','state_details','city_details'])->get();

        if( $obj_places_res != FALSE)
        {
            $arr_places = $obj_places_res->toArray();
        }

      return view('web_admin.places.show',compact('page_title','arr_cities'));
    }
    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_city = array();

        $page_title = "Edit City";

        $obj_cities_res = PlaceModel::where('id',$id)->with(['country_details','state_details','city_details'])->get();

        if( $obj_cities_res != FALSE)
        {
            $arr_city = $obj_cities_res->toArray();
        }

        return view('web_admin.places.edit',compact('page_title','arr_city'));
    }

    public function toggle_status($enc_id,$action)
    {
        if($action=="activate")
        {
            $this->_activate($enc_id);

            Session::flash('success','City/Cities Activated Successfully');
        }
        elseif($action=="deactivate")
        {
            $this->_block($enc_id);

            Session::flash('success','City/Cities Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/cities');
    }
    public function delete($enc_id)
    {
        if($this->_delete($enc_id))
        {
            Session::flash('success','City/Cities Deleted Successfully');
        }
        else
        {
            Session::flash('error','Problem Occured While Deleting City/Cities');
        }
        return redirect()->back();
    }
     public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect('/web_admin/cities')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
            return redirect('/web_admin/cities');

        }

        foreach ($checked_record as $key => $record_id)
        {
            if($multi_action=="delete")
            {
               $this->_delete($record_id);
                Session::flash('success','City(ies) Deleted Successfully');
            }
            elseif($multi_action=="activate")
            {
               $this->_activate($record_id);
               Session::flash('success','City(ies) Activated Successfully');
            }
            elseif($multi_action=="block")
            {
               $this->_block($record_id);
               Session::flash('success','City(ies) Blocked Successfully');
            }
        }

        return redirect('/web_admin/cities');
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        return PlaceModel::where('id',$id)
                  ->update(['is_active'=>'1']);
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        return PlaceModel::where('id',$id)
                  ->update(['is_active'=>'0']);
    }
    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);
        return PlaceModel::where('id',$id)->delete();
    }

}
