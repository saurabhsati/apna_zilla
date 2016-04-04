

@extends('front.template.master')
@section('main_section')
@include('front.template._search_top_nav')
<div class="gry_container">
   <div class="container">
      <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12">
            <ol class="breadcrumb">
               <span>You are here :</span>
               <li><a href="{{url('/')}}">Home</a></li>
               <!-- <li><a href="{{url('/')}}/{{$city}}/all-options/ct-{{isset($arr_business_details['category_details']['category_id']) && $arr_business_details['category_details']['category_id']!=''?$arr_business_details['category_details']['category_id']:'NA'}}"><?php if(isset($parent_category[0]['title']) && $parent_category[0]['title']!=''){echo $parent_category[0]['title'];} ?></a></li>
                  -->
               <li class="active"> {{ isset($arr_business_details['business_name']) && sizeof($arr_business_details['business_name'])>0?$arr_business_details['business_name']:''}}</li>
            </ol>
         </div>
      </div>
   </div>
   <hr/>
   <div class="container">
      <div class="row">
         @if(isset($arr_business_details) && sizeof($arr_business_details)>0)
         <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="p_detail_view">
               <!--  <div class="product_detail_banner" style="background: url('{{ url('/') }}/assets/front/images/banner_detail.jpg') repeat scroll 0px 0px;"> -->
               <div style="background: url('{{ url('/') }}/uploads/business/main_image/{{ $arr_business_details['main_image'] }}'); background-repeat: repeat;  background-size: 100% auto;">
                  <div class="product_detail_banner" style="background-color:rgba(0,0,0,0.7);">
                     <div class="product_title"><a href="#">{{$arr_business_details['business_name']}}</a></div>
                      <div class="resta-rating-block11">
                      <?php for($i=0;$i<round($arr_business_details['avg_rating']);$i++){ ?>
                      <i class="fa fa-star star-acti"></i>
                      <?php }?>
                      <?php for($i=0;$i<(5-round($arr_business_details['avg_rating']));$i++){ ?>
                      <i class="fa fa-star"></i>
                        <?php }?>
                      </div>
                     <div class="p_details"><i class="fa fa-phone"></i><span> {{$arr_business_details['landline_number']}} &nbsp; {{$arr_business_details['mobile_number']}}</span></div>
                     <div class="p_details"><i class="fa fa-map-marker"></i> <span>{{$arr_business_details['building']}} &nbsp; {{$arr_business_details['street']}},<br/> {{$arr_business_details['landmark']}},&nbsp;{{$arr_business_details['area']}},&nbsp;{{$arr_business_details['state_details']['state_title']}},&nbsp;{{$arr_business_details['country_details']['country_name']}} (<a href="javascript:void(0);" onclick="show_map()">map</a>)</span></div>
                     <div class="p_details lst">
                        <i class="fa fa-clock-o"></i><span>
                        @if(isset($arr_business_details['business_times']) && $arr_business_details['business_times']!='')
                        <?php
                           $current_day = strtolower(date("D"));
                           $open_time = $current_day.'_open';
                           $close_time = $current_day.'_close';
                           ?>
                        @if(array_key_exists($open_time, $arr_business_details['business_times']) &&
                        array_key_exists($close_time, $arr_business_details['business_times']) )
                        {{date('D')}} - {{ $arr_business_details['business_times'][$open_time] }} -
                        {{ $arr_business_details['business_times'][$close_time] }}
                        @endif
                        <a href="javascript:void(0);" onclick="show_opening_times()">View All</a></span>
                        @else
                        <span>Business Time Not Available.</span>
                        @endif
                        <div class="add_det"><i class="fa fa-globe"></i><a href="http://{{$arr_business_details['website']}}" target="_blank"> {{$arr_business_details['website']}}</a></div>
                         <div class="enquiry"><a data-toggle="modal" data-target="#enquiry"><i class="fa fa-envelope"></i> Send Enquiry By Email</a></div>
                     </div>
                  </div>
               </div>

               <div class="modal fade" id="share" role="dialog">
                <div class="modal-dialog">
                 <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <div class="modal-body">
                      <p>Share With Friends</p>
                        <div class="soc-menu-top">
                        <ul>
                        <li>
                       <!--  <a href="https://www.facebook.com/sharer.php?u=http%3A%2F%2Fwww.mynide.com%2Fdeals%2Fdetails%2FMQ%3D%3D&amp;t=1+Cocktail" target="_blank" style="cursor:pointer;">
                        </a> -->
                        <a href="https://www.facebook.com/sharer.php?<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;"><img src="{{ url('/') }}/assets/front/images/facebook-so.png" alt="facebook"/>
                        <span class="socail_name">Facebook</span>
                        </a>
                        </li>
                          <li><a href="http://twitter.com/share?url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;"><img src="{{ url('/') }}/assets/front/images/twitter-so.png" alt="twitter"/><span class="socail_name">Twitter</span></a></li>
                          <li><a href="https://plus.google.com/share?url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;"><img src="{{ url('/') }}/assets/front/images/googlepls-soc.png" alt="googlepls"/><span class="socail_name">Google +</span></a></li>
                          <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo URL::current(); ?>" target="_blank" style="cursor:pointer;"><img src="{{ url('/') }}/assets/front/images/linkind-soc.png" alt="linkind"/><span class="socail_name">Linkedin</span></a></li>
                          <!-- <li><a href="#"><img src="{{ url('/') }}/assets/front/images/pins-soc.png" alt="pins"/><span class="socail_name">Pinterest</span></a></li>
                          <li><a href="#"><img src="{{ url('/') }}/assets/front/images/VKontakte-so.png" alt="VKontakte"/><span class="socail_name">VKontakte</span></a></li>
                          <li><a href="#"><img src="{{ url('/') }}/assets/front/images/msg-so.png" alt="msg"/><span class="socail_name">SMS</span></a></li>
                          <li><a href="#"><img src="{{ url('/') }}/assets/front/images/email-soc.png" alt="email"/><span class="socail_name">Email</span></a></li>
                        --> </ul>
                        </div>
                    </div>
                  </div>
                </div>
              </div>




               <!--   <div class="map" id="business_location_map" style="width: 100%; height: 250;">
                  </div> -->
               <?php
                  $business_id =  $arr_business_details['id'];
                  ?>
               <div id="map_show" style="display: none;  margin-top: 5px;">
                  <div id="location_map" style="height:250px; width: 100%;"></div>
               </div>
               <input type="hidden" name="lat" id="lat" value="{{$arr_business_details['lat']}}"/>
               <input type="hidden" name="lng" id="lng" value="{{$arr_business_details['lng']}}"/>
               <div class="icons">
                  <div class="img_icons popup-v"><a data-toggle="modal" data-target="#share"><img src="{{ url('/') }}/assets/front/images/shar.png" alt="share"/>Share</a></div>
                  <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/write_review.png" alt="write_review">write review</div>

                  <div class="img_icons" onclick="showreview()" style="cursor: pointer;">
                    <div class="yr_rating-over">
                                    <input class="star required" type="radio" name="rating" value="1" id="rating" title="1 Star" />
                                    <input class="star" type="radio" name="rating" id="rating" value="2" title="2 Star" onclick="return set_rating(this);" />
                                    <input class="star" type="radio" name="rating" id="rating" value="3" title="3 Star" onclick="return set_rating(this);"/>
                                    <input class="star" type="radio" name="rating" id="rating" value="4" title="4 Star" onclick="return set_rating(this);"/>
                                    <input class="star" type="radio" name="rating" id="rating" value="5" title="5 Star" onclick="return set_rating(this);"/>

                                 </div><br/>
                   <!--  <img src="{{ url('/') }}/assets/front/images/your-vote.png" alt="your-vote"/> -->
                      Your Vote(<span id="dprtng">-</span>)

                  </div>
                  <div class="img_icons popup-v">
                     <a data-toggle="modal" data-target="#sms"><img src="{{ url('/') }}/assets/front/images/sms-emil.png" alt="write_review"/>Sms/Email</a>
                  </div>
                  <div class="img_icons popup-v">
                    <a data-toggle="modal" data-target="#verifed"><img src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>verified</a>
                  </div>
               </div>









                 <!--<div class="img_icons popup-v"><a data-toggle="modal" data-target="#share"><img src="images/shar.png" alt="share"/>Share</a></div>
                <div class="img_icons"><img src="images/write_review.png" alt="write_review"/>write review</div>
                <div class="img_icons"><img src="images/your-vote.png" alt="your-vote"/>Your Vote(0.5)</div>
                  <div class="img_icons"><img src="images/edit-this.png" alt="write_review"/>Edit this</div>
                <div class="img_icons popup-v"><a data-toggle="modal" data-target="#sms"><img src="images/sms-emil.png" alt="write_review"/>Sms/Email</a></div>
                      <div class="img_icons popup-v"><a data-toggle="modal" data-target="#verifed"><img src="images/verified.png" alt="write_review"/>verified</a></div>-->









            </div>
            <!-- <div class="map" id="business_location_map" style="width: 100%; height: 250;">
               </div> -->
            <div class="tours-detail-tab">
               <div id="dash_tab" style="background: #ffffff; padding: 10px 13px; border: 1px solid #eaeaea;">
                  <ul class="resp-tabs-list ">
                     <li id="review">Add a Review </li>
                     <img class="dash_line" alt="line" src="{{ url('/') }}/assets/front/images/dash_menu_line.jpg">
                     <li id="rating">Reviews &amp; Ratings</li>
                     <img class="dash_line" alt="line" src="{{ url('/') }}/assets/front/images/dash_menu_line.jpg">
                     <li>Gallery</li>
                     <div class="clearfix"></div>
                  </ul>
                  <div class="resp-tabs-container" id="review_rating">
                     <div>
                          @if(Session::has('success'))
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              {{ Session::get('success') }}
                          </div>
                        @endif

                        @if(Session::has('error'))
                          <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              {{ Session::get('error') }}
                          </div>
                        @endif
                        <div class="write-review-main" id="review_id">
                           <div class="write-review-head">
                              Write a Review
                           </div>

                           <form class="form-horizontal"
                              id="review-form"
                              method="POST"
                              action="{{ url('/listing/store_reviews/') }}"
                              enctype="multipart/form-data"
                              >
                              {{ csrf_field() }}
                              <div class="review-title">
                                 <div class="your-rating"> Your rating </div>
                                 <input type="hidden" name="business_id" value="{{$business_id}}">
                                 <div class="yr_rating-over">
                                    <input class="star required" type="radio" name="rating" value="1" id="rating" title="1 Star" />
                                    <input class="star" type="radio" name="rating" id="rating" value="2" title="2 Star"/>
                                    <input class="star" type="radio" name="rating" id="rating" value="3" title="3 Star"/>
                                    <input class="star" type="radio" name="rating" id="rating" value="4" title="4 Star"/>
                                    <input class="star" type="radio" name="rating" id="rating" value="5" title="5 Star"/>

                                 </div>
                                    <div class="error_msg" id="err_rating" name="err_rating"></div>

                                 <div class="clearfix" ></div>
                              </div>

                              <div class="review-title">
                                 <div class="title-review">
                                    Add review
                                 </div>
                                 <div class="title-rev-field">
                                    <textarea class="message-review"  placeholder="Add review" rows="" cols="" name="review" id="review" ></textarea>
                                    <div class="error_msg" id="err_review" name="err_review"></div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Name
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="name" id="name" placeholder="Name" value=""/>
                                    <div class="error_msg" id="err_name" name="err_name"></div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Mobile Number
                                 </div>
                                 <div class="title-rev-field">
                                    <div class="input-group">
                                       <div class="input-group-addon">+91</div>
                                       <input type="text" name="mobile_no" id="mobile_no"  class="form-control"  value="" placeholder="Mobile Number">
                                    </div>
                                     <div class="error_msg" id="err_mobile_no" name="err_mobile_no"></div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Email Id
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="email" id="email"  placeholder="Email Id" value=""/>
                                    <div class="error_msg" id="err_email" name="err_email"></div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="submit-btn">

                                 <button type="submit" name="submit_review" id="submit_review" onclick="return check_review();">SUBMIT REVIEW</button>
                              </div>
                           </form>

                        </div>
                     </div>
                     <div>
                        <div class="rating_views">
                           <div class="rank_name">
                              <span>Excellent</span>
                              <div style="width: 32%;">&nbsp;</div>
                              60%
                           </div>
                           <div class="rank_name">
                              <span>Very Good</span>
                              <div style="width: 0%;">&nbsp;</div>
                              0%
                           </div>
                           <div class="rank_name">
                              <span>Good</span>
                              <div style="width: 12%;">&nbsp;</div>
                              20%
                           </div>
                           <div class="rank_name">
                              <span>Average</span>
                              <div style="width:10%;">&nbsp;</div>
                              15%
                           </div>
                           <div class="rank_name">
                              <span>Poor</span>
                              <div style="width: 2%;">&nbsp;</div>
                              5%
                           </div>
                        </div>
                        @if(isset($arr_business_details['reviews']) && sizeof($arr_business_details['reviews'])>0)
                        @foreach($arr_business_details['reviews'] as $review)
                        <div class="testimo-one">
                           <div class="img-div-testi">
                              <img src="{{ url('/') }}/assets/front/images/testi-user.png" alt="" />
                           </div>
                           <div class="testimo-content">
                              <div class="user-name-testio">
                                 {{$review['name']}}
                              </div>
                              <div class="testimo-user-mess">
                                 {{$review['message']}}
                              </div>
                              <div class="acad-rating-block">
                                 <span class="stars-block">
                                    <?php for($i=0;$i<$review['ratings'];$i++){ ?>
                                    <i class="fa fa-star-o stars-rat"></i>
                                    <?php } ?>

                                 </span>
                                 <span class="label-block"><?php echo date('F Y',strtotime($review['created_at'])); ?></span>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @endif

                     </div>
                     <div>
                        <div class="gallery_view">
                           <div class="gallery">
                              @if(isset($arr_business_details['image_upload_details']) && $arr_business_details['image_upload_details']!='')
                              @foreach($arr_business_details['image_upload_details'] as $business_images)
                              <div class="prod_img">
                                 <a href="{{ url('/') }}/uploads/business/business_upload_image/{{$business_images['image_name']}}" class="gal img_inner"><img src="{{ url('/') }}/uploads/business/business_upload_image/{{$business_images['image_name']}}" alt=""/></a>
                              </div>
                              @endforeach
                              @else
                              <span>No Image Available.</span>
                              @endif
                           </div>
                           <div class="clr"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <br />
            </div>
         </div>
         <div class="col-sm-12 col-md-3 col-lg-3">
            <!-- Categories Start -->
            <div class="categories_sect sidebar-nav">
               <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/also-listed.png" alt="also listed"/>Also Listed in<span class="spe_mobile1"><a href="#"></a></span></div>
               <div class="bor_head">&nbsp;</div>
               <ul class="spe_submobile1">
                  @if(isset($all_category) && sizeof($all_category)>0)
                  @foreach($all_category as $category)
                  @foreach($arr_business_details['also_list_category'] as $busi_in_cat)
                  @if($category['cat_id']==$busi_in_cat['category_id'])
                  <li class="brdr"><a href="{{ url('/') }}/{{$city}}/all-options/ct-{{$busi_in_cat['category_id']}}"><?php echo $category['title']; ?></a></li>
                  @endif
                  @endforeach
                  @endforeach
                  @endif
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
            </div>
            <div class="categories_sect sidebar-nav" id="business_times_div" style="display:none ;">
               <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/hours-of-operation.png" alt="Hours of Operation"/>Hours of Operation<span class="spe_mobile2"><a href="#"></a></span></div>
               <div class="bor_head">&nbsp;</div>
               <ul class="spe_submobile2">
                  <li class="brdr"><a href="#">Monday   : {{$arr_business_details['business_times']['mon_open']}} - {{$arr_business_details['business_times']['mon_close']}}</a></li>
                  <li class="brdr"><a href="#">Tuesday  : {{$arr_business_details['business_times']['tue_open']}} - {{$arr_business_details['business_times']['tue_close']}}</a></li>
                  <li class="brdr"><a href="#">Wednesday: {{$arr_business_details['business_times']['wed_open']}} - {{$arr_business_details['business_times']['wed_close']}}</a></li>
                  <li class="brdr"><a href="#">Thursday : {{$arr_business_details['business_times']['thus_open']}} - {{$arr_business_details['business_times']['thus_close']}}</a></li>
                  <li class="brdr"><a href="#">Friday   : {{$arr_business_details['business_times']['fri_open']}} - {{$arr_business_details['business_times']['fri_close']}}</a></li>
                  <li class="brdr"><a href="#">Saturday : {{$arr_business_details['business_times']['sat_open']}} - {{$arr_business_details['business_times']['sat_close']}}</a></li>
                  <li class="brdr"><a href="#">Sunday   : {{$arr_business_details['business_times']['sun_open']}} - {{$arr_business_details['business_times']['sun_close']}}</a></li>
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
            </div>
            <div class="categories_sect sidebar-nav">
               <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/services.png" alt="services"/>Services<span class="spe_mobile3"><a href="#"></a></span></div>
               <div class="bor_head">&nbsp;</div>
               <ul class="spe_submobile3">
                  @if(isset($arr_business_details['service']) && sizeof($arr_business_details['service'])>0)
                  @foreach($arr_business_details['service'] as $services)
                  <li class="brdr">{{ $services['name'] }}</li>
                  @endforeach
                  @else
                  <span class="col-sm-3 col-md-3 col-lg-12">No Service Available.</span>
                  @endif
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
            </div>
             <div class="categories_sect sidebar-nav">
               <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/money.png" alt="services"/>Modes Of Payment<span class="spe_mobile3"><a href="#"></a></span></div>
               <div class="bor_head">&nbsp;</div>
               <ul class="spe_submobile3">
                  @if(isset($arr_business_details['payment_mode']) && sizeof($arr_business_details['payment_mode'])>0)
                  @foreach($arr_business_details['payment_mode'] as $payment_mode)
                  <li class="brdr">{{ $payment_mode['title'] }}</li>
                  @endforeach
                  @else
                  <span class="col-sm-3 col-md-3 col-lg-12">No Payment Mode Available.</span>
                  @endif
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
            </div>
         </div>
         @else
         <span>No Hotel/Restaurant Found</span>
         @endif
      </div>
      <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="title_main">Related Listing</div>
            <div class="row">
               @if(isset($all_related_business) && sizeof($all_related_business)>0)
               @foreach($all_related_business as $related_business)
               <div class="col-sm-3 col-md-3">
                  <div class="product_info">
                     <div class="p_images-detail">
                        <?php
                           $slug_business=str_slug($related_business['business_name']);
                           $slug_area=str_slug($related_business['area']);
                           $business_area=$slug_business.'<near>'.$slug_area;
                           ?>
                        <div class="name_product"> <a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($related_business['id'])}}" style="color: #ffffff;">{{ $related_business['business_name'] }}</a></div>
                        <img src="{{ url('/') }}/uploads/business/main_image/{{ $related_business['main_image'] }}" alt="product img"/>
                     </div>
                     <div class="p_infor_detail">
                        <span class="pull-left address-icon-img"><img src="{{ url('/') }}/assets/front/images/home_map.png" alt="location"/>{{$related_business['area']}}</span>
                        <span class="pull-right"><i class="fa fa-star-o ylow"></i></span>
                     </div>
                  </div>
               </div>
               @endforeach
               @else
               <span class="col-sm-3 col-md-3 col-lg-3">No related records found !</span>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="enquiry" role="dialog">
    <div class="modal-dialog modal-sm">
     <!-- Modal content-->
      <div class="modal-content">
      <form class="form-horizontal"
                              id="validation-form"
                              method="POST"
                              action="{{ url('/listing/send_enquiry')}}"
                              enctype="multipart/form-data"
                              >
                              {{ csrf_field() }}
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <b class="head-t">Send Enquiry By Email</b>

            <div class="soc-menu-top" style="margin-top:20px;">
                <div class="col-lg-11">
                     <div class="user_box1">
                           <div class="row">
                    <div class="col-lg-3  label-text1">To</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                     @if(isset($arr_business_details) && sizeof($arr_business_details)>0)
                         <div class="label-text1">{{$arr_business_details['business_name']}}</div>
                         <input type="hidden" id="business_id" name="business_id" value="{{$arr_business_details['id']}}">



                  @endif
                        </div>
                         </div>
                    </div>
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Name<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" required="" aria-describedby="basic-addon1" placeholder="Enter Name" id="name" name="name" class="input_acct form-control">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>



            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span id="basic-addon1" class="input-group-addon">+91</span>
                        <input type="text" required="" aria-describedby="basic-addon1" id="mobile" name="mobile"  placeholder="Mobile" class="form-control">

                        </div>
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>


                <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" required="" aria-describedby="basic-addon1" placeholder="Enter Email" name="email" id="email" class="input_acct form-control">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Subject<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" required="" aria-describedby="basic-addon1" placeholder="Enter Subject"  name="subject" id="subject" class="input_acct form-control">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Body<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="textarea" required="" aria-describedby="basic-addon1" placeholder="Enter Body" name="message" id="message" class="input_acct form-control">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>
                    <div class="clr"></div>
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">&nbsp;</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <div class="submit-btn"><button type="submit" name="submit_enquiry" id="submit_enquiry">Ok</button></div>

                    </div>
                           </div>
                    </div>

                     <span class="mandt"><span style="color:red">*</span>Denotes mandatory fields. </span>
                </div>
            </div>
           <div class="clr"></div>
        </div>
      </div>
      </form>
    </div>
  </div>


  <!-- Modal -->

