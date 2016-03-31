

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
                     <div class="rating_star">
                        <ul>
                           <?php for($i=0;$i<round($arr_business_details['avg_rating']);$i++){ ?>
                           <li><i class="fa fa-star-o ylow"></i></li>
                           <?php }?>
                           <?php for($i=0;$i<(5-round($arr_business_details['avg_rating']));$i++){ ?>
                           <li><i class="fa fa-star-o"></i></li>
                           <?php }?>
                        </ul>
                        {{round($arr_business_details['avg_rating'])}}&nbsp;out of 5 <a href="#" onclick="clickReview()">reviews</a>
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
                        <div class="add_det"><i class="fa fa-globe"></i><a href="{{$arr_business_details['website']}}"> {{$arr_business_details['website']}}</a></div>
                         <div class="enquiry"><a data-toggle="modal" data-target="#enquiry"><i class="fa fa-envelope"></i> Send Enquiry By Email</a></div>
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
                  <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/your-vote.png" alt="your-vote"/>Your Vote(0.5)</div>
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
                  <div class="resp-tabs-container">
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
                              id="validation-form"
                              method="POST"
                              action="{{ url('/listing/store_reviews/'.base64_encode($business_id)) }}"
                              enctype="multipart/form-data"
                              >
                              {{ csrf_field() }}
                              <div class="review-title">
                                 <div class="your-rating"> Your rating </div>
                                 <input type="hidden" value="" name="rating" id="rating">
                                 <span class="wrtrvtxt hidden-xs" id="mratdet">( <span id="dprtng">-</span> )</span>
                                 <div class="yr_rating-over">
                                    <ul>
                                       <li>
                                          <a class="ratingStar1" href="javascript:void(0);" rel="0.5">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common1" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over1.png" id="over1" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar2" href="javascript:void(0);" rel="1.0">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common2" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over1.png" id="over2" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar3" href="javascript:void(0);" rel="1.5">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common3" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over2.png" id="over3" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar4" href="javascript:void(0);" rel="2.0">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common4" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over2.png" id="over4" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar5" href="javascript:void(0);" rel="2.5">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common5" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over3.png" id="over5" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar6" href="javascript:void(0);" rel="3.0">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common6"  alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over3.png" id="over6" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar7" href="javascript:void(0);" rel="3.5">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common7" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over4.png" id="over7" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar8" href="javascript:void(0);" rel="4.0">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common8" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over4.png" id="over8" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar9" href="javascript:void(0);" rel="4.5">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common9" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over5.png" id="over9" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                       <li>
                                          <a class="ratingStar10" href="javascript:void(0);" rel="5.0">
                                             <img src="{{ url('/') }}/assets/front/images/comman-over.png" id="common10" alt="hover imag"/>
                                             <img src="{{ url('/') }}/assets/front/images/over5.png" id="over10" style="display: none;" alt="hover imag"/>
                                          </a>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Title
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="title" placeholder="Title" />
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Add review
                                 </div>
                                 <div class="title-rev-field">
                                    <textarea class="message-review" placeholder="Add review" rows="" cols="" name="review"></textarea>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Name
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="name" placeholder="Name" />
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
                                       <input type="text" name="mobile_no" class="form-control" id="exampleInputAmount" placeholder="Mobile Number">
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Email Id
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="email" placeholder="Email Id" />
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="submit-btn">
                                 <button type="submit">SUBMIT REVIEW</button>
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
                                    <!-- <i class="fa fa-star-o stars-rat"></i>
                                       <i class="fa fa-star-o stars-rat"></i>
                                       <i class="fa fa-star-o stars-rat"></i>
                                       <i class="fa fa-star-o"></i> -->
                                 </span>
                                 <span class="label-block"><?php echo date('F Y',strtotime($review['created_at'])); ?></span>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @endif
                        <!--  <div class="testimo-one lst">
                           <div class="img-div-testi">
                              <img src="images/testi-user.png" alt="" />
                           </div>
                           <div class="testimo-content">
                              <div class="user-name-testio">
                                 coumess
                              </div>
                              <div class="testimo-user-mess">
                               Awesome tool for creating a global business directory! Adding new cities is as easy as it can get, the extensive backend features for admin makes this theme a clear winner in this niche.
                              </div>
                              <div class="acad-rating-block">
                                 <span class="stars-block"><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o"></i></span>
                                 <span class="label-block">January 2016</span>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <div class="clearfix"></div>

                           <div class="testimo-one replay">
                           <div class="img-div-testi">
                              <img src="images/testi-user.png" alt="" />
                           </div>
                           <div class="testimo-content">
                              <div class="user-name-testio">
                                 Emma
                              </div>
                              <div class="testimo-user-mess">
                                I have not seen better Google map integration then this ever. Marker clustering is one hell of a useful feature when you have a huge directory with thousands of listings on map.
                              </div>
                              <div class="acad-rating-block">
                                 <span class="stars-block"><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o"></i></span>
                                 <span class="label-block">January 2016</span>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           </div>
                           </div> -->
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
                  <span>No Service Available.</span>
                  @endif
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
            </div>
             <div class="categories_sect sidebar-nav">
               <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/services.png" alt="services"/>Modes Of Payment<span class="spe_mobile3"><a href="#"></a></span></div>
               <div class="bor_head">&nbsp;</div>
               <ul class="spe_submobile3">
                  @if(isset($arr_business_details['payment_mode']) && sizeof($arr_business_details['payment_mode'])>0)
                  @foreach($arr_business_details['payment_mode'] as $payment_mode)
                  <li class="brdr">{{ $payment_mode['title'] }}</li>
                  @endforeach
                  @else
                  <span>No Payment Mode Available.</span>
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
<script type="text/javascript">
   function show_opening_times()
   {
     $('#business_times_div').show();
   }


   /*function show_map()
   {
     $('#map_show').show();
   }*/

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
   
   // $(".ratingStar").hover(function(){
   //    var rate=$(this).attr('rel');
   //    $("#dprtng").html(rate);
   //    $("input[name='rating']").val(rate);
   // });

      $(".ratingStar1").hover(
         function()
         {
            $('#over1').show();
            $('#common1').hide();
         },
         function()
         {
            $('#common1').show();
            $('#over1').hide();
         }
      );

      $(".ratingStar2").hover(
         function()
         {
            $('#over1').show();
            $('#over2').show();
            $('#common1').hide();
            $('#common2').hide();

            var rate=$(this).attr('rel');
            $("#dprtng").html(rate);
            $("input[name='rating']").val(rate);
         },
         function()
         {
            $('#common1').show();
            $('#common2').show();
            $('#over1').hide();  
            $('#over2').hide();
         }
      );

      /*$(".ratingStar2").click(function(){
         console.log('in');
         $('#over1').show();
         $('#over2').show();
         $('#common1').hide();
         $('#common2').hide();
      });*/

</script>
@endsection

