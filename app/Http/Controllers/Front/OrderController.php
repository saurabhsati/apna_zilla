<?php

namespace App\Http\Controllers\Front;

use App\Common\Services\PayUMoneyService;
use App\Common\Services\PayUPaymentService;
use App\Http\Controllers\Controller;
use App\Models\CouponModel;
use App\Models\DealsOffersModel;
use App\Models\DealsTransactionModel;
use App\Models\EmailTemplateModel;
use App\Models\UsersOrderModel;
use Illuminate\Http\Request;
use Mail;
use Session;
use URL;

class OrderController extends Controller
{
    private $payu;

    public function __construct()
    {
        $this->payu = new PayUPaymentService('eCwWELxi');

    }

    public function index($offers, $enc_id)
    {
        $id = base64_decode($enc_id);
        /*  if(!(Session::has('user_id')))
             {
                return redirect('/');
             }*/
        $page_title = 'Order Detail';
        /* Offers Ids & Quantity */
        $complite_arr = [];
        $explode_offers = explode('-', $offers);
        if (count($explode_offers) > 0) {
            foreach ($explode_offers as $value) {
                $complite_arr[] = explode('_', $value);
            }
        }

        $obj_deal_arr = DealsOffersModel::with(['offers_info', 'deals_slider_images'])->where('id', $id)->first();
        if ($obj_deal_arr) {
            $deal_arr = $obj_deal_arr->toArray();
        }
        $deal_image_path = 'uploads/deal';
        $total = 0;
        if (count($complite_arr) > 0 && isset($complite_arr)) {
            foreach ($complite_arr as $key => $selected_offer) {
                foreach ($deal_arr['offers_info'] as $deal_offer) {
                    if ($selected_offer[0] == $deal_offer['id']) {
                        $total = $total + $deal_offer['discounted_price'] * $selected_offer[1];
                    }
                }
            }
        }

        // dd(Session::all());exit;
        if (Session::has('promo_used')) {
            $coupon_type = Session::get('coupon_type');
            $apply_discount = Session::get('apply_discount');

            if ($coupon_type == 'PERCENT') {
                $discounted_amount = ($total) - ($total * ($apply_discount / 100));
            } elseif ($coupon_type == 'AMT') {

                $discounted_amount = $total - $apply_discount;
            }
            Session::put('total_deal_price', $discounted_amount);

        } else {
            //echo ">>";exit;
            Session::put('total_deal_price', $total);
        }

        Session::put('select_deal_id', $id);

        return view('front.order.order_detail', compact('page_title', 'deal_arr', 'deal_image_path', 'complite_arr'));
    }

    public function payment(Request $request)
    {
        if (! (Session::has('user_id'))) {
            return redirect('/');
        }
        $page_title = 'Payment';
        $surl = url('/').'/order/success';
        $furl = url('/').'/order/fail';
        $curl = url('/').'/order/cancel';

        $price = $request->input('amount');
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $phone = $request->input('phone');
        $deal_info = $request->input('deal_info');
        $deal_id = $request->input('deal_id');
        $paymentMode = $request->input('selector');
        $offer_ids = $request->input('offer_ids');
        $offer_quantitys = $request->input('offer_quantitys');

        $validity = 30;
        $txnid = uniqid('RTN_');
        $order_id = uniqid('RTN_ORD_');

        $arr_data['user_id'] = $user_id;
        $arr_data['transaction_id'] = $txnid;
        $arr_data['order_id'] = $order_id;
        $arr_data['deal_id'] = $deal_id;
        $arr_data['price'] = $price;
        $arr_data['transaction_status'] = 'Pending';
        $arr_data['mode'] = $paymentMode;
        $arr_data['start_date'] = date('Y-m-d');
        $arr_data['expire_date'] = date('Y-m-d', strtotime('+'.$validity.'days'));

        $obj_deal = DealsOffersModel::where('id', $deal_id)->first();
        if ($obj_deal) {
            $arr_single_deal = $obj_deal->toArray();
        }
        $last_redeem_count = $arr_single_deal['redeem_count'];
        $data_arr['redeem_count'] = $last_redeem_count + 1;
        // dd($arr_single_deal);
        $deal_update = DealsOffersModel::where('id', $deal_id)->update($data_arr);
        //dd($arr_data);
        $dealtransaction = DealsTransactionModel::create($arr_data);

        foreach ($offer_ids as $key => $value) {
            $arr_order_data['offer_id'] = $value;
            $arr_order_data['deal_id'] = $deal_id;
            $arr_order_data['order_id'] = $order_id;

            $arr_order_data['order_quantity'] = $offer_quantitys[$value];
            $insert_data = UsersOrderModel::create($arr_order_data);

        }

        $parameter_post = [
            'key' => 'gtKFFx',
            'txnid' => $txnid,
            'amount' => $price,
            'firstname' => $user_name,
            'phone' => $phone,
            'productinfo' => 'Deals Order',
            'surl' => $surl,
            'furl' => $furl,
        ];
        $salt = 'eCwWELxi';
        $run = $this->pay_page($parameter_post, $salt);

        return redirect($run);
    }