<div class="modal fade" id="sms" role="dialog">
    <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
       <div id="sms_err_div">

               </div>
       <form class="form-horizontal"
                              id="validation-form"
                              method="POST"
                              action="{{ url('/listing/send_sms/') }}"
                              enctype="multipart/form-data"
                              >
          {{ csrf_field() }}
          @if(isset($arr_business_details) && sizeof($arr_business_details)>0)
                        <input type="hidden" id="business_id" name="business_id" value="{{$arr_business_details['id']}}">

                  @endif
          <b class="head-t">Get information by SMS/Email</b>
           <p class="in-li">Enter the details below and click on SEND</p>
            <div class="soc-menu-top">
                <div class="col-lg-11">
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Name</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Name"   id="name" name="name" class="input_acct">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>



            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span id="basic-addon1" class="input-group-addon">+91</span>
                        <input type="text" required="" aria-describedby="basic-addon1" id="sms_mobile_no" name="sms_mobile_no" placeholder="Mobile" class="form-control" >

                        </div>
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>


                <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Email" name="email" id="email" class="input_acct" value="">
                          <div class="error_msg"></div>
                        </div>
                         </div>
                    </div>
                    <div class="clr"></div>
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">&nbsp;</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <div class="submit-btn">
                     <button type="button" name="send_sms" id="send_sms" onclick="Send_SMS()">Send</button>
                      </div>
                    </div>
                           </div>
                    </div>
                </div>
            </div>
           <div class="clr"></div>
        </div>
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript">
//var site_url="{{url('/')}}";
   // $('#submit_review').click(function(){


