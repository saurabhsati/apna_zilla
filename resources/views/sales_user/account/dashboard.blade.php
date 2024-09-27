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
                        <div class="col-md-12 ">
                             <div class="tile tile-pink">
                                <div class="img">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="content">
                                    <p class="big">{{ $vender_count }}</p>
                                    <p class="title"> Venders</p>
                                </div>
                            </div>
                           

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 ">
                             <div class="tile tile-blue">
                                <div class="img">
                                    <i class="fa fa-list"></i>
                                </div>
                                <div class="content">
                                    <p class="big">{{ $business_listing_count }}</p>
                                    <p class="title"> Business Listings</p>
                                </div>
                            </div>
                           

                        </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 ">
                             <div class="tile tile-green">
                                <div class="img">
                                    <i class="fa fa-bars"></i>
                                </div>
                                <div class="content">
                                    <p class="big">{{ $deals_count}}</p>
                                    <p class="title"> Deals</p>
                                </div>
                            </div>
                           

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 ">
                             <div class="tile tile-orange">
                                <div class="img">
                                    <i class="fa fa-bars"></i>
                                </div>
                                <div class="content">
                                    <p class="big">{{ $membership_transaction_count}}</p>
                                    <p class="title"> Membership Transactions </p>
                                </div>
                            </div>
                           

                        </div>
                    </div>
                </div>
                
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
                                        <div class="tile tile-orange">
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
     
         

 <div class="row">
     <div class="col-md-12">
         <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                 <div class="box-content" id="reg_chart"></div>  
                            </div>
                        </div>
                         <script type="text/javascript">
                            FusionCharts.ready(function () {
                            var revenueChart = new FusionCharts({
                                "type": "column3d",
                                "renderAt": "reg_chart",
                                "width": "650",
                                "height": "330",
                                "dataFormat": "json",
                                "dataSource": {
                                   "chart": {
                                      "caption": "Venders",
                                      "xAxisName": "Month",
                                      "yAxisName": "No of Venders",
                                      "theme": "fint"
                                   },
                                   "data": [
                                        <?php
                                            $i=0;
                                            if(sizeof($users_array)>0)
                                            foreach($users_array as $row)
                                            {   
                                                $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

                                                
                                                $month_name = $mons[$row['month']];
                                                $month_label = '';
                                                $month_label=$month_name;
                                                $i++;   
                                        ?>
                                                {
                                                   "label": "<?php echo $month_label;?>",
                                                   "value": "<?php echo $row['user_count'];?>"
                                                },
                                        <?php }
                                            if($i<count($users_array))
                                                echo",";
                                       ?>
                                    ]
                                }

                            });
                            revenueChart.render();
                        });
                        </script>
                       <div class="col-md-6">
                        <div class="row">
                            <div class="box-content" id="business_chart">
                              </div>
                        </div>
                      </div>
                    <script type="text/javascript">
                        FusionCharts.ready(function () {
                        var revenueChart = new FusionCharts({
                            "type": "column3d",
                            "renderAt": "business_chart",
                            "width": "650",
                            "height": "330",
                            "dataFormat": "json",
                            "dataSource": {
                               "chart": {
                                  "caption": " Business Listing ",
                                  "xAxisName": "Month",
                                  "yAxisName": "Monthly Business Register",
                                  "theme": "fint"
                               },
                               "data": [
                                    <?php
                                        $i=0;
                                        if(sizeof($businesses_array)>0)
                                        foreach($businesses_array as $row)
                                        { 
                                            $i++;   

                                            $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

                                            
                                            $month_name = $mons[$row['month']];
                                            $month_label = '';
                                            $month_label=$month_name;
                                           // $month_label = date('M', strtotime('11-2016'/*$row['month']*/));
                                    ?>
                                            {
                                               "label": "<?php echo $month_label;?>",
                                               "value": "<?php echo $row['business_count'];?>"
                                            },
                                    <?php }
                                        if($i<count($businesses_array))
                                            echo",";
                                   ?>
                                ]
                            }

                        });
                        revenueChart.render();
                    });
                    </script>
         </div>
    </div>
</div>

<hr>
<div class="row">
     <div class="col-md-12">
         <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                 <div class="box-content" id="deal_chart"></div>  
                            </div>
                        </div>
                         <script type="text/javascript">
                            FusionCharts.ready(function () {
                            var revenueChart = new FusionCharts({
                                "type": "column3d",
                                "renderAt": "deal_chart",
                                "width": "650",
                                "height": "330",
                                "dataFormat": "json",
                                "dataSource": {
                                   "chart": {
                                      "caption": "Deals ",
                                      "xAxisName": "Month",
                                      "yAxisName": "No of Deals",
                                      "theme": "fint"
                                   },
                                   "data": [
                                        <?php
                                            $i=0;
                                            if(sizeof($deals_array)>0)
                                            foreach($deals_array as $row)
                                            {   
                                                $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

                                                
                                                $month_name = $mons[$row['month']];
                                                $month_label = '';
                                                $month_label=$month_name;
                                                $i++;   
                                        ?>
                                                {
                                                   "label": "<?php echo $month_label;?>",
                                                   "value": "<?php echo $row['deal_count'];?>"
                                                },
                                        <?php }
                                            if($i<count($deals_array))
                                                echo",";
                                       ?>
                                    ]
                                }

                            });
                            revenueChart.render();
                        });
                        </script>
                       
         </div>
    </div>
</div>

@stop