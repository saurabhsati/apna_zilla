@extends('front.template.master')

@section('main_section')
<div class="gry_container" style="padding: 7px 0 16px;">
 @include('front.deal.deal_top_bar')
<!--  <div class="black-strip">
   <div class="container">
    <div class="row">

     <div class="col-lg-12">
      <div class="categ">
       <ul class="hidden-sm hidden-xs">
        <li><a href="#">All Deals</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Restaurant</a></li>
        <li><a href="#">Beauty</a></li>
        <li><a href="#">Tickets</a></li>
        <li><a href="#">Beauty</a></li>
        <li class="dropdown w3_megamenu-fw"><a data-hover="dropdown" class="dropdown-toggle ser" href="#">More <b class="caret" style="margin-left:5px;vertical-align:super;"></b></a>
          <ul class="dropdown-menu">
            <li class="w3_megamenu-content withdesc">
             <ul>
               <li><a href="#"> Eyelash Extensions</a></li>
               <li><a href="#"> Facial</a></li>
               <li><a href="#"> Makeup Application</a></li>
               <li><a href="#"> Tinting</a></li>
             </ul>
           </li>
         </ul>
       </li>


     </ul>


     <ul class="hidden-md hidden-lg">

      <li class="dropdown w3_megamenu-fw"><a data-hover="dropdown" class="dropdown-toggle ser" href="#">All Deals <b class="caret" style="margin-left:5px;vertical-align:super;"></b></a>
        <ul class="dropdown-menu">
          <li class="w3_megamenu-content withdesc">
           <ul>
            <li><a href="#">All Deals</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Restaurant</a></li>
            <li><a href="#">Beauty</a></li>
            <li><a href="#">Tickets</a></li>
            <li><a href="#">Beauty</a></li>
            <li><a href="#"> Eyelash Extensions</a></li>
            <li><a href="#"> Facial</a></li>
            <li><a href="#"> Makeup Application</a></li>
            <li><a href="#"> Tinting</a></li>
          </ul>
        </li>
      </ul>
    </li>


  </ul>
</div>
</div>

</div>

</div>
</div> -->
<div class="container">
 <div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
   <ol class="breadcrumb">
     <span>You are here :</span>
     <li><a href="#">Home</a></li>
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
       <h2>{{$deals_info[0]['name']}}</h2>
       <div class="rate_sec">
        <ul>
          <li><img alt="write_review" src="{{ url('/') }}/assets/front/images/verified.png" width="33px"/><span>{{$deals_info[0]['discount_price']}}%</span>  </li>
        </ul>
      </div>
      <img src="{{ url('/')}}/uploads/deal/{{$deals_info[0]['deal_image']}}" height="350px" alt="deals detail" class="deals-detils"/>
    </div>

    <div class="clr"></div>
    <div class="pad-dels-details">
      <div class="col-sm-12 col-md-9 col-lg-9">

        <h5>The Specifics</h5>
        <div class="detail_link">
        {{$deals_info[0]['description']}}
         <!--  <ul>
           <li> Beautiful featured posts slider</li>
           <li> Navigation bar hiding on scroll to bottom and appearing on opposite direction</li>
           <li> Works on your desktops, notebooks, tablets and mobiles</li>
           <li> Instagram feed</li>
           <li>WooCommerce support</li>
           <li> Widgetized sidebar &amp; footer</li>
           <li> Post like and share</li>
           <li>Explore page</li>
           <li> Review system</li>
           <li> Social media links</li>
           <li> Custom widgets </li>
         </ul> -->
       </div>
       <!-- <div class="divider"></div>
       <h5>Size information</h5>
       <table class="table newdet">
        <thead>
          <tr>
            <th>UK</th>
            <th>EU</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>3</td>
            <td>36</td>
          </tr>
          <tr>
            <td>4</td>
            <td>37</td>
          </tr>
          <tr>
            <td>5</td>
            <td>38</td>
          </tr>
          <tr>
            <td>6</td>
            <td>39</td>
          </tr>
          <tr>
            <td>7</td>
            <td>40</td>
          </tr>
          <tr>
            <td>8</td>
            <td>41</td>
          </tr>
        </tbody>
      </table> -->


    </div>



    <!-- side bar start -->
    <div class="col-sm-12 col-md-3 col-lg-3">
     <!-- Categories Start -->
     <div class="categories_sect sidebar-nav">

      <div class="buy_text">
      <span class="buy_price">£
      <?php echo round($deals_info[0]['price']-(($deals_info[0]['price'])*($deals_info[0]['discount_price']/100)));?></span>
      <div class="price-old">£{{ $deals_info[0]['price'] }} <!--| <span>offers 50% OFF</span>--></div>
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