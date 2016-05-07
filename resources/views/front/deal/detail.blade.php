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
    height: 480px;
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
     <li><a href="{{ url('/') }}/{{$city}}/deals">Deals</a></li>
     <li class="active"><?php echo substr($deals_info[0]['name'],0,120).'..';?></li>
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

     <div class="detail_bx">
       <h2>{{ucfirst($deals_info[0]['name'])}}</h2>
       <div class="rate_sec">
        <ul>
          <li><!-- <img alt="write_review" src="{{ url('/') }}/assets/front/images/verified.png" width="33px"/> --><span><!-- {{$deals_info[0]['discount_price']}}%  -->{{ucfirst($deals_info[0]['title'])}}</span>  </li>
        </ul>
      </div>
      <img src="{{get_resized_image_path($deals_info[0]['deal_image'],$deal_image_path,350,1140)}}" height="350px" alt="deals detail" class="deals-detils"/>
    </div>

    <div class="clr"></div>
    <div class="pad-dels-details deal_detail_all">
      <div class="col-sm-12 col-md-12 col-lg-12">
      @if(isset($deals_info[0]['offers_info']) && sizeof($deals_info[0]['offers_info'])>0)
		 <ul class="detail_link">
		   <h3><b>What you get</b></h3>
		   @foreach($deals_info[0]['offers_info'] as $offers)
           <li><span>{{$offers['title']}}</span>  </li>
           @endforeach
       </ul>
       <hr/>
        @endif
        
        @if(isset($deals_info[0]['offers_info']) && sizeof($deals_info[0]['offers_info'])>0)
         <div class="detail_link">
           <h3><b>Validity </b></h3>
            @foreach($deals_info[0]['offers_info'] as $offers)
           <div>{{$offers['title']}}
           <div class=""><span>Valid from : {{ date('d-M-Y',strtotime($offers['valid_from'])) }}</span></div>
            <div class=""><span>Valid until : {{ date('d-M-Y',strtotime($offers['valid_until'])) }}</span></div>
               <br/>
            </div>
           @endforeach
          
        </div>
        <hr/>
        @endif
        
        @if(isset($deals_info[0]['things_to_remember']) && !empty($deals_info[0]['things_to_remember']))
	        <div class="detail_link">
	       <h3><b>Things To Remember </b></h3>
	       <span>
	       {{strip_tags($deals_info[0]['things_to_remember'])}}
	       </span>
	       </div>
	        <hr/>
        @endif
        @if(isset($deals_info[0]['how_to_use']) && !empty($deals_info[0]['how_to_use']))
		      <div class="detail_link"><h3><b>How to use the offer</b></h3><span>
		      {{strip_tags($deals_info[0]['how_to_use'])}}
		      </span></div>
	        <hr/>
        @endif
        @if(isset($deals_info[0]['about']) && !empty($deals_info[0]['about']))
	        <div class="detail_link">
	        <h3><b>About </b></h3>
	        <span>
	        {{strip_tags($deals_info[0]['about'])}}
	        </span>
	        </div>
	        <hr/>
        @endif
        @if(isset($deals_info[0]['facilities']) && !empty($deals_info[0]['facilities']))
           <div class="detail_link">
            <h3><b>Facilities</b></h3>
	        <span>
			{{strip_tags($deals_info[0]['facilities'])}}
	         </span>
	         </div>
	        <hr/>
        @endif
        @if(isset($deals_info[0]['cancellation_policy']) && !empty($deals_info[0]['cancellation_policy']))
	        <div class="detail_link">
	        <h3><b>Cancellation policy</b></h3>
	        <span>
			{{strip_tags($deals_info[0]['cancellation_policy'])}}
	        </span>
	        </div>
	        <hr/>
        @endif
        @if(isset($deals_info[0]['description']) && !empty($deals_info[0]['description']))
        <div class="detail_link">
	        <h3><b>Description</b></h3>
	        <span>
			{{strip_tags($deals_info[0]['description'])}}
	        </span>
	        </div>
         @endif
        <div class="detail_link">
       </div>
       </div>



  

<div class="clearfix"></div>
</div>

</div>
<div class="col-sm-4 col-md-4 col-lg-4">

 <div class="detail_bx">
       <h2>Select Offers</h2>
       <div class="categories_sect sidebar-nav ">
        @if(isset($deals_info[0]['offers_info']) && sizeof($deals_info[0]['offers_info'])>0)
       <div class=" deal_offers_all">
        <ul class="offers_span">
        	 @foreach($deals_info[0]['offers_info'] as $key =>$offers)
          <li><span>{{$offers['title']}}</span>  </li>
          <div class="divider"></div>
           @endforeach
         </ul>
       </div>
       <div class="pad-dels-details">Total : 	0</div>
       @else
         <div class=" deal_offers_all"><ul class="offers_span"><li><span>Sorry , No Offers Avialable !!!</span></li></ul></div>
        @endif
       </div>
       

</div>
  
<div class="categories_sect sidebar-nav">

      <div class="buy_text">
      <span class="buy_price">£
      <?php echo number_format(($deals_info[0]['price']-(($deals_info[0]['price'])*($deals_info[0]['discount_price']/100))),2);?></span>
      <div class="price-old">£{{ $deals_info[0]['price'] }} <!--| <span>offers 50% OFF</span>--></div>
       <?php
					 if($deals_info[0]['end_day']!='')
                    {

                    	$end_date = new \Carbon($deals_info[0]['end_day']);
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
      </div>
      <button class="btn btn-post center-b">Buy Now</button>
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

    @endif
  </div>
<!-- </div> -->
<!-- side bar end -->
</div>

</div>
</div>
</div>
</div>
@endsection