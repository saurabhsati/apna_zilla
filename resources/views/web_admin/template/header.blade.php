
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ isset($page_title)?$page_title:"" }} - {{ config('app.project.name') }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!--base css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-fileupload/bootstrap-fileupload.css" />

        <!--flaty css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty-responsive.css">


        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-switch/static/stylesheets/bootstrap-switch.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/admin/select2.min.css" />

       <!-- Auto load email address -->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/chosen-bootstrap/chosen.min.css" />

        <!--basic scripts-->


        <script>window.jQuery || document.write('<script src="{{ url('/') }}/assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>




        <script src="{{ url('/') }}/js/admin/select2.min.js"></script>

        <script src="{{ url('/') }}/js/admin/tinymce/js/tinymce/tinymce.min.js"></script>

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/jquery-tags-input/jquery.tagsinput.css" />

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/dropzone/downloads/css/dropzone.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-colorpicker/css/colorpicker.css" />

        <!-- Timepicker css -->
            <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-timepicker/compiled/timepicker.css" />
            <!-- <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/clockface/css/clockface.css" /> -->
        <!-- End -->
        <!-- Datepicker css -->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-datepicker/css/datepicker.css" />
        <!-- Auto Complete css -->
           <link rel="stylesheet" href="{{ url('/') }}/assets/front/css/jquery-ui.css" type="text/css"/>
           <script src="{{ url('/') }}/assets/front/js/jquery-ui.js" type='text/javascript'></script>
           <!-- Multi select  -->
           <script src="{{ url('/') }}/assets/front/js/bootstrap-multiselect.js" type='text/javascript'></script>
          <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/front/css/bootstrap-multiselect.css" />
    </head>
    <body>

        <!-- BEGIN Theme Setting -->
        <div id="theme-setting">
            <a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
            <ul>
                <li>
                    <span>Skin</span>
                    <ul class="colors" data-target="body" data-prefix="skin-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Navbar</span>
                    <ul class="colors" data-target="#navbar" data-prefix="navbar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Sidebar</span>
                    <ul class="colors" data-target="#main-container" data-prefix="sidebar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span></span>
                    <a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Fixed Navbar</a>
                    <a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Fixed Sidebar</a>
                </li>
            </ul>
        </div>
        <!-- END Theme Setting -->

        <!-- BEGIN Navbar -->
        <div id="navbar" class="navbar">
            <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="fa fa-bars"></span>
            </button>
            <a class="navbar-brand" href="#">
                <small>
                    <i class="fa fa-desktop"></i>
                    {{ config('app.project.name') }} Admin
                </small>
            </a>

            <!-- BEGIN Navbar Buttons -->
            <ul class="nav flaty-nav pull-right">
                <!-- BEGIN Button Tasks -->
                {{-- <li class="hidden-xs">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="badge badge-warning">4</span>
                    </a>

                    <!-- BEGIN Tasks Dropdown -->
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header">
                            <i class="fa fa-check"></i>
                            4 Tasks to complete
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Software Update</span>
                                    <span class="pull-right">75%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:75%" class="progress-bar progress-bar-warning"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Transfer To New Server</span>
                                    <span class="pull-right">45%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:45%" class="progress-bar progress-bar-danger"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Bug Fixes</span>
                                    <span class="pull-right">20%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:20%" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Writing Documentation</span>
                                    <span class="pull-right">85%</span>
                                </div>

                                <div class="progress progress-mini progress-striped active">
                                    <div style="width:85%" class="progress-bar progress-bar-success"></div>
                                </div>
                            </a>
                        </li>

                        <li class="more">
                            <a href="#">See tasks with details</a>
                        </li>
                    </ul>
                    <!-- END Tasks Dropdown -->
                </li> --}}
                <!-- END Button Tasks -->

                <!-- BEGIN Button Notifications -->
                {{-- <li class="hidden-xs">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-important">5</span>
                    </a>

                    <!-- BEGIN Notifications Dropdown -->
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header">
                            <i class="fa fa-warning"></i>
                            5 Notifications
                        </li>

                        <li class="notify">
                            <a href="#">
                                <i class="fa fa-comment orange"></i>
                                <p>New Comments</p>
                                <span class="badge badge-warning">4</span>
                            </a>
                        </li>

                        <li class="notify">
                            <a href="#">
                                <i class="fa fa-twitter blue"></i>
                                <p>New Twitter followers</p>
                                <span class="badge badge-info">7</span>
                            </a>
                        </li>

                        <li class="notify">
                            <a href="#">
                                <img src="{{ url('/') }}/img/demo/avatar/avatar2.jpg" alt="Alex" />
                                <p>David would like to become moderator.</p>
                            </a>
                        </li>

                        <li class="notify">
                            <a href="#">
                                <i class="fa fa-bug pink"></i>
                                <p>New bug in program!</p>
                            </a>
                        </li>

                        <li class="notify">
                            <a href="#">
                                <i class="fa fa-shopping-cart green"></i>
                                <p>You have some new orders</p>
                                <span class="badge badge-success">+10</span>
                            </a>
                        </li>

                        <li class="more">
                            <a href="#">See all notifications</a>
                        </li>
                    </ul>
                    <!-- END Notifications Dropdown -->
                </li> --}}
                <!-- END Button Notifications -->

                <!-- BEGIN Button Messages -->
                {{-- <li class="hidden-xs">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-success">3</span>
                    </a>

                    <!-- BEGIN Messages Dropdown -->
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header">
                            <i class="fa fa-comments"></i>
                            3 Messages
                        </li>

                        <li class="msg">
                            <a href="#">
                                <img src="{{ url('/') }}/img/demo/avatar/avatar3.jpg" alt="Sarah's Avatar" />
                                <div>
                                    <span class="msg-title">Sarah</span>
                                    <span class="msg-time">
                                        <i class="fa fa-clock-o"></i>
                                        <span>a moment ago</span>
                                    </span>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </a>
                        </li>

                        <li class="msg">
                            <a href="#">
                                <img src="{{ url('/') }}/img/demo/avatar/avatar4.jpg" alt="Emma's Avatar" />
                                <div>
                                    <span class="msg-title">Emma</span>
                                    <span class="msg-time">
                                        <i class="fa fa-clock-o"></i>
                                        <span>2 Days ago</span>
                                    </span>
                                </div>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ...</p>
                            </a>
                        </li>

                        <li class="msg">
                            <a href="#">
                                <img src="{{ url('/') }}/img/demo/avatar/avatar5.jpg" alt="John's Avatar" />
                                <div>
                                    <span class="msg-title">John</span>
                                    <span class="msg-time">
                                        <i class="fa fa-clock-o"></i>
                                        <span>8:24 PM</span>
                                    </span>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in ...</p>
                            </a>
                        </li>

                        <li class="more">
                            <a href="#">See all messages</a>
                        </li>
                    </ul>
                    <!-- END Notifications Dropdown -->
                </li> --}}
                <!-- END Button Messages -->

                <!-- BEGIN Button User -->
                <li class="user-profile">
                    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">

                        <span class="hhh" id="user_info">
                            Admin
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <!-- BEGIN User Dropdown -->
                    <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                        <!-- <li class="nav-header">
                            <i class="fa fa-clock-o"></i>
                            Logined From 20:45
                        </li> -->

                       <!--  <li>
                            <a href="">
                                <i class="fa fa-cog"></i>
                                Account Settings
                            </a>
                        </li> -->

                       <!--  <li>
                            <a href="{{ url('/web_admin/site_setting')}}">
                                <i class="fa fa-user"></i>
                                Edit Profile
                            </a>
                        </li>-->
                        <li>
                            <a href="{{ url('/web_admin/edit_profile')}}">
                                <i class="fa fa-cog"></i>
                                Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/web_admin/change_password') }}">
                                <i class="fa fa-cog"></i>
                                Change Password
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/web_admin/site_settings')}}">
                                <i class="fa fa-wrench"></i>
                                Website Settings
                            </a>
                        </li>

                        <li class="divider visible-xs"></li>

                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-tasks"></i>
                                Tasks
                                <span class="badge badge-warning">4</span>
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-bell"></i>
                                Notifications
                                <span class="badge badge-important">8</span>
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                Messages
                                <span class="badge badge-success">5</span>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ url('/web_admin/logout') }}">
                                <i class="fa fa-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                    <!-- BEGIN User Dropdown -->
                </li>
                <!-- END Button User -->
            </ul>
            <!-- END Navbar Buttons -->
        </div>
        <!-- END Navbar -->

        <!-- BEGIN Container -->
        <div class="container" id="main-container">