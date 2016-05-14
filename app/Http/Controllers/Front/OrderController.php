<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DealsOffersModel;
use App\Common\Services\PayUCookiesService;
use App\Common\Services\PayUCurlService;
use App\Common\Services\PayUMiscService;
use App\Common\Services\PayUMoneyService;
use App\Common\Services\PayUPaymentService;

use App\Models\DealsTransactionModel;
use App\Models\UsersOrderModel;
use App\Models\EmailTemplateModel;
use Session;
use URL;
use Mail;
class OrderController extends Controller
{
  private $payu;

  public function __construct()
  {
     $this->payu = new PayUPaymentService('eCwWELxi');

  }

   public function index($offers,$enc_id)
   {
   	 $id = base64_decode($enc_id);
     if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
     $page_title ="Order Detail";
     /* Offers Ids & Quantity */
     $complite_arr=[];
     $explode_offers=explode('-',$offers);
     if(sizeof($explode_offers)>0)
     {
        foreach($explode_offers as $value)
        {
            $complite_arr[] = explode('_', $value);
         }
     }
     
 	  $obj_deal_arr=DealsOffersModel::with(['offers_info','deals_slider_images'])->where('id',$id)->first();
     if($obj_deal_arr)
    {
        $deal_arr = $obj_deal_arr->toArray();
    }
     $deal_image_path="uploads/deal";
    return view('front.order.order_detail',compact('page_title','deal_arr','deal_image_path','complite_arr'));
  }
  public function payment(Request $request)
  {
    if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
      $page_title = 'Payment';
       $surl = url('/').'/order/success';
      $furl = url('/').'/order/fail';
      $curl = url('/').'/order/cancel';

      $price           = $request->input('amount');
      $user_id         = $request->input('user_id');
      $user_name       = $request->input('user_name');
      $phone           = $request->input('phone');
      $deal_info       = $request->input('deal_info');
      $deal_id         = $request->input('deal_id');
      $paymentMode     = $request->input('paymentMode');
      $offer_ids       = $request->input('offer_ids'); 
      $offer_quantitys = $request->input('offer_quantitys');

       $validity   =30;
       $txnid=uniqid( 'RTN_' );
       $order_id=uniqid( 'RTN_ORD_' );

        $arr_data['user_id']            = $user_id;
        $arr_data['transaction_id']     = $txnid;
        $arr_data['order_id']           = $order_id;
        $arr_data['deal_id']            = $deal_id;
        $arr_data['price']              = $price;
        $arr_data['transaction_status'] = 'Pending';
        $arr_data['mode']               = $paymentMode;
        $arr_data['start_date']         = date('Y-m-d');
        $arr_data['expire_date']        = date('Y-m-d', strtotime("+".$validity."days"));
       
        
        $obj_deal = DealsOffersModel::where('id',$deal_id)->first();
        if($obj_deal)
        {
            $arr_single_deal = $obj_deal->toArray();
        }
        $last_redeem_count= $arr_single_deal['redeem_count'];
        $data_arr['redeem_count']    = $last_redeem_count+1;
       // dd($arr_single_deal);
        $deal_update = DealsOffersModel::where('id',$deal_id)->update($data_arr);
        //dd($arr_data);
        $dealtransaction = DealsTransactionModel::create($arr_data);

        

        foreach ($offer_ids as $key => $value)
        {
            $arr_order_data['offer_id']   = $value;
            $arr_order_data['deal_id']    = $deal_id;
            $arr_order_data['order_id']   = $order_id;

            $arr_order_data['order_quantity'] = $offer_quantitys[$value];
            $insert_data = UsersOrderModel::create($arr_order_data);

        }

      $parameter_post = array ( 
                        'key' => 'gtKFFx', 
                        'txnid' =>$txnid ,
                        'amount' =>$price,
                        'firstname' =>$user_name,
                        'phone' => $phone,
                        'productinfo' =>  'Deals Order', 
                        'surl' => $surl,
                        'furl' => $furl
                        );
      $salt ='eCwWELxi';
      $run=$this->pay_page($parameter_post, $salt);
      return redirect($run);
  }
   public function payment_success()
  {
        if(!(Session::has('user_id')))
        {
           return redirect('/');
        }
        $arr_data['mihpayid']=$_POST['mihpayid'];
        $arr_data['mode']=$_POST['mode'];
        $arr_data['transaction_status']=$_POST['status'];
        $transaction_id=$_POST['txnid'];
        //dd($_POST);
        $transaction = DealsTransactionModel::where('transaction_id',$transaction_id)->update($arr_data);
        if($transaction)
        {

          $obj_single_transaction=DealsTransactionModel::where('transaction_id',$_POST['txnid'])->first();
          if($obj_single_transaction)
          {
            $obj_single_transaction->load(['user_records']);
            $arr_single_transaction = $obj_single_transaction->toArray();
          }
          $first_name=ucfirst($arr_single_transaction['user_records']['first_name']);
          $email=ucfirst($arr_single_transaction['user_records']['email']);
          
          $transaction_id=$_POST['txnid'];
          $transaction_status=$_POST['status'];
          //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";die();
  
          $obj_email_template = EmailTemplateModel::where('id','1')->first();
              if($obj_email_template)
              {
                  $arr_email_template = $obj_email_template->toArray();

                  $content      = $arr_email_template['template_html'];
                  $content        = str_replace("##USER_FNAME##",$first_name,$content);
                  $content        = str_replace("##TRANS_ID##",$transaction_id,$content);
                  $content        = str_replace("##TRANS_STATUS##",$transaction_status,$content);
                  $content        = str_replace("##APP_LINK##","RightNext",$content);
                   //print_r($content);exit;
                  $content = view('email.front_general',compact('content'))->render();
                  $content = html_entity_decode($content);
                  if(!empty($email))
                  { 
                  $send_mail = Mail::send(array(),array(), function($message) use($email,$first_name,$arr_email_template,$content)
                              {
                                  $message->from($arr_email_template['template_from_mail'], $arr_email_template['template_from']);
                                  $message->to($email, $first_name)
                                          ->subject($arr_email_template['template_subject'])
                                          ->setBody($content, 'text/html');
                              });
                        if($send_mail)
                    {
                       Session::flash('success_payment','Success ! Order Place Successfully ! ');
                       return redirect(url('/').'/front_users/my_order');
                    }
                      else
                    {
                        Session::flash('error_payment','Order place successfully But Mail Not Delivered Yet !');
                         return redirect(url('/').'/front_users/my_order');
                    }
                  }
                  else
                  {
                    Session::flash('success_payment','Success ! Order Place Successfully ! ');
                    return redirect(url('/').'/front_users/my_order');
                  }
                  //return $send_mail;
            
          }
        }  
                   
    //echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";

  }

