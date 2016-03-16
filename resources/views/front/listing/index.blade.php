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
                    <li class="brdr"><a href="{{ url('/') }}/city/all-options/ct-{{$category['cat_id']}}">{{ $category['title'] }}</a></li>
                    <?php } }?>
                  @endforeach
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
                   <!--  <span class="drpwn dn">
                                    <a onclick="#" id="dst1" class="" href="javascript:void(0);">1 km</a>
                                    <a onclick="#" id="dst2" class="" href="javascript:void(0);">2 km</a>
                                    <a onclick="#" id="dst3" class="" href="javascript:void(0);">3 km</a>
                                    <a onclick="#" id="dst4" class="" href="javascript:void(0);">4 km</a>
                                    <a onclick="#" id="dst5" class="" href="javascript:void(0);">5 km</a>
                    </span> -->

                  </li>
                  <li><a href="#" class="active">Ratings </a></li>
                  <li>
                     <div class="btn-group btn-input clearfix">
                      <button type="button" class="btn_drop_nw dropdown-toggle form-control" data-toggle="dropdown">
                      <span data-bind="label">List</span><span class="caret"></span></button>
                    <ul class="dropdown-menu main" role="menu">
                      <li><a href="#">List</a></li>
                      <li><a href="#">Image</a></li>

                    </ul>
                  </div> 
                  </li>
                </ul>
             </div>
            <!-- Product Lisitng Start -->
         <!--    <div class="messagepop pop">
             <section class="jpbg">
                <span class="jcl close">X</span>
                <h3>Sort By Location</h3>
                 <span class="jinp">
                  City :<input class="" type="text" name="city_name" id="city_name" value="" autocomplete="off" /><br/>
                  Location:<input class="" type="text" name="sortbylocation" id="sortbylocation" value="" autocomplete="" />
                  <input type="hidden" name="categoryid" id="categoryid" value="{{Request::segment(3)}}"/>
                  <span id="sbd" class="jauto dn"></span>
                </span>

              </section></form>
            </div> -->
  <!-- location popup start-->
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

          <p>Where in Mumbai</p>
          <div class="row">
          <div class="col-lg-10"><input type="text" class="input-searchbx"/></div>
         <div class="col-lg-2"> <button type="submit" class="btn btn-warning">Go</button></div>
         <div class="clr"></div>
        </div>
      </div>
        
      </div>
      <div class="clr"></div>
    </div>
  </div>
            <!-- location popup end -->


           @if(isset($arr_business) && sizeof($arr_business)>0)
            @foreach($arr_business as $restaurants)

                  <div class="product_list_view">
                   <div class="row">
                       <div class="col-sm-3 col-md-3 col-lg-4">
                          <div class="product_img"><img src="{{ url('/') }}/uploads/business/main_image/{{ $restaurants['business_by_category']['main_image'] }}" alt="list product"/></div>
                       </div>

                      <div class="col-sm-9 col-md-9 col-lg-8">
                      <div class="product_details">
                          <div class="product_title">
                            <a href="{{url('/').'/listing/details/'.base64_encode($restaurants['business_by_category']['id'])}}">
                              {{ $restaurants['business_by_category']['business_name'] }}
                            </a>
                          </div>

                          <div class="rating_star">
                          <?php $reviews=0; ?>
                          @if(isset($restaurants['business_rating']) && sizeof($restaurants['business_rating'])>0)
                           @foreach($restaurants['business_rating'] as $review)
                           <?php  $reviews=$reviews+$review['ratings'] ?>
                           @endforeach
                           @endif
                           <?php
                             if(sizeof($restaurants['business_rating']))
                             {
                                $tot_review=sizeof($restaurants['business_rating']);
                                $avg_review=($reviews/$tot_review);
                             }
                             else
                             {
                              $avg_review= $tot_review=0;
                             }
                           ?>

                          <!-- <img src="{{ url('/') }}/assets/front/images/star2.png" alt="rating"/> -->

                          <img src="{{ url('/') }}/assets/front/images/rating.jpg" alt="rating"/> &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings
                          <span class=""> Estd.in {{ $restaurants['business_by_category']['establish_year'] }} </span></div>
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
                <span>No Records Available</span>
           @endif

          <!--Product Lisiting End  -->

             </div>
         </div>
       </div>

      </div>
<style type="text/css">
  a.selected {
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#FFFFFF;
  border:1px solid #999999;
  cursor:default;
  display:none;
  margin-top: 15px;
  position:absolute;
  text-align:left;
  width:394px;
  z-index:50;
  padding: 25px 25px 20px;
}

label {
  display: block;
  margin-bottom: 3px;
  padding-left: 15px;
  text-indent: -15px;
}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}

</style>
<script type="text/javascript">
 var site_url = "{{ url('/') }}";
 var csrf_token = "{{ csrf_token() }}";
  function deselect(e) {
  $('.pop').slideFadeToggle(function() {
    e.removeClass('selected');
  });
}

$(function() {
  $('#location').on('click', function() {
    if($(this).hasClass('selected')) {
      deselect($(this));
    } else {
      $(this).addClass('selected');
      $('.pop').slideFadeToggle();
    }
    return false;
  });

  $('.close').on('click', function() {
    deselect($('#location'));
    return false;
  });
});

$.fn.slideFadeToggle = function(easing, callback) {
  return this.animate({ opacity: 'toggle', height: 'toggle' }, 'fast', easing, callback);
};


  if($("#sortbylocation").length>0)
         {
            $( "#sortbylocation" ).autocomplete({
                    //source: site_url+"/"+city_all+"/searchkey?_token="+csrf_token+'&range='+$('#reangval').val(),
                    source : function( request, response ) {
                                  city_name = $('#city_name').val();
                                  category_id = $('#category_id').val();
                                  request.city_name = city_name;
                                  request.category_id = category_id;
                                  $.getJSON( site_url+"/search?_token="+csrf_token, request, function( data, status, xhr ) {
                                              response( data );
                                           });
                              },
                    minLength: 2,
                    select: function( event, ui )
                    {
                        //window.location.href = ui.item.ui.item.href;
                        /* var zipcode = ui.item.zip;
                        var place = ui.item.place;
                        setPlace(zipcode,place);
                        return false; */
                    }
             }).data("ui-autocomplete")._renderItem = function (ul, item) {
             return $("<li></li>")
                 .data("item.autocomplete", item)
                 .append('<a href="'+item.link+'">' + item.label +'<span style="color:#7b7b7b"> '+item.cat_name+'</span></a>')
                 .appendTo(ul);
            };
         }

         //droupdown//

    $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

   var $target = $( event.currentTarget );

   $target.closest( '.btn-group' )
      .find( '[data-bind="label"]' ).text( $target.text() )
         .end()
      .children( '.dropdown-toggle' ).dropdown( 'toggle' );

   return false;

})
    </script>
</script>
@endsection


