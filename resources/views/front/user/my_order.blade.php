@extends('front.template.master')

@section('main_section')
<style>
.remo_fav span{
    color: #f9a820 !important;
  }
  .remo_fav i{
    color: #f9a820 !important;
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
             <div class="title_head"></div>

                   @if(Session::has('success_payment'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success_payment') }}
            </div>
          @endif

          @if(Session::has('error_payment'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error_payment') }}
            </div>
          @endif


             @if(isset($arr_order) && (count($arr_order)>0 ))
                @foreach($arr_order as $deal)
              <div class="product_list_view">
                <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                        
                        <div class="product_img">
                          <img style="height:100% !important;" src="{{ get_resized_image_path($deal['order_deal']['deal_image'],$deal_image_path,235,300) }}" alt="list product"/>
                       </div>
                     </div>
                    <div class="col-sm-8 col-md-8 col-lg-8">
                     <div class="product_details">
                      <div class="product_title"><h4> <b>{{ucwords($deal['order_deal']['name'])}}</b></h4>
                      </div>
                       <div class="product_title"><h3> {{ucwords($deal['order_deal']['title'])}}</h3>
                      </div>
                     </div>
                   <?php $total=0;?>
                      @foreach($deal['order_deal']['offers_info'] as $offers)
                        @foreach($deal['user_orders'] as $selected_offers)
                         @if($selected_offers['offer_id']==$offers['id'])

                          <?php  $total=$total+$offers['discounted_price']*$selected_offers['order_quantity']; ?>
                       <div  class="">
                                                 
                                                   <div class="">
                                                        <h4 class="" id="dealTitle0">{{$offers['title']}}</h4>
                                                     </div>
                                                     <div class="">
                                                        <h4 class="">Qty - {{$selected_offers['order_quantity']}}</h4>
                                                     </div>
                                                     <div class="">
                                                        <p class="">
                                                        <span class=""></span>
                                                        <span class="">
                                                         <p class="price-old"><i class="fa fa-inr "></i>{{$offers['main_price']}}</p>
                                                         <p class=""><i class="fa fa-inr "></i><span class="sell_price">{{$offers['discounted_price']}}</span></p>
                                                    </div>
                                                    <div><b>Total </b>: {{$total}}</div>
                                                  </div>
                         @endif                         
                        @endforeach
                      @endforeach
                </div>
                </div>
                 </div>
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

@stop