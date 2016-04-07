@extends('front.template.master')

@section('main_section')

<!--search area end here-->
 <div class="gry_container" style="padding: 7px 0 16px;">
     @include('front.deal.deal_top_bar')

       <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

                  <div class="delas">
                  <div id="dash_tab" style="background:#fff;padding:10px;">
                     <ul class="resp-tabs-list">
                        <li>Latest Deals</li>
                         <img class="dash_line" alt="line" src="{{ url('/')}}/assets/front/images/dash_menu_line.jpg">
                        <li>Maximum Discount</li>
                         <img class="dash_line" alt="line" src="{{ url('/')}}/assets/front/images/dash_menu_line.jpg">
                        <li data-toggle="modal" data-target="#loc_deal">Location</li>

                        <div class="clearfix"></div>
                     </ul>
                     <div class="resp-tabs-container" id="deal_result">
                     <!-- All Deals -->
                        <div>
                       <div class="row">
                       <?php //echo( 1 - ( 75 / 100 ))*100;
                      // echo round($deals['price']-(($deals['price'])*($deals['discount_price']/100)));
                       //echo round(30-((30)*(50/100)));
                       ?>

                     @if(sizeof($arr_deals_info)>0)
                          @foreach($arr_deals_info as $deals)
                             <div class="col-sm-6 col-md-3 col-lg-3">
                              <div class="dels">
                              <div class="deals-img"><span class="discount ribbon">{{$deals['discount_price'] }}%</span><img src="{{ url('/')}}/uploads/deal/{{$deals['deal_image']}}" alt="img" width="250" height="200" /></div>
                              <div class="deals-product">
                              <div class="deals-nm"><a href="{{url('/').'/deals/details/'.base64_encode($deals['id'])}}">{{ $deals['name'] }}</a></div>
                              <div class="online-spend"></div>
                                      <div class="price-box">
                                      <div class="price-new">£<?php echo round($deals['price']-(($deals['price'])*($deals['discount_price']/100)));?></div>
                                          <div class="price-old">£{{ $deals['price'] }} <!--| <span>offers 50% OFF</span>--></div>
                                          <div class="view"><a href="{{url('/').'/deals/details/'.base64_encode($deals['id'])}}" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                      </div>
                              </div>
                              </div>
                              </div>

                          @endforeach
                          @else
                          <span class="col-sm-3 col-md-3 col-lg-12">No Deals  Available.</span>
                          @endif
                      </div>
                     </div>
                <!--  max discount -->
                   <div>
                     <div class="row">
                      @if(sizeof($arr_deals_max_dis_info)>0)
                          @foreach($arr_deals_max_dis_info as $max_dis_deals)

                          <div class="col-sm-6 col-md-3 col-lg-3">
                          <div class="dels">
                          <div class="deals-img"><span class="discount ribbon">{{$max_dis_deals['discount_price'] }}%</span><img src="{{ url('/')}}/uploads/deal/{{$max_dis_deals['deal_image']}}" alt="img" width="250" height="200" /></div>
                          <div class="deals-product">
                          <div class="deals-nm"><a href="{{url('/').'/deals/details/'.base64_encode($max_dis_deals['id'])}}">{{ $max_dis_deals['name'] }}</a></div>
                          <div class="online-spend"></div>
                                  <div class="price-box">
                                  <div class="price-new">£<?php echo round($max_dis_deals['price']-(($max_dis_deals['price'])*($max_dis_deals['discount_price']/100)));?></div>
                                      <div class="price-old">£{{ $max_dis_deals['price'] }} <!--| <span>offers 50% OFF</span>--></div>
                                      <div class="view"><a href="{{url('/').'/deals/details/'.base64_encode($max_dis_deals['id'])}}" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                  </div>
                          </div>
                          </div>
                          </div>

                      @endforeach
                      @else
                          <span class="col-sm-3 col-md-3 col-lg-12">No Deals  Available.</span>
                      @endif
                  </div>

                 </div>
                    <div class="row" id="deal_by_location">

                       @if(sizeof($arr_deals_loc_info)>0)
                          @foreach($arr_deals_loc_info as $loc_deals)

                          <div class="col-sm-6 col-md-3 col-lg-3">
                          <div class="dels">
                          <div class="deals-img"><span class="discount ribbon">{{$loc_deals['discount_price'] }}%</span><img src="{{ url('/')}}/uploads/deal/{{$loc_deals['deal_image']}}" alt="img" width="250" height="200" /></div>
                          <div class="deals-product">
                          <div class="deals-nm"><a href="{{url('/').'/deals/details/'.base64_encode($loc_deals['id'])}}">{{ $loc_deals['name'] }}</a></div>
                          <div class="online-spend"></div>
                                  <div class="price-box">
                                  <div class="price-new">£<?php echo round($loc_deals['price']-(($loc_deals['price'])*($loc_deals['discount_price']/100)));?></div>
                                      <div class="price-old">£{{ $loc_deals['price'] }} <!--| <span>offers 50% OFF</span>--></div>
                                      <div class="view"><a href="{{url('/').'/deals/details/'.base64_encode($loc_deals['id'])}}" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                  </div>
                          </div>
                          </div>
                          </div>

                      @endforeach
                      @else
                          <span class="col-sm-3 col-md-3 col-lg-12">No Deals  Available.</span>
                      @endif
                    </div>
                  </div>
                  </div>
                  <br />
               </div>
             </div>
         </div>
       </div>
      </div>

  <!-- Modal -->
    <div class="modal fade" id="loc_deal" role="dialog">
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
               else if(Session::has('city')) {
                echo Session::get('city');
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






         <!-- jQuery -->
      <script src="{{ url('/')}}/assets/front/js/jquery.js" type="text/javascript"></script>
      <!-- Bootstrap Core JavaScript -->
      <!--<script src="{{ url('/')}}/assets/front/js/bootstrap.min.js" type="text/javascript"></script>-->

      <script type="text/javascript">
         $(document).ready(function () {
             $('#dash_tab').easyResponsiveTabs({
                 type: 'default', //Types: default, vertical, accordion
                 width: 'auto', //auto or any width like 600px
                 fit: true,   // 100% fit in a container
                 closed: 'accordion', // Start closed if in accordion view
                 activate: function(event) { // Callback function if tab is switched
                     var $tab = $(this);
                     var $info = $('#tabInfo');
                     var $name = $('span', $info);

                     $name.text($tab.text());

                     $info.show();
                 }
             });

             $('#verticalTab').easyResponsiveTabs({
                 type: 'vertical',
                 width: 'auto',
                 fit: true
             });
         });

      </script>
       <script type="text/javascript">
var supports = (function () {
    var a = document.documentElement,
        b = "ontouchstart" in window || navigator.msMaxTouchPoints;
    if (b) {
        a.className += " touch";
        return {
            touch: true
        }
    } else {
        a.className += " no-touch";
        return {
            touch: false
        }
    }
})();


if ($("html").hasClass("no-touch")) {


  $('.dropdown > a').removeAttr("data-toggle");


    (function (e, t, n) {
        if ("ontouchstart" in document) return;
        var r = e();
        e.fn.dropdownHover = function (n) {
            r = r.add(this.parent());
            return this.each(function () {
                var i = e(this),
                    s = i.parent(),
                    o = {
                        delay: 0,
                        instantlyCloseOthers: !0
                    }, u = {
                        delay: e(this).data("delay"),
                        instantlyCloseOthers: e(this).data("close-others")
                    }, a = e.extend(!0, {}, o, n, u),
                    f;
                s.hover(function (n) {
                    if (!s.hasClass("open") && !i.is(n.target)) return !0;
                    a.instantlyCloseOthers === !0 && r.removeClass("open");
                    t.clearTimeout(f);
                    s.addClass("open");
                    s.trigger(e.Event("show.bs.dropdown"))
                }, function () {
                    f = t.setTimeout(function () {
                        s.removeClass("open");
                        s.trigger("hide.bs.dropdown")
                    }, 1)
                });
                i.hover(function () {
                    a.instantlyCloseOthers === !0 && r.removeClass("open");
                    t.clearTimeout(f);
                    s.addClass("open");
                    s.trigger(e.Event("show.bs.dropdown"))
                });
                s.find(".dropdown-submenu").each(function () {
                    var n = e(this),
                        r;
                    n.hover(function () {
                        t.clearTimeout(r);
                        n.children(".dropdown-menu").show();
                        n.siblings().children(".dropdown-menu").hide()
                    }, function () {
                        var e = n.children(".dropdown-menu");
                        r = t.setTimeout(function () {
                            e.hide()
                        }, a.delay)
                    })
                })
            })
        };
        e(document).ready(function () {

            e('[data-hover="dropdown"]').dropdownHover()
        })
    })(jQuery, this);

 } //END IF no-touch for hover script & removeAttr for the links to work
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
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

                  }
                });
      $("#go_to_search").click(function(){
        //$('#loc_deal').modal('hide');
         var business_search_by_location=$('#business_search_by_location').val();
         var search_under_city=$('#business_search_by_city').val();
         var loc_lat=$('#location_latitude').val();
         var loc_lng=$('#location_longitude').val();
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
                            search_under_city:search_under_city,
                            business_search_by_location:business_search_by_location,
                            _token:csrf_token
                            };
                          $.ajax({
                             url: site_url+"/deals/fetch_location_deal",
                             type: 'POST',
                             data: fromData,


                             success: function(responseresult)
                             {

                                $('#deal_by_location').html('<div class="row">'+responseresult+'</div>');


                               //$('.container').html('<h2>trst</h2>');

                             }
                         });

             }
          }

           $('#loc_deal').modal('hide');
      });



      });
      </script>


      @endsection
