@extends('front.template.master')

@section('main_section')
<style>

    </style>
<div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here:</span>
    <li><a href="{{ url('/').'/front_users/profile' }}">Home</a></li>

    <li class="active">My Business </li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">

            <div class="col-sm-12 col-md-3 col-lg-3">

            </div>

             <div class="col-sm-12 col-md-12 col-lg-12">
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


             @if(isset($arr_business_info) && (count($arr_business_info)>0 ))
                @foreach($arr_business_info as $business)

                <div class="product_list_view">
                <div class="row">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="product_img">
                          <img style="height:100% !important;" src="{{ get_resized_image_path($business['main_image'],$main_image_path,205,270) }}" alt="list product"/>
                         @if($business['is_verified']==1)
                            <img class="first-cate-veri" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
                        </div>
                     </div>
                    <div class="col-sm-9 col-md-9 col-lg-9">
                    <div class="product_details">
                     <?php
                     $category_id='';
                      foreach ($business['category'] as $business_category)
                          {
                             foreach ($arr_sub_category as $sub_category)
                              {
                                if($business_category['category_id']==$sub_category['cat_id'])
                                {
                                   foreach ($arr_main_category as $main_category)
                                   {
                                      if($sub_category['parent']==$main_category['cat_id'])
                                      {
                                         $category_id=$sub_category['parent'];
                                        $title=$main_category['title'];
                                      }
                                    }
                                }
                              }
                          }

                          ?>

                        <div class="product_title">

                        <a href="javascript:void(0);">
                        @if($business['is_verified']==1)
                            <img class="product-like-icon1" src="{{ url('/') }}/assets/front/images/verified-green.png" alt="write_review"/>
                            @endif
                            {{ucwords($business['business_name'])}}</a></div>
                             <h4> @if(isset($title))Category::{{$title}}@endif</h4>
                        <div class="rating_star">
                         <?php
                          if(sizeof($business['reviews']))
                          {
                            $tot_review=sizeof($business['reviews']);

                          }
                          else
                          {
                             $tot_review=0;
                          }
                          ?>
                          <div class="resta-rating-block11">
                          <?php for($i=0;$i<round($business['avg_rating']);$i++){ ?>
                          <i class="fa fa-star star-acti"></i>
                          <?php }?>
                          <?php for($i=0;$i<(5-round($business['avg_rating']));$i++){ ?>
                          <i class="fa fa-star"></i>
                            <?php }?>
                            </div>
                           &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings
                         <span class=""> Estd.in {{ $business['establish_year'] }} </span></div>
                        <div class="p_details"><i class="fa fa-phone"></i><span>  {{$business['mobile_number']}}, {{$business['landline_number']}}</span></div>
                        <div class="p_details"><i class="fa fa-map-marker"></i> <span>{{$business['building']}}, {{$business['street']}} <br/>
                        {{$business['landmark']}}, {{$business['area']}} <br/> </span></div>
                        <div class="p_details">
                        <!-- <a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a> -->
                        <ul>
                        <!-- <li><a href="#">SMS/Email</a></li>  -->
                        <li><a href="{{ url('/front_users/edit_business_step1/'.base64_encode($business['id'])) }}" >Edit</a></li>

                        <input type="hidden" name="business_id" id="business_id" value="{{$business['id']}}">
                        <input type="hidden" name="business_name" id="business_name" value="{{$business['business_name']}}">
                       <input type="hidden" name="category_id" id="category_id" value="{{$category_id}}">
                        <input type="hidden" name="user_id" id="user_id" value="{{base64_decode(session('user_id'))}}">
                        <?php if(!sizeof($business['membership_plan_details'])>0)
                         { ?>
                          <li><a class="lst" href="{{ url('/front_users/assign_membership').'/'.base64_encode($business['id']).'/'.base64_encode($business['business_name']).'/'.Session::get('user_id').'/'.base64_encode($category_id) }}" class="lst">Purchase Plan</a></li>
                        <?php }
                        else
                          {?>
                              <li><a href="#" class="lst" style="color:green;">Plan Assign</a></li>
                           <?php }?>
                        <!-- </form>
                        --> <!-- <li><a href="#" class="lst">Rate This</a></li>         -->
                        </ul>
                        </div>
                        </div>

                </div>
                </div>
                 </div>

                 @endforeach

                 @else
                    <div class="row">
                       <strong><h4> Please Add Business </h4> </strong>
                    </div>
                 @endif

            </div>
         </div>
       </div>
   </div>

@stop