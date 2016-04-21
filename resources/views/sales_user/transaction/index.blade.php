@extends('sales_user.template.sales')


    @section('main_content')

    <link rel="stylesheet" type="text/css" href="{{ url('/assets/data-tables/latest/') }}/dataTables.bootstrap.min.css">
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>

        </div>
    </div>
    <!-- END Page Title -->

    <!-- BEGIN Breadcrumb -->
     <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/sales_user/dashboard') }}">Dashboard</a>
            </li>

            <span class="divider">
               <i class="fa fa-angle-right"></i>

            </span>
            <li>

            <i class="fa fa-credit-card"></i>
               <a href="{{ url('/sales_user/transactions/') }}">Payment Transaction</a>
            </li>

            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active">{{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
    <!-- END Breadcrumb -->





    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-credit-card"></i>

                {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
            </div>
        </div>
        <div class="box-content">

          @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
          @endif

          @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
            </div>
          @endif
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/sales_user/restaurantReviews/multi_action') }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">
            <!--- Add new record - - - -->
               <div class="btn-group">

                </div>
            <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - -->

            <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                     title="Refresh"
                     href="{{ url('/sales_user/transactions/') }}"
                     style="text-decoration:none;">
                     <i class="fa fa-repeat"></i>
                  </a>
            </div>
          </div>
          <br/><br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="user_manage" >
              <thead>
                <tr>
                  <th> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th>Sr. No.</th>
                 <!--  <th>Transaction Id</th> -->
                  <th>Transaction Status</th>
                  <th>User Name</th>
                  <th>User Email</th>
                  <th>Membership</th>
                  <th>Business Name</th>
                  <th>Category Name</th>
                  <th>Price</th>
                  <th>Start Date</th>
                  <th>Expire Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @if(sizeof($arr_transaction)>0)
              @foreach($arr_transaction as $key => $transaction)

                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($transaction['id']) }}" />
                    </td>
                    <td>{{ $key+1 }}</td>
                  <!--   <td>
                        {{ $transaction['transaction_id'] }}
                    </td> -->
                    <td>
                        {{ $transaction['transaction_status'] }}
                    </td>
                    <td>
                        {{ isset($transaction['user_records']) && $transaction['user_records']? ucfirst($transaction['user_records']['first_name']):'' }}

                        {{ isset($transaction['user_records']) && $transaction['user_records']? ucfirst($transaction['user_records']['last_name']):'' }}
                    </td>
                    <td> {{ isset($transaction['user_records']) && $transaction['user_records']? ucfirst($transaction['user_records']['email']):'' }}</td>
                    <td>
                        {{ isset($transaction['membership']) && $transaction['membership']? $transaction['membership']['title']:'' }}
                    </td>
                     <td>
                        {{ isset($transaction['business']) && $transaction['business']? $transaction['business']['business_name']:'' }}
                    </td>
                     <td>
                        {{ isset($transaction['category']) && $transaction['category']? $transaction['category']['title']:'' }}
                    </td>
                    <td>Rs.{{ $transaction['price'] }} /- </td>

                    <td>
                        {{ date('d M Y',strtotime($transaction['start_date'])) }}
                    </td>
                    <td>
                        {{ date('d M Y',strtotime($transaction['expire_date'])) }}
                    </td>

                    <td>

                        <a href="{{ url('/sales_user/transactions/view/'.base64_encode($transaction['id'])) }}" class="show-tooltip" title="View">
                          <i class="fa fa-eye" ></i>
                        </a>
                         &nbsp;
                        <a href="{{ url('/sales_user/transactions/edit/'.base64_encode($transaction['id'])) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>

                    </td>
                  </tr>

                @endforeach
                @endif

              </tbody>
            </table>
          </div>

          </form>
      </div>
  </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">

   $(document).ready(function()
    {
        $("#user_manage").DataTable();
    });

</script>

@stop


