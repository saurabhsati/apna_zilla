@extends('sales_user.template.sales')


@section('main_content')
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-file-o"></i> Dashboard</h1>
                        <h4>Overview, stats, chat and more</h4>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="fa fa-home"></i> Home</li>

                    </ul>
                </div>
                <!-- END Breadcrumb -->


                <!-- BEGIN Tiles -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/sales_user/dashboard')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-home"></i>
                                            </div>
                                            <p class="title text-center">Dashboard</p>
                                        </div></a>
                                        <div class="tile tile-green  ">
                                            <p class="title">Dashboard</p>
                                            <p>See Your Dashboard</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-home"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                             <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/sales_user/users')}}">
                                        <div class="tile tile-blue">
                                            <div class="img img-center">
                                                 <i class="fa fa-users"></i>
                                            </div>
                                            <p class="title text-center">Venders</p>
                                        </div></a>
                                        <div class="tile tile-light-magenta ">
                                            <p class="title">Venders </p>
                                            <p>See Your Venders</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                             <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/sales_user/business_listing')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-list"></i>
                                            </div>
                                            <p class="title text-center">Business Listing</p>
                                        </div></a>
                                        <div class="tile tile-blue  ">
                                            <p class="title">Business Listings</p>
                                            <p>See Your Business Listing </p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-list"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                             <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/sales_user/transactions')}}">
                                        <div class="tile tile-blue">
                                            <div class="img img-center">
                                                 <i class="fa fa-credit-card"></i>
                                            </div>
                                            <p class="title text-center">Payments</p>
                                        </div></a>
                                        <div class="tile tile-green ">
                                            <p class="title">Payments</p>
                                            <p>See Your Payments</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>

                        </div>
                 </div>
            </div>
            <div id="pop_div"></div>
     
        <?php echo $lava->render('AreaChart', 'Population', 'pop_div'); ?>
            <!-- BEGIN Main Content -->
                <!-- <div class="row">
                    <div class="col-md-7">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="fa fa-bar-chart-o"></i> Visitors Chart</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <div id="visitors-chart" style="margin-top:20px; position:relative; height: 290px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="fa fa-bar-chart-o"></i> Users And Projects Statistics</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>

                            <div class="box-content">
                                <ul class="weekly-stats">

                                    <li>
                                        <span class="inline-sparkline">134,178,264,196,307,259,287</span>
                                        Total Registered Users: <span class="value">
                                                                {{ isset($dashboard_satistics['total_users'])?$dashboard_satistics['total_users']:''}}
                                                                </span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">89,124,197,138,235,169,186</span>
                                        Total Registered Companies: <span class="value">{{ isset($dashboard_satistics['number_of_companies'])?$dashboard_satistics['number_of_companies']:''}}</span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">625,517,586,638,669,698,763</span>
                                        Total Registered Catalysts: <span class="value">{{ isset($dashboard_satistics['number_of_catalysts'])?$dashboard_satistics['number_of_catalysts']:''}}</span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">1.34,2.98,0.76,1.29,1.86,1.68,1.92</span>
                                        Total Number Of Posted Projects: <span class="value">{{ isset($dashboard_satistics['posted_projects'])?$dashboard_satistics['posted_projects']:''}}</span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">2.34,2.67,1.47,1.97,2.25,2.47,1.27</span>
                                        Total Number Of Ongoing Projects: <span class="value">{{ isset($dashboard_satistics['ongoing_projetcs'])?$dashboard_satistics['ongoing_projetcs']:''}}</span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">70.34,67.41,59.45,65.43,78.42,75.92,74.29</span>
                                        Total Number Of Completed Projects: <span class="value">{{ isset($dashboard_satistics['completed_projects'])?$dashboard_satistics['completed_projects']:''}}</span>
                                    </li>

                                     <li>
                                        <span class="inline-sparkline">70.34,67.41,59.45,65.43,78.42,75.92,74.29</span>
                                        Total Number Of Countries: <span class="value">0</span>
                                    </li>
                                    <li>
                                        <span class="inline-sparkline">78.12,74.52,81.25,89.23,86.15,91.82,85.18</span>
                                        % New Visits: <span class="value">82.65%</span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
 -->


@stop