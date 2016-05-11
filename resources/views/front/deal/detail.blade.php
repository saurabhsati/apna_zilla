@extends('front.template.master')

@section('main_section')
 @include('front.template._search_top_nav')
 <style type="text/css">
 .deal_detail_all{
 	    display: block;
    overflow-y: scroll;
    height: 550px;
 }
  .deal_offers_all{
 	    display: block;
    overflow-y: scroll;
   /* height: 480px;*/
 }
.detail_link span {
    color: #777777;
    font-size: 14px;
    line-height: normal;
}
.offers_span span{
	color: #777777;
    font-size: 14px;
    text-align: justify;
    /*line-height: normal;*/
}
.detail_link b {
    font-size: 18px;
    font-weight: 600;
}


/* Related deals*/
/**/
 </style>
<div class="gry_container" style="padding: 7px 0 16px;">
 @include('front.deal.deal_top_bar')

<div class="container">
 <div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
   <ol class="breadcrumb">
     <span>You are here :</span>
     <li><a href="{{ url('/') }}">Home</a></li>
      <?php if(Request::segment(1))
              {
                 $city=urldecode(Request::segment(1));
              }
              else
              {
                  $city="Mumbai";
              }?>
     @if(sizeof($deals_info)>0)
      @foreach($deals_info as $deal)
    
     <li><a href="{{ url('/') }}/{{$city}}/deals">Deals</a></li>
     <li class="active"><?php echo substr($deal['name'],0,120).'..';?></li>
     @endforeach
     @endif
   </ol>
 </div>
</div>
</div>
<hr/>

<div class="container">
  <div class="row">
   <div class="col-sm-8 col-md-8 col-lg-8">
     @if(sizeof($deals_info)>0)
     @foreach($deals_info as $deal)

     <div class="detail_bx">
       <h2>{{ucfirst($deal['name'])}}</h2>
       <div class="rate_sec">
        <ul>
          <li><!-- <img alt="write_review" src="{{ url('/') }}/assets/front/images/verified.png" width="33px"/> --><span><!-- {{$deal['discount_price']}}%  -->{{ucfirst($deal['title'])}}</span>  </li>
        </ul>
      </div>
      <img src="{{get_resized_image_path($deal['deal_image'],$deal_image_path,350,1140)}}" height="350px" alt="deals detail" class="deals-detils"/>
    </div>

    <div class="clr"></div>
    <div class="pad-dels-details deal_detail_all">
      <div class="col-sm-12 col-md-12 col-lg-12">
      @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
		 <ul class="detail_link">
		   <h3><b>What you get</b></h3>
		   @foreach($deal['offers_info'] as $offers)
           <li><span>{{$offers['title']}}</span>  </li>
           @endforeach
       </ul>
       <hr/>
        @endif
        
        @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
         <div class="detail_link">
           <h3><b>Validity </b></h3>
            @foreach($deal['offers_info'] as $offers)
           <div>{{$offers['title']}}
           <div class=""><span>Valid from : {{ date('d-M-Y',strtotime($offers['valid_from'])) }}</span></div>
            <div class=""><span>Valid until : {{ date('d-M-Y',strtotime($offers['valid_until'])) }}</span></div>
               <br/>
            </div>
           @endforeach
          
        </div>
        <hr/>
        @endif
        
        @if(isset($deal['things_to_remember']) && !empty($deal['things_to_remember']))
	        <div class="detail_link">
	       <h3><b>Things To Remember </b></h3>
	       <span>
	       {{strip_tags($deal['things_to_remember'])}}
	       </span>
	       </div>
	        <hr/>
        @endif
        @if(isset($deal['how_to_use']) && !empty($deal['how_to_use']))
		      <div class="detail_link"><h3><b>How to use the offer</b></h3><span>
		      {{strip_tags($deal['how_to_use'])}}
		      </span></div>
	        <hr/>
        @endif
        @if(isset($deal['about']) && !empty($deal['about']))
	        <div class="detail_link">
	        <h3><b>About </b></h3>
	        <span>
	        {{strip_tags($deal['about'])}}
	        </span>
	        </div>
	        <hr/>
        @endif
        @if(isset($deal['facilities']) && !empty($deal['facilities']))
           <div class="detail_link">
            <h3><b>Facilities</b></h3>
	        <span>
			{{strip_tags($deal['facilities'])}}
	         </span>
	         </div>
	        <hr/>
        @endif
        @if(isset($deal['cancellation_policy']) && !empty($deal['cancellation_policy']))
	        <div class="detail_link">
	        <h3><b>Cancellation policy</b></h3>
	        <span>
			{{strip_tags($deal['cancellation_policy'])}}
	        </span>
	        </div>
	        <hr/>
        @endif
        @if(isset($deal['description']) && !empty($deal['description']))
        <div class="detail_link">
	        <h3><b>Description</b></h3>
	        <span>
			{{strip_tags($deal['description'])}}
	        </span>
	        </div>
         @endif
        <div class="detail_link">

       </div>
       <section class=" deals container">
   <div class="small-12 deal_row">
      <h3>Releted Deals</h3>
      <div class="row">
        @if(sizeof($arr_related_deals_info)>0 && isset($arr_related_deals_info))
           @foreach($arr_related_deals_info as $rel_deals)
         <div class="deal_cart medium-6 columns left font-family_open_sans_ragular" data-dealid="11453">
            <a class="ga-click-action card" href="{{url('/')}}/{{$city}}/deals/{{urlencode(str_replace(' ','-',$rel_deals['name']))}}/{{base64_encode($rel_deals['id'])}}">
               <div class="product_image product_black_ovelay card__img">
               <span class="ga-data hide" dealid="11453" title="Choice of Donuts" category="FNB" brand="Mad Over Donuts" variant="21 Locations" list="Deal Detail" position="1" city="mumbai" vertical="local"></span>
               <img class="deal loading img-sm" height="210px" width="350px" src="{{get_resized_image_path($rel_deals['deal_image'],$deal_image_path,200,250) }}" data-src="//img2.nbstatic.in/la-webp-s/5703a8ec02762b50e6f9ee28.jpg" alt="Mad Over Donuts" data-lzled="true"></div>
               <div class="description padding-tb_9px-rl_12px">
                  <h2 class="card__title"> {{$rel_deals['title']}}</h2>
                  <h3 class="card__location">21 Locations</h3>
                  <h4 class="card__description">{{strip_tags($rel_deals['description'])}}</h4>
               </div>
               <hr>
               <div class="card__footer">
                  <div class="row margin_zero green_txt card__footer__actual_price">
                     <div class="column medium-6 right"><span class="right"><span class="actual_price text-right padding_zero text-color_999999"></span></span></div>
                  </div>
                  <div class="row margin_zero green_txt">
                     <div class="column medium-6"><span class="bought text-color_999999"><span class="icon user"></span><span>{{$rel_deals['redeem_count']}} Bought </span></span></div>
                      <span >
                       <p class="price-old"><i class="fa fa-inr "></i>{{$rel_deals['price']}}</p>
                     <p class=""><i class="fa fa-inr "></i><span class="sell_price"><?php echo number_format(($rel_deals['price']-(($rel_deals['price'])*($rel_deals['discount_price']/100))),2);?></span></p>
                     </span>
                  </div>
               </div>
            </a>
         </div>
         @endforeach
        @else
                          <span class="col-sm-3 col-md-3 col-lg-12">No Related Deals Available.</span>
                          @endif
       
      </div>
   </div>