function check_review()
{
        var rating  = $('#rating').val();
        var review  = $('#review').val();
        var name    = $('#name').val();
        var mobile  = $('#mobile_no').val();
        var email   = $('#email').val();
        var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
        var filter_contact=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;

        var flag=1;

        if(rating=="")
        {

          $('#err_rating').html('Enter Your Rating.');
          $('#err_rating').show();
          $('#rating').focus();
          $('#rating').on('click',function(){
          $('#err_rating').hide();
            });
          flag=0;
        }

          if(review=="")
        {
          $('#err_review').html('Enter Your Review.');
          $('#err_review').show();
          $('#review').show();
          $('textarea#review').on('keyup', function(){
          $('#err_review').hide();
            });
          flag=0;
        }
        if(name=="")
        {
          $('#err_name').html('Enter Your Name.');
          $('#err_name').show();
          $('#name').focus();
          $('#name').on('keyup', function(){
          $('#err_name').hide();
            });
          flag=0;
        }
        if(mobile=="")
        {

          $('#err_mobile_no').html('Enter Your Mobile Number.');
          $('#err_mobile_no').show();
          $('#mobile_no').focus();
          $('#mobile_no').on('keyup', function(){
          $('#err_mobile_no').hide();
            });
          flag=0;
        }
        if(!filter_contact.test(mobile))
        {
          $('#err_mobile_no').html('Enter Your Valid Mobile Number.');
          $('#err_mobile_no').show();
          $('#mobile_no').focus();
          $('#mobile_no').on('keyup', function(){
          $('#err_mobile_no').hide();
            });
          flag=0;
        }
        if(email=="")
        {
          $('#err_email').html('Enter Your Email ID.');
          $('#err_email').show();
          $('#email').focus();
          $('#email').on('keyup', function(){
          $('#err_email').hide();
            });
          flag=0;
        }
        if(!filter.test(email))
        {
          $('#err_email').html('Enter Your Valid Email ID.');
          $('#err_email').show();
          $('#email').focus();
          $('#email').on('keyup', function(){
          $('#err_email').hide();
            });
          flag=0;
        }

        if(flag==1)
        {
            return true;
        }
        else
        {
          return false;
        }

    }



   function show_opening_times()
   {
     $('#business_times_div').show();
   }

   function showreview()
   {
    // $('#review').addClass('resp-tab-active');
    // $('#review_rating').addClass('resp-tab-content-active');
   }



