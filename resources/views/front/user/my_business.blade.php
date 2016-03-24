@extends('front.template.master')

@section('main_section')

<div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here:</span>
  <li><a href="{{ url('/').'/front_users/profile' }}">Home</a></li>
  <li class="active">{{ $cat_title }}</li>
  
</ol>
             </div>
          </div>
     </div>
     <hr/>
     
       <div class="container">
         <div class="row">
             
            <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                <!-- <div class="categories_sect sidebar-nav">
              
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
                <div class="clearfix"></div>
              </div> -->
            </div>
             
             <div class="col-sm-12 col-md-9 col-lg-9">
             <div class="title_head">{{ $cat_title }}</div>
                        
                <!-- <div class="sorted_by">Sort By :</div>
                <div class="filter_div">
                 <ul>
                  <li><a href="#">Most Recent </a></li>
                  <li><a href="#" class="active">Most Popular </a></li>
                  <li><a href="#">Alphabetical</a></li>     
                 </ul>  
               </div> -->  

             <?php
             $no_of_business = count($arr_business_info);
             ?>

             @for($business=1;$business<=$no_of_business;$business++)
                        
                @foreach($arr_business_info as $business) 

                <div class="product_list_view">
            <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-4">
                    <div class="product_img"><img style="height:200px;" src="{{ url('/') }}/uploads/business/main_image/{{ $business['main_image'] }}" alt="list product"/></div>
                 </div>
                <div class="col-sm-9 col-md-9 col-lg-8">
                <div class="product_details">
                    <div class="product_title"><a href="#">{{$business['business_name']}}</a></div>
                    <div class="rating_star"><img src="images/rating.jpg" alt="rating"/> 10 Ratings <span class=""> Estd.in {{ $business['establish_year'] }} </span></div>
                    <div class="p_details"><i class="fa fa-phone"></i><span>  {{$business['mobile_number']}}, {{$business['landline_number']}}</span></div>
                    <div class="p_details"><i class="fa fa-map-marker"></i> <span>{{$business['building']}}, {{$business['street']}} <br/>  
                    {{$business['landmark']}}, {{$business['area']}} <br/> </span></div>
                    <div class="p_details"><a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                    <ul>
                    <!-- <li><a href="#">SMS/Email</a></li>  -->
                    <li><a href="{{ url('/front_users/edit_business/'.base64_encode($business['id'])) }}" class="active">Edit</a></li>    
                    <!-- <li><a href="#">Own This</a></li>     -->
                    <!-- <li><a href="#" class="lst">Rate This</a></li>         -->
                    </ul>
                    </div>
                    </div>
                
                </div>
                </div>
                 </div> 

                 @endforeach

               @endfor

            </div>
         </div>
       </div>
   </div>      

@stop