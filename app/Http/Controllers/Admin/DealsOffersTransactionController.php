<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealsTransactionModel;
use Illuminate\Http\Request;
use Session;
use Validator;

class DealsOffersTransactionController extends Controller
{
    public function __construct()
    {
        $arr_except_auth_methods = [];
        $this->middleware(\App\Http\Middleware\SentinelCheck::class, ['except' => $arr_except_auth_methods]);
    }

    public function index()
    {
        $page_title = 'Deals & Offers Transaction :Manage';

        $arr_transaction = [];
        $obj_transaction = DealsTransactionModel::orderBy('id', 'DESC')->get();

        if ($obj_transaction) {
            $obj_transaction->load(['user_records', 'user_orders', 'order_deal.offers_info']);
            $arr_transaction = $obj_transaction->toArray();
        }

        // dd($arr_transaction);
        return view('web_admin.deals_offers_order_transaction.index', compact('page_title', 'arr_transaction'));
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title = 'Deals & Offers Transaction: View';

        $arr_single_transaction = [];
        $obj_single_transaction = DealsTransactionModel::where('id', $id)->first();

        if ($obj_single_transaction) {
            $obj_single_transaction->load(['user_records', 'user_orders', 'order_deal.offers_info']);
            $arr_single_transaction = $obj_single_transaction->toArray();
        }

        //dd($arr_single_transaction);
        return view('web_admin.deals_offers_order_transaction.view', compact('page_title', 'arr_single_transaction'));
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);

        $page_title = 'Deals & Offers Transaction: Edit';

        $arr_single_transaction = [];
        $obj_single_transaction = DealsTransactionModel::where('id', $id)->first();

        if ($obj_single_transaction) {
            $obj_single_transaction->load(['user_records', 'user_orders', 'order_deal.offers_info']);
            $arr_single_transaction = $obj_single_transaction->toArray();
        }

        //dd($arr_single_transaction);
        return view('web_admin.deals_offers_order_transaction.edit', compact('page_title', 'arr_single_transaction'));
    }

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules = [];
        $arr_rules['status'] = 'required';
        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $arr_data = [];
        $arr_data['transaction_status'] = $request->input('status');
        $transaction_status_update = DealsTransactionModel::where('id', $id)->update($arr_data);

        if ($transaction_status_update) {
            Session::flash('success', 'Transaction Updated Successfully');
        } else {
            Session::flash('error', 'Error While Updating Transaction details');
        }

        return redirect()->back();
    }

    public function export_excel($format = 'csv')//export excel file
    {
        if ($format == 'csv') {
            $arr_deal_transaction_list = [];
            $obj_deal_transaction__list = DealsTransactionModel::with(['user_records', 'user_orders', 'order_deal.offers_info'])->get();
            //dd($obj_business_list);

            if ($obj_deal_transaction__list) {
                $arr_deal_transaction_list = $obj_deal_transaction__list->toArray();

                \Excel::create('DEAL_TRANSACTION_LIST-'.date('Ymd').uniqid(), function ($excel) use ($arr_deal_transaction_list) {
                    $excel->sheet('Deal_Transaction_List', function ($sheet) use ($arr_deal_transaction_list) {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, [
                            'Sr.No.', 'Transaction ID', 'Transaction Status', 'User Name', 'Deal Name', 'Price', 'Start Date ', 'End Date',
                        ]);

                        if (count($arr_deal_transaction_list) > 0) {
                            $arr_tmp = [];
                            foreach ($arr_deal_transaction_list as $key => $deal_transaction_list) {
                                $arr_tmp[$key][] = $key + 1;
                                $arr_tmp[$key][] = $deal_transaction_list['transaction_id'];
                                $arr_tmp[$key][] = $deal_transaction_list['transaction_status'];
                                $arr_tmp[$key][] = $deal_transaction_list['user_records']['first_name'];

                                $arr_tmp[$key][] = $deal_transaction_list['order_deal']['title'];
                                $arr_tmp[$key][] = $deal_transaction_list['price'];
                                $arr_tmp[$key][] = date('d-m-Y', strtotime($deal_transaction_list['start_date']));
                                $arr_tmp[$key][] = date('d-m-Y', strtotime($deal_transaction_list['expire_date']));
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');
            }
        }
    }
}
