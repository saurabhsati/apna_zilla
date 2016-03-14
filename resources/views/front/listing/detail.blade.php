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
  <li><a href="{{url('/')}}//city/all-options/ct-{{isset($arr_business_details['category']['category_id']) && $arr_business_details['category']['category_id']!=''?$arr_business_details['category']['category_id']:'NA'}}">Restaurants</a></li>
         <li class="active">Britannia Wigan Hotel</li>

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
            <div class="product_detail_banner" style="background: url('{{ url('/') }}/assets/front/images/banner_detail.jpg') repeat scroll 0px 0px;">
              <div class="product_title"><a href="#">{{$arr_business_details['business_name']}}</a></div>
                <div class="rating_star"><ul><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o"></i></li><li><i class="fa fa-star-o"></i></li></ul>out of 3 <a href="#">reviews</a></div>
                <div class="p_details"><i class="fa fa-phone"></i><span> {{$arr_business_details['landline_number']}} &nbsp; {{$arr_business_details['mobile_number']}}</span></div>
                <div class="p_details"><i class="fa fa-map-marker"></i> <span>{{$arr_business_details['building']}} &nbsp; {{$arr_business_details['street']}},<br/> {{$arr_business_details['landmark']}},&nbsp;{{$arr_business_details['area']}},&nbsp;{{$arr_business_details['state_details']['state_title']}},&nbsp;{{$arr_business_details['country_details']['country_name']}} (<a href="#">map</a>)</span></div>

                <div class="p_details lst"><i class="fa fa-clock-o"></i><span>
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
                <div class="enquiry"><i class="fa fa-envelope"></i> Send Enquiry By Email</div>
                </div>


                    </div>

            <div class="icons">
            <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/shar.png" alt="share"/>Share</div>
                <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/write_review.png" alt="write_review"/>write review</div>
                <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/your-vote.png" alt="your-vote"/>Your Vote(0.5)</div>
                  <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/edit-this.png" alt="write_review"/>Edit this</div>
                  <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/sms-emil.png" alt="write_review"/>Sms/Email</div>
                <div class="img_icons"><img src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>verified</div>

            </div>
            </div>

                        <div class="tours-detail-tab">
                  <div id="dash_tab">
                     <ul class="resp-tabs-list">
                        <li>Add a Review </li>
                         <img class="dash_line" alt="line" src="{{ url('/') }}/assets/front/images/dash_menu_line.jpg">
                        <li>Reviews &amp; Ratings</li>
                         <img class="dash_line" alt="line" src="{{ url('/') }}/assets/front/images/dash_menu_line.jpg">
                        <li>Gallery</li>

                        <div class="clearfix"></div>
                     </ul>
                     <div class="resp-tabs-container">
                        <div> <div class="write-review-main">
                              <div class="write-review-head">
                                 Write a Review
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Title of your review
                                 </div>
                                 <div class="title-rev-field">
                                    <input type="text" name="Title" placeholder="Enter a review title" />
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="review-title">
                                 <div class="title-review">
                                    Your review
                                 </div>
                                 <div class="title-rev-field">
                                    <textarea class="message-review" placeholder="Enter your review" rows="" cols=""></textarea>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="submit-btn">
                                 <button>SUBMIT REVIEW</button>
                              </div>
                           </div></div>
                        <div>
                        <div class="rating_views">
                            <div class="rank_name">
                                <span>Excellent</span>
                                <div style="width: 32%;">&nbsp;</div>60%
                            </div>
                              <div class="rank_name">
                                <span>Very Good</span>
                                <div style="width: 0%;">&nbsp;</div>0%
                            </div>
                              <div class="rank_name">
                                <span>Good</span>
                                <div style="width: 12%;">&nbsp;</div>20%
                            </div>
                            <div class="rank_name">
                                <span>Average</span>
                                <div style="width:10%;">&nbsp;</div>15%
                            </div>
                            <div class="rank_name">
                                <span>Poor</span>
                                <div style="width: 2%;">&nbsp;</div>5%
                            </div>
                          </div>

                           <div class="testimo-one">
                              <div class="img-div-testi">
                                 <img src="{{ url('/') }}/assets/front/images/testi-user.png" alt="" />
                              </div>
                              <div class="testimo-content">
                                 <div class="user-name-testio">
                                    Anel N
                                 </div>
                                 <div class="testimo-user-mess">
                                    After failing to get a table at a nearby restaurant we wanted to try, a colleague and I chanced upon TED. A short walk from Kings Cross, and what a find.
                                 </div>
                                 <div class="acad-rating-block">
                                    <span class="stars-block"><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o stars-rat"></i><i class="fa fa-star-o"></i></span>
                                    <span class="label-block">January 2016</span>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="testimo-one lst">
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
                           </div>




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
                    <li class="brdr"><a href="#">Biryani Restaurants</a></li>
                  <li class="brdr"><a href="#">Restaurants</a></li>
                  <li class="brdr"><a href="#">Multicuisine Restaurants</a></li>
                  <li class="brdr"><a href="#">Chinese Restaurants</a></li>
                  <li class="brdr"><a href="#">Biryani Restaurants Home Delivery</a></li>
                  <li class="brdr"><a href="#">Dhaba Restaurants</a></li>
                  <li class="brdr"><a href="#">Tandoori Restaurants</a></li>
                  <li class="brdr"><a href="#">Andhra Restaurants Home Delivery</a></li>

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
                    <li class="brdr"><a href="#">Home Delivery</a></li>
                  <li class="brdr"><a href="#">Birthday Parties</a></li>
                  <li class="brdr"><a href="#">Banquet Hall</a></li>
                  <li class="brdr"><a href="#">TV Screens</a></li>
                  <li class="brdr"><a href="#">Pure Vegetarian</a></li>
                  <li class="brdr"><a href="#">WiFi</a></li>
                  <li class="brdr"><a href="#">Security Services</a></li>
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
               <div class="col-sm-3 col-md-3">
                <div class="product_info">
                   <div class="p_images">
                       <div class="name_product">Amirah's kitchen</div>
                       <img src="{{ url('/') }}/assets/front/images/img1.jpg" alt="product img"/>

                    </div>
                   <div class="p_infor_detail">
                    <span class="pull-left"><img src="{{ url('/') }}/assets/front/images/home_map.png" alt="location"/> London</span>
                    <span class="pull-right"><i class="fa fa-star-o ylow"></i></span>

                    </div>
                   </div>
                </div>
                 <div class="col-sm-3 col-md-3">
                <div class="product_info">
                   <div class="p_images">
                       <div class="name_product">Amirah's kitchen</div>
                       <img src="{{ url('/') }}/assets/front/images/img2.jpg" alt="product img"/>

                    </div>
                   <div class="p_infor_detail">
                    <span class="pull-left"><img src="{{ url('/') }}/assets/front/images/home_map.png" alt="location"/> London</span>
                    <span class="pull-right"><i class="fa fa-star-o ylow"></i></span>

                    </div>
                   </div>
                </div>
                 <div class="col-sm-3 col-md-3">
                <div class="product_info">
                   <div class="p_images">
                       <div class="name_product">Amirah's kitchen</div>
                       <img src="{{ url('/') }}/assets/front/images/img3.jpg" alt="product img"/>

                    </div>
                   <div class="p_infor_detail">
                    <span class="pull-left"><img src="{{ url('/') }}/assets/front/images/home_map.png" alt="location"/> London</span>
                    <span class="pull-right"><i class="fa fa-star-o ylow"></i></span>

                    </div>
                   </div>
                </div>
                 <div class="col-sm-3 col-md-3">
                <div class="product_info">
                   <div class="p_images">
                       <div class="name_product">Amirah's kitchen</div>
                       <img src="{{ url('/') }}/assets/front/images/img4.jpg" alt="product img"/>

                    </div>
                   <div class="p_infor_detail">
                    <span class="pull-left"><img src="{{ url('/') }}/assets/front/images/home_map.png" alt="location"/> London</span>
                    <span class="pull-right"><i class="fa fa-star-o ylow"></i></span>

                    </div>
                   </div>
                </div>

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
        
      </script>
      @endsection