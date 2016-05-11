@extends('front.template.master')

@section('main_section')
 @include('front.template._search_top_nav')
<style type="text/css">
  .box_border {
    border: 1px solid #dcdada;
    overflow: hidden;
}
.padding-margin-zero-important {
    padding: 0!important;
    margin: 0!important;
}
.payment-page .order-total {
    border-top: 0;
    padding: 15px 7px;
}
.margin-bottom_35px {
    margin-bottom: 35px!important;
}
.margin-top_10px {
    margin-top: 10px!important;
}

.column, .columns {
    position: relative;
    padding-left: .5625rem;
    padding-right: .5625rem;
    float: left;
}
.medium-12 {
    width: 100%;
}
.promo_input_trigger {
    color: #d89605;
    text-decoration: underline;
    min-height: 30px;
    margin-bottom: 15px;
}
.row .row {
    width: auto;
    margin-left: auto;
    margin-right: -0.5625rem;
    margin-top: 0;
    margin-bottom: 0;
    max-width: none;
}
.btn.btn-post.center-b {
    display: block;
    float: none;
    margin: 0 auto 20px;
    text-align: center;
    width: 112%!important;;
}
.padding_10px {
    padding: 10px;
}
.row.payment-page .row {
    margin-right: 0;
}
.payment-page .order-total {
    border-top: 0;
    padding: 15px 7px;
}
#proceed-with-pay {
    margin-bottom: 5px!important;
    margin-top: 35px!important;
}
.select_payment_mode {
    width: 98%;
}

.nb-radio {
    display: inline-block;
    position: relative;
    transition: all .3s ease;
    cursor: pointer;
    vertical-align: top;
    margin-right: 40px;
}
label {
    font-size: .875rem;
    color: #e6ab2a;
    cursor: pointer;
    display: block;
    font-weight: normal;
    line-height: 1.5;
    margin-bottom: 0;
}