</script>
<script type="text/javascript">
   var  map;
   var ref_input_lat = $('#lat');
   var ref_input_lng = $('#lng');


   function setMapLocation(address)
   {
     console.log(address);
       geocoder.geocode({'address': address}, function(results, status) {
           if (status == google.maps.GeocoderStatus.OK)
           {

               map.setCenter(results[0].geometry.location);

               $(ref_input_lat).val(results[0].geometry.location.lat().toFixed(6));
               $(ref_input_lng).val(results[0].geometry.location.lng().toFixed(6));

               var latlong = "(" + results[0].geometry.location.lat().toFixed(6) + ", " +
                       +results[0].geometry.location.lng().toFixed(6)+ ")";



               marker.setPosition(results[0].geometry.location);
               map.setZoom(16);
               infowindow.setContent(results[0].formatted_address);

               if (infowindow) {
                   infowindow.close();
               }

               google.maps.event.addListener(marker, 'click', function() {
                   infowindow.open(map, marker);
               });

               infowindow.open(map, marker);

           } else {
               alert("Lat and long cannot be found.");
           }
       });
   }
   function initializeMap()
   {
        var latlng = new google.maps.LatLng($(ref_input_lat).val(), $(ref_input_lng).val());
        var myOptions = {
            zoom: 18,
            center: latlng,
            panControl: true,
            scrollwheel: true,
            scaleControl: true,
            overviewMapControl: true,
            disableDoubleClickZoom: false,
            overviewMapControlOptions: {
                opened: true
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("location_map"),
            myOptions);
        geocoder = new google.maps.Geocoder();
        marker = new google.maps.Marker({
            position: latlng,
            map: map
        });

        map.streetViewControl = false;
        infowindow = new google.maps.InfoWindow({
            content: "("+$(ref_input_lat).val()+", "+$(ref_input_lng).val()+")"
        });

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);

            var yeri = event.latLng;

            var latlongi = "(" + yeri.lat().toFixed(6) + ", " + yeri.lng().toFixed(6) + ")";

            infowindow.setContent(latlongi);

            $(ref_input_lat).val(yeri.lat().toFixed(6));
            $(ref_input_lng).val(yeri.lng().toFixed(6));

        });

        google.maps.event.addListener(map, 'mousewheel', function(event, delta) {

            console.log(delta);
        });

         //var addr = "<?php echo $arr_business_details['street'];?>,"+"<?php echo $arr_business_details['area'];?>,"+"<?php echo $arr_business_details['state_details']['state_title'];?>,"+"<?php echo $arr_business_details['country_details']['country_name'];?>";

        // setMapLocation(addr);
        //onload_address_map();//call function onload

    }

   function loadScript()
   {
           var script = document.createElement('script');
           script.type = 'text/javascript';
           script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                   'callback=initializeMap';
           document.body.appendChild(script);


   }

   function show_map()
   {
     $('#map_show').show();
     loadScript();
     //window.onload = loadScript();
   }

   /* Autcomplete Code */

   function setMarkerTo(lat,lon,place)
   {
       var location = new google.maps.LatLng(lat,lng)
       map.setCenter(location);
       $(ref_input_lat).val = lat;
       $(ref_input_lng).val = lng;
       marker.setPosition(location);
       map.setZoom(16);
   }
  function set_rating(ref)
  {
     var rate=$(ref).val();
      $("#dprtng").html(rate);
      //$("input[name='rating']").val(rate);

  }

  function Send_SMS()
  {
    var site_url   = "{{ url('/') }}";
    var name = $('#name').val();
    var mobile  = $('#sms_mobile_no').val();
    var email   = $('#email').val();
    var business_id   = $('#business_id').val();
    var token      = jQuery("input[name=_token]").val();

     jQuery.ajax({
           url      : site_url+"/listing/send_sms?_token="+token,
           method   : 'POST',
           dataType : 'json',
           data     : 'name='+name+'&mobile='+mobile+'&email='+email+'&business_id='+business_id,
           success: function(response)
           {
            //console.log(response);
              if(response.status == "SUCCESS" )
              {
                //console.log(response.mobile_no);
                $('#name').val('');
                $('#mobile').val('');
                $('#email').val('');


                $('#sms_otp_div_popup').click();
                $('#mobile_no_otp').val(response.mobile_no);
                //$('#reg_succ_div').show();
              }
              else if(response.status == "ERROR")
              {
                  $("#sms_err_div").empty();
                  $("#sms_err_div").fadeIn();
                  $("#sms_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                  return false;
              }
              else if(response.status == "OTP_ERROR")
              {
                 $("#sms_err_div").empty();
                 $("#sms_err_div").fadeIn();
                 $("#sms_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
               else if(response.status == "VALIDATION_ERROR")
              {
                 $("#sms_err_div").empty();
                 $("#sms_err_div").fadeIn();
                  $("#sms_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else if(response.status == "MOBILE_ERROR")
              {
                 $("#sms_err_div").empty();
                 $("#sms_err_div").fadeIn();
                  $("#sms_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }

              else
              {

              }

              setTimeout(function()
              {
                  $("#reg_err_div").fadeOut();
              },5000);

              return false;
           }
        });
  }





</script>
@endsection

