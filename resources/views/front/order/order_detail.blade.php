@extends('front.template.master')

@section('main_section')
 @include('front.template._search_top_nav')
<style type="text/css">
.table-responsive {
    min-height: 0.01%;
    overflow-x: hidden!important;
}

.map {
    border: 1px solid #ddd;
    margin-top: 5px;
    padding: 3px;
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
                <h3>Order summary</h3>
                  <div class="p_detail_view pdngk">

                    <div class="mainpulsumiry">

<div class="row">
    
    <div class="col-sm-12 col-md-6 col-lg-6">
         <div class="pull-left">Sub Total</div><br/>
                      <p class="font-size_14px promo_status" style="display:none;"></p>
                      @if(Session::has('promo_used'))
                      <a href="#" id="removeCode" style="display:none;" onclick="remove_promocode();" class="remove_promo_trigger font-size_10px margin_zero info-class-color">Remove</a>@endif

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
                            
                           <input type="hidden" value="{{session('total_deal_price')}}" name="amount" id="amount">
                           <input type="hidden" value="{{$deal_arr['title']}}" name="deal_info" id="deal_info">
                            <input type="hidden" value="{{session('select_deal_id')}}" name="deal_id" id="deal_id">
                           <input type="hidden" name="user_id" id="user_id" value="{{base64_decode(session('user_id'))}}">
                           <input type="hidden" name="user_name" id="user_name" value="{{session('user_name')}}">
                           <input type="hidden" name="phone" id="phone" value="{{session('mobile_no')}}">


        
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="pull-right"><i class="fa fa-inr"></i> {{$total}}</div><br/>
                      <div id="amount_substract_div" style="display:none;">
                        <div class="pull-right">Discount Type <span id="discount_type"></span></div><br/>
                        <div class="pull-right">  - <span id="amount_substract"></span></div><br/>
                        </div>
    </div>
</div>

                     
                      

                      <div class="clearfix"></div>
                    </div>
                    <div id="apply_promo_div">
                    <div id="flip-newsd" style="cursor: pointer;"><a href="javascript:void(0);" >Click Here If You Have a promo code ?</a></div>
                    <div id="panel-newsd">
                      <div class="input-group" >
                        <input type="text" name="promocode" id="promocode" aria-describedby="basic-addon2" placeholder="Enter Promocode " class="form-control textbodr">
                        <span id="basic-addon2" class="input-group-addon style-aplyd"><a href="javascript:void(0);"  onclick="apply_promocode();">Apply</a></span>
                      </div>
                    </div>
                    </div>

                    <div class="summry-gry">
                      <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                          <h4>Total</h4>
                          <div class="loctionsd">Inclusive of taxes</div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                          <div class="sumry-tlin"><i class="fa fa-inr"></i> <span class="final_discounted_price">{{session('total_deal_price')}}</span></div>
                        </div>

                      </div>

                    </div>
                    <div class="row">

                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="cash-back-offer-parent">

                          <div class="radio-btns">

                            <div class="radio-btn">
                              <input type="radio" id="f-option" name="selector" checked="checked" id="selector" value="PAYU" >
                              <label for="f-option">Credit/Debit/Net banking/PayUmoney</label>
                              
                              <div class="check"></div>
                              {{-- <div class="dpslt"><a href="#"> 10% Cashback on American Express cards <i aria-hidden="true" class="fa fa-info-circle"></i></a></div> --}}
                            </div>




                          </div>

                        </div>

                      </div>

                     <div class="clearfix"></div> 


                   </div>
                 </div> 

                 
                 <div class="buy-n-btndsds">
                   @if(Session::has('user_id'))
                  <button type="submit" class="btn btn-post btn-post-nods" href="{{ url('/') }}/order/payment" >Proceed to payment</button>
                    @else
                    <button type="button" class="btn btn-post btn-post-nods" data-target="#login_poup" data-toggle="modal"  href="javascript:void(0);">Proceed to payment</button>
                   @endif
                  {{--  <a class="btn btn-post btn-post-nods" href="#">Proceed to payment</a> --}}
                   <div class="clearfix"></div> 
                 </div>
                 <div class="p_detail_view pdngk">
                   <div class="table-responsive">
                     <table class="table table-condensed">
                       <thead>
                         <th colspan="3">
                          <div class="row">
                           <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                             <img src="{{get_resized_image_path($deal_arr['deal_image'],$deal_image_path,200,234)}}" class="img-responsive mers" alt="" />
                           </div>
                           <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                             <h4>{{$deal_arr['name']}}</h4>
                             <h5>{{$deal_arr['title']}}</h5>
                           </div>
                         </div>
                       </th>

                     </thead>
                     <tbody>
                       @if(sizeof($complite_arr)>0 && isset($complite_arr))
                        @foreach($complite_arr as $key => $selected_offer)
                         @foreach($deal_arr['offers_info'] as $deal_offer)
                           @if($selected_offer[0]==$deal_offer['id'])
                           <tr>
                              <input type="hidden" name="offer_ids[]" id="offer_ids" value="{{$deal_offer['id']}}">
                               <input type="hidden" name="offer_quantitys[{{ $deal_offer['id'] }}]" id="offer_quantitys" 
                               value="{{$selected_offer[1]}}">
                             <td class="wosfd-one">{{$deal_offer['title']}}</td>
                             <td class="wosfd">Qty - {{$selected_offer[1]}}</td>
                             <td class="wosfd text-right">
                             <div class="left-gldf"> 
                             <i class="fa fa-inr"></i>&nbsp;{{$deal_offer['main_price']}} 
                             </div>
                             <div class="left-gldf-jh">
                              <i class="fa fa-inr"></i>&nbsp;{{$deal_offer['discounted_price']}}
                              </div>
                              </td>
                           </tr>
                             @endif
                           @endforeach
                         @endforeach
                        @endif

                       @if($key < sizeof($complite_arr)-1)
                          <tr><td colspan="3"   class="borderskds"></td></tr>
                      @endif
                   

                     </tbody>
                   </table>
                 </div>
                </div>

                </div>

                 </form>
               </div>
               @endif
            </div>
         </div>





<script type="text/javascript">



  jQuery.extend( jQuery.easing,{
      def: 'easeOutQuad',
      swing: function (x, t, b, c, d) {
        //alert(jQuery.easing.default);
        return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
      },
      easeInQuad: function (x, t, b, c, d) {
        return c*(t/=d)*t + b;
      },
      easeOutQuad: function (x, t, b, c, d) {
        return -c *(t/=d)*(t-2) + b;
      },
      easeInOutQuad: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t + b;
        return -c/2 * ((--t)*(t-2) - 1) + b;
      },
      easeOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
      },
      easeInOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
      },
      easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*(t/=d)*t*((s+1)*t - s) + b;
      },
      easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
      },
      easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158; 
        if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
      }
    });
  $(document).ready(function(){
  $("#flip-newsd").click(function(){
    $("#panel-newsd").slideToggle("slow");
  });
 
});


  var csrf_token = "{{ csrf_token() }}";
  function apply_promocode()
  {

   var promocode = $("#promocode").val();
   var amount    = $("#amount").val();
   var deal_id   = $("#deal_id").val();


   if(amount =='' && deal_id =='')
    {
       window.location.reload();
        return false;
    }
    else
    {
        var fromData = {
                            amount:{{$total}},
                            deal_id:deal_id,
                            promocode:promocode,
                            _token:csrf_token
                              };

      $.ajax({
                             url: site_url+"/order/set_order_deal_with_promocode",
                             type: 'POST',
                             data: fromData,
                             dataType: 'json',
                             async: false,

                             success: function(response)
                             {
                             	 if(response.status =="ALLOWED")
  	                           {
  	                             $("#amount").attr('value',response.discounted_amount);
                                 $(".final_discounted_price").html(response.discounted_amount);
                                 var coupon_type=response.coupon_type;
                                 var apply_discount=response.apply_discount;
                                 $("#amount_substract_div").css('display','block');
                                 if(coupon_type=='PERCENT')
                                 {
                                   $("#discount_type").html("%");
                                   $("#amount_substract").html(apply_discount+'%');

                                 }
                                 else if(coupon_type =='AMT')
                                 {
                                  $("#discount_type").html("Amount");
                                  $("#amount_substract").html('<i class="fa fa-inr"></i> '+apply_discount);
                                 }
                                $(".promo_status").css('display','block');
                                 $("#apply_promo_div").css('display','none');
                                 $(".promo_status").css('color','green');
  	                             $(".promo_status").html(response.msg);
                                 $(".promo_status").append('<br/><a href="javascript:void(0);" id="removeCode"  onclick="remove_promocode();" class="remove_promo_trigger font-size_10px margin_zero info-class-color">Remove</a>');
  	                           }
                               else if(response.status =="ERROR")
                               {
                                $(".promo_status").css('display','block');
                                $(".promo_status").css('color','red');
                                $(".promo_status").html(response.msg);
                               }

	                          
                               return false;
                             }
                         });
  }

  }
  function remove_promocode()
  {
     
          var fromData = {
                              amount:{{$total}},
                               _token:csrf_token
                                };

                        $.ajax({
                               url: site_url+"/order/remove_promocode",
                               type: 'POST',
                               data: fromData,
                               dataType: 'json',
                               async: false,

                               success: function(response)
                               {
                                 if(response.status =="REMOVE")
                                 {
                                  console.log(response.original_amount)
                                   $(".promo_status").css('display','block');
                                   $("#apply_promo_div").css('display','block');
                                   $("#amount_substract_div").css('display','none');
                                   $(".promo_status").css('color','green');
                                   $(".promo_status").html(response.msg);

                                   $("#amount").attr('value',response.original_amount);
                                   $(".final_discounted_price").html(response.original_amount);
                                 }
                                 else
                                 {
                                     $(".promo_status").css('display','block');
                                   $(".promo_status").css('color','green');
                                   $(".promo_status").html(response.msg);
                                 }
                                }
                             });

    }


</script>
@endsection