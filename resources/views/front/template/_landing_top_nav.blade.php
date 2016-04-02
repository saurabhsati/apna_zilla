 <div class="header">
         <div class="container">
            <div class="row">
                    <div class="col-lg-12">
              <div class="logo-block">
                  <a href="{{ url('/') }}" class="logo hidden-xs"><img src="{{ url('/') }}/assets/front/images/logo_header.png" alt="logo" /></a>
                    <a href="{{ url('/') }}" class="hidden-sm hidden-md hidden-lg logo"><img src="{{ url('/') }}/assets/front/images/logo_mobile.png" alt="logo" /></a>

               </div>
               <!--main-menu-start-here-->
               <div class="menublock">
                  <!--Menu Start-->
                  <div class="main-menu">
                     <div class="nav">
                        <ul class="nav-list">
                         <?php
                          $city='';
                          if(Session::has('city')){
                          $city=Session::get('city');
                          }else{
                          $city='Mumbai';
                          }?>
                          <!--  <li class="nav-item"><a href="{{ url('/') }}" class=" {{ Request::segment(1)==''? 'act':'' }}">Home</a></li> -->
                           <li class="nav-item"><a href="{{ url('/') }}/{{$city}}/all-categories">Categories</a></li>
                           <!-- <li class="nav-item">
                              <a href="{{ url('/') }}/listing" class=" {{ Request::segment(1)=='listing'? 'act':'' }}">Listing</a>
                                 <ul class="nav-submenu">
                                 <li class="nav-submenu-item"><a href="#">Sub menu</a></li>
                                 <li class="nav-submenu-item"><a href="#">Sub menu</a></li>
                                 </ul>
                           </li>-->
                           <li class="nav-item"><a href="{{ url('/deals') }}">Deals</a></li>

                            {{-- @if ($user = Sentinel::check()) --}}
                            @if(Session::has('user_name'))

                            <li class="nav-item">

                            <div class="dropdown">
                                <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Hi {{ucfirst(Session::get('user_name'))}}  <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                   <li><a href="{{ url('/').'/front_users/profile' }}">My Account</a></li>
                                  <!--  <li><a href="#">My Favorites</a></li>
                                   <li><a href="#">Friend's Ratings </a></li> -->
                                   <li><a href="{{ url('/').'/front_users/my_business' }}" >My Business </a></li>
                                   <li><a href="{{ url('/').'/front_users/add_business' }}" >Add Business </a></li>
                                   <li><a href="{{ url('/').'/front_users/logout' }}" onclick="social_logout(this)" >social_logout(this)" >Logout</a></li>
                                </ul>
                             </div>



                            </li>
                            
                        @else

                        <li class="nav-item"><a data-toggle="modal" data-target="#login_poup">Login/Register</a></li>

                        @endif

                        </ul>
                        <!-- <a class="btn btn-post" href="javascript:void(0);" id="list_your_business">List your Bussiness</a> -->
                      <?php
                       if(empty(session::get('user_mail')))
                        {
                           echo '<a data-toggle="modal" id="open_register" data-target="#reg_poup" class="btn btn-post" onclick="set_flag()" >List your Business </a>';
                        }
                        else{
                           echo '<a class="btn btn-post" href="'.url('/').'/front_users/add_business" id="list_your_business" >List your Business</a>';
                        }
                      ?>
                      </div>
                     <div class="clearfix"></div>
                  </div>
                  <!--Menu Start-->
               </div>
               <div class="clearfix"></div>
            </div>
             </div>
            <div class="clearfix"></div>
         </div>
         <div class="clearfix"></div>
      </div>
      <!--headar end-->

@if(!Auth::check())
<script type="text/javascript" language="javascript" src="{{ url('/') }}/js/front/fb_auth.js"></script>
@endif