    public function payment_success()
    {
        if (! (Session::has('user_id'))) {
            return redirect('/');
        }
        $arr_data['mihpayid'] = $_POST['mihpayid'];
        $arr_data['mode'] = $_POST['mode'];
        $arr_data['transaction_status'] = $_POST['status'];
        $transaction_id = $_POST['txnid'];
        //dd($_POST);
        $transaction = DealsTransactionModel::where('transaction_id', $transaction_id)->update($arr_data);
        if ($transaction) {

            $obj_single_transaction = DealsTransactionModel::where('transaction_id', $_POST['txnid'])->first();
            if ($obj_single_transaction) {
                $obj_single_transaction->load(['user_records']);
                $arr_single_transaction = $obj_single_transaction->toArray();
            }
            $first_name = ucfirst($arr_single_transaction['user_records']['first_name']);
            $email = ucfirst($arr_single_transaction['user_records']['email']);

            $transaction_id = $_POST['txnid'];
            $transaction_status = $_POST['status'];
            //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();

            $obj_email_template = EmailTemplateModel::where('id', '1')->first();
            if ($obj_email_template) {
                $arr_email_template = $obj_email_template->toArray();

                $content = $arr_email_template['template_html'];
                $content = str_replace('##USER_FNAME##', $first_name, $content);
                $content = str_replace('##TRANS_ID##', $transaction_id, $content);
                $content = str_replace('##TRANS_STATUS##', $transaction_status, $content);
                $content = str_replace('##APP_LINK##', 'RightNext', $content);
                //print_r($content);exit;
                $content = view('email.front_general', compact('content'))->render();
                $content = html_entity_decode($content);
                if (! empty($email)) {
                    $send_mail = Mail::send([], [], function ($message) use ($email, $first_name, $arr_email_template, $content) {
                        $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                        $message->to($email, $first_name)
                            ->subject($arr_email_template['template_subject'])
                            ->setBody($content, 'text/html');
                    });
                    if ($send_mail) {
                        Session::flash('success_payment', 'Success ! Order Place Successfully ! ');

                        return redirect(url('/').'/front_users/my_order');
                    } else {
                        Session::flash('error_payment', 'Order place successfully But Mail Not Delivered Yet !');

                        return redirect(url('/').'/front_users/my_order');
                    }
                } else {
                    Session::flash('success_payment', 'Success ! Order Place Successfully ! ');

                    return redirect(url('/').'/front_users/my_order');
                }
                //return $send_mail;

            }
        }

        //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";

    }

    public function payment_fail()
    {
        echo 'payment fail'.'<pre>'.print_r($_POST, true).'</pre>';
    }

    public function payment_cancle()
    {
        echo 'payment cancle'.'<pre>'.print_r($_POST, true).'</pre>';

    }