.nb-radio input:checked+.nb-radio__bg {
    opacity: 0;
}
.nb-radio input:checked+.nb-radio__bg {
    border-color: #212121;
}
.nb-radio__bg {
    display: block;
    width: 18px;
    height: 18px;
    border: 1px solid #a7a7a7;
    border-radius: 50%;
    display: inline-block;
    margin-left: 12px;
    vertical-align: middle;
    margin-right: 6px;
}
.medium-3 {
    width: 25%;
}
.medium-9 {
    width: 75%;
}
.image_overlay_wrapper {
    position: relative;
}
.font-weight_semibold {
    font-weight: 600;
}
.font-size_18px {
    font-size: 18px!important;
}
span.nb-radio__text {
    font-size: 16px;
    color: #d89605;
    margin-right: 143px;
    padding-left: 11px;
}
</style>
<div class="gry_container" style="padding: 7px 0 16px;">
 @include('front.deal.deal_top_bar')
            <div class="container">
               <div class="row">
               <form class="form-horizontal"
                                        id="paymoney_form"
                                        method="POST"
                                        action="{{ url('/') }}/order/payment"
                                        >
                @if(sizeof($deal_arr)>0)
  
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div data-equalizer-mq="large-up" data-equalizer="" class="row payment-page container">
                       <div class="column medium-12">
                          <h3 class="main-heading font-size_18px font-weight_semibold">Order summary</h3>
                          <div class="box_border">
                             <div class="margin-top_10px margin-bottom_35px">
                                <div class="small-6 column ">
                                   <p class="font-size_15px padding-margin-zero-important">Sub total</p>
                                </div>
                                <?php $total =0; 
                                 if(sizeof($complite_arr)>0 && isset($complite_arr))
                                 {
                                  foreach($complite_arr as $key => $selected_offer)
                                    {
                                      foreach($deal_arr['offers_info'] as $deal_offer)
                                      {
                                        if($selected_offer[0]==$deal_offer['id'])
                                        {
                                         $total=$total+$deal_offer['discounted_price']*$selected_offer[1];
                                        }
                                      } 
                                    }
                                   } ?>
                                    
                                   <input type="hidden" value="{{$total}}" name="amount" id="amount">
                                   <input type="hidden" value="{{$deal_arr['title']}}" name="deal_info" id="deal_info">
                                    <input type="hidden" value="{{$deal_arr['id']}}" name="deal_id" id="deal_id">
                                   <input type="hidden" name="user_id" id="user_id" value="{{base64_decode(session('user_id'))}}">
                                   <input type="hidden" name="user_name" id="user_name" value="{{session('user_name')}}">
                                   <input type="hidden" name="phone" id="phone" value="{{session('mobile_no')}}">
                                <div class="small-6 column">
                                   <p class="text-right margin_zero font-size_15px color-darker right font-weight_semibold"><i class="fa fa-inr"></i>&nbsp;<span subtotalprice="1.0" class="sub-total-price js-price-field">{{$total}}</span></p>
                                </div>
                             </div>
                             <div class="row">
                                <div class="medium-12 columns ">
                                   <div class="promo_input_wrapper"><a class="promo_input_trigger " href="javascript:void(0);">Have a promo code ?</a></div>
                                </div>
                                <div id="applyCodeContainer" class="medium-12 columns promo_input_box" style="display:none;">
                                   <div class="row collapse">
                                      <div class="small-8 columns medium-3"><input type="text" placeholder="Enter promo code" id="promocodeFld"></div>
                                      <div class="small-4 columns medium-1 left"><button class="button postfix btn-orng font-size12" id="applyPromoBtn">APPLY </button></div>
                                      <div class="incorrect-promo-code hide"><span>Please enter a valid promo code</span></div>
                                   </div>
                                </div>
                             </div>
                             <div id="removeCodeContainer" class="row" style="display:none;">
                                <div class="applied_credit">
                                   <div class="medium-8 columns">
                                      <p class="font-size_14px margin_zero">Promo code successfully applied</p>
                                      <a class="remove_promo_trigger font-size_10px margin_zero info-class-color" id="removeCode" href="#">Remove</a>
                                   </div>
                                   <div class="small-4 column ">
                                      <p class=" text-right margin_zero font-size_16px right font-weight_semibold color-darker"> - <i class="fa fa-inr"></i>&nbsp;<span id="promoDiff"></span></p>
                                   </div>
                                </div>
                             </div>
                             <div class="row order-total ">
                                <div class="small-6 column">
                                   <p class="font-size_18px color-darkest margin_zero padding_zero font-weight_semibold">Total</p>
                                   <span class="font-size_10px">Inclusive of taxes</span>
                                </div>
                                <div class="small-6 column">
                                   <p class="text-right margin_zero font-size_24px right green_txt"><i class="fa fa-inr"></i>&nbsp;<span finalprice="1.0" id="finalPrice">{{$total}}</span></p>
                                </div>
                             </div>

                             <div class="row">
                                <div id="proceed-with-pay" class="small-12 column select_payment_mode margin-bottom_25px margin-top_20px">
                                   <div class="form-group radio-group radio-group--inline">
                                      <label class="nb-radio">
                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" checked="checked" id="paymentModePayU" value="PAYU" name="paymentMode">
                                      <span class="nb-radio__bg"></span>
                                      <span class="nb-radio__icon icon rippler rippler-default"></span>
                                      <span class="nb-radio__text">Credit/Debit/Net banking/PayUmoney</span>
                                      </label>
                                    
                                   </div>
                                   <ul class="margin_zero margin-top_20px"></ul>
                                </div>
                             </div>
                             <div class="row">
                                <div class="small-12 column text-center select_payment_mode margin-bottom_20px">
                                   <div id="proceed-with-zero-pay" class="margin-top_10px font-size_15px" style="display: none;">
                                      <p class="green_txt font-size_24px margin_zero">Good News!</p>
                                      <p class="margin_zero">You needn't pay a penny more for this purchase</p>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                       <div id="proceed-with-pay-btn" class="column small-12 medium-4 right">

                        <button type="submit" class="btn btn-post center-b btn_buy" href="{{ url('/') }}/order/payment">Proceed to payment</button>
                      
                       <!-- <button class="button postfix btn_orange font-size18 margin_zero margin-top_20px">Proceed to payment</button> -->
                       </div>
                       <div id="proceed-with-zero-pay-btn" class="column small-12 medium-3 right" style="display: none;"><button class="button postfix btn_orange font-size18 margin_zero margin-top_20px">Proceed</button></div>
                       <div class="row">
                          <div class="column medium-12">
                             <h3 class="main-heading margin-top_25px font-size_18px font-weight_semibold">Order detail</h3>
                             <div class="box_border">
                                <div class="row order-total image_overlay_wrapper">
                                   <div class="column medium-3">
                                   <img draggable="false" alt="Goli-Vada-Pav-No-1-10260" src="{{get_resized_image_path($deal_arr['deal_image'],$deal_image_path,200,234)}}">
                                   </div>
                                   <div class="column medium-9">
                                      <p class="image_overl font-weight_semibold merchant-name font-size_18px color-darker">{{$deal_arr['name']}}</p>
                                      <p class="image_overl deal-title font-size_15px js-deal-title">{{$deal_arr['title']}}</p>
                                   </div>
                                </div>
                                <hr>
                                @if(sizeof($complite_arr)>0 && isset($complite_arr))

                                    @foreach($complite_arr as $key => $selected_offer)

                                        @foreach($deal_arr['offers_info'] as $deal_offer)

                                              @if($selected_offer[0]==$deal_offer['id'])

                                                  <div totalamount="1.0" price="1.0" dealid="10260" quantity="1" offerid="21457547962147" class="row padding_10px offers">
                                                    <input type="hidden" name="offer_ids[]" id="offer_ids" value="{{$deal_offer['id']}}">
                                                    <input type="hidden" name="offer_quantitys[{{ $deal_offer['id'] }}]" id="offer_quantitys" value="{{$selected_offer[1]}}">
                                                   <div class="small-12 medium-7 column">
                                                        <h4 class="font-size_14px padding-margin-zero-important color-darker" id="dealTitle0">{{$deal_offer['title']}}</h4>
                                                     </div>
                                                     <div class="small-3 medium-2 column">
                                                        <h4 class="font-size_12px font-weight_semibold padding-margin-zero-important color-darker">Qty - {{$selected_offer[1]}}</h4>
                                                     </div>
                                                     <div class="small-9 medium-3 column">
                                                        <p class="text-right margin_zero">
                                                        <span class="font-size_14px actual_price padding_zero"></span>
                                                        <span class="text-right margin_zero font-size_20px right color-darker">
                                                         <p class="price-old"><i class="fa fa-inr "></i>{{$deal_offer['main_price']}}</p>
                                                         <p class=""><i class="fa fa-inr "></i><span class="sell_price">{{$deal_offer['discounted_price']}}</span></p>
                                                        <input type="hidden" value="1.0" id="offersprice"></span></p>
                                                     </div>
                                                  </div>
                                                  @if($key < sizeof($complite_arr)-1)
                                                  <hr>
                                                  @endif

                                            @endif

                                         @endforeach

                                    @endforeach

                                @endif
                                
                             </div>
                          </div>
                       </div>
                       <div class="clearfix"></div>
                       </div>
                    </div>
                    </form>
               </div>
               @endif
            </div>
         </div>





<script type="text/javascript"></script>
@endsection