</section>
       </div>



  

<div class="clearfix"></div>
</div>

</div>
<div class="col-sm-4 col-md-4 col-lg-4">

 <div class="detail_bx">
       <h2>Select Offers</h2>
       <div class="categories_sect sidebar-nav ">
        @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
       <div class=" deal_offers_all">
        <ul class="offers_span foreach_ul">
        	 @foreach($deal['offers_info'] as $key =>$offers)
          <li ><span>{{$offers['title']}}</span>  <br>
          <div>  
	       <span >
               <p class="price-old"><i class="fa fa-inr "></i>{{$offers['main_price']}}</p>
	           <p class=""><i class="fa fa-inr "></i><span class="sell_price">{{$offers['discounted_price']}}</span></p>
             <input type="hidden" name="offer_hidden" id="offer_hidden" data-dealid="{{base64_encode($deal['id'])}}"  data-dotdid="{{$offers['id']}}" data-original="{{$offers['discounted_price']}}" data-minimumpurchasequantity="0" data-maxcustomercap="{{$offers['limit']}}">
          </span>
		    <label for="name">Select Quantity</label>
		     <input type="hidden" class="limit" name="limit" id="limit" value="{{$offers['limit']}}" />
		    <div class="dec button" style="  cursor: pointer;" >-</div>
		    <input type="text" name="qty" id="1" value="0" />
		    <div class="inc button" style="  cursor: pointer;" >+</div>
		</div>
		
	           
	    </li>
          <div class="divider"></div>
           @endforeach
         </ul>
       </div>
       <div class="pad-dels-details">Total :<span id="total_price">0</span>
       <input type="hidden" id="amount" name="amount" value="">
       </div>
       
       @else
         <div class=" deal_offers_all"><ul class="offers_span"><li><span>Sorry , No Offers Avialable !!!</span></li></ul></div>
        @endif

       </div>
        <p id="offerSelectionError" style="display: none; color:#d89605;font-size: 23px; text-align: center; margin: 2px 0 0 0;" class="select-offer-notification noshow"></p>
     

</div>
  