  public function payment_fail()
  {
    echo "payment fail". "<pre>" . print_r( $_POST, true ) . "</pre>";
  }

  public function payment_cancle()
  {
    echo "payment cancle". "<pre>" . print_r( $_POST, true ) . "</pre>";

  }

  /**
   * Displays the pay page.
   *
   * @param unknown $params
   * @param unknown $salt
   * @throws Exception
   */
  public function pay_page ( $params, $salt )
  {
    if ( count( $_POST ) && isset( $_POST['mihpayid'] ) && ! empty( $_POST['mihpayid'] ) ) {
      $_POST['surl'] = $params['surl'];
      $_POST['furl'] = $params['furl'];
      $result = response( $_POST, $salt );

      $this->payment_success($result );
      //$this->payu->show_reponse( $result );
    }
    else
    {
      
      $result = $this->pay( $params, $salt );
      $run_url=$this->payu->show_page( $result );
       return $run_url ;
    }
  }

  /**
   * Returns the pay page url or the merchant js file.
   *
   * @param unknown $params
   * @param unknown $salt
   * @throws Exception
   * @return Ambigous <multitype:number string , multitype:number Ambigous <boolean, string> >
   */
  function pay ( $params, $salt )
  {
    if ( ! is_array( $params ) ) throw new Exception( 'Pay params is empty' );

    if ( empty( $salt ) ) throw new Exception( 'Salt is empty' );

    $payment = new PayUMoneyService( $salt );
    $result = $payment->pay( $params );
    unset( $payment );

    return $result;
  }

  

}
