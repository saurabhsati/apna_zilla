@extends('front.template.master')

@section('main_section')
<style>
.remo_fav span{
    color: #f9a820 !important;
  }
  .remo_fav i{
    color: #f9a820 !important;
  }
  .right-paid span {
    color: #7e7e7e;
    font-size: 15px;
    margin-right: 15px;
   float: right;
}
    </style>
<div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here:</span>
    <li><a href="{{ url('/').'/front_users/profile' }}">Home</a></li>

    <li class="active">My Orders </li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
              @include('front.user.my_business_left')

              <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="p_detail_view pdngk">
                @if(isset($arr_order) && (count($arr_order)>0 ))
                @foreach($arr_order as $deal)
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                         <img src="{{ get_resized_image_path($deal['order_deal']['deal_image'],$deal_image_path,235,300) }}"  class="img-responsive" alt="" />
                     </div>
                      <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                          <div class="main-oderboxs">
                          <h4>{{ucwords($deal['order_deal']['name'])}}</h4>
                          <div class="bor_hefgsd"></div>
                          <?php $total=0;$final=0;?>
                        @foreach($deal['order_deal']['offers_info'] as $offers)
                          @foreach($deal['user_orders'] as $key => $selected_offers)
                           @if($selected_offers['offer_id']==$offers['id'])

                            <?php  
                                 $total=$total+$offers['discounted_price']*$selected_offers['order_quantity']; 
                                 $final=$final+ $total;
                            ?>
                           <div class="<?php  if($key<=sizeof($deal['user_orders'])-1) { echo "bordersk" ;}?>"></div>
                            <div class="main-oderboxs">
                           {{--  <h4>KFC</h4>
                            <div class="bor_hefgsd"></div> --}}
                            <div class="title-ondss">{{$offers['name']}}</div>
                            <p>{{$offers['title']}}</p>
                            <div class="qntyg">Qty - {{$selected_offers['order_quantity']}}</div>
                           <div class="right-kgf">
                           <span> <i class="fa fa-inr "></i> {{$offers['main_price']}}</span>
                           <i class="fa fa-inr right-paid"></i>{{$offers['discounted_price']}} ,  Total : <i class="fa fa-inr "></i>{{$total}}</div>
                           </div>

                            @endif                         
                        @endforeach
                      @endforeach
                         <div class="right-paid"><span> <i class="fa fa-inr "></i>Paid : {{$final}}</span></div>
                      </div>
                      <div class="clearfix"></div>
                    
                  </div>
                </div>
               <hr/>
                @endforeach

                 @else
                    <div class="row">
                       <strong><h4> Sorry , No Orders Found !! </h4> </strong>
                    </div>
                 @endif
                {!! $arr_paginate_my_order or '' !!}
           </div>
           </div>





























           
         </div>
       </div>
   </div>

@stop