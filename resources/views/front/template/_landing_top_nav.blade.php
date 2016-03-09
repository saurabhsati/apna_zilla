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
                           <li class="nav-item"><a href="{{ url('/') }}" class=" {{ Request::segment(1)==''? 'act':'' }}">Home</a></li>
                           <li class="nav-item"><a href="#">Categories</a></li>
                           <li class="nav-item">
                              <a href="{{ url('/') }}/listing" class=" {{ Request::segment(1)=='listing'? 'act':'' }}">Listing</a>
                              <!--
                                 <ul class="nav-submenu">
                                 <li class="nav-submenu-item"><a href="#">Sub menu</a></li>
                                 <li class="nav-submenu-item"><a href="#">Sub menu</a></li>
                                 </ul>
                                 -->
                           </li>
                           <li class="nav-item"><a href="#">Features</a></li>
                           <li class="nav-item"><a data-toggle="modal" data-target="#login_poup">Login/Register</a></li>
                        </ul>
                        <a class="btn btn-post" href="#">List your Bussiness</a>
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