    @extends('web_admin.template.admin')


    @section('main_content')
    <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-credit-card"></i> Payment</h1>
                        <h4>Transaction Deatils</h4>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="{{ url('web_admin/dashboard') }}">Dashboard</a>
                            <span class="divider"><i class="fa fa-angle-right"></i></span>
                            <i class="fa fa-credit-card"></i>
                            <a href="{{ url('web_admin/transactions') }}"> Payment Transaction</a>
                            <span class="divider"><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li class="active">Invoice</li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Main Content -->
                <div class="row">
                    <div class="col-md-12">
                       @if(isset($arr_single_transaction) && sizeof($arr_single_transaction)>0)



                        <div class="box">
                            <div class="box-content">
                                <div class="invoice">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>
                                            {{isset($arr_single_transaction['user_records']) && $arr_single_transaction['user_records']? $arr_single_transaction['user_records']['first_name']:'' }}

                                            {{isset($arr_single_transaction['user_records']) && $arr_single_transaction['user_records']? $arr_single_transaction['user_records']['last_name']:'' }}
                                            </h2>
                                        </div>
                                        <div class="col-md-6 invoice-info">
                                            <p class="font-size-17">
                                            <strong>Date</strong> -
                                            {{ date('d M Y',strtotime($arr_single_transaction['created_at'])) }}</p>
                                        </div>
                                    </div>

                                    <hr class="margin-0" />

                                    <div class="row">
                                        <div class="col-lg-12 company-info">
                                            <h4><b><u>Transaction Id</u></b> - {{ $arr_single_transaction['transaction_id'] }}</h4>

                                            <br/>
                                            <p><i class="fa fa-envelope"></i>
                                                {{ isset($arr_single_transaction['user_records']) && $arr_single_transaction['user_records']?
                                                $arr_single_transaction['user_records']['email']:'' }}
                                            </p>
                                            <p><i class="fa fa-phone"></i>
                                              {{ isset($arr_single_transaction['user_records']) && $arr_single_transaction['user_records']?
                                                $arr_single_transaction['user_records']['mobile_no']:'' }}
                                             </p>


                                        </div>

                                    </div>

                                    <br/><br/>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Transaction Id</th>
                                                    <th>Membership Plan</th>
                                                     <th>Business Name</th>
                                                    <th>Category Name</th>
                                                     <th>Transaction Status</th>
                                                     <th>Deal Count</th>
                                                    <th>Price</th>
                                                    <th>Start Date</th>
                                                    <th>Expire Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="center">1</td>
                                                    <td>
                                                        {{ $arr_single_transaction['transaction_id'] }}
                                                    </td>
                                                    <td>
                                                        {{ isset($arr_single_transaction['membership']) && $arr_single_transaction['membership']?
                                                        $arr_single_transaction['membership']['title']:'' }}
                                                    </td>
                                                    <td>
                                                    {{ isset($arr_single_transaction['business']) && $arr_single_transaction['business']? $arr_single_transaction['business']['business_name']:'' }}
                                                </td>
                                                 <td>
                                                    {{ isset($arr_single_transaction['category']) && $arr_single_transaction['category']? $arr_single_transaction['category']['title']:'' }}
                                                </td>

                                                <td>
                                                    
                                                        {{ $arr_single_transaction['transaction_status'] }}
                                                </td>

                                                <td>{{$arr_single_transaction['membership']['no_normal_deals']}}
                                                </td>

                                                    <td>Rs.
                                                    {{ $arr_single_transaction['price'] }}/- </td>
                                                    <td>
                                                     {{ date('d-m-Y',strtotime($arr_single_transaction['start_date'])) }}
                                                    </td>
                                                    <td>
                                                     {{ date('d-m-Y',strtotime($arr_single_transaction['expire_date'])) }}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    @else
                        <h4>No Record Found!</h4>
                    @endif
                 </div>
                 </div>
                <!-- END Main Content -->


@stop