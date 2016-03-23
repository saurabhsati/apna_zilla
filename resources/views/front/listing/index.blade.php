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
  </style>
  <div class="gry_container">
    <div class="container">
     <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
       <ol class="breadcrumb">
         <span>You are here:</span>
         <li><a href="{{ url('/') }}">Home</a></li>
         <li class="active"><?php if(isset($parent_category) &&(isset($sub_category))){echo $sub_category[0]['title'].' '.$parent_category[0]['title'];} ?></li>

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
        @if(isset($arr_sub_cat) && sizeof($arr_sub_cat)>0)
        @foreach($arr_sub_cat as $category)
        <?php  $current_cat=explode('-',Request::segment(3));
        if(isset($current_cat)){ if($current_cat[1]!=$category['cat_id']){
          ?>
          <li class="brdr"><a href="{{ url('/') }}/{{$city}}/all-options/ct-{{$category['cat_id']}}">{{ $category['title'] }}</a></li>
          <?php } }?>
          @endforeach
          @else
            <li class="brdr"><?php echo "No Records Available"; ?></li>
          @endif

        </ul>
        <!-- /#Categoriesr End-->
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="col-sm-12 col-md-9 col-lg-9">
     <div class="title_head"><?php if(isset($parent_category) && (isset($sub_category))){echo $sub_category[0]['title'].' '.$parent_category[0]['title'];} ?></div>


     <div class="sorted_by">Sort By :</div>
     <div class="filter_div">
       <ul>
        <li><a href="#" class="active">Most Popular </a></li>
        <li>
          <a class="act" data-toggle="modal" data-target="#loc">Location</a>
        </li>

        <li id="distance" style="cursor:pointer;" class="new_new_act1">
         <a onclick="#" href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Distance <span class="caret"></span></a>
         <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
           <li><a href="#">1 km</a></li>
           <li><a href="#">2 km</a></li>
           <li><a href="#">3 km</a></li>
           <li><a href="#">4 km</a></li>

         </ul>

       </li>
       <!-- <form action="{{ url('/') }}/{{$city}}/all-options/ct-{{$category['cat_id']}}" id="submit_form_list"> -->
       <input type="hidden" name="current_url" value="{{ url('/') }}/{{$city}}/all-options/ct-{{$category['cat_id']}}">
       <li><a href="#" class="active" onclick="submit_business();" >Ratings <span><i class="fa fa-long-arrow-up"></i></span></a></li>
       <!-- </form> -->
       <li>
         <div class="btn-group btn-input clearfix">
          <button type="button" class="btn_drop_nw dropdown-toggle form-control" data-toggle="dropdown">
            <span data-bind="label">List</span><span class="caret"></span></button>
            <ul class="dropdown-menu main" role="menu">
              <li><a href="#" id="list_click">List</a></li>
              <li><a href="#" id="grid_click">Image</a></li>

            </ul>
          </div>
        </li>
      </ul>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="loc" role="dialog">
      <div class="modal-dialog">

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
               }?>

            </p>
            <div class="row">
              <div class="col-lg-10">
              <input type="text" class="input-searchbx " id="location_search" />
              <input type="hidden" class="input-searchbx " id="business_search_by_location" value="" />
               <input type="hidden" class="input-searchbx " id="business_search_by_city"
               @if(Session::has('search_city_title'))
               value="{{Session::get('search_city_title')}}"
               @else
                value="{{Session::get('city')}}"
               @endif
                />

              @if(isset($sub_category))
               <input type="hidden" class="input-searchbx " id="search_under_category" value="{{str_slug($sub_category[0]['title'])}}" />
               @endif
               </div>

              <div class="col-lg-2"> <button type="submit" class="btn btn-warning" id="go_to_search">Go</button></div>
              <div class="clr"></div></div>
            </div>
          </div>

        </div>
        <div class="clr"></div>
      </div>

    <!-- location popup end -->

    <div id="list_view">
      @if(isset($arr_business) && sizeof($arr_business)>0)
      @foreach($arr_business as $restaurants)

      <div class="product_list_view" >
       <div class="row">
         <div class="col-sm-3 col-md-3 col-lg-4">
          <div class="product_img"><img src="{{ url('/') }}/uploads/business/main_image/{{ $restaurants['main_image'] }}" alt="list product"/></div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-8">
          <div class="product_details">
            <div class="product_title">
            <?php
             $slug_business=str_slug($restaurants['business_name']);
             $slug_area=str_slug($restaurants['area']);
             $business_area=$slug_business.'<near>'.$slug_area;
            ?>
            <a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}">
                {{ $restaurants['business_name'] }}
              </a>

            </div>

            <div class="rating_star">
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

              <!-- <img src="{{ url('/') }}/assets/front/images/star2.png" alt="rating"/> -->

              <img src="{{ url('/') }}/assets/front/images/rating.jpg" alt="rating"/> &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings
              <span class=""> Estd.in {{ $restaurants['establish_year'] }} </span></div>
              <div class="p_details"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
              <div class="p_details"><i class="fa fa-map-marker"></i>
                <span>{{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                  {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}<br/>
                </span></div>
                <div class="p_details"><a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                  <ul>
                    <li><a href="#">SMS/Email</a></li>
                    <li><a href="#" class="lst">Rate This</a></li>
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
                      <div class="name-grid"><a href="{{url('/').'/listing/details/'.base64_encode($restaurants['id'])}}">{{ $restaurants['business_name'] }}</a></div>
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
                       <div class="rating_star"><img src="{{ url('/') }}/assets/front/images/rating-4.png" alt="rating" width="73"/><span> &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings</span></div>
                        <a href="#" style="border-right:0;display:inline-block;" data-toggle="tooltip" title="Add to favorites"><i class="fa fa-heart"></i><span> </span></a>
                         </div>
                       <img src="{{ url('/') }}/uploads/business/main_image/{{ $restaurants['main_image'] }}" alt="product img" >

                    </div>


                <div class="p_list_details">
                   <div class="list-product"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
                       <div class="list-product"><i class="fa fa-map-marker"></i><span>{{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                  {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}</span>  </div>

                  <div class="p_details"><!--<a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>-->
                    <ul>
                    <li><a href="#">SMS/Email</a></li>
                   <!--  <li><a href="#" class="active">Edit</a></li>
                    <li><a href="#">Own This</a></li> -->
                    <li><a href="#" class="lst">Rate This</a></li>
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

                  },
                  response: function (event, ui)
                  {

                  }
                });




      });

         //droupdown//

         $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

           var $target = $( event.currentTarget );

           $target.closest( '.btn-group' )
           .find( '[data-bind="label"]' ).text( $target.text() )
           .end()
           .children( '.dropdown-toggle' ).dropdown( 'toggle' );

           return false;

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
         if(search_under_city!='')
         {
          var city=search_under_city;
         }
         else
         {
           var city="{{Session::get('city')}}";
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
            /*ww.justdial.com/Nashik/Indian-Restaurants-<near>-Nashik-Pune-Road-Dwarka/ct-10263652
            */ var get_url=site_url+'/'+city+'/'+search_under_category+'-<near>-'+business_search_by_location+'/'+'ct-'+category_id;
              window.location.href = get_url;
          }
        });
    function submit_business()
    {
      /*alert();
      var current_url=$("#current_url").val();
          var fromData = {rating:'DEASC',_token:csrf_token};
           $.get({
               url: current_url,
               type: 'get',
               data: fromData,
               dataType: 'json',
               async: false,

               success: function(response)
               {

               }
           });*/
    }
       </script>
     <!-- <style type="text/css">
 .ui-autocomplete
 {
    height: 125px;
    left: 478px;
    overflow-x: auto;
    position: fixed !important;
 }

</style>-->


       @endsection


