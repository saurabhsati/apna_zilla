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

      
       <li class="{{ Request::segment(2)=='siteSettings'?'active':'' }}">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="fa fa-wrench"></i>
                <span>Acocunts &amp; Setting</span>
                <b class="arrow fa fa-angle-right"></b>
            </a> 
            <ul class="submenu">
                <li style="display: block;" class="{{ Request::segment(2)=='siteSettings'?'active':'' }}"><a href="{{ url('/web_admin/site_settings')}}">Manage Website Setting</a> </li> 
                <!-- <li style="display: block;"><a href="#">Manage Payment Setting</a> </li> -->
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

