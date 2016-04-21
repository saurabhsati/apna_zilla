@extends('front.template.master')

@section('main_section')
<div class="gry_container" style="padding: 7px 0 16px;">
 @include('front.deal.deal_top_bar')

<div class="container">
 <div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
   <ol class="breadcrumb">
     <span>You are here :</span>
     <li><a href="{{ url('/') }}">Home</a></li>
     @if(sizeof($deals_info)>0)
     <li><a href="{{ url('/deals') }}">Deals</a></li>
     <li class="active"><?php echo substr($deals_info[0]['name'],0,120).'..';?></li>
     @endif
   </ol>
 </div>
</div>
</div>
<hr/>

<div class="container">
  <div class="row">
   <div class="col-sm-12 col-md-12 col-lg-12">
   @if(sizeof($deals_info)>0)

     <div class="detail_bx">
       <h2>{{ucfirst($deals_info[0]['name'])}}</h2>
       <div class="rate_sec">
        <ul>
          <li><img alt="write_review" src="{{ url('/') }}/assets/front/images/verified.png" width="33px"/><span>{{$deals_info[0]['discount_price']}}%</span>  </li>
        </ul>
      </div>
      <img src="{{get_resized_image_path($deals_info[0]['deal_image'],$deal_image_path,350,1140)}}" height="350px" alt="deals detail" class="deals-detils"/>
    </div>

    <div class="clr"></div>
    <div class="pad-dels-details">
      <div class="col-sm-12 col-md-9 col-lg-9">

        <h5>{{$deals_info[0]['description']}}</h5>
        <div class="detail_link">
       </div>
       </div>



    <!-- side bar start -->
    <div class="col-sm-12 col-md-3 col-lg-3">
     <!-- Categories Start -->
     <div class="categories_sect sidebar-nav">

      <div class="buy_text">
      <span class="buy_price">£
      <?php echo round($deals_info[0]['price']-(($deals_info[0]['price'])*($deals_info[0]['discount_price']/100)));?></span>
      <div class="price-old">£{{ $deals_info[0]['price'] }} <!--| <span>offers 50% OFF</span>--></div>
       <?php
                    if($deals_info[0]['end_day']!='')
                    {
                      $date1 = date('Y-m-d',strtotime($deals_info[0]['end_day']));
                      $date2 = date('Y-m-d h:m:s');

                      $diff = abs(strtotime($date1) - strtotime($date2));

                      $years = floor($diff / (365*60*60*24));
                      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                      if($days>0)
                        {
                          echo '<div class="social_icon"> Limited For '.$days.' Days Only</div>' ;
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
</div>
<!-- side bar end -->

<div class="clearfix"></div>
</div>

</div>
</div>
</div>
</div>
</div>
@endsection