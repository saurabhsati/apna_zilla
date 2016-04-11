<div id="sidebar" class="navbar-collapse collapse">
    <!-- BEGIN Navlist -->
    <ul class="nav nav-list">


        <li class="{{ Request::segment(2)=='dashboard'? 'active':'' }}">
            <a href="{{ url('/sales_user/dashboard')}}">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>


        <li class="{{ Request::segment(2)=='edit_profile'? 'active':'' }}">
            <a href="{{ url('/sales_user/edit_profile')}}" class="dropdown-toggle">
                <i class="fa fa-user"></i>
                <span>My Profile</span>
               <!--  <b class="arrow fa fa-angle-right"></b> -->
            </a>

        </li>
        <li class="{{ Request::segment(2)=='users'? 'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-user"></i>
                <span>Normal Users</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/sales_user/users')}}">Manage</a> </li>
            </ul>
        </li>

        <li class="{{ Request::segment(2)=='business_listing'? 'active':'' }}
                    {{ Request::segment(2)=='reviews'? 'active':'' }}
                     {{ Request::segment(2)=='deals'? 'active':'' }}
        ">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-list"></i>
                <span>Business Listing</span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            <ul class="submenu">
                <li style="display: block;"><a href="{{ url('/sales_user/business_listing')}}">Manage</a> </li>
            </ul>
        </li>



   <!-- BEGIN Sidebar Collapse Button -->
    <div id="sidebar-collapse" class="visible-lg">
        <i class="fa fa-angle-double-left"></i>
    </div>
    <!-- END Sidebar Collapse Button -->
</div>
