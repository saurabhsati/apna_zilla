@extends('front.template.landing')

@section('main_section')

 <div class="catetory-block">
         <div class="container">
            <div class="category-head">
               <h3>Most Popular Category</h3>
               <span></span>
            </div>
            <div class="cate-count-block">
            <?php
            //echo '<pre>';
            //print_r($arr_category);
            ?>
               <ul class="category_list">
                  @if(isset($arr_category) && sizeof($arr_category)>0)
                  @foreach($arr_category as $key => $category)
                   <?php $count=0; ?>
                  <li <?php if($key>3){echo 'style=display:none;';}?> >
                     <a href="{{ url('/') }}/city/{{$category['cat_slug']}}/{{$category['cat_id']}}">
                     <span class="cate-img"><img src="{{ $cat_img_path.'/'.$category['cat_img']}}" alt="" height="30px" width="30px" /></span>
                     <span class="cate-txt">{{ ucfirst($category['title'])}}</span>
                     <span class="cate-count">
                      @foreach($sub_category as $subcategory)
                     <?php
                      if($subcategory['parent']==$category['cat_id'])
                           {
                               if(array_key_exists($subcategory['cat_id'],$category_business))
                                    {
                                       if($count==0)
                                       {
                                            $count=$category_business[$subcategory['cat_id']];
                                       }
                                       else
                                       {
                                              $count=$count+$category_business[$subcategory['cat_id']];
                                       }
                                    }
                           }
                      ?>
                      @endforeach
                      <?php //echo '('.$count.')';?>
                    </span>
                     </a>
                  </li>

                  @endforeach
                  @endif
                  <!-- <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img2.png" alt="" /></span>
                     <span class="cate-txt">Security Services</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img3.png" alt="" /></span>
                     <span class="cate-txt">Hotels &amp; Restaurants</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li class="mar-none">
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img4.png" alt="" /></span>
                     <span class="cate-txt">Motor Garage</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img5.png" alt="" /></span>
                     <span class="cate-txt">Security Services</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img6.png" alt="" /></span>
                     <span class="cate-txt">Real Eastat</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img7.png" alt="" /></span>
                     <span class="cate-txt">Plumber</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li class="mar-none">
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img8.png" alt="" /></span>
                     <span class="cate-txt">Pest Control</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img9.png" alt="" /></span>
                     <span class="cate-txt">Printing Services</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img10.png" alt="" /></span>
                     <span class="cate-txt">Housekeeping</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img11.png" alt="" /></span>
                     <span class="cate-txt">Packers &amp; Movers</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li class="mar-none">
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img12.png" alt="" /></span>
                     <span class="cate-txt">Mobile Shopee</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img1.png" alt="" /></span>
                     <span class="cate-txt">Hospital</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img2.png" alt="" /></span>
                     <span class="cate-txt">Security Services</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img3.png" alt="" /></span>
                     <span class="cate-txt">Hotels &amp; Restaurants</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li class="mar-none">
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img4.png" alt="" /></span>
                     <span class="cate-txt">Motor Garage</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img5.png" alt="" /></span>
                     <span class="cate-txt">Security Services</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img6.png" alt="" /></span>
                     <span class="cate-txt">Real Eastat</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img7.png" alt="" /></span>
                     <span class="cate-txt">Plumber</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li>
                  <li class="mar-none">
                     <a href="#">
                     <span class="cate-img"><img src="{{ url('/') }}/assets/front/images/cate-img8.png" alt="" /></span>
                     <span class="cate-txt">Pest Control</span>
                     <span class="cate-count">( 14 )</span>
                     </a>
                  </li> -->
               </ul>
               <div class="clearfix"></div>
            </div>
            <div class="all-cate-btn browse_all_cat">
               <button> Browse All Categories</button>
            </div>
         </div>
      </div>
      <div class="explore-category">
         <div class="container">
            <div class="exp-category-head">
               <h3>Explore Directory Category</h3>
               <span></span>
            </div>
            <div class="cate-content">
               Lorem Ipsum is simply dummy text of the printing and typesetting industry.
               Lorem Ipsum has been the
            </div>
            <div class="cate-btns">
               <ul>
                  <li><a href="#">ALL</a></li>
                  <li><a href="#" class="acti">Restaurant</a></li>
                  <li><a href="#">Automobile</a></li>
                  <li><a href="#">Entertaiment</a></li>
                  <li><a href="#">Hospitals</a></li>
                  <li><a href="#">car rental</a></li>
               </ul>
               <div class="clearfix"></div>
            </div>
            <div class="row">
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img class="over-img" alt="" src="{{ url('/') }}/assets/front/images/rest-img1.png">
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img alt="" src="{{ url('/') }}/assets/front/images/cate-address.png"> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img alt="" src="{{ url('/') }}/assets/front/images/cate-address.png"> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img class="over-img" alt="" src="{{ url('/') }}/assets/front/images/rest-img1.png">
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img alt="" src="{{ url('/') }}/assets/front/images/cate-address.png"> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img alt="" src="{{ url('/') }}/assets/front/images/cate-address.png"> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img1.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img3.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img1.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img2.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img1.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">
                  <div class="first-cate-img">
                     <img src="{{ url('/') }}/assets/front/images/rest-img3.png" alt="" class="over-img" />
                  </div>
                  <div class="first-cate-white">
                     <div class="f1_container">
                        <div class="f1_card shadow">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                        <div class="back face center">
                           <div class="cate-addre-block-two front face"><img src="{{ url('/') }}/assets/front/images/cate-address.png" alt="" /> </div>
                        </div>
                     </div>
                     <div class="resta-name">
                        <h6><a href="#">SSK Restaurant</a></h6>
                        <span></span>
                     </div>
                     <div class="resta-content">
                        2 Whitehall Cout,London SW1A
                        2Ej, United Kingdom
                     </div>
                     <div class="resta-rating-block">
                        <i class="fa fa-star star-acti"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                     </div>
                  </div>
               </div>
            </div>
            <div class="email-block">
               <div class="email-content">
                  Be A Part Of Our Family &amp; Get Everything In Your
                  Email Address
               </div>
               <div class="email-textbox">
                  <img src="{{ url('/') }}/assets/front/images/email-image.png" alt="" />
                  <input type="text" name="Email" placeholder="Enter Your Email Address" />
                  <button><i class="fa fa-paper-plane"></i></button>
               </div>
            </div>
            <div class="how-it-work-block">
               <div class="category-head how-it">
                  <h3>How It Work</h3>
                  <span></span>
               </div>
               <div class="row">
                  <div class="col-sm-4 col-md-4 col-lg-4">
                     <div class="what-to-do">
                        <div class="f1_container-tow">
                           <div class="f1_card shadow">
                              <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img1.png" alt="" /> </div>
                           </div>
                        </div>
                        <h4><a href="#">Choose What To Do</a></h4>
                        <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
                     </div>
                  </div>
                  <div class="col-sm-4 col-md-4 col-lg-4">
                     <div class="what-to-do">
                        <div class="f1_container-tow">
                           <div class="f1_card shadow">
                              <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img2.png" alt="" /></div>
                           </div>
                        </div>
                        <h4><a href="#">Find What You Want</a></h4>
                        <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
                     </div>
                  </div>
                  <div class="col-sm-4 col-md-4 col-lg-4">
                     <div class="what-to-do">
                        <div class="f1_container-tow">
                           <div class="f1_card shadow">
                              <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img3.png" alt="" /></div>
                           </div>
                        </div>
                        <h4><a href="#">Explore Amazing Places</a></h4>
                        <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
<script type="text/javascript">
   $('.browse_all_cat').click(function(){
   $('ul.category_list *').removeAttr('style');
   });
</script>
@endsection