    /**
     * Displays the pay page.
     *
     * @param  unknown  $params
     * @param  unknown  $salt
     *
     * @throws Exception
     */
    public function pay_page($params, $salt)
    {
        if (count($_POST) && isset($_POST['mihpayid']) && ! empty($_POST['mihpayid'])) {
            $_POST['surl'] = $params['surl'];
            $_POST['furl'] = $params['furl'];
            $result = response($_POST, $salt);

            $this->payment_success($result);
            //$this->payu->show_reponse( $result );
        } else {

            $result = $this->pay($params, $salt);
            $run_url = $this->payu->show_page($result);

            return $run_url;
        }
    }

    /**
     * Returns the pay page url or the merchant js file.
     *
     * @param  unknown  $params
     * @param  unknown  $salt
     * @return Ambigous <multitype:number string , multitype:number Ambigous <boolean, string> >
     *
     * @throws Exception
     */
    public function pay($params, $salt)
    {
        if (! is_array($params)) {
            throw new Exception('Pay params is empty');
        }

        if (empty($salt)) {
            throw new Exception('Salt is empty');
        }

        $payment = new PayUMoneyService($salt);
        $result = $payment->pay($params);
        unset($payment);

        return $result;
    }

    public function set_order_deal_with_promocode(Request $request)
    {
        $amount = $request->input('amount');
        $deal_id = $request->input('deal_id');
        $promocode = $request->input('promocode');
        $consider_amount = 0;
        $apply_discount = 0;
        $discounted_amount = 0;

        $consider_amount = $amount;

        $arr_coupon = [];
        $coupon_type = '';
        $obj_arr_coupon = CouponModel::where('coupon_code', $promocode)->first();

        if ($obj_arr_coupon != false) {
            $arr_coupon = $obj_arr_coupon->toArray();

        }
        if (count($arr_coupon) > 0 && isset($arr_coupon)) {
            $promo_start_date = $arr_coupon['start_date'];
            $promo_end_date = $arr_coupon['end_date'];
            $current_date = date('Y-m-d');
            if (strtotime($current_date) <= strtotime($promo_end_date) && strtotime($current_date) >= strtotime($promo_start_date)) {
                $coupon_type = $arr_coupon['type'];
                if ($coupon_type == 'PERCENT') {
                    $apply_discount = $arr_coupon['discount'];
                    $discounted_amount = ($consider_amount) - ($consider_amount * ($apply_discount / 100));
                } elseif ($coupon_type == 'AMT') {
                    $apply_discount = $arr_coupon['discount'];
                    if ($consider_amount > $apply_discount) {
                        $discounted_amount = $consider_amount - $apply_discount;

                    } else {
                        $data['status'] = 'ERROR';
                        $data['msg'] = 'Cart Total Is Less Than Promocode Discount Amount';
                        echo json_encode($data);
                        exit;

                    }

                }
                $data['status'] = 'ALLOWED';
                $data['msg'] = 'Promo code applied successfully';
                $data['coupon_type'] = $coupon_type;
                $data['apply_discount'] = $apply_discount;
                $data['discounted_amount'] = $discounted_amount;

                Session::put('total_deal_price', $discounted_amount);
                Session::put('coupon_type', $coupon_type);
                Session::put('apply_discount', $apply_discount);
                Session::put('promo_used', true);

                // dd(Session::all());
                // echo json_encode($data);
                return response()->json($data);

            } else {
                $data['status'] = 'ERROR';
                $data['msg'] = 'Promo code is not valid now';

                // echo json_encode($data);
                // exit;
                return response()->json($data);
            }

        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = 'Invalid Promo Code !';

            // echo json_encode($data);
            // exit;
            return response()->json($data);
        }

    }

    public function remove_promocode(Request $request)
    {
        $amount = $request->input('amount');
        if (Session::has('promo_used')) {

            $data['status'] = 'REMOVE';
            $data['msg'] = 'Promo code removed successfully';
            $data['original_amount'] = $amount;
            Session::forget('total_deal_price');
            Session::forget('coupon_type');
            Session::forget('apply_discount');
            Session::forget('promo_used');

            return response()->json($data);

        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = 'Promo code is not remove now';

            // echo json_encode($data);
            // exit;
            return response()->json($data);
        }

    }
}
