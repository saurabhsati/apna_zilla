@extends('front.template.master')

@section('main_section')
@include('front.template._search_top_nav')

<div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here:</span>
  <li><a href="{{ url('/') }}">Home</a></li>
  <li class="active">Restaurants</li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">

            <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                <div class="categories_sect sidebar-nav">

                 <div class="sidebar-brand">Related Categories<span class="spe_mobile"><a href="#"></a></span></div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="spe_submobile">
                    <li class="brdr"><a href="#">Pizza Restaurants</a></li>
                  <li class="brdr"><a href="#">Mexican Restaurants</a></li>
                  <li class="brdr"><a href="#">Italian Restaurants</a></li>
                  <li class="brdr"><a href="#">Chinese Restaurants</a></li>
                  <li class="brdr"><a href="#">Japanese Restaurants</a></li>
                  <li class="brdr"><a href="#">Indian Restaurants</a></li>
                  <li class="brdr"><a href="#">Thai Restaurants</a></li>
                  <li class="brdr"><a href="#">Breakfast Restaurants </a></li>
                  <li class="brdr"><a href="#">Seafood Restaurants</a></li>
                  <li class="brdr"><a href="#">Fast Food Restaurants</a></li>
                  <li class="brdr"><a href="#">Grill Restaurants</a></li>
                  <li class="brdr"><a href="#">Sushi Restaurants</a></li>
                  <li class="brdr"><a href="#">Greek Restaurants</a></li>
                  <li class="brdr"><a href="#">Cafe Restaurants</a></li>
                  <li class="brdr1"><a href="#">French Restaurants</a></li>
                   <li class="brdr1"><a href="#">Korean Restaurants</a></li>
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>

             <div class="col-sm-12 col-md-9 col-lg-9">
             <div class="title_head">Restaurants</div>


                <div class="sorted_by">Sort By :</div>
              <div class="filter_div">
                 <ul>
                <li><a href="#">Most Recent </a></li>
                 <li><a href="#" class="active">Most Popular </a></li>
                 <li><a href="#">Alphabetical</a></li>
                </ul>
             </div>
            <!-- Product Lisitng Start -->

           @if(isset($arr_business) && sizeof($arr_business)>0)
            @foreach($arr_business as $restaurants)
             
                  <div class="product_list_view">
                   <div class="row">
                       <div class="col-sm-3 col-md-3 col-lg-4">
                          <div class="product_img"><img src="{{ url('/') }}/assets/front/images/list1.jpg" alt="list product"/></div>
                       </div>

                      <div class="col-sm-9 col-md-9 col-lg-8">
                      <div class="product_details">
                          <div class="product_title">
                            <a href="{{url('/').'/listing/details/'.base64_encode($restaurants['business_by_category']['id'])}}">
                              {{ $restaurants['business_by_category']['business_name'] }}
                            </a>
                          </div>

                          <div class="rating_star">
                              <img src="{{ url('/') }}/assets/front/images/rating.jpg" alt="rating"/> 10 Ratings <span class=""> Estd.in {{ $restaurants['business_by_category']['establish_year'] }} </span></div>
                          <div class="p_details"><i class="fa fa-phone"></i><span> {{ $restaurants['business_by_category']['landline_number'] }} &nbsp; {{ $restaurants['business_by_category']['mobile_number'] }}</span></div>
                          <div class="p_details"><i class="fa fa-map-marker"></i> 
                            <span>{{ $restaurants['business_by_category']['building'] }} &nbsp; {{ $restaurants['business_by_category']['street'] }} <br/>
                                  {{ $restaurants['business_by_category']['landmark'] }} &nbsp; {{ $restaurants['business_by_category']['area'] }} &nbsp;{{ '-'.$restaurants['business_by_category']['pincode'] }}<br/>
                                  </span></div>
                          <div class="p_details"><a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                            <ul>
                                <li><a href="#">SMS/Email</a></li>
                                <li><a href="#" class="active">Edit</a></li>
                                <li><a href="#">Own This</a></li>
                                <li><a href="#" class="lst">Rate This</a></li>
                            </ul>
                          </div>
                          </div>

                      </div>
                      </div>
                 </div>
            
            @endforeach
           @else
                <span>No Restaurant Available</span>
           @endif
          
          <!--Product Lisiting End  -->

             </div>
         </div>
       </div>

      </div>
@endsection
