<style type="text/css">
 .categ li .active{
    color: #f9a820 !important;
  }
</style>
<div class="gry_container" style="padding: 7px 0 16px;">
<div class="black-strip">
   <div class="container">
        <div class="row">
       <div class="col-lg-12">
            <div class="categ">
           <ul class="hidden-sm hidden-xs">
          <li><a href="{{ url('/deals') }}">All Deals</a></li>
          @if(isset($deal_category) && sizeof($deal_category)>0)
            @foreach($deal_category as $key => $category)
                 <li><a class="<?php if($category['cat_slug']==Request::segment(2)){echo'active';}?>" href="{{ url('/deals') }}/{{$category['cat_slug']}}">{{ ucfirst($category['title'])}}</a></li>
                   @endforeach
                          @endif

                <!--  <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">More <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
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
                      </li> -->
                </ul>

              <ul class="hidden-md hidden-lg">

              <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">All Deals <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="w3_megamenu-content withdesc">
                           <ul>
                  <li><a class="active" href="#">Restaurant</a></li>
                <li><a href="#">Beauty/Spa</a></li>
                <li><a href="#">Wellness</a></li>
                <li><a href="#">Travel</a></li>
                <li><a href="#">Health care</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Shopping</a></li>
                <li><a href="#">Leisure Offers</a></li>
                <li><a href="#">Tickets</a></li>
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