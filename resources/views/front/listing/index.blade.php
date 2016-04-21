  @extends('front.template.master')

  @section('main_section')
  @include('front.template._search_top_nav')
<style>
    .fixed-height {
      padding: 1px;
      max-height: 200px;
      overflow: auto;
      position:fixed;
    }

  .remo_fav span{
    color: #f9a820 !important;
  }
  .remo_fav i{
    color: #f9a820 !important;
  }




  </style>

   <?php
  // echo "<pre>";
  // print_r($arr_business);
  // exit();
  ?>
  <div class="gry_container">
    <div class="container">
     <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
       <ol class="breadcrumb">
         <span>You are here:</span>
         <li><a href="{{ url('/') }}">Home</a></li>
         <li class="active"><?php if(sizeof($parent_category)>0 && (sizeof($sub_category)>0)){echo $parent_category[0]['title'].' :: '.$sub_category[0]['title'];} ?></li>
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
        <?php

           //die;
        ?>
        @if(isset($arr_sub_cat) && sizeof($arr_sub_cat)>0)
        @foreach($arr_sub_cat as $category)
        <?php  $current_cat=explode('-',Request::segment(3));
        if(isset($current_cat)){
         if($current_cat[1]!=$category['cat_id']){
          ?>
          <li class="brdr"><a href="{{ url('/') }}/{{$city}}/all-options/ct-{{$category['cat_id']}}">{{ $category['title'] }}</a></li>
          <?php }
           }?>
          @endforeach
          @else
            <li class="brdr"><?php echo "No Records Available"; ?></li>
          @endif

        </ul>
        <!-- Categories End-->
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="col-sm-12 col-md-9 col-lg-9">
     <div class="title_head"><?php if(sizeof($parent_category)>0 && (sizeof($sub_category)>0)){echo $sub_category[0]['title'].' '.$parent_category[0]['title'];} ?></div>


     <div class="sorted_by">Sort By :</div>
     <div class="filter_div">
       <ul>

        <li><a href="javascript:void(0);"  class="<?php if( !Session::has('review_rating') && !Session::has('location_latitude') ){echo"active";} ?>" onclick="clearRating();">Most Popular </a></li>
        <li>
          <a   href="javascript:void(0);" data-toggle="modal" class="<?php if(Session::has('location_latitude')){echo"active";} ?>"  data-target="#loc">Location</a>
        </li>

        <li id="distance" style="cursor:pointer;" class="new_new_act1 <?php if(Session::has('distance')){echo 'open';}?>">
         <a onclick="#" href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Distance <span class="caret"></span></a>

        <?php
        if(Session::has('search_city_title'))
        {
           $city=Session::get('search_city_title');
        }
        else if(Session::has('city'))
        {
           $city=Session::get('city');
        }
        else
        {
           $city="Mumbai";
        }
        $category_search='';
        if(sizeof($sub_category)>0){
        if($sub_category[0]['title']!='')
        {
          $category_search=str_slug($sub_category[0]['title']);

           //$category_id=Session::get('category_id');
         }

       }
       else
       {
        $category_search='';
       }
          /*else {$category_id="";}*/
          if(!empty($loc)){
               $location=str_replace(' ','-',strtolower($loc));
             }
          else
               { $location="";}

             ?>
         <ul class="dropdown-menu distance_dropdown" aria-labelledby="dropdownMenu1">
           <li><a href="#" class="<?php if(Session::has('distance')){if(Session::get('distance')==1){echo 'active';}}?>" onclick="return setdistance('<?php echo $city;?>','1','<?php echo $category_search;?>','<?php echo $location;?>');">1 km</a></li>
           <li><a href="#" class="<?php if(Session::has('distance')){if(Session::get('distance')==2){echo 'active';}}?>"onclick="return setdistance('<?php echo $city;?>','2','<?php echo $category_search;?>','<?php echo $location;?>');">2 km</a></li>
           <li><a href="#" class="<?php if(Session::has('distance')){if(Session::get('distance')==3){echo 'active';}}?>"onclick="return setdistance('<?php echo $city;?>','3','<?php echo $category_search;?>','<?php echo $location;?>');">3 km</a></li>
           <li><a href="#" class="<?php if(Session::has('distance')){if(Session::get('distance')==4){echo 'active';}}?>"onclick="return setdistance('<?php echo $city;?>','4','<?php echo $category_search;?>','<?php echo $location;?>');">4 km</a></li>

         </ul>

       </li>
      <input type="hidden" name="current_url" value="{{ url('/') }}/{{$city}}/all-options/ct-@if(isset($category['cat_id'])){{$category['cat_id']}}@else{{0}}@endif">
       <li><a href="javascript:void(0);" class="<?php if( Session::has('review_rating')){echo"active";} ?>" <?php if(Session::has('review_rating')){ ?>onclick="javascript:void(0);" <?php }else{ ?>onclick="orderByRating();" <?php } ?>>Ratings <span><i class="fa fa-long-arrow-up"></i></span></a></li>

       <li>
         <div class="btn-group btn-input clearfix">
          <button type="button" class="btn_drop_nw dropdown-toggle form-control" data-toggle="dropdown">
            <span data-bind="label">View</span><span class="caret"></span></button>
            <ul class="dropdown-menu main" role="menu">
              <li><a href="javascript:void(0);" id="list_click">List</a></li>
              <li><a href="javascript:void(0);" id="grid_click">Grid</a></li>

            </ul>
          </div>
        </li>
      </ul>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="loc" role="dialog">
      <div class="modal-dialog">
{{ csrf_token() }}
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sort By Location</h4>
          </div>
          <div class="modal-body">
            <p>Where in  <?php
             if(Session::has('search_city_title')){
               echo Session::get('search_city_title');
               }
               else{
                echo $city;
               }?>

            </p>
            <div class="row">
              <div class="col-lg-10">
              <input type="text" class="input-searchbx " id="location_search"
              @if(!empty($loc))
               value="{{ucwords($loc)}}"
               @else
                value=""
               @endif/>
              <input type="hidden" class="input-searchbx " id="business_search_by_location"
                @if(!empty($loc))
               value="{{ucwords($loc)}}"
               @else
                value=""
               @endif
               />
               <input type="hidden" class="input-searchbx " id="business_search_by_city"
               @if(Session::has('search_city_title'))
               value="{{Session::get('search_city_title')}}"
               @else
                value="{{Session::get('city')}}"
               @endif
                />
                 <input type="hidden" class="input-searchbx " id="location_latitude"
               @if(Session::has('location_latitude'))
               value="{{Session::get('location_latitude')}}"
               @endif
               />
                 <input type="hidden" class="input-searchbx " id="location_longitude"
               @if(Session::has('location_longitude'))
               value="{{Session::get('location_longitude')}}"
               @endif
                />

              @if(isset($sub_category))
               <input type="hidden" class="input-searchbx " id="search_under_category" value="@if(isset($sub_category[0]['title'])){{str_slug($sub_category[0]['title'])}}@endif" />
               @endif
               </div>

              <div class="col-lg-2"> <button type="submit" class="btn btn-warning" id="go_to_search">Go</button></div>
              <div class="clr"></div></div>
            </div>
          </div>

        </div>
        <div class="clr"></div>
      </div>

         <!-- SEND SMS POPUP START-->
         @if(isset($arr_business) && sizeof($arr_business)>0)
            @foreach($arr_business as $restaurants)
            <div class="modal fade" id="sms-{{ $restaurants['id'] }}" role="dialog">
          <div class="modal-dialog">
           <!-- Modal content-->
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
             <div class="modal-body">
             <form class="form-horizontal"
                                    id="validation-form"
                                    method="POST"
                                    action="{{ url('/listing/send_sms/') }}"
                                    enctype="multipart/form-data"
                                    >
                {{ csrf_field() }}



                <b class="head-t">Get information by SMS/Email</b>
                 <p class="in-li">Enter the details below and click on SEND</p>
                  <div class="soc-menu-top">
                      <div class="col-lg-11">
                  <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Name</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                               <input type="text" placeholder="Enter Name"   id="name-{{ $restaurants['id'] }}" name="name-{{ $restaurants['id'] }}" class="input_acct">
                                 <div class="error_msg" id="err_name-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>



                  <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Mobile</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                              <div class="input-group">
                              <span id="basic-addon1" class="input-group-addon">+91</span>
                              <input type="text" required="" aria-describedby="basic-addon1" id="sms_mobile_no-{{ $restaurants['id'] }}" name="sms_mobile_no-{{ $restaurants['id'] }}" placeholder="Mobile" class="form-control">

                              </div>
                                <div class="error_msg" id="err_sms_mobile_no-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>


                      <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Email</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                               <input type="text" placeholder="Enter Email" name="email-{{ $restaurants['id'] }}" id="email-{{ $restaurants['id'] }}" class="input_acct">
                                <div class="error_msg" id="err_email-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>
                          <div class="clr"></div>
                             <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">&nbsp;</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <div class="submit-btn">
                          <input type="hidden" id="business_id-{{ $restaurants['id'] }}" name="business_id-{{ $restaurants['id'] }}" value="{{ $restaurants['id'] }}">
                           <button type="button" name="send_sms" id="send_sms" onclick="Send_SMS({{ $restaurants['id'] }})">Send</button>
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
          <!-- SEND SMS POPUP END -->
         @endforeach
        @endif



    <!-- location popup end -->

    <div id="list_view">
      @if(isset($arr_business) && sizeof($arr_business)>0)

      @foreach($arr_business as $restaurants)

      <div class="product_list_view" >
       <div class="row">
         <div class="col-sm-3 col-md-3 col-lg-4">
          <div class="product_img">
          <img style="height: 100% !important;" class="over-img" src="{{ get_resized_image_path($restaurants['main_image'],$main_image_path,205,270) }}" alt="list product"/>
                    @if($restaurants['is_verified']==1)<img class="product-like-icon" src="{{ url('/') }}/assets/front/images/verified_2.png" alt="write_review"/>@endif
          </div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-8">
          <div class="product_details">
            <div class="product_title">
            <?php
             $slug_business=str_slug($restaurants['business_name']);
             $slug_area=str_slug($restaurants['area']);
             $business_area=$slug_business.'@'.$slug_area;
            ?>
            <a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}">
            @if($restaurants['is_verified']==1)
            <img src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
                {{ $restaurants['business_name'] }}
              </a>

            </div>

            <div class="rating_star">

              <?php
              if(sizeof($restaurants['reviews']))
              {
                $tot_review=sizeof($restaurants['reviews']);

              }
              else
              {
                 $tot_review=0;
              }
              ?>


              <div class="resta-rating-block11">
              <?php for($i=0;$i<round($restaurants['avg_rating']);$i++){ ?>
              <i class="fa fa-star star-acti"></i>
              <?php }?>
              <?php for($i=0;$i<(5-round($restaurants['avg_rating']));$i++){ ?>
              <i class="fa fa-star"></i>
                <?php }?>
                </div>
               &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings
              <span class=""> Estd.in {{ $restaurants['establish_year'] }} </span></div>
              <div class="p_details"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
              <div class="p_details"><i class="fa fa-map-marker"></i>
                <span>{{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}<br/>

               @if(Session::has('distance'))
               Away From {{Session::get('distance')}} km distance
                @endif

                </span>
                </div>

                <input type="hidden"  id="business_id" value="{{ $restaurants['id'] }}"  />

                  <div class="p_details" >
                    @if(Session::has('user_mail'))
                    <?php
                    if(isset($arr_fav_business) && count($arr_fav_business)>0 )
                    {
                      if(in_array($restaurants['id'], $arr_fav_business))
                      {
                    ?>  <span class="remo_fav" id="{{ 'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);" class="active" onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Remove favorite</span></a>
                        </span>
                    <?php
                      }
                      else
                      {
                    ?>
                        <span id="{{'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favorite</span></a>
                        </span>
                    <?php
                      }
                    }
                    else{
                      ?>
                         <span id="{{'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favorite</span></a>
                        </span>
                      <?php
                    }
                    ?>
                      <!-- <span id="{{-- 'show_fav_status_'.$restaurants['id'] --}}" style="width: 175px;">
                      <a href="javascript:void(0);"  onclick="add_to_favourite('{{--$restaurants['id']--}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favourite</span></a>
                      </span> -->

                    @else
                    <span>
                      <a href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                      </span>
                    @endif

                    <ul>
                      <li><a data-toggle="modal" data-target="#sms-{{ $restaurants['id'] }}" href="#">SMS/Email</a></li>
                      <li><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}" class="lst">Rate This</a></li>
                    </ul>
                </div>
              </div>

            </div>
          </div>

        </div>




        @endforeach
        @else

      <span>No Records Available</span>
         @endif
      </div>

      <!--Product Grid Start  -->
      <div  id="grid_view" style="display: none;">
          <div class="row">
 @if(isset($arr_business) && sizeof($arr_business)>0)
      @foreach($arr_business as $restaurants)
  <div class="col-sm-6 col-md-6 col-lg-6">
                         <div class="product_grid_view">
                  <div class="p_images">
                     <div class="grid_product">
                       <?php
                       $slug_business=str_slug($restaurants['business_name']);
                       $slug_area=str_slug($restaurants['area']);
                       $business_area=$slug_business.'@'.$slug_area;
                      ?>
                      <div class="name-grid"><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}">{{ $restaurants['business_name'] }}</a></div>
                        <?php $reviews=0; ?>
                        @if(isset($restaurants['reviews']) && sizeof($restaurants['reviews'])>0)
                        @foreach($restaurants['reviews'] as $review)
                        <?php  $reviews=$reviews+$review['ratings'] ?>
                        @endforeach
                        @endif
                        <?php
                        if(sizeof($restaurants['reviews']))
                        {
                          $tot_review=sizeof($restaurants['reviews']);
                          $avg_review=($reviews/$tot_review);
                        }
                        else
                        {
                          $avg_review= $tot_review=0;
                        }
                        ?>
                       <div class="rating_star"><img src="{{ url('/') }}/assets/front/images/rating-4.png" alt="rating" width="73"/>
                        <span> &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings</span>
                       </div>


                     @if(Session::has('user_mail'))
                    <?php
                    if(isset($arr_fav_business) && count($arr_fav_business)>0 )
                    {
                      if(in_array($restaurants['id'], $arr_fav_business))
                      {
                    ?>  <span class="remo_fav" id="{{ 'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Remove favourite"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Remove favorite</span></i></a>
                        </span>
                    <?php
                      }
                      else
                      {
                    ?>
                        <span id="{{'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Add to favorites"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Add to favorite</span></i></a>
                        </span>
                    <?php
                      }
                    }
                    else{
                      ?>
                         <span id="{{'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Add to favorites"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Add to favorite</span></i></a>
                        </span>
                      <?php
                    }
                    ?>
                      <!-- <span id="{{-- 'show_fav_status_'.$restaurants['id'] --}}" style="width: 175px;">
                      <a href="javascript:void(0);"  onclick="add_to_favourite('{{--$restaurants['id']--}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favourite</span></a>
                      </span> -->

                    @else
                    <span>
                      <a href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" style="border-right:0;display:inline-block;"
                      ><i class="fa fa-heart"></i><span> </span></a>
                      </span>
                    @endif



                       <!--  <a href="#" style="border-right:0;display:inline-block;" data-toggle="tooltip" title="Add to favorites"><i class="fa fa-heart"></i><span> </span>
                        </a> -->



                        </div>
                       <img src="{{get_resized_image_path($restaurants['main_image'],$main_image_path,205,270) }}" alt="product img" >
                        @if($restaurants['is_verified']==1)<img class="product-like-icon" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
                    </div>


                <div class="p_list_details">
                   <div class="list-product"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
                       <div class="list-product"><i class="fa fa-map-marker"></i><span>{{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                  {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}</span>  </div>

                  <div class="p_details"><!--<a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>-->
                    <ul>
                    <li><a data-toggle="modal" data-target="#sms-{{ $restaurants['id'] }}" href="#">SMS/Email</a></li>
                   <!--  <li><a href="#" class="active">Edit</a></li>
                    <li><a href="#">Own This</a></li> -->
                    <li><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}" class="lst">Rate This</a></li>
                    </ul>
                    </div>
                    </div>

                </div>
                </div>





@endforeach
@else
<span>No Records Available</span>
@endif
</div>



</div>

<!--Product Lisiting End  -->


</div>
</div>
</div>

</div>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>-->

<script type="text/javascript">

  var site_url = "{{ url('/') }}";
  var csrf_token = "{{ csrf_token() }}";

 $(document).ready(function()
  {
    //search by location
        $("#location_search").autocomplete(
                {
                  minLength:3,
                  source:site_url+"/get_location_auto",
                  search: function( event, ui )
                  {
                   /* if(category==false)
                    {
                        alert("Select Category First");
                        event.preventDefault();
                        return false;
                    }*/
                  },
                   select:function(event,ui)
                  {


                    $("input[name='location_search']").val(ui.item.label);
                    $("#business_search_by_location").attr('value',ui.item.loc_slug);
                    $("#location_search").attr('value',ui.item.loc);
                    $('#location_latitude').attr('value',ui.item.loc_lat);
                    $('#location_longitude').attr('value',ui.item.loc_lng);

                  },
                  response: function (event, ui)
                  {
                    $('.ui-autocomplete').css({
                      'position': 'fixed'

                  });
                  }
                });




      });

         //droupdown//

         $( document.body ).on( 'click', '.distance_dropdown li', function( event ) {

           var select_location=$('#business_search_by_location').val();
           if(select_location=='')
           {
             // open location model popup
            // $('.modal-open').open();
             $('#loc').modal('toggle');

           }
           else
           {
             var $target = $( event.currentTarget );
             $target.closest( '.btn-group' )
             .find( '[data-bind="label"]' ).text( $target.text() )
             .end()
             .children( '.dropdown-toggle' ).dropdown( 'toggle' );
             return false;
          }

         });


         $(function() {
          $('#list_click').click(function() {
            $('#grid_view').hide();
            $('#list_view').show();
          });
          $('#grid_click').click(function() {
            $('#list_view').hide();
            $('#grid_view').show();
          });



        })
         $(document.body).on( 'click', '#go_to_search', function( event )
        {
         var business_search_by_location=$("#business_search_by_location").val();
         var search_under_category=$("#search_under_category").val();
         var search_under_city=$("#business_search_by_city").val();
         var session_city="{{Session::get('city')}}";
         var loc_lat=$("#location_latitude").val();
         var loc_lng=$("#location_longitude").val();

         if(search_under_city!='')
         {
          var city=search_under_city;
         }
          else if(session_city!='')
         {
          var city=session_city;
         }
         else
         {
            var city="Mumbai";
         }

         var category_id=$("#category_id").val();
         if(business_search_by_location=='')
          {
              alert("Select Location");
              event.preventDefault();
              return false;
          }
          else
          {
            if(loc_lat!='' && loc_lng!='')
           {


            var fromData = {
                            lat:loc_lat,
                            lng:loc_lng,
                            _token:csrf_token
                              };
                          $.ajax({
                             url: site_url+"/set_location_lat_lng",
                             type: 'POST',
                             data: fromData,
                             dataType: 'json',
                             async: false,

                             success: function(response)
                             {
                               if (response.status == "1") {
                                  var get_url=site_url+'/'+city+'/'+search_under_category+'@'+business_search_by_location+'/'+'ct-'+category_id;
                                  //alert(get_url);
                                  window.location.href = get_url;
                               }
                               return false;
                             }
                         });

             }
          }
        });

        function setdistance(city,distance,category,location)
        {
             var business_search_by_location=location;
             var search_under_category=category;
             var search_under_city=city;
             var distance=distance;
             var session_city="{{Session::get('city')}}";
             if(search_under_city!='')
             {
              var city=search_under_city;
             }
              else if(session_city!='')
             {
              var city=session_city;
             }
             else
             {
                var city="Mumbai";
             }
             var category_id=$("#category_id").val();
             if(business_search_by_location=='')
              {
                  alert("Select Location");
                  event.preventDefault();
                  return false;
              }
              else
              {
                var fromData = {
                                business_search_by_location:business_search_by_location,
                                search_under_category:search_under_category,
                                search_under_city:search_under_city,
                                distance:distance,
                                _token:csrf_token
                                  };
                              $.ajax({
                                 url: site_url+"/set_distance_range",
                                 type: 'POST',
                                 data: fromData,
                                 dataType: 'json',
                                 async: false,

                                 success: function(response)
                                 {
                                   if (response.status == "1") {

                                     var get_url=site_url+'/'+city+'/'+search_under_category+'@'+business_search_by_location+'/'+'ct-'+category_id;
                                     window.location.href = get_url;
                                    //window.location.href = location.href;
                                   }
                                   return false;
                                 }
                             });
               }

        }

        function orderByRating()
        {
                    var fromData = { _token:csrf_token
                              };
                    $.ajax({
                             url: site_url+"/set_rating",
                             type: 'POST',
                             dataType: 'json',
                             data: fromData,
                             async: false,
                             success: function(response)
                             {
                               if (response.status == "1") {
                                  var current_url = $(location).attr('href');
                                  window.location.href=current_url;
                              }
                             }

                         });
        }
        function clearRating()
        {
                    var fromData = { _token:csrf_token
                              };
                    $.ajax({
                             url: site_url+"/clear_rating",
                             type: 'POST',
                             dataType: 'json',
                             data: fromData,
                             async: false,
                             success: function(response)
                             {
                               if (response.status == "1") {
                                  var current_url = $(location).attr('href');
                                  window.location.href=current_url;
                              }
                             }

                         });
        }


        function add_to_favourite(ref)
        {
          var business_id = ref;
          var user_mail   = "{{ session::get('user_mail') }}";

          var data        = { business_id:business_id, user_mail:user_mail ,_token:csrf_token };
          jQuery.ajax({
            url:site_url+'/listing/add_to_favourite',
            type:'POST',
            dataType:'json',
            data: data,
            success:function(response){

              if(response.status == "favorites")
              {
                 jQuery('#show_fav_status_'+ref+'').addClass("remo_fav");
                var str = '<a href="javascript:void(0);"  onclick="add_to_favourite('+ref+')" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Remove favorite</span></a>';
                jQuery('#show_fav_status_'+ref+'').html(str);
              }

              if(response.status=="un_favorites")
              {
                 jQuery('#show_fav_status_'+ref+'').removeClass("remo_fav");
                 var str = '<a href="javascript:void(0);"  onclick="add_to_favourite('+ref+')" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span>Add To favorite</span></a>';
                jQuery('#show_fav_status_'+ref+'').html(str);

              }

            }
          });
        }


        function add_to_favourite_grid(ref)
        {
          var business_id = ref;
          var user_mail   = "{{ session::get('user_mail') }}";
          var data        = { business_id:business_id, user_mail:user_mail ,_token:csrf_token };
          jQuery.ajax({
            url:site_url+'/listing/add_to_favourite',
            type:'POST',
            dataType:'json',
            data: data,
            success:function(response){

              if(response.status == "favorites")
              {
                jQuery('#show_fav_status_grid_'+ref+'').addClass("remo_fav");
                var str = '<a href="javascript:void(0);"  onclick="add_to_favourite_grid('+ref+')" style="border-right:0;display:inline-block;" data-toggle="tooltip" title="Remove favorite"><i class="fa fa-heart"></i><span>Remove favorite</span></a>';
                jQuery('#show_fav_status_grid_'+ref+'').html(str);
              }

              if(response.status=="un_favorites")
              {
                 jQuery('#show_fav_status_grid_'+ref+'').removeClass("remo_fav");
                 var str = '<a href="javascript:void(0);"  onclick="add_to_favourite_grid('+ref+')" style="border-right:0;display:inline-block;" data-toggle="tooltip" title="Add to favorites" ><i class="fa fa-heart"></i><span>Add To favorite</span></a>';
                jQuery('#show_fav_status_grid_'+ref+'').html(str);

              }

            }
          });
        }





     // });
        function Send_SMS(business_id)
        {
          var site_url   = "{{ url('/') }}";

          var business_id   = $('#business_id-'+business_id).val();
         // alert(business_id);
          var name = $('#name-'+business_id).val();
          var mobile  = $('#sms_mobile_no-'+business_id).val();
          var email   = $('#email-'+business_id).val();
          var token      = jQuery("input[name=_token]").val();
           var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;

             if(name.trim()=='')
             {
                  $('#err_name-'+business_id).html('Enter Your Name.');
                  $('#err_name-'+business_id).show();
                  $('#name-'+business_id).focus();
                  $('#name-'+business_id).on('keyup', function(){
                  $('#err_name-'+business_id).hide();
              });
             }
             else if(mobile.trim()=='')
             {
               $('#err_sms_mobile_no-'+business_id).html('Enter Your Mobile Number.');
                  $('#err_sms_mobile_no-'+business_id).show();
                  $('#sms_mobile_no-'+business_id).focus();
                  $('#sms_mobile_no-'+business_id).on('keyup', function(){
                  $('#err_sms_mobile_no-'+business_id).hide();
              });
             }
             else if(isNaN(mobile))
             {
               $('#err_sms_mobile_no-'+business_id).html('Enter Valid Mobile Number.');
                  $('#err_sms_mobile_no-'+business_id).show();
                  $('#sms_mobile_no-'+business_id).focus();
                  $('#sms_mobile_no-'+business_id).on('keyup', function(){
                  $('#err_sms_mobile_no-'+business_id).hide();
              });
             }
             else if(email.trim()=='')
             {
               $('#err_email-'+business_id).html('Enter Your Email Id.');
                  $('#err_email-'+business_id).show();
                  $('#email-'+business_id).focus();
                  $('#email-'+business_id).on('keyup', function(){
                  $('#err_email-'+business_id).hide();
              });
             }
             else if(!filter.test(email))
             {
                $('#err_email-'+business_id).html('Enter Valid Email Id.');
                  $('#err_email-'+business_id).show();
                  $('#email-'+business_id).focus();
                  $('#email-'+business_id).on('keyup', function(){
                  $('#err_email-'+business_id).hide();
              });
             }
             else
             {
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
        }

       </script>



      @endsection


