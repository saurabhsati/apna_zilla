<div id="sidebar" class="navbar-collapse collapse">
    <!-- BEGIN Navlist -->
    <ul class="nav nav-list">


        <li class="{{ Request::segment(2)=='dashboard'? 'active':'' }}">
            <a href="{{ url('/web_admin/dashboard')}}">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ Request::segment(2)=='users'? 'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-user"></i>
                <span>Users</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/users')}}">Manage</a> </li>
            </ul>
        </li>

         <li class="{{ Request::segment(2)=='categories'? 'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-bars"></i>
                <span>Categories</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/categories')}}">Manage</a> </li>
            </ul>
        </li>
<li class="{{ Request::segment(2)=='static_pages'? 'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-files-o"></i>
                <span>CMS</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/static_pages')}}">Manage</a> </li>
            </ul>
        </li>
<li class="<?php  if(Request::segment(2) == 'countries' || Request::segment(2) == 'states' || Request::segment(2) == 'cities' || Request::segment(2) == 'zipcode' ){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-globe"></i>
                            <span>Locations</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li class="<?php  if(Request::segment(2) == 'countries'){ echo 'active'; } ?>" style="display: block;"><a href="{{ url('/web_admin/countries')}}">Manage Country</a></li>
                            <li class="<?php  if(Request::segment(2) == 'states'){ echo 'active'; } ?>"><a href="{{ url('/web_admin/states')}}">Manage States</a></li>
                            <li class="<?php  if(Request::segment(2) == 'cities'){ echo 'active'; } ?>"><a href="{{ url('/web_admin/cities')}}">Manage Cities</a></li>
                            <li class="<?php  if(Request::segment(2) == 'zipcode'){ echo 'active'; } ?>"><a href="{{ url('/web_admin/zipcode')}}">Manage ZipCode</a></li>
                        </ul>
                    </li>

        <li class="{{ Request::segment(2)=='restaurants'?'active':'' }}
                   {{ Request::segment(2)=='dishes'?'active':'' }}
                   {{ Request::segment(2)=='deals'?'active':'' }}
                   {{ Request::segment(2)=='restaurantReviews'?'active':'' }}
                   {{ Request::segment(2)=='dealsReviews'?'active':'' }}">



        <li class="{{ Request::segment(2)=='transactions'?'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-credit-card"></i>
                <span>Payments</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/transactions')}}">Manage</a> </li>
            </ul>
        </li>

         <li class="{{ Request::segment(2)=='newsletter'?'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-credit-card"></i>
                <span>News-Letter</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/newsletter')}}">Manage</a> </li>
            </ul>
        </li>


       <li class="{{ Request::segment(2)=='siteSettings'?'active':'' }}
                   {{ Request::segment(2)=='edit_profile'?'active':'' }}
                   ">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-wrench"></i>
                <span>Accounts &amp; Setting</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
            <li style="display: block;" class="{{ Request::segment(2)=='edit_profile'?'active':'' }}"><a href="{{ url('/web_admin/edit_profile')}}">Profile </a> </li>
                <li style="display: block;" class="{{ Request::segment(2)=='siteSettings'?'active':'' }}"><a href="{{ url('/web_admin/site_settings')}}">Manage Website Setting</a> </li>
                <!-- <li style="display: block;"><a href="#">Manage Payment Setting</a> </li> -->
            </ul>

        </li>
        <li class="{{ Request::segment(2)=='front_slider'?'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-youtube-play"></i>
                <span>Front slider</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/web_admin/front_slider')}}">Manage</a> </li>
            </ul>
        </li>
        <li class="{{ Request::segment(2)=='reviews'? 'active':'' }}">
                <a href="javascript:void(0)"  class="dropdown-toggle">
                    <i class="fa fa-star"></i>
                    <span>Reviews</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                 <ul class="submenu">
                    <li style="display: block;"><a href="{{ url('/web_admin/reviews/MjU=')}}">Manage</a> </li>
                </ul>
            </li>
            <li class="{{ Request::segment(2)=='faq'? 'active':'' }}">
                <a href="javascript:void(0)"  class="dropdown-toggle">
                    <i class="fa fa-question-circle"></i>
                    <span>FAQ</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                 <ul class="submenu">
                    <li style="display: block;"><a href="{{ url('/web_admin/faq')}}">Manage</a> </li>
                </ul>
            </li>
        <li class="<?php  if(Request::segment(2) == 'email_template'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-envelope"></i>
                            <span>Email Template</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url('/web_admin/email_template')}}">Manage</a> </li>
                        </ul>
         </li>
         <li class="{{ Request::segment(2)=='contact_enquiry'?'active':'' }}">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <i class="fa fa-phone"></i>
                        <span>Contact Enquiry</span>
                        <b class="arrow fa fa-angle-right"></b>
                    </a>
                    <ul class="submenu">
                        <li style="display: block;"><a href="{{ url('/web_admin/contact_enquiry')}}">Manage</a> </li>
                    </ul>
                </li>
         </ul>
    <!-- END Navlist -->
    <!-- BEGIN Sidebar Collapse Button -->
    <div id="sidebar-collapse" class="visible-lg">
        <i class="fa fa-angle-double-left"></i>
    </div>
    <!-- END Sidebar Collapse Button -->
</div>

