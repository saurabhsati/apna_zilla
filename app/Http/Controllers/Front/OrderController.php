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
  public function payment()
  {
    $page_title = 'Payment';
      $surl = url('/').'/order/success';
      $furl = url('/').'/order/fail';
      $curl = url('/').'/order/cancel';

      $txnid=uniqid( 'RTN_' );

       $parameter_post = array (  'key' => 'gtKFFx', 'txnid' =>$txnid , 'amount' =>10,
        'firstname' =>'abc', 'phone' => '8457679666',
        'productinfo' =>  'Deals & Ofers', 'surl' => $surl, 'furl' => $furl);
      $salt ='eCwWELxi';
      $run=$this->pay_page($parameter_post, $salt);
      return redirect($run);
  }
   public function payment_success()
  {
        
                  
    echo "Payment Success" . "<pre>" . print_r( $_POST, true ) . "</pre>";

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
      //$host = (isset( $_SERVER['https'] ) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

      /*if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['surl'] = $host;
      if ( isset( $_SERVER['REQUEST_URI'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) $params['furl'] = $host;*/
      //dd($params['surl']);
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
