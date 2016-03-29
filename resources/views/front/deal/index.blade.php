@extends('front.template.master')

@section('main_section')

<!--search area end here-->
 <div class="gry_container" style="padding: 7px 0 16px;">
      <div class="black-strip">
     <div class="container">
          <div class="row">
         <div class="col-lg-12">
              <div class="categ">
             <ul class="hidden-sm hidden-xs">
                  <li><a href="#">All Deals</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Restaurant</a></li>
                  <li><a href="#">Beauty</a></li>
                 <li><a href="#">Tickets</a></li>
                 <li><a href="#">Beauty</a></li>
                <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">More <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                                 <li><a href="#"> Eyelash Extensions</a></li>
                                  <li><a href="#"> Facial</a></li>
                                  <li><a href="#"> Makeup Application</a></li>
                                  <li><a href="#"> Tinting</a></li>
                                </ul>
                          </li>
                        </ul>
                        </li>
                  </ul>

                <ul class="hidden-md hidden-lg">

                <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">All Deals <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                                  <li><a href="#">All Deals</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Restaurant</a></li>
                  <li><a href="#">Beauty</a></li>
                 <li><a href="#">Tickets</a></li>
                 <li><a href="#">Beauty</a></li>
                                 <li><a href="#"> Eyelash Extensions</a></li>
                                  <li><a href="#"> Facial</a></li>
                                  <li><a href="#"> Makeup Application</a></li>
                                  <li><a href="#"> Tinting</a></li>
                                </ul>
                          </li>
                        </ul>
                        </li>
                  </ul>
             </div>
              </div>

         </div>

          </div>
     </div>

       <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

                  <div class="delas">
                  <div id="dash_tab">
                     <ul class="resp-tabs-list">
                        <li>Latest Deals</li>
                         <img class="dash_line" alt="line" src="{{ url('/')}}/assets/front/images/dash_menu_line.jpg">
                        <li>Maximum Discount</li>
                         <img class="dash_line" alt="line" src="{{ url('/')}}/assets/front/images/dash_menu_line.jpg">
                        <li>Location</li>

                        <div class="clearfix"></div>
                     </ul>
                     <div class="resp-tabs-container">
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
                              <div class="deals-nm"><a href="#">{{ $deals['name'] }}</a></div>
                              <div class="online-spend"></div>
                                      <div class="price-box">
                                      <div class="price-new">£<?php echo round($deals['price']-(($deals['price'])*($deals['discount_price']/100)));?></div>
                                          <div class="price-old">£{{ $deals['price'] }} <!--| <span>offers 50% OFF</span>--></div>
                                          <div class="view"><a href="#" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                      </div>
                              </div>
                              </div>
                              </div>

                          @endforeach
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
                          <div class="deals-nm"><a href="#">{{ $max_dis_deals['name'] }}</a></div>
                          <div class="online-spend"></div>
                                  <div class="price-box">
                                  <div class="price-new">£<?php echo round($max_dis_deals['price']-(($max_dis_deals['price'])*($max_dis_deals['discount_price']/100)));?></div>
                                      <div class="price-old">£{{ $max_dis_deals['price'] }} <!--| <span>offers 50% OFF</span>--></div>
                                      <div class="view"><a href="#" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a></div>
                                  </div>
                          </div>
                          </div>
                          </div>

                      @endforeach
                      @endif
                  </div>

                 </div>
                    <div>
                  &nbsp;
                    </div>
                  </div>
                  </div>
                  <br />
               </div>
             </div>
         </div>
       </div>
      </div>


         <!-- jQuery -->
      <script src="{{ url('/')}}/assets/front/js/jquery.js" type="text/javascript"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="{{ url('/')}}/assets/front/js/bootstrap.min.js" type="text/javascript"></script>
      <script type="text/javascript">
         $('.tag.example .ui.dropdown')
         .dropdown({
         allowAdditions: true
         });
         
      </script>
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
        <script src="{{ url('/')}}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
        <link href="{{ url('/')}}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />

@endsection