@extends('web_admin.template.admin')


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
                             <div class="tile tile-orange">
                                <div class="img">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="content">
                                    <p class="big">{{ $sales_executive_count }}</p>
                                    <p class="title"> Sales Executives</p>
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
                             <div class="tile tile-magenta">
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
                 

                    <div class="col-md-12">
                        <div class="row">

                             <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/dashboard')}}">
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
                                        <a href="{{ url('/web_admin/users')}}">
                                        <div class="tile tile-blue">
                                            <div class="img img-center">
                                                 <i class="fa fa-users"></i>
                                            </div>
                                            <p class="title text-center">Venders</p>
                                        </div></a>
                                        <div class="tile tile-light-magenta ">
                                            <p class="title">Venders</p>
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
                                        <a href="{{ url('/web_admin/sales_user')}}">
                                        <div class="tile tile-green">
                                            <div class="img img-center">
                                                 <i class="fa fa-users"></i>
                                            </div>
                                            <p class="title text-center">Sales Executives</p>
                                        </div></a>
                                        <div class="tile tile-blue  ">
                                            <p class="title">Sales Executives</p>
                                            <p>See Your Sales Executives</p>
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
                                        <a href="{{ url('/web_admin/business_listing')}}">
                                        <div class="tile tile-pink">
                                            <div class="img img-center">
                                                 <i class="fa fa-list"></i>
                                            </div>
                                            <p class="title text-center">Business Listing</p>
                                        </div></a>
                                        <div class="tile tile-green  ">
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
                                        <a href="{{ url('/web_admin/deals_offers')}}">
                                        <div class="tile tile-pink">
                                            <div class="img img-center">
                                                 <i class="fa fa-list"></i>
                                            </div>
                                            <p class="title text-center">Deals Listing</p>
                                        </div></a>
                                        <div class="tile tile-blue">
                                            <p class="title">Deals Listings</p>
                                            <p>See Your Deals Listing </p>
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
                                        <a href="{{ url('/web_admin/deals_offers_transactions')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-euro"></i>
                                            </div>
                                            <p class="title text-center">Deals & Offers Payment</p>
                                        </div></a>
                                        <div class="tile tile-pink ">
                                            <p class="title">Deals & Offers Payment</p>
                                            <p>See Your Deals & Offers Payment</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-euro"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                              <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/deals_bulk_request')}}">
                                        <div class="tile tile-blue">
                                            <div class="img img-center">
                                                 <i class="fa fa-list"></i>
                                            </div>
                                            <p class="title text-center">Bulk Request</p>
                                        </div></a>
                                        <div class="tile tile-magenta">
                                            <p class="title">Bulk Request</p>
                                            <p>See Your Bulk Requestg </p>
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
                                        <a href="{{ url('/web_admin/categories')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-bars"></i>
                                            </div>
                                            <p class="title text-center">Business Categories</p>
                                        </div></a>
                                        <div class="tile tile-pink">
                                            <p class="title">Business Categories</p>
                                            <p>See Your Business Categories </p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-bars"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                               <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/static_pages')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-files-o"></i>
                                            </div>
                                            <p class="title text-center">CMS</p>
                                        </div></a>
                                        <div class="tile tile-magenta  ">
                                            <p class="title">CMS</p>
                                            <p>See Your CMS </p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-files-o"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                                 <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/newsletter')}}">
                                        <div class="tile tile-pink">
                                            <div class="img img-center">
                                                 <i class="fa fa-users"></i>
                                            </div>
                                            <p class="title text-center">News-Letter Subscribers</p>
                                        </div></a>
                                        <div class="tile tile-green ">
                                            <p class="title">News-Letter Subscribers</p>
                                            <p>See Your News-Letter Subscribers </p>
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
                                        <a href="{{ url('/web_admin/faq')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-question-circle"></i>
                                            </div>
                                            <p class="title text-center">FAQs</p>
                                        </div></a>
                                        <div class="tile tile-blue">
                                            <p class="title">FAQs</p>
                                            <p>See Your FAQs </p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-question-circle"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                               <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/membership')}}">
                                        <div class="tile tile-pink">
                                            <div class="img img-center">
                                                 <i class="fa fa-euro"></i>
                                            </div>
                                            <p class="title text-center">Membership Plans</p>
                                        </div></a>
                                        <div class="tile tile-magenta ">
                                            <p class="title">Membership Plans</p>
                                            <p>See Your Membership Plan </p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-euro"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                                <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/membershipcost')}}">
                                        <div class="tile tile-pink">
                                            <div class="img img-center">
                                                 <i class="fa fa-euro"></i>
                                            </div>
                                            <p class="title text-center">Membership Plan Costs</p>
                                        </div></a>
                                        <div class="tile tile-green ">
                                            <p class="title">Membership Plan Costs</p>
                                            <p>See Your Membership Plan Costs</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-euro"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                              <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/transactions')}}">
                                        <div class="tile tile-blue">
                                            <div class="img img-center">
                                                 <i class="fa fa-credit-card"></i>
                                            </div>
                                            <p class="title text-center">Payments</p>
                                        </div></a>
                                        <div class="tile tile-pink ">
                                            <p class="title">Payments</p>
                                            <p>See Your Payments</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>
                               <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/email_template')}}">
                                        <div class="tile tile-green">
                                            <div class="img img-center">
                                                 <i class="fa fa-envelope"></i>
                                            </div>
                                            <p class="title text-center">Email Templates</p>
                                        </div></a>
                                        <div class="tile tile-magenta ">
                                            <p class="title">Email Templates</p>
                                            <p>See Your Email Templates</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>

                              <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12 tile-active">
                                        <a href="{{ url('/web_admin/contact_enquiry')}}">
                                        <div class="tile tile-magenta">
                                            <div class="img img-center">
                                                 <i class="fa fa-phone"></i>
                                            </div>
                                            <p class="title text-center">Contact Enquiry</p>
                                        </div></a>
                                        <div class="tile tile-green">
                                            <p class="title">Contact Enquiry</p>
                                            <p>See Your Contact Enquiry</p>
                                            <div class="img img-bottom">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </div>

                          

                        </div>
                    </div>
                  </div>

                      <div class="row">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="box-title">
                                <h3><i class="fa fa-bar-chart-o"></i>Activity Reports For Sales Executive </h3>
                                <div class="box-tool"> <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a> <a data-action="close" href="#"><i class="fa fa-times"></i></a> </div>
                              </div>
                              <div class="box-content" >
                              <table class="class_table_activity">
                              <tr>
                               <td><label class="control-label">From Date:</label></td>
                               <td><input class="form-control" type="text" id="from_date" class="span1" name="from_date"></td>&nbsp&nbsp&nbsp
                               <td><label class="control-label">To Date:</label></td>
                               <td><input class="form-control" type="text" id="to_date" class="span1" name="to_date"></td>&nbsp&nbsp&nbsp
                               <td><label class="control-label">Select Sales Executive:</label></td>
                               <td>
                               <select class="form-control" name="sales_user_public_id" id="sales_user_public_id">
                                     <option>Select Sales Executive</option>
                                     @if(isset($all_sales_executive) && sizeof($all_sales_executive)>0)
                                          @foreach($all_sales_executive as $sales_executive)
                                              <option value="{{$sales_executive['public_id']}}">{{ $sales_executive['public_id']}}</option>
                                          @endforeach
                                      @endif
                               </select>
                              </td>&nbsp&nbsp&nbsp
                               <td><input type="button" class="btn btn-primary" id="btn_view" name="btn_view" value="Filter" onclick="javascript:return view_sales_activity()"></td>
                               <td><input type="button" class="btn btn-primary" id="btn_reset" name="btn_reset" value="Reset" onclick="javascript:return clear_sales_activity()"></td>
                               <div id="view_sales_executive_activity_chart">
                               </div>
                              <tr>
                                </table>
                                <div id="response_result">
                                </div>
                              </div>
                            </div>
                          </div>
          </div>


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
                                      "yAxisName": "No of Venders Register",
                                      "theme": "fint"
                                   },
                                   "data": [
                                        <?php
                                            $i=0;
                                            if(sizeof($users_array)>0)
                                            foreach($users_array as $row)
                                            {   
                                                $mons = [1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"];

                                                
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
                            <div class="box-content" id="sales_executive_chart">
                              </div>
                        </div>
                      </div>
                    <script type="text/javascript">
                        FusionCharts.ready(function () {
                        var revenueChart = new FusionCharts({
                            "type": "column3d",
                            "renderAt": "sales_executive_chart",
                            "width": "650",
                            "height": "330",
                            "dataFormat": "json",
                            "dataSource": {
                               "chart": {
                                  "caption": " Sales Executives ",
                                  "xAxisName": "Month",
                                  "yAxisName": "Monthly Sales Executives Register",
                                  "theme": "fint"
                               },
                               "data": [
                                    <?php
                                        $i=0;
                                        if(sizeof($sales_executive_array)>0)
                                        foreach($sales_executive_array as $row)
                                        { 
                                            $i++;   

                                            $mons = [1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"];

                                            
                                            $month_name = $mons[$row['month']];
                                            $month_label = '';
                                            $month_label=$month_name;
                                           // $month_label = date('M', strtotime('11-2016'/*$row['month']*/));
                                    ?>
                                            {
                                               "label": "<?php echo $month_label;?>",
                                               "value": "<?php echo $row['executive_count'];?>"
                                            },
                                    <?php }
                                        if($i<count($sales_executive_array))
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

                                            $mons = [1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"];

                                            
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
                                                $mons = [1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"];

                                                
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
                  <div id="pop_div"></div>
                  <?php //echo $lava->render('LineChart', 'Temps', 'pop_div'); ?>
 <script type="text/javascript">
 $(function(){
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    $('#from_date').datepicker({
      onRender: function(date) {
        //return date.valueOf() < now.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) 
    {
      $('#from_date').datepicker('hide');
    }).data('datepicker');

    $('#to_date').datepicker({
      onRender: function(date) {
        //return date.valueOf() < now.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) 
    {
      $('#to_date').datepicker('hide');
    }).data('datepicker');
});
 </script>                 
<script type="text/javascript">
 var site_url="{{url('/')}}";
 var csrf_token = "{{ csrf_token() }}";
function view_sales_activity(url)
{   
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var sales_user_public_id = $('#sales_user_public_id').val();
   
    if(from_date!="" && to_date!="")
    {
     var fromData = {
                            from_date:from_date,
                            to_date:to_date,
                            sales_user_public_id:sales_user_public_id,
                            _token:csrf_token
                              };

                     $.ajax({
                             url:site_url+'/web_admin/view_sales_activity',
                             type: 'POST',
                             data: fromData,
                            /* dataType: 'json',*/
                             async: false,

                             success: function(response)
                             {
                                $("#response_result").html(response);
                             }
                         });
    }
}
function clear_sales_activity()
{   
     var current_url= window.location.href;
      var url_parts = current_url.split("#")
      var final_url = url_parts[0];
      window.location.href=final_url;
    
}
</script>                 
            
              

@stop