<div class="categories_sect sidebar-nav">

      <div class="buy_text">
      <span class="buy_price">
      <?php //echo number_format(($deal['price']-(($deal['price'])*($deal['discount_price']/100))),2);?></span>
     <!--  <div class="price-old">£{{ $deal['price'] }} </div> -->
       <?php
					 if($deal['end_day']!='')
                    {

                    	$end_date = new \Carbon($deal['end_day']);
                        $now = Carbon::now();
                        $difference = ($end_date->diff($now)->days < 1)
                            ? 'today'
                            : $end_date->diffForHumans($now);
                           
                        if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false) 
                        {
							echo '<div class="social_icon"> Limited For '.str_replace('after','', $difference).' Only</div>' ;
                        }



                    }
                    ?>
                    <span>{{$deal['redeem_count']}} Bought </span>
      </div>
      <input type="hidden" value="" id="offers_ids" name="offers_ids">
      @if(Session::has('user_id'))
      <a type="button" class="btn btn-post center-b btn_buy" href="javascript:void(0);">Buy Now</a>
       @else
        <a type="button" href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" class="btn btn-post center-b btn_buy" href="javascript:void(0);">Buy Now</a>
       @endif
      <div class="divider"></div>
      <div class="social_icon">
       SHARE THIS DEAL
       <ul>

        <li><a href="https://www.facebook.com/sharer.php?<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;" class="fb">&nbsp;</a> </li>
        <li><a href="http://twitter.com/share?url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;" class="twitter">&nbsp; </a> </li>
       <!--  <li><a href="#" class="instagram">&nbsp;</a> </li> -->
        <li><a href="https://plus.google.com/share?url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;" class="google">&nbsp;</a> </li>
       <!--  <li><a href="#" class="pioneer">&nbsp;</a> </li> -->
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;" class="in">&nbsp;</a> </li>
      </ul>
    </div>

    <!-- /#Categoriesr End-->
    <div class="clearfix"></div>
    @endforeach
    @endif
  </div>
<!-- </div> -->
<!-- side bar end -->
</div>

</div>
</div>
</div>
</div>
<script type="text/javascript">
  var site_url = "{{ url('/') }}";
	$(function() {


		incrementVar = 0;
$('.inc.button').click(function(){

		$("#offerSelectionError").css('display','none');
        var $this = $(this),

        $input = $this.prev('input'),

        $parent = $input.closest('div');
       // alert($parent.html());
        var limit=$(".limit").val();
        if(limit >  parseInt($input.val(), 10))
        {

         newValue = parseInt($input.val(), 10)+1;

		    $parent.find('.inc').addClass('a'+newValue);

		    $input.val(newValue);

		    incrementVar += newValue;

		    $offerprice=$parent.find('.sell_price').html();

		    var old_total = $('#total_price').html();

		    $finaltotal=parseInt($offerprice, 10)+parseInt(old_total, 10);

		     $('#total_price').html($finaltotal);
		     $("#amount").attr('value',$finaltotal);
         var offer_id=$parent.find('#offer_hidden').attr('data-dotdid');
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
         var deal_id=$parent.find('#offer_hidden').attr('data-dealid');
        }
	   
	     //alert($total);

});
$('.dec.button').click(function(){
        var $this = $(this),

        $input = $this.next('input');

        $parent = $input.closest('div');

        if($input.val() != '0')
        {
	        newValue = parseInt($input.val(), 10)-1;

		    $parent.find('.inc').addClass('a'+newValue);

		    $input.val(newValue);

		    incrementVar += newValue;

		    $offerprice=$parent.find('.sell_price').html();

		    var old_total = $('#total_price').html();

		    $finaltotal=parseInt(old_total, 10)-parseInt($offerprice, 10);
		   
		    $('#total_price').html($finaltotal);
		    $("#amount").attr('value',$finaltotal);
         var offer_id=$parent.find('#offer_hidden').attr('data-dotdid');
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
        }
	    
});
$('.btn_buy').click(function()
{
	var amount=$("#amount").val();
	if(amount=='')
	{
		$("#offerSelectionError").css('display','block');
		$("#offerSelectionError").html("Please select at least one offer");
		return false;
	}
	else
	{
    
    var string='offerid=';
		$(".foreach_ul").find('li').each( function(i){
       var current = $(this);
       var offer_id=current.find("#offer_hidden").attr('data-dotdid');
       var offer_selected_quantity=current.find("#offer_hidden").attr('data-minimumpurchasequantity');
       if(offer_selected_quantity!='0')
       {
         if (string.indexOf('_') == -1) 
         {
            string+=offer_id+'_'+offer_selected_quantity;
         }
         else
         {
            string+='-'+offer_id+'_'+offer_selected_quantity;
         }
       }
       

    });
   var deal_id=$('#offer_hidden').attr('data-dealid');
   if(deal_id!='')
   {
     string+='/'+deal_id;
   }
   var get_url=site_url+'/order/'+string;
  //alert(get_url);
  //return false;
  window.location.href = get_url;
    //alert(string);
  }
});

		

	});
</script>
@endsection
