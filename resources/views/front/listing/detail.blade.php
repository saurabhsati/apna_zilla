@extends('front.template.master')

@section('main_section')
@include('front.listing._search_top_nav')
<div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here :</span>
  <li><a href="#">Home</a></li>
  <li><a href="#">Restaurants</a></li>
         <li class="active">Britannia Wigan Hotel</li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="p_detail_view">
            <div class="product_detail_banner" style="background: url('{{ url('/') }}/assets/front/images/banner_detail.jpg') repeat scroll 0px 0px;">
              <div class="product_title"><a href="#">Britannia Wigan Hotel</a></div>
                <div class="rating_star"><ul><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o ylow"></i></li><li><i class="fa fa-star-o"></i></li><li><i class="fa fa-star-o"></i></li></ul>out of 3 <a href="#">reviews</a></div>
                <div class="p_details"><i class="fa fa-phone"></i><span>  86 10 6538 5537, +86 10 6538 5537</span></div>
                <div class="p_details"><i class="fa fa-map-marker"></i> <span>Kharadi Road, Kharadi, UK - 411014,
Near Eon IT Park And Zensar (<a href="#">map</a>)</span></div>

                <div class="p_details lst"><i class="fa fa-clock-o"></i><span>Today  11:30 am - 11:30 pm    <a href="#">View All</a></span>
                <div class="add_det"><i class="fa fa-globe"></i> www.britanniawigan.com</div>
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
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img1.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img1.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img2.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img2.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img3.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img3.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img4.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img4.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img1.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img1.jpg" alt=""/></a>
                                       </div>
                                             <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img1.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img1.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img2.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img2.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img3.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img3.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img4.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img4.jpg" alt=""/></a>
                                       </div>
                                       <div class="prod_img">
                                          <a href="{{ url('/') }}/assets/front/images/img1.jpg" class="gal img_inner"><img src="{{ url('/') }}/assets/front/images/img1.jpg" alt=""/></a>
                                       </div>
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

                 <div class="categories_sect sidebar-nav">

                 <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/hours-of-operation.png" alt="Hours of Operation"/>Hours of Operation<span class="spe_mobile2"><a href="#"></a></span></div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="spe_submobile2">
                    <li class="brdr"><a href="#">Monday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Tuesday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Wednesday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Thursday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Friday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Saturday : 09:00 - 22:00</a></li>
                  <li class="brdr"><a href="#">Sunday : 09:00 - 21:00</a></li>


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
      @endsection