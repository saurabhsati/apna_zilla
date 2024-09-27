<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyInBulkModel;
use Illuminate\Http\Request;

class BuyInBulkRequestController extends Controller
{
    public function index()
    {
        $page_title = 'Buy In Bulk Request :Manage';

        $arr_request = [];
        $obj_request = BuyInBulkModel::orderBy('id', 'DESC')->get();

        if ($obj_request) {
            $obj_request->load(['order_deal']);
            $arr_request = $obj_request->toArray();
        }

        // dd($arr_request);
        return view('web_admin.deals_bulk_order_request.index', compact('page_title', 'arr_request'));
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title = 'Buy In Bulk: View';

        $arr_single_request = [];
        $obj_single_request = BuyInBulkModel::where('id', $id)->first();

        if ($obj_single_request) {
            $obj_single_request->load(['order_deal']);
            $arr_single_request = $obj_single_request->toArray();
        }

        //dd($arr_single_request);
        return view('web_admin.deals_bulk_order_request.view', compact('page_title', 'arr_single_request'));
    }

    public function export_excel($format = 'csv')//export excel file
    {
        if ($format == 'csv') {
            $arr_order_request_list = [];
            $obj_deal_transaction__list = BuyInBulkModel::with(['order_deal'])->get();
            //dd($obj_business_list);

            if ($obj_deal_transaction__list) {
                $arr_order_request_list = $obj_deal_transaction__list->toArray();

                \Excel::create('BULK_ORDER_LIST-'.date('Ymd').uniqid(), function ($excel) use ($arr_order_request_list) {
                    $excel->sheet('Bulk_Order_List', function ($sheet) use ($arr_order_request_list) {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, [
                            'Sr.No.', 'User Name', 'Deal Name', 'Email', 'Phone Number', 'Quantity', 'Created Date ',
                        ]);

                        if (count($arr_order_request_list) > 0) {
                            $arr_tmp = [];
                            foreach ($arr_order_request_list as $key => $list) {
                                $arr_tmp[$key][] = $key + 1;
                                $arr_tmp[$key][] = $list['name'];
                                $arr_tmp[$key][] = $list['order_deal']['title'];
                                $arr_tmp[$key][] = $list['email'];
                                $arr_tmp[$key][] = $list['phone_no'];
                                $arr_tmp[$key][] = $list['quantity'];
                                $arr_tmp[$key][] = date('d-m-Y', strtotime($list['created_at']));

                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }
}
